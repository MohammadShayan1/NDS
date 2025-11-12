<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../models/DelegateRegistration.php';
require_once '../models/BrandAmbassador.php';

requireLogin();

$database = new Database();
$db = $database->connect();

$delegateModel = new DelegateRegistration($db);
$baModel = new BrandAmbassador($db);

$delegateStats = $delegateModel->getStats();
$baStats = $baModel->getStats();

$recentDelegates = array_slice($delegateModel->getAll(), 0, 5);
$recentBAs = array_slice($baModel->getAll(), 0, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include 'includes/header.php'; ?>

        <div class="container-fluid py-4">
            <h1 class="mb-4">Dashboard</h1>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Total Delegates</h6>
                                    <h2 class="mb-0"><?php echo $delegateStats['total']; ?></h2>
                                </div>
                                <i class="fas fa-users fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Confirmed</h6>
                                    <h2 class="mb-0"><?php echo $delegateStats['confirmed']; ?></h2>
                                </div>
                                <i class="fas fa-check-circle fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Pending</h6>
                                    <h2 class="mb-0"><?php echo $delegateStats['pending']; ?></h2>
                                </div>
                                <i class="fas fa-clock fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Brand Ambassadors</h6>
                                    <h2 class="mb-0"><?php echo $baStats['total']; ?></h2>
                                </div>
                                <i class="fas fa-star fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Breakdown -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Registration Breakdown</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>NED Students</span>
                                    <strong><?php echo $delegateStats['ned_registrations']; ?></strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $delegateStats['total'] > 0 ? ($delegateStats['ned_registrations']/$delegateStats['total']*100) : 0; ?>%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Other Institutions</span>
                                    <strong><?php echo $delegateStats['other_registrations']; ?></strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $delegateStats['total'] > 0 ? ($delegateStats['other_registrations']/$delegateStats['total']*100) : 0; ?>%"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Individual Delegates</span>
                                    <strong><?php echo $delegateStats['delegates']; ?></strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $delegateStats['total'] > 0 ? ($delegateStats['delegates']/$delegateStats['total']*100) : 0; ?>%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Delegations</span>
                                    <strong><?php echo $delegateStats['delegations']; ?></strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $delegateStats['total'] > 0 ? ($delegateStats['delegations']/$delegateStats['total']*100) : 0; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-star me-2"></i>Brand Ambassador Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Pending Review</span>
                                    <strong><?php echo $baStats['pending']; ?></strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $baStats['total'] > 0 ? ($baStats['pending']/$baStats['total']*100) : 0; ?>%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Approved</span>
                                    <strong><?php echo $baStats['approved']; ?></strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $baStats['total'] > 0 ? ($baStats['approved']/$baStats['total']*100) : 0; ?>%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Rejected</span>
                                    <strong><?php echo $baStats['rejected']; ?></strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $baStats['total'] > 0 ? ($baStats['rejected']/$baStats['total']*100) : 0; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Delegate Registrations</h5>
                            <a href="<?php echo BASE_URL; ?>admin/delegates" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Institution</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentDelegates as $delegate): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($delegate['full_name']); ?></td>
                                            <td><?php echo htmlspecialchars($delegate['institution_name']); ?></td>
                                            <td><span class="badge bg-<?php echo $delegate['registration_type'] === 'NED' ? 'primary' : 'secondary'; ?>"><?php echo $delegate['registration_type']; ?></span></td>
                                            <td><span class="badge bg-<?php echo $delegate['status'] === 'confirmed' ? 'success' : 'warning'; ?>"><?php echo ucfirst($delegate['status']); ?></span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent BA Applications</h5>
                            <a href="<?php echo BASE_URL; ?>admin/brand-ambassadors" class="btn btn-sm btn-warning">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Institution</th>
                                            <th>Delegates</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentBAs as $ba): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($ba['full_name']); ?></td>
                                            <td><?php echo htmlspecialchars($ba['institution']); ?></td>
                                            <td><?php echo htmlspecialchars($ba['delegates_count']); ?></td>
                                            <td><span class="badge bg-<?php echo $ba['status'] === 'approved' ? 'success' : ($ba['status'] === 'rejected' ? 'danger' : 'warning'); ?>"><?php echo ucfirst($ba['status']); ?></span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tech Partner Credit -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="text-center p-3" style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), transparent); border-radius: 10px; border: 1px solid rgba(212, 175, 55, 0.2);">
                        <p class="mb-0" style="color: var(--text-light);">
                            <i class="fas fa-laptop-code me-2" style="color: var(--primary-gold);"></i>
                            <strong style="color: var(--primary-gold);">Tech Partner:</strong>
                            <a href="https://telinks.org" target="_blank" style="color: var(--primary-gold); text-decoration: none; font-weight: 600; margin-left: 0.5rem;">
                                TE Links (telinks.org)
                            </a>
                            <span style="opacity: 0.7; margin-left: 1rem;">— Powering NEDMUN-VI Registration System</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
