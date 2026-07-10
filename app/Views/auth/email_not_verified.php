<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Gagal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-danger text-center">
            <h3>Link verifikasi tidak valid.</h3>
            <p>Silakan meminta link verifikasi baru.</p>
            <a
                href="<?= base_url('login') ?>"
                class="btn btn-danger">
                Kembali
            </a>
        </div>
    </div>
</body>
</html>