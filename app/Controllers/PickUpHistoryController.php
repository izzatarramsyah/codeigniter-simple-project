<?php

namespace App\Controllers;
use App\Models\PickUpModel;
use App\Models\PickUpDetailModel;
use \Datetime;

class PickUpHistoryController extends BaseController  {

    public function index ()  {
        $data['pageTitle'] = 'Pick Up History';
        $data['menu'] = 'pickupHistory';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            return  view('view_modal/modal_detail_order')
            . view('view_modal/modal_detail_pickup')
            . view('view_modal/modal_detail_product')
            . view('view_menu/view_pick_up_history', $data);
        }
    }

    public function getListPickUp () {
        $pickUpModel = new PickUpModel();
        $dataUser = array_values(session("dataUser"));
        return $this->response->setJSON([
            "object" => $pickUpModel->getListPickUp($dataUser[0]["id"])
        ]);
    }

    public function updatePickupStatus () {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $dataUser = array_values(session("dataUser"));
        $dt = date("Y-m-d H:i:s");
        $pickUpModel = new PickUpModel();
        $pickUpDetailModel = new PickUpDetailModel();
        $data = [
            "status" => $status,
            "lastupd_dtm" => $dt,
            "lastupd_by" => $dataUser[0]["username"]
        ];
        $pickUpModel->updatePickupStatus($id, $data);
        $seq = $pickUpDetailModel->getSequnce($id);
        $detail = [
            "pick_up_id" => $id,
            "sequence" => (intval($seq[0]->pick_up_id)+1),
            "status" => $status,
            "created_by" => $dataUser[0]["username"]
        ];
        $pickUpDetailModel->savePickUpDetail($detail);
        return $this->response->setJSON([
            "message" => "Sucess updated status pick up"
        ]);
    }

}