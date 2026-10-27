<?php

namespace App\Models;

use CodeIgniter\Model;

class RpsPertemuanModel extends Model
{
    protected $table         = 'rps_pertemuan';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['rps_id', 'minggu', 'sub_cpmk', 'indikator', 'materi', 'model', 'bentuk', 'bobot', 'is_uts', 'is_uas', 'luring', 'daring', 'blended', 'penilaian', 'alokasi_waktu'];
}
