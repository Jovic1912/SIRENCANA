<?php

namespace App\Controllers;

use App\Models\ProdiModel;

class ProdiController extends BaseController
{
    public function index()
    {
        $model = new ProdiModel();
        $data = [
            'title' => 'Program Studi',
            'prodi' => $model->orderBy('nama', 'ASC')->findAll(),
            'canWrite' => has_role('admin'),
        ];
        return view('master/prodi', $data);
    }

    public function store()
    {
        $model = new ProdiModel();
        $nama = trim((string) $this->request->getPost('nama'));
        if ($nama === '') {
            return redirect()->to(site_url('prodi'))->with('error', 'Nama program studi wajib diisi.');
        }
        $model->insert([
            'nama'     => $nama,
            'jurusan'  => $this->request->getPost('jurusan'),
            'fakultas' => $this->request->getPost('fakultas'),
        ]);
        return redirect()->to(site_url('prodi'))->with('success', 'Program studi ditambahkan.');
    }

    public function delete(int $id)
    {
        (new ProdiModel())->delete($id);
        return redirect()->to(site_url('prodi'))->with('success', 'Program studi dihapus.');
    }
}
