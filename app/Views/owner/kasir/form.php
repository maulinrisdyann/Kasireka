<?= $this->extend('layouts/owner') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('owner/kasir') ?>" class="btn btn-outline-secondary btn-sm me-3">
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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('owner/kasir/' . ($kasir ? $kasir['id'] . '/edit' : 'new')) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= old('name', $kasir['name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $kasir['email'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <?= $kasir ? '<small class="text-muted">(kosongkan jika tidak diubah)</small>' : '<span class="text-danger">*</span>' ?></label>
                        <input type="password" name="password" class="form-control" <?= !$kasir ? 'required' : '' ?> minlength="6">
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                   <?= old('is_active', $kasir['is_active'] ?? 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">Akun Aktif</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i><?= $kasir ? 'Perbarui' : 'Simpan' ?>
                        </button>
                        <a href="<?= base_url('owner/kasir') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
