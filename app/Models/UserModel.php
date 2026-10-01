<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['nama', 'username', 'password', 'role', 'dosen_id', 'aktif', 'wajib_ganti_password', 'last_login', 'created_at'];

    public const ROLES = [
        'admin'   => 'Administrator',
        'dosen'   => 'Dosen',
        'gkm'     => 'GKM (Gugus Kendali Mutu)',
        'kaprodi' => 'Koordinator Prodi (Kaprodi)',
        'gpm'     => 'GPM (Gugus Penjamin Mutu)',
    ];
}
