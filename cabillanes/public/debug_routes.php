<?php
// Route Debug Script - Place this in public folder
require_once '../app/Config/Paths.php';

$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h1>CodeIgniter Route Debug</h1>";
echo "<p>Testing if CodeIgniter is working...</p>";

// Test basic routing
$routes = Config\Services::routes();
echo "<h2>Available Routes:</h2>";
echo "<pre>";
print_r($routes->getRoutes());
echo "</pre>";

echo "<h2>Quick Route Tests:</h2>";
echo "<ul>";
echo "<li><a href='" . base_url('/auth/login') . "'>Test Login Route</a></li>";
echo "<li><a href='" . base_url('/auth/register') . "'>Test Register Route</a></li>";
echo "<li><a href='" . base_url('/') . "'>Test Home Route</a></li>";
echo "</ul>";
?>