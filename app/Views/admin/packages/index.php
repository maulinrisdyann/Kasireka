<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-box me-2 text-primary"></i>Paket Langganan</h4>
    <a href="<?= base_url('admin/packages/new') ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Paket</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr><th>#</th><th>Nama</th><th>Durasi</th><th>Harga</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($packages as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($p['name']) ?></td>
                            <td><?= $p['duration_days'] ?> hari</td>
                            <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                            <td><?= esc($p['description'] ?? '—') ?></td>
                            <td><?= $p['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' ?></td>
                            <td>
                                <a href="<?= base_url('admin/packages/' . $p['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning py-0 px-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('admin/packages/' . $p['id'] . '/delete') ?>" method="post" class="d-inline"
                                      onsubmit="return confirm('Hapus paket ini?')">
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
