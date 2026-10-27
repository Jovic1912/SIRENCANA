<?= $this->extend('layout/print') ?>
<?= $this->section('content') ?>

<?php
  $logo = is_file(FCPATH . 'assets/logo-umrah.png') ? base_url('assets/logo-umrah.png') : null;
  $namaProdi = $prodi['nama'] ?? '…';
  $semesterMk = trim((string) ($mk['semester'] ?? '')) ?: '…';
  // Judul rencana asesmen: "RENCANA TUGAS MAHASISWA", ditambah nama bila berbeda dari kategorinya.
  $labelKategori = fn (array $j) => strtoupper(['proyek' => 'Proyek', 'lainnya' => 'Asesmen'][$j['kategori'] ?? ''] ?? kategori_penilaian($j['kategori'] ?? 'tugas'));
  $namaBeda = fn (array $j) => strcasecmp(trim($j['nama']), kategori_penilaian($j['kategori'] ?? 'tugas')) !== 0;
  $totalJenis = array_sum(array_map(fn ($j) => (float) $j['bobot'], $jenisList));
  $kolomCpl = $cplList ?: [['id' => 0, 'kode' => 'CPL …']];
?>

<!-- Sampul -->
<div class="sheet landscape" style="display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center">
  <h2 style="font-size:15pt">RENCANA PEMBELAJARAN SEMESTER</h2>
  <?php if ($logo): ?><img src="<?= $logo ?>" alt="Logo UMRAH" style="width:200px;margin:30px 0"><?php else: ?><div style="height:60px"></div><?php endif; ?>
  <table style="font-size:12pt;text-align:left;margin-top:10px">
    <tr><td style="width:190px">MATA KULIAH</td><td>: <?= esc($mk['nama'] ?? '…') ?></td></tr>
    <tr><td>KODE MATAKULIAH</td><td>: <?= esc($mk['kode'] ?? '…') ?></td></tr>
    <tr><td>SEMESTER</td><td>: <?= esc($semesterMk) ?></td></tr>
  </table>
</div>

