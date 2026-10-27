<?= $this->extend('layout/print') ?>
<?= $this->section('content') ?>

<?php
  $tataTertib = [
      'Mahasiswa sah yang mengikuti perkuliahan ini adalah yang namanya tercantum dalam Daftar Peserta Perkuliahan di SIPA.',
      'Satu orang perwakilan mahasiswa menandatangani kontrak perkuliahan bersama dosen pengajar.',
      'Mahasiswa harus berada di dalam kelas 5 menit sebelum perkuliahan dimulai.',
      'Mahasiswa diberi toleransi waktu terlambat 15 menit dari jadwal.',
      'Mahasiswa yang datang lebih dari 15 menit maka dianggap tidak masuk tanpa keterangan namun masih diperbolehkan mengikuti perkuliahan.',
      'Mahasiswa diperkenankan tidak mengikuti aktivitas perkuliahan jika sakit, terjadi keadaan mendesak atau mengikuti kegiatan di luar program studi dengan membuat surat izin yang dilengkapi dengan:'
        . '<ol type="a"><li>Jika sakit maka memberikan Surat Keterangan Dokter</li>'
        . '<li>Jika terjadi keadaan mendesak maka memberikan Surat Keterangan dari Orang Tua/ Wali Mahasiswa dan diketahui oleh Dosen PA</li>'
        . '<li>Jika ada tugas dari Fakultas dan/atau Universitas maka dilengkapi dengan Surat Tugas dari Fakultas/ Universitas</li></ol>',
      'Mahasiswa diharuskan mengikuti 75% dari seluruh proses perkuliahan untuk memperoleh nilai akhir.',
      'Mahasiswa harus memakai busana yang sopan, bersih, dan rapi. Sandal dan kaus oblong tidak diperkenankan. Mahasiswa wajib memakai sepatu.',
      'Apabila terjadi hujan lebat, maka sandal diperbolehkan.',
      'Mahasiswa harus bertutur kata yang sopan dan santun ketika berinteraksi dengan dosen dan mahasiswa lain.',
      'Mahasiswa diwajibkan mengumpulkan tugas sesuai jadwal dan ketentuan yang telah ditentukan.',
      'Tugas hasil <em>copy paste</em> atau plagiarisme lebih dari 30% bernilai 0',
      'Mahasiswa yang tidak mengikuti pembelajaran suatu mata kuliah lebih dari 3 (tiga) pertemuan dari seluruh rencana pembelajaran dalam satu semester tidak dapat mengikuti ujian akhir semester.',
      'Mahasiswa berhak mengikuti ujian susulan jika berhalangan hadir dengan alasan sakit, kedukaan atau mengikuti kegiatan dari fakultas/universitas dengan memberikan surat sesuai dengan poin nomor 6. Alasan terlambat atau kesalahan pada diri mahasiswa tidak diterima. Jadwal ujian susulan ditentukan oleh dosen.',
      'Mahasiswa berhak mendapat nilai yang objektif dari dosen.',
      'Mahasiswa berhak mempertanyakan nilai tugas dan ujian sesuai dengan kalender akademik.',
  ];
  $dosen = [
      'Dosen mengajar sesuai dengan jadwal perkuliahan, bila ada perubahan dosen wajib memberikan informasi kepada mahasiswa maksimum 1 hari sebelum perkuliahan berlangsung.',
      'Dosen pengajar wajib menandatangani kontrak perkuliahan bersama dengan koordinator kelas.',
      'Dosen wajib memberikan materi perkuliahan dengan sungguh-sungguh.',
      'Dosen wajib mengganti jam perkuliahan yang tidak terlaksana dengan terlebih dulu membuat kesepakatan bersama mahasiswa.',
      'Dosen harus berpakaian rapi, sopan, dan bersih.',
      'Dosen harus menilai mahasiswa secara objektif sesuai komponen penilaian yang ada.',
      'Dosen wajib memberitahu nilai tugas dan ujian kepada mahasiswa.',
      'Dosen berhak memberi sanksi bagi mahasiswa yang menyalahi aturan akademik.',
      'Dosen berhak tidak menilai tugas mahasiswa yang tidak dikumpulkan pada waktu yang telah ditentukan.',
  ];
  $skala = [
      ['85 ≤ x ≤ 100', 'A', '4,00'], ['80 ≤ x < 85', 'A-', '3,75'], ['75 ≤ x < 80', 'B+', '3,5'],
      ['70 ≤ x < 75', 'B', '3,0'], ['65 ≤ x < 70', 'B-', '2,75'], ['60 ≤ x < 65', 'C+', '2,5'],
      ['55 ≤ x < 60', 'C', '2'], ['40 ≤ x < 55', 'D', '1'], ['0 ≤ x < 40', 'E', '0'],
  ];
  $klausaTambahan = lap_baris($kontrak['klausa'] ?? '');
  $sudahTtd = ! empty($kontrak['ttd']);
