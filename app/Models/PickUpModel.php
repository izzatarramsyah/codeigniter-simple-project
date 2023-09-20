<?php

namespace App\Models;

use CodeIgniter\Model;

class PickUpModel extends Model
{
    protected $table      = 'tbl_pick_up';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'pick_up_id',
        'user_id',
        'status',
        'notes'
    ];

    public function savePickUp($data) {
        $builder = $this->db->table('tbl_pick_up');
        return $builder->insert($data);
    }

    public function getListPickUp($userId) {
        $builder = $this->db->table('tbl_pick_up');
        $builder->select('tbl_product_out.order_id, 
            tbl_pick_up.pick_up_id, 
            tbl_pick_up.status, 
            tbl_pick_up.created_dtm, 
            tbl_pick_up.lastupd_dtm');
        $builder->join('tbl_product_out', 
            'tbl_pick_up.pick_up_id = tbl_product_out.pick_up_id');
        $builder->where('tbl_pick_up.user_id' , $userId);
        $query = $builder->get();
        return $query->getResult();
    }

    public function updatePickupStatus($id, $data) {
        $builder = $this->db->table('tbl_pick_up');
        $builder->where('pick_up_id' , $id);
        return $builder->update($data);
    }
}