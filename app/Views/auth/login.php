<?= $this->extend('layout/auth_tailwind') ?>
<?= $this->section('content') ?>

<!-- Login Form -->
<form method="post" action="<?= site_url('login') ?>" autocomplete="off" class="space-y-6">
  <?= csrf_field() ?>
  
  <!-- Username Field -->
  <div class="form-group">
    <label class="form-label">Username</label>
    <input type="text" 
           name="username" 
           required 
           autofocus 
           autocapitalize="none"
           placeholder="Masukkan username Anda"
           class="form-input">
  </div>
  
  <!-- Password Field -->
  <div class="form-group">
    <label class="form-label">Password</label>
    <input type="password" 
           name="password" 
           required
           placeholder="Masukkan password Anda"
           class="form-input">
  </div>
  
  <!-- Submit Button - Amber sesuai design.md -->
  <button type="submit" class="w-full btn-amber text-base">
    Masuk
  </button>
</form>

<!-- Footer Text -->
<p class="text-center text-body-sm text-neutral-600 mt-8 pt-6 border-t border-sky-100">
  Belum punya akun? <br>
  <span class="font-medium text-neutral-950 mt-1 inline-block">Hubungi administrator program studi Anda.</span>
</p>

<?= $this->endSection() ?>
