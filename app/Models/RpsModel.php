<?php

namespace App\Models;

use CodeIgniter\Model;

class RpsModel extends Model
{
    protected $table         = 'rps';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['mk_id', 'tahun_akademik', 'pengembang_id', 'koor_prodi_id', 'status', 'ttd_dosen', 'ttd_kaprodi', 'arsip_gpm', 'arsip_lokasi', 'created_at', 'kode_dokumen', 'tgl_penyusunan', 'bahan_kajian', 'pustaka', 'media_software', 'media_hardware', 'mk_syarat', 'sdgs', 'analisis_pembelajaran'];
}
