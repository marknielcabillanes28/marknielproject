<?php

namespace App\Controllers;

class PasswordDebug extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }
    
    public function index()
    {
        echo "<h1>Password Debug Utility</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .user{background:#f0f0f0;padding:10px;margin:10px 0;border-radius:5px;} .success{color:green;} .error{color:red;}</style>";
        
        try {
            $users = $this->userModel->findAll();
            
            echo "<h2>Users in Database:</h2>";
            foreach ($users as $user) {
                echo "<div class='user'>";
                echo "<strong>Username:</strong> " . htmlspecialchars($user['username']) . "<br>";
                echo "<strong>Role:</strong> " . htmlspecialchars($user['role']) . "<br>";
                echo "<strong>Password Hash:</strong> " . htmlspecialchars(substr($user['password'], 0, 30)) . "...<br>";
                echo "<strong>Hash Type:</strong> " . (str_starts_with($user['password'], '$2y$') ? '<span class="success">Properly Hashed (bcrypt)</span>' : '<span class="error">Plain Text or Invalid Hash</span>');
                echo "</div>";
            }
            
        } catch (\Exception $e) {
            echo "<p class='error'>Database Error: " . $e->getMessage() . "</p>";
        }
        
        echo "<hr>";
        echo "<h2>Test Password Verification</h2>";
        echo "<form method='post' action='" . base_url('/password-debug/test') . "'>";
        echo "<label>Username:</label><br>";
        echo "<input type='text' name='username' required><br><br>";
        echo "<label>Password:</label><br>";
        echo "<input type='password' name='password' required><br><br>";
        echo "<button type='submit'>Test Login</button>";
        echo "</form>";
        
        echo "<hr>";
        echo "<h2>Reset Specific User Password</h2>";
        echo "<form method='post' action='" . base_url('/password-debug/reset') . "'>";
        echo "<label>Username:</label><br>";
        echo "<input type='text' name='username' value='chavy' required><br><br>";
        echo "<label>New Password:</label><br>";
        echo "<input type='password' name='new_password' value='password123' required><br><br>";
        echo "<button type='submit'>Reset Password</button>";
        echo "</form>";
    }
    
    public function test()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        echo "<h1>Password Test Results</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;background:#e8f5e8;padding:10px;} .error{color:red;background:#ffe8e8;padding:10px;} .info{color:blue;background:#e8f0ff;padding:10px;}</style>";
        
        // Step 1: Check if user exists
        $user = $this->userModel->where('username', $username)->first();
        
        if (!$user) {
            echo "<div class='error'><strong>❌ User not found:</strong> {$username}</div>";
            echo "<a href='" . base_url('/password-debug') . "'>← Back</a>";
            return;
        }
        
        echo "<div class='info'><strong>✅ User found:</strong> {$username}</div>";
        echo "<div class='info'><strong>Stored hash:</strong> " . htmlspecialchars($user['password']) . "</div>";
        echo "<div class='info'><strong>Input password:</strong> " . htmlspecialchars($password) . "</div>";
        
        // Step 2: Test password verification
        $isValid = password_verify($password, $user['password']);
        
        if ($isValid) {
            echo "<div class='success'><strong>✅ PASSWORD VERIFICATION SUCCESS</strong><br>";
            echo "This password should work for login!</div>";
        } else {
            echo "<div class='error'><strong>❌ PASSWORD VERIFICATION FAILED</strong><br>";
            echo "The password does not match the stored hash.</div>";
            
            // Check if it's a plain text password
            if ($password === $user['password']) {
                echo "<div class='error'>⚠️ Password is stored as plain text! This needs to be hashed.</div>";
            }
        }
        
        // Step 3: Test using the model method
        $userFromModel = $this->userModel->verifyPassword($username, $password);
        
        if ($userFromModel) {
            echo "<div class='success'><strong>✅ MODEL VERIFICATION SUCCESS</strong><br>";
            echo "UserModel::verifyPassword() returned the user successfully.</div>";
        } else {
            echo "<div class='error'><strong>❌ MODEL VERIFICATION FAILED</strong><br>";
            echo "UserModel::verifyPassword() returned false.</div>";
        }
        
        echo "<br><a href='" . base_url('/password-debug') . "'>← Back</a>";
    }
    
    public function reset()
    {
        $username = $this->request->getPost('username');
        $newPassword = $this->request->getPost('new_password');
        
        echo "<h1>Password Reset Results</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;background:#e8f5e8;padding:10px;} .error{color:red;background:#ffe8e8;padding:10px;}</style>";
        
        try {
            $user = $this->userModel->where('username', $username)->first();
            
            if (!$user) {
                echo "<div class='error'>❌ User '{$username}' not found!</div>";
                echo "<a href='" . base_url('/password-debug') . "'>← Back</a>";
                return;
            }
            
            // Update password - the model will automatically hash it
            $this->userModel->update($user['id'], ['password' => $newPassword]);
            
            echo "<div class='success'>✅ Password updated successfully for user: {$username}</div>";
            echo "<div class='success'>New password: {$newPassword}</div>";
            echo "<div class='success'>Try logging in now!</div>";
            
        } catch (\Exception $e) {
            echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
        }
        
        echo "<br><a href='" . base_url('/password-debug') . "'>← Back</a>";
        echo "<br><a href='" . base_url('/auth/login') . "'>→ Go to Login</a>";
    }
}
?>