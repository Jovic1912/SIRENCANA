<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaKelasModel extends Model
{
    protected $table         = 'peserta_kelas';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['kelas_id', 'mahasiswa_id'];
}
