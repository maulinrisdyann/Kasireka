<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Email Berhasil Diverifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h3>Email berhasil diverifikasi.</h3>
            <p>Sekarang Anda dapat login ke Kasireka.</p>
            <a
                href="<?= base_url('login') ?>"
                class="btn btn-success">
                Login
            </a>
        </div>
    </div>
</body>
</html>