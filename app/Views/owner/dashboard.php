<?= $this->extend('layouts/owner') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Dashboard Owner</h4>
        <small class="text-muted">Selamat datang, <?= esc(session('name')) ?></small>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#198754,#0f5132)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Penjualan Hari Ini</p>
                    <h4 class="mb-0 fw-bold">Rp <?= number_format($today_sales['total_revenue'] ?? 0, 0, ',', '.') ?></h4>
                    <small class="opacity-75"><?= $today_sales['total_trx'] ?? 0 ?> transaksi</small>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#0d6efd,#0d47a1)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Minggu Ini</p>
                    <h4 class="mb-0 fw-bold">Rp <?= number_format($week_sales['total_revenue'] ?? 0, 0, ',', '.') ?></h4>
                    <small class="opacity-75"><?= $week_sales['total_trx'] ?? 0 ?> transaksi</small>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-calendar-week"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#9c27b0,#6f2ca0)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Bulan Ini</p>
                    <h4 class="mb-0 fw-bold">Rp <?= number_format($month_sales['total_revenue'] ?? 0, 0, ',', '.') ?></h4>
                    <small class="opacity-75"><?= $month_sales['total_trx'] ?? 0 ?> transaksi</small>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-calendar-alt"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,<?= $low_stock_count > 0 ? '#dc3545,#a71d2a' : '#6c757d,#495057' ?>)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Stok Menipis</p>
                    <h3 class="mb-0 fw-bold"><?= $low_stock_count ?> produk</h3>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Grafik Penjualan 7 Hari -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2 text-success"></i>Penjualan 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Top 5 Produk -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-trophy me-2 text-warning"></i>Top 5 Produk Terlaris</h6>
            </div>
            <div class="card-body pt-0">
                <?php if (empty($top_products)): ?>
                    <p class="text-muted text-center py-4">Belum ada data penjualan.</p>
                <?php else: ?>
                    <?php foreach ($top_products as $i => $p): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="fw-bold text-muted me-3" style="width:20px"><?= $i + 1 ?></div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small"><?= esc($p['product_name']) ?></div>
                                <div class="text-muted" style="font-size:.78rem">Terjual: <?= $p['total_qty'] ?> unit</div>
                            </div>
                            <div class="text-success fw-bold small">Rp <?= number_format($p['total_revenue'], 0, ',', '.') ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
const ctx = document.getElementById('salesChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= $chart_labels ?>,
        datasets: [{
            label: 'Penjualan (Rp)',
            data: <?= $chart_data ?>,
            backgroundColor: 'rgba(25,135,84,0.7)',
            borderColor: '#198754',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID')
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'Rp ' + Number(v).toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
