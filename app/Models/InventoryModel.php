<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table      = 'tbl_inventory';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'product_code',
        'ttl_units',
        'remaining_units'
    ];

    public function saveInventory($data) {
        $builder = $this->db->table('tbl_inventory');
        return $builder->insert($data);
    }

    public function getInventory($userId) {
        $builder = $this->db->table('tbl_inventory');
        $builder->select('tbl_inventory.id, 
                          tbl_inventory.created_dtm, 
                          tbl_inventory.lastupd_dtm, 
                          tbl_mst_product.product_code, 
                          tbl_mst_product.product_name, 
                          tbl_mst_product.description, 
                          tbl_mst_product.product_price,
                          tbl_inventory.ttl_units, 
                          tbl_inventory.remaining_units');
        $builder->join('tbl_mst_product', 'tbl_inventory.product_code = tbl_mst_product.product_code');
        $builder->where(['tbl_inventory.user_id' => $userId]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getInventoryById($id) {
        $builder = $this->db->table('tbl_inventory');
        $builder->select('tbl_inventory.id, 
                          tbl_inventory.created_dtm, 
                          tbl_mst_product.product_code, 
                          tbl_mst_product.product_name, 
                          tbl_mst_product.description, 
                          tbl_mst_product.product_price,
                          tbl_inventory.ttl_units, 
                          tbl_inventory.remaining_units');
        $builder->join('tbl_mst_product', 'tbl_inventory.product_code = tbl_mst_product.product_code');
        $builder->where(['tbl_inventory.id' => $id]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function checkInventory($userId, $product_code) {
        $builder = $this->db->table('tbl_inventory');
        $builder->select('tbl_inventory.ttl_units, 
                          tbl_inventory.remaining_units');
        $builder->where('tbl_inventory.user_id' , $userId);
        $builder->where('tbl_inventory.product_code' , $product_code);
        $query = $builder->get();
        return $query->getResult();
    }

    public function updateInventory($userId, $product_code, $ttl_units, $remaining_units) {
        $builder = $this->db->table('tbl_inventory');
        $builder->set('ttl_units', $ttl_units);
        $builder->set('remaining_units', $remaining_units);
        $builder->where('user_id' , $userId);
        $builder->where('product_code' , $product_code);
        return $builder->update();
    }

    public function updateRemainingUnitInventory($id, $remaining_units) {
        $builder = $this->db->table('tbl_inventory');
        $builder->set('remaining_units', $remaining_units);
        $builder->where('id' , $id);
        return $builder->update();
    }

}