<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header text-white" style="background: #9c27b0;">
        <h5 class="mb-0">Ubah Password</h5>
    </div>

    <div class="card-body">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="old_password" class="form-label">Password Lama</label>
                <div class="input-group">
                    <input type="password"
                        id="old_password"
                        name="old_password"
                        class="form-control"
                        required>
                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        onclick="togglePassword('old_password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <div class="input-group">
                    <input type="password"
                        id="new_password"
                        name="new_password"
                        class="form-control"
                        required>
                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        onclick="togglePassword('new_password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password"
                        id="confirm_password"
                        name="confirm_password"
                        class="form-control"
                        required>
                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        onclick="togglePassword('confirm_password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button class="btn" style="background: #9c27b0; border-color: #9c27b0; color: white;">
                Simpan Password
            </button>

        </form>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;

        const icon = btn.querySelector('i');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        if (icon) {
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    }
</script>
<?= $this->endSection() ?>
