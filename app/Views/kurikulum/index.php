<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Kurikulum &amp; CPMK</h1><p>Susun CPL prodi, pilih Mata Kuliah, lalu kelola CPMK dan matriks pembebanan CPMK → CPL.</p></div></div>

<div class="panel">
  <form method="get" action="<?= site_url('kurikulum') ?>">
    <div class="field"><label>1. Pilih Program Studi</label>
      <select name="prodi" onchange="this.form.submit()">
        <option value="">— pilih program studi —</option>
        <?php foreach ($prodiList as $p): ?>
          <option value="<?= $p['id'] ?>" <?= ($prodi && $prodi['id'] == $p['id']) ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </form>
</div>

<?php if (! $prodi): ?>
  <div class="empty">Pilih program studi untuk mengelola CPL dan Mata Kuliah.</div>
<?php else: ?>
<div class="two-col">
  <div>
    <div class="panel">
      <h2>CPL — <?= esc($prodi['nama']) ?></h2>
      <form method="post" action="<?= site_url('kurikulum/cpl/store') ?>">
        <input type="hidden" name="prodi_id" value="<?= $prodi['id'] ?>">
        <div class="field-row">
          <div class="field"><label>Kode</label><input type="text" name="kode" placeholder="CPL-1" required></div>
          <div class="field"><label>Deskripsi</label><input type="text" name="deskripsi" placeholder="Rumusan capaian pembelajaran lulusan"></div>
        </div>
        <button type="submit" class="btn">Tambah CPL</button>
      </form>
      <div class="divider"></div>
      <?php if (empty($cplList)): ?>
        <div class="empty">Belum ada CPL.</div>
      <?php else: ?>
        <table><thead><tr><th>Kode</th><th>Deskripsi</th><th></th></tr></thead><tbody>
        <?php foreach ($cplList as $c): ?>
          <tr>
            <td class="mono"><?= esc($c['kode']) ?></td>
            <td><?= esc($c['deskripsi']) ?></td>
            <td><a class="iconbtn" href="<?= site_url('kurikulum/cpl/delete/' . $c['id']) ?>" onclick="return confirm('Hapus CPL ini?')">Hapus</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody></table>
      <?php endif; ?>
    </div>

    <div class="panel">
      <h2>Mata Kuliah — <?= esc($prodi['nama']) ?></h2>
      <p class="hint">Mata kuliah baru ditambahkan lewat menu <strong>Data Induk</strong>. Pilih salah satu untuk mengelola CPMK-nya.</p>
      <?php if (empty($mkList)): ?>
        <div class="empty">Belum ada mata kuliah pada prodi ini.</div>
      <?php else: ?>
        <table><thead><tr><th>Kode</th><th>Nama</th><th>Sifat</th><th class="num">SKS</th><th>Smt</th><th class="num">CPMK</th></tr></thead><tbody>
        <?php foreach ($mkList as $m): ?>
          <tr>
            <td class="mono"><?= esc($m['kode']) ?></td>
            <td><a class="link" href="<?= site_url('kurikulum') ?>?prodi=<?= $prodi['id'] ?>&mk=<?= $m['id'] ?>"><?= esc($m['nama']) ?></a></td>
            <td><?= esc($m['sifat_mk']) ?></td>
            <td class="num"><?= $m['sks'] ?></td>
            <td><?= esc($m['semester']) ?></td>
            <td class="num"><?= $cpmkCountByMk[$m['id']] ?? 0 ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody></table>
      <?php endif; ?>
    </div>
  </div>

  <div>
    <?php if (! $mk): ?>
      <div class="panel"><div class="empty">Pilih mata kuliah di sebelah kiri untuk mengelola CPMK.</div></div>
    <?php else: ?>
      <div class="panel">
        <h2>CPMK — <?= esc($mk['kode']) ?> <?= esc($mk['nama']) ?></h2>
        <form method="post" action="<?= site_url('kurikulum/cpmk/store') ?>">
          <input type="hidden" name="mk_id" value="<?= $mk['id'] ?>">
          <input type="hidden" name="prodi_id" value="<?= $prodi['id'] ?>">
          <div class="field-row">
            <div class="field"><label>Kode</label><input type="text" name="kode" placeholder="CPMK-1" required></div>
            <div class="field"><label>Deskripsi</label><input type="text" name="deskripsi" placeholder="Rumusan capaian pembelajaran mata kuliah"></div>
          </div>
          <button type="submit" class="btn">Tambah CPMK</button>
        </form>
        <div class="divider"></div>
        <?php if (empty($cpmkList)): ?>
          <div class="empty">Belum ada CPMK. CPL harus diisi terlebih dulu agar bisa dibebankan.</div>
        <?php else: ?>
          <?php foreach ($cpmkList as $cp): ?>
            <div style="margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--line)">
              <div style="display:flex;justify-content:space-between;gap:10px">
                <div><span class="mono" style="font-weight:600"><?= esc($cp['kode']) ?></span> — <?= esc($cp['deskripsi']) ?></div>
                <a class="iconbtn" href="<?= site_url('kurikulum/cpmk/delete/' . $cp['id']) ?>" onclick="return confirm('Hapus CPMK ini?')">Hapus</a>
              </div>
              <div class="hint">Pembebanan ke CPL:</div>
              <table><tbody>
              <?php foreach ($cplList as $c): $existing = $bobotCplByCpmk[$cp['id']][$c['id']] ?? 0; ?>
                <tr>
                  <td style="width:70px" class="mono"><?= esc($c['kode']) ?></td>
                  <td>
                    <form method="post" action="<?= site_url('kurikulum/cpmk/bobot') ?>" style="display:flex;gap:6px;align-items:center">
                      <input type="hidden" name="cpmk_id" value="<?= $cp['id'] ?>">
                      <input type="hidden" name="cpl_id" value="<?= $c['id'] ?>">
                      <input type="hidden" name="prodi_id" value="<?= $prodi['id'] ?>">
                      <input type="hidden" name="mk_id" value="<?= $mk['id'] ?>">
                      <input class="matrix-input" type="number" min="0" max="100" name="bobot" value="<?= $existing ?>">
                      <span class="muted small">%</span>
                      <button type="submit" class="btn ghost sm">Simpan</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody></table>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
