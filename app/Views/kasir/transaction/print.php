<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk — <?= esc($transaction['invoice_number']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 280px; margin: 0 auto; padding: 10px; }
        .center { text-align: center; }
        .divider { border-top: 1px dashed #000; margin: 6px 0; }
        .row { display: flex; justify-content: space-between; }
        .item-name { word-break: break-word; }
        h3 { font-size: 14px; }
        .total-row { font-size: 13px; font-weight: bold; }
        @media print {
            body { width: 280px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="center">
        <h3><?= esc($tenant['name']) ?></h3>
        <?php if ($tenant['address']): ?><p><?= esc($tenant['address']) ?></p><?php endif; ?>
        <?php if ($tenant['phone']): ?><p>Telp: <?= esc($tenant['phone']) ?></p><?php endif; ?>
    </div>
    <div class="divider"></div>
    <div class="row"><span><?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?></span><span>Kasir: <?= esc($transaction['kasir_name']) ?></span></div>
    <div>Invoice: <?= esc($transaction['invoice_number']) ?></div>
    <div class="divider"></div>

    <?php foreach ($items as $item): ?>
        <div class="item-name"><?= esc($item['product_name']) ?></div>
        <div class="row">
            <span><?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
            <span>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
        </div>
    <?php endforeach; ?>

    <div class="divider"></div>
    <div class="row total-row"><span>TOTAL</span><span>Rp <?= number_format($transaction['total_amount'], 0, ',', '.') ?></span></div>
    <div class="row"><span>Bayar (<?= $transaction['payment_method'] === 'cash' ? 'Tunai' : 'Transfer' ?>)</span><span>Rp <?= number_format($transaction['payment_amount'], 0, ',', '.') ?></span></div>
    <div class="row"><span>Kembalian</span><span>Rp <?= number_format($transaction['change_amount'], 0, ',', '.') ?></span></div>
    <div class="divider"></div>
    <?php if ($transaction['note']): ?><p>Catatan: <?= esc($transaction['note']) ?></p><?php endif; ?>
    <div class="center"><p>Terima kasih telah berbelanja!</p></div>

    <div class="no-print" style="margin-top:16px;text-align:center">
        <button onclick="window.print()" style="padding:8px 20px;cursor:pointer;background:#0d6efd;color:#fff;border:none;border-radius:6px">
            🖨️ Print Struk
        </button>
        <button onclick="window.close()" style="padding:8px 20px;cursor:pointer;margin-left:8px">Tutup</button>
    </div>
    <script>window.onload = function(){ window.print(); }</script>
</body>
</html>
