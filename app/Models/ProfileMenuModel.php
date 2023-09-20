<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileMenuModel extends Model
{
    protected $table      = 'tbl_profile_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'profile',
        'menu_id'
    ];

}