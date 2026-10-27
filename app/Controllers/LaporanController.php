<?php

namespace App\Controllers;

use App\Libraries\Access;
use App\Models\CplModel;
use App\Models\CpmkCplModel;
use App\Models\CpmkModel;
use App\Models\DosenModel;
use App\Models\EpbmModel;
use App\Models\JenisPenilaianModel;
use App\Models\KelasDosenModel;
use App\Models\KelasModel;
use App\Models\KontrakKuliahModel;
use App\Models\MataKuliahModel;
use App\Models\MatriksPenilaianModel;
use App\Models\PortofolioModel;
use App\Models\ProdiModel;
use App\Models\RpsModel;
use App\Models\RpsPertemuanModel;

/**
 * Dokumen siap cetak sesuai format OBE UMRAH 2026:
 * Silabus, RPS, Kontrak Kuliah, Portofolio MK, dan Laporan EPBM.
 */
class LaporanController extends BaseController
{
    protected $helpers = ['obe', 'auth', 'laporan'];

    public function index()
    {
        $mkById = array_column((new MataKuliahModel())->findAll(), null, 'id');
        $data = [
            'title'     => 'Laporan & Dokumen',
            'rpsAll'    => Access::visibleRps(),
            'kelasAll'  => has_role('gkm', 'gpm') ? (new KelasModel())->orderBy('id', 'DESC')->findAll() : Access::visibleKelas(),
            'mkById'    => $mkById,
            'dosenById' => array_column((new DosenModel())->findAll(), null, 'id'),
            'epbmAll'   => has_role('admin', 'kaprodi', 'gkm', 'gpm') ? (new EpbmModel())->orderBy('id', 'DESC')->findAll() : [],
        ];
        return view('laporan/index', $data);
    }

    /** Nama dosen pengampu sebuah kelas. */
    private static function pengampu(int $kelasId, array $dosenById): array
    {
        $ids = array_column((new KelasDosenModel())->where('kelas_id', $kelasId)->findAll(), 'dosen_id');
        return array_values(array_filter(array_map(fn ($id) => $dosenById[$id]['nama'] ?? null, $ids)));
    }

    /** Data bersama Silabus & RPS. */
    private function dataRps(int $id): ?array
    {
        $rps = (new RpsModel())->find($id);
        if (! $rps || ! Access::canViewRps($rps)) return null;

        $mk = (new MataKuliahModel())->find($rps['mk_id']);
        $prodi = ! empty($mk['prodi_id']) ? (new ProdiModel())->find($mk['prodi_id']) : null;
        $dosenById = array_column((new DosenModel())->findAll(), null, 'id');
        $cpmkList = (new CpmkModel())->where('mk_id', $rps['mk_id'])->orderBy('kode', 'ASC')->findAll();

        // Matriks CPMK → CPL dan CPL yang dibebankan pada MK ini
        $cpmkCpl = [];
        $cplIds = [];
        if ($cpmkList) {
            foreach ((new CpmkCplModel())->whereIn('cpmk_id', array_column($cpmkList, 'id'))->findAll() as $r) {
                if ((float) $r['bobot'] <= 0) continue;
                $cpmkCpl[$r['cpmk_id']][$r['cpl_id']] = (float) $r['bobot'];
                $cplIds[$r['cpl_id']] = true;
            }
        }
        $cplList = $cplIds ? (new CplModel())->whereIn('id', array_keys($cplIds))->orderBy('id', 'ASC')->findAll() : [];

        $pertemuan = (new RpsPertemuanModel())->where('rps_id', $id)->orderBy('minggu', 'ASC')->findAll();
        $subCpmk = [];
        foreach ($pertemuan as $p) {
            $s = trim((string) $p['sub_cpmk']);
            if ($s !== '' && ! in_array($s, $subCpmk, true)) $subCpmk[] = $s;
        }

        $matriks = [];
        foreach ((new MatriksPenilaianModel())->where('rps_id', $id)->findAll() as $m) {
            $matriks[$m['jenis_penilaian_id']][$m['cpmk_id']] = (float) $m['bobot'];
        }

        // Dosen pengampu: dari kelas yang dibuka dengan RPS ini; bila belum ada, pengembang RPS.
        $pengampu = [];
        foreach ((new KelasModel())->where('rps_id', $id)->findAll() as $k) {
            $pengampu = array_merge($pengampu, self::pengampu((int) $k['id'], $dosenById));
        }
        $pengampu = array_values(array_unique($pengampu)) ?: array_filter([$dosenById[$rps['pengembang_id']]['nama'] ?? null]);

        return [
            'rps'        => $rps,
            'mk'         => $mk,
            'prodi'      => $prodi,
            'cpmkList'   => $cpmkList,
            'cplList'    => $cplList,
            'cpmkCpl'    => $cpmkCpl,
            'pertemuan'  => $pertemuan,
            'subCpmk'    => $subCpmk,
            'jenisList'  => (new JenisPenilaianModel())->where('rps_id', $id)->orderBy('id', 'ASC')->findAll(),
            'matriks'    => $matriks,
            'pengembang' => $dosenById[$rps['pengembang_id']]['nama'] ?? '',
            'koorProdi'  => $dosenById[$rps['koor_prodi_id']]['nama'] ?? '',
            'pengampu'   => $pengampu,
        ];
    }

