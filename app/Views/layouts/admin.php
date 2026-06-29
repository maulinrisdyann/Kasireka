<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> — Kasireka</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <style>
        body { background: #f4f6fb; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #0d47a1 0%, #0d6efd 100%);
            width: 260px;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar .brand {
            padding: 1.5rem 1.25rem 1rem;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.85);
            padding: .6rem 1.25rem;
            border-radius: 8px;
            margin: 2px 8px;
            font-size: .92rem;
            transition: background .2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,.18);
            color: #fff;
        }
        .sidebar .nav-link i { width: 22px; }
        .sidebar .nav-section {
            color: rgba(255,255,255,.5);
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .75rem 1.25rem .25rem;
        }
        .main-content { margin-left: 260px; min-height: 100vh; transition: all .3s; }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e9f2;
            padding: .75rem 1.5rem;
            position: sticky; top: 0; z-index: 900;
        }
        .page-content { padding: 1.5rem; }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,.06); border-radius: 12px; }
        .stat-card { border-radius: 12px; color: #fff; }
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-260px); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="brand">
        <i class="fas fa-cash-register me-2"></i>Kasireka
        <small class="d-block text-white-50 fs-7">Admin Panel</small>
    </div>
    <nav class="pt-2">
        <div class="nav-section">Utama</div>
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= uri_string() === 'admin/dashboard' ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <div class="nav-section">Manajemen</div>
        <a href="<?= base_url('admin/tenants') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/tenants') ? 'active' : '' ?>">
            <i class="fas fa-store me-2"></i> Tenant
        </a>
        <a href="<?= base_url('admin/packages') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/packages') ? 'active' : '' ?>">
            <i class="fas fa-box me-2"></i> Paket Langganan
        </a>
        <a href="<?= base_url('admin/subscriptions') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/subscriptions') ? 'active' : '' ?>">
            <i class="fas fa-credit-card me-2"></i> Order Langganan
        </a>
        <div class="nav-section">Akun</div>
        <a href="<?= base_url('logout') ?>" class="nav-link">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="topbar d-flex align-items-center justify-content-between">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="badge bg-danger">Admin</span>
            <span class="fw-semibold"><?= esc(session('name')) ?></span>
        </div>
    </div>
    <div class="page-content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.getElementById('toggleSidebar')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('show');
    });
    $(document).ready(function () {
        if ($('.datatable').length) {
            $('.datatable').DataTable({
                language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' }
            });
        }
    });
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
