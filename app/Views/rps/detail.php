<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
$statusOrder = ['draft','diajukan','diperiksa','disetujui_gkm','ditandatangani','diarsipkan'];
$jumlahBobotJenis = array_sum(array_column($jenisPenilaian, 'bobot'));
$matriksIndex = [];
foreach ($matriks as $m) { $matriksIndex[$m['jenis_penilaian_id']][$m['cpmk_id']] = $m['bobot']; }
?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('rps') ?>">← Kembali ke daftar RPS</a>
    <h1 style="margin-top:8px"><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? '')) ?></h1>
    <p>RPS <?= esc($rps['tahun_akademik']) ?> · Pengembang: <?= esc($dosenById[$rps['pengembang_id']]['nama'] ?? '—') ?> · Koor. Prodi: <?= esc($dosenById[$rps['koor_prodi_id']]['nama'] ?? '—') ?></p>
  </div>
  <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
    <?= status_badge($rps['status']) ?>
    <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/silabus/' . $rps['id']) ?>">Cetak Silabus</a>
    <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/rps/' . $rps['id']) ?>">Cetak RPS</a>
  </div>
</div>

<div class="status-flow">
<?php foreach ($statusOrder as $s): ?>
  <span class="<?= $rps['status'] === $s ? 'cur' : '' ?>"><?= status_label($s) ?></span><?= $s !== end($statusOrder) ? ' → ' : '' ?>
<?php endforeach; ?>
</div>

<div class="panel">
  <h2>Tindakan Alur Kerja</h2>
  <?php $st = $rps['status']; ?>

  <?php if (in_array($st, ['draft', 'revisi_diperlukan'], true)): ?>
    <?php if ($canAjukan): ?>
      <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/workflow/ajukan') ?>">
        <?= csrf_field() ?>
        <?php if ($st === 'revisi_diperlukan'): ?><p class="hint">GKM meminta revisi. Lihat catatannya di Riwayat Status di bawah, perbaiki, lalu ajukan ulang.</p><?php endif; ?>
        <div class="field"><label>Catatan pengajuan (opsional)</label><input type="text" name="catatan" placeholder="Catatan untuk GKM"></div>
        <button type="submit" class="btn teal">Ajukan ke GKM</button>
      </form>
    <?php else: ?>
      <p class="hint">Menunggu pengembang RPS (<?= esc($dosenById[$rps['pengembang_id']]['nama'] ?? '—') ?>) menyelesaikan dan mengajukan dokumen ini.</p>
    <?php endif; ?>

  <?php elseif ($st === 'diajukan'): ?>
    <?php if ($canReview): ?>
      <p class="hint">Aksi Gugus Kendali Mutu (GKM):</p>
      <form id="wfReview" method="post" action="">
        <?= csrf_field() ?>
        <div class="field"><label>Catatan review</label><textarea name="catatan" id="wfcatatan" placeholder="Catatan verifikasi (wajib jika meminta revisi)"></textarea></div>
        <div style="display:flex;gap:10px">
          <button type="submit" class="btn amber" formaction="<?= site_url('rps/' . $rps['id'] . '/workflow/revisi') ?>">Kembalikan untuk Revisi</button>
          <button type="submit" class="btn teal" formaction="<?= site_url('rps/' . $rps['id'] . '/workflow/setuju') ?>">Setujui Dokumen</button>
        </div>
      </form>
    <?php else: ?>
      <p class="hint">Menunggu pemeriksaan GKM.</p>
    <?php endif; ?>

  <?php elseif ($st === 'disetujui_gkm'): ?>
    <p class="hint">Pengesahan — memerlukan tanda tangan Dosen pengembang dan Koordinator Program Studi (Kaprodi):</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
      <?php if ($rps['ttd_dosen']): ?>
        <span class="badge diarsipkan">✓ Dosen sudah TTD</span>
      <?php elseif ($canTtdDosen): ?>
        <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/workflow/ttd-dosen') ?>"><?= csrf_field() ?><button type="submit" class="btn">Tanda Tangan Dosen</button></form>
      <?php else: ?>
        <span class="badge draft">Menunggu TTD Dosen</span>
      <?php endif; ?>

      <?php if ($rps['ttd_kaprodi']): ?>
        <span class="badge diarsipkan">✓ Kaprodi sudah TTD</span>
      <?php elseif ($canTtdKaprodi): ?>
        <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/workflow/ttd-kaprodi') ?>"><?= csrf_field() ?><button type="submit" class="btn">Tanda Tangan Kaprodi</button></form>
      <?php else: ?>
        <span class="badge draft">Menunggu TTD Kaprodi</span>
      <?php endif; ?>
    </div>

  <?php elseif ($st === 'ditandatangani'): ?>
    <?php if ($canArsip): ?>
      <p class="hint">Dokumen sah. Serahkan ke Gugus Penjamin Mutu (GPM) dan arsipkan:</p>
      <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/workflow/arsip') ?>">
        <?= csrf_field() ?>
        <div class="field"><label>Lokasi arsip / tautan penyimpanan</label><input type="text" name="lokasi" placeholder="mis. Drive Prodi / lemari arsip B-12"></div>
        <button type="submit" class="btn teal">Serahkan ke GPM &amp; Arsipkan</button>
      </form>
    <?php else: ?>
      <p class="hint">Dokumen sah. Menunggu diserahkan ke GPM dan diarsipkan.</p>
    <?php endif; ?>

  <?php elseif ($st === 'diarsipkan'): ?>
    <p class="hint">Dokumen sudah diarsipkan<?= $rps['arsip_lokasi'] ? ' di ' . esc($rps['arsip_lokasi']) : '' ?>. Siap dipakai untuk membuka kelas.</p>
  <?php endif; ?>
