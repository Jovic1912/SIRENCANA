<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<?php $roles = \App\Models\UserModel::ROLES; ?>

<div class="pagehead"><div><h1>Pengguna</h1><p>Kelola akun dan peran. Peran menentukan menu dan tindakan yang tersedia di setiap tahap alur kerja.</p></div></div>

<div class="panel">
  <h2>Peran dalam sistem</h2>
  <div class="tbl-wrap"><table>
    <thead><tr><th>Peran</th><th>Tugas dalam alur kerja</th></tr></thead>
    <tbody>
      <tr><td><strong>Administrator</strong></td><td>Mengelola data induk, akun pengguna, kurikulum, dan pembukaan kelas. Tidak dapat menyetujui atau menandatangani RPS (pemisahan tugas).</td></tr>
      <tr><td><strong>Dosen</strong></td><td>Menyusun RPS miliknya sendiri, mengajukan ke GKM, merevisi, menandatangani, serta mengisi kontrak, presensi, nilai, dan portofolio kelas yang diampunya.</td></tr>
      <tr><td><strong>GKM</strong></td><td>Memeriksa RPS yang diajukan: menyetujui atau mengembalikan untuk revisi disertai catatan.</td></tr>
      <tr><td><strong>Kaprodi</strong></td><td>Menandatangani RPS yang disetujui GKM, mengelola CPL/CPMK, mata kuliah, dan membuka kelas; dapat mengarsipkan RPS.</td></tr>
      <tr><td><strong>GPM</strong></td><td>Menerima dan mengarsipkan RPS yang sudah ditandatangani; memantau capaian dan portofolio.</td></tr>
    </tbody>
  </table></div>
</div>

<div class="panel">
  <h2>Tambah Pengguna</h2>
  <form method="post" action="<?= site_url('users/store') ?>" autocomplete="off">
    <?= csrf_field() ?>
    <div class="field-row">
      <div class="field"><label>Nama lengkap</label><input type="text" name="nama" required></div>
      <div class="field"><label>Username</label><input type="text" name="username" pattern="[a-z0-9._-]{3,30}" placeholder="huruf kecil/angka" required autocapitalize="none"></div>
      <div class="field"><label>Password awal (min. 8 karakter)</label><input type="text" name="password" minlength="8" required></div>
    </div>
    <div class="field-row">
      <div class="field"><label>Peran</label>
        <select name="role"><?php foreach ($roles as $k => $v): ?><option value="<?= $k ?>"><?= esc($v) ?></option><?php endforeach; ?></select>
      </div>
      <div class="field"><label>Tautkan ke data dosen <span class="muted">(wajib untuk Dosen &amp; Kaprodi)</span></label>
        <select name="dosen_id"><option value="">— tidak ditautkan —</option>
          <?php foreach ($dosenList as $d): ?><option value="<?= $d['id'] ?>"><?= esc($d['nama']) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <p class="hint">Pengguna baru wajib mengganti password saat login pertama. Buat dulu data dosen di menu Data Induk → Dosen bila belum ada.</p>
    <button type="submit" class="btn">Tambah Pengguna</button>
  </form>
</div>

<div class="panel">
  <h2>Daftar Pengguna</h2>
  <div class="tbl-wrap"><table>
    <thead><tr><th>Nama</th><th>Username</th><th>Peran</th><th>Data dosen</th><th>Status</th><th>Login terakhir</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($users as $u): $self = (int) $u['id'] === (int) session()->get('user_id'); ?>
      <tr>
        <td><?= esc($u['nama']) ?><?= $self ? ' <span class="muted small">(Anda)</span>' : '' ?></td>
        <td class="mono"><?= esc($u['username']) ?></td>
        <td><?= esc($roles[$u['role']] ?? $u['role']) ?></td>
        <td><?= esc($dosenById[$u['dosen_id']]['nama'] ?? '—') ?></td>
        <td>
          <?= $u['aktif'] ? '<span class="badge diarsipkan">Aktif</span>' : '<span class="badge draft">Nonaktif</span>' ?>
          <?= $u['wajib_ganti_password'] ? '<span class="badge ditandatangani" title="Belum mengganti password awal">Password sementara</span>' : '' ?>
        </td>
        <td class="muted small"><?= $u['last_login'] ? esc(date('d M Y H:i', strtotime($u['last_login']))) : 'belum pernah' ?></td>
        <td style="white-space:nowrap">
          <a class="link" href="<?= site_url('users/edit/' . $u['id']) ?>">Ubah</a> ·
          <form method="post" action="<?= site_url('users/reset/' . $u['id']) ?>" style="display:inline" onsubmit="return confirm('Buat password sementara baru untuk pengguna ini?')"><?= csrf_field() ?><button type="submit" class="link" style="background:none;border:none;cursor:pointer;font-family:inherit">Reset password</button></form>
          <?php if (! $self): ?> · <?= delete_form(site_url('users/delete/' . $u['id']), 'Hapus', 'Hapus pengguna ini?') ?><?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table></div>
</div>
<?= $this->endSection() ?>
