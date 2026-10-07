<?php

namespace App\Controllers;

use App\Libraries\Access;
use App\Models\KelasModel;
use App\Models\KelasDosenModel;
use App\Models\KontrakKuliahModel;
use App\Models\PesertaKelasModel;
use App\Models\MataKuliahModel;
use App\Models\RpsModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\CpmkModel;
use App\Models\JenisPenilaianModel;
use App\Models\MatriksPenilaianModel;

class KelasController extends BaseController
{
    public function index()
    {
        $kelasModel = new KelasModel();
        $kelasAll = Access::visibleKelas();
        $mkById = array_column((new MataKuliahModel())->findAll(), null, 'id');

        $rpsSiap = (new RpsModel())->where('status', 'diarsipkan')->findAll();

        $pesertaCount = [];
        $kontrakByKelas = [];
        $pesertaModel = new PesertaKelasModel();
        $kontrakModel = new KontrakKuliahModel();
        foreach ($kelasAll as $k) {
            $pesertaCount[$k['id']] = $pesertaModel->where('kelas_id', $k['id'])->countAllResults();
            $kontrakByKelas[$k['id']] = $kontrakModel->where('kelas_id', $k['id'])->first();
        }

        $data = [
            'title'          => 'Kelas & Kontrak Kuliah',
            'kelasAll'       => $kelasAll,
            'mkById'         => $mkById,
            'rpsSiap'        => $rpsSiap,
            'dosenList'      => (new DosenModel())->orderBy('nama', 'ASC')->findAll(),
            'pesertaCount'   => $pesertaCount,
            'kontrakByKelas' => $kontrakByKelas,
            'canCreate'      => has_role('admin', 'kaprodi'),
        ];
        return view('kelas/index', $data);
    }

    public function store()
    {
        $rpsId = (int) $this->request->getPost('rps_id');
        $label = trim((string) $this->request->getPost('label'));
        $semester = $this->request->getPost('semester');
        $tahun = $this->request->getPost('tahun_akademik');
        $dosenIds = $this->request->getPost('dosen_ids') ?? [];

        $rps = (new RpsModel())->find($rpsId);
        if (! $rps || $label === '') {
            return redirect()->to(site_url('kelas'))->with('error', 'Pilih RPS dan isi label kelas.');
        }

        $kelasModel = new KelasModel();
        $kelasId = $kelasModel->insert([
            'mk_id'            => $rps['mk_id'],
            'rps_id'           => $rpsId,
            'label'            => $label,
            'semester'         => $semester,
            'tahun_akademik'   => $tahun,
            'jumlah_pertemuan' => 16,
        ], true);

        foreach ($dosenIds as $did) {
            (new KelasDosenModel())->insert(['kelas_id' => $kelasId, 'dosen_id' => (int) $did]);
        }

        (new KontrakKuliahModel())->insert([
            'kelas_id'     => $kelasId,
            'jadwal_ruang' => '', 'jadwal_hari' => '', 'jadwal_jam' => '',
            'klausa'       => '', 'ttd' => 0,
        ]);
        (new \App\Models\PortofolioModel())->insert(['kelas_id' => $kelasId, 'tujuan' => '', 'metode' => '', 'isi' => '']);

        return redirect()->to(site_url('kelas/' . $kelasId))->with('success', 'Kelas dibuka.');
    }

