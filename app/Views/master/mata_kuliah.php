<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Mata Kuliah</h1><p>Data induk mata kuliah — kategori, sifat, bobot SKS, dan deskripsi.</p></div></div>

<div class="panel">
  <?php if ($canWrite): ?>
<h2>Tambah Mata Kuliah</h2>
  <form method="post" action="<?= site_url('mata-kuliah/store') ?>">
<?= csrf_field() ?>
    <div class="field-row">
      <div class="field"><label>Kode MK</label><input type="text" name="kode" placeholder="IF301" required></div>
      <div class="field"><label>Nama MK</label><input type="text" name="nama" placeholder="Rekayasa Perangkat Lunak" required></div>
      <div class="field"><label>Kategori MK</label>
        <select name="tingkat_mk" id="tingkat_mk" onchange="document.getElementById('prodiField').style.display = this.value==='Prodi' ? '' : 'none'">
          <option value="Prodi">MK Program Studi</option>
          <option value="Fakultas">MK Fakultas</option>
          <option value="Universitas">MK Universitas</option>
        </select>
      </div>
    </div>
    <div class="field-row">
      <div class="field" id="prodiField"><label>Program Studi</label>
        <select name="prodi_id">
          <option value="">— tidak terikat prodi tertentu —</option>
          <?php foreach ($prodiList as $p): ?>
            <option value="<?= $p['id'] ?>"><?= esc($p['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Rumpun MK</label><input type="text" name="rumpun_mk" placeholder="mis. Rekayasa Perangkat Lunak"></div>
      <div class="field"><label>Sifat MK</label>
        <select name="sifat_mk"><option value="Wajib">Wajib</option><option value="Pilihan">Pilihan</option></select>
      </div>
      <div class="field"><label>Bobot SKS</label>
        <select name="sks"><?php for ($n = 1; $n <= 6; $n++): ?><option value="<?= $n ?>" <?= $n === 3 ? 'selected' : '' ?>><?= $n ?> SKS</option><?php endfor; ?></select>
      </div>
      <div class="field"><label>Semester</label>
        <select name="semester"><option value="Ganjil">Ganjil</option><option value="Genap">Genap</option></select>
      </div>
    </div>
    <div class="field"><label>Deskripsi Mata Kuliah</label><textarea name="deskripsi" placeholder="Ringkasan isi dan tujuan mata kuliah…"></textarea></div>
    <p class="hint">MK Fakultas/Universitas berlaku lintas program studi, sehingga Program Studi bersifat opsional.</p>
    <button type="submit" class="btn">Tambah Mata Kuliah</button>
  </form>
<?php endif; ?>
</div>

<div class="panel">
  <h2>Daftar Mata Kuliah</h2>
  <?php if (empty($mk)): ?>
    <div class="empty">Belum ada mata kuliah.</div>
  <?php else: ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Prodi</th><th>Rumpun</th><th>Sifat</th><th class="num">SKS</th><th>Semester</th><th>Deskripsi</th><th class="num">CPMK</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($mk as $m):
        $badgeMap = ['Universitas' => 'diajukan', 'Fakultas' => 'ditandatangani', 'Prodi' => 'disetujui_gkm'];
        $tb = $badgeMap[$m['tingkat_mk']] ?? 'disetujui_gkm';
        $desk = $m['deskripsi'] ?? '';
        $preview = mb_strlen($desk) > 50 ? mb_substr($desk, 0, 50) . '…' : $desk;
      ?>
        <tr>
          <td class="mono"><?= esc($m['kode']) ?></td>
          <td><?= esc($m['nama']) ?></td>
          <td><span class="badge <?= $tb ?>">MK <?= esc($m['tingkat_mk']) ?></span></td>
          <td><?= esc($prodiById[$m['prodi_id']]['nama'] ?? '—') ?></td>
          <td><?= esc($m['rumpun_mk'] ?? '—') ?></td>
          <td><span class="badge <?= $m['sifat_mk'] === 'Wajib' ? 'diarsipkan' : 'draft' ?>"><?= esc($m['sifat_mk']) ?></span></td>
          <td class="num"><?= $m['sks'] ?></td>
          <td><?= esc($m['semester']) ?></td>
          <td title="<?= esc($desk) ?>"><?= esc($preview) ?: '<span class="muted">—</span>' ?></td>
          <td class="num"><?= $cpmkCount[$m['id']] ?? 0 ?></td>
          <td><?php if ($canWrite): ?><?= delete_form(site_url('mata-kuliah/delete/' . $m['id']), 'Hapus', 'Hapus mata kuliah ini?') ?><?php endif; ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
