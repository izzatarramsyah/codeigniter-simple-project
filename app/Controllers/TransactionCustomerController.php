<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\MstProductModel;
use App\Models\ProductInModel;
use App\Models\InventoryModel;
use App\Models\SellModel;
use App\Models\SellDetailModel;
use \Datetime;

class TransactionCustomerController extends BaseController 
{
    public function index() {
        $data['pageTitle'] = 'Info Transaction';
        $data['menu'] = 'transactionCustomer';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            return view('view_modal/modal_detail_order')
                . view('view_modal/modal_detail_pickup')
                .view('view_menu/view_transaction_customer', $data);
        }
    }

    public function getTransactionCustomer() {
        $transactionId = $this->request->getPost('transactionId');
        $startDate = $this->request->getPost('startDate');
        $endDate = $this->request->getPost('endDate');
        $session = session();
        $data = array_values(session('dataUser'));
        try {
            $orderModel = new OrderModel();
            if ( $transactionId == null || $transactionId == '' ) {
                return $this->response->setJSON([
                    'object' => $orderModel->getOrder($data[0]['id'], $startDate, $endDate)
                ]);
            } else {
                return $this->response->setJSON([
                    'object' => $orderModel->getOrderByID($data[0]['id'], $transactionId)
                ]);
            }
           
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function receiveOrder() {
       
        $session = session();
        $dataUser = array_values(session('dataUser'));
        $orderId = $this->request->getPost('orderId');
        $inventoryModel = new InventoryModel();
        $mstProductModel = new MstProductModel();
        $orderModel = new OrderModel();

        try {

            $orderDetail = $orderModel->getOrderDetail($orderId);
            $total_price = 0;
            for ($i = 0; $i < count($orderDetail); $i++) {

                $inv = [
                    "user_id" => $dataUser[0]["id"],
                    "product_code" => $orderDetail[$i]->product_code,
                    "ttl_units" =>  (int) $orderDetail[$i]->quantity,
                    "remaining_units" =>  (int) $orderDetail[$i]->quantity,
                    "created_by" => $dataUser[0]["username"]
                ];
                $checkInv = $inventoryModel->checkInventory($dataUser[0]["id"], $orderDetail[$i]->product_code);
                if ( $checkInv == null ) {
                    $inventoryModel->saveInventory($inv);
                } else {
                    $ttl_units = (int) $checkInv[0]->ttl_units + (int) $orderDetail[$i]->quantity;
                    $remaining_units = (int) $checkInv[0]->remaining_units + (int) $orderDetail[$i]->quantity;
                    $inventoryModel->updateInventory($dataUser[0]["id"], $orderDetail[$i]->product_code, 
                        $ttl_units, $remaining_units);
                }

                $product = $mstProductModel->getProduct($orderDetail[$i]->product_code);
                $mstProductModel->updateQtyProduct( ($product[0]->quantity - (int) $orderDetail[$i]->quantity), $orderDetail[$i]->product_code);
    
            }

            $dt = date("Y-m-d H:i:s");
            $data = [
                "status" => 'Completed. Order Received.',
                "lastupd_dtm" => $dt,
                "lastupd_by" => $dataUser[0]["username"]
            ];
            $orderModel->updateOrder($orderId, $data);
            return $this->response->setJSON([
                'message' => 'Success update order to received'
            ]);
        }catch (\Exception $e) {
            echo $e->getMessage();
            return $this->response->setJSON([
                'message' => 'failed'
            ]);
        }
    }

}
