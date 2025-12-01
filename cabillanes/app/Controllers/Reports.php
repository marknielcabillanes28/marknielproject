<?php


namespace App\Controllers;

class Reports extends BaseController
{
    protected function ensureAdminAndNotMaintenance()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // triple-check maintenance file/session
        $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
        $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
        if (file_exists($maintenanceFile)) {
            $fileMode = trim(file_get_contents($maintenanceFile));
            if ($fileMode === 'on') {
                $maintenance_mode = 'on';
            }
        }

        if ($maintenance_mode === 'on' && session()->get('role') !== 'admin') {
            if (session()->isStarted()) {
                session()->destroy();
            }
            $response = service('response');
            $response->setStatusCode(503);
            $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            return $response->setBody(view('maintenance'));
        }

        return null;
    }

    public function index()
    {
        // role/maintenance guard
        $guard = $this->ensureAdminAndNotMaintenance();
        if ($guard instanceof \CodeIgniter\HTTP\ResponseInterface) {
            return $guard;
        } elseif ($guard !== null) {
            return $guard;
        }

        $db = \Config\Database::connect();
        $builder = $db->table('purchases')
            ->select('purchases.*, electronics.name AS electronic_name, electronics.brand AS electronic_brand, users.username AS buyer')
            ->join('electronics', 'electronics.id = purchases.electronic_id', 'left')
            ->join('users', 'users.id = purchases.user_id', 'left')
            ->orderBy('purchases.id', 'DESC');

        // optional filters
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        if ($start) {
            $builder->where('purchases.created_at >=', $start . ' 00:00:00');
        }
        if ($end) {
            $builder->where('purchases.created_at <=', $end . ' 23:59:59');
        }

        $results = $builder->get()->getResultArray();

        $totalTransactions = count($results);
        $totalItemsSold = 0;
        foreach ($results as $r) {
            $totalItemsSold += (int) ($r['quantity'] ?? 0);
        }

        return view('admin/reports', [
            'reports' => $results,
            'total_transactions' => $totalTransactions,
            'total_items_sold' => $totalItemsSold,
            'start_date' => $start,
            'end_date' => $end
        ]);
    }

    public function exportCsv()
    {
        // role/maintenance guard
        $guard = $this->ensureAdminAndNotMaintenance();
        if ($guard instanceof \CodeIgniter\HTTP\ResponseInterface) {
            return $guard;
        } elseif ($guard !== null) {
            return $guard;
        }

        $db = \Config\Database::connect();
        $builder = $db->table('purchases')
            ->select('purchases.*, electronics.name AS electronic_name, electronics.brand AS electronic_brand, users.username AS buyer')
            ->join('electronics', 'electronics.id = purchases.electronic_id', 'left')
            ->join('users', 'users.id = purchases.user_id', 'left')
            ->orderBy('purchases.id', 'DESC');

        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        if ($start) {
            $builder->where('purchases.created_at >=', $start . ' 00:00:00');
        }
        if ($end) {
            $builder->where('purchases.created_at <=', $end . ' 23:59:59');
        }

        $rows = $builder->get()->getResultArray();

        // build CSV
        $filename = 'reports_' . date('Ymd_His') . '.csv';
        $csv = fopen('php://memory', 'w');
        fputcsv($csv, ['ID','Buyer','Electronic','Brand','Quantity','Purchased At']);
        foreach ($rows as $r) {
            fputcsv($csv, [
                $r['id'],
                $r['buyer'] ?? '',
                $r['electronic_name'] ?? '',
                $r['electronic_brand'] ?? '',
                $r['quantity'] ?? 0,
                $r['created_at'] ?? ''
            ]);
        }
        fseek($csv, 0);
        $content = stream_get_contents($csv);
        fclose($csv);

        return $this->response->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }
}