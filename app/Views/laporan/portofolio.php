<?= $this->extend('layout/print') ?>
<?= $this->section('content') ?>

<?php
  $nPertemuan = (int) ($kelas['jumlah_pertemuan'] ?? 16);
  $matriksIdx = [];
  foreach ($matriksRows as $m) { $matriksIdx[$m['jenis_penilaian_id']][$m['cpmk_id']] = (float) $m['bobot']; }
  $proporsi = [];
  foreach ($cpmkList as $c) {
      $proporsi[$c['id']] = array_sum(array_map(fn ($j) => $matriksIdx[$j['id']][$c['id']] ?? 0, $jenisList));
  }
  $semesterTa = gabung_teks([$kelas['semester'], $kelas['tahun_akademik']]);
  $persenHadirMhs = $rows ? round(array_sum(array_map(fn ($r) => $r['pres']['skor'], $rows)) / count($rows), 2) : 0;
  $persenHadirDosen = $nPertemuan ? round($realisasi / $nPertemuan * 100, 2) : 0;
  $statusPres = fn ($r) => $r['pres']['eligible'] ? 'OK' : 'TIDAK BISA UAS';
  $kodeStatus = fn ($s) => $s === 'A' ? 'TK' : $s;
  $skalaKelas = ['Sangat Baik' => 'sk-sb', 'Baik' => 'sk-b', 'Cukup' => 'sk-c', 'Kurang' => 'sk-k'];

  // Kotak identitas yang berulang di tiap sheet
  $identitas = function (string $judul) use ($prodi, $kelas, $mk, $pengampu, $semesterTa) {
      ob_start(); ?>
      <?= view('laporan/_kop', ['prodi' => $prodi, 'judul' => $judul]) ?>
      <table class="doc sm" style="margin-top:-1px">
        <tr><td style="width:60%">Tahun Akademik: <?= esc($kelas['tahun_akademik']) ?></td><td>Semester: <?= esc($kelas['semester']) ?></td></tr>
        <tr><td>Nama MK: <?= esc($mk['nama'] ?? '') ?></td><td>Kode: <?= esc($mk['kode'] ?? '') ?></td></tr>
        <tr><td>Kelas: <?= esc($kelas['label']) ?></td><td>SKS: <?= esc($mk['sks'] ?? '') ?></td></tr>
        <tr><td colspan="2">Dosen Pengampu:<?php foreach ($pengampu as $i => $d): ?><br>&nbsp;&nbsp;<?= $i + 1 ?>) <?= esc($d) ?><?php endforeach; ?></td></tr>
      </table>
      <?php return ob_get_clean();
  };
?>

<!-- Daftar isi -->
<div class="sheet">
  <h2 class="center" style="margin-bottom:10px">Daftar Isi Portofolio Mata Kuliah</h2>
  <p class="center"><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? '')) ?> · Kelas <?= esc($kelas['label']) ?> · <?= esc($semesterTa) ?></p>
  <table class="doc">
    <tr><th style="width:8%">No.</th><th>Bagian</th><th>Keterangan</th></tr>
    <?php
      $isi = [
        ['Master Data', 'Identitas mata kuliah dan daftar peserta'],
        ['Matriks Asesmen', 'Bobot tiap bentuk penilaian terhadap tiap CPMK'],
        ['0. Daftar Kelengkapan Portofolio', 'Status kelengkapan dokumen'],
        ['1. Portofolio MK', 'Deskripsi proses pembelajaran'],
        ['2–4, 6. RPS, Kontrak Kuliah, Presensi SIPA, Soal Ujian', 'Tautan dokumen'],
        ['5. Rekap Presensi', 'Presensi mahasiswa'],
        ['7. Rekap Nilai', 'Nilai mahasiswa'],
      ];
      foreach ($cpmkList as $i => $c) { $isi[] = [(8 + $i) . '. ' . $c['kode'], 'Asesmen capaian ' . $c['kode']]; }
      $isi[] = [(8 + count($cpmkList)) . '. Laporan OBE', 'Rekapitulasi hasil capaian pembelajaran mata kuliah'];
    ?>
    <?php foreach ($isi as $i => [$a, $b]): ?><tr><td class="c"><?= $i + 1 ?></td><td><?= esc($a) ?></td><td><?= esc($b) ?></td></tr><?php endforeach; ?>
  </table>
</div>

