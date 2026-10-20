<?= $this->extend('layout/auth_tailwind') ?>
<?= $this->section('content') ?>

<!-- Login Form -->
<form method="post" action="<?= site_url('login') ?>" autocomplete="off" class="space-y-5">
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
  
  <!-- Submit Button dengan warna kuning dan border emas -->
  <button type="submit" class="w-full btn-yellow py-3 text-base font-bold shadow-lg hover:shadow-xl transition-all duration-200">
    🔐 Masuk
  </button>
</form>

<!-- Footer Text -->
<p class="text-center text-sm text-primary-600 mt-6 pt-6 border-t-2 border-gold-pale">
  Belum punya akun? <br>
  <span class="font-semibold text-primary-800">Hubungi administrator program studi Anda.</span>
</p>

<?= $this->endSection() ?>
