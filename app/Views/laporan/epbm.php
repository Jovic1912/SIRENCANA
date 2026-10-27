<?= $this->extend('layout/print') ?>
<?= $this->section('content') ?>

<?php
  $logo = is_file(FCPATH . 'assets/logo-umrah.png') ? base_url('assets/logo-umrah.png') : null;
  $judulSmt = 'SEMESTER ' . strtoupper($epbm['semester']) . ' TA. ' . $epbm['tahun_akademik'];
  $tahun = substr((string) $epbm['tahun_akademik'], -4) ?: date('Y');
  $band = fn (string $t) => '<div class="band navy" style="margin-bottom:12px">' . esc($t) . '</div>';
  $tabel = 0;
  $daftarTabel = [];
  $namaTabel = function (string $judul) use (&$tabel, &$daftarTabel) { $tabel++; $daftarTabel[] = "Tabel {$tabel}. {$judul}"; return "Tabel {$tabel}. {$judul}"; };
  // Siapkan judul tabel lebih dulu agar Daftar Tabel lengkap
  $tJumlah = $namaTabel('Jumlah Mahasiswa per Program Studi');
  $tMk     = $namaTabel('Rekapitulasi Evaluasi Mata Kuliah');
  $tDosen  = $namaTabel('Rekapitulasi Kinerja Dosen Pengampu');
  $paragraf = fn (?string $t, string $kosong = '') => trim((string) $t) !== '' ? '<div class="pre" style="text-align:justify">' . esc($t) . '</div>' : ($kosong ? '<p class="muted">' . esc($kosong) . '</p>' : '');
?>

<!-- Sampul -->
<div class="sheet" style="display:flex;flex-direction:column;justify-content:space-between;font-size:14pt">
  <div style="display:flex;gap:16px;align-items:center">
    <?php if ($logo): ?><img src="<?= $logo ?>" style="width:90px"><?php endif; ?>
    <div>LAPORAN<br>EVALUASI PROSES BELAJAR MENGAJAR<br>(EPBM)<br><span style="font-size:12pt"><?= esc($judulSmt) ?></span></div>
  </div>
  <div style="font-size:18pt">
    JURUSAN <?= esc(strtoupper($epbm['jurusan'])) ?>
    <ul style="font-size:14pt">
      <?php foreach ($prodiList as $p): ?><li>PROGRAM STUDI <?= esc(strtoupper($p['nama'])) ?></li><?php endforeach; ?>
      <?php if (! $prodiList): ?><li>PROGRAM STUDI …</li><?php endif; ?>
    </ul>
  </div>
  <div class="right">
    GUGUS KENDALI MUTU<br>JURUSAN <?= esc(strtoupper($epbm['jurusan'])) ?><br>FAKULTAS <?= esc(strtoupper(preg_replace('/^fakultas\s+/i', '', $epbm['fakultas']))) ?><br>UNIVERSITAS MARITIM RAJA ALI HAJI<br>TAHUN <?= esc($tahun) ?>
  </div>
</div>

<!-- Tim GKM -->
<div class="sheet">
  <p><strong>Tim Gugus Kendali Mutu (GKM)<br>Jurusan <?= esc($epbm['jurusan']) ?></strong></p>
  <table style="margin-top:10px">
    <tr><td style="width:110px;vertical-align:top">Ketua</td><td style="vertical-align:top">: <?= esc($epbm['ketua_gkm'] ?: '…') ?></td></tr>
    <tr>
      <td style="vertical-align:top">Anggota</td>
      <td style="vertical-align:top">: <?php $ang = lap_baris($epbm['anggota_gkm'] ?? ''); echo $ang ? esc(array_shift($ang)) : '…'; foreach ($ang as $a) { echo '<br>&nbsp;&nbsp;' . esc($a); } ?></td>
    </tr>
  </table>
</div>

<!-- Prakata -->
<div class="sheet">
  <?= $band('PRAKATA') ?>
  <?= $paragraf($epbm['prakata'] ?? '', 'Prakata belum diisi.') ?>
</div>

