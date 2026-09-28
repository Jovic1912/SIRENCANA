<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('kelas') ?>">← Kembali ke daftar kelas</a>
    <h1 style="margin-top:8px"><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? '')) ?> — Kelas <?= esc($kelas['label']) ?></h1>
    <p><?= esc($kelas['semester']) ?> · <?= esc($kelas['tahun_akademik']) ?> · Pengampu: <?= esc(implode(', ', $dosenNama) ?: '—') ?></p>
  </div>
</div>

<div class="two-col">
  <div>
    <div class="panel">
      <h2>Kontrak Kuliah</h2>
      <form method="post" action="<?= site_url('kelas/' . $kelas['id'] . '/kontrak') ?>">
        <div class="field-row">
          <div class="field"><label>Ruang</label><input type="text" name="jadwal_ruang" value="<?= esc($kontrak['jadwal_ruang'] ?? '') ?>"></div>
          <div class="field"><label>Hari</label><input type="text" name="jadwal_hari" value="<?= esc($kontrak['jadwal_hari'] ?? '') ?>"></div>
        </div>
        <div class="field"><label>Jam</label><input type="text" name="jadwal_jam" value="<?= esc($kontrak['jadwal_jam'] ?? '') ?>"></div>
        <div class="field"><label>Klausa &amp; Tata Tertib Tambahan</label><textarea name="klausa"><?= esc($kontrak['klausa'] ?? '') ?></textarea></div>
        <label style="display:flex;align-items:center;gap:8px;margin:8px 0">
          <input type="checkbox" name="ttd" value="1" <?= ! empty($kontrak['ttd']) ? 'checked' : '' ?>> Disepakati &amp; ditandatangani (dosen &amp; perwakilan mahasiswa)
        </label>
        <?php if (! empty($kontrak['ttd']) && ! empty($kontrak['tgl_ttd'])): ?>
          <p class="hint">Ditandatangani <?= esc(date('d M Y', strtotime($kontrak['tgl_ttd']))) ?></p>
        <?php endif; ?>
        <button type="submit" class="btn sm">Simpan Kontrak</button>
      </form>
    </div>
  </div>
  <div>
    <div class="panel">
      <h2>Peserta Kelas (<?= count($peserta) ?>)</h2>
      <form method="post" action="<?= site_url('kelas/' . $kelas['id'] . '/peserta/add') ?>">
        <div class="field-row">
          <div class="field" style="flex:1">
            <select name="mahasiswa_id">
              <?php if (empty($eligibleMhs)): ?><option value="">Tidak ada kandidat tersedia</option><?php endif; ?>
              <?php foreach ($eligibleMhs as $m): ?>
                <option value="<?= $m['id'] ?>"><?= esc($m['nim'] . ' — ' . $m['nama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div><button type="submit" class="btn ghost sm">+ Tambah</button></div>
        </div>
      </form>
      <div class="tbl-wrap" style="max-height:400px;overflow-y:auto"><table>
        <thead><tr><th>NIM</th><th>Nama</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($peserta as $p): $m = $mhsById[$p['mahasiswa_id']] ?? null; ?>
          <tr>
            <td class="mono"><?= esc($m['nim'] ?? '—') ?></td>
            <td><?= esc($m['nama'] ?? '—') ?></td>
            <td><a class="iconbtn" href="<?= site_url('kelas/' . $kelas['id'] . '/peserta/delete/' . $p['id']) ?>" onclick="return confirm('Keluarkan peserta ini?')">Keluarkan</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
