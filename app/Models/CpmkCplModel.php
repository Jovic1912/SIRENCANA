<?php

namespace App\Models;

use CodeIgniter\Model;

class CpmkCplModel extends Model
{
    protected $table         = 'cpmk_cpl';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['cpmk_id', 'cpl_id', 'bobot'];
}
