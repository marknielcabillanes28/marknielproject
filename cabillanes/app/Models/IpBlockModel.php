<?php

namespace App\Models;

use CodeIgniter\Model;

class IpBlockModel extends Model
{
    protected $table            = 'ip_blocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['from_ip', 'to_ip', 'reason', 'status', 'created_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Check if an IP address is in a blocked range
     */
    public function isIpBlocked($ip)
    {
        $ipLong = ip2long($ip);
        
        if ($ipLong === false) {
            return false;
        }

        $blocks = $this->where('status', 'active')->findAll();
        
        foreach ($blocks as $block) {
            $fromIpLong = ip2long($block['from_ip']);
            $toIpLong = ip2long($block['to_ip']);
            
            if ($fromIpLong === false || $toIpLong === false) {
                continue;
            }
            
            // Check if IP is within range
            if ($ipLong >= $fromIpLong && $ipLong <= $toIpLong) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get all active IP blocks
     */
    public function getActiveBlocks()
    {
        return $this->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get all IP blocks (active and inactive)
     */
    public function getAllBlocks()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Block an IP range
     */
    public function blockIpRange($fromIp, $toIp, $reason = '', $createdBy = '')
    {
        // Validate IPs
        if (!filter_var($fromIp, FILTER_VALIDATE_IP) || !filter_var($toIp, FILTER_VALIDATE_IP)) {
            return false;
        }

        $data = [
            'from_ip'    => $fromIp,
            'to_ip'      => $toIp,
            'reason'     => $reason,
            'status'     => 'active',
            'created_by' => $createdBy
        ];

        return $this->insert($data);
    }

    /**
     * Unblock an IP range (soft delete by setting status to inactive)
     */
    public function unblockIpRange($id)
    {
        return $this->update($id, ['status' => 'inactive']);
    }
}
