<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\IpBlockModel;

class IpBlockFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $ipBlockModel = new IpBlockModel();
        $userIp = $request->getIPAddress();
        
        // Check if IP is blocked
        if ($ipBlockModel->isIpBlocked($userIp)) {
            error_log("IP_BLOCK_FILTER: Blocking IP - {$userIp}");
            
            // Return 403 Forbidden response
            $response = service('response');
            $response->setStatusCode(403);
            $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->setBody(view('errors/html/error_403', [
                'message' => 'Your IP address has been blocked from accessing this system.'
            ]));
            
            return $response;
        }
        
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
