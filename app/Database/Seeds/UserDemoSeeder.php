<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

class UserDemoSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $dosenDosen   = $this->ensureDosen('Dosen Demo', '0000000001');
        $dosenKaprodi = $this->ensureDosen('Kaprodi Demo', '0000000002');

        $akun = [
            ['Dosen Demo',   'dosen1',   'dosen',   $dosenDosen],
            ['Kaprodi Demo', 'kaprodi1', 'kaprodi', $dosenKaprodi],
            ['GKM Demo',     'gkm1',     'gkm',     null],
            ['GPM Demo',     'gpm1',     'gpm',     null],
        ];
        foreach ($akun as [$nama, $username, $role, $dosenId]) {
            if ($this->db->table('users')->where('username', $username)->countAllResults()) {
                CLI::write("Lewati $username (sudah ada).", 'yellow');
                continue;
            }
            $this->db->table('users')->insert([
                'nama' => $nama, 'username' => $username,
                'password' => password_hash('demo12345', PASSWORD_DEFAULT),
                'role' => $role, 'dosen_id' => $dosenId, 'aktif' => 1,
                'wajib_ganti_password' => 0, 'created_at' => $now,
            ]);
            CLI::write("Dibuat: $username ($role) / demo12345", 'green');
        }
        CLI::write('PERINGATAN: akun demo hanya untuk uji lokal. Hapus/ganti password sebelum dipakai bersama.', 'red');
    }

    private function ensureDosen(string $nama, string $nidn): int
    {
        $row = $this->db->table('dosen')->where('nidn', $nidn)->get()->getRowArray();
        if ($row) return (int) $row['id'];
        $this->db->table('dosen')->insert(['nama' => $nama, 'nidn' => $nidn]);
        return (int) $this->db->insertID();
    }
}
