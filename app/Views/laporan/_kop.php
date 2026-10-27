<?php
/**
 * Kop dokumen UMRAH.
 * @var array|null $prodi  baris prodi (nama, jurusan, fakultas)
 * @var string     $judul  judul dokumen di bawah kop (opsional)
 */
$logo = is_file(FCPATH . 'assets/logo-umrah.png') ? base_url('assets/logo-umrah.png') : null;
// Hindari "FAKULTAS FAKULTAS ..." bila data prodi sudah memuat awalan.
$baris = static fn (string $awalan, ?string $isi) => $awalan . ' ' . strtoupper(trim(preg_replace('/^' . $awalan . '\s+/i', '', (string) ($isi ?: '…'))));
?>
<div class="kop">
  <?php if ($logo): ?><img src="<?= $logo ?>" alt="Logo UMRAH"><?php endif; ?>
  <div class="t">
    UNIVERSITAS MARITIM RAJA ALI HAJI<br>
    <?= esc($baris('FAKULTAS', $prodi['fakultas'] ?? null)) ?><br>
    <?= esc($baris('JURUSAN', $prodi['jurusan'] ?? null)) ?><br>
    <?= esc($baris('PROGRAM STUDI', $prodi['nama'] ?? null)) ?>
  </div>
  <?php if (! empty($kanan)): ?><div style="width:130px;border-left:1px solid #000;padding-left:8px;font-size:9pt"><?= $kanan ?></div><?php endif; ?>
</div>
<?php if (! empty($judul)): ?><div class="band"><?= esc($judul) ?></div><?php endif; ?>
