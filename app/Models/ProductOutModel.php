<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductOutModel extends Model
{
    protected $table      = 'tbl_product_out';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id',
        'order_id',
        'status',
        'pickup_by'
    ];

    public function saveProductOut($data) {
        $builder = $this->db->table('tbl_product_out');
        return $builder->insert($data);
    }

    public function updateProductOut($id, $pickUpId, $username) {
        $builder = $this->db->table('tbl_product_out');
        $builder->set('pick_up_id', $pickUpId);
        $builder->set('lastupd_by', $username);
        $builder->where('id' , $id);
        return $builder->update();
    }

    public function getListProductOut($startDate, $endDate) {
        $builder = $this->db->table('tbl_product_out');
        $builder->select('tbl_product_out.order_id, tbl_product_out.pick_up_id, tbl_product_out.created_dtm');
        //$builder->where('DATE(tbl_product_in.created_dtm) BETWEEN "'. date('Y-m-d', strtotime($startDate)). '" and "'. date('Y-m-d', strtotime($endDate)).'"');
        $query = $builder->get();
        return $query->getResult();
    }

}