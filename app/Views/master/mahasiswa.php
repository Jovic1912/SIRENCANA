<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Mahasiswa</h1><p>Data induk mahasiswa — dipakai sebagai peserta kelas.</p></div></div>

<div class="panel">
  <?php if ($canWrite): ?>
<h2>Tambah Mahasiswa</h2>
  <form method="post" action="<?= site_url('mahasiswa/store') ?>">
<?= csrf_field() ?>
    <div class="field-row">
      <div class="field"><label>NIM</label><input type="text" name="nim" placeholder="mis. 2301020030" required></div>
      <div class="field"><label>Nama</label><input type="text" name="nama" placeholder="Nama lengkap" required></div>
      <div class="field"><label>Program Studi</label>
        <select name="prodi_id">
          <option value="">— pilih —</option>
          <?php foreach ($prodiList as $p): ?>
            <option value="<?= $p['id'] ?>"><?= esc($p['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <button type="submit" class="btn">Tambah Mahasiswa</button>
  </form>
<?php endif; ?>
</div>

<div class="panel">
  <h2>Daftar Mahasiswa</h2>
  <?php if (empty($mahasiswa)): ?>
    <div class="empty">Belum ada mahasiswa.</div>
  <?php else: ?>
    <div class="tbl-wrap" style="max-height:480px;overflow-y:auto"><table>
      <thead><tr><th>NIM</th><th>Nama</th><th>Prodi</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($mahasiswa as $m): ?>
        <tr>
          <td class="mono"><?= esc($m['nim']) ?></td>
          <td><?= esc($m['nama']) ?></td>
          <td><?= esc($prodiById[$m['prodi_id']]['nama'] ?? '—') ?></td>
          <td><?php if ($canWrite): ?><?= delete_form(site_url('mahasiswa/delete/' . $m['id']), 'Hapus', 'Hapus mahasiswa ini?') ?><?php endif; ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
