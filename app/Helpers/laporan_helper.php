<?php
/**
 * Fungsi bantu tampilan dokumen cetak (format OBE UMRAH).
 */

if (! function_exists('lap_baris')) {
    /** Teks multi-baris → array baris tak kosong. */
    function lap_baris(?string $teks): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $teks)), fn ($b) => $b !== ''));
    }
}

if (! function_exists('lap_daftar')) {
    /** Teks multi-baris → <ol>; satu baris → teks biasa; kosong → penanda isian. */
    function lap_daftar(?string $teks, string $kosong = '…'): string
    {
        $baris = lap_baris($teks);
        if (! $baris) return '<span class="muted">' . esc($kosong) . '</span>';
        if (count($baris) === 1) return esc($baris[0]);
        return '<ol>' . implode('', array_map(fn ($b) => '<li>' . esc(preg_replace('/^\d+[.)]\s*/', '', $b)) . '</li>', $baris)) . '</ol>';
    }
}

if (! function_exists('lap_teks')) {
    function lap_teks(?string $teks, string $kosong = '…'): string
    {
        return trim((string) $teks) !== '' ? '<span class="pre">' . esc($teks) . '</span>' : '<span class="muted">' . esc($kosong) . '</span>';
    }
}

if (! function_exists('lap_angka')) {
    /** Angka tanpa nol berlebih: 30.00 → 30, 12.50 → 12,5 */
    function lap_angka($n): string
    {
        if ($n === null || $n === '') return '';
        return str_replace('.', ',', rtrim(rtrim(number_format((float) $n, 2, '.', ''), '0'), '.'));
    }
}
