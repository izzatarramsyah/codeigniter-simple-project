<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use Dompdf\Dompdf;

class InventoryController extends BaseController {
    
    public function index()  {
        $data['pageTitle'] = 'List Inventory';
        $data['menu'] = 'listInventory';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            return view('view_menu/view_inventory', $data);
        }
    }

    public function getInventory() {
        $session = session();
        $user = array_values(session('dataUser'));
        try {
            $inventoryModel = new InventoryModel();
            return $this->response->setJSON([
                'object' => $inventoryModel->getInventory($user[0]['id'])
            ]);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}