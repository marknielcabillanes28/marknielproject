<?php
// Network Test Script (Non-CodeIgniter)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Network Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Network Connection Test</h1>
    <h2>Server Information:</h2>
    <ul>
        <li><strong>Server IP:</strong> <?= $_SERVER['SERVER_ADDR'] ?? 'Unknown' ?></li>
        <li><strong>Client IP:</strong> <?= $_SERVER['REMOTE_ADDR'] ?? 'Unknown' ?></li>
        <li><strong>Server Name:</strong> <?= $_SERVER['SERVER_NAME'] ?? 'Unknown' ?></li>
        <li><strong>Request URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'Unknown' ?></li>
        <li><strong>Current Time:</strong> <?= date('Y-m-d H:i:s') ?></li>
    </ul>

    <h2>Access URLs:</h2>
    <div class="info">
        <p><strong>Correct URLs to use from other computers:</strong></p>
        <ul>
            <li><a href="http://192.168.15.15/cabillanes/public/" target="_blank">Main Application (Recommended)</a></li>
            <li><a href="http://192.168.15.15/cabillanes/public/auth/login" target="_blank">Login Page</a></li>
            <li><a href="http://192.168.15.15/cabillanes/public/auth/register" target="_blank">Register Page</a></li>
            <li><a href="http://192.168.15.15/cabillanes/" target="_blank">Auto-redirect (Alternative)</a></li>
        </ul>
    </div>

    <h2>File Tests:</h2>
    <ul>
        <li><?= file_exists('../public/index.php') ? '<span class="success">✅</span>' : '<span class="error">❌</span>' ?> CodeIgniter public/index.php exists</li>
        <li><?= file_exists('../app/Config/App.php') ? '<span class="success">✅</span>' : '<span class="error">❌</span>' ?> App.php config exists</li>
        <li><?= is_writable('../writable') ? '<span class="success">✅</span>' : '<span class="error">❌</span>' ?> Writable directory is accessible</li>
    </ul>

    <h2>Instructions for Other Users:</h2>
    <div style="background: #f0f0f0; padding: 15px; border-radius: 5px;">
        <p><strong>Tell other users to access:</strong></p>
        <code style="background: #fff; padding: 5px; display: block; margin: 5px 0;">
            http://192.168.15.15/cabillanes/public/
        </code>
        <p>Or they can use the auto-redirect:</p>
        <code style="background: #fff; padding: 5px; display: block; margin: 5px 0;">
            http://192.168.15.15/cabillanes/
        </code>
    </div>
</body>
</html>