<!-- Master Data -->
<div class="sheet">
  <div class="band" style="background:#4f81bd;color:#fff">MASTER DATA</div>
  <table class="doc sm" style="margin-top:-1px">
    <?php
      $master = [
        'Tahun Akademik' => $kelas['tahun_akademik'], 'Nama MK' => $mk['nama'] ?? '', 'Kode MK' => $mk['kode'] ?? '',
        'SKS' => $mk['sks'] ?? '', 'Semester' => $kelas['semester'], 'Kelas' => $kelas['label'],
        'Jumlah Dosen Pengampu' => count($pengampu),
      ];
      foreach ($pengampu as $i => $d) { $master['Nama Dosen Pengampu ' . ($i + 1)] = $d; }
      $master += ['Koordinator Program Studi' => $koorProdi, 'Jumlah Mahasiswa' => count($rows), 'Jumlah Pertemuan' => $nPertemuan,
                  'Fakultas' => $prodi['fakultas'] ?? '', 'Jurusan' => $prodi['jurusan'] ?? '', 'Program Studi' => $prodi['nama'] ?? ''];
      $romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII','XIII','XIV','XV','XVI','XVII','XVIII'];
      $no = 0;
    ?>
    <?php foreach ($master as $k => $v): ?>
      <tr><td style="width:7%"><?= $romawi[$no++] ?? $no ?></td><td style="width:45%"><?= esc($k) ?></td><td><?= esc($v) ?></td></tr>
    <?php endforeach; ?>
  </table>
  <div class="band" style="background:#4f81bd;color:#fff">DAFTAR PESERTA KULIAH</div>
  <table class="doc sm" style="margin-top:-1px">
    <tr><th style="width:7%">No</th><th>NIM</th><th>NAMA</th></tr>
    <?php foreach ($rows as $i => $r): ?>
      <tr><td class="c"><?= $i + 1 ?></td><td><?= esc($r['mhs']['nim'] ?? '—') ?></td><td><?= esc($r['mhs']['nama'] ?? '—') ?></td></tr>
    <?php endforeach; ?>
  </table>
</div>

<!-- Matriks Asesmen -->
<div class="sheet landscape">
  <div class="band orange">MATRIK PENILAIAN TERHADAP CPMK</div>
  <table class="doc" style="margin-top:-1px">
    <tr><th>ASESMEN</th><?php foreach ($cpmkList as $c): ?><th><?= esc($c['kode']) ?></th><?php endforeach; ?><th>TOTAL</th></tr>
    <?php foreach ($jenisList as $j): $t = 0; ?>
      <tr>
        <td><?= esc($j['nama']) ?></td>
        <?php foreach ($cpmkList as $c): $v = $matriksIdx[$j['id']][$c['id']] ?? 0; $t += $v; ?><td class="c"><?= $v ? lap_angka($v) . '%' : '' ?></td><?php endforeach; ?>
        <td class="c"><strong><?= lap_angka($t) ?>%</strong></td>
      </tr>
    <?php endforeach; ?>
    <tr><th>PROPORSI</th><?php foreach ($cpmkList as $c): ?><th><?= lap_angka($proporsi[$c['id']]) ?>%</th><?php endforeach; ?><th><?= lap_angka(array_sum($proporsi)) ?>%</th></tr>
  </table>
</div>

<!-- 0. Daftar Kelengkapan -->
<div class="sheet">
  <?= $identitas('DAFTAR KELENGKAPAN PORTOFOLIO MATA KULIAH') ?>
  <table class="doc sm">
    <tr><th rowspan="2" style="width:7%">No.</th><th rowspan="2">Daftar Kelengkapan Portofolio MK</th><th colspan="2">Status Kelengkapan</th></tr>
    <tr><th style="width:14%">Ada</th><th style="width:14%">Tidak Ada</th></tr>
    <?php $no = 0; ?>
    <?php foreach (kelengkapan_portofolio() as $k => $label): ?>
      <?php if (in_array($k, ['soal_uas', 'soal_proyek'], true)) continue; ?>
      <?php if ($k === 'soal_uts'): $no++; ?>
        <tr><td class="c" rowspan="4"><?= $no ?></td><td>Soal Asesmen:</td><td></td><td></td></tr>
        <?php foreach (['soal_uts' => 'a) UTS*', 'soal_uas' => 'b) UAS*', 'soal_proyek' => 'c) Proyek/Case Method*'] as $sk => $sl): ?>
          <tr><td style="padding-left:20px"><?= $sl ?></td><td class="c"><?= ! empty($kelengkapan[$sk]) ? '✓' : '' ?></td><td class="c"><?= empty($kelengkapan[$sk]) ? '✓' : '' ?></td></tr>
        <?php endforeach; ?>
        <?php continue; ?>
      <?php endif; $no++; ?>
      <tr><td class="c"><?= $no ?></td><td><?= esc($label) ?></td><td class="c"><?= ! empty($kelengkapan[$k]) ? '✓' : '' ?></td><td class="c"><?= empty($kelengkapan[$k]) ? '✓' : '' ?></td></tr>
    <?php endforeach; ?>
    <tr><td colspan="4" style="font-size:9pt"><strong><u>Catatan:</u></strong><br>1. *) Coret yang tidak perlu<br>2. Berilah tanda ✓ pada status kelengkapan pada kolom yang tersedia<br>3. Berikan tanda tangan untuk dosen pengampu MK yang bersangkutan</td></tr>
    <tr><td colspan="2" class="ttd" style="height:90px;vertical-align:top">Dosen Pengampu I,<div style="height:48px"></div><?= esc($pengampu[0] ?? '') ?></td><td colspan="2" style="vertical-align:top">Koordinator Program Studi<div style="height:48px"></div><?= esc($koorProdi) ?></td></tr>
  </table>
