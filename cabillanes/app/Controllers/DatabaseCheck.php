<?php

namespace App\Controllers;

class DatabaseCheck extends BaseController
{
    public function index()
    {
        echo "<h1>Database Structure Check</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} table{border-collapse:collapse;} td,th{border:1px solid #ccc;padding:8px;}</style>";
        
        try {
            $db = \Config\Database::connect();
            
            // Check if users table exists
            echo "<h2>Users Table Structure:</h2>";
            $query = $db->query("DESCRIBE users");
            $fields = $query->getResultArray();
            
            echo "<table>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            foreach ($fields as $field) {
                echo "<tr>";
                echo "<td>" . $field['Field'] . "</td>";
                echo "<td>" . $field['Type'] . "</td>";
                echo "<td>" . $field['Null'] . "</td>";
                echo "<td>" . ($field['Key'] === 'UNI' ? '<span class="success">UNIQUE</span>' : $field['Key']) . "</td>";
                echo "<td>" . $field['Default'] . "</td>";
                echo "<td>" . $field['Extra'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Check for username uniqueness
            echo "<h2>Username Constraint Check:</h2>";
            $query = $db->query("SHOW INDEX FROM users WHERE Column_name = 'username'");
            $indexes = $query->getResultArray();
            
            if (!empty($indexes)) {
                echo "<div class='success'>✅ Username has indexes:</div>";
                foreach ($indexes as $index) {
                    echo "<p>Index: " . $index['Key_name'] . " (Unique: " . ($index['Non_unique'] == 0 ? 'Yes' : 'No') . ")</p>";
                }
            } else {
                echo "<div class='error'>❌ No unique constraint on username!</div>";
                echo "<p><strong>Fix needed:</strong> Add unique constraint to username field.</p>";
                echo "<form method='post' action='" . base_url('/database-check/fix-username') . "'>";
                echo "<button type='submit'>Add Unique Constraint to Username</button>";
                echo "</form>";
            }
            
            // Show current users
            echo "<h2>Current Users:</h2>";
            $query = $db->query("SELECT id, username, role, LEFT(password, 20) as password_preview FROM users ORDER BY id");
            $users = $query->getResultArray();
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Password Preview</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['username'] . "</td>";
                echo "<td>" . $user['role'] . "</td>";
                echo "<td>" . $user['password_preview'] . "...</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Check for duplicate usernames
            echo "<h2>Duplicate Username Check:</h2>";
            $query = $db->query("SELECT username, COUNT(*) as count FROM users GROUP BY username HAVING count > 1");
            $duplicates = $query->getResultArray();
            
            if (!empty($duplicates)) {
                echo "<div class='error'>❌ Duplicate usernames found:</div>";
                foreach ($duplicates as $dup) {
                    echo "<p>Username '{$dup['username']}' appears {$dup['count']} times</p>";
                }
                echo "<form method='post' action='" . base_url('/database-check/remove-duplicates') . "'>";
                echo "<button type='submit'>Remove Duplicate Users (Keep Latest)</button>";
                echo "</form>";
            } else {
                echo "<div class='success'>✅ No duplicate usernames found</div>";
            }
            
        } catch (\Exception $e) {
            echo "<div class='error'>❌ Database Error: " . $e->getMessage() . "</div>";
        }
    }
    
    public function fixUsername()
    {
        echo "<h1>Adding Unique Constraint to Username</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
        
        try {
            $db = \Config\Database::connect();
            
            // First remove any existing duplicates
            $this->removeDuplicates();
            
            // Then add unique constraint
            $db->query("ALTER TABLE users ADD UNIQUE KEY unique_username (username)");
            
            echo "<div class='success'>✅ Unique constraint added to username field!</div>";
            
        } catch (\Exception $e) {
            echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
        }
        
        echo "<br><a href='" . base_url('/database-check') . "'>← Back</a>";
    }
    
    public function removeDuplicates()
    {
        echo "<h1>Removing Duplicate Users</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
        
        try {
            $db = \Config\Database::connect();
            
            // Find duplicates
            $query = $db->query("
                SELECT username, MIN(id) as keep_id, COUNT(*) as count 
                FROM users 
                GROUP BY username 
                HAVING count > 1
            ");
            $duplicates = $query->getResultArray();
            
            if (empty($duplicates)) {
                echo "<div class='success'>✅ No duplicates to remove</div>";
                return;
            }
            
            $removed = 0;
            foreach ($duplicates as $dup) {
                // Delete all except the first one (lowest ID)
                $deleteQuery = $db->query("DELETE FROM users WHERE username = ? AND id != ?", 
                    [$dup['username'], $dup['keep_id']]);
                
                $deletedCount = $db->affectedRows();
                $removed += $deletedCount;
                
                echo "<p>Removed {$deletedCount} duplicate entries for username: {$dup['username']}</p>";
            }
            
            echo "<div class='success'>✅ Total duplicate users removed: {$removed}</div>";
            
        } catch (\Exception $e) {
            echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
        }
        
        echo "<br><a href='" . base_url('/database-check') . "'>← Back</a>";
    }
}
?>