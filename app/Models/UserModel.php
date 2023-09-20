<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'tbl_user';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $allowedFields = [
        'username',
        'password',
        'email',
        'status',
        'join_date'
    ];

    public function getCountCustomer(){
        $builder = $this->db->table('tbl_user');
        $builder->select('count(id) as customer');
        $builder->where(['tbl_user.profile_id' => 2]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getListUser() {
        $builder = $this->db->table('tbl_user');
        $builder->select('id, username, email, status, join_date');
        $query = $builder->get();
        return $query->getResult();
    }

    public function saveUser($data) {
        $builder = $this->db->table('tbl_user');
        return $builder->insert($data);
    }

    public function decreaseBalance($id, $balance) {
        $builder = $this->db->table('tbl_user');
        $builder->set('balance', $balance);
        $builder->where('id', $id);
        return $builder->update();
    }
    
    public function updateUser($id, $username, $email) {
        $builder = $this->db->table('tbl_user');
        $builder->set('username', $username);
        $builder->set('email', $email);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function updateStatusUser($id, $status) {
        $builder = $this->db->table('tbl_user');
        $builder->set('status', $status);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function deleteUser($id) {
        $builder = $this->db->table('tbl_user');
        return $builder->delete(['id' => $id]);
    }

}