</div>

<!-- 1. Portofolio MK -->
<div class="sheet">
  <?= $identitas('PORTOFOLIO MATA KULIAH') ?>
  <?php
    $narasi = [
      ['1', 'Pendahuluan', '(Ceritakan penjelasan yang diperlukan tentang mata kuliah ini)', 'pendahuluan'],
      ['2', 'Tujuan', '(Jelaskan tujuan perkuliahan umum maupun khusus)', 'tujuan'],
      ['3', 'Metode Pembelajaran', '(Jelaskan strategi yang digunakan untuk mencapai tujuan perkuliahan - CPMK)', 'metode'],
      ['4', 'Isi Perkuliahan', '(jelaskan kesesuaiannya dengan kurikulum yang berlaku)', 'isi'],
      ['5', 'Peserta Kuliah', '(berikan gambaran tentang peserta kuliah)', 'peserta_ket'],
    ];
  ?>
  <table class="doc sm">
    <?php foreach ($narasi as [$n, $judul, $ket, $key]): ?>
      <tr><td class="c" style="width:7%"><?= $n ?></td><td><strong><?= $judul ?></strong> <?= $ket ?></td></tr>
      <tr><td></td><td style="min-height:40px"><?= lap_teks($portofolio[$key] ?? '', '') ?><?= $key === 'peserta_ket' ? '<div>Jumlah peserta: ' . count($rows) . ' mahasiswa.</div>' : '' ?></td></tr>
    <?php endforeach; ?>
    <tr><td class="c">6</td><td><strong>Persentase Kehadiran</strong> (% kehadiran dosen ; % kehadiran mahasiswa)</td></tr>
    <tr><td></td><td>Kehadiran dosen: <?= lap_angka($persenHadirDosen) ?>% (<?= (int) $realisasi ?> dari <?= $nPertemuan ?> pertemuan) ; rata-rata kehadiran mahasiswa: <?= lap_angka($persenHadirMhs) ?>%<?= trim((string) ($portofolio['kehadiran_ket'] ?? '')) !== '' ? '<br>' . lap_teks($portofolio['kehadiran_ket']) : '' ?></td></tr>
    <tr><td class="c">7</td><td><strong>Sistem Evaluasi</strong> (jelaskan tentang PR, Kuis, tugas kelompok, praktikum, dll)</td></tr>
    <tr><td></td><td><?= lap_teks($portofolio['sistem_evaluasi'] ?? '', '') ?><div>Komponen penilaian: <?= esc(implode('; ', array_map(fn ($j) => $j['nama'] . ' ' . lap_angka($j['bobot']) . '%', $jenisList))) ?></div></td></tr>
    <tr><td class="c">8</td><td><strong>Hasil Capaian Pembelajaran</strong> (jelaskan tentang capaian atas tujuan yang telah ditetapkan, masukkan pula ketercapaian pembelajaran yang dapat dijelaskan)</td></tr>
    <tr class="pecah">
      <td></td>
      <td>
        <?= lap_teks($portofolio['hasil_capaian'] ?? '', '') ?>
        <?php foreach ($summary as $s): ?>
          <table class="doc sm" style="margin:6px 0">
            <tr><td colspan="4"><strong><?= esc($s['cpmk']['kode']) ?> :</strong> <?= esc($s['cpmk']['deskripsi']) ?></td></tr>
            <tr><th class="sk-sb">SANGAT BAIK</th><th class="sk-b">BAIK</th><th class="sk-c">CUKUP</th><th class="sk-k">KURANG</th></tr>
            <tr><td class="c"><strong><?= $s['sb'] ?></strong></td><td class="c"><strong><?= $s['b'] ?></strong></td><td class="c"><strong><?= $s['c'] ?></strong></td><td class="c"><strong><?= $s['k'] ?></strong></td></tr>
          </table>
        <?php endforeach; ?>
      </td>
    </tr>
    <tr><td class="c">9</td><td><strong>Distribusi Nilai</strong></td></tr>
    <tr class="pecah">
      <td></td>
      <td>
        <p><strong>Indikator ketercapaian (achieved) adalah apabila 50% jumlah mahasiswa peserta kuliah mendapatkan nilai akhir ≥ 55</strong></p>
        <p>Statistik:</p>
        <?php $total = count($rows); $maks = max(1, max($distribusi)); ?>
        <table class="doc sm" style="width:85%">
          <tr><th>Nilai</th><th>Jumlah</th><th>Persentase</th><th style="width:40%">Grafik</th></tr>
          <?php foreach ($distribusi as $h => $jml): ?>
            <tr>
              <td class="c"><?= $h ?></td><td class="c"><strong><?= $jml ?></strong></td>
              <td class="c"><strong><?= $total ? round($jml / $total * 100) : 0 ?>%</strong></td>
              <td><span class="bar" style="width:<?= round($jml / $maks * 100) ?>%"></span></td>
            </tr>
          <?php endforeach; ?>
        </table>
        <p>Tercapai <?= lap_angka($persenTercapai) ?>% dan tidak tercapai <?= lap_angka($total ? 100 - $persenTercapai : 0) ?>%</p>
      </td>
    </tr>
    <tr><td class="c">10</td><td><strong>Kesimpulan</strong></td></tr>
    <tr><td></td><td>
      <?php if (! $total): ?><span class="muted">Belum ada peserta.</span>
      <?php else: ?>Berdasarkan indikator dan hasil pencapaian mahasiswa maka mata kuliah ini <strong><?= $persenTercapai >= 50 ? 'TERCAPAI (ACHIEVED)' : 'TIDAK TERCAPAI (NOT ACHIEVED)' ?></strong><?php endif; ?>
    </td></tr>
    <tr><td class="c">11</td><td><strong>Rekomendasi Perbaikan</strong></td></tr>
    <tr><td></td><td style="height:50px"><?= lap_teks($portofolio['rekomendasi'] ?? '', '') ?></td></tr>
    <tr><td></td><td><strong>Lampiran:</strong><br>1. RPS MK<br>2. Presensi Perkuliahan<br>3. Soal Ujian<br>4. Rekapitulasi Nilai<br>5. OBE: Laporan Pencapaian Keseluruhan CPMK</td></tr>
  </table>
