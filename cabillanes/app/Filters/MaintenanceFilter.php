<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // AGGRESSIVE MAINTENANCE CHECK - Multiple sources (session, file, database)
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
        
        // Check from file backup
        $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
        if (file_exists($maintenanceFile)) {
            $fileMode = trim(file_get_contents($maintenanceFile));
            if ($fileMode === 'on') {
                $maintenance_mode = 'on';
                session()->set('maintenance_mode', 'on'); // Sync session
            }
        }
        
        // Check from database - system_settings table
        $db = \Config\Database::connect();
        $systemSettings = $db->table('system_settings')->where('id', 1)->get()->getRow();
        if ($systemSettings && $systemSettings->maintenance_mode == 1) {
            $maintenance_mode = 'on';
            session()->set('maintenance_mode', 'on'); // Sync session
        }
        
        // Check from database - maintenance table (backup check)
        $maintenanceTable = $db->table('maintenance')->where('id', 1)->get()->getRow();
        if ($maintenanceTable && $maintenanceTable->status === 'maintenance') {
            $maintenance_mode = 'on';
            session()->set('maintenance_mode', 'on'); // Sync session
        }
        
        $userRole = session()->get('role') ?? 'none';
        $username = session()->get('username') ?? 'none';
        
        // FORCE LOG EVERY REQUEST
        error_log("MAINTENANCE_FILTER: Mode={$maintenance_mode}, User={$username}, Role={$userRole}, URI=" . $request->getUri()->getPath());
        
        // If maintenance is ON and user is NOT admin - BLOCK IMMEDIATELY
        if ($maintenance_mode === 'on' && $userRole !== 'admin') {
            
            $uri = $request->getUri();
            $path = $uri->getPath();
            
            // Clean path
            $path = str_replace('/cabillanes/public/index.php', '', $path);
            $path = str_replace('/cabillanes/public', '', $path);
            $path = ltrim($path, '/');
            
            // VERY RESTRICTIVE - Only allow login/logout and root
            $allowedPaths = [
                'auth/login',
                'auth/logout',
                'auth/auth',
                'maintenance'
            ];
            
            $isAllowed = false;
            
            // Allow empty path (root)
            if ($path === '' || $path === '/') {
                $isAllowed = true;
            } else {
                // Check if path matches allowed paths exactly or starts with them
                foreach ($allowedPaths as $allowed) {
                    if ($path === $allowed || strpos($path, $allowed . '/') === 0) {
                        $isAllowed = true;
                        break;
                    }
                }
            }
            
            error_log("MAINTENANCE_FILTER: BLOCKING CHECK - Path='{$path}', Allowed=" . ($isAllowed ? 'YES' : 'NO'));
            
            if (!$isAllowed) {
                error_log("MAINTENANCE_FILTER: *** BLOCKING USER *** - Path: {$path}");
                
                // Return maintenance page with 503 status
                $response = service('response');
                $response->setStatusCode(503);
                $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
                $response->setHeader('Pragma', 'no-cache');
                $response->setHeader('Expires', '0');
                $response->setBody(view('maintenance'));
                return $response;
            } else {
                error_log("MAINTENANCE_FILTER: ALLOWING - Path '{$path}' is permitted");
            }
        } else {
            if ($maintenance_mode === 'off') {
                error_log("MAINTENANCE_FILTER: SKIP - Maintenance is OFF");
            } else if ($userRole === 'admin') {
                error_log("MAINTENANCE_FILTER: SKIP - User is ADMIN");
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}
?>