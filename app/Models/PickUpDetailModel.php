<?php

namespace App\Models;

use CodeIgniter\Model;

class PickUpDetailModel extends Model
{
    protected $table      = 'tbl_pick_up_detail';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'pick_up_id',
        'sequence',
        'status'
    ];

    public function savePickUpDetail($data) {
        $builder = $this->db->table('tbl_pick_up_detail');
        return $builder->insert($data);
    }

    public function getListPickUpDetail($pickupId) {
        $builder = $this->db->table('tbl_pick_up_detail');
        $builder->where('tbl_pick_up_detail.pick_up_id' , $pickupId);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getSequnce($pickupId){
        $builder = $this->db->table('tbl_pick_up_detail');
        $builder->selectCount('pick_up_id');
        $builder->where('tbl_pick_up_detail.pick_up_id' , $pickupId);
        $query = $builder->get();
        return $query->getResult();
    }

}