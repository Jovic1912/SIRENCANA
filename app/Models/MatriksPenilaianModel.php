<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriksPenilaianModel extends Model
{
    protected $table         = 'matriks_penilaian';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['rps_id', 'jenis_penilaian_id', 'cpmk_id', 'bobot'];
}