</div>

<?php
  $identitas = [
    'kode_dokumen'          => ['Kode Dokumen', 'input', 'mis. FKIP-PBI-RPS-001'],
    'tgl_penyusunan'        => ['Tanggal Penyusunan', 'date', ''],
    'mk_syarat'             => ['Mata Kuliah Syarat (jika ada)', 'input', 'Kosongkan jika tidak ada'],
    'bahan_kajian'          => ['Materi / Bahan Kajian', 'textarea', 'Satu bahan kajian per baris'],
    'pustaka'               => ['Pustaka / Referensi', 'textarea', 'Diharapkan berasal dari penelitian/PkM dosen; satu pustaka per baris'],
    'media_software'        => ['Media Pembelajaran — Perangkat Lunak', 'textarea', 'mis. Google Classroom, Zoom'],
    'media_hardware'        => ['Media Pembelajaran — Perangkat Keras', 'textarea', 'mis. Laptop, proyektor, mikrofon'],
    'sdgs'                  => ['Keterkaitan MK dengan SDGs', 'textarea', "Prioritaskan SDGs IKU wajib UMRAH (1, 4, 7, 14, 17)\nmis. SDG 4: Pendidikan Berkualitas — ..."],
    'analisis_pembelajaran' => ['Analisis Pembelajaran (untuk Silabus)', 'textarea', 'Urutan Sub-CPMK dari garis entry behavior hingga CPMK, mis. Sub-CPMK 1 (mg 1–2) → Sub-CPMK 2 (mg 3–4) → UTS → ...'],
  ];
?>
<div class="panel" id="identitas">
  <h2>Identitas &amp; Kelengkapan RPS</h2>
  <p class="hint">Isian ini dipakai pada dokumen Silabus dan RPS format UMRAH. Identitas MK (kode, rumpun, sifat, SKS, semester, deskripsi) diambil dari menu Mata Kuliah.</p>
  <?php if ($editable): ?>
    <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/identitas') ?>">
      <?= csrf_field() ?>
      <div class="field-row cols-3">
        <?php foreach (array_slice($identitas, 0, 3, true) as $key => [$label, $type, $ph]): ?>
          <div class="field">
            <label><?= esc($label) ?></label>
            <input type="<?= $type === 'date' ? 'date' : 'text' ?>" name="<?= $key ?>" placeholder="<?= esc($ph) ?>" value="<?= esc($rps[$key] ?? '') ?>">
          </div>
        <?php endforeach; ?>
      </div>
      <div class="field-row">
        <?php foreach (array_slice($identitas, 3, null, true) as $key => [$label, $type, $ph]): ?>
          <div class="field">
            <label><?= esc($label) ?></label>
            <textarea name="<?= $key ?>" rows="3" placeholder="<?= esc($ph) ?>"><?= esc($rps[$key] ?? '') ?></textarea>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="form-actions"><button type="submit" class="btn sm">Simpan Identitas RPS</button></div>
    </form>
  <?php else: ?>
    <dl class="kv">
      <?php foreach ($identitas as $key => [$label]): ?>
        <dt><?= esc($label) ?></dt>
        <dd class="prewrap"><?= trim((string) ($rps[$key] ?? '')) !== '' ? esc($rps[$key]) : '<span class="muted">Belum diisi</span>' ?></dd>
      <?php endforeach; ?>
    </dl>
  <?php endif; ?>
