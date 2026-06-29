<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-store me-2 text-primary"></i>Kelola Tenant</h4>
    <a href="<?= base_url('admin/tenants/new') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Tenant
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr><th>#</th><th>Nama</th><th>Slug</th><th>Email</th><th>Status</th><th>Langganan Aktif Hingga</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($tenants as $i => $t): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($t['name']) ?></td>
                            <td><code><?= esc($t['slug']) ?></code></td>
                            <td><?= esc($t['email']) ?></td>
                            <td>
                                <?= $t['is_active']
                                    ? '<span class="badge bg-success">Aktif</span>'
                                    : '<span class="badge bg-secondary">Nonaktif</span>' ?>
                            </td>
                            <td>
                                <?php if ($t['subscription_expires_at']): ?>
                                    <?php $expired = strtotime($t['subscription_expires_at']) < time(); ?>
                                    <span class="<?= $expired ? 'text-danger' : 'text-success' ?>">
                                        <?= date('d/m/Y H:i', strtotime($t['subscription_expires_at'])) ?>
                                        <?= $expired ? ' <span class="badge bg-danger ms-1">Expired</span>' : '' ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/tenants/' . $t['id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning py-0 px-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('admin/tenants/' . $t['id'] . '/delete') ?>" method="post" class="d-inline"
                                      onsubmit="return confirm('Hapus tenant ini?')">
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