    public function detail(int $id)
    {
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($id);
        if (! $kelas) return redirect()->to(site_url('kelas'))->with('error', 'Kelas tidak ditemukan.');
        if (! Access::canViewKelas($id)) return redirect()->to(site_url('kelas'))->with('error', 'Anda bukan pengampu kelas tersebut.');

        $mk = (new MataKuliahModel())->find($kelas['mk_id']);
        $dosenIds = array_column((new KelasDosenModel())->where('kelas_id', $id)->findAll(), 'dosen_id');
        $dosenById = array_column((new DosenModel())->findAll(), null, 'id');
        $kontrak = (new KontrakKuliahModel())->where('kelas_id', $id)->first();

        $peserta = (new PesertaKelasModel())->where('kelas_id', $id)->findAll();
        $mhsById = array_column((new MahasiswaModel())->findAll(), null, 'id');
        $pesertaIds = array_column($peserta, 'mahasiswa_id');

        $mhsModel = new MahasiswaModel();
        if (! empty($mk['prodi_id'])) {
            $eligibleMhs = $mhsModel->groupStart()->where('prodi_id', $mk['prodi_id'])->orWhere('prodi_id', null)->groupEnd()->findAll();
        } else {
            $eligibleMhs = $mhsModel->findAll();
        }
        if ($pesertaIds) {
            $eligibleMhs = array_filter($eligibleMhs, fn ($m) => ! in_array($m['id'], $pesertaIds, true));
        }

        $data = [
            'title'       => 'Kelas ' . ($kelas['label'] ?? ''),
            'kelas'       => $kelas,
            'mk'          => $mk,
            'dosenNama'   => array_map(fn ($id) => $dosenById[$id]['nama'] ?? '—', $dosenIds),
            'kontrak'     => $kontrak,
            'peserta'     => $peserta,
            'mhsById'     => $mhsById,
            'eligibleMhs' => array_values($eligibleMhs),
            'canManage'   => Access::canManageKelas($id),
        ];
        return view('kelas/detail', $data);
    }

    public function updateKontrak(int $id)
    {
        $kelas = (new KelasModel())->find($id);
        if (! $kelas) return redirect()->to(site_url('kelas'));
        if (! Access::canManageKelas($id)) return redirect()->to(site_url('kelas'))->with('error', 'Anda tidak berwenang mengubah kelas ini.');
        $kontrak = (new KontrakKuliahModel())->where('kelas_id', $id)->first();
        $payload = [
            'jadwal_ruang' => $this->request->getPost('jadwal_ruang'),
            'jadwal_hari'  => $this->request->getPost('jadwal_hari'),
            'jadwal_jam'   => $this->request->getPost('jadwal_jam'),
            'klausa'       => $this->request->getPost('klausa'),
            'ttd'          => $this->request->getPost('ttd') ? 1 : 0,
        ];
        if ($payload['ttd'] && empty($kontrak['ttd'])) {
            $payload['tgl_ttd'] = date('Y-m-d H:i:s');
        } elseif (! $payload['ttd']) {
            $payload['tgl_ttd'] = null;
        }
        if ($kontrak) {
            (new KontrakKuliahModel())->update($kontrak['id'], $payload);
        } else {
            $payload['kelas_id'] = $id;
            (new KontrakKuliahModel())->insert($payload);
        }
        return redirect()->to(site_url('kelas/' . $id))->with('success', 'Kontrak kuliah disimpan.');
    }

    public function addPeserta(int $id)
    {
        if (! Access::canManageKelas($id)) return redirect()->to(site_url('kelas'))->with('error', 'Anda tidak berwenang mengubah kelas ini.');
        $mhsId = (int) $this->request->getPost('mahasiswa_id');
        if ($mhsId) {
            $exists = (new PesertaKelasModel())->where(['kelas_id' => $id, 'mahasiswa_id' => $mhsId])->first();
            if (! $exists) {
                (new PesertaKelasModel())->insert(['kelas_id' => $id, 'mahasiswa_id' => $mhsId]);
            }
        }
        return redirect()->to(site_url('kelas/' . $id))->with('success', 'Peserta ditambahkan.');
    }

    public function deletePeserta(int $id, int $pesertaId)
    {
        if (! Access::canManageKelas($id)) return redirect()->to(site_url('kelas'))->with('error', 'Anda tidak berwenang mengubah kelas ini.');
        (new PesertaKelasModel())->where('kelas_id', $id)->delete($pesertaId);
        return redirect()->to(site_url('kelas/' . $id))->with('success', 'Peserta dikeluarkan.');
    }
}
