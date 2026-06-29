<?= $this->extend('layouts/owner') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-users me-2 text-success"></i>Kelola Kasir</h4>
    <a href="<?= base_url('owner/kasir/new') ?>" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> Tambah Kasir
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr><th>#</th><th>Nama</th><th>Email</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($kasirs as $i => $k): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($k['name']) ?></td>
                            <td><?= esc($k['email']) ?></td>
                            <td>
                                <?= $k['is_active']
                                    ? '<span class="badge bg-success">Aktif</span>'
                                    : '<span class="badge bg-secondary">Nonaktif</span>' ?>
                            </td>
                            <td>
                                <a href="<?= base_url('owner/kasir/' . $k['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning py-0 px-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('owner/kasir/' . $k['id'] . '/delete') ?>" method="post" class="d-inline"
                                      onsubmit="return confirm('Hapus akun kasir ini?')">
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
