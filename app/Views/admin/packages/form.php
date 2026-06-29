<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('admin/packages') ?>" class="btn btn-outline-secondary btn-sm me-3"><i class="fas fa-arrow-left"></i></a>
    <h4 class="mb-0 fw-bold"><?= $title ?></h4>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="row"><div class="col-lg-6">
<div class="card"><div class="card-body">
    <form action="<?= base_url('admin/packages/' . ($package ? $package['id'] . '/edit' : 'new')) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Nama Paket <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="<?= old('name', $package['name'] ?? '') ?>" required>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-6">
                <label class="form-label">Durasi (hari) <span class="text-danger">*</span></label>
                <input type="number" name="duration_days" class="form-control" value="<?= old('duration_days', $package['duration_days'] ?? '') ?>" min="1" required>
            </div>
            <div class="col-6">
                <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="<?= old('price', $package['price'] ?? '') ?>" min="0" step="100" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="2"><?= old('description', $package['description'] ?? '') ?></textarea>
        </div>
        <div class="form-check form-switch mb-4">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                   <?= old('is_active', $package['is_active'] ?? 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="isActive">Paket Aktif</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $package ? 'Perbarui' : 'Simpan' ?></button>
            <a href="<?= base_url('admin/packages') ?>" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div></div>
</div></div>

<?= $this->endSection() ?>