</div>

<div class="panel" id="pertemuan">
  <h2>A. Rancangan Pembelajaran 16 Pertemuan</h2>
  <p class="hint">Bentuk pembelajaran diisi dengan uraian kegiatan (bukan centang). Model pembelajaran harus menerapkan Student Centered Learning (SCL). Total bobot seluruh pertemuan = 100.</p>
  <?php $totalBobotPertemuan = array_sum(array_column($pertemuan, 'bobot')); ?>
  <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/pertemuan') ?>">
    <?= csrf_field() ?>
    <div class="tbl-wrap">
      <table class="rps-grid">
        <thead>
          <tr>
            <th rowspan="2" style="width:36px">Mg</th>
            <th rowspan="2">Kemampuan Akhir (Sub-CPMK)</th>
            <th rowspan="2">Indikator</th>
            <th rowspan="2">Materi / Pokok Bahasan</th>
            <th rowspan="2">Model Pembelajaran (SCL)</th>
            <th colspan="3">Bentuk Pembelajaran</th>
            <th colspan="2">Penilaian</th>
            <th rowspan="2">Alokasi Waktu</th>
          </tr>
          <tr><th>Luring</th><th>Daring</th><th>Blended</th><th>Teknik &amp; Kriteria</th><th style="width:70px">Bobot</th></tr>
        </thead>
        <tbody>
          <?php foreach ($pertemuan as $p): $n = 'p[' . $p['id'] . ']'; ?>
            <tr>
              <td class="mono"><?= $p['minggu'] ?><?= $p['is_uts'] ? ' <span class="badge diperiksa">UTS</span>' : '' ?><?= $p['is_uas'] ? ' <span class="badge diarsipkan">UAS</span>' : '' ?></td>
              <?php if ($editable): ?>
                <?php foreach (['sub_cpmk', 'indikator', 'materi', 'model', 'luring', 'daring', 'blended', 'penilaian'] as $f): ?>
                  <td><textarea name="<?= $n ?>[<?= $f ?>]" rows="2"><?= esc($p[$f] ?? '') ?></textarea></td>
                <?php endforeach; ?>
                <td><input class="matrix-input" type="number" min="0" max="100" step="0.01" name="<?= $n ?>[bobot]" value="<?= $p['bobot'] ?>"></td>
                <td><textarea name="<?= $n ?>[alokasi_waktu]" rows="2"><?= esc($p['alokasi_waktu'] ?? '') ?></textarea></td>
              <?php else: ?>
                <?php foreach (['sub_cpmk', 'indikator', 'materi', 'model', 'luring', 'daring', 'blended', 'penilaian'] as $f): ?>
                  <td class="prewrap"><?= esc($p[$f] ?? '') ?></td>
                <?php endforeach; ?>
                <td class="num"><?= $p['bobot'] ?></td>
                <td class="prewrap"><?= esc($p['alokasi_waktu'] ?? '') ?></td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="hint" style="color:<?= abs($totalBobotPertemuan - 100) > 0.01 ? 'var(--red)' : 'var(--ink-soft)' ?>">
      Total bobot pertemuan: <?= $totalBobotPertemuan ?> <?= abs($totalBobotPertemuan - 100) > 0.01 ? '— format UMRAH: total seluruh pertemuan = 100' : '✓' ?>
    </p>
    <?php if ($editable): ?><button type="submit" class="btn sm">Simpan Rancangan Pertemuan</button><?php endif; ?>
  </form>
</div>

<div class="panel" id="penilaian">
  <h2>B. Jenis &amp; Bobot Penilaian</h2>
  <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/jenis/update') ?>">