<!-- Identitas & CP -->
<div class="sheet landscape">
  <table class="doc sm" style="table-layout:fixed">
    <colgroup><col style="width:13%"><col style="width:13%"><col style="width:10%"><col style="width:13%"><col style="width:9%"><col style="width:8%"><col style="width:8%"><col style="width:10%"><col style="width:16%"></colgroup>
    <tr>
      <td style="text-align:center;vertical-align:middle"><?php if ($logo): ?><img src="<?= $logo ?>" style="width:62px"><?php endif; ?></td>
      <td colspan="7" class="c" style="font-weight:bold;line-height:1.5">
        UNIVERSITAS MARITIM RAJA ALI HAJI<br>
        Fakultas <?= esc($prodi['fakultas'] ?? '…') ?><br>Jurusan <?= esc($prodi['jurusan'] ?? '…') ?><br>Program Studi <?= esc($namaProdi) ?>
      </td>
      <td><strong>Kode Dokumen</strong><br><?= esc($rps['kode_dokumen'] ?? '') ?></td>
    </tr>
    <tr><td colspan="9" class="c" style="background:#daeef3;font-weight:bold">RENCANA PEMBELAJARAN SEMESTER<br>(RPS)</td></tr>
    <tr>
      <th colspan="2">MATA KULIAH (MK)</th><th>KODE</th><th>Rumpun MK</th><th colspan="2">Sifat MK</th><th>BOBOT (sks)</th><th>SEMESTER</th><th>Tgl Penyusunan</th>
    </tr>
    <tr>
      <td colspan="2"><?= esc($mk['nama'] ?? '') ?></td>
      <td class="c"><?= esc($mk['kode'] ?? '') ?></td>
      <td><?= esc($mk['rumpun_mk'] ?? '') ?></td>
      <td colspan="2" class="c"><?= esc($mk['sifat_mk'] ?? '') ?></td>
      <td class="c"><?= esc($mk['sks'] ?? '') ?></td>
      <td class="c"><?= esc($mk['semester'] ?? '') ?></td>
      <td class="c"><?= ! empty($rps['tgl_penyusunan']) ? esc(tanggal_id($rps['tgl_penyusunan'])) : '' ?></td>
    </tr>
    <tr>
      <th colspan="2" rowspan="2">OTORISASI<br>Prodi <?= esc($namaProdi) ?></th>
      <th colspan="2">Pengembang RPS</th><th colspan="3">Dosen Pengampu Mata Kuliah</th><th colspan="2">Koor. Prodi</th>
    </tr>
    <tr>
      <td colspan="2" class="c"><?= esc($pengembang) ?></td>
      <td colspan="3" class="c"><?= esc(implode(', ', $pengampu)) ?></td>
      <td colspan="2" class="c"><?= esc($koorProdi) ?></td>
    </tr>
    <tr>
      <td rowspan="<?= count($cplList) + 1 ?>" class="label">Capaian Pembelajaran (CP)</td>
      <td class="label">Kode CPL dalam Kurikulum OBE Prodi</td>
      <td colspan="7" class="c" style="background:#f0f0f0;font-weight:bold">CPL Prodi <?= esc($namaProdi) ?> yang dibebankan pada Mata Kuliah <?= esc($mk['nama'] ?? '') ?></td>
    </tr>
    <?php foreach ($cplList as $c): ?>
      <tr><td><?= esc($c['kode']) ?></td><td colspan="7"><?= esc($c['deskripsi']) ?></td></tr>
    <?php endforeach; ?>
    <?php foreach ($cpmkList as $i => $c): ?>
      <tr>
        <?php if ($i === 0): ?><td rowspan="<?= count($cpmkList) ?>" class="label">Capaian Pembelajaran Mata Kuliah (CPMK)</td><?php endif; ?>
        <td><?= esc($c['kode']) ?></td><td colspan="7"><?= esc($c['deskripsi']) ?></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="2" class="label">Matriks CPMK terhadap CPL</td>
      <td colspan="7">
        <table class="doc sm" style="width:auto;margin:4px 0">
          <tr><th>CPMK</th><?php foreach ($kolomCpl as $c): ?><th><?= esc($c['kode']) ?></th><?php endforeach; ?></tr>
          <?php foreach ($cpmkList as $cp): ?>
            <tr><td><?= esc($cp['kode']) ?></td><?php foreach ($kolomCpl as $c): ?><td class="c"><?= lap_angka($cpmkCpl[$cp['id']][$c['id']] ?? '') ?></td><?php endforeach; ?></tr>
          <?php endforeach; ?>
        </table>
      </td>
    </tr>
    <tr><td colspan="2" class="label">Deskripsi MK</td><td colspan="7"><?= lap_teks($mk['deskripsi'] ?? '') ?></td></tr>
    <tr><td colspan="9" style="background:#f0f0f0;font-weight:bold">Sub Capaian Pembelajaran Mata Kuliah (Sub CPMK)</td></tr>
    <?php foreach ($subCpmk as $i => $s): ?>
      <tr><td colspan="2" class="c">Sub CPMK <?= $i + 1 ?></td><td colspan="7"><?= esc($s) ?></td></tr>
    <?php endforeach; ?>
    <?php if (! $subCpmk): ?><tr><td colspan="2" class="c">Sub CPMK …</td><td colspan="7"></td></tr><?php endif; ?>
    <tr><td colspan="2" class="label">Materi Bahan Kajian</td><td colspan="7"><?= lap_daftar($rps['bahan_kajian'] ?? '') ?></td></tr>
    <tr>
      <td colspan="2" class="label">Keterkaitan MK dengan Sustainable Development Goals (SDGs)</td>
      <td colspan="7">Mata kuliah ini berkontribusi pada pencapaian SDGs, khususnya:<?= lap_daftar($rps['sdgs'] ?? '') ?></td>
    </tr>
    <tr><td colspan="2" class="label">PUSTAKA</td><td colspan="7"><?= lap_daftar($rps['pustaka'] ?? '') ?></td></tr>
    <tr>
      <td colspan="2" class="label">MEDIA PEMBELAJARAN</td>
      <td colspan="4"><strong>Perangkat Lunak:</strong><br><?= lap_teks($rps['media_software'] ?? '', '') ?></td>
      <td colspan="3"><strong>Perangkat Keras:</strong><br><?= lap_teks($rps['media_hardware'] ?? '', '') ?></td>
    </tr>
    <tr><td colspan="2" class="label">Mata Kuliah Syarat (Jika ada)</td><td colspan="7"><?= esc($rps['mk_syarat'] ?: '-') ?></td></tr>
  </table>
