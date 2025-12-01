<?php

namespace App\Controllers;

class ForceMaintenanceMode extends BaseController
{
    public function index()
    {
        echo "<h1>🚨 EMERGENCY MAINTENANCE MODE ENFORCER</h1>";
        echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5;} .box{background:white;padding:20px;margin:15px 0;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);} .error{background:#ffebee;border-left:5px solid #f44336;} .success{background:#e8f5e8;border-left:5px solid #4caf50;} .warning{background:#fff3e0;border-left:5px solid #ff9800;} .btn{background:#2196f3;color:white;padding:12px 20px;text-decoration:none;border-radius:4px;margin:5px;display:inline-block;} .btn-danger{background:#f44336;} .btn:hover{opacity:0.8;}</style>";
        
        // Check current status
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
        $user_role = session()->get('role') ?? 'none';
        $username = session()->get('username') ?? 'none';
        $is_logged_in = session()->get('isLoggedIn') ? 'yes' : 'no';
        
        echo "<div class='box error'>";
        echo "<h2>🔍 Current System Status</h2>";
        echo "<p><strong>Maintenance Mode:</strong> {$maintenance_mode}</p>";
        echo "<p><strong>Current User:</strong> {$username}</p>";
        echo "<p><strong>User Role:</strong> {$user_role}</p>";
        echo "<p><strong>Logged In:</strong> {$is_logged_in}</p>";
        echo "</div>";
        
        if ($maintenance_mode === 'on' && $user_role !== 'admin') {
            echo "<div class='box error'>";
            echo "<h2>❌ CRITICAL: NON-ADMIN USER ACCESSING DURING MAINTENANCE</h2>";
            echo "<p>This should NOT be happening! User '{$username}' is accessing the system during maintenance mode.</p>";
            echo "</div>";
        }
        
        // Nuclear option - force destroy all non-admin sessions
        echo "<div class='box warning'>";
        echo "<h2>⚡ EMERGENCY FIXES</h2>";
        echo "<form method='post' action='" . base_url('/force-maintenance/destroy-user-sessions') . "' style='display:inline;'>";
        echo "<button type='submit' class='btn btn-danger'>🔥 DESTROY ALL USER SESSIONS</button>";
        echo "</form>";
        
        echo "<form method='post' action='" . base_url('/force-maintenance/force-maintenance-on') . "' style='display:inline;'>";
        echo "<button type='submit' class='btn btn-danger'>🛠️ FORCE MAINTENANCE ON</button>";
        echo "</form>";
        echo "</div>";
        
        // Test links
        echo "<div class='box'>";
        echo "<h2>🧪 Test Links (Use These in Incognito/New Browser)</h2>";
        echo "<p>After applying fixes, test with these links:</p>";
        echo "<ul>";
        echo "<li><a href='" . base_url('/auth/login') . "' target='_blank'>Login as User (chavy/password)</a></li>";
        echo "<li><a href='" . base_url('/user/dashboard') . "' target='_blank'>User Dashboard (Should be BLOCKED)</a></li>";
        echo "<li><a href='" . base_url('/electronics') . "' target='_blank'>Electronics (Should be BLOCKED)</a></li>";
        echo "<li><a href='" . base_url('/admin/dashboard') . "' target='_blank'>Admin Dashboard (Should work for admin)</a></li>";
        echo "</ul>";
        echo "</div>";
    }
    
    public function destroyUserSessions()
    {
        echo "<h1>🔥 DESTROYING ALL USER SESSIONS</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;background:#e8f5e8;padding:15px;border-radius:5px;} .error{color:red;background:#ffebee;padding:15px;border-radius:5px;}</style>";
        
        try {
            // Method 1: Clear session files directory
            $sessionPath = WRITEPATH . 'session/';
            if (is_dir($sessionPath)) {
                $files = glob($sessionPath . '*');
                $deletedCount = 0;
                foreach($files as $file) {
                    if(is_file($file)) {
                        unlink($file);
                        $deletedCount++;
                    }
                }
                echo "<div class='success'>✅ Deleted {$deletedCount} session files from disk</div>";
            }
            
            // Method 2: Destroy current session
            session()->destroy();
            
            // Method 3: Clear any cached session data
            if (function_exists('apcu_clear_cache')) {
                apcu_clear_cache();
            }
            
            echo "<div class='success'>✅ All user sessions have been forcefully destroyed!</div>";
            echo "<div class='success'>✅ Session cache cleared!</div>";
            
        } catch (\Exception $e) {
            echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
        }
        
        echo "<br><a href='" . base_url('/force-maintenance') . "'>← Back</a>";
        echo "<br><a href='" . base_url('/auth/login') . "'>→ Test Login Now</a>";
        
        // Auto redirect after 3 seconds
        echo "<script>setTimeout(() => { window.location.href = '" . base_url('/force-maintenance') . "'; }, 3000);</script>";
    }
    
    public function forceMaintenanceOn()
    {
        echo "<h1>🛠️ FORCING MAINTENANCE MODE ON</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;background:#e8f5e8;padding:15px;border-radius:5px;}</style>";
        
        // Force maintenance mode on in session
        session()->set('maintenance_mode', 'on');
        
        // Also try to store it in a file as backup
        $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
        file_put_contents($maintenanceFile, 'on');
        
        echo "<div class='success'>✅ Maintenance mode FORCED ON!</div>";
        echo "<div class='success'>✅ Stored in session AND file backup!</div>";
        
        echo "<br><a href='" . base_url('/force-maintenance') . "'>← Back</a>";
        echo "<br><a href='" . base_url('/admin/dashboard') . "'>→ Admin Dashboard</a>";
    }
}
?>