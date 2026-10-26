<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<!-- Page Header - sesuai design.md dengan generous spacing -->
<div class="page-header">
  <div>
    <h1 class="page-title">Dasbor</h1>
    <p class="page-subtitle">Ringkasan status perancangan pembelajaran di seluruh program studi.</p>
  </div>
</div>

<!-- Grid Stats - 28px radius, tonal contrast per design.md -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
  <div class="stat-card">
    <div class="stat-number"><?= $jumlahMk ?></div>
    <div class="stat-label">Mata Kuliah terdaftar</div>
  </div>
  
  <div class="stat-card">
    <div class="stat-number"><?= $jumlahRps ?></div>
    <div class="stat-label">Dokumen RPS</div>
  </div>
  
  <div class="stat-card">
    <div class="stat-number"><?= $jumlahKelas ?></div>
    <div class="stat-label">Kelas berjalan</div>
  </div>
  
  <div class="stat-card">
    <div class="stat-number"><?= $jumlahMhs ?></div>
    <div class="stat-label">Mahasiswa terdaftar</div>
  </div>
  
  <div class="stat-card bg-gradient-to-br from-green-50 to-white border-green-200/50">
    <div class="stat-number text-green-700"><?= $statusCount['diarsipkan'] ?></div>
    <div class="stat-label">RPS diarsipkan (sah)</div>
  </div>
  
  <div class="stat-card bg-gradient-to-br from-amber-50 to-white border-amber-200/50">
    <div class="stat-number text-amber-700"><?= $statusCount['revisi_diperlukan'] ?></div>
    <div class="stat-label">RPS perlu revisi dosen</div>
  </div>
</div>

<!-- Panel Dokumen - card dengan 28px radius per design.md -->
<div class="card mb-12">
  <h2 class="card-header">Dokumen menunggu tindak lanjut</h2>
  
  <?php if (empty($perluAksi)): ?>
    <div class="text-center py-12 px-6 bg-sky-50 rounded-inner border border-dashed border-sky-300">
      <div class="text-4xl mb-3">✓</div>
      <p class="text-body text-neutral-600">Tidak ada dokumen yang menunggu aksi saat ini.</p>
    </div>
  <?php else: ?>
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>Mata Kuliah</th>
            <th>Tahun Akademik</th>
            <th>Status</th>
            <th class="text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($perluAksi as $r): $m = $mkById[$r['mk_id']] ?? null; ?>
          <tr>
            <td class="font-medium text-neutral-950">
              <?= esc(($m['kode'] ?? '—') . ' — ' . ($m['nama'] ?? '—')) ?>
            </td>
            <td class="text-neutral-700"><?= esc($r['tahun_akademik']) ?></td>
            <td><?= status_badge($r['status']) ?></td>
            <td class="text-right">
              <a href="<?= site_url('rps/' . $r['id']) ?>" 
                 class="inline-block btn-amber px-5 py-2 text-sm">
                Buka
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- Panel Distribusi Status - flat design dengan tonal separation -->
<div class="card">
  <h2 class="card-header">Distribusi status RPS</h2>
  
  <div class="space-y-4">
    <?php foreach ($statusOrder as $s): 
      $pct = $jumlahRps ? round($statusCount[$s] / $jumlahRps * 100) : 0; 
    ?>
      <div class="flex items-center gap-5">
        <div class="w-48 flex-shrink-0"><?= status_badge($s) ?></div>
        
        <!-- Progress bar dengan sky blue gradient -->
        <div class="flex-1 bg-sky-100 rounded-pill h-3 overflow-hidden border border-sky-200/50">
          <div class="h-full bg-gradient-to-r from-sky-600 to-sky-500 transition-all duration-500 rounded-pill" 
               style="width: <?= $pct ?>%">
          </div>
        </div>
        
        <div class="w-20 text-right font-medium text-neutral-950 text-lg">
          <?= $statusCount[$s] ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?= $this->endSection() ?>
