<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Dasbor</h1><p>Ringkasan status perancangan pembelajaran di seluruh program studi.</p></div></div>

<div class="grid-stats">
  <div class="stat"><div class="n"><?= $jumlahMk ?></div><div class="l">Mata Kuliah terdaftar</div></div>
  <div class="stat"><div class="n"><?= $jumlahRps ?></div><div class="l">Dokumen RPS</div></div>
  <div class="stat"><div class="n"><?= $jumlahKelas ?></div><div class="l">Kelas berjalan</div></div>
  <div class="stat"><div class="n"><?= $jumlahMhs ?></div><div class="l">Mahasiswa terdaftar</div></div>
  <div class="stat"><div class="n"><?= $statusCount['diarsipkan'] ?></div><div class="l">RPS diarsipkan (sah)</div></div>
  <div class="stat"><div class="n"><?= $statusCount['revisi_diperlukan'] ?></div><div class="l">RPS perlu revisi dosen</div></div>
</div>

<div class="panel">
  <h2>Dokumen menunggu tindak lanjut</h2>
  <?php if (empty($perluAksi)): ?>
    <div class="empty">Tidak ada dokumen yang menunggu aksi saat ini.</div>
  <?php else: ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Mata Kuliah</th><th>Tahun Akademik</th><th>Status</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($perluAksi as $r): $m = $mkById[$r['mk_id']] ?? null; ?>
        <tr>
          <td><?= esc(($m['kode'] ?? '—') . ' — ' . ($m['nama'] ?? '—')) ?></td>
          <td><?= esc($r['tahun_akademik']) ?></td>
          <td><?= status_badge($r['status']) ?></td>
          <td><a class="link" href="<?= site_url('rps/' . $r['id']) ?>">Buka →</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>

<div class="panel">
  <h2>Distribusi status RPS</h2>
  <div class="tbl-wrap"><table><tbody>
  <?php foreach ($statusOrder as $s): $pct = $jumlahRps ? round($statusCount[$s] / $jumlahRps * 100) : 0; ?>
    <tr>
      <td style="width:200px"><?= status_badge($s) ?></td>
      <td><div style="background:var(--line);height:6px;border-radius:4px;overflow:hidden"><div style="width:<?= $pct ?>%;height:100%;background:var(--teal)"></div></div></td>
      <td class="num" style="width:40px"><?= $statusCount[$s] ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody></table></div>
</div>

<?= $this->endSection() ?>
