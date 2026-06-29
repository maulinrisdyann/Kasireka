<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('kasir/products') ?>" class="btn btn-outline-secondary btn-sm me-3"><i class="fas fa-arrow-left"></i></a>
    <h4 class="mb-0 fw-bold"><?= $title ?></h4>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="row"><div class="col-lg-8">
<div class="card"><div class="card-body">
    <form action="<?= base_url('kasir/products/' . ($product ? $product['id'] . '/edit' : 'new')) ?>" method="post">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $product['name'] ?? '') ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="">— Tanpa Kategori —</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= old('category_id', $product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Barcode</label>
                <input type="text" name="barcode" class="form-control" value="<?= old('barcode', $product['barcode'] ?? '') ?>"
                       placeholder="Kosongkan untuk generate otomatis">
                <div class="form-text">Format otomatis: [tenant]-[id]-[timestamp]</div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Satuan</label>
                <input type="text" name="unit" class="form-control" value="<?= old('unit', $product['unit'] ?? 'pcs') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="<?= old('price', $product['price'] ?? '') ?>" min="0" step="100" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control" value="<?= old('stock', $product['stock'] ?? 0) ?>" min="0" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Alert Stok (Min)</label>
                <input type="number" name="stock_alert" class="form-control" value="<?= old('stock_alert', $product['stock_alert'] ?? 5) ?>" min="0">
                <div class="form-text">Notifikasi jika stok ≤ nilai ini</div>
            </div>
            <?php if ($product): ?>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                           <?= old('is_active', $product['is_active'] ?? 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="isActive">Produk Aktif</label>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <hr class="my-4">
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $product ? 'Perbarui' : 'Simpan' ?></button>
            <a href="<?= base_url('kasir/products') ?>" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div></div>
</div></div>

<?= $this->endSection() ?>
