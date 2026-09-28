<?php

namespace App\Models;

use CodeIgniter\Model;

class MataKuliahModel extends Model
{
    protected $table         = 'mata_kuliah';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['kode', 'nama', 'tingkat_mk', 'prodi_id', 'rumpun_mk', 'sifat_mk', 'sks', 'semester', 'deskripsi'];
}
