<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Dashboard Admin</h4>
        <small class="text-muted">Selamat datang, <?= esc(session('name')) ?></small>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#0d6efd,#0d47a1)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Total Tenant</p>
                    <h3 class="mb-0 fw-bold"><?= $total_tenants ?></h3>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-store"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#198754,#0f5132)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Tenant Aktif</p>
                    <h3 class="mb-0 fw-bold"><?= $active_tenants ?></h3>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#ffc107,#fd7e14)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small text-dark">Order Pending</p>
                    <h3 class="mb-0 fw-bold text-dark"><?= $pending_orders ?></h3>
                </div>
                <div class="fs-2 opacity-50 text-dark"><i class="fas fa-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3" style="background:linear-gradient(135deg,#9c27b0,#6f2ca0)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 opacity-75 small">Total User</p>
                    <h3 class="mb-0 fw-bold"><?= $total_users ?></h3>
                </div>
                <div class="fs-2 opacity-50"><i class="fas fa-users"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Subscription Orders -->
<div class="card">
    <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between py-3">
        <h6 class="mb-0 fw-bold"><i class="fas fa-credit-card me-2 text-primary"></i>Order Langganan Terbaru</h6>
        <a href="<?= base_url('admin/subscriptions') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tenant</th><th>Paket</th><th>Jumlah</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_orders)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada order.</td></tr>
                    <?php else: ?>
                        <?php foreach (array_slice($recent_orders, 0, 10) as $order): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($order['tenant_name']) ?></td>
                                <td><?= esc($order['package_name']) ?> <small class="text-muted">(<?= $order['duration_days'] ?> hari)</small></td>
                                <td>Rp <?= number_format($order['amount'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($order['status'] === 'pending'): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php elseif ($order['status'] === 'verified'): ?>
                                        <span class="badge bg-success">Verified</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?= date('d/m/Y', strtotime($order['created_at'])) ?></small></td>
                                <td>
                                    <?php if ($order['status'] === 'pending'): ?>
                                        <a href="<?= base_url('admin/subscriptions') ?>" class="btn btn-xs btn-outline-success btn-sm py-0 px-2">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
