<?= $this->extend('layouts/owner') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-boxes me-2 text-success"></i>Laporan Stok</h4>
    <a href="<?= base_url('owner/report/stock/export') ?>" class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf me-1"></i> Export PDF
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead class="table-light">
                    <tr><th>#</th><th>Nama Produk</th><th>Kategori</th><th>Stok</th><th>Alert</th><th>Satuan</th><th>Harga</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $i => $p): ?>
                        <?php
                        if ($p['stock'] == 0) { $status = '<span class="badge bg-danger">Habis</span>'; }
                        elseif ($p['stock'] <= $p['stock_alert']) { $status = '<span class="badge bg-warning text-dark">Menipis</span>'; }
                        else { $status = '<span class="badge bg-success">Aman</span>'; }
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($p['name']) ?></td>
                            <td><?= esc($p['category_name'] ?? '—') ?></td>
                            <td><strong class="<?= $p['stock'] == 0 ? 'text-danger' : ($p['stock'] <= $p['stock_alert'] ? 'text-warning' : 'text-success') ?>"><?= $p['stock'] ?></strong></td>
                            <td><?= $p['stock_alert'] ?></td>
                            <td><?= esc($p['unit']) ?></td>
                            <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                            <td><?= $status ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
