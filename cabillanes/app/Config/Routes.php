<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// -----------------------
// DEFAULT ROUTE
// -----------------------
$routes->get('/', 'Auth::login');     // When opening http://localhost:8080 → go to login page

// -----------------------
// AUTH ROUTES
// -----------------------
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/auth', 'Auth::auth');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/store', 'Auth::store');
$routes->get('/auth/logout', 'Auth::logout');

// -----------------------
// DASHBOARD
// -----------------------
$routes->get('/dashboard', 'Electronics::index');

// -----------------------
// ELECTRONICS CRUD
// -----------------------
$routes->get('/electronics', 'Electronics::index');
$routes->get('/electronics/create', 'Electronics::create');
$routes->post('/electronics/store', 'Electronics::store');
$routes->get('/electronics/edit/(:num)', 'Electronics::edit/$1');
$routes->post('/electronics/update/(:num)', 'Electronics::update/$1');
$routes->get('/electronics/delete/(:num)', 'Electronics::delete/$1');


$routes->get('/admin/dashboard', 'Dashboard::admin');
$routes->get('/user/dashboard', 'Dashboard::user');
//buy electronics  
$routes->get('/electronics/my-purchases', 'Electronics::myPurchases');
$routes->post('/electronics/buy/(:num)', 'Electronics::buy/$1');

// Dashboard Routes
$routes->get('/admin/dashboard', 'Dashboard::admin');
$routes->get('/user/dashboard', 'Dashboard::user');
$routes->get('/admin/toggle-maintenance', 'Dashboard::toggleMaintenance');

// Activity Logs Routes
$routes->get('/admin/activity-logs', 'ActivityLogs::index');
$routes->get('/admin/activity-logs/block/(:num)', 'ActivityLogs::block/$1');
$routes->get('/admin/activity-logs/unblock/(:num)', 'ActivityLogs::unblock/$1');
$routes->get('/admin/activity-logs/delete/(:num)', 'ActivityLogs::delete/$1');

// IP Blocking Routes
$routes->post('/admin/activity-logs/block-ip-range', 'ActivityLogs::blockIpRange');
$routes->post('/admin/activity-logs/unblock-ip-range/(:num)', 'ActivityLogs::unblockIpRange/$1');
$routes->post('/admin/activity-logs/delete-ip-block/(:num)', 'ActivityLogs::deleteIpBlock/$1');

// Debug Routes (remove in production)
$routes->get('/debug', 'Debug::index');
$routes->get('/debug/routes', 'Debug::routes');

// Password Reset Utility (remove in production)
$routes->get('/password-reset', 'PasswordReset::index');
$routes->post('/password-reset/convert', 'PasswordReset::convert');
$routes->post('/password-reset/create-test-user', 'PasswordReset::createTestUser');

// Status page
$routes->get('/status', function() {
    return view('status');
});

// Password Debug Utility (remove in production)
$routes->get('/password-debug', 'PasswordDebug::index');
$routes->post('/password-debug/test', 'PasswordDebug::test');
$routes->post('/password-debug/reset', 'PasswordDebug::reset');

// Database Check Utility (remove in production)
$routes->get('/database-check', 'DatabaseCheck::index');
$routes->post('/database-check/fix-username', 'DatabaseCheck::fixUsername');
$routes->post('/database-check/remove-duplicates', 'DatabaseCheck::removeDuplicates');

// Quick Fix Utility (remove in production)
$routes->get('/quick-fix', 'QuickFix::index');
$routes->post('/quick-fix/hash-all-passwords', 'QuickFix::hashAllPasswords');

// Test Login Utility (remove in production)
$routes->get('/test-login', 'TestLogin::index');
$routes->post('/test-login/authenticate', 'TestLogin::authenticate');
$routes->post('/test-login/hash-passwords', 'TestLogin::hashPasswords');
$routes->post('/test-login/create-test-user', 'TestLogin::createTestUser');
$routes->post('/test-login/fix-user-password', 'TestLogin::fixUserPassword');

// Maintenance Test Utility (remove in production)
$routes->get('/maintenance-test', 'MaintenanceTest::index');

// Force Maintenance Mode Utility (remove in production)
$routes->get('/force-maintenance', 'ForceMaintenanceMode::index');
$routes->post('/force-maintenance/destroy-user-sessions', 'ForceMaintenanceMode::destroyUserSessions');
$routes->post('/force-maintenance/force-maintenance-on', 'ForceMaintenanceMode::forceMaintenanceOn');
$routes->get('admin/reports', 'Reports::index');
$routes->get('admin/reports/export', 'Reports::exportCsv');
$routes->get('admin/users', 'AdminUsers::index');
$routes->get('admin/users/export', 'AdminUsers::exportCsv');
