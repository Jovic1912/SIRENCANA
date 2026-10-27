<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPenilaianModel extends Model
{
    protected $table         = 'jenis_penilaian';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['rps_id', 'nama', 'bobot', 'kategori', 'judul', 'sub_cpmk', 'deskripsi', 'metode', 'luaran_objek', 'luaran_bentuk', 'indikator', 'kriteria', 'jadwal', 'lain_lain', 'rujukan', 'rubrik'];
}