</div>

<!-- 2, 3, 4, 6. Tautan dokumen -->
<div class="sheet">
  <?= $identitas('RPS, KONTRAK PERKULIAHAN, PRESENSI SIPA, DAN SOAL UJIAN') ?>
  <table class="doc sm">
    <tr><th style="width:8%">No.</th><th style="width:30%">Dokumen</th><th>Tautan</th></tr>
    <?php foreach ([['2. Rencana Pembelajaran Semester', 'tautan_rps', $rps ? site_url('laporan/rps/' . $rps['id']) : null],
                    ['3. Kontrak Perkuliahan', 'tautan_kontrak', site_url('laporan/kontrak/' . $kelas['id'])],
                    ['4. Presensi SIPA', 'tautan_presensi', null],
                    ['6. Soal Ujian', 'tautan_soal', null]] as $i => [$label, $key, $fallback]): ?>
      <?php $url = trim((string) ($portofolio[$key] ?? '')) ?: $fallback; ?>
      <tr><td class="c"><?= $i + 1 ?></td><td><?= esc($label) ?></td><td><?= $url ? '<a href="' . esc($url, 'attr') . '">' . esc($url) . '</a>' : '<span class="muted">Belum diisi</span>' ?></td></tr>
    <?php endforeach; ?>
  </table>
</div>

