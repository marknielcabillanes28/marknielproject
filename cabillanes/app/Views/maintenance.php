<!DOCTYPE html>
<html>
<head>
    <title>System Under Maintenance</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff6b6b, #ffa500);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }
        
        .maintenance-container {
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 500px;
        }
        
        .maintenance-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #ffff00;
        }
        
        p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .btn {
            background: #4CAF50;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #45a049;
        }
        
        .time-info {
            margin-top: 20px;
            font-size: 0.9em;
            opacity: 0.8;
        }
        
        .debug-info {
            margin-top: 20px;
            font-size: 0.8em;
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🛠️</div>
        <h1>System Under Maintenance</h1>
        <p>
            We're currently performing scheduled maintenance to improve your experience. 
            The system will be back online shortly.
        </p>
        <p>
            Thank you for your patience!
        </p>
        
        <a href="<?= base_url('/auth/logout') ?>" class="btn">Return to Login</a>
        
        <div class="time-info">
            Last updated: <?= date('M j, Y g:i A') ?>
        </div>
        
        <?php 
        // Force session destruction for non-admin users
        if (function_exists('session')) {
            try {
                $role = session()->get('role');
                if ($role !== 'admin') {
                    session()->destroy();
                }
            } catch (\Exception $e) {
                // Session not available, ignore
            }
        }
        ?>
        
        <div class="debug-info">
            <strong>🔒 MAINTENANCE MODE ACTIVE</strong><br>
            User session has been terminated for security.<br>
            Admin access remains available.
        </div>
    </div>
    
    <script>
        // Clear any cached data and force page refresh
        if (window.location.hash !== '#maintenance') {
            window.location.hash = '#maintenance';
            window.location.reload();
        }
    </script>
</body>
</html>