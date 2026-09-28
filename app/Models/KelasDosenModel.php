<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasDosenModel extends Model
{
    protected $table         = 'kelas_dosen';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['kelas_id', 'dosen_id'];
}
