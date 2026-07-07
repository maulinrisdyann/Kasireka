<?= $this->extend('layouts/owner') ?>
<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="fas fa-user-circle text-success me-2"></i>
            Profil Saya
        </h4>
        <small class="text-muted">
            Kelola informasi akun dan foto profil Anda.
        </small>
    </div>
</div>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <i class="fas fa-times-circle me-2"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<div class="row">
    <!-- FOTO PROFIL -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <?php
                if (!empty($user['profile_photo'])) {
                    $photo = base_url('uploads/profiles/' . $user['profile_photo']);
                } else {
                    $photo = 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) . '&background=0d6efd&color=fff&size=220';
                }
                ?>
                <img
                    id="preview"
                    src="<?= $photo ?>"
                    class="rounded-circle border border-3 border-success shadow"
                    width="180"
                    height="180"
                    style="object-fit:cover;">
                <h4 class="mt-3 fw-bold">
                    <?= esc($user['name']) ?>
                </h4>
                <p class="text-muted mb-1">
                    <?= esc($user['email']) ?>
                </p>
                <span class="badge bg-success">
                    Owner
                </span>
            </div>
        </div>
    </div>
    <!-- FORM -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Profil
                </h5>
            </div>
            <div class="card-body">
                <form
                    action="<?= base_url('owner/profile/update') ?>"
                    method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="<?= esc($user['name']) ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= esc($user['email']) ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nomor HP
                        </label>
                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="<?= esc($user['phone']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Alamat
                        </label>
                        <textarea
                            name="address"
                            rows="4"
                            class="form-control"><?= esc($user['address']) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Foto Profil
                        </label>
                        <input
                            type="file"
                            class="form-control"
                            name="profile_photo"
                            accept=".jpg,.jpeg,.png"
                            onchange="previewImage(event)">
                        <div class="form-text">
                            Format JPG/PNG maksimal 2 MB.
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success">
                            <i class="fas fa-save me-2"></i>
                            Simpan Perubahan
                        </button>
                        <a
                            href="<?= base_url('owner/dashboard') ?>"
                            class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<?= $this->endSection() ?>