?>

<div class="sheet">
  <p style="font-size:10pt">(Format ini bersifat minimal, prodi dapat menambahkan klausa kesepakatan lain jika diperlukan)</p>
  <?= view('laporan/_kop', ['prodi' => $prodi, 'judul' => 'KONTRAK KULIAH']) ?>
  <table class="doc" style="margin-top:-1px">
    <tr><td style="width:45%">Mata Kuliah/ Kode</td><td><?= esc(gabung_teks([$mk['nama'] ?? '', $mk['kode'] ?? ''], ' / ')) ?></td></tr>
    <tr><td>SKS/ Semester</td><td><?= esc(gabung_teks([isset($mk['sks']) ? $mk['sks'] . ' SKS' : '', gabung_teks([$kelas['semester'], $kelas['tahun_akademik']], ' ')], ' / ')) ?> · Kelas <?= esc($kelas['label']) ?></td></tr>
    <tr><td>Dosen Pengampu</td><td><?= esc(implode(', ', $pengampu) ?: '…') ?></td></tr>
    <tr><td>Jadwal Perkuliahan (Ruang/ Hari/ Jam)</td><td><?= esc(gabung_teks([$kontrak['jadwal_ruang'] ?? '', $kontrak['jadwal_hari'] ?? '', $kontrak['jadwal_jam'] ?? ''], ' / ')) ?></td></tr>
    <tr><th colspan="2">KESEPAKATAN DAN TATA TERTIB PERKULIAHAN</th></tr>
    <tr class="pecah">
      <td colspan="2">
        <ol>
          <?php foreach ($tataTertib as $t): ?><li><?= $t ?></li><?php endforeach; ?>
          <?php foreach ($klausaTambahan as $t): ?><li><?= esc(preg_replace('/^\d+[.)]\s*/', '', $t)) ?></li><?php endforeach; ?>
        </ol>
        <p class="center" style="font-weight:bold;margin-top:8px">HAK DAN KEWAJIBAN DOSEN</p>
        <ol><?php foreach ($dosen as $t): ?><li><?= esc($t) ?></li><?php endforeach; ?></ol>
      </td>
    </tr>
    <tr><th colspan="2">INDIKATOR, KRITERIA, DAN BOBOT PENILAIAN</th></tr>
    <tr class="pecah">
      <td colspan="2">
        <p class="center">Standar penilaian berdasarkan Peraturan Rektor UMRAH nomor 03 Tahun 2025</p>
        <table class="doc sm" style="width:70%;margin:0 auto 4px">
          <tr><th>No</th><th>Skor Penguasaan</th><th>Nilai Dalam Huruf</th><th>Nilai Dalam Angka</th></tr>
          <?php foreach ($skala as $i => [$skor, $huruf, $angka]): ?>
            <tr><td class="c"><?= $i + 1 ?></td><td class="c"><?= $skor ?></td><td class="c"><?= $huruf ?></td><td class="c"><?= $angka ?></td></tr>
          <?php endforeach; ?>
        </table>
        <p class="center">Nilai D dan E dinyatakan tidak lulus</p>
        <p>Jenis Penilaian dan Bobot Skor</p>
        <table class="doc sm" style="width:60%">
          <tr><th style="width:12%">No</th><th>Jenis Penilaian</th><th style="width:28%">Persentase</th></tr>
          <?php foreach ($jenisList as $i => $j): ?>
            <tr><td class="c"><?= $i + 1 ?></td><td><?= esc($j['nama']) ?></td><td class="c"><?= lap_angka($j['bobot']) ?>%</td></tr>
          <?php endforeach; ?>
          <?php if (! $jenisList): ?><tr><td class="c">1</td><td>…</td><td></td></tr><?php endif; ?>
        </table>
      </td>
    </tr>
    <tr><th colspan="2">LAIN-LAIN</th></tr>
    <tr>
      <td colspan="2" style="text-align:justify">
        Dengan menandatangani kontrak ini kami perwakilan mahasiswa memastikan telah mendapatkan dan memahami penjelasan tentang Rencana Pembelajaran Semester (RPS), mekanisme penilaian, dan menyepakati Kesepakatan dan Tata Tertib perkuliahan.
        <?php if ($sudahTtd && ! empty($kontrak['tgl_ttd'])): ?><br><em>Disepakati pada <?= esc(tanggal_id($kontrak['tgl_ttd'])) ?>.</em><?php endif; ?>
      </td>
    </tr>
    <tr>
      <td style="height:95px;vertical-align:top">Dosen Pengampu<div style="height:50px"></div>(<?= esc($pengampu[0] ?? 'Nama Terang') ?>)</td>
      <td style="vertical-align:top">Koordinator Kelas<div style="height:50px"></div>(<?= esc(($kontrak['koordinator_kelas'] ?? '') ?: 'Nama Terang') ?>)</td>
    </tr>
  </table>
</div>

<?= $this->endSection() ?>
