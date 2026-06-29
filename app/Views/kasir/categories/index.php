<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-tags me-2" style="color:#9c27b0"></i>Kategori Produk</h4>
    <a href="<?= base_url('kasir/categories/new') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead><tr><th>#</th><th>Nama Kategori</th><th>Dibuat</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php foreach ($categories as $i => $c): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($c['name']) ?></td>
                            <td><small><?= date('d/m/Y', strtotime($c['created_at'])) ?></small></td>
                            <td>
                                <a href="<?= base_url('kasir/categories/' . $c['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning py-0 px-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('kasir/categories/' . $c['id'] . '/delete') ?>" method="post" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini?')">
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
