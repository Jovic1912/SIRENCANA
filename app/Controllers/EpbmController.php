<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\EpbmModel;
use App\Models\KelasDosenModel;
use App\Models\KelasModel;
use App\Models\KontrakKuliahModel;
use App\Models\MahasiswaModel;
use App\Models\MataKuliahModel;
use App\Models\PortofolioModel;
use App\Models\ProdiModel;
use App\Models\RpsModel;

/**
 * Laporan Evaluasi Proses Belajar Mengajar (EPBM) per jurusan per semester,
 * disusun oleh Gugus Kendali Mutu (GKM).
 */
class EpbmController extends BaseController
{
    public const NARASI = [
        'prakata'            => ['Prakata', ''],
        'latar_belakang'     => ['Pendahuluan — a. Latar Belakang', ''],
        'tujuan'             => ['Pendahuluan — b. Tujuan', ''],
        'metode'             => ['Metode Pelaksanaan', 'mis. kuesioner EPBM daring, telaah portofolio MK, rekap nilai dari SIRENCANA'],
        'evaluasi_mk'        => ['Hasil Evaluasi — a. Evaluasi Mata Kuliah', 'Uraian; tabel rekap tiap kelas dibuat otomatis'],
        'evaluasi_dosen'     => ['Hasil Evaluasi — b. Evaluasi Dosen', 'Hasil kuesioner evaluasi dosen; tabel kinerja pengampu dibuat otomatis'],
        'kepuasan_mahasiswa' => ['Hasil Evaluasi — c. Tingkat Kepuasan Mahasiswa', 'Hasil survei kepuasan mahasiswa tiap prodi'],
        'kelulusan'          => ['Hasil Evaluasi — d. Kelulusan Mahasiswa', 'Hasil kelulusan mahasiswa (yang sudah yudisium) tiap prodi'],
        'simpulan'           => ['Simpulan', ''],
    ];

    private static function sama(?string $a, ?string $b): bool
    {
        return strcasecmp(trim((string) $a), trim((string) $b)) === 0;
    }

    /**
     * Mengumpulkan data otomatis untuk laporan: prodi dalam jurusan, jumlah mahasiswa,
     * rekap per kelas (nilai, kehadiran, capaian CPMK, kelengkapan dokumen) dan per dosen.
     */
    public static function kompilasi(array $epbm): array
    {
        $prodiList = array_values(array_filter((new ProdiModel())->findAll(), fn ($p) => self::sama($p['jurusan'], $epbm['jurusan'])));
        $prodiIds = array_map('intval', array_column($prodiList, 'id'));
        $prodiById = array_column($prodiList, null, 'id');

        $mahasiswa = (new MahasiswaModel())->findAll();
        $jumlahMhs = [];
        foreach ($prodiList as $p) {
            $jumlahMhs[$p['id']] = count(array_filter($mahasiswa, fn ($m) => (int) $m['prodi_id'] === (int) $p['id']));
        }

        $mkById = array_column((new MataKuliahModel())->findAll(), null, 'id');
        $dosenById = array_column((new DosenModel())->findAll(), null, 'id');

        $kelasRows = [];
        $perDosen = [];
        foreach ((new KelasModel())->orderBy('id', 'ASC')->findAll() as $k) {
            $mk = $mkById[$k['mk_id']] ?? null;
            if (! $mk || ! in_array((int) $mk['prodi_id'], $prodiIds, true)) continue;
            if (! self::sama($k['semester'], $epbm['semester']) || ! self::sama($k['tahun_akademik'], $epbm['tahun_akademik'])) continue;

            $hasil = CapaianController::hitung($k);
            $rows = $hasil['rows'];
            $n = count($rows);
            $lulus = count(array_filter($rows, fn ($r) => ! in_array($r['akhir']['huruf'], ['D', 'E'], true)));
            $rata = $n ? round(array_sum(array_map(fn ($r) => $r['akhir']['angka'], $rows)) / $n, 2) : null;
            $hadir = $n ? round(array_sum(array_map(fn ($r) => $r['pres']['skor'], $rows)) / $n, 2) : null;
            $cpmkTercapai = count(array_filter($hasil['summary'], fn ($s) => $s['total'] > 0 && $s['persenLulus'] >= 50));

            $portofolio = (new PortofolioModel())->where('kelas_id', $k['id'])->first();
            $kontrak = (new KontrakKuliahModel())->where('kelas_id', $k['id'])->first();
            $rps = (new RpsModel())->find($k['rps_id']);
            $kelengkapan = PortofolioController::kelengkapan($k, $rps, $portofolio, $kontrak, $hasil);
            $realisasi = $portofolio['realisasi_tatap_muka'] ?? PortofolioController::pertemuanTerlaksana((int) $k['id']);

            $dosenIds = array_column((new KelasDosenModel())->where('kelas_id', $k['id'])->findAll(), 'dosen_id');
            $namaDosen = array_values(array_filter(array_map(fn ($d) => $dosenById[$d]['nama'] ?? null, $dosenIds)));

            $kelasRows[] = [
                'kelas'        => $k,
                'mk'           => $mk,
                'prodi'        => $prodiById[$mk['prodi_id']] ?? null,
                'dosen'        => $namaDosen,
                'peserta'      => $n,
                'rata'         => $rata,
                'persenLulus'  => $n ? round($lulus / $n * 1000) / 10 : null,
                'hadir'        => $hadir,
                'cpmkTercapai' => $cpmkTercapai,
                'cpmkTotal'    => count($hasil['cpmkList']),
                'rpsSah'       => ($rps['status'] ?? '') === 'diarsipkan',
                'kontrakTtd'   => ! empty($kontrak['ttd']),
                'kelengkapan'  => count(array_filter($kelengkapan)) . '/' . count($kelengkapan),
                'realisasi'    => (int) $realisasi,
                'pertemuan'    => (int) ($k['jumlah_pertemuan'] ?? 16),
                'tercapai'     => $n ? ($lulus / $n) >= 0.5 : null,
            ];

            foreach ($dosenIds as $d) {
                $perDosen[$d] ??= ['nama' => $dosenById[$d]['nama'] ?? '—', 'kelas' => [], 'realisasi' => 0, 'pertemuan' => 0, 'kontrak' => 0, 'portofolio' => 0];
                $perDosen[$d]['kelas'][] = ($mk['kode'] ?? '') . ' ' . $k['label'];
                $perDosen[$d]['realisasi'] += (int) $realisasi;
                $perDosen[$d]['pertemuan'] += (int) ($k['jumlah_pertemuan'] ?? 16);
                $perDosen[$d]['kontrak'] += ! empty($kontrak['ttd']) ? 1 : 0;
                $perDosen[$d]['portofolio'] += count(array_filter($kelengkapan)) === count($kelengkapan) ? 1 : 0;
            }
        }
        usort($perDosen, fn ($a, $b) => strcmp($a['nama'], $b['nama']));

        return [
            'prodiList' => $prodiList,
            'jumlahMhs' => $jumlahMhs,
            'kelasRows' => $kelasRows,
            'perDosen'  => $perDosen,
        ];
    }