<!-- 5. Rekap Presensi -->
<div class="sheet landscape">
  <div class="band blue">JUMLAH REALISASI KELAS TATAP MUKA SELAMA 1 SEMESTER (TIDAK TERMASUK EVALUASI CPMK)</div>
  <table class="doc xs" style="margin-top:-1px">
    <tr><td colspan="<?= 3 + $nPertemuan ?>">Realisasi total perkuliahan tatap muka dengan dosen pengampu:</td><td colspan="7"><strong><?= (int) $realisasi ?></strong> kali tatap muka</td></tr>
    <tr><th colspan="3">IDENTITAS DAN PRESENSI PESERTA KULIAH</th><th colspan="<?= $nPertemuan + 7 ?>">REALISASI TATAP MUKA</th></tr>
    <tr>
      <th>NIM</th><th>Nama</th><th>Kelas</th>
      <?php for ($p = 1; $p <= $nPertemuan; $p++): ?><th>P<?= $p ?></th><?php endfor; ?>
      <th>Hadir</th><th>Izin</th><th>Sakit</th><th>Tanpa Ket.</th><th>Skor Kehadiran (%)</th><th colspan="2">Keterangan</th>
    </tr>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= esc($r['mhs']['nim'] ?? '') ?></td><td><?= esc($r['mhs']['nama'] ?? '') ?></td><td class="c"><?= esc($kelas['label']) ?></td>
        <?php for ($p = 1; $p <= $nPertemuan; $p++): ?><td class="c"><?= esc($kodeStatus($r['presensiRows'][$p] ?? '')) ?></td><?php endfor; ?>
        <td class="c"><?= $r['pres']['h'] ?></td><td class="c"><?= $r['pres']['i'] ?></td><td class="c"><?= $r['pres']['s'] ?></td><td class="c"><?= $r['pres']['a'] ?></td>
        <td class="c"><?= lap_angka($r['pres']['skor']) ?></td>
        <td colspan="2" class="c <?= $r['pres']['eligible'] ? '' : 'lulus-no' ?>"><?= $statusPres($r) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <p style="font-size:8pt">H = Hadir, I = Izin, S = Sakit, TK = Tanpa Keterangan. Mahasiswa dengan TK lebih dari 3 pertemuan tidak dapat mengikuti UAS.</p>
</div>

<!-- 7. Rekap Nilai -->
<div class="sheet landscape">
  <?= $identitas('REKAPITULASI NILAI AKHIR MAHASISWA') ?>
  <table class="doc xs">
    <tr>
      <th rowspan="2">No</th><th rowspan="2">NIM</th><th rowspan="2">NAMA</th><th rowspan="2">Jumlah Minimal Presensi</th>
      <?php foreach ($jenisList as $j): ?><th><?= esc($j['nama']) ?></th><?php endforeach; ?>
      <th rowspan="2">Nilai Angka</th><th rowspan="2">Nilai Huruf</th>
    </tr>
    <tr><?php foreach ($jenisList as $j): ?><th><?= lap_angka($j['bobot']) ?>%</th><?php endforeach; ?></tr>
    <?php foreach ($rows as $i => $r): ?>
      <tr>
        <td class="c"><?= $i + 1 ?></td><td><?= esc($r['mhs']['nim'] ?? '') ?></td><td><?= esc($r['mhs']['nama'] ?? '') ?></td>
        <td class="c"><?= $statusPres($r) ?></td>
        <?php foreach ($jenisList as $j): ?><td class="c"><?= lap_angka($r['nilaiByJenis'][$j['id']] ?? '') ?></td><?php endforeach; ?>
        <td class="c"><?= number_format($r['akhir']['angka'], 2, ',', '') ?></td>
        <td class="c"><strong><?= $r['akhir']['huruf'] ?></strong></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<!-- 8.. Per CPMK -->
