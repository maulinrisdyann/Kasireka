<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Lupa Password</h4>
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
                        <form action="<?= base_url('forgot-password') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label>Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    required>
                            </div>
                            <button class="btn btn-primary w-100">
                                Kirim Link Reset Password
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="<?= base_url('login') ?>">
                                Kembali Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>