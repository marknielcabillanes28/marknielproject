<?php

namespace App\Controllers;

use App\Models\ActivityLogsModel;
use App\Models\IpBlockModel;

class ActivityLogs extends BaseController
{
    protected $activityLogsModel;
    protected $ipBlockModel;

    public function __construct()
    {
        $this->activityLogsModel = new ActivityLogsModel();
        $this->ipBlockModel = new IpBlockModel();
    }

    public function index()
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Activity Logs',
            'logs' => $this->activityLogsModel->getAllLogs(),
            'ipBlocks' => $this->ipBlockModel->getAllBlocks()
        ];

        return view('admin/activity_logs', $data);
    }

    public function block($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $result = $this->activityLogsModel->updateStatus($id, 'blocked');
        
        if ($result) {
            return redirect()->to('/admin/activity-logs')->with('success', 'User has been blocked successfully.');
        } else {
            return redirect()->to('/admin/activity-logs')->with('error', 'Failed to block user.');
        }
    }

    public function unblock($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $result = $this->activityLogsModel->updateStatus($id, 'active');
        
        if ($result) {
            return redirect()->to('/admin/activity-logs')->with('success', 'User has been unblocked successfully.');
        } else {
            return redirect()->to('/admin/activity-logs')->with('error', 'Failed to unblock user.');
        }
    }

    public function delete($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $result = $this->activityLogsModel->delete($id);
        
        if ($result) {
            return redirect()->to('/admin/activity-logs')->with('success', 'Activity log has been deleted successfully.');
        } else {
            return redirect()->to('/admin/activity-logs')->with('error', 'Failed to delete activity log.');
        }
    }

    public function blockIpRange()
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $fromIp = $this->request->getPost('from_ip');
        $toIp = $this->request->getPost('to_ip');
        $reason = $this->request->getPost('reason');
        $createdBy = session()->get('username');

        // Validate IPs
        if (!filter_var($fromIp, FILTER_VALIDATE_IP)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid FROM IP address']);
        }

        if (!filter_var($toIp, FILTER_VALIDATE_IP)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid TO IP address']);
        }

        // Convert IPs to long for comparison
        $fromIpLong = ip2long($fromIp);
        $toIpLong = ip2long($toIp);

        if ($fromIpLong > $toIpLong) {
            return $this->response->setJSON(['success' => false, 'message' => 'FROM IP must be less than or equal to TO IP']);
        }

        $result = $this->ipBlockModel->blockIpRange($fromIp, $toIp, $reason, $createdBy);
        
        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'IP range has been blocked successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to block IP range']);
        }
    }

    public function unblockIpRange($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $result = $this->ipBlockModel->unblockIpRange($id);
        
        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'IP range has been unblocked successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to unblock IP range']);
        }
    }

    public function deleteIpBlock($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $result = $this->ipBlockModel->delete($id);
        
        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'IP block has been deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete IP block']);
        }
    }
}