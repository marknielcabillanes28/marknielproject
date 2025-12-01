<?php
// Direct database password fix for user 'chavy'

try {
    // Connect to database
    $host = 'localhost';
    $dbname = 'electronics_inventory';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>🔧 Direct Password Fix for User 'chavy'</h1>";
    echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;background:#e8f5e8;padding:10px;} .error{color:red;background:#ffe8e8;padding:10px;} .info{color:blue;background:#e8f0ff;padding:10px;}</style>";
    
    // First, let's see the current state
    echo "<div class='info'>";
    echo "<h3>Current State:</h3>";
    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = 'chavy'");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<p><strong>User found:</strong> {$user['username']}</p>";
        echo "<p><strong>Current password:</strong> {$user['password']}</p>";
        echo "<p><strong>Role:</strong> {$user['role']}</p>";
        
        // Check if it's already hashed
        $isHashed = str_starts_with($user['password'], '$2y$');
        echo "<p><strong>Status:</strong> " . ($isHashed ? "Already Hashed ✅" : "Plain Text ❌") . "</p>";
        
        if (!$isHashed) {
            // Hash the password "password"
            $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
            
            // Update the database
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $result = $updateStmt->execute([$hashedPassword, $user['id']]);
            
            if ($result) {
                echo "</div>";
                echo "<div class='success'>";
                echo "<h3>✅ Password Updated Successfully!</h3>";
                echo "<p><strong>Old password:</strong> {$user['password']} (plain text)</p>";
                echo "<p><strong>New password:</strong> " . substr($hashedPassword, 0, 30) . "... (hashed)</p>";
                echo "<p><strong>Login credentials:</strong></p>";
                echo "<ul>";
                echo "<li><strong>Username:</strong> chavy</li>";
                echo "<li><strong>Password:</strong> password</li>";
                echo "</ul>";
                echo "</div>";
                
                // Test the new hash
                echo "<div class='info'>";
                echo "<h3>🧪 Testing New Hash:</h3>";
                $testResult = password_verify('password', $hashedPassword);
                echo "<p>password_verify('password', hash) = " . ($testResult ? "<span style='color:green'>✅ SUCCESS</span>" : "<span style='color:red'>❌ FAILED</span>") . "</p>";
                echo "</div>";
                
            } else {
                echo "</div>";
                echo "<div class='error'>";
                echo "<h3>❌ Update Failed</h3>";
                echo "<p>Could not update the password in the database.</p>";
                echo "</div>";
            }
        } else {
            echo "</div>";
            echo "<div class='success'>";
            echo "<h3>✅ Password Already Hashed</h3>";
            echo "<p>The password is already properly hashed. The issue might be elsewhere.</p>";
            echo "</div>";
        }
    } else {
        echo "</div>";
        echo "<div class='error'>";
        echo "<h3>❌ User Not Found</h3>";
        echo "<p>User 'chavy' was not found in the database.</p>";
        echo "</div>";
    }
    
} catch (PDOException $e) {
    echo "<div class='error'>";
    echo "<h3>❌ Database Error</h3>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<div style="margin-top:20px;padding:15px;background:#f0f0f0;border-radius:5px;">
    <h3>🚀 Next Steps:</h3>
    <ol>
        <li><strong>Try logging in now:</strong> <a href="http://192.168.15.15/cabillanes/public/auth/login" target="_blank">→ Login Page</a></li>
        <li><strong>Username:</strong> chavy</li>
        <li><strong>Password:</strong> password</li>
    </ol>
    
    <h3>🛠️ Other Tools:</h3>
    <ul>
        <li><a href="http://192.168.15.15/cabillanes/public/test-login">→ Test Login Tool</a></li>
        <li><a href="http://192.168.15.15/cabillanes/public/password-debug">→ Password Debug Tool</a></li>
    </ul>
</div>