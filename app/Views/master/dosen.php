<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Dosen</h1><p>Data induk dosen — dipakai sebagai pengembang RPS, koordinator prodi, dan pengampu kelas.</p></div></div>

<div class="panel">
  <h2>Tambah Dosen</h2>
  <form method="post" action="<?= site_url('dosen/store') ?>">
    <div class="field-row">
      <div class="field"><label>Nama Dosen</label><input type="text" name="nama" placeholder="mis. Dr. Ahmad Fauzi, S.Kom., M.T." required></div>
      <div class="field"><label>NIDN</label><input type="text" name="nidn" placeholder="mis. 1012039001"></div>
    </div>
    <button type="submit" class="btn">Tambah Dosen</button>
  </form>
</div>

<div class="panel">
  <h2>Daftar Dosen</h2>
  <?php if (empty($dosen)): ?>
    <div class="empty">Belum ada dosen.</div>
  <?php else: ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Nama</th><th>NIDN</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($dosen as $d): ?>
        <tr>
          <td><?= esc($d['nama']) ?></td>
          <td class="mono"><?= esc($d['nidn']) ?></td>
          <td><a class="iconbtn" href="<?= site_url('dosen/delete/' . $d['id']) ?>" onclick="return confirm('Hapus dosen ini?')">Hapus</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
