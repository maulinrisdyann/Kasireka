<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Kasireka</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d47a1 0%, #0d6efd 50%, #42a5f5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        }
        .register-brand {
            text-align: center;
            padding: 2rem 2rem .5rem;
        }
        .register-brand .icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #0d6efd, #0d47a1);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .75rem;
        }
        .register-brand .icon i {
            color: #fff;
            font-size: 1.75rem;
        }
        .register-brand h4 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
        .register-brand p {
            color: #6c757d;
            font-size: .88rem;
        }
        .card-body {
            padding: 1.5rem 2rem 2rem;
        }
        .form-control {
            border-radius: 10px;
            padding: .65rem 1rem;
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
        }
        .btn-register {
            background: linear-gradient(135deg, #0d6efd, #0d47a1);
            border: none;
            border-radius: 10px;
            padding: .65rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="card register-card">
        <div class="register-brand">
            <div class="icon">
                <i class="fas fa-cash-register"></i>
            </div>
            <h4>Kasireka</h4>
            <p>Sistem Kasir Multi-Tenant</p>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger py-2">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('register') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Pemilik
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-user text-muted"></i>
                        </span>
                        <input
                            class="form-control"
                            name="name"
                            placeholder="Nama pemilik"
                            required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Toko
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-store text-muted"></i>
                        </span>
                        <input
                            class="form-control"
                            name="tenant"
                            placeholder="Nama toko"
                            required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Email
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-envelope text-muted"></i>
                        </span>
                        <input
                            class="form-control"
                            name="email"
                            type="email"
                            placeholder="email@contoh.com"
                            required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Password
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input
                            id="register_password"
                            class="form-control"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('register_password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-register btn-primary w-100">
                    <i class="fas fa-user-plus me-2"></i>
                    Daftar
                </button>
                <div class="text-center mt-3">
                    Sudah punya akun?
                    <a href="<?= base_url('login') ?>" class="fw-semibold text-decoration-none">
                        Login
                    </a>
                </div>
                <div class="text-center mt-2">
                    <a href="<?= base_url('/') ?>"
                        class="text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke halaman utama
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>