<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<?php $roles = \App\Models\UserModel::ROLES; ?>
<div class="pagehead"><div><a class="link" href="<?= site_url('users') ?>">← Kembali ke daftar pengguna</a><h1 style="margin-top:8px">Ubah Pengguna</h1><p>Username: <span class="mono"><?= esc($user['username']) ?></span> (tidak dapat diubah)</p></div></div>
<div class="panel" style="max-width:560px">
  <form method="post" action="<?= site_url('users/update/' . $user['id']) ?>">
    <?= csrf_field() ?>
    <div class="field"><label>Nama lengkap</label><input type="text" name="nama" value="<?= esc($user['nama']) ?>" required></div>
    <div class="field"><label>Peran</label>
      <select name="role"><?php foreach ($roles as $k => $v): ?><option value="<?= $k ?>" <?= $user['role'] === $k ? 'selected' : '' ?>><?= esc($v) ?></option><?php endforeach; ?></select>
    </div>
    <div class="field"><label>Tautkan ke data dosen (wajib untuk Dosen &amp; Kaprodi)</label>
      <select name="dosen_id"><option value="">— tidak ditautkan —</option>
        <?php foreach ($dosenList as $d): ?><option value="<?= $d['id'] ?>" <?= (int) $user['dosen_id'] === (int) $d['id'] ? 'selected' : '' ?>><?= esc($d['nama']) ?></option><?php endforeach; ?>
      </select>
    </div>
    <label style="display:flex;align-items:center;gap:8px;margin:10px 0"><input type="checkbox" name="aktif" value="1" style="width:auto" <?= $user['aktif'] ? 'checked' : '' ?>> Akun aktif</label>
    <button type="submit" class="btn">Simpan Perubahan</button>
  </form>
</div>
<?= $this->endSection() ?>
