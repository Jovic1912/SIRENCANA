<?php

namespace App\Controllers;

use App\Libraries\Access;
use App\Models\CpmkModel;
use App\Models\DosenModel;
use App\Models\JenisPenilaianModel;
use App\Models\MataKuliahModel;
use App\Models\MatriksPenilaianModel;
use App\Models\RpsModel;
use App\Models\RpsPertemuanModel;
use App\Models\RpsStatusLogModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RpsController extends BaseController
{
    private const EDITABLE = ['draft', 'revisi_diperlukan'];

    public function index()
    {
        $mkModel   = new MataKuliahModel();
        $dosenAll  = (new DosenModel())->orderBy('nama', 'ASC')->findAll();

        $kaprodiIds = array_filter(array_column((new UserModel())->where(['role' => 'kaprodi', 'aktif' => 1])->findAll(), 'dosen_id'));
        $koorList   = $kaprodiIds ? array_values(array_filter($dosenAll, fn ($d) => in_array($d['id'], $kaprodiIds))) : $dosenAll;

        $data = [
            'title'      => 'RPS & Persetujuan',
            'rpsAll'     => Access::visibleRps(),
            'mkList'     => $mkModel->orderBy('kode', 'ASC')->findAll(),
            'dosenList'  => $dosenAll,
            'koorList'   => $koorList,
            'koorFallback' => ! $kaprodiIds,
            'mkById'     => array_column($mkModel->findAll(), null, 'id'),
            'dosenById'  => array_column($dosenAll, null, 'id'),
            'canCreate'  => has_role('dosen', 'admin'),
            'myDosen'    => Access::dosenId() ? (new DosenModel())->find(Access::dosenId()) : null,
        ];
        return view('rps/index', $data);
    }

    public function store()
    {
        $mkId  = (int) $this->request->getPost('mk_id');
        $tahun = trim((string) $this->request->getPost('tahun_akademik'));
        $koorId = (int) $this->request->getPost('koor_prodi_id');

        $pengembangId = has_role('dosen') ? Access::dosenId() : (int) $this->request->getPost('pengembang_id');
        if (! $pengembangId) {
            return redirect()->to(site_url('rps'))->with('error', 'Akun Anda belum ditautkan ke data dosen. Hubungi administrator.');
        }
        if (! $mkId || $tahun === '' || ! (new MataKuliahModel())->find($mkId)) {
            return redirect()->to(site_url('rps'))->with('error', 'Pilih mata kuliah dan isi tahun akademik.');
        }

        $rpsId = (new RpsModel())->insert([
            'mk_id'          => $mkId,
            'tahun_akademik' => $tahun,
            'pengembang_id'  => $pengembangId,
            'koor_prodi_id'  => $koorId ?: null,
            'status'         => 'draft',
            'created_at'     => date('Y-m-d H:i:s'),
        ], true);

        $pertemuanModel = new RpsPertemuanModel();
        for ($i = 1; $i <= 16; $i++) {
            $pertemuanModel->insert([
                'rps_id' => $rpsId, 'minggu' => $i, 'bentuk' => 'Luring', 'bobot' => 0,
                'is_uts' => $i === 8 ? 1 : 0, 'is_uas' => $i === 16 ? 1 : 0,
            ]);
        }
        $jenisModel = new JenisPenilaianModel();
        foreach ([['Tugas', 30], ['UTS', 30], ['UAS', 40]] as [$nama, $bobot]) {
            $jenisModel->insert(['rps_id' => $rpsId, 'nama' => $nama, 'bobot' => $bobot]);
        }
        $this->log($rpsId, 'draft', 'RPS dibuat sebagai draf.');

        return redirect()->to(site_url('rps/' . $rpsId))->with('success', 'Draf RPS dibuat.');
    }

    public function detail(int $id)
    {
        $rps = (new RpsModel())->find($id);
        if (! $rps) return redirect()->to(site_url('rps'))->with('error', 'RPS tidak ditemukan.');
        if (! Access::canViewRps($rps)) {
            return redirect()->to(site_url('rps'))->with('error', 'Anda tidak memiliki akses ke RPS tersebut.');
        }

        $mk = (new MataKuliahModel())->find($rps['mk_id']);
        $status = $rps['status'];
        $isOwner = Access::canEditRps($rps);

        $data = [
            'title'          => 'RPS — ' . ($mk['nama'] ?? ''),
            'rps'            => $rps,
            'mk'             => $mk,
            'pertemuan'      => (new RpsPertemuanModel())->where('rps_id', $id)->orderBy('minggu', 'ASC')->findAll(),
            'jenisPenilaian' => (new JenisPenilaianModel())->where('rps_id', $id)->findAll(),
            'matriks'        => (new MatriksPenilaianModel())->where('rps_id', $id)->findAll(),
            'statusLog'      => (new RpsStatusLogModel())->where('rps_id', $id)->orderBy('id', 'DESC')->findAll(),
            'cpmkList'       => (new CpmkModel())->where('mk_id', $rps['mk_id'])->findAll(),
            'dosenById'      => array_column((new DosenModel())->findAll(), null, 'id'),
            'editable'       => $isOwner && in_array($status, self::EDITABLE, true),
            'canAjukan'      => $isOwner && in_array($status, self::EDITABLE, true),
            'canReview'      => has_role('gkm') && $status === 'diajukan',
            'canTtdDosen'    => $status === 'disetujui_gkm' && ! $rps['ttd_dosen'] && Access::canSignAsDosen($rps),
            'canTtdKaprodi'  => $status === 'disetujui_gkm' && ! $rps['ttd_kaprodi'] && Access::canSignAsKaprodi($rps),
            'canArsip'       => $status === 'ditandatangani' && has_role('gpm', 'kaprodi'),
        ];
        return view('rps/detail', $data);
    }

    private function loadEditable(int $id): array
    {
        $rps = (new RpsModel())->find($id);
        if (! $rps) throw PageNotFoundException::forPageNotFound();
        if (! Access::canEditRps($rps)) {
            return [null, redirect()->to(site_url('rps'))->with('error', 'Anda bukan pengembang RPS ini.')];
        }
        if (! in_array($rps['status'], self::EDITABLE, true)) {
            return [null, redirect()->to(site_url('rps/' . $id))->with('error', 'RPS tidak dapat diubah pada status "' . status_label($rps['status']) . '".')];
        }
        return [$rps, null];
    }

    public function updatePertemuan(int $id)
    {
        [$rps, $deny] = $this->loadEditable($id);
        if ($deny) return $deny;

        $model = new RpsPertemuanModel();
        $rows = $this->request->getPost('p');
        if (is_array($rows)) {
            foreach ($rows as $pid => $f) {
                $model->where('rps_id', $id)->update((int) $pid, [
                    'sub_cpmk'  => (string) ($f['sub_cpmk'] ?? ''),
                    'indikator' => (string) ($f['indikator'] ?? ''),
                    'materi'    => (string) ($f['materi'] ?? ''),
                    'model'     => (string) ($f['model'] ?? ''),
                    'bentuk'    => in_array($f['bentuk'] ?? '', ['Luring', 'Daring', 'Blended'], true) ? $f['bentuk'] : 'Luring',
                    'bobot'     => max(0, min(100, (float) ($f['bobot'] ?? 0))),
                ]);
            }
        }
        return redirect()->to(site_url('rps/' . $id) . '#pertemuan')->with('success', 'Rancangan 16 pertemuan disimpan.');
    }

    public function addJenis(int $id)
    {
        [$rps, $deny] = $this->loadEditable($id);
        if ($deny) return $deny;
        (new JenisPenilaianModel())->insert(['rps_id' => $id, 'nama' => 'Baru', 'bobot' => 0]);
        return redirect()->to(site_url('rps/' . $id) . '#penilaian');
    }

    public function deleteJenis(int $id, int $jenisId)
    {
        [$rps, $deny] = $this->loadEditable($id);
        if ($deny) return $deny;
        (new JenisPenilaianModel())->where('rps_id', $id)->delete($jenisId);
        return redirect()->to(site_url('rps/' . $id) . '#penilaian')->with('success', 'Jenis penilaian dihapus.');
    }

    public function updateJenis(int $id)
    {
        [$rps, $deny] = $this->loadEditable($id);
        if ($deny) return $deny;
        $model = new JenisPenilaianModel();
        $rows = $this->request->getPost('j');
        if (is_array($rows)) {
            foreach ($rows as $jid => $f) {
                $nama = trim((string) ($f['nama'] ?? ''));
                if ($nama === '') continue;
                $model->where('rps_id', $id)->update((int) $jid, ['nama' => $nama, 'bobot' => max(0, min(100, (float) ($f['bobot'] ?? 0)))]);
            }
        }
        return redirect()->to(site_url('rps/' . $id) . '#penilaian')->with('success', 'Bobot penilaian disimpan.');
    }

    public function updateMatriks(int $id)
    {
        [$rps, $deny] = $this->loadEditable($id);
        if ($deny) return $deny;

        $validJenis = array_column((new JenisPenilaianModel())->where('rps_id', $id)->findAll(), 'id');
        $validCpmk  = array_column((new CpmkModel())->where('mk_id', $rps['mk_id'])->findAll(), 'id');
        $model = new MatriksPenilaianModel();
        $cells = $this->request->getPost('m');
        if (is_array($cells)) {
            foreach ($cells as $jenisId => $cpmkVals) {
                if (! in_array((int) $jenisId, array_map('intval', $validJenis), true) || ! is_array($cpmkVals)) continue;
                foreach ($cpmkVals as $cpmkId => $bobot) {
                    if (! in_array((int) $cpmkId, array_map('intval', $validCpmk), true)) continue;
                    $bobot = max(0, min(100, (float) $bobot));
                    $existing = $model->where(['rps_id' => $id, 'jenis_penilaian_id' => $jenisId, 'cpmk_id' => $cpmkId])->first();
                    if ($bobot > 0) {
                        $existing
                            ? $model->update($existing['id'], ['bobot' => $bobot])
                            : $model->insert(['rps_id' => $id, 'jenis_penilaian_id' => $jenisId, 'cpmk_id' => $cpmkId, 'bobot' => $bobot]);
                    } elseif ($existing) {
                        $model->delete($existing['id']);
                    }
                }
            }
        }
        return redirect()->to(site_url('rps/' . $id) . '#matriks')->with('success', 'Matriks penilaian × CPMK disimpan.');
    }

    private function log(int $rpsId, string $status, ?string $catatan): void
    {
        (new RpsStatusLogModel())->insert([
            'rps_id' => $rpsId, 'status' => $status, 'catatan' => $catatan ?: '',
            'oleh' => Access::actorLabel(), 'tanggal' => date('Y-m-d H:i:s'),
        ]);
    }

    private function setStatus(int $rpsId, string $status, ?string $catatan): void
    {
        (new RpsModel())->update($rpsId, ['status' => $status]);
        $this->log($rpsId, $status, $catatan);
    }

    private function requireStatus(int $id, array $allowed): array
    {
        $rps = (new RpsModel())->find($id);
        if (! $rps) throw PageNotFoundException::forPageNotFound();
        if (! in_array($rps['status'], $allowed, true)) {
            return [null, redirect()->to(site_url('rps/' . $id))->with('error', 'Tindakan tidak dapat dilakukan pada status "' . status_label($rps['status']) . '".')];
        }
        return [$rps, null];
    }

    public function wfAjukan(int $id)
    {
        [$rps, $deny] = $this->requireStatus($id, self::EDITABLE);
        if ($deny) return $deny;
        if (! Access::canEditRps($rps)) {
            return redirect()->to(site_url('rps'))->with('error', 'Hanya pengembang RPS yang dapat mengajukan.');
        }
        $total = array_sum(array_column((new JenisPenilaianModel())->where('rps_id', $id)->findAll(), 'bobot'));
        if (abs($total - 100) > 0.01) {
            return redirect()->to(site_url('rps/' . $id) . '#penilaian')->with('error', 'Total bobot jenis penilaian harus 100% sebelum diajukan (saat ini ' . $total . '%).');
        }
        $this->setStatus($id, 'diajukan', $this->request->getPost('catatan'));
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS diajukan ke GKM.');
    }

    public function wfRevisi(int $id)
    {
        [$rps, $deny] = $this->requireStatus($id, ['diajukan']);
        if ($deny) return $deny;
        $catatan = trim((string) $this->request->getPost('catatan'));
        if ($catatan === '') {
            return redirect()->to(site_url('rps/' . $id))->with('error', 'Catatan revisi wajib diisi agar dosen tahu apa yang perlu diperbaiki.');
        }
        $this->setStatus($id, 'revisi_diperlukan', $catatan);
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS dikembalikan untuk revisi.');
    }

    public function wfSetuju(int $id)
    {
        [$rps, $deny] = $this->requireStatus($id, ['diajukan']);
        if ($deny) return $deny;
        $this->setStatus($id, 'disetujui_gkm', $this->request->getPost('catatan'));
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS disetujui GKM. Menunggu tanda tangan Dosen dan Kaprodi.');
    }

    public function wfTtdDosen(int $id)
    {
        [$rps, $deny] = $this->requireStatus($id, ['disetujui_gkm']);
        if ($deny) return $deny;
        if (! Access::canSignAsDosen($rps)) {
            return redirect()->to(site_url('rps/' . $id))->with('error', 'Hanya dosen pengembang RPS ini yang dapat menandatangani sebagai Dosen.');
        }
        (new RpsModel())->update($id, ['ttd_dosen' => 1]);
        $this->log($id, 'disetujui_gkm', 'Tanda tangan Dosen.');
        $this->finishIfSigned($id);
        return redirect()->to(site_url('rps/' . $id))->with('success', 'Tanda tangan Dosen tersimpan.');
    }

    public function wfTtdKaprodi(int $id)
    {
        [$rps, $deny] = $this->requireStatus($id, ['disetujui_gkm']);
        if ($deny) return $deny;
        if (! Access::canSignAsKaprodi($rps)) {
            return redirect()->to(site_url('rps/' . $id))->with('error', 'Anda bukan Koordinator Prodi yang ditetapkan pada RPS ini.');
        }
        (new RpsModel())->update($id, ['ttd_kaprodi' => 1]);
        $this->log($id, 'disetujui_gkm', 'Tanda tangan Kaprodi.');
        $this->finishIfSigned($id);
        return redirect()->to(site_url('rps/' . $id))->with('success', 'Tanda tangan Kaprodi tersimpan.');
    }

    private function finishIfSigned(int $id): void
    {
        $rps = (new RpsModel())->find($id);
        if ($rps['ttd_dosen'] && $rps['ttd_kaprodi']) {
            $this->setStatus($id, 'ditandatangani', 'Ditandatangani Dosen & Kaprodi.');
        }
    }

    public function wfArsip(int $id)
    {
        [$rps, $deny] = $this->requireStatus($id, ['ditandatangani']);
        if ($deny) return $deny;
        (new RpsModel())->update($id, ['arsip_gpm' => 1, 'arsip_lokasi' => trim((string) $this->request->getPost('lokasi'))]);
        $this->setStatus($id, 'diarsipkan', 'Diserahkan ke GPM dan diarsipkan.');
        return redirect()->to(site_url('rps/' . $id))->with('success', 'RPS diarsipkan.');
    }
}
