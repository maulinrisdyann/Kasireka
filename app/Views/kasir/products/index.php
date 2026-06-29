<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-box me-2" style="color:#9c27b0"></i>Produk</h4>
    <a href="<?= base_url('kasir/products/new') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr><th>#</th><th>Nama</th><th>Kategori</th><th>Barcode</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($p['name']) ?></td>
                            <td><?= esc($p['category_name'] ?? '—') ?></td>
                            <td><code class="small"><?= esc($p['barcode'] ?? '—') ?></code></td>
                            <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                            <td>
                                <?php
                                $stockClass = 'bg-success';
                                if ($p['stock'] == 0) $stockClass = 'bg-danger';
                                elseif ($p['stock'] <= $p['stock_alert']) $stockClass = 'bg-warning text-dark';
                                ?>
                                <span class="badge <?= $stockClass ?>"><?= $p['stock'] ?> <?= esc($p['unit']) ?></span>
                            </td>
                            <td><?= $p['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' ?></td>
                            <td>
                                <a href="<?= base_url('kasir/products/' . $p['id'] . '/barcode') ?>" class="btn btn-sm btn-outline-info py-0 px-2" title="Barcode">
                                    <i class="fas fa-barcode"></i>
                                </a>
                                <a href="<?= base_url('kasir/products/' . $p['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning py-0 px-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('kasir/products/' . $p['id'] . '/delete') ?>" method="post" class="d-inline"
                                      onsubmit="return confirm('Hapus produk ini?')">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
