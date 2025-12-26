<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/email.php';
require_once '../models/EventRegistration.php';

requireLogin();

$database = new Database();
$db = $database->connect();
$eventModel = new EventRegistration($db);

// Handle actions
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'update_status' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = sanitize($_POST['status']);
        $notes = sanitize($_POST['admin_notes']);
        
        if ($eventModel->updateStatus($id, $status, $notes)) {
            // Send event pass email on approval
            if ($status === 'approved') {
                $registration = $eventModel->getById($id);
                if ($registration) {
                    sendEventPass($registration);
                }
            }
            showAlert('Status updated successfully!', 'success');
        } else {
            showAlert('Error updating status.', 'danger');
        }
        redirect('admin/event-registrations');
    } elseif ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        if ($eventModel->delete($_GET['id'])) {
            showAlert('Registration deleted successfully!', 'success');
        } else {
            showAlert('Error deleting registration.', 'danger');
        }
        redirect('admin/event-registrations');
    }
}

$registrations = $eventModel->getAll();
$stats = $eventModel->getStats();
$alert = getAlert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registrations - <?php echo SITE_NAME; ?></title>
    
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/NEDMUN.webp">
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
                <h1><i class="fas fa-calendar-check me-2"></i>حرف راز Social Event</h1>
                <a href="<?php echo BASE_URL; ?>event-registration" class="btn btn-primary" target="_blank">
                    <i class="fas fa-external-link-alt me-2"></i>View Registration Form
                </a>
            </div>

            <!-- Quick Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h3 class="text-primary"><?php echo $stats['total']; ?></h3>
                            <p class="mb-0 text-muted">Total Registrations</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h3 class="text-warning"><?php echo $stats['pending']; ?></h3>
                            <p class="mb-0 text-muted">Pending</p>
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

            <!-- Registrations Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="registrationsTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>CNIC</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registrations as $registration): ?>
                                <tr>
                                    <td><?php echo $registration['id']; ?></td>
                                    <td><?php echo htmlspecialchars($registration['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($registration['cnic_number']); ?></td>
                                    <td><?php echo htmlspecialchars($registration['email']); ?></td>
                                    <td><?php echo htmlspecialchars($registration['phone_number']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $registration['status'] === 'approved' ? 'success' : ($registration['status'] === 'rejected' ? 'danger' : 'warning'); ?>">
                                            <?php echo ucfirst($registration['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($registration['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="viewDetails(<?php echo $registration['id']; ?>)" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="viewPayment(<?php echo $registration['id']; ?>)" title="View Payment">
                                            <i class="fas fa-receipt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" 
                                                onclick="editStatus(<?php echo $registration['id']; ?>)" 
                                                data-status="<?php echo $registration['status']; ?>" 
                                                data-admin-notes="<?php echo htmlspecialchars($registration['admin_notes'] ?? '', ENT_QUOTES); ?>" 
                                                title="Edit Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteRegistration(<?php echo $registration['id']; ?>)" title="Delete">
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
                    <h5 class="modal-title">Registration Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="registrationDetails"></div>
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
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="editStatus" required>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes</label>
                            <textarea class="form-control" name="admin_notes" id="editAdminNotes" rows="3"></textarea>
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

    <!-- Payment Screenshot Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Screenshot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" id="paymentContent"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationsTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 25
            });
        });

        function viewDetails(id) {
            fetch('<?php echo BASE_URL; ?>admin/ajax/get-event-registration.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    let html = `
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Full Name:</strong><br>${data.full_name}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>CNIC:</strong><br>${data.cnic_number}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong><br>${data.email}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Phone:</strong><br>${data.phone_number}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Status:</strong><br>
                                <span class="badge bg-${data.status === 'approved' ? 'success' : (data.status === 'rejected' ? 'danger' : 'warning')}">${data.status.toUpperCase()}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Admin Notes:</strong><br>${data.admin_notes || 'No notes'}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Registration Date:</strong><br>${new Date(data.created_at).toLocaleString()}
                            </div>
                        </div>
                    `;
                    document.getElementById('registrationDetails').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('viewModal')).show();
                });
        }

        function viewPayment(id) {
            fetch('<?php echo BASE_URL; ?>admin/ajax/get-event-registration.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    const imageUrl = '<?php echo BASE_URL; ?>' + data.payment_screenshot;
                    document.getElementById('paymentContent').innerHTML = `
                        <img src="${imageUrl}" alt="Payment Screenshot" class="img-fluid" style="max-height: 70vh; cursor: zoom-in;" onclick="window.open('${imageUrl}', '_blank')">
                        <div class="mt-3 text-muted">
                            <small>Click on image to view full size</small>
                        </div>
                    `;
                    new bootstrap.Modal(document.getElementById('paymentModal')).show();
                });
        }

        function editStatus(id, button) {
            if (!button) {
                button = event.target.closest('button');
            }
            
            document.getElementById('editForm').action = '<?php echo BASE_URL; ?>admin/event-registrations?action=update_status&id=' + id;
            
            const currentStatus = button.getAttribute('data-status');
            const currentNotes = button.getAttribute('data-admin-notes');
            
            document.getElementById('editStatus').value = currentStatus;
            document.getElementById('editAdminNotes').value = currentNotes || '';
            
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function deleteRegistration(id) {
            if (confirm('Are you sure you want to delete this registration?')) {
                window.location.href = '<?php echo BASE_URL; ?>admin/event-registrations?action=delete&id=' + id;
            }
        }
    </script>
</body>
</html>