</div>

<!-- A. Rancangan Pembelajaran -->
<div class="sheet landscape">
  <p class="sec">A. RANCANGAN PEMBELAJARAN</p>
  <table class="doc xs">
    <thead>
      <tr>
        <th rowspan="2" style="width:4%">Mg/ Mt Ke-</th>
        <th rowspan="2" style="width:11%">Kemampuan akhir yang diharapkan (Sub-CPMK)</th>
        <th rowspan="2" style="width:10%">Indikator Pencapaian</th>
        <th rowspan="2" style="width:11%">Materi/ Pokok Bahasan</th>
        <th rowspan="2" style="width:10%">Model Pembelajaran (sintaks/ langkah)</th>
        <th colspan="3">Bentuk Pembelajaran</th>
        <th colspan="2">Penilaian</th>
        <th rowspan="2" style="width:9%">Alokasi Waktu</th>
      </tr>
      <tr><th style="width:9%">Luring</th><th style="width:9%">Daring</th><th style="width:9%">Blended</th><th style="width:10%">Teknik dan Kriteria</th><th style="width:5%">Bobot</th></tr>
    </thead>
    <tbody>
      <?php foreach ($pertemuan as $p): ?>
        <?php if (($p['is_uts'] || $p['is_uas']) && trim((string) $p['sub_cpmk']) === ''): ?>
          <tr>
            <td class="c"><?= $p['minggu'] ?></td>
            <td colspan="8" class="c" style="font-weight:bold"><?= $p['is_uts'] ? 'Ujian Tengah Semester' : 'Ujian Akhir Semester' ?><?= trim((string) $p['penilaian']) !== '' ? '<br><span style="font-weight:normal">' . esc($p['penilaian']) . '</span>' : '' ?></td>
            <td class="c"><?= lap_angka($p['bobot'] ?: '') ?></td>
            <td class="pre"><?= esc($p['alokasi_waktu'] ?? '') ?></td>
          </tr>
        <?php else: ?>
          <tr>
            <td class="c"><?= $p['minggu'] ?></td>
            <?php foreach (['sub_cpmk', 'indikator', 'materi', 'model', 'luring', 'daring', 'blended', 'penilaian'] as $f): ?>
              <td class="pre"><?= esc($p[$f] ?? '') ?></td>
            <?php endforeach; ?>
            <td class="c"><?= lap_angka($p['bobot'] ?: '') ?></td>
            <td class="pre"><?= esc($p['alokasi_waktu'] ?? '') ?></td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
      <tr><td colspan="9" class="r"><strong>Total bobot</strong></td><td class="c"><strong><?= lap_angka(array_sum(array_column($pertemuan, 'bobot'))) ?></strong></td><td></td></tr>
    </tbody>
  </table>
  <p style="font-size:9pt"><strong>Ket: KBT: Kegiatan Belajar Terstruktur, KPT: Kegiatan Penugasan Terstruktur, KM: Kegiatan Mandiri</strong></p>
</div>

