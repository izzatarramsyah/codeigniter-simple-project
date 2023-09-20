<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductInModel extends Model
{
    protected $table      = 'tbl_product_in';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id',
        'product_code',
        'quantity'
    ];

    public function saveProductIn($data) {
        $builder = $this->db->table('tbl_product_in');
        return $builder->insert($data);
    }

    public function getListProductIn($startDate, $endDate) {
        $builder = $this->db->table('tbl_product_in');
        //$builder->where('DATE(tbl_product_in.created_dtm) BETWEEN "'. date('Y-m-d', strtotime($startDate)). '" and "'. date('Y-m-d', strtotime($endDate)).'"');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getCountProductIn(){
        $builder = $this->db->table('tbl_product_in');
        $builder->select('sum(quantity) as product_in');
        $query = $builder->get();
        return $query->getResult();
    }

}