    public function silabus(int $id)
    {
        $data = $this->dataRps($id);
        if (! $data) return redirect()->to(site_url('laporan'))->with('error', 'RPS tidak ditemukan atau Anda tidak memiliki akses.');
        $data['title'] = 'Silabus — ' . ($data['mk']['nama'] ?? '');
        return view('laporan/silabus', $data);
    }

    public function rps(int $id)
    {
        $data = $this->dataRps($id);
        if (! $data) return redirect()->to(site_url('laporan'))->with('error', 'RPS tidak ditemukan atau Anda tidak memiliki akses.');
        $data['title'] = 'RPS — ' . ($data['mk']['nama'] ?? '');
        return view('laporan/rps', $data);
    }

    /** Data bersama Kontrak Kuliah & Portofolio. */
    private function dataKelas(int $id): ?array
    {
        $kelas = (new KelasModel())->find($id);
        if (! $kelas || ! Access::canViewKelas($id)) return null;

        $mk = (new MataKuliahModel())->find($kelas['mk_id']);
        $rps = (new RpsModel())->find($kelas['rps_id']);
        $dosenById = array_column((new DosenModel())->findAll(), null, 'id');

        return [
            'kelas'     => $kelas,
            'mk'        => $mk,
            'rps'       => $rps,
            'prodi'     => ! empty($mk['prodi_id']) ? (new ProdiModel())->find($mk['prodi_id']) : null,
            'kontrak'   => (new KontrakKuliahModel())->where('kelas_id', $id)->first(),
            'pengampu'  => self::pengampu($id, $dosenById),
            'koorProdi' => $rps ? ($dosenById[$rps['koor_prodi_id']]['nama'] ?? '') : '',
            'jenisList' => $rps ? (new JenisPenilaianModel())->where('rps_id', $rps['id'])->orderBy('id', 'ASC')->findAll() : [],
        ];
    }

    public function kontrak(int $id)
    {
        $data = $this->dataKelas($id);
        if (! $data) return redirect()->to(site_url('laporan'))->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
        $data['title'] = 'Kontrak Kuliah — ' . ($data['mk']['nama'] ?? '') . ' ' . $data['kelas']['label'];
        return view('laporan/kontrak', $data);
    }

    public function portofolio(int $id)
    {
        $data = $this->dataKelas($id);
        if (! $data) return redirect()->to(site_url('laporan'))->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');

        $hasil = CapaianController::hitung($data['kelas']);
        $portofolio = (new PortofolioModel())->where('kelas_id', $id)->first();
        $terlaksana = PortofolioController::pertemuanTerlaksana($id);

        // Distribusi nilai huruf & ketercapaian MK (≥ 50% mahasiswa bernilai akhir ≥ 55 / minimal C)
        $distribusi = array_fill_keys(['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'E'], 0);
        foreach ($hasil['rows'] as $r) { $distribusi[$r['akhir']['huruf']]++; }
        $total = count($hasil['rows']);
        $tercapai = $total - $distribusi['D'] - $distribusi['E'];

        $data = array_merge($data, $hasil, [
            'title'       => 'Portofolio — ' . ($data['mk']['nama'] ?? '') . ' ' . $data['kelas']['label'],
            'portofolio'  => $portofolio,
            'realisasi'   => $portofolio['realisasi_tatap_muka'] ?? $terlaksana,
            'kelengkapan' => PortofolioController::kelengkapan($data['kelas'], $data['rps'], $portofolio, $data['kontrak'], $hasil),
            'distribusi'  => $distribusi,
            'persenTercapai' => $total ? round($tercapai / $total * 1000) / 10 : 0,
        ]);
        return view('laporan/portofolio', $data);
    }

    public function epbm(int $id)
    {
        $epbm = (new EpbmModel())->find($id);
        if (! $epbm) return redirect()->to(site_url('epbm'))->with('error', 'Laporan EPBM tidak ditemukan.');
        $data = array_merge(EpbmController::kompilasi($epbm), [
            'title' => 'Laporan EPBM — ' . $epbm['jurusan'] . ' ' . $epbm['semester'] . ' ' . $epbm['tahun_akademik'],
            'epbm'  => $epbm,
        ]);
        return view('laporan/epbm', $data);
    }
}
