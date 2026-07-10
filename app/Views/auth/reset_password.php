<?php /** @var string $token */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('reset-password') ?>" method="post">
                            <?= csrf_field() ?>
                            <input
                                type="hidden"
                                name="token"
                                value="<?= $token ?>">
                            <div class="mb-3">
                                <label>Password Baru</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Konfirmasi Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="confirm_password"
                                    required>
                            </div>
                            <button class="btn btn-success w-100">
                                Simpan Password Baru
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>