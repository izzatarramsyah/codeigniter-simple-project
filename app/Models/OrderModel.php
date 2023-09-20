<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'tbl_order';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'order_id',
        'status'
    ];

    public function saveOrder($data) {
        $builder = $this->db->table('tbl_order');
        return $builder->insert($data);
    }

    public function getOrder($userId, $startDate, $endDate) {
        $builder = $this->db->table('tbl_order');
        $builder->select('order_id, status, created_dtm, created_by');
        $builder->where('user_id' , $userId);
        $builder->where('DATE(created_dtm) BETWEEN "'. date('Y-m-d', strtotime($startDate)). '" and "'. date('Y-m-d', strtotime($endDate)).'"');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getOrderByID($userId, $transactionId) {
        $builder = $this->db->table('tbl_order');
        $builder->select('order_id, status, created_dtm, created_by');
        $builder->where('user_id' , $userId);
        $builder->where('order_id' , $transactionId);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getAllOrderDetail($startDate, $endDate) {
        $builder = $this->db->table('tbl_order');
        $builder->select('tbl_order.order_id, tbl_mst_product.product_name, tbl_order.created_dtm, 
            tbl_order_detail.product_code, tbl_order_detail.quantity, tbl_order_detail.total_price');
        $builder->join('tbl_order_detail', 'tbl_order.order_id = tbl_order_detail.order_id');
        $builder->join('tbl_mst_product', 'tbl_order_detail.product_code = tbl_order_detail.product_code');
        $builder->where('DATE(created_dtm) BETWEEN "'. date('Y-m-d', strtotime($startDate)). '" and "'. date('Y-m-d', strtotime($endDate)).'"');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getOrderDetail($order_id) {
        $builder = $this->db->table('tbl_order');
        $builder->select('tbl_order.order_id, tbl_mst_product.product_name, tbl_order.created_dtm, 
            tbl_order_detail.product_code, tbl_order_detail.quantity, tbl_order_detail.total_price');
        $builder->join('tbl_order_detail', 'tbl_order.order_id = tbl_order_detail.order_id');
        $builder->join('tbl_mst_product', 'tbl_order_detail.product_code = tbl_order_detail.product_code');
        $builder->where(['tbl_order_detail.order_id' => $order_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getOrderDetailByUser($userId) {
        $builder = $this->db->table('tbl_order');
        $builder->select('tbl_order.order_id, tbl_mst_product.product_name, tbl_order.created_dtm, 
            tbl_order_detail.product_code, tbl_order_detail.quantity, tbl_order_detail.total_price');
        $builder->join('tbl_order_detail', 'tbl_order.order_id = tbl_order_detail.order_id');
        $builder->join('tbl_mst_product', 'tbl_order_detail.product_code = tbl_order_detail.product_code');
        $builder->where(['tbl_order.user_id' => $userId]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getOrderRequest($startDate, $endDate) {
        $builder = $this->db->table('tbl_order');
        $builder->select('tbl_order.order_id, 
                          tbl_order.status, 
                          tbl_order.created_dtm, 
                          tbl_user.username');
        $builder->join('tbl_user', 'tbl_user.id = tbl_order.user_id');
        $builder->where('DATE(created_dtm) BETWEEN "'. date('Y-m-d', strtotime($startDate)). '" and "'. date('Y-m-d', strtotime($endDate)).'"');
        $query = $builder->get();
        return $query->getResult();
    }

    public function updateOrder($orderId, $data) {
        $builder = $this->db->table('tbl_order');
        $builder->where('order_id' , $orderId);
        return $builder->update($data);
    }

}