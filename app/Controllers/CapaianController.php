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
use App\Models\MatriksPenilaianModel;
use App\Models\CpmkModel;

class CapaianController extends BaseController
{
    public function index()
    {
        $data = [
            'title'    => 'Capaian CPMK — Laporan OBE',
            'kelasAll' => Access::visibleKelas(),
            'mkById'   => array_column((new MataKuliahModel())->findAll(), null, 'id'),
        ];
        return view('capaian/pilih', $data);
    }

    /**
     * Menghitung capaian CPMK & rekap presensi untuk seluruh peserta satu kelas.
     * Dipakai bersama oleh CapaianController & PortofolioController.
     */
    public static function hitung(array $kelas): array
    {
        $mk = (new MataKuliahModel())->find($kelas['mk_id']);
        $peserta = (new PesertaKelasModel())->where('kelas_id', $kelas['id'])->findAll();
        $mhsById = array_column((new MahasiswaModel())->findAll(), null, 'id');
        $cpmkList = (new CpmkModel())->where('mk_id', $kelas['mk_id'])->findAll();
        $jenisList = (new JenisPenilaianModel())->where('rps_id', $kelas['rps_id'])->findAll();
        $matriksRows = (new MatriksPenilaianModel())->where('rps_id', $kelas['rps_id'])->findAll();

        $presensiModel = new PresensiModel();
        $nilaiModel = new NilaiModel();

        $rows = [];
        foreach ($peserta as $p) {
            $presensiRows = $presensiModel->where('peserta_id', $p['id'])->findAll();
            $nilaiRows = $nilaiModel->where('peserta_id', $p['id'])->findAll();
            $nilaiByJenis = [];
            foreach ($nilaiRows as $n) { $nilaiByJenis[$n['jenis_penilaian_id']] = $n['nilai']; }

            $pres = rekap_presensi($presensiRows, (int) ($kelas['jumlah_pertemuan'] ?? 16));
            $capaian = capaian_cpmk($nilaiByJenis, $cpmkList, $matriksRows);
            // Mahasiswa yang tidak boleh ikut UAS dinyatakan tidak lulus seluruh CPMK (format UMRAH).
            foreach ($capaian as &$c) {
                $c['tidak_eligible'] = ! $pres['eligible'];
                if (! $pres['eligible'] && $c['nilai'] !== null) $c['lulus'] = false;
            }
            unset($c);

            $rows[] = [
                'peserta'       => $p,
                'mhs'           => $mhsById[$p['mahasiswa_id']] ?? null,
                'pres'          => $pres,
                'presensiRows'  => array_column($presensiRows, 'status', 'pertemuan'),
                'nilaiByJenis'  => $nilaiByJenis,
                'akhir'         => nilai_akhir($nilaiByJenis, $jenisList),
                'capaian'       => $capaian,
            ];
        }

        $summary = [];
        foreach ($cpmkList as $cp) {
            $vals = [];
            foreach ($rows as $r) {
                foreach ($r['capaian'] as $c) {
                    if ($c['cpmk']['id'] === $cp['id'] && $c['nilai'] !== null) $vals[] = $c;
                }
            }
            $eligibleVals = array_filter($vals, fn ($v) => ! $v['tidak_eligible']);
            $count = fn ($skala) => count(array_filter($eligibleVals, fn ($v) => $v['skala'] === $skala));
            $tercapai = $count('Sangat Baik') + $count('Baik') + $count('Cukup');
            $summary[] = [
                'cpmk'        => $cp,
                'total'       => count($vals),
                'sb'          => $count('Sangat Baik'),
                'b'           => $count('Baik'),
                'c'           => $count('Cukup'),
                'k'           => $count('Kurang'),
                'tidakLulus'  => count($vals) - count($eligibleVals),
                'persenLulus' => count($vals) ? round($tercapai / count($vals) * 1000) / 10 : 0,
            ];
        }

        return ['mk' => $mk, 'cpmkList' => $cpmkList, 'jenisList' => $jenisList, 'matriksRows' => $matriksRows, 'rows' => $rows, 'summary' => $summary];
    }

    public function show(int $id)
    {
        $kelas = (new KelasModel())->find($id);
        if (! $kelas) return redirect()->to(site_url('capaian'))->with('error', 'Kelas tidak ditemukan.');
        if (! Access::canViewKelas($id)) return redirect()->to(site_url('capaian'))->with('error', 'Anda bukan pengampu kelas tersebut.');

        $hasil = self::hitung($kelas);
        $data = array_merge($hasil, [
            'title' => 'Capaian CPMK — ' . ($hasil['mk']['nama'] ?? ''),
            'kelas' => $kelas,
        ]);
        return view('capaian/show', $data);
    }
}
