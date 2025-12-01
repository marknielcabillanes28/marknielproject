<?php

namespace App\Models;

use CodeIgniter\Model;

class ElectronicsModel extends Model
{
    protected $table = 'electronics';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','brand','model','quantity','status'];
    protected $useTimestamps = true;
}
