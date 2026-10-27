<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
    $namaMk    = $mk['nama'] ?? 'Mata kuliah tidak ditemukan';
    $kodeMk    = $mk['kode'] ?? '';
    $sudahTtd  = ! empty($kontrak['ttd']);
    $isiAtau   = fn ($v) => trim((string) $v) !== '' ? esc($v) : '<span class="muted">Belum diisi</span>';
?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('kelas') ?>">← Kembali ke daftar kelas</a>
    <h1 style="margin-top:8px">
      <?php if ($kodeMk !== ''): ?><span class="mono muted"><?= esc($kodeMk) ?></span> <?php endif; ?>
      <?= esc($namaMk) ?> — Kelas <?= esc($kelas['label']) ?>
    </h1>
    <p>
      <?= esc(gabung_teks([$kelas['semester'], $kelas['tahun_akademik']])) ?>
      · Pengampu: <?= esc(implode(', ', $dosenNama) ?: '—') ?>
    </p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/kontrak/' . $kelas['id']) ?>">Cetak Kontrak Kuliah</a>
    <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/portofolio/' . $kelas['id']) ?>">Cetak Portofolio</a>
  </div>
</div>

<div class="two-col">
  <div>
    <div class="panel">
      <h2>
        Kontrak Kuliah
        <?= $sudahTtd
            ? '<span class="badge diarsipkan">Disepakati</span>'
            : '<span class="badge draft">Belum disepakati</span>' ?>
      </h2>

      <?php if ($canManage): ?>
        <form method="post" action="<?= site_url('kelas/' . $kelas['id'] . '/kontrak') ?>">
          <?= csrf_field() ?>
          <div class="field-row cols-3">
            <div class="field">
              <label>Ruang</label>
              <input type="text" name="jadwal_ruang" placeholder="mis. R. 301" value="<?= esc($kontrak['jadwal_ruang'] ?? '') ?>">
            </div>
            <div class="field">
              <label>Hari</label>
              <input type="text" name="jadwal_hari" placeholder="mis. Senin" value="<?= esc($kontrak['jadwal_hari'] ?? '') ?>">
            </div>
            <div class="field">
              <label>Jam</label>
              <input type="text" name="jadwal_jam" placeholder="mis. 08.00–10.30" value="<?= esc($kontrak['jadwal_jam'] ?? '') ?>">
            </div>
          </div>
          <div class="field">
            <label>Koordinator Kelas (perwakilan mahasiswa yang menandatangani)</label>
            <input type="text" name="koordinator_kelas" list="daftar-peserta" placeholder="Ketik atau pilih nama peserta" value="<?= esc($kontrak['koordinator_kelas'] ?? '') ?>">
            <datalist id="daftar-peserta">
              <?php foreach ($peserta as $p): $m = $mhsById[$p['mahasiswa_id']] ?? null; if (! $m) continue; ?>
                <option value="<?= esc($m['nama']) ?>"><?= esc($m['nim']) ?></option>
              <?php endforeach; ?>
            </datalist>
          </div>
          <div class="field">
            <label>Klausa &amp; Tata Tertib Tambahan</label>
            <textarea name="klausa" rows="8" placeholder="Tuliskan kesepakatan tambahan, satu poin per baris."><?= esc($kontrak['klausa'] ?? '') ?></textarea>
            <p class="hint">16 poin tata tertib standar, hak &amp; kewajiban dosen, tabel nilai, dan bobot penilaian dari RPS otomatis dicantumkan pada dokumen kontrak. Isi di sini hanya kesepakatan tambahan.</p>
          </div>
          <div class="ttd-box">
            <label class="check-line">
              <input type="checkbox" name="ttd" value="1" <?= $sudahTtd ? 'checked' : '' ?>>
              <span>Disepakati &amp; ditandatangani oleh dosen dan perwakilan mahasiswa</span>
            </label>
            <?php if ($sudahTtd && ! empty($kontrak['tgl_ttd'])): ?>
              <p class="hint">Ditandatangani pada <?= esc(tanggal_id($kontrak['tgl_ttd'])) ?></p>
            <?php endif; ?>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn sm">Simpan Kontrak</button>
          </div>
        </form>
      <?php else: ?>
        <dl class="kv">
          <dt>Ruang</dt><dd><?= $isiAtau($kontrak['jadwal_ruang'] ?? '') ?></dd>
          <dt>Hari</dt><dd><?= $isiAtau($kontrak['jadwal_hari'] ?? '') ?></dd>
          <dt>Jam</dt><dd><?= $isiAtau($kontrak['jadwal_jam'] ?? '') ?></dd>
          <dt>Koordinator Kelas</dt><dd><?= $isiAtau($kontrak['koordinator_kelas'] ?? '') ?></dd>
          <dt>Klausa</dt>
          <dd class="prewrap"><?= $isiAtau($kontrak['klausa'] ?? '') ?></dd>
          <?php if ($sudahTtd && ! empty($kontrak['tgl_ttd'])): ?>
            <dt>Ditandatangani</dt><dd><?= esc(tanggal_id($kontrak['tgl_ttd'])) ?></dd>
          <?php endif; ?>
        </dl>
        <p class="hint">Anda hanya dapat melihat kontrak kelas ini.</p>
      <?php endif; ?>
    </div>
  </div>

  <div>
    <div class="panel">
      <h2>Peserta Kelas <span class="muted">(<?= count($peserta) ?> mahasiswa)</span></h2>

      <?php if ($canManage): ?>
        <form method="post" action="<?= site_url('kelas/' . $kelas['id'] . '/peserta/add') ?>">
          <?= csrf_field() ?>
          <div class="field-row" style="grid-template-columns:1fr auto; align-items:end">
            <div class="field">
              <select name="mahasiswa_id" <?= empty($eligibleMhs) ? 'disabled' : '' ?>>
                <?php if (empty($eligibleMhs)): ?>
                  <option value="">Tidak ada kandidat tersedia</option>
                <?php endif; ?>
                <?php foreach ($eligibleMhs as $m): ?>
                  <option value="<?= $m['id'] ?>"><?= esc($m['nim'] . ' — ' . $m['nama']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <button type="submit" class="btn ghost sm" <?= empty($eligibleMhs) ? 'disabled' : '' ?>>+ Tambah</button>
            </div>
          </div>
        </form>
      <?php endif; ?>

      <?php if (empty($peserta)): ?>
        <div class="empty">Belum ada peserta di kelas ini.</div>
      <?php else: ?>
        <div class="tbl-wrap" style="max-height:400px; overflow-y:auto">
          <table>
            <thead>
              <tr>
                <th class="num">No</th>
                <th>NIM</th>
                <th>Nama</th>
                <?php if ($canManage): ?><th></th><?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($peserta as $i => $p): $m = $mhsById[$p['mahasiswa_id']] ?? null; ?>
                <tr>
                  <td class="num"><?= $i + 1 ?></td>
                  <td class="mono"><?= esc($m['nim'] ?? '—') ?></td>
                  <td><?= esc($m['nama'] ?? '—') ?></td>
                  <?php if ($canManage): ?>
                    <td><?= delete_form(site_url('kelas/' . $kelas['id'] . '/peserta/delete/' . $p['id']), 'Keluarkan', 'Keluarkan peserta ini?') ?></td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
