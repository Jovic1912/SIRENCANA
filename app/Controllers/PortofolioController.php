<?php

namespace App\Controllers;

use App\Libraries\Access;
use App\Models\KelasModel;
use App\Models\MataKuliahModel;
use App\Models\RpsModel;
use App\Models\PortofolioModel;
use App\Models\KontrakKuliahModel;
use App\Models\PesertaKelasModel;
use App\Models\PresensiModel;

class PortofolioController extends BaseController
{
    /** Kolom narasi portofolio, urut sesuai format Portofolio MK UMRAH. */
    public const NARASI = [
        'pendahuluan'     => ['1. Pendahuluan', 'Ceritakan penjelasan yang diperlukan tentang mata kuliah ini'],
        'tujuan'          => ['2. Tujuan', 'Jelaskan tujuan perkuliahan umum maupun khusus'],
        'metode'          => ['3. Metode Pembelajaran', 'Jelaskan strategi yang digunakan untuk mencapai tujuan perkuliahan (CPMK)'],
        'isi'             => ['4. Isi Perkuliahan', 'Jelaskan kesesuaiannya dengan kurikulum yang berlaku'],
        'peserta_ket'     => ['5. Peserta Kuliah', 'Berikan gambaran tentang peserta kuliah'],
        'kehadiran_ket'   => ['6. Persentase Kehadiran', 'Uraian % kehadiran dosen dan % kehadiran mahasiswa (angka dihitung otomatis)'],
        'sistem_evaluasi' => ['7. Sistem Evaluasi', 'Jelaskan tentang PR, kuis, tugas kelompok, praktikum, dll.'],
        'hasil_capaian'   => ['8. Hasil Capaian Pembelajaran', 'Jelaskan capaian atas tujuan yang telah ditetapkan (tabel capaian CPMK dihitung otomatis)'],
        'rekomendasi'     => ['11. Rekomendasi Perbaikan', 'Rekomendasi perbaikan untuk pelaksanaan berikutnya'],
    ];

    public const TAUTAN = [
        'tautan_rps'      => 'Tautan RPS',
        'tautan_kontrak'  => 'Tautan Kontrak Kuliah',
        'tautan_presensi' => 'Tautan Presensi SIPA',
        'tautan_soal'     => 'Tautan Soal Ujian',
    ];

    public function index()
    {
        $data = [
            'title'    => 'Portofolio Mata Kuliah',
            'kelasAll' => Access::visibleKelas(),
            'mkById'   => array_column((new MataKuliahModel())->findAll(), null, 'id'),
        ];
        return view('portofolio/pilih', $data);
    }

    /**
     * Jumlah pertemuan yang benar-benar terlaksana (punya data presensi),
     * dipakai sebagai default realisasi tatap muka dosen.
     */
    public static function pertemuanTerlaksana(int $kelasId): int
    {
        $pesertaIds = array_column((new PesertaKelasModel())->where('kelas_id', $kelasId)->findAll(), 'id');
        if (! $pesertaIds) return 0;
        $rows = (new PresensiModel())->select('pertemuan')->whereIn('peserta_id', $pesertaIds)->groupBy('pertemuan')->findAll();
        return count($rows);
    }