<!-- Daftar Isi, Tabel, Lampiran -->
<div class="sheet">
  <?= $band('DAFTAR ISI') ?>
  <ol style="list-style:none;padding-left:0;line-height:1.8">
    <li>PRAKATA</li><li>DAFTAR ISI</li><li>DAFTAR TABEL</li><li>DAFTAR GAMBAR</li><li>DAFTAR LAMPIRAN</li>
    <li>PENDAHULUAN<ol type="a"><li>Latar Belakang</li><li>Tujuan</li><li>Jumlah Mahasiswa</li></ol></li>
    <li>METODE PELAKSANAAN</li>
    <li>HASIL EVALUASI<ol type="a"><li>Evaluasi Mata Kuliah</li><li>Evaluasi Dosen</li><li>Tingkat Kepuasan Mahasiswa</li><li>Kelulusan Mahasiswa</li></ol></li>
    <li>SIMPULAN</li><li>LAMPIRAN</li>
  </ol>
  <div style="height:18px"></div>
  <?= $band('DAFTAR TABEL') ?>
  <?php foreach ($daftarTabel as $t): ?><p><?= esc($t) ?></p><?php endforeach; ?>
  <div style="height:18px"></div>
  <?= $band('DAFTAR GAMBAR') ?>
  <p>-</p>
  <div style="height:18px"></div>
  <?= $band('DAFTAR LAMPIRAN') ?>
  <?php foreach ($prodiList as $i => $p): ?><p>Lampiran <?= $i + 1 ?>. Rekapitulasi Penilaian Mata Kuliah Prodi <?= esc($p['nama']) ?></p><?php endforeach; ?>
</div>

<!-- Pendahuluan -->
<div class="sheet">
  <?= $band('PENDAHULUAN') ?>
  <p><strong>a. Latar Belakang</strong></p><?= $paragraf($epbm['latar_belakang'] ?? '') ?>
  <p style="margin-top:10px"><strong>b. Tujuan</strong></p><?= $paragraf($epbm['tujuan'] ?? '') ?>
  <p style="margin-top:10px"><strong>c. Jumlah Mahasiswa</strong></p>
  <p class="center"><?= esc($tJumlah) ?></p>
  <table class="doc" style="width:75%;margin:0 auto 10px">
    <tr><th style="width:10%">No</th><th>Program Studi</th><th style="width:25%">Jumlah Mahasiswa</th></tr>
    <?php foreach ($prodiList as $i => $p): ?><tr><td class="c"><?= $i + 1 ?></td><td><?= esc($p['nama']) ?></td><td class="c"><?= $jumlahMhs[$p['id']] ?? 0 ?></td></tr><?php endforeach; ?>
    <tr><td></td><td><strong>Jumlah</strong></td><td class="c"><strong><?= array_sum($jumlahMhs) ?></strong></td></tr>
  </table>

  <div style="height:14px"></div>
  <?= $band('METODE PELAKSANAAN') ?>
  <?= $paragraf($epbm['metode'] ?? '', 'Metode pelaksanaan belum diisi.') ?>
</div>

