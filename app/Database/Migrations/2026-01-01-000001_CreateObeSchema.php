<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateObeSchema extends Migration
{
    public function up()
    {
        // ---------------- prodi ----------------
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'jurusan'  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'fakultas' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('prodi', true);

        // ---------------- cpl ----------------
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'prodi_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kode'      => ['type' => 'VARCHAR', 'constraint' => 30],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('prodi_id', 'prodi', 'id', '', 'CASCADE');
        $this->forge->createTable('cpl', true);

        // ---------------- dosen ----------------
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 150],
            'nidn' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dosen', true);

        // ---------------- mahasiswa ----------------
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nim'      => ['type' => 'VARCHAR', 'constraint' => 30],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'prodi_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nim');
        $this->forge->addForeignKey('prodi_id', 'prodi', 'id', '', 'SET NULL');
        $this->forge->createTable('mahasiswa', true);

        // ---------------- mata_kuliah ----------------
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 30],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'tingkat_mk' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Prodi'], // Universitas / Fakultas / Prodi
            'prodi_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'rumpun_mk'  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'sifat_mk'   => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Wajib'], // Wajib / Pilihan
            'sks'        => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true, 'default' => 3],
            'semester'   => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'Ganjil'], // Ganjil / Genap
            'deskripsi'  => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('prodi_id', 'prodi', 'id', '', 'SET NULL');
        $this->forge->createTable('mata_kuliah', true);

        // ---------------- cpmk ----------------
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mk_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kode'      => ['type' => 'VARCHAR', 'constraint' => 30],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mk_id', 'mata_kuliah', 'id', '', 'CASCADE');
        $this->forge->createTable('cpmk', true);

        // ---------------- cpmk_cpl (matriks pembebanan) ----------------
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'cpmk_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'cpl_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'bobot'    => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cpmk_id', 'cpmk', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('cpl_id', 'cpl', 'id', '', 'CASCADE');
        $this->forge->createTable('cpmk_cpl', true);

        // ---------------- rps ----------------
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mk_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tahun_akademik'=> ['type' => 'VARCHAR', 'constraint' => 30],
            'pengembang_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'koor_prodi_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'status'        => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'draft'],
            'ttd_dosen'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'ttd_kaprodi'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'arsip_gpm'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'arsip_lokasi'  => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mk_id', 'mata_kuliah', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('pengembang_id', 'dosen', 'id', '', 'SET NULL');
        $this->forge->addForeignKey('koor_prodi_id', 'dosen', 'id', '', 'SET NULL');
        $this->forge->createTable('rps', true);

        // ---------------- rps_pertemuan ----------------
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rps_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'minggu'    => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true],
            'sub_cpmk'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'indikator' => ['type' => 'TEXT', 'null' => true],
            'materi'    => ['type' => 'TEXT', 'null' => true],
            'model'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'bentuk'    => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Luring'],
            'bobot'     => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'is_uts'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_uas'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rps_id', 'rps', 'id', '', 'CASCADE');
        $this->forge->createTable('rps_pertemuan', true);

        // ---------------- jenis_penilaian ----------------
        $this->forge->addField([
            'id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rps_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'bobot'  => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rps_id', 'rps', 'id', '', 'CASCADE');
        $this->forge->createTable('jenis_penilaian', true);

        // ---------------- matriks_penilaian (jenis_penilaian x cpmk) ----------------
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rps_id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_penilaian_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'cpmk_id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'bobot'              => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rps_id', 'rps', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('jenis_penilaian_id', 'jenis_penilaian', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('cpmk_id', 'cpmk', 'id', '', 'CASCADE');
        $this->forge->createTable('matriks_penilaian', true);

        // ---------------- rps_status_log ----------------
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rps_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status'   => ['type' => 'VARCHAR', 'constraint' => 30],
            'catatan'  => ['type' => 'TEXT', 'null' => true],
            'oleh'     => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'tanggal'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rps_id', 'rps', 'id', '', 'CASCADE');
        $this->forge->createTable('rps_status_log', true);

        // ---------------- kelas (penawaran kelas) ----------------
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mk_id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'rps_id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'label'             => ['type' => 'VARCHAR', 'constraint' => 30],
            'semester'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'tahun_akademik'    => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'jumlah_pertemuan'  => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'default' => 16],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mk_id', 'mata_kuliah', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('rps_id', 'rps', 'id', '', 'CASCADE');
        $this->forge->createTable('kelas', true);

        // ---------------- kelas_dosen ----------------
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kelas_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'dosen_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id', '', 'CASCADE');
        $this->forge->createTable('kelas_dosen', true);

        // ---------------- kontrak_kuliah ----------------
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kelas_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jadwal_ruang'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jadwal_hari'   => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'jadwal_jam'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'klausa'        => ['type' => 'TEXT', 'null' => true],
            'ttd'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'tgl_ttd'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kelas_id');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', '', 'CASCADE');
        $this->forge->createTable('kontrak_kuliah', true);

        // ---------------- peserta_kelas ----------------
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kelas_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'mahasiswa_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('mahasiswa_id', 'mahasiswa', 'id', '', 'CASCADE');
        $this->forge->createTable('peserta_kelas', true);

        // ---------------- presensi ----------------
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'peserta_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'pertemuan'  => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 2], // H, I, S, A
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('peserta_id', 'peserta_kelas', 'id', '', 'CASCADE');
        $this->forge->createTable('presensi', true);

        // ---------------- nilai ----------------
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'peserta_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_penilaian_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nilai'              => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('peserta_id', 'peserta_kelas', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('jenis_penilaian_id', 'jenis_penilaian', 'id', '', 'CASCADE');
        $this->forge->createTable('nilai', true);

        // ---------------- portofolio ----------------
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kelas_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tujuan'   => ['type' => 'TEXT', 'null' => true],
            'metode'   => ['type' => 'TEXT', 'null' => true],
            'isi'      => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kelas_id');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', '', 'CASCADE');
        $this->forge->createTable('portofolio', true);
    }

    public function down()
    {
        $tables = [
            'portofolio', 'nilai', 'presensi', 'peserta_kelas', 'kontrak_kuliah', 'kelas_dosen', 'kelas',
            'rps_status_log', 'matriks_penilaian', 'jenis_penilaian', 'rps_pertemuan', 'rps',
            'cpmk_cpl', 'cpmk', 'mata_kuliah', 'mahasiswa', 'dosen', 'cpl', 'prodi',
        ];
        foreach ($tables as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}
