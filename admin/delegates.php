<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../models/DelegateRegistration.php';

requireLogin();

$database = new Database();
$db = $database->connect();
$delegateModel = new DelegateRegistration($db);

// Handle actions
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'update_status' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = sanitize($_POST['status']);
        $payment_status = sanitize($_POST['payment_status']);
        $notes = sanitize($_POST['admin_notes']);
        
        if ($delegateModel->updateStatus($id, $status, $payment_status, $notes)) {
            showAlert('Status updated successfully!', 'success');
        } else {
            showAlert('Error updating status.', 'danger');
        }
        redirect('admin/delegates');
    } elseif ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        if ($delegateModel->delete($_GET['id'])) {
            showAlert('Registration deleted successfully!', 'success');
        } else {
            showAlert('Error deleting registration.', 'danger');
        }
        redirect('admin/delegates');
    }
}

$delegates = $delegateModel->getAll();
$stats = $delegateModel->getStats();
$alert = getAlert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Delegates - <?php echo SITE_NAME; ?></title>
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
                <h1><i class="fas fa-users me-2"></i>Delegate Registrations</h1>
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
                            <p class="mb-0 text-muted">Total Registrations</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success"><?php echo $stats['confirmed']; ?></h3>
                            <p class="mb-0 text-muted">Confirmed</p>
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
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h3 class="text-info"><?php echo $stats['paid']; ?></h3>
                            <p class="mb-0 text-muted">Paid</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delegates Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="delegatesTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Institution</th>
                                    <th>Type</th>
                                    <th>Participant</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($delegates as $delegate): ?>
                                <tr>
                                    <td><?php echo $delegate['id']; ?></td>
                                    <td><?php echo htmlspecialchars($delegate['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($delegate['email']); ?></td>
                                    <td><?php echo htmlspecialchars($delegate['phone_number']); ?></td>
                                    <td><?php echo htmlspecialchars($delegate['institution_name']); ?></td>
                                    <td><span class="badge bg-<?php echo $delegate['registration_type'] === 'NED' ? 'primary' : 'secondary'; ?>"><?php echo $delegate['registration_type']; ?></span></td>
                                    <td><span class="badge bg-info"><?php echo ucfirst($delegate['participant_type']); ?></span></td>
                                    <td><span class="badge bg-<?php echo $delegate['status'] === 'confirmed' ? 'success' : ($delegate['status'] === 'rejected' ? 'danger' : 'warning'); ?>"><?php echo ucfirst($delegate['status']); ?></span></td>
                                    <td><span class="badge bg-<?php echo $delegate['payment_status'] === 'paid' ? 'success' : ($delegate['payment_status'] === 'waived' ? 'info' : 'warning'); ?>"><?php echo ucfirst($delegate['payment_status']); ?></span></td>
                                    <td><?php echo date('M d, Y', strtotime($delegate['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="viewDetails(<?php echo $delegate['id']; ?>)" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if (!empty($delegate['payment_screenshot'])): ?>
                                        <button class="btn btn-sm btn-success" onclick="viewPayment(<?php echo $delegate['id']; ?>)" title="View Payment Screenshot">
                                            <i class="fas fa-receipt"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if ($delegate['participant_type'] === 'delegation'): ?>
                                        <button class="btn btn-sm btn-info" onclick="viewMembers(<?php echo $delegate['id']; ?>)" title="View Members">
                                            <i class="fas fa-users"></i>
                                        </button>
                                        <?php endif; ?>
                                        <button class="btn btn-sm btn-success" onclick="assignCommittee(<?php echo $delegate['id']; ?>, 'main')" title="Assign Committee">
                                            <i class="fas fa-clipboard-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editStatus(<?php echo $delegate['id']; ?>)" title="Edit Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteDelegate(<?php echo $delegate['id']; ?>)" title="Delete">
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
                    <h5 class="modal-title">Delegate Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="delegateDetails"></div>
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
                            <label class="form-label">Registration Status</label>
                            <select class="form-select" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="rejected">Rejected</option>
                                <option value="waitlist">Waitlist</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="payment_status" required>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="waived">Waived</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes</label>
                            <textarea class="form-control" name="admin_notes" rows="3"></textarea>
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

    <!-- View Delegation Members Modal -->
    <div class="modal fade" id="membersModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delegation Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="membersContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Committee Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Committee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Delegate Name</label>
                        <input type="text" class="form-control" id="assignDelegateName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preferred Committee</label>
                        <input type="text" class="form-control" id="assignPreferredCommittee" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign to Committee <span class="text-danger">*</span></label>
                        <select class="form-select" id="assignedCommittee" required>
                            <option value="">-- Select Committee --</option>
                            <option value="UNSC">United Nations Security Council (UNSC)</option>
                            <option value="UNCSTD">United Nations Commission on Science and Technology for Development (UNCSTD)</option>
                            <option value="UNWOMEN">UN Women</option>
                            <option value="DISEC">Disarmament and International Security Committee (DISEC)</option>
                            <option value="SPECPOL">Special Political and Decolonization Committee (SPECPOL)</option>
                            <option value="SOCHUM">Social, Humanitarian and Cultural Committee (SOCHUM)</option>
                            <option value="KCC">Karachi City Council (KCC)</option>
                            <option value="PNA">Pakistan National Assembly (PNA)</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        An acceptance email will be sent to the delegate with their assigned committee.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="confirmAssignment()">
                        <i class="fas fa-paper-plane me-2"></i>Assign & Send Email
                    </button>
                </div>
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
                <div class="modal-body text-center" id="paymentContent">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="downloadPayment" href="#" download class="btn btn-primary" style="display: none;">
                        <i class="fas fa-download me-2"></i>Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#delegatesTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 25
            });
        });

        let currentAssignId = null;
        let currentAssignType = null;

        function viewDetails(id) {
            fetch('<?php echo BASE_URL; ?>admin/ajax/get-delegate.php?id=' + id)
                .then(response => response.json())
                .then(response => {
                    const data = response.success ? response.delegate : response;
                    let html = `
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Full Name:</strong><br>${data.full_name}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong><br>${data.email}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Phone:</strong><br>${data.phone_number}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>WhatsApp:</strong><br>${data.whatsapp_number}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Institution:</strong><br>${data.institution_name}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Education Level:</strong><br>${data.education_level}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Committee Preferences:</strong><br>
                                1. ${data.committee_preference_1 || 'N/A'}<br>
                                2. ${data.committee_preference_2 || 'N/A'}<br>
                                3. ${data.committee_preference_3 || 'N/A'}
                            </div>
                            ${data.assigned_committee ? `
                            <div class="col-md-12 mb-3">
                                <strong>Assigned Committee:</strong><br>
                                <span class="badge bg-success fs-6">${data.assigned_committee}</span>
                            </div>
                            ` : ''}
                            <div class="col-md-12 mb-3">
                                <strong>MUN Experience:</strong><br>${data.mun_experience || 'N/A'}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Admin Notes:</strong><br>${data.admin_notes || 'No notes'}
                            </div>
                        </div>
                    `;
                    document.getElementById('delegateDetails').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('viewModal')).show();
                });
        }

        function viewMembers(id) {
            const modal = new bootstrap.Modal(document.getElementById('membersModal'));
            modal.show();
            
            fetch('<?php echo BASE_URL; ?>admin/ajax/get-delegate-details.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        document.getElementById('membersContent').innerHTML = `
                            <div class="alert alert-danger">${data.message}</div>
                        `;
                        return;
                    }
                    
                    let html = `
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-user-tie me-2"></i>Head Delegate</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"><strong>Name:</strong> ${data.delegate.full_name}</div>
                                    <div class="col-md-4"><strong>Email:</strong> ${data.delegate.email}</div>
                                    <div class="col-md-4"><strong>Phone:</strong> ${data.delegate.phone_number}</div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Preferred:</strong> ${data.delegate.committee_preference_1 || 'N/A'}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Assigned:</strong> 
                                        ${data.delegate.assigned_committee ? 
                                            `<span class="badge bg-success">${data.delegate.assigned_committee}</span>` : 
                                            `<button class="btn btn-sm btn-success" onclick="assignCommittee(${data.delegate.id}, 'main')">
                                                <i class="fas fa-clipboard-check me-1"></i>Assign Committee
                                            </button>`
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    if (data.members && data.members.length > 0) {
                        html += `
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Delegation Members (${data.members.length})</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>CNIC</th>
                                                    <th>Preferred Committee</th>
                                                    <th>Assigned Committee</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                        `;
                        
                        data.members.forEach((member, index) => {
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${member.member_name}</td>
                                    <td>${member.member_email}</td>
                                    <td>${member.member_phone}</td>
                                    <td>${member.member_cnic}</td>
                                    <td>
                                        ${member.member_committee_preference || 'N/A'}
                                        ${member.member_experience ? `<br><small class="text-muted"><i class="fas fa-star me-1"></i>${member.member_experience}</small>` : ''}
                                    </td>
                                    <td>${member.assigned_committee ? 
                                        `<span class="badge bg-success">${member.assigned_committee}</span>` : 
                                        '<span class="badge bg-warning">Not Assigned</span>'
                                    }</td>
                                    <td><span class="badge bg-${member.status === 'confirmed' ? 'success' : 'warning'}">${member.status || 'pending'}</span></td>
                                    <td>
                                        ${!member.assigned_committee ? 
                                            `<button class="btn btn-sm btn-success" onclick="assignCommittee(${member.id}, 'member')">
                                                <i class="fas fa-clipboard-check"></i> Assign
                                            </button>` : 
                                            `<button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-check"></i> Assigned
                                            </button>`
                                        }
                                    </td>
                                </tr>
                            `;
                        });
                        
                        html += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        html += `
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>No delegation members found.
                            </div>
                        `;
                    }
                    
                    document.getElementById('membersContent').innerHTML = html;
                });
        }

        function assignCommittee(id, type) {
            currentAssignId = id;
            currentAssignType = type;
            
            const endpoint = type === 'main' ? 
                '<?php echo BASE_URL; ?>admin/ajax/get-delegate.php?id=' + id :
                '<?php echo BASE_URL; ?>admin/ajax/get-member.php?id=' + id;
            
            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    if (type === 'main') {
                        const delegate = data.success ? data.delegate : data;
                        document.getElementById('assignDelegateName').value = delegate.full_name;
                        document.getElementById('assignPreferredCommittee').value = delegate.committee_preference_1 || 'N/A';
                    } else {
                        document.getElementById('assignDelegateName').value = data.member_name;
                        document.getElementById('assignPreferredCommittee').value = data.member_committee_preference || 'N/A';
                    }
                    
                    document.getElementById('assignedCommittee').value = '';
                    new bootstrap.Modal(document.getElementById('assignModal')).show();
                })
                .catch(error => {
                    alert('Error loading data: ' + error);
                    console.error('Error:', error);
                });
        }

        function confirmAssignment() {
            const committee = document.getElementById('assignedCommittee').value;
            
            if (!committee) {
                alert('Please select a committee');
                return;
            }
            
            const formData = new FormData();
            if (currentAssignType === 'main') {
                formData.append('delegate_id', currentAssignId);
            } else {
                formData.append('member_id', currentAssignId);
            }
            formData.append('assigned_committee', committee);
            formData.append('type', currentAssignType);
            
            fetch('<?php echo BASE_URL; ?>admin/ajax/assign-committee.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Committee assigned successfully! Acceptance email sent.');
                    bootstrap.Modal.getInstance(document.getElementById('assignModal')).hide();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error assigning committee: ' + error);
            });
        }

        function editStatus(id) {
            document.getElementById('editForm').action = '<?php echo BASE_URL; ?>admin/delegates?action=update_status&id=' + id;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function deleteDelegate(id) {
            if (confirm('Are you sure you want to delete this registration?')) {
                window.location.href = '<?php echo BASE_URL; ?>admin/delegates?action=delete&id=' + id;
            }
        }

        function viewPayment(id) {
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            const paymentContent = document.getElementById('paymentContent');
            const downloadBtn = document.getElementById('downloadPayment');
            
            // Show loading spinner
            paymentContent.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
            downloadBtn.style.display = 'none';
            
            modal.show();
            
            // Fetch payment screenshot info
            fetch(`<?php echo BASE_URL; ?>admin/ajax/get-delegate.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.delegate.payment_screenshot) {
                        const imageUrl = '<?php echo BASE_URL; ?>' + data.delegate.payment_screenshot;
                        paymentContent.innerHTML = `
                            <div class="p-3">
                                <img src="${imageUrl}" alt="Payment Screenshot" class="img-fluid rounded shadow" style="max-height: 70vh; cursor: zoom-in;" onclick="window.open('${imageUrl}', '_blank')">
                                <div class="mt-3 text-muted">
                                    <small><i class="fas fa-info-circle me-1"></i>Click on image to view full size</small>
                                </div>
                            </div>
                        `;
                        downloadBtn.href = imageUrl;
                        downloadBtn.download = data.delegate.payment_screenshot;
                        downloadBtn.style.display = 'inline-block';
                    } else {
                        paymentContent.innerHTML = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>No payment screenshot available for this delegate.</div>';
                    }
                })
                .catch(error => {
                    paymentContent.innerHTML = '<div class="alert alert-danger"><i class="fas fa-times-circle me-2"></i>Error loading payment screenshot.</div>';
                    console.error('Error:', error);
                });
        }

        function exportToCSV() {
            window.location.href = '<?php echo BASE_URL; ?>admin/ajax/export-delegates.php';
        }
    </script>
</body>
</html>
