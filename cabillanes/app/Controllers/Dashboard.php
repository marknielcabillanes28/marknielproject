<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // Get maintenance mode from session, default 'off'
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';

        return view('admin/dashboard', ['maintenance_mode' => $maintenance_mode]);
    }

    public function toggleMaintenance()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $current = session()->get('maintenance_mode') ?? 'off';
        $new = ($current === 'on') ? 'off' : 'on';

        // Update session
        session()->set('maintenance_mode', $new);
        
        // Update file backup
        $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
        file_put_contents($maintenanceFile, $new);
        
        // Update database - system_settings table
        $db = \Config\Database::connect();
        $db->table('system_settings')->where('id', 1)->update([
            'maintenance_mode' => ($new === 'on') ? 1 : 0
        ]);
        
        // Update database - maintenance table
        $db->table('maintenance')->where('id', 1)->update([
            'status' => ($new === 'on') ? 'maintenance' : 'online'
        ]);

        $message = ($new === 'on') 
            ? '🛠 Maintenance mode is now ENABLED. Users cannot access the system.' 
            : '✅ Maintenance mode is now DISABLED. System is back online.';

        return redirect()->to('/admin/dashboard')->with('status', $message);
    }

    public function user()
    {
        // TRIPLE CHECK MAINTENANCE MODE - NUCLEAR OPTION
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
        
        // Check file backup too
        $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
        if (file_exists($maintenanceFile)) {
            $fileMode = trim(file_get_contents($maintenanceFile));
            if ($fileMode === 'on') {
                $maintenance_mode = 'on';
            }
        }
        
        $userRole = session()->get('role') ?? 'none';
        
        // LOG EVERYTHING FOR DEBUG
        error_log("Dashboard::user() - Mode: {$maintenance_mode}, Role: {$userRole}");
        
        // IF MAINTENANCE IS ON AND NOT ADMIN - BLOCK IMMEDIATELY
        if ($maintenance_mode === 'on' && $userRole !== 'admin') {
            error_log("Dashboard::user() - *** BLOCKING USER *** - Maintenance ON");
            
            // Clear session if started
            if (session()->isStarted()) {
                session()->destroy();
            }
            
            // Return maintenance view with headers
            $response = service('response');
            $response->setStatusCode(503);
            $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            return $response->setBody(view('maintenance'));
        }
        
        if ($userRole !== 'user') {
            return redirect()->to('/auth/login');
        }

        return view('user/dashboard');
    }
}
