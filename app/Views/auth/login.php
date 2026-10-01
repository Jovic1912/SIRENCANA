<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<h1>SIRENCANA</h1>
<div class="sub">Sistem Perancangan &amp; Penjaminan Mutu Pembelajaran OBE</div>
<form method="post" action="<?= site_url('login') ?>" autocomplete="off">
  <?= csrf_field() ?>
  <div class="field"><label>Username</label><input type="text" name="username" required autofocus autocapitalize="none"></div>
  <div class="field"><label>Password</label><input type="password" name="password" required></div>
  <button type="submit" class="btn" style="width:100%">Masuk</button>
</form>
<p class="hint" style="margin-top:16px">Belum punya akun? Hubungi administrator program studi Anda.</p>
<?= $this->endSection() ?>
