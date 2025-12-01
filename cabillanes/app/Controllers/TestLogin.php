<?php

namespace App\Controllers;

class TestLogin extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }
    
    public function index()
    {
        echo "<h1>🧪 LOGIN TEST & DIAGNOSTICS</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .box{background:#f8f9fa;padding:15px;margin:10px 0;border-left:4px solid #007bff;} .success{border-color:#28a745;background:#d4f6d4;} .error{border-color:#dc3545;background:#f8d7da;} .warning{border-color:#ffc107;background:#fff3cd;} input,button{padding:8px;margin:5px;}</style>";
        
        // Show current users
        echo "<div class='box'>";
        echo "<h3>👥 Users in Database:</h3>";
        try {
            $users = $this->userModel->findAll();
            foreach ($users as $user) {
                $hashType = str_starts_with($user['password'], '$2y$') ? 'HASHED' : 'PLAIN TEXT';
                $hashColor = $hashType === 'HASHED' ? 'green' : 'red';
                echo "<p><strong>{$user['username']}</strong> ({$user['role']}) - Password: <span style='color:{$hashColor}'>{$hashType}</span></p>";
                if ($hashType === 'PLAIN TEXT') {
                    echo "<p style='color:red;margin-left:20px;'>Plain text value: '{$user['password']}'</p>";
                }
            }
        } catch (\Exception $e) {
            echo "<p style='color:red'>Database error: {$e->getMessage()}</p>";
        }
        echo "</div>";
        
        // Test form
        echo "<div class='box'>";
        echo "<h3>🧪 Test Login Here:</h3>";
        echo "<form method='post' action='" . base_url('/test-login/authenticate') . "'>";
        echo "<p><label>Username:</label><br><input type='text' name='username' value='chavy' required></p>";
        echo "<p><label>Password:</label><br><input type='password' name='password' value='password' required></p>";
        echo "<button type='submit'>🔍 Test Authentication</button>";
        echo "</form>";
        echo "</div>";
        
        // Quick fixes
        echo "<div class='box warning'>";
        echo "<h3>⚡ Quick Fixes:</h3>";
        echo "<form method='post' action='" . base_url('/test-login/hash-passwords') . "' style='display:inline;'>";
        echo "<button type='submit'>🔒 Hash All Plain Text Passwords</button>";
        echo "</form> ";
        echo "<form method='post' action='" . base_url('/test-login/create-test-user') . "' style='display:inline;'>";
        echo "<button type='submit'>👤 Create Fresh Test User</button>";
        echo "</form>";
        echo "</div>";
    }
    
    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        echo "<h1>🔍 LOGIN TEST RESULTS</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .box{background:#f8f9fa;padding:15px;margin:10px 0;border-left:4px solid #007bff;} .success{border-color:#28a745;background:#d4f6d4;} .error{border-color:#dc3545;background:#f8d7da;} .step{margin:10px 0;padding:10px;background:#e9ecef;}</style>";
        
        echo "<div class='box'>";
        echo "<h3>📝 Test Details:</h3>";
        echo "<p><strong>Username:</strong> {$username}</p>";
        echo "<p><strong>Password:</strong> {$password}</p>";
        echo "</div>";
        
        // Step 1: Check if user exists
        echo "<div class='step'>";
        echo "<h4>Step 1: User Lookup</h4>";
        $user = $this->userModel->where('username', $username)->first();
        if ($user) {
            echo "<p style='color:green'>✅ User found in database</p>";
            echo "<p><strong>ID:</strong> {$user['id']}</p>";
            echo "<p><strong>Username:</strong> {$user['username']}</p>";
            echo "<p><strong>Role:</strong> {$user['role']}</p>";
            echo "<p><strong>Stored Password:</strong> {$user['password']}</p>";
        } else {
            echo "<p style='color:red'>❌ User NOT found in database</p>";
            echo "<a href='" . base_url('/test-login') . "'>← Back to Test</a>";
            return;
        }
        echo "</div>";
        
        // Step 2: Test password verification methods
        echo "<div class='step'>";
        echo "<h4>Step 2: Password Verification Tests</h4>";
        
        // Test 1: Direct comparison (for plain text)
        $directMatch = ($password === $user['password']);
        echo "<p><strong>Direct comparison:</strong> " . ($directMatch ? "<span style='color:green'>✅ MATCH</span>" : "<span style='color:red'>❌ NO MATCH</span>") . "</p>";
        
        // Test 2: password_verify (for hashed)
        $hashMatch = password_verify($password, $user['password']);
        echo "<p><strong>password_verify():</strong> " . ($hashMatch ? "<span style='color:green'>✅ MATCH</span>" : "<span style='color:red'>❌ NO MATCH</span>") . "</p>";
        
        // Test 3: Model method
        $modelResult = $this->userModel->verifyPassword($username, $password);
        echo "<p><strong>Model verifyPassword():</strong> " . ($modelResult ? "<span style='color:green'>✅ SUCCESS</span>" : "<span style='color:red'>❌ FAILED</span>") . "</p>";
        echo "</div>";
        
        // Step 3: Recommendation
        echo "<div class='step'>";
        echo "<h4>Step 3: Diagnosis & Recommendation</h4>";
        
        $isPlainText = !str_starts_with($user['password'], '$2y$');
        
        if ($isPlainText && $directMatch) {
            echo "<div class='box error'>";
            echo "<h4>🚨 Problem: Plain Text Password</h4>";
            echo "<p>The password is stored as plain text, but the system expects hashed passwords.</p>";
            echo "<p><strong>Solution:</strong> Hash the password in the database.</p>";
            echo "<form method='post' action='" . base_url('/test-login/fix-user-password') . "'>";
            echo "<input type='hidden' name='user_id' value='{$user['id']}'>";
            echo "<input type='hidden' name='username' value='{$username}'>";
            echo "<input type='hidden' name='password' value='{$password}'>";
            echo "<button type='submit'>🔧 Fix This User's Password</button>";
            echo "</form>";
            echo "</div>";
        } elseif (!$isPlainText && $hashMatch) {
            echo "<div class='box success'>";
            echo "<h4>✅ Password is correctly hashed and verified!</h4>";
            echo "<p>The authentication should work. There might be another issue.</p>";
            echo "</div>";
        } else {
            echo "<div class='box error'>";
            echo "<h4>❌ Password mismatch</h4>";
            echo "<p>Neither plain text nor hash verification worked.</p>";
            echo "<p>Try resetting the password for this user.</p>";
            echo "</div>";
        }
        echo "</div>";
        
        // Test actual login flow
        echo "<div class='step'>";
        echo "<h4>Step 4: Test Actual Login Flow</h4>";
        echo "<form method='post' action='" . base_url('/auth/auth') . "' target='_blank'>";
        echo "<input type='hidden' name='username' value='{$username}'>";
        echo "<input type='hidden' name='password' value='{$password}'>";
        echo "<button type='submit'>🚀 Test Real Login (Opens in New Tab)</button>";
        echo "</form>";
        echo "</div>";
        
        echo "<br><a href='" . base_url('/test-login') . "'>← Back to Test Page</a>";
    }
    
    public function hashPasswords()
    {
        echo "<h1>🔒 Hashing Plain Text Passwords</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
        
        try {
            $users = $this->userModel->findAll();
            $fixed = 0;
            
            $db = \Config\Database::connect();
            
            foreach ($users as $user) {
                $isPlainText = !str_starts_with($user['password'], '$2y$');
                
                if ($isPlainText) {
                    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
                    $db->table('users')->where('id', $user['id'])->update(['password' => $hashedPassword]);
                    echo "<p class='success'>✅ Fixed: {$user['username']} - '{$user['password']}' → hashed</p>";
                    $fixed++;
                } else {
                    echo "<p>ℹ️ Skipped: {$user['username']} - already hashed</p>";
                }
            }
            
            echo "<h3 class='success'>🎉 Fixed {$fixed} passwords!</h3>";
            
        } catch (\Exception $e) {
            echo "<p class='error'>Error: {$e->getMessage()}</p>";
        }
        
        echo "<br><a href='" . base_url('/test-login') . "'>← Back to Test</a>";
        echo "<br><a href='" . base_url('/auth/login') . "'>→ Try Login Now</a>";
    }
    
    public function createTestUser()
    {
        echo "<h1>👤 Creating Fresh Test User</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
        
        try {
            // Delete existing test user if exists
            $this->userModel->where('username', 'testuser')->delete();
            
            // Create new test user
            $data = [
                'username' => 'testuser',
                'password' => 'test123',
                'role' => 'user'
            ];
            
            $this->userModel->insert($data);
            
            echo "<p class='success'>✅ Created test user successfully!</p>";
            echo "<p><strong>Username:</strong> testuser</p>";
            echo "<p><strong>Password:</strong> test123</p>";
            echo "<p><strong>Role:</strong> user</p>";
            
        } catch (\Exception $e) {
            echo "<p class='error'>Error: {$e->getMessage()}</p>";
        }
        
        echo "<br><a href='" . base_url('/test-login') . "'>← Back to Test</a>";
        echo "<br><a href='" . base_url('/auth/login') . "'>→ Try Login with testuser/test123</a>";
    }
    
    public function fixUserPassword()
    {
        $userId = $this->request->getPost('user_id');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        echo "<h1>🔧 Fixing User Password</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
        
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $db = \Config\Database::connect();
            $db->table('users')->where('id', $userId)->update(['password' => $hashedPassword]);
            
            echo "<p class='success'>✅ Fixed password for user: {$username}</p>";
            echo "<p>Original: {$password}</p>";
            echo "<p>Now hashed: " . substr($hashedPassword, 0, 30) . "...</p>";
            
        } catch (\Exception $e) {
            echo "<p class='error'>Error: {$e->getMessage()}</p>";
        }
        
        echo "<br><a href='" . base_url('/test-login') . "'>← Back to Test</a>";
        echo "<br><a href='" . base_url('/auth/login') . "'>→ Try Login Now</a>";
    }
}
?>