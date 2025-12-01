<?php

namespace App\Controllers;

class MaintenanceTest extends BaseController
{
    public function index()
    {
        echo "<h1>🛠️ Maintenance Mode Test</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .box{background:#f8f9fa;padding:15px;margin:10px 0;border-left:4px solid #007bff;border-radius:5px;} .success{border-color:#28a745;background:#d4f6d4;} .error{border-color:#dc3545;background:#f8d7da;} .warning{border-color:#ffc107;background:#fff3cd;} .info{border-color:#17a2b8;background:#d1ecf1;} .btn{background:#007bff;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;margin:5px;display:inline-block;} .btn:hover{background:#0056b3;}</style>";
        
        // Current session info
        echo "<div class='box info'>";
        echo "<h3>📋 Current Session Info:</h3>";
        echo "<p><strong>User:</strong> " . (session()->get('username') ?? 'Not logged in') . "</p>";
        echo "<p><strong>Role:</strong> " . (session()->get('role') ?? 'None') . "</p>";
        echo "<p><strong>Logged In:</strong> " . (session()->get('isLoggedIn') ? 'Yes' : 'No') . "</p>";
        echo "<p><strong>Maintenance Mode:</strong> " . (session()->get('maintenance_mode') ?? 'off') . "</p>";
        echo "</div>";
        
        // Maintenance status
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
        $userRole = session()->get('role');
        
        if ($maintenance_mode === 'on') {
            if ($userRole === 'admin') {
                echo "<div class='box warning'>";
                echo "<h3>⚠️ Maintenance Mode: ON</h3>";
                echo "<p>You're an admin, so you can access the system during maintenance.</p>";
                echo "<p>Regular users should see the maintenance page.</p>";
                echo "</div>";
            } else {
                echo "<div class='box error'>";
                echo "<h3>🚨 ERROR: You shouldn't see this!</h3>";
                echo "<p>Maintenance mode is ON but you're accessing the system as a non-admin user.</p>";
                echo "<p>The maintenance filter is not working properly.</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='box success'>";
            echo "<h3>✅ Maintenance Mode: OFF</h3>";
            echo "<p>System is operating normally.</p>";
            echo "</div>";
        }
        
        // Test links for different user types
        echo "<div class='box'>";
        echo "<h3>🧪 Test Links:</h3>";
        echo "<p>Try accessing these URLs as different users when maintenance is ON:</p>";
        echo "<ul>";
        echo "<li><a href='" . base_url('/user/dashboard') . "' target='_blank'>User Dashboard</a> - Should show maintenance page for users</li>";
        echo "<li><a href='" . base_url('/admin/dashboard') . "' target='_blank'>Admin Dashboard</a> - Should work for admins</li>";
        echo "<li><a href='" . base_url('/electronics') . "' target='_blank'>Electronics</a> - Should show maintenance page for users</li>";
        echo "<li><a href='" . base_url('/auth/login') . "' target='_blank'>Login Page</a> - Should always work</li>";
        echo "</ul>";
        echo "</div>";
        
        // Instructions
        echo "<div class='box info'>";
        echo "<h3>📝 Testing Instructions:</h3>";
        echo "<ol>";
        echo "<li><strong>As Admin:</strong> Login as admin, enable maintenance mode</li>";
        echo "<li><strong>Open new browser/incognito:</strong> Try to login as regular user</li>";
        echo "<li><strong>Expected:</strong> User should see maintenance page when accessing system</li>";
        echo "<li><strong>Admin can:</strong> Still access everything normally</li>";
        echo "</ol>";
        echo "</div>";
        
        // Quick actions
        echo "<div class='box'>";
        echo "<h3>⚡ Quick Actions:</h3>";
        if ($userRole === 'admin') {
            $toggleText = $maintenance_mode === 'on' ? 'Turn OFF Maintenance' : 'Turn ON Maintenance';
            $toggleUrl = base_url('/admin/toggle-maintenance');
            echo "<a href='{$toggleUrl}' class='btn'>{$toggleText}</a>";
        }
        echo "<a href='" . base_url('/auth/logout') . "' class='btn'>Logout</a>";
        echo "<a href='" . base_url('/auth/login') . "' class='btn'>Login Page</a>";
        echo "</div>";
        
        // Debug info
        echo "<div class='box'>";
        echo "<h3>🔍 Debug Info:</h3>";
        echo "<p><strong>Current URL:</strong> " . current_url() . "</p>";
        echo "<p><strong>Base URL:</strong> " . base_url() . "</p>";
        echo "<p><strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] ?? 'Unknown' . "</p>";
        echo "<p><strong>Filter Status:</strong> MaintenanceFilter should be running globally</p>";
        echo "</div>";
    }
}
?>