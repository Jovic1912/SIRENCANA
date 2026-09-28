<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table         = 'kelas';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['mk_id', 'rps_id', 'label', 'semester', 'tahun_akademik', 'jumlah_pertemuan'];
}
