<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <h1>Kelas &amp; Kontrak Kuliah</h1>
    <p>Buka penawaran kelas dari RPS yang sudah sah, lalu kelola kontrak kuliah dan peserta.</p>
  </div>
</div>

<?php if ($canCreate): ?>
  <div class="panel">
    <h2>Buka Kelas Baru</h2>

    <?php if (empty($rpsSiap)): ?>
      <div class="empty">
        Belum ada RPS berstatus "Diarsipkan" yang bisa dipakai membuka kelas.
        Selesaikan alur persetujuan RPS terlebih dahulu.
      </div>
    <?php else: ?>
      <form method="post" action="<?= site_url('kelas/store') ?>">
        <?= csrf_field() ?>
        <div class="field-row">
          <div class="field">
            <label>RPS (sudah diarsipkan)</label>
            <select name="rps_id" required>
              <?php foreach ($rpsSiap as $r): $m = $mkById[$r['mk_id']] ?? null; ?>
                <option value="<?= $r['id'] ?>">
                  <?= esc(gabung_teks([$m['kode'] ?? '', $m['nama'] ?? 'MK tidak ditemukan', $r['tahun_akademik']], ' — ')) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label>Label Kelas</label>
            <input type="text" name="label" placeholder="mis. A, B, atau Pagi" required>
          </div>
        </div>

        <div class="field-row">
          <div class="field">
            <label>Semester</label>
            <select name="semester">
              <option value="Ganjil">Ganjil</option>
              <option value="Genap">Genap</option>
            </select>
          </div>
          <div class="field">
            <label>Tahun Akademik</label>
            <input type="text" name="tahun_akademik" placeholder="mis. 2026/2027" pattern="\d{4}/\d{4}" title="Format: 2026/2027">
          </div>
        </div>

        <div class="field">
          <label>Dosen Pengampu</label>
          <div class="checklist">
            <?php foreach ($dosenList as $d): ?>
              <label><input type="checkbox" name="dosen_ids[]" value="<?= $d['id'] ?>"> <?= esc($d['nama']) ?></label>
            <?php endforeach; ?>
          </div>
        </div>

        <button type="submit" class="btn">Buka Kelas</button>
      </form>
    <?php endif; ?>
  </div>
<?php endif; ?>

<div class="panel">
  <h2>Daftar Kelas</h2>

  <?php if (empty($kelasAll)): ?>
    <div class="empty">Belum ada kelas yang dibuka.</div>
  <?php else: ?>
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th>Kode</th>
            <th>Mata Kuliah</th>
            <th>Kelas</th>
            <th>Semester</th>
            <th class="num">Peserta</th>
            <th>Kontrak</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($kelasAll as $k):
              $m       = $mkById[$k['mk_id']] ?? null;
              $kontrak = $kontrakByKelas[$k['id']] ?? null;
          ?>
            <tr>
              <td class="mono"><?= esc($m['kode'] ?? '—') ?></td>
              <td><?= $m ? esc($m['nama']) : '<span class="muted">Mata kuliah tidak ditemukan</span>' ?></td>
              <td><?= esc($k['label']) ?></td>
              <td><?= esc(gabung_teks([$k['semester'], $k['tahun_akademik']])) ?></td>
              <td class="num"><?= $pesertaCount[$k['id']] ?? 0 ?></td>
              <td>
                <?= ! empty($kontrak['ttd'])
                    ? '<span class="badge diarsipkan">Disepakati</span>'
                    : '<span class="badge draft">Belum</span>' ?>
              </td>
              <td><a class="link" href="<?= site_url('kelas/' . $k['id']) ?>">Buka →</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