<?= csrf_field() ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Jenis Penilaian</th><th style="width:160px">Kategori</th><th style="width:100px">Bobot %</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($jenisPenilaian as $j): ?>
        <tr>
          <td><?php if ($editable): ?><input name="j[<?= $j['id'] ?>][nama]" value="<?= esc($j['nama']) ?>"><?php else: ?><?= esc($j['nama']) ?><?php endif; ?></td>
          <td>
            <?php if ($editable): ?>
              <select name="j[<?= $j['id'] ?>][kategori]">
                <?php foreach (kategori_penilaian() as $k => $lbl): ?>
                  <option value="<?= $k ?>" <?= ($j['kategori'] ?? '') === $k ? 'selected' : '' ?>><?= esc($lbl) ?></option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <?= esc(kategori_penilaian($j['kategori'] ?? 'tugas')) ?>
            <?php endif; ?>
          </td>
          <td><?php if ($editable): ?><input class="matrix-input" type="number" name="j[<?= $j['id'] ?>][bobot]" value="<?= $j['bobot'] ?>"><?php else: ?><?= $j['bobot'] ?><?php endif; ?></td>
          <td><?php if ($editable): ?><button type="submit" class="iconbtn" formaction="<?= site_url('rps/' . $rps['id'] . '/jenis/delete/' . $j['id']) ?>" formnovalidate onclick="return confirm('Hapus jenis penilaian ini?')">Hapus</button><?php endif; ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
    <p class="hint" style="color:<?= abs($jumlahBobotJenis - 100) > 0.01 ? 'var(--red)' : 'var(--ink-soft)' ?>">Total bobot: <?= $jumlahBobotJenis ?>% <?= abs($jumlahBobotJenis - 100) > 0.01 ? '— harus berjumlah 100%' : '✓' ?></p>
    <?php if ($editable): ?><button type="submit" class="btn sm">Simpan Bobot Penilaian</button><?php endif; ?>
  </form>
  <?php if ($editable): ?>
  <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/jenis/add') ?>" style="margin-top:8px">
<?= csrf_field() ?>
    <button type="submit" class="btn ghost sm">+ Tambah jenis penilaian</button>
  </form>
  <?php endif; ?>
  <?php $kategoriAda = array_column($jenisPenilaian, 'kategori'); ?>
  <?php if (! in_array('uts', $kategoriAda, true) || ! in_array('uas', $kategoriAda, true)): ?>
    <p class="hint" style="color:var(--red)">Format RPS UMRAH mewajibkan jenis penilaian berkategori UTS dan UAS.</p>
  <?php endif; ?>
</div>

<div class="panel" id="rencana">
  <h2>Rencana Asesmen &amp; Rubrik Penilaian</h2>
  <p class="hint">Mengisi lampiran Rencana Tugas / Quiz / Proyek / UTS / UAS Mahasiswa pada format RPS UMRAH. Buka tiap jenis penilaian untuk mengisi.</p>
  <?php
    $rencanaFields = [
      'judul'         => ['Judul / Bentuk', 'input'],
      'sub_cpmk'      => ['Sub Capaian Pembelajaran Mata Kuliah', 'textarea'],
      'deskripsi'     => ['Deskripsi (objek garapan, batasan, relevansi & manfaat)', 'textarea'],
      'metode'        => ['Metode Pengerjaan (satu langkah per baris)', 'textarea'],
      'luaran_objek'  => ['Bentuk & Format Luaran — Objek Garapan', 'textarea'],
      'luaran_bentuk' => ['Bentuk & Format Luaran — Bentuk Luaran', 'textarea'],
      'indikator'     => ['Indikator Penilaian', 'textarea'],
      'kriteria'      => ['Kriteria Penilaian', 'textarea'],
      'rubrik'        => ['Rubrik Penilaian', 'textarea'],
      'jadwal'        => ['Jadwal Pelaksanaan', 'input'],
      'lain_lain'     => ['Lain-lain', 'textarea'],
      'rujukan'       => ['Daftar Rujukan', 'textarea'],
    ];
  ?>
  <?php foreach ($jenisPenilaian as $j): ?>
    <?php $terisi = trim((string) ($j['deskripsi'] ?? '')) !== '' || trim((string) ($j['judul'] ?? '')) !== ''; ?>
    <details class="rencana" id="rencana-<?= $j['id'] ?>">
      <summary>
        <strong><?= esc($j['nama']) ?></strong>
        <span class="muted">· <?= esc(kategori_penilaian($j['kategori'] ?? 'tugas')) ?> · bobot <?= $j['bobot'] ?>%</span>
        <span class="badge <?= $terisi ? 'diarsipkan' : 'draft' ?>"><?= $terisi ? 'Terisi' : 'Belum diisi' ?></span>
      </summary>
      <?php if ($editable): ?>
        <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/jenis/' . $j['id'] . '/rencana') ?>">
          <?= csrf_field() ?>
          <div class="field-row">
            <?php foreach ($rencanaFields as $key => [$label, $type]): ?>
              <div class="field">
                <label><?= esc($label) ?></label>
                <?php if ($type === 'input'): ?>
                  <input type="text" name="<?= $key ?>" value="<?= esc($j[$key] ?? '') ?>">
                <?php else: ?>
                  <textarea name="<?= $key ?>" rows="3"><?= esc($j[$key] ?? '') ?></textarea>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="form-actions"><button type="submit" class="btn sm">Simpan Rencana <?= esc($j['nama']) ?></button></div>
        </form>
      <?php else: ?>
        <dl class="kv">
          <?php foreach ($rencanaFields as $key => [$label]): ?>
            <dt><?= esc($label) ?></dt>
            <dd class="prewrap"><?= trim((string) ($j[$key] ?? '')) !== '' ? esc($j[$key]) : '<span class="muted">—</span>' ?></dd>
          <?php endforeach; ?>
        </dl>
      <?php endif; ?>
    </details>
  <?php endforeach; ?>
