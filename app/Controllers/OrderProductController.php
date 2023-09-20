<?php

namespace App\Controllers;

use App\Models\MstProductModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\InventoryModel;
use App\Models\UserModel;
use App\Models\ProductOutModel;
use \Datetime;

class OrderProductController extends BaseController {
    
    public function index() {
        $data["pageTitle"] = "Order Product";
        $data["menu"] = "orderProduct";
        $session = session();
        if ($session->has("dataUser")) {
            $data["dataUser"] = array_values(session("dataUser"));
            $data["profileMenu"] = array_values(session("profileMenu"));
            return view("view_menu/view_order_product", $data);
        }
    }

    public function getOrderDetail() {
        $orderId = $this->request->getPost('orderId');
        try {
            $orderModel = new OrderModel();
            return $this->response->setJSON([
                'object' => $orderModel->getOrderDetail($orderId)
            ]);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function orderProduct() {
        $now = new DateTime();
        $orderModel = new OrderModel();
        $orderDetailModel = new OrderDetailModel();
        $productOutModel = new ProductOutModel();
        $orderId = 'ORDER' . $now->getTimestamp();
        try {
            $cart = $this->request->getPost("cart");
            $dataUser = array_values(session("dataUser"));
            $data = [
                "user_id" => $dataUser[0]["id"],
                "order_id" => $orderId,
                "status" => "Waiting for Pick Up",
                "created_by" => $dataUser[0]["username"],
                "lastupd_by" => $dataUser[0]["username"],
            ];
            $date = new DateTime();               
            if ($orderModel->saveOrder($data)) {
                for ($i = 0; $i < count($cart); $i++) {
                    $detail = [
                        "order_id" => $orderId,
                        "product_code" => $cart[$i]["product_code"],
                        "quantity" => $cart[$i]["quantity"],
                        "total_price" => $cart[$i]["total_price"],
                        "created_by" => $dataUser[0]["username"],
                        "lastupd_by" => $dataUser[0]["username"],
                    ];
                    $orderDetailModel->saveOrderDetail($detail);
                }
                $productOut = [
                    "order_id" => $orderId,
                    "created_by" => $dataUser[0]["username"],
                    "lastupd_by" => $dataUser[0]["username"],
                ];
                $productOutModel->saveProductOut($productOut);
                $session = session();
                $session->remove('cart');
                return $this->response->setJSON([
                    "message" => 'Order success. Your transaction ID is : ' . $orderId
                ]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getListCart() {
        $cart = [];
        $session = session();
        if ($session->has('cart')) {
            $cart = array_values(session('cart'));
        }
        return $this->response->setJSON([
            "object" => $cart,
        ]);
    }

    public function addToCart() {
        $item = $this->request->getPost('item');
        $session = session();
        if (!$session->has('cart')) {
            $cart = [];
            array_push($cart , $item);
            $session->set('cart', $cart);
        } else {
            $index = $this->cartIsExist($item['product_code']);
            $cart = array_values(session('cart'));
            if ( $index == -1) {
                array_push($cart , $item);
            } else {
                $cart[$index]['quantity']++;
            }
            $session->set('cart' , $cart);
        }
        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    private function cartIsExist($id) {
        $items = array_values(session('cart'));
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]['product_code'] == $id) {
                return $i;
            }
        }
        return -1;
    }

    public function removeFromCart() {
        $id = $this->request->getPost('id');
        $index = $this->cartIsExist($id);
        $cart = array_values(session('cart'));
        unset($cart[$index]);
        $session = session();
        $session->set('cart' , $cart);
        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function updateCart() {
        $id = $this->request->getPost('id');
        $quantity = $this->request->getPost('quantity');
        $items = array_values(session('cart'));
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]['product_code'] == $id) {
                $items[$i]['quantity'] = (int) $quantity;
                $items[$i]['totalPrice'] = ( (int) $quantity * (int)$items[$i]['product_price'] );
            }
        }
        $session = session();
        $session->set('cart' , $items);
        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

}
