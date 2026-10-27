<?php

namespace App\Models;

use CodeIgniter\Model;

class EpbmModel extends Model
{
    protected $table         = 'epbm';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['fakultas', 'jurusan', 'semester', 'tahun_akademik', 'ketua_gkm', 'anggota_gkm', 'prakata', 'latar_belakang', 'tujuan', 'metode', 'evaluasi_mk', 'evaluasi_dosen', 'kepuasan_mahasiswa', 'kelulusan', 'simpulan'];
}
