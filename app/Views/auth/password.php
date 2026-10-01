<?= $this->extend($wajib ? 'layout/auth' : 'layout/main') ?>
<?= $this->section('content') ?>
<?php if ($wajib): ?>
  <h1>Ganti Password</h1>
  <div class="sub">Demi keamanan, buat password baru sebelum melanjutkan.</div>
<?php else: ?>
  <div class="pagehead"><div><h1>Ganti Password</h1><p>Akun: <?= esc(user_name()) ?> (<?= esc(role_label(session()->get('role'))) ?>)</p></div></div>
<?php endif; ?>
<div class="<?= $wajib ? '' : 'panel' ?>" style="<?= $wajib ? '' : 'max-width:440px' ?>">
  <form method="post" action="<?= site_url('ganti-password') ?>" autocomplete="off">
    <?= csrf_field() ?>
    <div class="field"><label>Password lama</label><input type="password" name="password_lama" required></div>
    <div class="field"><label>Password baru (minimal 8 karakter)</label><input type="password" name="password_baru" minlength="8" required></div>
    <div class="field"><label>Ulangi password baru</label><input type="password" name="password_ulang" minlength="8" required></div>
    <button type="submit" class="btn">Simpan Password</button>
  </form>
  <?php if ($wajib): ?>
    <form method="post" action="<?= site_url('logout') ?>" style="margin-top:12px"><?= csrf_field() ?><button type="submit" class="link">Keluar</button></form>
  <?php endif; ?>
</div>
<?= $this->endSection() ?>
