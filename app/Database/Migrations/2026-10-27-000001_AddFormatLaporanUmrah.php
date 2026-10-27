<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Kolom tambahan agar isian web memenuhi format dokumen OBE UMRAH 2026:
 * Silabus, RPS (+ Rencana Tugas/Quiz/Proyek/UTS/UAS), Kontrak Kuliah, Portofolio MK, dan Laporan EPBM.
 */
class AddFormatLaporanUmrah extends Migration
{
    public function up()
    {
        $text = ['type' => 'TEXT', 'null' => true];

        $this->forge->addColumn('rps', [
            'kode_dokumen'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tgl_penyusunan'        => ['type' => 'DATE', 'null' => true],
            'bahan_kajian'          => $text,
            'pustaka'               => $text,
            'media_software'        => $text,
            'media_hardware'        => $text,
            'mk_syarat'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sdgs'                  => $text,
            'analisis_pembelajaran' => $text,
        ]);

        $this->forge->addColumn('rps_pertemuan', [
            'luring'        => $text,
            'daring'        => $text,
            'blended'       => $text,
            'penilaian'     => $text, // teknik & kriteria penilaian
            'alokasi_waktu' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
        ]);

        // Rencana Tugas / Quiz / Proyek / UTS / UAS per jenis penilaian
        $this->forge->addColumn('jenis_penilaian', [
            'kategori'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'tugas'], // tugas|quiz|proyek|uts|uas|lainnya
            'judul'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sub_cpmk'      => $text,
            'deskripsi'     => $text,
            'metode'        => $text,
            'luaran_objek'  => $text,
            'luaran_bentuk' => $text,
            'indikator'     => $text,
            'kriteria'      => $text,
            'jadwal'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lain_lain'     => $text,
            'rujukan'       => $text,
            'rubrik'        => $text,
        ]);

        $this->forge->addColumn('kontrak_kuliah', [
            'koordinator_kelas' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
        ]);

        $this->forge->addColumn('portofolio', [
            'pendahuluan'          => $text,
            'peserta_ket'          => $text,
            'kehadiran_ket'        => $text,
            'sistem_evaluasi'      => $text,
            'hasil_capaian'        => $text,
            'rekomendasi'          => $text,
            'tautan_rps'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tautan_kontrak'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tautan_presensi'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tautan_soal'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'kelengkapan'          => $text, // JSON: {kunci_item: 1|0}
            'realisasi_tatap_muka' => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'null' => true],
        ]);

        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fakultas'           => ['type' => 'VARCHAR', 'constraint' => 150],
            'jurusan'            => ['type' => 'VARCHAR', 'constraint' => 150],
            'semester'           => ['type' => 'VARCHAR', 'constraint' => 20],
            'tahun_akademik'     => ['type' => 'VARCHAR', 'constraint' => 30],
            'ketua_gkm'          => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'anggota_gkm'        => $text,
            'prakata'            => $text,
            'latar_belakang'     => $text,
            'tujuan'             => $text,
            'metode'             => $text,
            'evaluasi_mk'        => $text,
            'evaluasi_dosen'     => $text,
            'kepuasan_mahasiswa' => $text,
            'kelulusan'          => $text,
            'simpulan'           => $text,
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('epbm', true);

        // Data lama: tandai kategori jenis penilaian dari namanya.
        $this->db->query("UPDATE jenis_penilaian SET kategori = 'uts' WHERE UPPER(nama) LIKE 'UTS%'");
        $this->db->query("UPDATE jenis_penilaian SET kategori = 'uas' WHERE UPPER(nama) LIKE 'UAS%'");
        $this->db->query("UPDATE jenis_penilaian SET kategori = 'quiz' WHERE UPPER(nama) LIKE 'QUIZ%' OR UPPER(nama) LIKE 'KUIS%'");
        $this->db->query("UPDATE jenis_penilaian SET kategori = 'proyek' WHERE UPPER(nama) LIKE 'PROYEK%' OR UPPER(nama) LIKE 'PROJECT%'");
        $this->db->query("UPDATE jenis_penilaian SET kategori = 'lainnya' WHERE UPPER(nama) LIKE 'KEAKTIFAN%' OR UPPER(nama) LIKE 'PARTISIPASI%'");    }

    public function down()
    {
        $this->forge->dropColumn('rps', ['kode_dokumen', 'tgl_penyusunan', 'bahan_kajian', 'pustaka', 'media_software', 'media_hardware', 'mk_syarat', 'sdgs', 'analisis_pembelajaran']);
        $this->forge->dropColumn('rps_pertemuan', ['luring', 'daring', 'blended', 'penilaian', 'alokasi_waktu']);
        $this->forge->dropColumn('jenis_penilaian', ['kategori', 'judul', 'sub_cpmk', 'deskripsi', 'metode', 'luaran_objek', 'luaran_bentuk', 'indikator', 'kriteria', 'jadwal', 'lain_lain', 'rujukan', 'rubrik']);
        $this->forge->dropColumn('kontrak_kuliah', ['koordinator_kelas']);
        $this->forge->dropColumn('portofolio', ['pendahuluan', 'peserta_ket', 'kehadiran_ket', 'sistem_evaluasi', 'hasil_capaian', 'rekomendasi', 'tautan_rps', 'tautan_kontrak', 'tautan_presensi', 'tautan_soal', 'kelengkapan', 'realisasi_tatap_muka']);
        $this->forge->dropTable('epbm', true);
    }
}
