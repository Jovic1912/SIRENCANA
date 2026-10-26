<?= $this->extend('layout/main_tailwind') ?>
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
  <div><?= status_badge($rps['status']) ?></div>
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

<div class="panel" id="pertemuan">
  <h2>A. Rancangan 16 Pertemuan</h2>
  <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/pertemuan') ?>">
<?= csrf_field() ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th style="width:36px">Mg</th><th>Sub-CPMK</th><th>Materi</th><th>Model</th><th>Bentuk</th><th>Indikator</th><th style="width:70px">Bobot%</th></tr></thead>
      <tbody>
      <?php foreach ($pertemuan as $p): ?>
        <tr>
          <td class="mono"><?= $p['minggu'] ?><?= $p['is_uts'] ? ' <span class="badge diperiksa">UTS</span>' : '' ?><?= $p['is_uas'] ? ' <span class="badge diarsipkan">UAS</span>' : '' ?></td>
          <?php if ($editable): ?>
            <td><input name="p[<?= $p['id'] ?>][sub_cpmk]" value="<?= esc($p['sub_cpmk']) ?>"></td>
            <td><input name="p[<?= $p['id'] ?>][materi]" value="<?= esc($p['materi']) ?>"></td>
            <td><input name="p[<?= $p['id'] ?>][model]" value="<?= esc($p['model']) ?>"></td>
            <td>
              <select name="p[<?= $p['id'] ?>][bentuk]">
                <?php foreach (['Luring','Daring','Blended'] as $o): ?>
                  <option <?= $p['bentuk'] === $o ? 'selected' : '' ?>><?= $o ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td><input name="p[<?= $p['id'] ?>][indikator]" value="<?= esc($p['indikator']) ?>"></td>
            <td><input class="matrix-input" type="number" min="0" max="100" name="p[<?= $p['id'] ?>][bobot]" value="<?= $p['bobot'] ?>"></td>
          <?php else: ?>
            <td><?= esc($p['sub_cpmk']) ?></td><td><?= esc($p['materi']) ?></td><td><?= esc($p['model']) ?></td>
            <td><?= esc($p['bentuk']) ?></td><td><?= esc($p['indikator']) ?></td><td class="num"><?= $p['bobot'] ?></td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
    <?php if ($editable): ?><button type="submit" class="btn sm" style="margin-top:12px">Simpan Rancangan Pertemuan</button><?php endif; ?>
  </form>
</div>

<div class="panel" id="penilaian">
  <h2>B. Jenis &amp; Bobot Penilaian</h2>
  <form method="post" action="<?= site_url('rps/' . $rps['id'] . '/jenis/update') ?>">
<?= csrf_field() ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Jenis Penilaian</th><th style="width:100px">Bobot %</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($jenisPenilaian as $j): ?>
        <tr>
          <td><?php if ($editable): ?><input name="j[<?= $j['id'] ?>][nama]" value="<?= esc($j['nama']) ?>"><?php else: ?><?= esc($j['nama']) ?><?php endif; ?></td>
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
        <thead><tr><th>Jenis Penilaian</th><?php foreach ($cpmkList as $c): ?><th class="num"><?= esc($c['kode']) ?></th><?php endforeach; ?></tr></thead>
        <tbody>
        <?php foreach ($jenisPenilaian as $j): ?>
          <tr>
            <td><?= esc($j['nama']) ?></td>
            <?php foreach ($cpmkList as $c): $val = $matriksIndex[$j['id']][$c['id']] ?? 0; ?>
              <td class="num"><?php if ($editable): ?><input class="matrix-input" type="number" min="0" max="100" name="m[<?= $j['id'] ?>][<?= $c['id'] ?>]" value="<?= $val ?>"><?php else: ?><?= $val ?><?php endif; ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
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
