<?php

namespace App\Models;

use CodeIgniter\Model;

class RpsStatusLogModel extends Model
{
    protected $table         = 'rps_status_log';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['rps_id', 'status', 'catatan', 'oleh', 'tanggal'];
}
