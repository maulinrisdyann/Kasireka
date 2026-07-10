<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Dashboard Kasir</h4>
        <small class="text-muted">Selamat datang, <?= esc(session('name')) ?></small>
    </div>
    <a href="<?= base_url('kasir/transaction') ?>" class="btn btn-primary">
        <i class="fas fa-cash-register me-1"></i> Mulai Transaksi
    </a>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#9c27b0,#6f2ca0)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Transaksi Hari Ini</p>
                    <h3 class="mb-0 fw-bold"><?= $sales_today['total_trx'] ?? 0 ?></h3>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-receipt"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#0d6efd,#0d47a1)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Pendapatan Hari Ini</p>
                    <h3 class="mb-0 fw-bold">
                        Rp <?= number_format($sales_today['total_revenue'] ?? 0, 0, ',', '.') ?>
                    </h3>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,<?= $low_stock_count > 0 ? '#dc3545,#a71d2a' : '#198754,#0f5132' ?>)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Stok Menipis</p>
                    <h3 class="mb-0 fw-bold"><?= $low_stock_count ?></h3>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Alert Stok Menipis -->
<?php if (!empty($low_stock)): ?>
<div class="alert alert-warning border-0 shadow-sm mb-4">
    <div class="d-flex align-items-start">
        <i class="fas fa-exclamation-triangle fs-4 me-3 mt-1 text-warning"></i>
        <div class="flex-grow-1">
            <h6 class="mb-2 fw-bold text-dark">
                <span class="badge bg-warning text-dark me-2"><?= count($low_stock) ?></span>
                Produk dengan stok menipis atau habis!
            </h6>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Produk</th><th>Stok</th><th>Batas Alert</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php foreach ($low_stock as $p): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($p['name']) ?></td>
                                <td>
                                    <span class="badge <?= $p['stock'] == 0 ? 'bg-danger' : 'bg-warning text-dark' ?>">
                                        <?= $p['stock'] ?> <?= esc($p['unit']) ?>
                                    </span>
                                </td>
                                <td><?= $p['stock_alert'] ?></td>
                                <td>
                                    <?php if ($p['stock'] == 0): ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Menipis</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="<?= base_url('kasir/stock') ?>" class="btn btn-sm btn-outline-warning mt-2">
                <i class="fas fa-warehouse me-1"></i> Lihat Semua Stok
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Quick Links -->
<div class="row g-3">
    <div class="col-md-4">
        <a href="<?= base_url('kasir/transaction') ?>" class="card text-decoration-none h-100 border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="fas fa-cash-register fs-1 text-primary mb-3"></i>
                <h6 class="fw-bold">Kasir POS</h6>
                <p class="text-muted small mb-0">Proses transaksi penjualan</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= base_url('kasir/products') ?>" class="card text-decoration-none h-100 border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="fas fa-box fs-1 text-success mb-3"></i>
                <h6 class="fw-bold">Kelola Produk</h6>
                <p class="text-muted small mb-0">Tambah & edit produk</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= base_url('kasir/transaction/history') ?>" class="card text-decoration-none h-100 border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="fas fa-history fs-1 text-info mb-3"></i>
                <h6 class="fw-bold">Riwayat Transaksi</h6>
                <p class="text-muted small mb-0">Lihat transaksi sebelumnya</p>
            </div>
        </a>
    </div>
</div>

<?= $this->endSection() ?>
