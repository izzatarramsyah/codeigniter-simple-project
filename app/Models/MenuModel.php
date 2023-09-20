<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'tbl_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'menu'
    ];


}