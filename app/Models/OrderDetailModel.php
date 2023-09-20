<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailModel extends Model
{
    protected $table      = 'tbl_order_detail';
    protected $useTimestamps = true;

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'order_id',
        'product_code',
        'quantity',
        'total_price'
    ];

    public function saveOrderDetail($data) {
        $builder = $this->db->table('tbl_order_detail');
        return $builder->insert($data);
    }

    public function getTotalIncome(){
        $builder = $this->db->table('tbl_order_detail');
        $builder->select('sum(total_price) as total_price, sum(quantity) as quantity');
        $query = $builder->get();
        return $query->getResult();
    }

}