</div>

<div class="panel" id="matriks">
  <h2>C. Matriks Penilaian × CPMK</h2>
  <p class="hint">Isi bobot (%) kontribusi tiap jenis penilaian terhadap tiap CPMK — dasar perhitungan capaian CPMK otomatis di kelas.</p>
  <?php if (empty($cpmkList)): ?>
    <div class="empty">Mata kuliah ini belum memiliki CPMK. Tambahkan di menu Kurikulum &amp; CPMK.</div>
  <?php else: ?>
    <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/matriks') ?>">
<?= csrf_field() ?>
      <div class="tbl-wrap"><table>
        <thead><tr><th>Jenis Penilaian</th><?php foreach ($cpmkList as $c): ?><th class="num"><?= esc($c['kode']) ?> (%)</th><?php endforeach; ?><th class="num">Total</th></tr></thead>
        <tbody>
        <?php $proporsi = []; $selisih = false; ?>
        <?php foreach ($jenisPenilaian as $j): $rowTotal = 0; ?>
          <tr>
            <td><?= esc($j['nama']) ?> <span class="muted">(bobot <?= $j['bobot'] ?>%)</span></td>
            <?php foreach ($cpmkList as $c): $val = (float) ($matriksIndex[$j['id']][$c['id']] ?? 0); $rowTotal += $val; $proporsi[$c['id']] = ($proporsi[$c['id']] ?? 0) + $val; ?>
              <td class="num"><?php if ($editable): ?><input class="matrix-input" type="number" min="0" max="100" step="0.01" name="m[<?= $j['id'] ?>][<?= $c['id'] ?>]" value="<?= $val ?>"><?php else: ?><?= $val ?><?php endif; ?></td>
            <?php endforeach; ?>
            <?php $beda = abs($rowTotal - (float) $j['bobot']) > 0.01; $selisih = $selisih || $beda; ?>
            <td class="num" style="<?= $beda ? 'color:var(--red)' : '' ?>"><strong><?= $rowTotal ?>%</strong></td>
          </tr>
        <?php endforeach; ?>
          <tr>
            <td><strong>Proporsi CPMK</strong></td>
            <?php foreach ($cpmkList as $c): ?><td class="num"><strong><?= $proporsi[$c['id']] ?? 0 ?>%</strong></td><?php endforeach; ?>
            <td class="num"><strong><?= array_sum($proporsi) ?>%</strong></td>
          </tr>
        </tbody>
      </table></div>
      <?php if ($selisih): ?>
        <p class="hint" style="color:var(--red)">Total tiap baris harus sama dengan bobot jenis penilaiannya (format Matrik Penilaian terhadap CPMK).</p>
      <?php endif; ?>
      <?php if ($editable): ?><button type="submit" class="btn sm" style="margin-top:12px">Simpan Matriks</button><?php endif; ?>
    </form>
  <?php endif; ?>
</div>

<div class="panel">
  <h2>CPMK Mata Kuliah Ini</h2>
  <?php if (empty($cpmkList)): ?>
    <div class="empty">Belum ada CPMK.</div>
  <?php else: ?>
    <table><thead><tr><th>Kode</th><th>Deskripsi</th></tr></thead><tbody>
    <?php foreach ($cpmkList as $c): ?>
      <tr><td class="mono"><?= esc($c['kode']) ?></td><td><?= esc($c['deskripsi']) ?></td></tr>
    <?php endforeach; ?>
    </tbody></table>
  <?php endif; ?>
</div>

<div class="panel">
  <h2>Riwayat Status</h2>
  <?php foreach ($statusLog as $l): ?>
    <div class="log-item">
      <?= status_badge($l['status']) ?> <strong><?= esc($l['oleh']) ?></strong>
      <div class="meta"><?= esc(date('d M Y H:i', strtotime($l['tanggal']))) ?><?= $l['catatan'] ? ' — ' . esc($l['catatan']) : '' ?></div>
    </div>
  <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
