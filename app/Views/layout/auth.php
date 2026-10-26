<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Masuk') ?> — SIRENCANA</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
<style>
  .auth-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: linear-gradient(135deg, var(--color-sky-blue) 0%, var(--color-sky-600) 100%);
  }
  
  .auth-card {
    width: 100%;
    max-width: 420px;
    background: var(--color-pure-white);
    border-radius: var(--radius-card);
    padding: 40px 36px;
    box-shadow: 0 20px 60px rgba(30, 41, 59, 0.25);
  }
  
  .auth-card h1 {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.56px;
    color: var(--color-deep-ink);
    margin-bottom: 6px;
  }
  
  .auth-card .sub {
    color: var(--color-soft-ink);
    font-size: 14px;
    margin-bottom: 28px;
    line-height: 1.5;
  }
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
