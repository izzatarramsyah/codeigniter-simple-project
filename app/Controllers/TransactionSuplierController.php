<?php

namespace App\Controllers;

use App\Models\MstProductModel;
use App\Models\ProductInModel;
use App\Models\ProductOutModel;
use App\Models\PickUpDetailModel;
use App\Models\UserModel;
use Dompdf\Dompdf;

class TransactionSuplierController extends BaseController 
{
    public function index() {
        $data['pageTitle'] = 'Info Transaction';
        $data['menu'] = 'transactionSuplier';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            $data["dashboard"] = array_values(session("dashboard"));
            return view('view_modal/modal_detail_order')
                . view('view_modal/modal_detail_pickup')
                . view('view_modal/modal_detail_product')
                . view('view_menu/view_transaction_suplier', $data);
        }
    }

    public function getListPickUpDetail () {
        $pickUpDetailModel = new PickUpDetailModel();
        $pickupId = $this->request->getPost('pickupId');
        return $this->response->setJSON([
            "object" => $pickUpDetailModel->getListPickUpDetail($pickupId)
        ]);
    }

    public function getTransactionSuplier() {
        $trxType = $this->request->getPost('trxType');
        $startDate = $this->request->getPost('startDate');
        $endDate = $this->request->getPost('endDate');
        $session = session();
        $data = array_values(session('dataUser'));
        $result = [];
        try {
            if ( $trxType == 'stockIn' ) {
                $productInModel = new ProductInModel();
                $data = $productInModel->getListProductIn($startDate, $endDate);
                for ($i = 0; $i < count($data); $i++) {
                    $productCode = "'". $data[$i]->product_code ."'";
                    $temp = array(
                        'product_code' => '<a href="javascript:void(0); " onclick="openModalProductDetail(' . $productCode. ')">' . $data[$i]->product_code . '</a>',
                        'quantity' => $data[$i]->quantity,
                        'created_dtm' => $data[$i]->created_dtm
                    );   
                    array_push($result, $temp);
                }
            } else if ( $trxType == 'stockOut' ) {
                $productOutModel = new ProductOutModel();
                $data = $productOutModel->getListProductOut($startDate, $endDate);
                for ($i = 0; $i < count($data); $i++) {
                    $orderId = "'". $data[$i]->order_id."'";
                    $pickupId = "'". $data[$i]->pick_up_id."'";
                    $temp = array(
                        'order_id' => '<a href="javascript:void(0); " onclick="openModalOrderDetail(' . $orderId. ')">' . $data[$i]->order_id. '</a>',
                        'pick_up_id' => '<a href="javascript:void(0); " onclick="openModalPickupDetail(' . $pickupId . ')">' . $data[$i]->pick_up_id . '</a>',
                        'created_dtm' => $data[$i]->created_dtm
                    );   
                    array_push($result, $temp);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }      
        return $this->response->setJSON([
            'object' => $result
        ]);
    }

}