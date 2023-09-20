<?php

namespace App\Controllers;
use App\Models\ProductOutModel;
use App\Models\PickUpModel;
use App\Models\PickUpDetailModel;
use App\Models\OrderModel;
use \Datetime;

class PickUpOrderController extends BaseController  {

    public function index()  {
        $data['pageTitle'] = 'Pick Up Order';
        $data['menu'] = 'pickupOrder';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            return view('view_modal/modal_detail_order')
                .view('view_menu/view_pick_up_order', $data);
        }
    }

    public function getListPickUpOrder() {
        $productOutModel = new ProductOutModel();
        return $this->response->setJSON([
            "object" => $productOutModel->findAll()
        ]);
    }

    public function updateProductOut() {
        $id = $this->request->getPost('id');
        $dataUser = array_values(session("dataUser"));
        $now = new DateTime();
        $pickUpId =  'PICKUP' . $now->getTimestamp();
        $productOutModel = new ProductOutModel();
        if ( $productOutModel->updateProductOut($id, $pickUpId , $dataUser[0]["id"]) ) {
            $pickUpModel = new PickUpModel();
            $pickUpDetailModel = new PickUpDetailModel();
            $history = [
                "pick_up_id" => $pickUpId,
                "user_id" => $dataUser[0]["id"],
                "status" => 'On Progress',
                "created_by" => $dataUser[0]["username"],
            ];
            $pickUpModel->savePickUp($history);

            $historyDetail = [
                "pick_up_id" => $pickUpId,
                "sequence" => 1,
                "status" => 'Order Picked Up By ' . $dataUser[0]["username"],
                "created_by" => $dataUser[0]["username"],
            ];
            $pickUpDetailModel->savePickUpDetail($historyDetail);
            return $this->response->setJSON([
                'message' => 'Success Pick Up Order. Your Pick Up ID is : ' . $pickUpId
            ]);
        } else {
            return $this->response->setJSON([
                'message' => 'Failed Pick Up Order'
            ]);
        }
    }

}