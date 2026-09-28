<?php

namespace App\Controllers;

use App\Models\RpsModel;
use App\Models\RpsPertemuanModel;
use App\Models\JenisPenilaianModel;
use App\Models\MatriksPenilaianModel;
use App\Models\RpsStatusLogModel;
use App\Models\MataKuliahModel;
use App\Models\DosenModel;
use App\Models\CpmkModel;

class RpsController extends BaseController
{
    public function index()
    {
        $rpsModel = new RpsModel();
        $mkModel  = new MataKuliahModel();
        $rpsAll   = $rpsModel->orderBy('id', 'DESC')->findAll();
        $mkById   = [];
        foreach ($mkModel->findAll() as $m) { $mkById[$m['id']] = $m; }
        $dosenById = [];
        foreach ((new DosenModel())->findAll() as $d) { $dosenById[$d['id']] = $d; }

        $data = [
            'title'     => 'RPS & Persetujuan',
            'rpsAll'    => $rpsAll,
            'mkList'    => $mkModel->orderBy('kode', 'ASC')->findAll(),
            'dosenList' => (new DosenModel())->orderBy('nama', 'ASC')->findAll(),
            'mkById'    => $mkById,
            'dosenById' => $dosenById,
        ];
        return view('rps/index', $data);
    }

    public function store()
    {
        $mkId = (int) $this->request->getPost('mk_id');
        $tahun = trim((string) $this->request->getPost('tahun_akademik'));
        $pengembangId = (int) $this->request->getPost('pengembang_id');
        $koorId = (int) $this->request->getPost('koor_prodi_id');

        if (! $mkId || $tahun === '') {
            return redirect()->to(site_url('rps'))->with('error', 'Pilih mata kuliah dan isi tahun akademik.');
        }

        $rpsModel = new RpsModel();
        $rpsId = $rpsModel->insert([
            'mk_id'          => $mkId,
            'tahun_akademik' => $tahun,
            'pengembang_id'  => $pengembangId ?: null,
            'koor_prodi_id'  => $koorId ?: null,
            'status'         => 'draft',
            'created_at'     => date('Y-m-d H:i:s'),
        ], true);

        // salin CPMK MK menjadi rancangan 16 pertemuan kosong
        $pertemuanModel = new RpsPertemuanModel();
        for ($i = 1; $i <= 16; $i++) {
            $pertemuanModel->insert([
                'rps_id' => $rpsId,
                'minggu' => $i,
                'bentuk' => 'Luring',
                'bobot'  => 0,
                'is_uts' => $i === 8 ? 1 : 0,
                'is_uas' => $i === 16 ? 1 : 0,
            ]);
        }

        // jenis penilaian default
        $jenisModel = new JenisPenilaianModel();
        $jenisModel->insert(['rps_id' => $rpsId, 'nama' => 'Tugas', 'bobot' => 30]);
        $jenisModel->insert(['rps_id' => $rpsId, 'nama' => 'UTS', 'bobot' => 30]);
        $jenisModel->insert(['rps_id' => $rpsId, 'nama' => 'UAS', 'bobot' => 40]);

        $dosenModel = new DosenModel();
        $pengembang = $pengembangId ? $dosenModel->find($pengembangId) : null;
        (new RpsStatusLogModel())->insert([
            'rps_id'  => $rpsId,
            'status'  => 'draft',
            'catatan' => 'RPS dibuat sebagai draf.',
            'oleh'    => $pengembang['nama'] ?? '—',
            'tanggal' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('rps/' . $rpsId))->with('success', 'Draf RPS dibuat.');
    }

    public function detail(int $id)
    {
        $rpsModel = new RpsModel();
        $rps = $rpsModel->find($id);
        if (! $rps) {
            return redirect()->to(site_url('rps'))->with('error', 'RPS tidak ditemukan.');
        }
        $mk = (new MataKuliahModel())->find($rps['mk_id']);
        $dosenModel = new DosenModel();

        $cpmkModel = new CpmkModel();
        $cpmkList = $cpmkModel->where('mk_id', $rps['mk_id'])->findAll();

        $data = [
            'title'           => 'RPS — ' . ($mk['nama'] ?? ''),
            'rps'             => $rps,
            'mk'              => $mk,
            'pertemuan'       => (new RpsPertemuanModel())->where('rps_id', $id)->orderBy('minggu', 'ASC')->findAll(),
            'jenisPenilaian'  => (new JenisPenilaianModel())->where('rps_id', $id)->findAll(),
            'matriks'         => (new MatriksPenilaianModel())->where('rps_id', $id)->findAll(),
            'statusLog'       => (new RpsStatusLogModel())->where('rps_id', $id)->orderBy('id', 'DESC')->findAll(),
            'cpmkList'        => $cpmkList,
            'dosenById'       => array_column($dosenModel->findAll(), null, 'id'),
            'editable'        => in_array($rps['status'], ['draft', 'revisi_diperlukan'], true),
        ];
        return view('rps/detail', $data);
    }

    private function findRpsOr404(int $id): array
    {
        $rps = (new RpsModel())->find($id);
        if (! $rps) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return $rps;
    }

    public function updatePertemuan(int $id)
    {
        $this->findRpsOr404($id);
        $model = new RpsPertemuanModel();
        $rows = $this->request->getPost('p'); // p[pertemuan_id][field] = value
        if (is_array($rows)) {
            foreach ($rows as $pid => $fields) {
                $model->update((int) $pid, [
                    'sub_cpmk'  => $fields['sub_cpmk'] ?? '',
                    'indikator' => $fields['indikator'] ?? '',
                    'materi'    => $fields['materi'] ?? '',
                    'model'     => $fields['model'] ?? '',
                    'bentuk'    => $fields['bentuk'] ?? 'Luring',
                    'bobot'     => (float) ($fields['bobot'] ?? 0),
                ]);
            }
        }
        return redirect()->to(site_url('rps/' . $id) . '#pertemuan')->with('success', 'Rancangan 16 pertemuan disimpan.');
    }

    public function addJenis(int $id)
    {
        $this->findRpsOr404($id);
        (new JenisPenilaianModel())->insert(['rps_id' => $id, 'nama' => 'Baru', 'bobot' => 0]);
        return redirect()->to(site_url('rps/' . $id) . '#penilaian');
    }

    public function deleteJenis(int $id, int $jenisId)
    {
        $this->findRpsOr404($id);
        (new JenisPenilaianModel())->delete($jenisId);
        return redirect()->to(site_url('rps/' . $id) . '#penilaian')->with('success', 'Jenis penilaian dihapus.');
    }

    public function updateJenis(int $id)
    {
        $this->findRpsOr404($id);
        $model = new JenisPenilaianModel();
        $rows = $this->request->getPost('j');
        if (is_array($rows)) {
            foreach ($rows as $jid => $fields) {
                $model->update((int) $jid, ['nama' => $fields['nama'] ?? '', 'bobot' => (float) ($fields['bobot'] ?? 0)]);
            }
        }
        return redirect()->to(site_url('rps/' . $id) . '#penilaian')->with('success', 'Bobot penilaian disimpan.');
    }

    public function updateMatriks(int $id)
    {
        $this->findRpsOr404($id);
        $model = new MatriksPenilaianModel();
        $cells = $this->request->getPost('m'); // m[jenis_id][cpmk_id] = bobot
        if (is_array($cells)) {
            foreach ($cells as $jenisId => $cpmkVals) {
                foreach ($cpmkVals as $cpmkId => $bobot) {
                    $bobot = (float) $bobot;
                    $existing = $model->where(['rps_id' => $id, 'jenis_penilaian_id' => $jenisId, 'cpmk_id' => $cpmkId])->first();
                    if ($bobot > 0) {
                        if ($existing) {
                            $model->update($existing['id'], ['bobot' => $bobot]);
                        } else {
                            $model->insert(['rps_id' => $id, 'jenis_penilaian_id' => $jenisId, 'cpmk_id' => $cpmkId, 'bobot' => $bobot]);
                        }
                    } elseif ($existing) {
                        $model->delete($existing['id']);
                    }
                }
            }
        }
        return redirect()->to(site_url('rps/' . $id) . '#matriks')->with('success', 'Matriks penilaian × CPMK disimpan.');
    }

    private function pushStatus(int $rpsId, string $status, ?string $catatan, string $oleh): void
    {
        (new RpsModel())->update($rpsId, ['status' => $status]);
        (new RpsStatusLogModel())->insert([
            'rps_id'  => $rpsId,
            'status'  => $status,
            'catatan' => $catatan ?: '',
            'oleh'    => $oleh,
            'tanggal' => date('Y-m-d H:i:s'),
        ]);
    }

    public function wfAjukan(int $id)
    {
        $rps = $this->findRpsOr404($id);
        $dosen = $rps['pengembang_id'] ? (new DosenModel())->find($rps['pengembang_id']) : null;
        $this->pushStatus($id, 'diajukan', $this->request->getPost('catatan'), $dosen['nama'] ?? '—');
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS diajukan ke GKM.');
    }

    public function wfRevisi(int $id)
    {
        $this->findRpsOr404($id);
        $catatan = trim((string) $this->request->getPost('catatan'));
        if ($catatan === '') {
            return redirect()->to(site_url('rps/' . $id))->with('error', 'Catatan revisi wajib diisi agar dosen tahu apa yang perlu diperbaiki.');
        }
        $this->pushStatus($id, 'revisi_diperlukan', $catatan, 'GKM');
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS dikembalikan untuk revisi.');
    }

    public function wfSetuju(int $id)
    {
        $this->findRpsOr404($id);
        $this->pushStatus($id, 'disetujui_gkm', $this->request->getPost('catatan'), 'GKM');
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS disetujui GKM.');
    }

    public function wfTtdDosen(int $id)
    {
        $rps = $this->findRpsOr404($id);
        (new RpsModel())->update($id, ['ttd_dosen' => 1]);
        $rps = (new RpsModel())->find($id);
        if ($rps['ttd_dosen'] && $rps['ttd_kaprodi']) {
            $dosen = $rps['pengembang_id'] ? (new DosenModel())->find($rps['pengembang_id']) : null;
            $this->pushStatus($id, 'ditandatangani', 'Ditandatangani Dosen & Kaprodi.', $dosen['nama'] ?? '—');
        }
        return redirect()->to(site_url('rps/' . $id))->with('success', 'Tanda tangan Dosen tersimpan.');
    }

    public function wfTtdKaprodi(int $id)
    {
        $rps = $this->findRpsOr404($id);
        (new RpsModel())->update($id, ['ttd_kaprodi' => 1]);
        $rps = (new RpsModel())->find($id);
        if ($rps['ttd_dosen'] && $rps['ttd_kaprodi']) {
            $koor = $rps['koor_prodi_id'] ? (new DosenModel())->find($rps['koor_prodi_id']) : null;
            $this->pushStatus($id, 'ditandatangani', 'Ditandatangani Dosen & Kaprodi.', $koor['nama'] ?? '—');
        }
        return redirect()->to(site_url('rps/' . $id))->with('success', 'Tanda tangan Kaprodi tersimpan.');
    }

    public function wfArsip(int $id)
    {
        $this->findRpsOr404($id);
        $lokasi = trim((string) $this->request->getPost('lokasi'));
        (new RpsModel())->update($id, ['arsip_gpm' => 1, 'arsip_lokasi' => $lokasi]);
        $this->pushStatus($id, 'diarsipkan', 'Diserahkan ke GPM dan diarsipkan.', 'Prodi');
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS diarsipkan.');
    }
}
