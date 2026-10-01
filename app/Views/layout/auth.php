<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Masuk') ?> — SIRENCANA</title>
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
<style>
  .auth-wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;background:var(--navy)}
  .auth-card{width:100%;max-width:400px;background:var(--paper-raised);border-radius:var(--radius);padding:32px 30px}
  .auth-card h1{font-size:1.6rem;margin-bottom:2px}
  .auth-card .sub{color:var(--ink-soft);font-size:.82rem;margin-bottom:22px}
</style>
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <?php if (session()->getFlashdata('success')): ?><div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?><div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
    <?= $this->renderSection('content') ?>
  </div>
</div>
</body>
</html>
