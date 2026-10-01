<?php

namespace App\Controllers;

use App\Models\ProdiModel;
use App\Models\MataKuliahModel;
use App\Models\CplModel;
use App\Models\CpmkModel;
use App\Models\CpmkCplModel;

class KurikulumController extends BaseController
{
    public function index()
    {
        $prodiId = (int) ($this->request->getGet('prodi') ?? 0);
        $mkId    = (int) ($this->request->getGet('mk') ?? 0);

        $prodiModel = new ProdiModel();
        $mkModel    = new MataKuliahModel();
        $cpmkModel  = new CpmkModel();

        $prodi = $prodiId ? $prodiModel->find($prodiId) : null;
        $mkList = $prodi ? $mkModel->where('prodi_id', $prodiId)->orderBy('kode', 'ASC')->findAll() : [];
        $mk = $mkId ? $mkModel->find($mkId) : null;
        $cplList = $prodi ? (new CplModel())->where('prodi_id', $prodi['id'])->findAll() : [];

        $cpmkList = [];
        $bobotCplByCpmk = [];
        if ($mk) {
            $cpmkList = $cpmkModel->where('mk_id', $mk['id'])->findAll();
            $cplBobotModel = new CpmkCplModel();
            foreach ($cpmkList as $c) {
                $rows = $cplBobotModel->where('cpmk_id', $c['id'])->findAll();
                $bobotCplByCpmk[$c['id']] = [];
                foreach ($rows as $r) { $bobotCplByCpmk[$c['id']][$r['cpl_id']] = $r['bobot']; }
            }
        }

        $data = [
            'title'           => 'Kurikulum & CPMK',
            'prodiList'       => $prodiModel->orderBy('nama', 'ASC')->findAll(),
            'prodi'           => $prodi,
            'mkList'          => $mkList,
            'mk'              => $mk,
            'cpmkList'        => $cpmkList,
            'cplList'         => $cplList,
            'bobotCplByCpmk'  => $bobotCplByCpmk,
            'cpmkCountByMk'   => $this->cpmkCountFor($mkList, $cpmkModel),
            'canWrite'        => has_role('admin', 'kaprodi'),
        ];
        return view('kurikulum/index', $data);
    }

    private function cpmkCountFor(array $mkList, CpmkModel $model): array
    {
        $out = [];
        foreach ($mkList as $m) { $out[$m['id']] = $model->where('mk_id', $m['id'])->countAllResults(); }
        return $out;
    }

    public function storeCpl()
    {
        $prodiId = (int) $this->request->getPost('prodi_id');
        $kode = trim((string) $this->request->getPost('kode'));
        if ($kode === '' || ! $prodiId) {
            return redirect()->back()->with('error', 'Kode CPL wajib diisi.');
        }
        (new CplModel())->insert([
            'prodi_id'  => $prodiId,
            'kode'      => $kode,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);
        return redirect()->to(site_url('kurikulum') . '?prodi=' . $prodiId)->with('success', 'CPL ditambahkan.');
    }

    public function deleteCpl(int $id)
    {
        $cpl = (new CplModel())->find($id);
        (new CplModel())->delete($id);
        $prodiId = $cpl['prodi_id'] ?? null;
        return redirect()->to(site_url('kurikulum') . ($prodiId ? '?prodi=' . $prodiId : ''))->with('success', 'CPL dihapus.');
    }

    public function storeCpmk()
    {
        $mkId = (int) $this->request->getPost('mk_id');
        $prodiId = (int) $this->request->getPost('prodi_id');
        $kode = trim((string) $this->request->getPost('kode'));
        if ($kode === '' || ! $mkId) {
            return redirect()->back()->with('error', 'Kode CPMK wajib diisi.');
        }
        (new CpmkModel())->insert([
            'mk_id'     => $mkId,
            'kode'      => $kode,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);
        return redirect()->to(site_url('kurikulum') . "?prodi=$prodiId&mk=$mkId")->with('success', 'CPMK ditambahkan.');
    }

    public function deleteCpmk(int $id)
    {
        $cpmk = (new CpmkModel())->find($id);
        (new CpmkModel())->delete($id);
        $mk = $cpmk ? (new MataKuliahModel())->find($cpmk['mk_id']) : null;
        $qs = $mk ? "?prodi={$mk['prodi_id']}&mk={$mk['id']}" : '';
        return redirect()->to(site_url('kurikulum') . $qs)->with('success', 'CPMK dihapus.');
    }

    public function setBobot()
    {
        $cpmkId = (int) $this->request->getPost('cpmk_id');
        $cplId  = (int) $this->request->getPost('cpl_id');
        $bobot  = (float) $this->request->getPost('bobot');
        $prodiId = (int) $this->request->getPost('prodi_id');
        $mkId    = (int) $this->request->getPost('mk_id');

        $model = new CpmkCplModel();
        $existing = $model->where(['cpmk_id' => $cpmkId, 'cpl_id' => $cplId])->first();
        if ($bobot > 0) {
            if ($existing) {
                $model->update($existing['id'], ['bobot' => $bobot]);
            } else {
                $model->insert(['cpmk_id' => $cpmkId, 'cpl_id' => $cplId, 'bobot' => $bobot]);
            }
        } elseif ($existing) {
            $model->delete($existing['id']);
        }
        return redirect()->to(site_url('kurikulum') . "?prodi=$prodiId&mk=$mkId");
    }
}
