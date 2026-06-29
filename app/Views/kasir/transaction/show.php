<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('kasir/transaction/history') ?>" class="btn btn-outline-secondary btn-sm me-3"><i class="fas fa-arrow-left"></i></a>
    <h4 class="mb-0 fw-bold">Detail Transaksi</h4>
    <a href="<?= base_url('kasir/transaction/' . $transaction['id'] . '/print') ?>" target="_blank" class="btn btn-outline-secondary btn-sm ms-auto">
        <i class="fas fa-print me-1"></i> Cetak Struk
    </a>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3 text-muted">Info Transaksi</h6>
                <table class="table table-sm mb-0">
                    <tr><td class="text-muted">Invoice</td><td><code><?= esc($transaction['invoice_number']) ?></code></td></tr>
                    <tr><td class="text-muted">Kasir</td><td><?= esc($transaction['kasir_name']) ?></td></tr>
                    <tr><td class="text-muted">Waktu</td><td><?= date('d/m/Y H:i:s', strtotime($transaction['created_at'])) ?></td></tr>
                    <tr><td class="text-muted">Metode</td><td>
                        <?= $transaction['payment_method'] === 'cash' ? '<span class="badge bg-success">Tunai</span>' : '<span class="badge bg-info">Transfer</span>' ?>
                    </td></tr>
                    <tr><td class="text-muted">Total</td><td class="fw-bold">Rp <?= number_format($transaction['total_amount'], 0, ',', '.') ?></td></tr>
                    <tr><td class="text-muted">Bayar</td><td>Rp <?= number_format($transaction['payment_amount'], 0, ',', '.') ?></td></tr>
                    <tr><td class="text-muted">Kembalian</td><td class="fw-bold text-primary">Rp <?= number_format($transaction['change_amount'], 0, ',', '.') ?></td></tr>
                    <?php if ($transaction['note']): ?>
                        <tr><td class="text-muted">Catatan</td><td><?= esc($transaction['note']) ?></td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Item Belanja</h6>
            </div>
            <div class="card-body pt-0">
                <table class="table">
                    <thead class="table-light"><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= esc($item['product_name']) ?></td>
                                <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td class="fw-semibold">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total</td>
                            <td>Rp <?= number_format($transaction['total_amount'], 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
