<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <!-- FOTO PROFIL -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <?php
                    if ($user['profile_photo']) {
                        $photo = base_url('uploads/profiles/' . $user['profile_photo']);
                    } else {
                        $photo = 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) . '&background=0d6efd&color=fff&size=220';
                    }
                    ?>
                    <img
                        src="<?= $photo ?>"
                        class="rounded-circle border border-3 border-primary mb-3"
                        width="180"
                        height="180"
                        style="object-fit:cover;">
                    <h4><?= esc($user['name']) ?></h4>
                    <p class="text-muted">
                        <?= esc($user['email']) ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- FORM EDIT -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        Edit Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form
                        action="<?= base_url('admin/profile/update') ?>"
                        method="post"
                        enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">
                                Nama
                            </label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?= esc($user['name']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= esc($user['email']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Nomor HP
                            </label>
                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                value="<?= esc($user['phone']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Alamat
                            </label>
                            <textarea
                                class="form-control"
                                rows="3"
                                name="address"><?= esc($user['address']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Foto Profil
                            </label>
                            <input
                                type="file"
                                name="profile_photo"
                                class="form-control">
                            <small class="text-muted">
                                JPG / PNG maksimal 2 MB
                            </small>
                        </div>
                        <button class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>