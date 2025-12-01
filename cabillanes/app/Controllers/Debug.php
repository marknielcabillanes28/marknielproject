<?php

namespace App\Controllers;

class Debug extends BaseController
{
    public function index()
    {
        echo "<h1>Debug Information</h1>";
        echo "<h2>Session Data:</h2>";
        echo "<pre>";
        print_r(session()->get());
        echo "</pre>";
        
        echo "<h2>Base URL:</h2>";
        echo "<p>" . base_url() . "</p>";
        
        echo "<h2>Current URL:</h2>";
        echo "<p>" . current_url() . "</p>";
        
        echo "<h2>Server Info:</h2>";
        echo "<pre>";
        echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'] . "\n";
        echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
        echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "\n";
        echo "</pre>";
        
        echo "<h2>Database Test:</h2>";
        try {
            $db = \Config\Database::connect();
            echo "<p style='color: green;'>✅ Database connection successful</p>";
            
            // Test if users table exists
            $query = $db->query("SELECT COUNT(*) as count FROM users");
            $result = $query->getRow();
            echo "<p>Users in database: " . $result->count . "</p>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
        }
    }
    
    public function routes()
    {
        echo "<h1>Available Routes</h1>";
        echo "<ul>";
        echo "<li><a href='" . base_url('/auth/login') . "'>Login</a></li>";
        echo "<li><a href='" . base_url('/auth/register') . "'>Register</a></li>";
        echo "<li><a href='" . base_url('/user/dashboard') . "'>User Dashboard</a></li>";
        echo "<li><a href='" . base_url('/admin/dashboard') . "'>Admin Dashboard</a></li>";
        echo "<li><a href='" . base_url('/electronics') . "'>Electronics</a></li>";
        echo "</ul>";
    }
}
?>