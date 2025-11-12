<div class="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center justify-content-center mb-2">
            <i class="fas fa-user-shield fa-3x" style="color: var(--primary-gold);"></i>
        </div>
        <h4><i class="fas fa-chart-line me-2"></i>NEDMUN Admin</h4>
        <p class="text-muted small mb-0">Management Portal</p>
    </div>
    
    <nav class="sidebar-nav">
        <a href="<?php echo BASE_URL; ?>admin/dashboard" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?php echo BASE_URL; ?>admin/delegates" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'delegates.php' ? 'active' : ''; ?>">
            <i class="fas fa-users"></i>
            <span>Delegate Registrations</span>
        </a>
        <a href="<?php echo BASE_URL; ?>admin/brand-ambassadors" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) === 'brand-ambassadors.php' ? 'active' : ''; ?>">
            <i class="fas fa-star"></i>
            <span>Brand Ambassadors</span>
        </a>
        
        <div style="border-top: 2px solid var(--border-color); margin: 1.5rem 1rem;"></div>
        
        <a href="<?php echo BASE_URL; ?>admin/logout" class="sidebar-link" style="color: #ff5252;">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </nav>
    
    <div style="position: absolute; bottom: 20px; left: 0; right: 0; padding: 0 1.5rem; text-align: center;">
        <small style="color: var(--text-light); opacity: 0.7; display: block; margin-bottom: 0.5rem;">
            <i class="fas fa-code me-1"></i>NEDMUN-VI v1.0
        </small>
        <small style="color: var(--primary-gold); opacity: 0.8; display: block;">
            Developed by <a href="https://telinks.org" target="_blank" style="color: var(--primary-gold); text-decoration: none; font-weight: 600;">TE Links</a>
        </small>
    </div>
</div>
