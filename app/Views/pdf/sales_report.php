<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h2 { text-align: center; margin: 0; }
        .subtitle { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #0d6efd; color: white; padding: 8px; text-align: left; }
        td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) { background: #f8f9fa; }
        .summary { margin: 16px 0; padding: 12px; background: #f0f7ff; border-radius: 6px; }
        .summary div { display: inline-block; margin-right: 30px; }
        .footer { margin-top: 20px; text-align: right; color: #999; font-size: 10px; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <p class="subtitle"><?= esc($tenant['name']) ?> | <?= date('d/m/Y', strtotime($date_from)) ?> – <?= date('d/m/Y', strtotime($date_to)) ?></p>

    <div class="summary">
        <div><strong>Total Transaksi:</strong> <?= $summary['total_trx'] ?? 0 ?></div>
        <div><strong>Total Pendapatan:</strong> Rp <?= number_format($summary['total_revenue'] ?? 0, 0, ',', '.') ?></div>
    </div>

    <table>
        <thead>
            <tr><th>#</th><th>Invoice</th><th>Kasir</th><th>Total</th><th>Metode</th><th>Waktu</th></tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $i => $t): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($t['invoice_number']) ?></td>
                    <td><?= esc($t['kasir_name']) ?></td>
                    <td>Rp <?= number_format($t['total_amount'], 0, ',', '.') ?></td>
                    <td><?= $t['payment_method'] === 'cash' ? 'Tunai' : 'Transfer' ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">Dicetak pada: <?= date('d/m/Y H:i:s') ?></div>
</body>
</html>