<?php foreach ($cpmkList as $ci => $c): ?>
  <div class="sheet landscape">
    <div class="band">PEMBOBOTAN NILAI ASESMEN <?= esc(strtoupper($c['kode'])) ?></div>
    <table class="doc xs" style="margin-top:-1px">
      <tr><td colspan="2"><?= esc($c['kode']) ?>: <?= esc($c['deskripsi']) ?></td><td class="r"></td></tr>
      <tr><td colspan="2" class="c">Bobot <?= esc($c['kode']) ?> terhadap total jumlah seluruh CPMK:</td><td class="r"><strong><?= lap_angka($proporsi[$c['id']]) ?>%</strong></td></tr>
      <?php foreach ($jenisList as $ji => $j): ?>
        <tr><td style="width:35%" class="c">Bobot Penilaian-<?= $ji + 1 ?></td><td class="c"><?= esc($j['nama']) ?></td><td class="r" style="width:12%"><?= lap_angka($matriksIdx[$j['id']][$c['id']] ?? 0) ?>%</td></tr>
      <?php endforeach; ?>
    </table>
    <div class="band orange">ASESMEN CAPAIAN PEMBELAJARAN <?= esc(strtoupper($c['kode'])) ?></div>
    <table class="doc xs" style="margin-top:-1px">
      <tr><th>No</th><th>NIM</th><th>NAMA</th><th>Jumlah Minimal Presensi</th><?php foreach ($jenisList as $j): ?><th><?= esc($j['nama']) ?></th><?php endforeach; ?><th>NILAI CAPAIAN</th><th>STATUS KELULUSAN CPMK</th></tr>
      <?php foreach ($rows as $i => $r): $cp = $r['capaian'][$ci] ?? null; ?>
        <tr>
          <td class="c"><?= $i + 1 ?></td><td><?= esc($r['mhs']['nim'] ?? '') ?></td><td><?= esc($r['mhs']['nama'] ?? '') ?></td>
          <td class="c"><?= $statusPres($r) ?></td>
          <?php foreach ($jenisList as $j): ?><td class="c"><?= lap_angka($r['nilaiByJenis'][$j['id']] ?? '') ?></td><?php endforeach; ?>
          <td class="c"><?= $cp && $cp['nilai'] !== null ? round($cp['nilai']) : '-' ?></td>
          <td class="<?= $cp && $cp['nilai'] !== null && ! $cp['lulus'] ? 'lulus-no' : '' ?>"><?= ! $cp || $cp['nilai'] === null ? '-' : ($cp['lulus'] ? 'LULUS' : 'TIDAK LULUS') ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
<?php endforeach; ?>

<!-- Laporan OBE -->
<div class="sheet landscape">
  <?= $identitas('REKAPITULASI HASIL CAPAIAN PEMBELAJARAN MATA KULIAH') ?>
  <table class="doc xs" style="width:auto;margin:6px 0">
    <tr><th>ASSESMENT CPMK</th><th class="sk-sb">SANGAT BAIK</th><th class="sk-b">BAIK</th><th class="sk-c">CUKUP</th><th class="sk-k">KURANG</th><th>TIDAK LULUS CPMK</th><th>TOTAL</th><th>PERSENTASE KELULUSAN</th></tr>
    <?php foreach ($summary as $s): ?>
      <tr><td class="c"><?= esc($s['cpmk']['kode']) ?></td><td class="c"><?= $s['sb'] ?></td><td class="c"><?= $s['b'] ?></td><td class="c"><?= $s['c'] ?></td><td class="c"><?= $s['k'] ?></td><td class="c"><?= $s['tidakLulus'] ?></td><td class="c"><?= $s['total'] ?></td><td class="c"><?= round($s['persenLulus']) ?>%</td></tr>
    <?php endforeach; ?>
  </table>
  <table class="doc xs">
    <tr><th>No</th><th>NIM</th><th>NAMA</th><th>Jumlah Minimal Presensi</th><?php foreach ($cpmkList as $c): ?><th><?= esc($c['kode']) ?></th><th>Skala Rubrik</th><?php endforeach; ?></tr>
    <?php foreach ($rows as $i => $r): ?>
      <tr>
        <td class="c"><?= $i + 1 ?></td><td><?= esc($r['mhs']['nim'] ?? '') ?></td><td><?= esc($r['mhs']['nama'] ?? '') ?></td>
        <td class="c <?= $r['pres']['eligible'] ? '' : 'lulus-no' ?>"><?= $statusPres($r) ?></td>
        <?php foreach ($r['capaian'] as $cp): ?>
          <td class="c"><?= $cp['nilai'] !== null ? number_format($cp['nilai'], 1, ',', '') : '-' ?></td>
          <?php if ($cp['nilai'] === null): ?><td>-</td>
          <?php elseif (! empty($cp['tidak_eligible'])): ?><td class="lulus-no">Tidak Lulus CPMK</td>
          <?php else: ?><td class="<?= $skalaKelas[$cp['skala']] ?? '' ?>"><?= esc($cp['skala']) ?></td><?php endif; ?>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </table>
  <p style="font-size:8pt">Skala rubrik: Sangat Baik ≥ 75 · Baik ≥ 65 · Cukup ≥ 55 · Kurang &lt; 55. CPMK lulus bila nilai capaian ≥ 55 dan mahasiswa memenuhi syarat presensi.</p>
</div>

<?= $this->endSection() ?>
