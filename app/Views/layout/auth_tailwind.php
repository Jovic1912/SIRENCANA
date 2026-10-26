<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Masuk') ?> — SIRENCANA</title>

<!-- Inter Font - sesuai design.md -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap" rel="stylesheet">

<!-- Tailwind CSS Output -->
<link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>
<body class="bg-gradient-to-br from-sky-100 via-white to-sky-50 min-h-screen">

<!-- Auth Wrapper - sky blue gradasi ke putih -->
<div class="min-h-screen flex items-center justify-center px-6 py-12">
  
  <!-- Auth Card - 28px radius sesuai design.md, tonal contrast tanpa heavy shadow -->
  <div class="w-full max-w-md bg-white rounded-card p-10 border border-sky-200/50 shadow-card">
    
    <!-- Brand Header -->
    <div class="text-center mb-8">
      <h1 class="text-4xl font-medium text-gradient-sky mb-3">
        SIRENCANA
      </h1>
      <p class="text-body-sm text-neutral-600 leading-relaxed">
        Sistem Perancangan &amp; Penjaminan Mutu Pembelajaran OBE
      </p>
    </div>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <span class="font-medium">✓</span> <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error">
        <span class="font-medium">✗</span> <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>
    
    <!-- Content -->
    <?= $this->renderSection('content') ?>
    
  </div>
</div>

</body>
</html>
