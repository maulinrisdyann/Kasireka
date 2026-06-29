<?= $this->extend('layouts/owner') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2 text-success"></i>Laporan Penjualan</h4>
    <a href="<?= base_url('owner/report/sales/export?' . http_build_query(['date_from' => $date_from, 'date_to' => $date_to])) ?>"
       class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf me-1"></i> Export PDF
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control" value="<?= $date_from ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control" value="<?= $date_to ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3" style="border-left:4px solid #198754">
            <div class="text-muted small">Total Transaksi</div>
            <h4 class="fw-bold mb-0"><?= $summary['total_trx'] ?? 0 ?></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3" style="border-left:4px solid #0d6efd">
            <div class="text-muted small">Total Pendapatan</div>
            <h4 class="fw-bold mb-0">Rp <?= number_format($summary['total_revenue'] ?? 0, 0, ',', '.') ?></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3" style="border-left:4px solid #9c27b0">
            <div class="text-muted small">Rata-rata per Transaksi</div>
            <h4 class="fw-bold mb-0">
                Rp <?= $summary['total_trx'] > 0
                    ? number_format($summary['total_revenue'] / $summary['total_trx'], 0, ',', '.')
                    : 0 ?>
            </h4>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead class="table-light">
                    <tr><th>#</th><th>Invoice</th><th>Kasir</th><th>Total</th><th>Metode</th><th>Waktu</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $i => $t): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><code><?= esc($t['invoice_number']) ?></code></td>
                            <td><?= esc($t['kasir_name']) ?></td>
                            <td class="fw-semibold">Rp <?= number_format($t['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?= $t['payment_method'] === 'cash'
                                    ? '<span class="badge bg-success">Tunai</span>'
                                    : '<span class="badge bg-info">Transfer</span>' ?>
                            </td>
                            <td><small><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></small></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
