<?php if (empty($rows)): ?>
  <div class="empty">Kelas ini belum memiliki peserta.</div>
<?php elseif (empty($cpmkList)): ?>
  <div class="empty">RPS kelas ini belum memiliki CPMK.</div>
<?php else: ?>
  <div class="panel">
    <h2>Ringkasan per CPMK</h2>
    <div class="tbl-wrap"><table>
      <thead><tr><th>CPMK</th><th class="num">Sangat Baik</th><th class="num">Baik</th><th class="num">Cukup</th><th class="num">Kurang</th><th class="num">% Kelulusan</th></tr></thead>
      <tbody>
      <?php foreach ($summary as $s): ?>
        <tr>
          <td class="mono"><?= esc($s['cpmk']['kode']) ?></td>
          <td class="num"><?= $s['sb'] ?></td><td class="num"><?= $s['b'] ?></td><td class="num"><?= $s['c'] ?></td><td class="num"><?= $s['k'] ?></td>
          <td class="num"><strong><?= $s['persenLulus'] ?>%</strong></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  </div>
  <div class="panel">
    <h2>Capaian per Mahasiswa</h2>
    <div class="tbl-wrap"><table>
      <thead><tr><th>NIM</th><th>Nama</th><th class="num">Kehadiran</th><?php foreach ($cpmkList as $c): ?><th class="num"><?= esc($c['kode']) ?></th><?php endforeach; ?></tr></thead>
      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td class="mono"><?= esc($r['mhs']['nim'] ?? '—') ?></td>
          <td><?= esc($r['mhs']['nama'] ?? '—') ?></td>
          <td class="num"><?= $r['pres']['skor'] ?>% <?= $r['pres']['eligible'] ? '' : '<span class="badge revisi_diperlukan">Tak Eligible</span>' ?></td>
          <?php foreach ($r['capaian'] as $c): ?>
            <td class="num"><?= $c['nilai'] !== null ? esc($c['nilai']) . ' <span class="badge ' . skala_class($c['skala']) . '">' . esc($c['skala']) . '</span>' : '<span class="muted">—</span>' ?></td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  </div>
<?php endif; ?>