<!-- B–E -->
<div class="sheet">
  <p class="sec">B. Matrik Penilaian</p>
  <table class="doc" style="width:65%">
    <tr><th style="text-align:left">Jenis Penilaian</th><th style="width:30%">Bobot (%)</th></tr>
    <?php foreach ($jenisList as $j): ?>
      <tr><td><?= esc($j['nama']) ?><?= in_array($j['kategori'] ?? '', ['uts', 'uas'], true) ? '*' : '' ?></td><td class="c"><?= lap_angka($j['bobot']) ?></td></tr>
    <?php endforeach; ?>
    <tr><td><strong>Total</strong></td><td class="c"><strong><?= lap_angka($totalJenis) ?>%</strong></td></tr>
  </table>
  <p style="font-size:9pt;margin-top:-6px">*WAJIB ADA</p>

  <p class="sec">C. Matrik Penilaian terhadap CPMK</p>
  <table class="doc">
    <tr><th style="text-align:left">Jenis Penilaian</th><?php foreach ($cpmkList as $c): ?><th><?= esc($c['kode']) ?> (%)</th><?php endforeach; ?><th>Total (%)</th></tr>
    <?php $proporsi = []; ?>
    <?php foreach ($jenisList as $j): $rowT = 0; ?>
      <tr>
        <td><?= esc($j['nama']) ?><?= in_array($j['kategori'] ?? '', ['uts', 'uas'], true) ? '*' : '' ?></td>
        <?php foreach ($cpmkList as $c): $v = $matriks[$j['id']][$c['id']] ?? 0; $rowT += $v; $proporsi[$c['id']] = ($proporsi[$c['id']] ?? 0) + $v; ?>
          <td class="c"><?= $v ? lap_angka($v) : '' ?></td>
        <?php endforeach; ?>
        <td class="c"><?= lap_angka($rowT) ?></td>
      </tr>
    <?php endforeach; ?>
    <tr><td><strong>Proporsi</strong></td><?php foreach ($cpmkList as $c): ?><td class="c"><strong><?= lap_angka($proporsi[$c['id']] ?? 0) ?></strong></td><?php endforeach; ?><td class="c"><strong><?= lap_angka(array_sum($proporsi)) ?></strong></td></tr>
  </table>
  <p style="font-size:9pt;margin-top:-6px">*wajib ada</p>

  <p class="sec">D. Rubrik Penilaian</p>
  <?php foreach ($jenisList as $i => $j): ?>
    <p><strong><?= $i + 1 ?>. <?= esc($j['nama']) ?></strong><?= $namaBeda($j) ? ' <span style="font-size:9pt">(' . esc(kategori_penilaian($j['kategori'] ?? 'tugas')) . ')</span>' : '' ?></p>
    <div style="margin:0 0 8px 18px"><?= lap_teks($j['rubrik'] ?? '', 'Rubrik belum diisi') ?></div>
  <?php endforeach; ?>

  <p class="sec" style="margin-top:16px">E. PENGESAHAN RPS</p>
  <table class="doc">
    <tr>
      <td style="width:50%;background:#d9d9d9;vertical-align:middle">Dosen Pengembang RPS,</td>
      <td style="background:#d9d9d9">Menyetujui,<br>Universitas Maritim Raja Ali Haji<br>Prodi <?= esc($namaProdi) ?><br>Koor. Prodi</td>
    </tr>
    <tr>
      <td class="ttd" style="vertical-align:bottom"><?= $rps['ttd_dosen'] ? '<div style="font-size:9pt" class="muted">Ditandatangani elektronik di SIRENCANA</div>' : '' ?><strong><u><?= esc($pengembang) ?></u></strong></td>
      <td class="ttd" style="vertical-align:bottom"><?= $rps['ttd_kaprodi'] ? '<div style="font-size:9pt" class="muted">Ditandatangani elektronik di SIRENCANA</div>' : '' ?><strong><u><?= esc($koorProdi) ?></u></strong></td>
    </tr>
  </table>
  <table class="doc" style="width:50%;margin:10px auto">
    <tr><th>Penelaah,</th></tr>
    <tr><td class="ttd c" style="vertical-align:bottom;height:80px"><?= ($rps['status'] ?? '') === 'diarsipkan' ? '<div style="font-size:9pt" class="muted">Diarsipkan' . ($rps['arsip_lokasi'] ? ' — ' . esc($rps['arsip_lokasi']) : '') . '</div>' : '' ?>Gugus Penjamin Mutu</td></tr>
  </table>
