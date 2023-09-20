<?php

namespace App\Models;

use CodeIgniter\Model;

class MstProductModel extends Model
{
    protected $table      = 'tbl_mst_product';
    protected $primaryKey = 'product_code';
    protected $useTimestamps = true;

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'product_code',
        'product_name',
        'description',
        'product_price',
        'quantity'
    ];

    public function saveProduct($data) {
        $builder = $this->db->table('tbl_mst_product');
        return $builder->insert($data);
    }

    public function getProduct($product_code) {
        $builder = $this->db->table('tbl_mst_product');
        $builder->where('product_code' , $product_code);
        $query = $builder->get();
        return $query->getResult();
    }

    public function updateQtyProduct($quantity, $product_code) {
        $builder = $this->db->table('tbl_mst_product');
        $builder->set('quantity', $quantity);
        $builder->where('product_code' , $product_code);
        return $builder->update();
    }

    public function updateProduct($product_name, $description, $product_price, $quantity, $product_code) {
        $builder = $this->db->table('tbl_mst_product');
        $builder->set('product_name', $product_name);
        $builder->set('description', $description);
        $builder->set('product_price', $product_price);
        $builder->set('quantity', $quantity);
        $builder->where('product_code' , $product_code);
        return $builder->update();
    }

    public function deleteProduct($product_code) {
        $builder = $this->db->table('tbl_mst_product');
        return $builder->delete(['product_code' => $product_code]);
    }

}