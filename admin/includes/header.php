<div class="top-header py-3 mb-4">
    <div class="container-fluid">
        <nav class="navbar navbar-expand navbar-dark">
            <div class="container-fluid px-0">
                <div class="navbar-text">
                    <i class="fas fa-user-shield me-2"></i>
                    Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>!
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-secondary me-3" id="sessionTimer">
                        <i class="fas fa-clock me-1"></i>
                        <span id="timeLeft">60:00</span>
                    </span>
                    <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                        <i class="fas fa-external-link-alt me-1"></i>View Website
                    </a>
                    <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-sm btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Session Timer Script -->
<script>
    // Session timeout: 1 hour (3600 seconds)
    let sessionTimeout = 3600;
    let timeRemaining = sessionTimeout;
    
    // Get last activity from server
    <?php if(isset($_SESSION['LAST_ACTIVITY'])): ?>
    let lastActivity = <?php echo $_SESSION['LAST_ACTIVITY']; ?>;
    let currentTime = <?php echo time(); ?>;
    timeRemaining = sessionTimeout - (currentTime - lastActivity);
    <?php endif; ?>
    
    function updateTimer() {
        if (timeRemaining <= 0) {
            window.location.href = '<?php echo BASE_URL; ?>admin/logout';
            return;
        }
        
        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;
        
        document.getElementById('timeLeft').textContent = 
            String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        
        // Change color when less than 5 minutes
        let timerBadge = document.getElementById('sessionTimer');
        if (timeRemaining < 300) {
            timerBadge.classList.remove('bg-secondary');
            timerBadge.classList.add('bg-warning');
        }
        if (timeRemaining < 60) {
            timerBadge.classList.remove('bg-warning');
            timerBadge.classList.add('bg-danger');
        }
        
        timeRemaining--;
    }
    
    // Update timer every second
    setInterval(updateTimer, 1000);
    updateTimer();
    
    // Reset timer on user activity
    let activityEvents = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
    let activityTimeout;
    
    function resetActivityTimer() {
        clearTimeout(activityTimeout);
        activityTimeout = setTimeout(function() {
            // Send keep-alive request
            fetch('<?php echo BASE_URL; ?>admin/ajax/keep-alive.php')
                .then(() => {
                    timeRemaining = sessionTimeout;
                    document.getElementById('sessionTimer').classList.remove('bg-warning', 'bg-danger');
                    document.getElementById('sessionTimer').classList.add('bg-secondary');
                });
        }, 5000); // Debounce for 5 seconds
    }
    
    activityEvents.forEach(function(eventName) {
        document.addEventListener(eventName, resetActivityTimer, true);
    });
</script>
