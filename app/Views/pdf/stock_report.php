<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h2 { text-align: center; margin: 0; }
        .subtitle { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #198754; color: white; padding: 8px; text-align: left; }
        td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) { background: #f8f9fa; }
        .badge-aman { color: #198754; font-weight: bold; }
        .badge-menipis { color: #fd7e14; font-weight: bold; }
        .badge-habis { color: #dc3545; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; color: #999; font-size: 10px; }
    </style>
</head>
<body>
    <h2>Laporan Stok Produk</h2>
    <p class="subtitle"><?= esc($tenant['name']) ?> | Per <?= date('d/m/Y H:i') ?></p>

    <table>
        <thead>
            <tr><th>#</th><th>Nama Produk</th><th>Kategori</th><th>Stok</th><th>Alert</th><th>Satuan</th><th>Harga</th><th>Status</th></tr>
        </thead>
        <tbody>
            <?php foreach ($products as $i => $p): ?>
                <?php
                if ($p['stock'] == 0) { $statusClass = 'badge-habis'; $statusText = 'Habis'; }
                elseif ($p['stock'] <= $p['stock_alert']) { $statusClass = 'badge-menipis'; $statusText = 'Menipis'; }
                else { $statusClass = 'badge-aman'; $statusText = 'Aman'; }
                ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($p['name']) ?></td>
                    <td><?= esc($p['category_name'] ?? '—') ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td><?= $p['stock_alert'] ?></td>
                    <td><?= esc($p['unit']) ?></td>
                    <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                    <td class="<?= $statusClass ?>"><?= $statusText ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">Dicetak pada: <?= date('d/m/Y H:i:s') ?></div>
</body>
</html>
