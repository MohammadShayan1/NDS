<?php
/**
 * Admin Layout Component
 * Combines sidebar and header for cleaner code
 */

function renderAdminLayout($pageTitle = 'Admin Panel', $currentPage = '') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($pageTitle); ?> - NEDMUN-VI Admin</title>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <!-- Custom Admin CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
    </head>
    <body>
        <div class="admin-wrapper">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-brand p-4 text-center">
                    <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.svg" alt="NDS Logo" class="img-fluid mb-2" style="max-width: 180px;">
                    <h5 class="text-white mb-0"><i class="fas fa-chart-line me-2"></i>Admin Panel</h5>
                    <small class="text-muted d-block">NED Debating Society</small>
                </div>
                
                <nav class="sidebar-nav">
                    <a href="<?php echo BASE_URL; ?>admin/dashboard" class="sidebar-link <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a href="<?php echo BASE_URL; ?>admin/delegates" class="sidebar-link <?php echo $currentPage === 'delegates' ? 'active' : ''; ?>">
                        <i class="fas fa-users me-2"></i>Delegate Registrations
                    </a>
                    <a href="<?php echo BASE_URL; ?>admin/brand-ambassadors" class="sidebar-link <?php echo $currentPage === 'brand-ambassadors' ? 'active' : ''; ?>">
                        <i class="fas fa-star me-2"></i>Brand Ambassadors
                    </a>
                    <a href="<?php echo BASE_URL; ?>admin/logout" class="sidebar-link text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Top Header -->
                <div class="top-header bg-white shadow-sm py-3 mb-4">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h5>
                            </div>
                            <div>
                                <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-external-link-alt me-1"></i>View Website
                                </a>
                                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-sm btn-danger">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Content Container -->
                <div class="container-fluid">
    <?php
}

function closeAdminLayout() {
    ?>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    </body>
    </html>
    <?php
}
?>
