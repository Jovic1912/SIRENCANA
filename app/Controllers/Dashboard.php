<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\RpsModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $rpsModel = new RpsModel();
        $rpsAll   = $rpsModel->findAll();

        $statusOrder = ['draft', 'diajukan', 'diperiksa', 'revisi_diperlukan', 'disetujui_gkm', 'ditandatangani', 'diarsipkan'];
        $statusCount = array_fill_keys($statusOrder, 0);
        foreach ($rpsAll as $r) {
            $statusCount[$r['status']] = ($statusCount[$r['status']] ?? 0) + 1;
        }

        $perluAksi = array_filter($rpsAll, fn ($r) => in_array($r['status'], ['diajukan', 'diperiksa', 'revisi_diperlukan', 'disetujui_gkm'], true));

        $mkModel = new MataKuliahModel();
        $mk      = $mkModel->findAll();
        $mkById  = [];
        foreach ($mk as $m) { $mkById[$m['id']] = $m; }

        $data = [
            'title'       => 'Dasbor',
            'jumlahMk'    => count($mk),
            'jumlahRps'   => count($rpsAll),
            'jumlahKelas' => (new KelasModel())->countAllResults(),
            'jumlahMhs'   => (new MahasiswaModel())->countAllResults(),
            'statusCount' => $statusCount,
            'statusOrder' => $statusOrder,
            'perluAksi'   => $perluAksi,
            'mkById'      => $mkById,
        ];

        return view('dashboard', $data);
    }
}
