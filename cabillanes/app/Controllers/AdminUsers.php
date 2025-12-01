<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminUsers extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Only admin allowed
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // TRIPLE CHECK MAINTENANCE MODE
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
        $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
        if (file_exists($maintenanceFile)) {
            $fileMode = trim(file_get_contents($maintenanceFile));
            if ($fileMode === 'on') {
                $maintenance_mode = 'on';
            }
        }

        if ($maintenance_mode === 'on' && session()->get('role') !== 'admin') {
            if (session()->isStarted()) {
                session()->destroy();
            }
            $response = service('response');
            $response->setStatusCode(503);
            $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            return $response->setBody(view('maintenance'));
        }

        $data['users'] = $this->userModel->orderBy('id', 'DESC')->findAll();

        return view('admin/users', $data);
    }

    // ---------- NEW: Edit user form ----------
    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        return view('admin/user_edit', ['user' => $user]);
    }

    // ---------- NEW: Update user ----------
    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $username = $this->request->getPost('username');
        $role = $this->request->getPost('role');
        $password = $this->request->getPost('password'); // optional

        // basic validation
        if (empty($username)) {
            return redirect()->back()->with('error', 'Username is required.')->withInput();
        }

        // Prevent duplicate username (unless it's the same user)
        $existing = $this->userModel->where('username', $username)->first();
        if ($existing && $existing['id'] != $id) {
            return redirect()->back()->with('error', 'Username already in use.')->withInput();
        }

        $data = [
            'username' => $username,
            'role' => $role
        ];

        if (!empty($password)) {
            // let the model handle hashing if set in the model; otherwise hash here
            $data['password'] = $password;
        }

        try {
            $this->userModel->update($id, $data);
            return redirect()->to('/admin/users')->with('success', 'User updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user.')->withInput();
        }
    }

    // ---------- NEW: Delete user ----------
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // protect current admin from deleting themselves accidentally
        if ($id == session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'You cannot delete your own account.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        try {
            $this->userModel->delete($id);
            return redirect()->to('/admin/users')->with('success', 'User deleted.');
        } catch (\Exception $e) {
            return redirect()->to('/admin/users')->with('error', 'Failed to delete user.');
        }
    }

    // ---------- NEW: Export users to CSV ----------
    public function exportCsv()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // TRIPLE CHECK MAINTENANCE MODE
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
        $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
        if (file_exists($maintenanceFile)) {
            $fileMode = trim(file_get_contents($maintenanceFile));
            if ($fileMode === 'on') {
                $maintenance_mode = 'on';
            }
        }

        if ($maintenance_mode === 'on' && session()->get('role') !== 'admin') {
            if (session()->isStarted()) {
                session()->destroy();
            }
            $response = service('response');
            $response->setStatusCode(503);
            $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            return $response->setBody(view('maintenance'));
        }

        $users = $this->userModel->orderBy('id', 'DESC')->findAll();

        // Build CSV in memory
        $filename = 'users_' . date('Ymd_His') . '.csv';
        $handle = fopen('php://memory', 'w');

        // Header row - adjust fields if your users table differs
        fputcsv($handle, ['ID', 'Username', 'Role', 'Email', 'Created At']);

        foreach ($users as $u) {
            fputcsv($handle, [
                $u['id'] ?? '',
                $u['username'] ?? '',
                $u['role'] ?? '',
                $u['email'] ?? '',
                $u['created_at'] ?? ''
            ]);
        }

        fseek($handle, 0);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }
}