<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Program Studi</h1><p>Data induk fakultas, jurusan, dan program studi.</p></div></div>

<div class="panel">
  <h2>Tambah Program Studi</h2>
  <form method="post" action="<?= site_url('prodi/store') ?>">
    <div class="field-row">
      <div class="field"><label>Nama Program Studi</label><input type="text" name="nama" placeholder="mis. Informatika" required></div>
      <div class="field"><label>Jurusan</label><input type="text" name="jurusan" placeholder="mis. Teknik Informatika"></div>
      <div class="field"><label>Fakultas</label><input type="text" name="fakultas" placeholder="mis. FTTK"></div>
    </div>
    <button type="submit" class="btn">Tambah Program Studi</button>
  </form>
</div>

<div class="panel">
  <h2>Daftar Program Studi</h2>
  <?php if (empty($prodi)): ?>
    <div class="empty">Belum ada program studi.</div>
  <?php else: ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Prodi</th><th>Jurusan</th><th>Fakultas</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($prodi as $p): ?>
        <tr>
          <td><strong><?= esc($p['nama']) ?></strong></td>
          <td><?= esc($p['jurusan']) ?></td>
          <td><?= esc($p['fakultas']) ?></td>
          <td><a class="iconbtn" href="<?= site_url('prodi/delete/' . $p['id']) ?>" onclick="return confirm('Hapus program studi ini?')">Hapus</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
