<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'John Doe',
                'ip_address' => '192.168.1.100',
                'mac_address' => '00:1B:44:11:3A:B7',
                'action' => 'login',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'name' => 'Jane Smith',
                'ip_address' => '192.168.1.101',
                'mac_address' => '00:1B:44:11:3A:B8',
                'action' => 'logout',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'name' => 'Mike Johnson',
                'ip_address' => '192.168.1.102',
                'mac_address' => '00:1B:44:11:3A:B9',
                'action' => 'failed_login',
                'status' => 'blocked',
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
            ],
            [
                'name' => 'Sarah Wilson',
                'ip_address' => '192.168.1.103',
                'mac_address' => '00:1B:44:11:3A:C0',
                'action' => 'login',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-15 minutes')),
            ],
            [
                'name' => 'Admin User',
                'ip_address' => '192.168.1.1',
                'mac_address' => '00:1B:44:11:3A:C1',
                'action' => 'admin_login',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 minutes')),
            ],
        ];

        // Insert sample data
        $this->db->table('activity_logs')->insertBatch($data);
    }
}