<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ActivityLogsModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $activityLogsModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->activityLogsModel = new ActivityLogsModel();
        $this->session = session();
    }

    // Show login page
    public function login()
    {
        return view('auth/login');
    }

    // Handle login form
    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Debug: Log the attempt
        log_message('debug', "Login attempt - Username: {$username}");

        // Get user's IP address and generate a mock MAC address for demonstration
        $ipAddress = $this->request->getIPAddress();
        $macAddress = $this->generateMockMacAddress();

        // Debug: Check if user exists first
        $userExists = $this->userModel->where('username', $username)->first();
        if ($userExists) {
            log_message('debug', "User found in database: {$username}");
            log_message('debug', "Stored password hash: " . substr($userExists['password'], 0, 20) . "...");
        } else {
            log_message('debug', "User NOT found in database: {$username}");
        }

        $user = $this->userModel->verifyPassword($username, $password);

        if ($user) {
            // Log successful login
            $this->activityLogsModel->addLog(
                $user['username'],
                $ipAddress,
                $macAddress,
                $user['role'] === 'admin' ? 'admin_login' : 'login'
            );

            $this->session->set([
                'isLoggedIn' => true,
                'username'   => $user['username'],
                'user_id'    => $user['id'],
                'role'       => $user['role']
            ]);

            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/user/dashboard');
            }
        } else {
            // Log failed login attempt
            $this->activityLogsModel->addLog(
                $username ?: 'Unknown',
                $ipAddress,
                $macAddress,
                'failed_login'
            );

            $this->session->setFlashdata('error', 'Invalid username or password');
            return redirect()->to('/auth/login');
        }
    }

    // Logout
    public function logout()
    {
        // Log logout activity if user is logged in
        if ($this->session->get('isLoggedIn')) {
            $username = $this->session->get('username');
            $ipAddress = $this->request->getIPAddress();
            $macAddress = $this->generateMockMacAddress();
            
            $this->activityLogsModel->addLog(
                $username,
                $ipAddress,
                $macAddress,
                'logout'
            );
        }

        $this->session->destroy();
        return redirect()->to('/auth/login');
    }

    // Register page
    public function register()
    {
        return view('auth/register');
    }

    // Handle registration
    public function store()
{
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    $confirm  = $this->request->getPost('confirm_password');
    $role     = $this->request->getPost('role');

    if ($password !== $confirm) {
        $this->session->setFlashdata('error', 'Passwords do not match!');
        return redirect()->to('/auth/register');
    }

    // Check if username already exists
    $existingUser = $this->userModel->where('username', $username)->first();
    if ($existingUser) {
        $this->session->setFlashdata('error', 'Username already exists! Please choose a different username.');
        return redirect()->to('/auth/register');
    }

    try {
        $data = [
            'username' => $username,
            'password' => $password,
            'role'     => $role
        ];

        $this->userModel->save($data);
        return redirect()->to('/auth/login')->with('success', 'Account created successfully!');
    } catch (\Exception $e) {
        $this->session->setFlashdata('error', 'Registration failed. Please try again.');
        return redirect()->to('/auth/register');
    }
}

    // Helper method to generate a mock MAC address for demonstration purposes
    private function generateMockMacAddress()
    {
        // Generate a random MAC address for demonstration
        // In a real application, you would need to implement proper MAC address detection
        $mac = sprintf('%02x:%02x:%02x:%02x:%02x:%02x',
            rand(0, 255), rand(0, 255), rand(0, 255),
            rand(0, 255), rand(0, 255), rand(0, 255)
        );
        return strtoupper($mac);
    }

}
