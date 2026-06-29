<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-history me-2" style="color:#9c27b0"></i>Riwayat Transaksi</h4>
    <a href="<?= base_url('kasir/transaction') ?>" class="btn btn-primary">
        <i class="fas fa-cash-register me-1"></i> Transaksi Baru
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead class="table-light">
                    <tr><th>#</th><th>Invoice</th><th>Total</th><th>Bayar</th><th>Kembalian</th><th>Metode</th><th>Waktu</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $i => $t): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><code><?= esc($t['invoice_number']) ?></code></td>
                            <td class="fw-semibold">Rp <?= number_format($t['total_amount'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($t['payment_amount'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($t['change_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?= $t['payment_method'] === 'cash'
                                    ? '<span class="badge bg-success">Tunai</span>'
                                    : '<span class="badge bg-info">Transfer</span>' ?>
                            </td>
                            <td><small><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></small></td>
                            <td>
                                <a href="<?= base_url('kasir/transaction/' . $t['id']) ?>" class="btn btn-sm btn-outline-primary py-0 px-2">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('kasir/transaction/' . $t['id'] . '/print') ?>" target="_blank" class="btn btn-sm btn-outline-secondary py-0 px-2">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