    public function index()
    {
        $prodi = (new ProdiModel())->findAll();
        $data = [
            'title'    => 'Laporan EPBM',
            'epbmAll'  => (new EpbmModel())->orderBy('id', 'DESC')->findAll(),
            'jurusan'  => array_values(array_unique(array_filter(array_map(fn ($p) => trim((string) $p['jurusan']), $prodi)))),
            'fakultas' => array_values(array_unique(array_filter(array_map(fn ($p) => trim((string) $p['fakultas']), $prodi)))),
            'canEdit'  => has_role('admin', 'gkm'),
        ];
        return view('epbm/index', $data);
    }

    public function store()
    {
        $payload = [];
        foreach (['fakultas', 'jurusan', 'semester', 'tahun_akademik'] as $f) {
            $payload[$f] = trim((string) $this->request->getPost($f));
            if ($payload[$f] === '') {
                return redirect()->to(site_url('epbm'))->with('error', 'Lengkapi fakultas, jurusan, semester, dan tahun akademik.');
            }
        }
        $payload['ketua_gkm'] = has_role('gkm') ? user_name() : '';
        $id = (new EpbmModel())->insert($payload, true);
        return redirect()->to(site_url('epbm/' . $id))->with('success', 'Laporan EPBM dibuat. Lengkapi isinya di bawah.');
    }

    public function edit(int $id)
    {
        $epbm = (new EpbmModel())->find($id);
        if (! $epbm) return redirect()->to(site_url('epbm'))->with('error', 'Laporan EPBM tidak ditemukan.');
        $data = array_merge(self::kompilasi($epbm), [
            'title'   => 'EPBM ' . $epbm['jurusan'] . ' — ' . $epbm['semester'] . ' ' . $epbm['tahun_akademik'],
            'epbm'    => $epbm,
            'canEdit' => has_role('admin', 'gkm'),
        ]);
        return view('epbm/edit', $data);
    }

    public function update(int $id)
    {
        $model = new EpbmModel();
        if (! $model->find($id)) return redirect()->to(site_url('epbm'))->with('error', 'Laporan EPBM tidak ditemukan.');
        $payload = [];
        foreach (array_merge(['fakultas', 'jurusan', 'semester', 'tahun_akademik', 'ketua_gkm', 'anggota_gkm'], array_keys(self::NARASI)) as $f) {
            $payload[$f] = trim((string) $this->request->getPost($f));
        }
        $model->update($id, $payload);
        return redirect()->to(site_url('epbm/' . $id))->with('success', 'Laporan EPBM disimpan.');
    }

    public function delete(int $id)
    {
        (new EpbmModel())->delete($id);
        return redirect()->to(site_url('epbm'))->with('success', 'Laporan EPBM dihapus.');
    }
}
