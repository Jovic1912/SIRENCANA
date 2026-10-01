<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\ProdiModel;

class MahasiswaController extends BaseController
{
    public function index()
    {
        $model = new MahasiswaModel();
        $mhs = $model->orderBy('nim', 'ASC')->findAll();
        $prodiById = [];
        foreach ((new ProdiModel())->findAll() as $p) { $prodiById[$p['id']] = $p; }

        $data = [
            'title'     => 'Mahasiswa',
            'mahasiswa' => $mhs,
            'prodiList' => (new ProdiModel())->orderBy('nama', 'ASC')->findAll(),
            'prodiById' => $prodiById,
            'canWrite' => has_role('admin'),
        ];
        return view('master/mahasiswa', $data);
    }

    public function store()
    {
        $model = new MahasiswaModel();
        $nim  = trim((string) $this->request->getPost('nim'));
        $nama = trim((string) $this->request->getPost('nama'));
        if ($nim === '' || $nama === '') {
            return redirect()->to(site_url('mahasiswa'))->with('error', 'NIM dan nama wajib diisi.');
        }
        $prodiId = $this->request->getPost('prodi_id');
        $model->insert([
            'nim'      => $nim,
            'nama'     => $nama,
            'prodi_id' => $prodiId !== '' ? $prodiId : null,
        ]);
        return redirect()->to(site_url('mahasiswa'))->with('success', 'Mahasiswa ditambahkan.');
    }

    public function delete(int $id)
    {
        (new MahasiswaModel())->delete($id);
        return redirect()->to(site_url('mahasiswa'))->with('success', 'Mahasiswa dihapus.');
    }
}
