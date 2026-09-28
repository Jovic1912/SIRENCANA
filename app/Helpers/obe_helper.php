<?php

if (! function_exists('status_label')) {
    function status_label(string $status): string
    {
        $map = [
            'draft'              => 'Draf',
            'diajukan'           => 'Diajukan',
            'diperiksa'          => 'Sedang Diperiksa GKM',
            'revisi_diperlukan'  => 'Revisi Diperlukan',
            'disetujui_gkm'      => 'Disetujui GKM',
            'ditandatangani'     => 'Ditandatangani',
            'diarsipkan'         => 'Diarsipkan',
        ];
        return $map[$status] ?? $status;
    }
}

if (! function_exists('status_badge')) {
    function status_badge(string $status): string
    {
        return '<span class="badge ' . esc($status) . '">' . esc(status_label($status)) . '</span>';
    }
}

if (! function_exists('nilai_huruf')) {
    function nilai_huruf(float $n): string
    {
        if ($n >= 85) return 'A';
        if ($n >= 80) return 'A-';
        if ($n >= 75) return 'B+';
        if ($n >= 70) return 'B';
        if ($n >= 65) return 'B-';
        if ($n >= 60) return 'C+';
        if ($n >= 55) return 'C';
        if ($n >= 40) return 'D';
        return 'E';
    }
}

if (! function_exists('skala_rubrik')) {
    function skala_rubrik(float $n): string
    {
        if ($n >= 80) return 'Sangat Baik';
        if ($n >= 65) return 'Baik';
        if ($n >= 50) return 'Cukup';
        return 'Kurang';
    }
}

if (! function_exists('skala_class')) {
    function skala_class(string $s): string
    {
        $map = ['Sangat Baik' => 'sangatbaik', 'Baik' => 'baik', 'Cukup' => 'cukup', 'Kurang' => 'kurang'];
        return $map[$s] ?? '';
    }
}

if (! function_exists('rekap_presensi')) {
    /**
     * @param array $presensiRows rows: ['pertemuan'=>int, 'status'=>'H'|'I'|'S'|'A']
     */
    function rekap_presensi(array $presensiRows, int $jumlahPertemuan = 16): array
    {
        $h = $i = $s = $a = 0;
        foreach ($presensiRows as $row) {
            switch ($row['status']) {
                case 'H': $h++; break;
                case 'I': $i++; break;
                case 'S': $s++; break;
                case 'A': $a++; break;
            }
        }
        $skor = $jumlahPertemuan > 0 ? round(($h / $jumlahPertemuan) * 1000) / 10 : 0;
        return ['h' => $h, 'i' => $i, 's' => $s, 'a' => $a, 'skor' => $skor, 'eligible' => $skor >= 75];
    }
}

if (! function_exists('nilai_akhir')) {
    /**
     * @param array $nilaiByJenisId  [jenis_penilaian_id => nilai]
     * @param array $jenisList       rows: ['id'=>, 'nama'=>, 'bobot'=>]
     */
    function nilai_akhir(array $nilaiByJenisId, array $jenisList): array
    {
        $sum = 0; $bobotTotal = 0;
        foreach ($jenisList as $j) {
            if (isset($nilaiByJenisId[$j['id']])) {
                $sum += ((float) $nilaiByJenisId[$j['id']]) * ((float) $j['bobot'] / 100);
                $bobotTotal += (float) $j['bobot'];
            }
        }
        $angka = round($sum * 100) / 100;
        return ['angka' => $angka, 'huruf' => nilai_huruf($angka), 'lengkap' => $bobotTotal >= 99.99];
    }
}

if (! function_exists('capaian_cpmk')) {
    /**
     * @param array $nilaiByJenisId [jenis_penilaian_id => nilai]
     * @param array $cpmkList       rows: ['id'=>,'kode'=>,'deskripsi'=>]
     * @param array $matriksRows    rows: ['jenis_penilaian_id'=>,'cpmk_id'=>,'bobot'=>]
     */
    function capaian_cpmk(array $nilaiByJenisId, array $cpmkList, array $matriksRows): array
    {
        $out = [];
        foreach ($cpmkList as $cp) {
            $rows = array_filter($matriksRows, fn ($m) => (int) $m['cpmk_id'] === (int) $cp['id'] && (float) $m['bobot'] > 0);
            $sum = 0; $bobotTotal = 0;
            foreach ($rows as $r) {
                if (! isset($nilaiByJenisId[$r['jenis_penilaian_id']])) continue;
                $sum += ((float) $nilaiByJenisId[$r['jenis_penilaian_id']]) * (float) $r['bobot'];
                $bobotTotal += (float) $r['bobot'];
            }
            $nilai = $bobotTotal > 0 ? round(($sum / $bobotTotal) * 100) / 100 : null;
            $out[] = [
                'cpmk'     => $cp,
                'nilai'    => $nilai,
                'skala'    => $nilai !== null ? skala_rubrik($nilai) : null,
                'lulus'    => $nilai !== null ? $nilai >= 65 : null,
                'ada_data' => $bobotTotal > 0,
            ];
        }
        return $out;
    }
}
