<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogsModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'ip_address', 'mac_address', 'action', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllLogs($limit = null)
    {
        if ($limit) {
            return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
        }
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    public function addLog($name, $ip_address, $mac_address, $action = 'login')
    {
        return $this->insert([
            'name' => $name,
            'ip_address' => $ip_address,
            'mac_address' => $mac_address,
            'action' => $action,
            'status' => 'active'
        ]);
    }
}