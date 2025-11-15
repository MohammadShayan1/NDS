<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../models/BrandAmbassador.php';

requireLogin();

$database = new Database();
$db = $database->connect();
$baModel = new BrandAmbassador($db);

// Handle actions
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'update_status' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = sanitize($_POST['status']);
        $notes = sanitize($_POST['admin_notes']);
        
        if ($baModel->updateStatus($id, $status, $notes)) {
            showAlert('Status updated successfully!', 'success');
        } else {
            showAlert('Error updating status.', 'danger');
        }
        redirect('admin/brand-ambassadors');
    } elseif ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        if ($baModel->delete($_GET['id'])) {
            showAlert('Application deleted successfully!', 'success');
        } else {
            showAlert('Error deleting application.', 'danger');
        }
        redirect('admin/brand-ambassadors');
    }
}

$ambassadors = $baModel->getAll();
$stats = $baModel->getStats();
$alert = getAlert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Brand Ambassadors - <?php echo SITE_NAME; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp">
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include 'includes/header.php'; ?>

        <div class="container-fluid py-4">
            <?php if ($alert): ?>
            <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $alert['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-star me-2"></i>Brand Ambassador Applications</h1>
                <button class="btn btn-success" onclick="exportToCSV()">
                    <i class="fas fa-download me-2"></i>Export to CSV
                </button>
            </div>

            <!-- Quick Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h3 class="text-primary"><?php echo $stats['total']; ?></h3>
                            <p class="mb-0 text-muted">Total Applications</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h3 class="text-warning"><?php echo $stats['pending']; ?></h3>
                            <p class="mb-0 text-muted">Pending Review</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success"><?php echo $stats['approved']; ?></h3>
                            <p class="mb-0 text-muted">Approved</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h3 class="text-danger"><?php echo $stats['rejected']; ?></h3>
                            <p class="mb-0 text-muted">Rejected</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand Ambassadors Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ambassadorsTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>WhatsApp</th>
                                    <th>Institution</th>
                                    <th>Education</th>
                                    <th>Delegates</th>
                                    <th>PR Drive</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ambassadors as $ba): ?>
                                <tr>
                                    <td><?php echo $ba['id']; ?></td>
                                    <td><?php echo htmlspecialchars($ba['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($ba['email']); ?></td>
                                    <td><?php echo htmlspecialchars($ba['whatsapp_number']); ?></td>
                                    <td><?php echo htmlspecialchars($ba['institution']); ?></td>
                                    <td><?php echo htmlspecialchars($ba['education_level']); ?></td>
                                    <td><?php echo htmlspecialchars($ba['delegates_count']); ?></td>
                                    <td><span class="badge bg-<?php echo $ba['pr_drive'] === 'Yes' ? 'success' : 'secondary'; ?>"><?php echo $ba['pr_drive']; ?></span></td>
                                    <td><span class="badge bg-<?php echo $ba['status'] === 'approved' ? 'success' : ($ba['status'] === 'rejected' ? 'danger' : 'warning'); ?>"><?php echo ucfirst($ba['status']); ?></span></td>
                                    <td><?php echo date('M d, Y', strtotime($ba['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="viewDetails(<?php echo $ba['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editStatus(<?php echo $ba['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBA(<?php echo $ba['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Brand Ambassador Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="baDetails"></div>
            </div>
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="editForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Application Status</label>
                            <select class="form-select" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes</label>
                            <textarea class="form-control" name="admin_notes" rows="3" placeholder="Add notes about your decision..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ambassadorsTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 25
            });
        });

        function viewDetails(id) {
            fetch('<?php echo BASE_URL; ?>admin/ajax/get-ba.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    let html = `
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Full Name:</strong><br>${data.full_name}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong><br>${data.email}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>WhatsApp:</strong><br>${data.whatsapp_number}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>CNIC:</strong><br>${data.cnic_number}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Institution:</strong><br>${data.institution}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Education Level:</strong><br>${data.education_level}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Expected Delegates:</strong><br>${data.delegates_count}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>PR Drive:</strong><br>${data.pr_drive}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Prior Experience:</strong><br>${data.prior_experience}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Admin Notes:</strong><br>${data.admin_notes || 'No notes'}
                            </div>
                        </div>
                    `;
                    document.getElementById('baDetails').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('viewModal')).show();
                });
        }

        function editStatus(id) {
            document.getElementById('editForm').action = '<?php echo BASE_URL; ?>admin/brand-ambassadors?action=update_status&id=' + id;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function deleteBA(id) {
            if (confirm('Are you sure you want to delete this application?')) {
                window.location.href = '<?php echo BASE_URL; ?>admin/brand-ambassadors?action=delete&id=' + id;
            }
        }

        function exportToCSV() {
            window.location.href = '<?php echo BASE_URL; ?>admin/ajax/export-ba.php';
        }
    </script>
</body>
</html>