    /**
     * Status kelengkapan portofolio: nilai tersimpan bila dosen sudah mengisi,
     * selain itu ditebak dari data di sistem.
     */
    public static function kelengkapan(array $kelas, ?array $rps, ?array $portofolio, ?array $kontrak, array $hasil): array
    {
        $saved = json_decode((string) ($portofolio['kelengkapan'] ?? ''), true);
        if (is_array($saved) && $saved) {
            $out = [];
            foreach (kelengkapan_portofolio() as $k => $_) { $out[$k] = ! empty($saved[$k]); }
            return $out;
        }

        $rows = $hasil['rows'];
        $kategori = array_column($hasil['jenisList'], 'kategori');
        $isi = fn (?string $v) => trim((string) $v) !== '';
        $adaNilai = $rows && count(array_filter($rows, fn ($r) => $r['akhir']['lengkap'])) === count($rows);
        $adaPresensi = $rows && count(array_filter($rows, fn ($r) => $r['presensiRows'])) > 0;
        $rencanaTugas = array_filter($hasil['jenisList'], fn ($j) => $isi($j['deskripsi'] ?? '') || $isi($j['judul'] ?? ''));

        return [
            'portofolio'     => $isi($portofolio['tujuan'] ?? '') && $isi($portofolio['metode'] ?? ''),
            'analisis'       => $isi($rps['analisis_pembelajaran'] ?? ''),
            'rps'            => ($rps['status'] ?? '') === 'diarsipkan',
            'basis_evaluasi' => ! empty($hasil['matriksRows']),
            'lembar_tugas'   => (bool) $rencanaTugas,
            'kontrak'        => ! empty($kontrak['ttd']),
            'jurnal_sipa'    => $isi($portofolio['tautan_presensi'] ?? ''),
            'rekap_presensi' => $adaPresensi,
            'soal_uts'       => in_array('uts', $kategori, true) && $isi($portofolio['tautan_soal'] ?? ''),
            'soal_uas'       => in_array('uas', $kategori, true) && $isi($portofolio['tautan_soal'] ?? ''),
            'soal_proyek'    => in_array('proyek', $kategori, true),
            'rekap_nilai'    => $adaNilai,
            'rekap_cpmk'     => $adaNilai && ! empty($hasil['cpmkList']),
            'laporan_obe'    => $adaNilai && ! empty($hasil['cpmkList']),
        ];
    }

    public function show(int $id)
    {
        $kelas = (new KelasModel())->find($id);
        if (! $kelas) return redirect()->to(site_url('portofolio'))->with('error', 'Kelas tidak ditemukan.');
        if (! Access::canViewKelas($id)) return redirect()->to(site_url('portofolio'))->with('error', 'Anda bukan pengampu kelas tersebut.');

        $mk = (new MataKuliahModel())->find($kelas['mk_id']);
        $rps = (new RpsModel())->find($kelas['rps_id']);
        $portofolio = (new PortofolioModel())->where('kelas_id', $id)->first();
        $kontrak = (new KontrakKuliahModel())->where('kelas_id', $id)->first();
        $hasil = CapaianController::hitung($kelas);

        $data = [
            'title'        => 'Portofolio — ' . ($mk['nama'] ?? ''),
            'kelas'        => $kelas,
            'mk'           => $mk,
            'rps'          => $rps,
            'portofolio'   => $portofolio,
            'kontrak'      => $kontrak,
            'jumlahPeserta'=> count($hasil['rows']),
            'terlaksana'   => self::pertemuanTerlaksana($id),
            'kelengkapan'  => self::kelengkapan($kelas, $rps, $portofolio, $kontrak, $hasil),
            'rows'         => $hasil['rows'],
            'cpmkList'     => $hasil['cpmkList'],
            'summary'      => $hasil['summary'],
            'canWrite'     => Access::canWriteKelasData($id),
        ];
        return view('portofolio/show', $data);
    }

    public function updateNarasi(int $id)
    {
        if (! Access::canWriteKelasData($id)) return redirect()->to(site_url('portofolio'))->with('error', 'Hanya dosen pengampu yang dapat mengubah portofolio.');
        $model = new PortofolioModel();
        $existing = $model->where('kelas_id', $id)->first();

        $payload = [];
        foreach (array_keys(self::NARASI + self::TAUTAN) as $f) {
            $payload[$f] = trim((string) $this->request->getPost($f));
        }
        $realisasi = $this->request->getPost('realisasi_tatap_muka');
        $payload['realisasi_tatap_muka'] = is_numeric($realisasi) ? max(0, min(99, (int) $realisasi)) : null;

        $centang = (array) ($this->request->getPost('kelengkapan') ?? []);
        $kelengkapan = [];
        foreach (kelengkapan_portofolio() as $k => $_) { $kelengkapan[$k] = isset($centang[$k]) ? 1 : 0; }
        $payload['kelengkapan'] = json_encode($kelengkapan);

        if ($existing) {
            $model->update($existing['id'], $payload);
        } else {
            $payload['kelas_id'] = $id;
            $model->insert($payload);
        }
        return redirect()->to(site_url('portofolio/' . $id))->with('success', 'Portofolio disimpan.');
    }
}
