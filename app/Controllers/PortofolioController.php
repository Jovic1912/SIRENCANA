<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MataKuliahModel;
use App\Models\RpsModel;
use App\Models\PortofolioModel;
use App\Models\KontrakKuliahModel;
use App\Models\PesertaKelasModel;
use App\Models\PresensiModel;
use App\Models\NilaiModel;
use App\Models\JenisPenilaianModel;

class PortofolioController extends BaseController
{
    public function index()
    {
        $data = [
            'title'    => 'Portofolio Mata Kuliah',
            'kelasAll' => (new KelasModel())->orderBy('id', 'DESC')->findAll(),
            'mkById'   => array_column((new MataKuliahModel())->findAll(), null, 'id'),
        ];
        return view('portofolio/pilih', $data);
    }

    public function show(int $id)
    {
        $kelas = (new KelasModel())->find($id);
        if (! $kelas) return redirect()->to(site_url('portofolio'))->with('error', 'Kelas tidak ditemukan.');

        $mk = (new MataKuliahModel())->find($kelas['mk_id']);
        $rps = (new RpsModel())->find($kelas['rps_id']);
        $portofolio = (new PortofolioModel())->where('kelas_id', $id)->first();
        $kontrak = (new KontrakKuliahModel())->where('kelas_id', $id)->first();

        $peserta = (new PesertaKelasModel())->where('kelas_id', $id)->findAll();
        $jenisList = (new JenisPenilaianModel())->where('rps_id', $kelas['rps_id'])->findAll();
        $presensiModel = new PresensiModel();
        $nilaiModel = new NilaiModel();

        $presLengkap = count($peserta) > 0;
        $nilaiLengkap = count($peserta) > 0;
        foreach ($peserta as $p) {
            $jumlahPresensi = $presensiModel->where('peserta_id', $p['id'])->countAllResults();
            if ($jumlahPresensi < (int) ($kelas['jumlah_pertemuan'] ?? 16)) $presLengkap = false;

            $nilaiRows = $nilaiModel->where('peserta_id', $p['id'])->findAll();
            $byJenis = array_column($nilaiRows, 'nilai', 'jenis_penilaian_id');
            if (! nilai_akhir($byJenis, $jenisList)['lengkap']) $nilaiLengkap = false;
        }

        $hasil = CapaianController::hitung($kelas);

        $data = [
            'title'        => 'Portofolio — ' . ($mk['nama'] ?? ''),
            'kelas'        => $kelas,
            'mk'           => $mk,
            'rps'          => $rps,
            'portofolio'   => $portofolio,
            'kontrak'      => $kontrak,
            'peserta'      => $peserta,
            'presLengkap'  => $presLengkap,
            'nilaiLengkap' => $nilaiLengkap,
            'rows'         => $hasil['rows'],
            'cpmkList'     => $hasil['cpmkList'],
            'summary'      => $hasil['summary'],
        ];
        return view('portofolio/show', $data);
    }

    public function updateNarasi(int $id)
    {
        $model = new PortofolioModel();
        $existing = $model->where('kelas_id', $id)->first();
        $payload = [
            'tujuan' => $this->request->getPost('tujuan'),
            'metode' => $this->request->getPost('metode'),
            'isi'    => $this->request->getPost('isi'),
        ];
        if ($existing) {
            $model->update($existing['id'], $payload);
        } else {
            $payload['kelas_id'] = $id;
            $model->insert($payload);
        }
        return redirect()->to(site_url('portofolio/' . $id))->with('success', 'Narasi portofolio disimpan.');
    }
}
