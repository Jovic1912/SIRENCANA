<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\ProdiModel;
use App\Models\CpmkModel;

class MataKuliahController extends BaseController
{
    public function index()
    {
        $mkModel = new MataKuliahModel();
        $mk = $mkModel->orderBy('kode', 'ASC')->findAll();

        $prodiById = [];
        foreach ((new ProdiModel())->findAll() as $p) { $prodiById[$p['id']] = $p; }

        $cpmkModel = new CpmkModel();
        $cpmkCount = [];
        foreach ($cpmkModel->findAll() as $c) {
            $cpmkCount[$c['mk_id']] = ($cpmkCount[$c['mk_id']] ?? 0) + 1;
        }

        $data = [
            'title'     => 'Mata Kuliah',
            'mk'        => $mk,
            'prodiList' => (new ProdiModel())->orderBy('nama', 'ASC')->findAll(),
            'prodiById' => $prodiById,
            'cpmkCount' => $cpmkCount,
        ];
        return view('master/mata_kuliah', $data);
    }

    public function store()
    {
        $model = new MataKuliahModel();
        $kode = trim((string) $this->request->getPost('kode'));
        $nama = trim((string) $this->request->getPost('nama'));
        $tingkat = $this->request->getPost('tingkat_mk') ?: 'Prodi';
        $prodiId = $this->request->getPost('prodi_id');

        if ($kode === '' || $nama === '') {
            return redirect()->to(site_url('mata-kuliah'))->with('error', 'Kode dan nama mata kuliah wajib diisi.');
        }
        if ($tingkat === 'Prodi' && ! $prodiId) {
            return redirect()->to(site_url('mata-kuliah'))->with('error', 'MK Program Studi wajib memilih program studi.');
        }

        $model->insert([
            'kode'       => $kode,
            'nama'       => $nama,
            'tingkat_mk' => $tingkat,
            'prodi_id'   => $prodiId !== '' ? $prodiId : null,
            'rumpun_mk'  => $this->request->getPost('rumpun_mk'),
            'sifat_mk'   => $this->request->getPost('sifat_mk') ?: 'Wajib',
            'sks'        => (int) ($this->request->getPost('sks') ?: 3),
            'semester'   => $this->request->getPost('semester') ?: 'Ganjil',
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ]);
        return redirect()->to(site_url('mata-kuliah'))->with('success', 'Mata kuliah ditambahkan.');
    }

    public function delete(int $id)
    {
        (new MataKuliahModel())->delete($id);
        return redirect()->to(site_url('mata-kuliah'))->with('success', 'Mata kuliah dihapus.');
    }
}
