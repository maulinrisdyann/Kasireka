<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasireka - Sistem Kasir Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f9ff;
            font-family: 'Segoe UI', sans-serif;
            color: #1a1a2e;
        }

        /* NAVBAR */
        .navbar {
            background:
                linear-gradient(135deg, #0d47a1, #0d6efd);
            padding: 15px;
        }

        .brand-box {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            background:
                rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-box i {
            color: white;
            font-size: 24px;
        }

        .navbar-brand {
            color: white !important;
            font-size: 25px;
            font-weight: 800;
        }

        /* BUTTON */
        .btn-login {
            background: white;
            color: #0d47a1;
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-register {
            background: #42a5f5;
            color: white;
            border-radius: 12px;
            font-weight: 600;
        }

        /* HERO */
        .hero {
            padding: 90px 0;
        }

        .hero h1 {
            font-size: 52px;
            font-weight: 800;
        }

        .hero p {
            font-size: 18px;
            line-height: 1.8;
            color: #6c757d;
        }

        .btn-start {
            padding: 14px 30px;
            border-radius: 15px;
            background:
                linear-gradient(135deg, #0d6efd, #0d47a1);
            color: white;
            font-weight: 600;
        }

        .hero-box {
            height: 380px;
            border-radius: 30px;
            overflow: hidden;
            box-shadow:
                0 25px 60px rgba(13, 110, 253, .3);
        }

        .hero-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* FEATURE */
        .section-title {
            font-weight: 800;
        }

        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 25px;
            height: 100%;
            box-shadow:
                0 15px 45px rgba(0, 0, 0, .08);
            transition: .35s;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow:
                0 25px 60px rgba(13, 110, 253, .25);
        }

        .feature-image {
            height: 220px;
            overflow: hidden;
            border-radius: 20px;
            margin-bottom: 25px;
        }

        .feature-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .5s;
        }

        .feature-card:hover img {
            transform: scale(1.15);
        }

        .feature-card h4 {
            font-weight: 750;
        }

        .feature-card p {
            color: #6c757d;
            line-height: 1.7;
        }

        .feature-link {
            text-decoration: none;
            color: #0d6efd;
            font-weight: 600;
        }

        /* CTA */
        .cta {
            margin: 80px 0;
            padding: 55px;
            border-radius: 30px;
            background:
                linear-gradient(135deg, #0d47a1, #0d6efd);
            color: white;
        }

        footer {
            background: #0d47a1;
            color: white;
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center">
                <div class="brand-box me-2">
                    <i class="fas fa-cash-register"></i>
                </div>
                Kasireka
            </a>
            <div>
                <a href="<?= base_url('login') ?>"
                    class="btn btn-login me-2">
                    Login
                </a>
                <a href="<?= base_url('register') ?>"
                    class="btn btn-register">
                    Daftar
                </a>
            </div>
        </div>
    </nav>
    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>
                        Kasir Digital
                        <br>
                        Untuk Bisnis Modern
                    </h1>
                    <p>
                        Kasireka membantu UMKM mengelola transaksi,
                        stok barang, laporan penjualan, dan karyawan
                        dalam satu aplikasi kasir cepat dan aman.
                    </p>
                    <a href="<?= base_url('register') ?>"
                        class="btn btn-start mt-3">
                        <i class="fas fa-rocket me-2"></i>
                        Mulai Sekarang
                    </a>
                </div>
                <div class="col-md-6 mt-5 mt-md-0">
                    <div class="hero-box">
                        <img src="
https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=900&q=80
">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FITUR -->
    <section class="container pb-5">
        <div class="text-center mb-5">
            <h2 class="section-title">
                Fitur Unggulan Kasireka
            </h2>
            <p class="text-muted">
                Semua kebutuhan bisnis dalam satu platform.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?q=80&w=735&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                    </div>
                    <h4>
                        Manajemen Produk
                    </h4>
                    <p>
                        Atur produk, harga, stok,
                        kategori, dan barcode dengan mudah
                        tanpa pencatatan manual.
                    </p>
                    <a href="<?= base_url('register') ?>"
                        class="feature-link">
                        Kelola Produk
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=1311&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                    </div>
                    <h4>
                        Laporan Bisnis
                    </h4>
                    <p>
                        Pantau transaksi harian,
                        mingguan, dan bulanan dengan
                        grafik yang mudah dipahami.
                    </p>
                    <a href="<?= base_url('register') ?>"
                        class="feature-link">
                        Lihat Laporan
                        <i class="fas fa-chart-line ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="https://plus.unsplash.com/premium_photo-1684225765349-072e1a35afc6?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                    </div>
                    <h4>
                        Multi User
                    </h4>
                    <p>
                        Kelola admin, owner,
                        dan kasir dengan hak akses
                        yang berbeda.
                    </p>
                    <a href="<?= base_url('register') ?>"
                        class="feature-link">
                        Buat Akun
                        <i class="fas fa-users ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA -->
    <div class="container">
        <div class="cta text-center">
            <h2>
                Siap Mengembangkan Bisnis?
            </h2>
            <p>
                Daftar sekarang dan nikmati
                kemudahan sistem kasir modern.
            </p>
            <a href="<?= base_url('register') ?>"
                class="btn btn-light">
                Daftar Gratis
            </a>
        </div>
    </div>
    <footer class="text-center">
        © <?= date('Y') ?> Kasireka
        <br>
        Sistem Kasir Multi Tenant
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>