<?php

namespace App\Controllers;

class PasswordReset extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }
    
    public function index()
    {
        echo "<h1>Password Reset Utility</h1>";
        echo "<p>This tool will convert all plain text passwords to hashed passwords.</p>";
        echo "<form method='post' action='" . base_url('/password-reset/convert') . "'>";
        echo "<button type='submit' onclick=\"return confirm('Are you sure? This will hash all existing passwords!')\">Convert Passwords</button>";
        echo "</form>";
        
        echo "<hr>";
        echo "<h2>Create Test User</h2>";
        echo "<form method='post' action='" . base_url('/password-reset/create-test-user') . "'>";
        echo "<label>Username:</label><br>";
        echo "<input type='text' name='username' value='testuser' required><br><br>";
        echo "<label>Password:</label><br>";
        echo "<input type='password' name='password' value='password123' required><br><br>";
        echo "<label>Role:</label><br>";
        echo "<select name='role'>";
        echo "<option value='user'>User</option>";
        echo "<option value='admin'>Admin</option>";
        echo "</select><br><br>";
        echo "<button type='submit'>Create Test User</button>";
        echo "</form>";
    }
    
    public function convert()
    {
        try {
            $users = $this->userModel->findAll();
            $converted = 0;
            
            foreach ($users as $user) {
                // Check if password is already hashed (hashed passwords start with $2y$)
                if (!str_starts_with($user['password'], '$2y$')) {
                    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
                    $this->userModel->update($user['id'], ['password' => $hashedPassword]);
                    $converted++;
                }
            }
            
            echo "<h1>Password Conversion Complete</h1>";
            echo "<p>Converted {$converted} passwords to hashed format.</p>";
            echo "<a href='" . base_url('/auth/login') . "'>Go to Login</a>";
            
        } catch (\Exception $e) {
            echo "<h1>Error</h1>";
            echo "<p>Error converting passwords: " . $e->getMessage() . "</p>";
        }
    }
    
    public function createTestUser()
    {
        try {
            $data = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'), // Will be hashed by model
                'role' => $this->request->getPost('role')
            ];
            
            $this->userModel->insert($data);
            
            echo "<h1>Test User Created</h1>";
            echo "<p>Username: " . $data['username'] . "</p>";
            echo "<p>Password: " . $this->request->getPost('password') . "</p>";
            echo "<p>Role: " . $data['role'] . "</p>";
            echo "<a href='" . base_url('/auth/login') . "'>Go to Login</a>";
            
        } catch (\Exception $e) {
            echo "<h1>Error</h1>";
            echo "<p>Error creating user: " . $e->getMessage() . "</p>";
        }
    }
}
?>