<!-- Hasil Evaluasi -->
<div class="sheet landscape">
  <?= $band('HASIL EVALUASI') ?>
  <p><strong>a. Evaluasi Mata Kuliah</strong></p>
  <?= $paragraf($epbm['evaluasi_mk'] ?? '') ?>
  <p class="center"><?= esc($tMk) ?></p>
  <table class="doc xs">
    <tr><th>No</th><th>Prodi</th><th>Mata Kuliah</th><th>Kelas</th><th>Dosen Pengampu</th><th>Peserta</th><th>Rata-rata Nilai</th><th>% Lulus (≥ C)</th><th>Kehadiran Mhs (%)</th><th>Tatap Muka</th><th>CPMK Tercapai</th><th>RPS Sah</th><th>Kontrak</th><th>Portofolio</th><th>Status MK</th></tr>
    <?php foreach ($kelasRows as $i => $r): ?>
      <tr>
        <td class="c"><?= $i + 1 ?></td><td><?= esc($r['prodi']['nama'] ?? '') ?></td>
        <td><?= esc($r['mk']['kode'] . ' ' . $r['mk']['nama']) ?></td><td class="c"><?= esc($r['kelas']['label']) ?></td>
        <td><?= esc(implode(', ', $r['dosen'])) ?></td><td class="c"><?= $r['peserta'] ?></td>
        <td class="c"><?= $r['rata'] !== null ? lap_angka($r['rata']) : '-' ?></td>
        <td class="c"><?= $r['persenLulus'] !== null ? lap_angka($r['persenLulus']) . '%' : '-' ?></td>
        <td class="c"><?= $r['hadir'] !== null ? lap_angka($r['hadir']) : '-' ?></td>
        <td class="c"><?= $r['realisasi'] ?>/<?= $r['pertemuan'] ?></td>
        <td class="c"><?= $r['cpmkTercapai'] ?>/<?= $r['cpmkTotal'] ?></td>
        <td class="c"><?= $r['rpsSah'] ? '✓' : '—' ?></td><td class="c"><?= $r['kontrakTtd'] ? '✓' : '—' ?></td>
        <td class="c"><?= esc($r['kelengkapan']) ?></td>
        <td class="c"><?= $r['tercapai'] === null ? '-' : ($r['tercapai'] ? 'Tercapai' : 'Tidak tercapai') ?></td>
      </tr>
    <?php endforeach; ?>
    <?php if (! $kelasRows): ?><tr><td colspan="15" class="c muted">Tidak ada kelas pada semester ini.</td></tr><?php endif; ?>
  </table>
  <p style="font-size:8pt">Status MK tercapai bila ≥ 50% peserta memperoleh nilai akhir ≥ 55 (minimal C). CPMK tercapai bila persentase kelulusan CPMK ≥ 50%.</p>

  <p style="margin-top:10px"><strong>b. Evaluasi Dosen</strong></p>
  <?= $paragraf($epbm['evaluasi_dosen'] ?? '') ?>
  <p class="center"><?= esc($tDosen) ?></p>
  <table class="doc xs">
    <tr><th>No</th><th>Nama Dosen</th><th>Kelas Diampu</th><th>Realisasi Tatap Muka</th><th>% Kehadiran Dosen</th><th>Kontrak Disepakati</th><th>Portofolio Lengkap</th></tr>
    <?php foreach ($perDosen as $i => $d): ?>
      <tr>
        <td class="c"><?= $i + 1 ?></td><td><?= esc($d['nama']) ?></td><td><?= esc(implode(', ', $d['kelas'])) ?></td>
        <td class="c"><?= $d['realisasi'] ?>/<?= $d['pertemuan'] ?></td>
        <td class="c"><?= $d['pertemuan'] ? lap_angka(round($d['realisasi'] / $d['pertemuan'] * 100, 2)) : '-' ?>%</td>
        <td class="c"><?= $d['kontrak'] ?>/<?= count($d['kelas']) ?></td><td class="c"><?= $d['portofolio'] ?>/<?= count($d['kelas']) ?></td>
      </tr>
    <?php endforeach; ?>
    <?php if (! $perDosen): ?><tr><td colspan="7" class="c muted">Tidak ada data dosen.</td></tr><?php endif; ?>
  </table>

  <p style="margin-top:10px"><strong>c. Tingkat Kepuasan Mahasiswa</strong></p>
  <?= $paragraf($epbm['kepuasan_mahasiswa'] ?? '', '(Hasil evaluasi tingkat kepuasan mahasiswa dari setiap program studi pada semester tersebut)') ?>

  <p style="margin-top:10px"><strong>d. Kelulusan Mahasiswa</strong></p>
  <?= $paragraf($epbm['kelulusan'] ?? '', '(Hasil evaluasi kelulusan mahasiswa yang sudah yudisium dari setiap program studi pada semester tersebut)') ?>
</div>

<!-- Simpulan -->
<div class="sheet">
  <?= $band('SIMPULAN') ?>
  <?= $paragraf($epbm['simpulan'] ?? '', 'Simpulan belum diisi.') ?>
</div>

<!-- Lampiran -->
<div class="sheet landscape">
  <?= $band('LAMPIRAN') ?>
  <?php foreach ($prodiList as $i => $p): ?>
    <p><strong>Lampiran <?= $i + 1 ?>. Rekapitulasi Penilaian Mata Kuliah Prodi <?= esc($p['nama']) ?></strong></p>
    <?php $baris = array_values(array_filter($kelasRows, fn ($r) => (int) ($r['prodi']['id'] ?? 0) === (int) $p['id'])); ?>
    <table class="doc xs">
      <tr><th>No</th><th>Kode</th><th>Mata Kuliah</th><th>Kelas</th><th>Peserta</th><th>Rata-rata</th><th>% Lulus</th><th>CPMK Tercapai</th></tr>
      <?php foreach ($baris as $j => $r): ?>
        <tr><td class="c"><?= $j + 1 ?></td><td><?= esc($r['mk']['kode']) ?></td><td><?= esc($r['mk']['nama']) ?></td><td class="c"><?= esc($r['kelas']['label']) ?></td><td class="c"><?= $r['peserta'] ?></td><td class="c"><?= $r['rata'] !== null ? lap_angka($r['rata']) : '-' ?></td><td class="c"><?= $r['persenLulus'] !== null ? lap_angka($r['persenLulus']) . '%' : '-' ?></td><td class="c"><?= $r['cpmkTercapai'] ?>/<?= $r['cpmkTotal'] ?></td></tr>
      <?php endforeach; ?>
      <?php if (! $baris): ?><tr><td colspan="8" class="c muted">Tidak ada kelas.</td></tr><?php endif; ?>
    </table>
  <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
