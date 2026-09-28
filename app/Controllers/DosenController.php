<?php

namespace App\Controllers;

use App\Models\DosenModel;

class DosenController extends BaseController
{
    public function index()
    {
        $model = new DosenModel();
        $data = [
            'title' => 'Dosen',
            'dosen' => $model->orderBy('nama', 'ASC')->findAll(),
        ];
        return view('master/dosen', $data);
    }

    public function store()
    {
        $model = new DosenModel();
        $nama = trim((string) $this->request->getPost('nama'));
        if ($nama === '') {
            return redirect()->to(site_url('dosen'))->with('error', 'Nama dosen wajib diisi.');
        }
        $model->insert(['nama' => $nama, 'nidn' => $this->request->getPost('nidn')]);
        return redirect()->to(site_url('dosen'))->with('success', 'Dosen ditambahkan.');
    }

    public function delete(int $id)
    {
        (new DosenModel())->delete($id);
        return redirect()->to(site_url('dosen'))->with('success', 'Dosen dihapus.');
    }
}
