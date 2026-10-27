<?php

namespace App\Models;

use CodeIgniter\Model;

class KontrakKuliahModel extends Model
{
    protected $table         = 'kontrak_kuliah';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['kelas_id', 'jadwal_ruang', 'jadwal_hari', 'jadwal_jam', 'klausa', 'ttd', 'tgl_ttd', 'koordinator_kelas'];
}
