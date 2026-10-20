<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Masuk') ?> — SIRENCANA</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<!-- Tailwind CSS Output -->
<link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>
<body class="bg-gradient-to-br from-primary-800 via-primary-700 to-primary-900 min-h-screen">

<!-- Auth Wrapper dengan background gradasi biru -->
<div class="min-h-screen flex items-center justify-center px-6 py-12">
  
  <!-- Auth Card dengan border emas -->
  <div class="w-full max-w-md bg-white rounded-xl shadow-2xl border-4 border-gold p-8">
    
    <!-- Brand Header -->
    <div class="text-center mb-6">
      <h1 class="text-3xl font-serif font-bold text-gradient-blue mb-2">
        SIRENCANA
      </h1>
      <p class="text-sm text-primary-700">
        Sistem Perancangan &amp; Penjaminan Mutu Pembelajaran OBE
      </p>
    </div>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success mb-4">
        ✓ <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error mb-4">
        ✗ <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>
    
    <!-- Content -->
    <?= $this->renderSection('content') ?>
    
  </div>
</div>

</body>
</html>
