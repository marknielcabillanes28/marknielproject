<!DOCTYPE html>
<html>
<head>
    <title>System Status Test</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f1c2c7; }
    </style>
</head>
<body>
    <h1>System Status Test</h1>
    
    <div class="status success">
        <h3>✅ Current Session Info:</h3>
        <p><strong>User:</strong> <?= session()->get('username') ?? 'Not logged in' ?></p>
        <p><strong>Role:</strong> <?= session()->get('role') ?? 'None' ?></p>
        <p><strong>Logged In:</strong> <?= session()->get('isLoggedIn') ? 'Yes' : 'No' ?></p>
    </div>
    
    <div class="status <?= (session()->get('maintenance_mode') === 'on') ? 'warning' : 'success' ?>">
        <h3><?= (session()->get('maintenance_mode') === 'on') ? '🛠️ Maintenance Mode: ON' : '✅ Maintenance Mode: OFF' ?></h3>
        <p>Current maintenance status: <?= session()->get('maintenance_mode') ?? 'off' ?></p>
    </div>
    
    <div class="status success">
        <h3>🔗 Available Links:</h3>
        <ul>
            <li><a href="<?= base_url('/auth/login') ?>">Login</a></li>
            <li><a href="<?= base_url('/auth/register') ?>">Register</a></li>
            <li><a href="<?= base_url('/user/dashboard') ?>">User Dashboard</a></li>
            <li><a href="<?= base_url('/admin/dashboard') ?>">Admin Dashboard</a></li>
            <li><a href="<?= base_url('/electronics') ?>">Electronics</a></li>
            <li><a href="<?= base_url('/admin/toggle-maintenance') ?>">Toggle Maintenance (Admin Only)</a></li>
        </ul>
    </div>
    
    <div class="status success">
        <h3>🌐 Network Info:</h3>
        <p><strong>Base URL:</strong> <?= base_url() ?></p>
        <p><strong>Current URL:</strong> <?= current_url() ?></p>
        <p><strong>Server IP:</strong> <?= $_SERVER['SERVER_ADDR'] ?? 'Unknown' ?></p>
    </div>
    
    <?php if (session()->get('maintenance_mode') === 'on' && session()->get('role') !== 'admin'): ?>
    <div class="status error">
        <h3>⚠️ Maintenance Mode Active</h3>
        <p>Regular users should see the maintenance page when trying to access the system.</p>
    </div>
    <?php endif; ?>
</body>
</html>