<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Laporan') ?></title>
<style>
  @page { size: A4 portrait; margin: 15mm 15mm 15mm 18mm; }
  @page land { size: A4 landscape; margin: 12mm 12mm 12mm 12mm; }
  * { box-sizing: border-box; }
  html, body { background: #e9e9e9; margin: 0; }
  body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; line-height: 1.35; }
  .toolbar { position: sticky; top: 0; z-index: 10; background: #1d2b53; color: #fff; padding: 10px 16px; display: flex; gap: 10px; align-items: center; font-family: Arial, sans-serif; font-size: 13px; }
  .toolbar a, .toolbar button { color: #fff; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.3); border-radius: 4px; padding: 6px 12px; text-decoration: none; cursor: pointer; font: inherit; }
  .toolbar .grow { flex: 1; }
  .sheet { background: #fff; width: 210mm; min-height: 297mm; margin: 14px auto; padding: 15mm 15mm 15mm 18mm; box-shadow: 0 1px 4px rgba(0,0,0,.2); }
  .sheet.landscape { width: 297mm; min-height: 210mm; padding: 12mm; page: land; }
  h1, h2, h3, h4 { margin: 0; }
  p { margin: 0 0 6px; }
  table.doc { width: 100%; border-collapse: collapse; margin: 0 0 10px; }
  table.doc th, table.doc td { border: 1px solid #000; padding: 3px 5px; vertical-align: top; text-align: left; }
  table.doc th { background: #d9d9d9; font-weight: bold; text-align: center; vertical-align: middle; }
  table.doc td.c, table.doc th.c { text-align: center; }
  table.doc td.r { text-align: right; }
  table.doc td.label { background: #f0f0f0; font-weight: bold; width: 28%; }
  table.doc tr { break-inside: avoid; }
  table.doc tr.pecah { break-inside: auto; } /* baris panjang boleh terpotong antarhalaman */
  table.doc.sm { font-size: 9pt; }
  table.doc.xs { font-size: 8pt; }
  table.doc.xs th, table.doc.xs td { padding: 2px 3px; }
  .band { background: #d9d9d9; font-weight: bold; text-align: center; border: 1px solid #000; padding: 4px; margin: 0; }
  .band.navy { background: #002060; color: #fff; border-color: #002060; }
  .band.blue { background: #dbe9f4; }
  .band.orange { background: #f79646; }
  .sec { font-weight: bold; margin: 12px 0 6px; }
  .pre { white-space: pre-line; }
  .muted { color: #555; font-style: italic; }
  .center { text-align: center; }
  .right { text-align: right; }
  .kop { display: flex; align-items: center; gap: 14px; border: 1px solid #000; padding: 6px 10px; }
  .kop img { width: 72px; height: 72px; object-fit: contain; }
  .kop .t { flex: 1; text-align: center; font-weight: bold; line-height: 1.25; }
  .ttd { height: 70px; }
  .lulus-no { background: #ff0000; color: #fff; }
  table.doc .sk-sb { background: #00b0f0; color: #000; } table.doc .sk-b { background: #00b050; color: #000; }
  table.doc .sk-c { background: #92d050; color: #000; } table.doc .sk-k { background: #ffff00; color: #000; }
  table.doc .lulus-no { background: #ff0000; color: #fff; }
  .bar { display: inline-block; height: 10px; background: #4472c4; vertical-align: middle; }
  .page-break { break-before: page; }
  ol, ul { margin: 2px 0 6px; padding-left: 20px; }
  @media print {
    html, body { background: #fff; }
    .toolbar { display: none; }
    .sheet, .sheet.landscape { width: auto; min-height: 0; margin: 0; padding: 0; box-shadow: none; }
    .sheet + .sheet { break-before: page; }
    * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  }
</style>
</head>
<body>
<div class="toolbar">
  <a href="javascript:history.length > 1 ? history.back() : window.close()">← Kembali</a>
  <span class="grow"><?= esc($title ?? 'Laporan') ?></span>
  <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
</div>
<?= $this->renderSection('content') ?>
</body>
</html>
