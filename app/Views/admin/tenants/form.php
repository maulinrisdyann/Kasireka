<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('admin/tenants') ?>" class="btn btn-outline-secondary btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="mb-0 fw-bold"><?= $title ?></h4>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('admin/tenants/' . ($tenant ? $tenant['id'] . '/edit' : 'new')) ?>" method="post">
                    <?= csrf_field() ?>
                    <h6 class="fw-bold text-muted mb-3">Info Tenant</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Tenant <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?= old('name', $tenant['name'] ?? '') ?>" required
                                   oninput="autoSlug(this.value)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" value="<?= old('slug', $tenant['slug'] ?? '') ?>"
                                   required pattern="[a-z0-9-]+" placeholder="contoh-tenant">
                            <div class="form-text">Huruf kecil, angka, dan tanda minus saja.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email', $tenant['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" class="form-control" value="<?= old('phone', $tenant['phone'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="2"><?= old('address', $tenant['address'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Langganan Aktif Hingga</label>
                            <input type="datetime-local" name="subscription_expires_at" class="form-control"
                                   value="<?= old('subscription_expires_at', isset($tenant['subscription_expires_at']) ? date('Y-m-d\TH:i', strtotime($tenant['subscription_expires_at'])) : '') ?>">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                       <?= old('is_active', $tenant['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">Tenant Aktif</label>
                            </div>
                        </div>
                    </div>

                    <?php if (!$tenant): ?>
                        <hr>
                        <h6 class="fw-bold text-muted mb-3">Buat Akun Owner (Opsional)</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Nama Owner</label>
                                <input type="text" name="owner_name" class="form-control" value="<?= old('owner_name') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email Owner</label>
                                <input type="email" name="owner_email" class="form-control" value="<?= old('owner_email') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="owner_password" class="form-control">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i><?= $tenant ? 'Perbarui' : 'Simpan' ?>
                        </button>
                        <a href="<?= base_url('admin/tenants') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
function autoSlug(val) {
    const slugEl = document.getElementById('slug');
    if (!slugEl.dataset.manual) {
        slugEl.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    }
}
document.getElementById('slug').addEventListener('input', function () {
    this.dataset.manual = '1';
});
</script>
<?= $this->endSection() ?>
