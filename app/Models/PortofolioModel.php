<?php

namespace App\Models;

use CodeIgniter\Model;

class PortofolioModel extends Model
{
    protected $table         = 'portofolio';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['kelas_id', 'tujuan', 'metode', 'isi', 'pendahuluan', 'peserta_ket', 'kehadiran_ket', 'sistem_evaluasi', 'hasil_capaian', 'rekomendasi', 'tautan_rps', 'tautan_kontrak', 'tautan_presensi', 'tautan_soal', 'kelengkapan', 'realisasi_tatap_muka'];
}
