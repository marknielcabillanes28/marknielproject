<?php

namespace App\Controllers;

use App\Models\ElectronicsModel;



class Electronics extends BaseController
{
    protected $electronicsModel;

    public function __construct()
    {
        $this->electronicsModel = new ElectronicsModel();
    }

    public function index()
{
    // TRIPLE CHECK MAINTENANCE MODE
    $maintenance_mode = session()->get('maintenance_mode') ?? 'off';
    $role = session()->get('role') ?? 'none';
    
    // Check file backup
    $maintenanceFile = WRITEPATH . 'maintenance_mode.txt';
    if (file_exists($maintenanceFile)) {
        $fileMode = trim(file_get_contents($maintenanceFile));
        if ($fileMode === 'on') {
            $maintenance_mode = 'on';
        }
    }
    
    error_log("Electronics::index() - Mode: {$maintenance_mode}, Role: {$role}");
    
    if ($maintenance_mode === 'on' && $role !== 'admin') {
        error_log("Electronics::index() - *** BLOCKING USER *** - Maintenance ON");
        
        // Clear session if started
        if (session()->isStarted()) {
            session()->destroy();
        }
        
        $response = service('response');
        $response->setStatusCode(503);
        $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        return $response->setBody(view('maintenance'));
    }

    $data['electronics'] = $this->electronicsModel->findAll();

    if ($role === 'admin') {
        return view('electronics/index', $data);
    } else {
        return view('electronics/user_index', $data);
    }
}


    public function create()
    {
        return view('electronics/create');
    }

    public function store()
    {
        $this->electronicsModel->save([
            'name'     => $this->request->getPost('name'),
            'brand'    => $this->request->getPost('brand'),
            'model'    => $this->request->getPost('model'),
            'quantity' => $this->request->getPost('quantity'),
            'status'   => $this->request->getPost('status'),
        ]);
        return redirect()->to('/electronics');
    }

    public function edit($id)
    {
        $data['electronic'] = $this->electronicsModel->find($id);
        return view('electronics/edit', $data);
    }

    public function update($id)
    {
        $this->electronicsModel->update($id, [
            'name'     => $this->request->getPost('name'),
            'brand'    => $this->request->getPost('brand'),
            'model'    => $this->request->getPost('model'),
            'quantity' => $this->request->getPost('quantity'),
            'status'   => $this->request->getPost('status'),
        ]);
        return redirect()->to('/electronics');
    }

    public function delete($id)
    {
        $this->electronicsModel->delete($id);
        return redirect()->to('/electronics');
    }


    public function buy($id)
{
    $userId = session()->get('user_id');
    $quantityToBuy = (int) $this->request->getPost('buy_quantity');

    // Fetch the item
    $item = $this->electronicsModel->find($id);

    if (!$item) {
        return redirect()->to('/electronics')->with('error', 'Item not found.');
    }

    if ($item['quantity'] < $quantityToBuy) {
        return redirect()->to('/electronics')->with('error', 'Not enough stock available.');
    }

    // Reduce stock
    $newQuantity = $item['quantity'] - $quantityToBuy;
    $this->electronicsModel->update($id, ['quantity' => $newQuantity]);

    // Log purchase
    $db = \Config\Database::connect();
    $builder = $db->table('purchases');
    $builder->insert([
        'user_id' => $userId,
        'electronic_id' => $id,
        'quantity' => $quantityToBuy
    ]);

    return redirect()->to('/electronics')->with('success', 'Purchase successful!');
}

public function myPurchases()
{
    $db = \Config\Database::connect();
    $userId = session()->get('user_id');

    $query = $db->table('purchases')
        ->select('purchases.*, electronics.name, electronics.brand, electronics.model')
        ->join('electronics', 'electronics.id = purchases.electronic_id')
        ->where('purchases.user_id', $userId)
        ->get();

    $data['purchases'] = $query->getResultArray();

    return view('electronics/my_purchases', $data);
}


}
