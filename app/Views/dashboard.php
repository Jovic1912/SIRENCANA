<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Page Header dengan gradasi biru -->
<div class="page-header">
  <div>
    <h1 class="page-title">Dasbor</h1>
    <p class="page-subtitle">Ringkasan status perancangan pembelajaran di seluruh program studi.</p>
  </div>
</div>

<!-- Grid Stats dengan border emas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
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
  
  <div class="stat-card">
    <div class="stat-number"><?= $statusCount['diarsipkan'] ?></div>
    <div class="stat-label">RPS diarsipkan (sah)</div>
  </div>
  
  <div class="stat-card">
    <div class="stat-number"><?= $statusCount['revisi_diperlukan'] ?></div>
    <div class="stat-label">RPS perlu revisi dosen</div>
  </div>
</div>

<!-- Panel Dokumen dengan border emas -->
<div class="card mb-6">
  <h2 class="card-header">Dokumen menunggu tindak lanjut</h2>
  
  <?php if (empty($perluAksi)): ?>
    <div class="text-center py-8 px-4 text-primary-600 bg-primary-50 rounded-lg border border-dashed border-yellow-dark">
      Tidak ada dokumen yang menunggu aksi saat ini.
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
            <td class="font-medium text-primary-900">
              <?= esc(($m['kode'] ?? '—') . ' — ' . ($m['nama'] ?? '—')) ?>
            </td>
            <td class="text-primary-700"><?= esc($r['tahun_akademik']) ?></td>
            <td><?= status_badge($r['status']) ?></td>
            <td class="text-right">
              <a href="<?= site_url('rps/' . $r['id']) ?>" 
                 class="inline-block px-4 py-1.5 text-sm font-semibold bg-yellow-dark hover:bg-yellow text-primary-950 rounded border border-yellow-dark transition-colors">
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

<!-- Panel Distribusi Status -->
<div class="card">
  <h2 class="card-header">Distribusi status RPS</h2>
  
  <div class="space-y-3">
    <?php foreach ($statusOrder as $s): 
      $pct = $jumlahRps ? round($statusCount[$s] / $jumlahRps * 100) : 0; 
    ?>
      <div class="flex items-center gap-4">
        <div class="w-48"><?= status_badge($s) ?></div>
        
        <div class="flex-1 bg-primary-100 rounded-full h-2.5 overflow-hidden border border-yellow-dark">
          <div class="h-full bg-gradient-to-r from-primary-900 to-primary-700 transition-all duration-500" 
               style="width: <?= $pct ?>%">
          </div>
        </div>
        
        <div class="w-16 text-right font-mono font-bold text-primary-800">
          <?= $statusCount[$s] ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?= $this->endSection() ?>