</div>

<!-- Rencana Tugas / Quiz / Proyek / UTS / UAS -->
<?php foreach ($jenisList as $j): $label = $labelKategori($j); ?>
  <div class="sheet">
    <table class="doc sm">
      <tr>
        <td style="width:32%;text-align:center;vertical-align:middle;background:#b8cce4"><?php if ($logo): ?><img src="<?= $logo ?>" style="width:90px"><?php endif; ?></td>
        <td colspan="1" style="background:#b8cce4;font-weight:bold">
          NAMA PERGURUAN TINGGI : UNIVERSITAS MARITIM RAJA ALI HAJI<br>
          NAMA FAKULTAS : <?= esc($prodi['fakultas'] ?? '…') ?><br>
          NAMA JURUSAN / PRODI : <?= esc(gabung_teks([$prodi['jurusan'] ?? '', $namaProdi], ' / ')) ?>
        </td>
      </tr>
      <tr><td colspan="2" class="c" style="background:#b8cce4;font-weight:bold">RENCANA <?= esc($label) ?> MAHASISWA<?= $namaBeda($j) ? ' — ' . esc(strtoupper($j['nama'])) : '' ?></td></tr>
      <tr><td class="label">MATA KULIAH</td><td><?= esc($mk['nama'] ?? '') ?></td></tr>
      <tr><td class="label">KODE</td><td><?= esc($mk['kode'] ?? '') ?></td></tr>
      <tr><td class="label">DOSEN PENGAMPU</td><td><?= esc(implode(', ', $pengampu)) ?></td></tr>
      <?php
        $baris = [
          'BENTUK ' . $label            => lap_teks($j['judul'] ?? ''),
          'SUB CAPAIAN PEMBELAJARAN MATA KULIAH' => lap_teks($j['sub_cpmk'] ?? ''),
          'DESKRIPSI ' . $label         => lap_teks($j['deskripsi'] ?? ''),
          'METODE PENGERJAAN ' . $label => lap_daftar($j['metode'] ?? ''),
          'BENTUK DAN FORMAT LUARAN'    => '<strong>a. Obyek Garapan:</strong> ' . lap_teks($j['luaran_objek'] ?? '') . '<br><strong>b. Bentuk Luaran:</strong> ' . lap_teks($j['luaran_bentuk'] ?? ''),
          'INDIKATOR, KRITERIA, DAN BOBOT PENILAIAN' => '<strong>Indikator</strong><br>' . lap_teks($j['indikator'] ?? '') . '<br><strong>Kriteria</strong><br>' . lap_teks($j['kriteria'] ?? '') . '<br><strong>Bobot Penilaian</strong><br>' . lap_angka($j['bobot']) . '%',
          'JADWAL PELAKSANAAN'          => lap_teks($j['jadwal'] ?? ''),
          'LAIN-LAIN'                   => lap_teks($j['lain_lain'] ?? '', '-'),
          'DAFTAR RUJUKAN'              => lap_daftar($j['rujukan'] ?? ''),
        ];
      ?>
      <?php foreach ($baris as $judul => $isi): ?>
        <tr><td colspan="2" style="background:#d9d9d9;font-weight:bold"><?= esc($judul) ?></td></tr>
        <tr><td colspan="2"><?= $isi ?></td></tr>
      <?php endforeach; ?>
    </table>
  </div>
<?php endforeach; ?>

<?= $this->endSection() ?>
