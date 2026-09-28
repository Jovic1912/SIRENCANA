<?php

namespace App\Models;

use CodeIgniter\Model;

class CplModel extends Model
{
    protected $table         = 'cpl';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['prodi_id', 'kode', 'deskripsi'];
}
