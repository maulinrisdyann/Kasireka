<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('kasir/categories') ?>" class="btn btn-outline-secondary btn-sm me-3"><i class="fas fa-arrow-left"></i></a>
    <h4 class="mb-0 fw-bold"><?= $title ?></h4>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="row"><div class="col-lg-5">
<div class="card"><div class="card-body">
    <form action="<?= base_url('kasir/categories/' . ($category ? $category['id'] . '/edit' : 'new')) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="<?= old('name', $category['name'] ?? '') ?>" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $category ? 'Perbarui' : 'Simpan' ?></button>
            <a href="<?= base_url('kasir/categories') ?>" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div></div>
</div></div>

<?= $this->endSection() ?>
