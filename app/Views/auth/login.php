<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Kasireka</title>
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

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        }

        .login-brand {
            text-align: center;
            padding: 2rem 2rem .5rem;
        }

        .login-brand .icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #0d6efd, #0d47a1);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .75rem;
        }

        .login-brand .icon i {
            color: #fff;
            font-size: 1.75rem;
        }

        .login-brand h4 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }

        .login-brand p {
            color: #6c757d;
            font-size: .88rem;
        }

        .card-body {
            padding: 1.5rem 2rem 2rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #0d6efd, #0d47a1);
            border: none;
            border-radius: 10px;
            padding: .65rem;
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: .6rem 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .2);
        }
    </style>
</head>

<body>
    <div class="card login-card">
        <div class="login-brand">
            <div class="icon"><i class="fas fa-cash-register"></i></div>
            <h4>Kasireka</h4>
            <p>Sistem Kasir Multi-Tenant</p>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-sm py-2">
                    <i class="fas fa-exclamation-circle me-1"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-sm py-2">
                    <i class="fas fa-check-circle me-1"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-sm">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0"
                            placeholder="email@contoh.com" value="<?= old('email') ?>" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-sm">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0"
                            placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-login btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
                <div class="text-center mt-3">

                    Belum punya akun?

                    <a href="<?= base_url('register') ?>" class="fw-semibold text-decoration-none">
                        Tambah Akun
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
</body>

</html>