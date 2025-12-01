<?php

namespace App\Controllers;

class QuickFix extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }
    
    public function index()
    {
        echo "<h1>🚨 QUICK FIX FOR LOGIN ISSUE</h1>";
        echo "<style>body{font-family:Arial;padding:20px;background:#f0f0f0;} .box{background:white;padding:20px;margin:10px 0;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);} .success{background:#d4edda;color:#155724;} .error{background:#f8d7da;color:#721c24;} .warning{background:#fff3cd;color:#856404;} button{background:#007bff;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;}</style>";
        
        echo "<div class='box warning'>";
        echo "<h3>🔍 Problem Identified:</h3>";
        echo "<p>Your passwords are stored as <strong>plain text</strong> instead of being hashed!</p>";
        echo "<p>This is why login fails - the system expects hashed passwords.</p>";
        echo "</div>";
        
        try {
            $users = $this->userModel->findAll();
            
            echo "<div class='box'>";
            echo "<h3>👥 Current Users:</h3>";
            
            $plainTextUsers = [];
            $hashedUsers = [];
            
            foreach ($users as $user) {
                $isHashed = str_starts_with($user['password'], '$2y$');
                
                if ($isHashed) {
                    $hashedUsers[] = $user;
                    echo "<p>✅ <strong>{$user['username']}</strong> - Password properly hashed</p>";
                } else {
                    $plainTextUsers[] = $user;
                    echo "<p>❌ <strong>{$user['username']}</strong> - Password is plain text: '<code>{$user['password']}</code>'</p>";
                }
            }
            echo "</div>";
            
            if (!empty($plainTextUsers)) {
                echo "<div class='box error'>";
                echo "<h3>🔧 Fix Required:</h3>";
                echo "<p>Found " . count($plainTextUsers) . " users with plain text passwords.</p>";
                echo "<form method='post' action='" . base_url('/quick-fix/hash-all-passwords') . "'>";
                echo "<button type='submit'>🔒 Hash All Plain Text Passwords</button>";
                echo "</form>";
                echo "</div>";
            }
            
            if (!empty($hashedUsers)) {
                echo "<div class='box success'>";
                echo "<h3>✅ Already Fixed:</h3>";
                echo "<p>" . count($hashedUsers) . " users already have properly hashed passwords.</p>";
                echo "</div>";
            }
            
        } catch (\Exception $e) {
            echo "<div class='box error'>";
            echo "<h3>❌ Database Error:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "</div>";
        }
        
        echo "<div class='box'>";
        echo "<h3>🧪 Test Login After Fix:</h3>";
        echo "<p>After fixing, try these credentials:</p>";
        echo "<ul>";
        echo "<li><strong>Username:</strong> chavy</li>";
        echo "<li><strong>Password:</strong> password (or whatever the plain text was)</li>";
        echo "</ul>";
        echo "<a href='" . base_url('/auth/login') . "' target='_blank'>→ Go to Login Page</a>";
        echo "</div>";
    }
    
    public function hashAllPasswords()
    {
        echo "<h1>🔒 Hashing Plain Text Passwords</h1>";
        echo "<style>body{font-family:Arial;padding:20px;background:#f0f0f0;} .box{background:white;padding:20px;margin:10px 0;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);} .success{background:#d4edda;color:#155724;} .error{background:#f8d7da;color:#721c24;}</style>";
        
        try {
            $users = $this->userModel->findAll();
            $fixed = 0;
            $alreadyHashed = 0;
            
            echo "<div class='box'>";
            echo "<h3>Processing Users:</h3>";
            
            foreach ($users as $user) {
                $isHashed = str_starts_with($user['password'], '$2y$');
                
                if (!$isHashed) {
                    // Hash the plain text password
                    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
                    
                    // Update directly in database to bypass model hooks
                    $db = \Config\Database::connect();
                    $db->table('users')
                       ->where('id', $user['id'])
                       ->update(['password' => $hashedPassword]);
                    
                    echo "<p>✅ Fixed: <strong>{$user['username']}</strong> - Plain text '<code>{$user['password']}</code>' → Hashed</p>";
                    $fixed++;
                } else {
                    echo "<p>ℹ️ Skipped: <strong>{$user['username']}</strong> - Already hashed</p>";
                    $alreadyHashed++;
                }
            }
            
            echo "</div>";
            
            echo "<div class='box success'>";
            echo "<h3>🎉 Fix Complete!</h3>";
            echo "<p><strong>Fixed:</strong> {$fixed} users</p>";
            echo "<p><strong>Already hashed:</strong> {$alreadyHashed} users</p>";
            echo "<p>All passwords are now properly hashed!</p>";
            echo "</div>";
            
        } catch (\Exception $e) {
            echo "<div class='box error'>";
            echo "<h3>❌ Error:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "</div>";
        }
        
        echo "<div class='box'>";
        echo "<h3>🧪 Test Login Now:</h3>";
        echo "<p>Try logging in with:</p>";
        echo "<ul>";
        echo "<li><strong>Username:</strong> chavy</li>";
        echo "<li><strong>Password:</strong> password</li>";
        echo "</ul>";
        echo "<a href='" . base_url('/auth/login') . "'>→ Go to Login Page</a>";
        echo "</div>";
    }
}
?>