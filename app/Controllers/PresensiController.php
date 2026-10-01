<?php

namespace App\Controllers;

use App\Libraries\Access;
use App\Models\KelasModel;
use App\Models\MataKuliahModel;
use App\Models\PesertaKelasModel;
use App\Models\MahasiswaModel;
use App\Models\PresensiModel;
use App\Models\NilaiModel;
use App\Models\JenisPenilaianModel;

class PresensiController extends BaseController
{
    public function index()
    {
        $kelasModel = new KelasModel();
        $data = [
            'title'    => 'Presensi & Nilai',
            'kelasAll' => Access::visibleKelas(),
            'mkById'   => array_column((new MataKuliahModel())->findAll(), null, 'id'),
        ];
        return view('presensi/pilih', $data);
    }

    public function show(int $id)
    {
        $kelas = (new KelasModel())->find($id);
        if (! $kelas) return redirect()->to(site_url('presensi'))->with('error', 'Kelas tidak ditemukan.');
        if (! Access::canViewKelas($id)) return redirect()->to(site_url('presensi'))->with('error', 'Anda bukan pengampu kelas tersebut.');
        $mk = (new MataKuliahModel())->find($kelas['mk_id']);

        $mode = $this->request->getGet('mode') ?: 'presensi';
        $minggu = (int) ($this->request->getGet('minggu') ?: 1);

        $peserta = (new PesertaKelasModel())->where('kelas_id', $id)->findAll();
        $mhsById = array_column((new MahasiswaModel())->findAll(), null, 'id');
        $jenisPenilaian = (new JenisPenilaianModel())->where('rps_id', $kelas['rps_id'])->findAll();

        $presensiModel = new PresensiModel();
        $nilaiModel = new NilaiModel();

        $presensiMinggu = [];
        $nilaiPeserta = [];
        foreach ($peserta as $p) {
            $row = $presensiModel->where(['peserta_id' => $p['id'], 'pertemuan' => $minggu])->first();
            $presensiMinggu[$p['id']] = $row['status'] ?? '';

            $nRows = $nilaiModel->where('peserta_id', $p['id'])->findAll();
            $byJenis = [];
            foreach ($nRows as $nr) { $byJenis[$nr['jenis_penilaian_id']] = $nr['nilai']; }
            $nilaiPeserta[$p['id']] = $byJenis;
        }

        $data = [
            'title'          => 'Presensi & Nilai — ' . ($kelas['label'] ?? ''),
            'kelas'          => $kelas,
            'mk'             => $mk,
            'mode'           => $mode,
            'minggu'         => $minggu,
            'peserta'        => $peserta,
            'mhsById'        => $mhsById,
            'jenisPenilaian' => $jenisPenilaian,
            'presensiMinggu' => $presensiMinggu,
            'nilaiPeserta'   => $nilaiPeserta,
            'canWrite'       => Access::canWriteKelasData($id),
        ];
        return view('presensi/show', $data);
    }

    public function simpanPresensi(int $id)
    {
        if (! Access::canWriteKelasData($id)) return redirect()->to(site_url('presensi'))->with('error', 'Hanya dosen pengampu yang dapat mengisi presensi kelas ini.');
        $minggu = (int) $this->request->getPost('minggu');
        $status = $this->request->getPost('status'); // [peserta_id => 'H'|'I'|'S'|'A'|'']
        $model = new PresensiModel();

        if (is_array($status)) {
            $pesertaValid = array_map('intval', array_column((new PesertaKelasModel())->where('kelas_id', $id)->findAll(), 'id'));
            foreach ($status as $pesertaId => $st) {
                if (! in_array((int) $pesertaId, $pesertaValid, true) || ! in_array($st, ['', 'H', 'I', 'S', 'A'], true)) continue;
                $existing = $model->where(['peserta_id' => $pesertaId, 'pertemuan' => $minggu])->first();
                if ($st === '') {
                    if ($existing) $model->delete($existing['id']);
                    continue;
                }
                if ($existing) {
                    $model->update($existing['id'], ['status' => $st]);
                } else {
                    $model->insert(['peserta_id' => $pesertaId, 'pertemuan' => $minggu, 'status' => $st]);
                }
            }
        }
        return redirect()->to(site_url('presensi/' . $id) . '?mode=presensi&minggu=' . $minggu)->with('success', 'Presensi pertemuan ' . $minggu . ' disimpan.');
    }

    public function simpanNilai(int $id)
    {
        if (! Access::canWriteKelasData($id)) return redirect()->to(site_url('presensi'))->with('error', 'Hanya dosen pengampu yang dapat mengisi nilai kelas ini.');
        $nilai = $this->request->getPost('nilai'); // [peserta_id][jenis_id] = value
        $model = new NilaiModel();
        if (is_array($nilai)) {
            $pesertaValid = array_map('intval', array_column((new PesertaKelasModel())->where('kelas_id', $id)->findAll(), 'id'));
            $jenisValid = array_map('intval', array_column((new JenisPenilaianModel())->where('rps_id', (new KelasModel())->find($id)['rps_id'])->findAll(), 'id'));
            foreach ($nilai as $pesertaId => $jenisVals) {
                if (! in_array((int) $pesertaId, $pesertaValid, true) || ! is_array($jenisVals)) continue;
                foreach ($jenisVals as $jenisId => $val) {
                    if (! in_array((int) $jenisId, $jenisValid, true)) continue;
                    if ($val !== '' && (! is_numeric($val) || $val < 0 || $val > 100)) continue;
                    $existing = $model->where(['peserta_id' => $pesertaId, 'jenis_penilaian_id' => $jenisId])->first();
                    if ($val === '') {
                        if ($existing) $model->delete($existing['id']);
                        continue;
                    }
                    if ($existing) {
                        $model->update($existing['id'], ['nilai' => (float) $val]);
                    } else {
                        $model->insert(['peserta_id' => $pesertaId, 'jenis_penilaian_id' => $jenisId, 'nilai' => (float) $val]);
                    }
                }
            }
        }
        return redirect()->to(site_url('presensi/' . $id) . '?mode=nilai')->with('success', 'Nilai disimpan.');
    }
}
