<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $exists = $this->db->table('users')->where('username', 'admin')->countAllResults();
        if ($exists) {
            CLI::write('Akun "admin" sudah ada. Tidak ada perubahan.', 'yellow');
            return;
        }

        $password = substr(bin2hex(random_bytes(8)), 0, 12);
        $this->db->table('users')->insert([
            'nama'                 => 'Administrator',
            'username'             => 'admin',
            'password'             => password_hash($password, PASSWORD_DEFAULT),
            'role'                 => 'admin',
            'aktif'                => 1,
            'wajib_ganti_password' => 1,
            'created_at'           => date('Y-m-d H:i:s'),
        ]);

        CLI::write('Akun administrator dibuat.', 'green');
        CLI::write('  Username : admin');
        CLI::write('  Password : ' . $password, 'yellow');
        CLI::write('Catat password ini sekarang; Anda akan diminta menggantinya saat login pertama.');
    }
}
