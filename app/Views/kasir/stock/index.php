<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-warehouse me-2" style="color:#9c27b0"></i>Monitoring Stok</h4>
    <a href="<?= base_url('kasir/products/new') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Produk
    </a>
</div>

<!-- Legend -->
<div class="d-flex gap-2 mb-3 flex-wrap">
    <span class="badge bg-success fs-7 py-2 px-3"><i class="fas fa-circle me-1"></i> Stok Aman</span>
    <span class="badge bg-warning text-dark fs-7 py-2 px-3"><i class="fas fa-circle me-1"></i> Stok Menipis</span>
    <span class="badge bg-danger fs-7 py-2 px-3"><i class="fas fa-circle me-1"></i> Stok Habis</span>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead class="table-light">
                    <tr><th>#</th><th>Nama Produk</th><th>Kategori</th><th>Stok</th><th>Batas Alert</th><th>Satuan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $i => $p): ?>
                        <?php
                        if ($p['stock'] == 0) { $rowClass = 'table-danger'; $status = '<span class="badge bg-danger">Habis</span>'; }
                        elseif ($p['stock'] <= $p['stock_alert']) { $rowClass = 'table-warning'; $status = '<span class="badge bg-warning text-dark">Menipis</span>'; }
                        else { $rowClass = ''; $status = '<span class="badge bg-success">Aman</span>'; }
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($p['name']) ?></td>
                            <td><?= esc($p['category_name'] ?? '—') ?></td>
                            <td>
                                <strong class="<?= $p['stock'] == 0 ? 'text-danger' : ($p['stock'] <= $p['stock_alert'] ? 'text-warning' : 'text-success') ?>">
                                    <?= $p['stock'] ?>
                                </strong>
                            </td>
                            <td><?= $p['stock_alert'] ?></td>
                            <td><?= esc($p['unit']) ?></td>
                            <td><?= $status ?></td>
                            <td>
                                <a href="<?= base_url('kasir/products/' . $p['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning py-0 px-2">
                                    <i class="fas fa-edit"></i> Update Stok
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
