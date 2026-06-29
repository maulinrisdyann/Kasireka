<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f4f6fb; }
        .barcode-card { max-width: 480px; margin: 3rem auto; }
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .barcode-card { box-shadow: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="barcode-card">
        <div class="card shadow">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between pt-3 px-4 no-print">
                <h5 class="mb-0 fw-bold"><i class="fas fa-barcode me-2 text-primary"></i>Barcode Produk</h5>
                <a href="<?= base_url('kasir/products') ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body text-center px-4 pb-4">
                <h5 class="fw-bold mb-1"><?= esc($product['name']) ?></h5>
                <p class="text-muted mb-3">Rp <?= number_format($product['price'], 0, ',', '.') ?> / <?= esc($product['unit']) ?></p>

                <div class="border rounded p-3 bg-white mb-3 d-inline-block">
                    <?= $barcodeSvg ?>
                </div>

                <p class="font-monospace text-muted small mb-4"><?= esc($product['barcode']) ?></p>

                <div class="d-flex gap-2 justify-content-center no-print">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i> Print Barcode
                    </button>
                    <a href="<?= base_url('kasir/products/' . $product['id'] . '/edit') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Edit Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
