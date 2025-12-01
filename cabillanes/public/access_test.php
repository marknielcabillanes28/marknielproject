<?php
// Direct Access Test
echo "<h1>Direct Access Test</h1>";
echo "<p>Current URL: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";

echo "<h2>File System Check:</h2>";
echo "<ul>";
echo "<li>Current Directory: " . getcwd() . "</li>";
echo "<li>Index.php exists: " . (file_exists('index.php') ? 'YES' : 'NO') . "</li>";
echo "<li>App directory exists: " . (file_exists('../app') ? 'YES' : 'NO') . "</li>";
echo "<li>System directory exists: " . (file_exists('../system') ? 'YES' : 'NO') . "</li>";
echo "</ul>";

echo "<h2>Access Methods:</h2>";
echo "<p><strong>Method 1 - Direct CodeIgniter (Recommended):</strong></p>";
echo "<a href='http://192.168.15.15/cabillanes/public/index.php/auth/login'>http://192.168.15.15/cabillanes/public/index.php/auth/login</a><br>";
echo "<a href='http://192.168.15.15/cabillanes/public/index.php/auth/register'>http://192.168.15.15/cabillanes/public/index.php/auth/register</a><br>";

echo "<p><strong>Method 2 - With URL Rewriting:</strong></p>";
echo "<a href='http://192.168.15.15/cabillanes/public/auth/login'>http://192.168.15.15/cabillanes/public/auth/login</a><br>";
echo "<a href='http://192.168.15.15/cabillanes/public/auth/register'>http://192.168.15.15/cabillanes/public/auth/register</a><br>";

echo "<h2>Test Links (Click to test):</h2>";
echo "<a href='index.php/auth/login' style='display:block; padding:10px; background:#f0f0f0; margin:5px;'>Test Login (Method 1)</a>";
echo "<a href='auth/login' style='display:block; padding:10px; background:#e0e0e0; margin:5px;'>Test Login (Method 2)</a>";
?>