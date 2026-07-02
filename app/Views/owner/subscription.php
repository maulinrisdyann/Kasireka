<?= $this->extend('layouts/owner') ?>
<?= $this->section('content') ?>
<h4 class="mb-4 fw-bold"><i class="fas fa-credit-card me-2 text-success"></i>Langganan</h4>
<!-- Info Langganan Saat Ini -->
<div class="card mb-4" style="border-left:4px solid <?= $tenant['subscription_expires_at'] && strtotime($tenant['subscription_expires_at']) > time() ? '#198754' : '#dc3545' ?>">
    <div class="card-body">
        <h6 class="fw-bold mb-2">Status Langganan</h6>
        <?php if ($tenant['subscription_expires_at'] && strtotime($tenant['subscription_expires_at']) > time()): ?>
            <p class="mb-0 text-success fw-semibold">
                <i class="fas fa-check-circle me-2"></i>
                Aktif hingga <strong><?= date('d F Y', strtotime($tenant['subscription_expires_at'])) ?></strong>
                (<?= ceil((strtotime($tenant['subscription_expires_at']) - time()) / 86400) ?> hari lagi)
            </p>
        <?php else: ?>
            <p class="mb-0 text-danger fw-semibold">
                <i class="fas fa-exclamation-circle me-2"></i>
                Langganan sudah habis atau belum diaktifkan.
            </p>
        <?php endif; ?>
    </div>
</div>
<div class="row g-4">
    <!-- Form Order Langganan -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Order Paket Baru</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('owner/subscription/order') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Paket</label>
                        <?php foreach ($packages as $pkg): ?>
                            <div class="card mb-2 border-2 package-option" style="cursor:pointer" onclick="selectPkg(<?= $pkg['id'] ?>)">
                                <div class="card-body py-2 d-flex align-items-center justify-content-between">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="package_id" id="pkg<?= $pkg['id'] ?>" value="<?= $pkg['id'] ?>" required>
                                        <label class="form-check-label fw-semibold" for="pkg<?= $pkg['id'] ?>">
                                            <?= esc($pkg['name']) ?>
                                            <small class="text-muted">(<?= $pkg['duration_days'] ?> hari)</small>
                                        </label>
                                    </div>
                                    <span class="badge bg-primary fs-6">Rp <?= number_format($pkg['price'], 0, ',', '.') ?></span>
                                </div>
                                <?php if ($pkg['description']): ?>
                                    <div class="card-footer bg-light py-1"><small class="text-muted"><?= esc($pkg['description']) ?></small></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Transfer Ke
                        </label>
                        <select name="payment_account"
                            class="form-select"
                            required>
                            <option value="">
                                -- Pilih Rekening --
                            </option>
                            <?php foreach ($payment_accounts as $acc): ?>
                                <option value="<?= $acc['id'] ?>">
                                    <?= esc($acc['type']) ?>
                                    -
                                    <?= esc($acc['account_name']) ?>
                                    (
                                    <?= esc($acc['account_number']) ?>
                                    )
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Bukti Transfer</label>
                        <input type="file" name="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        <div class="form-text">Format: JPG, PNG, PDF. Maks 2MB.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Order Langganan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Riwayat Order -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Riwayat Order</h6>
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <p class="text-muted text-center py-4">Belum ada riwayat order.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Paket</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $o): ?>
                                    <tr>
                                        <td><?= esc($o['package_name']) ?> <small class="text-muted">(<?= $o['duration_days'] ?>h)</small></td>
                                        <td>Rp <?= number_format($o['amount'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($o['status'] === 'pending'): ?><span class="badge bg-warning text-dark">Pending</span>
                                            <?php elseif ($o['status'] === 'verified'): ?><span class="badge bg-success">Verified</span>
                                            <?php else: ?><span class="badge bg-danger">Rejected</span><?php endif; ?>
                                        </td>
                                        <td><small><?= date('d/m/Y', strtotime($o['created_at'])) ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    function selectPkg(id) {
        document.getElementById('pkg' + id).checked = true;
    }
</script>
<?= $this->endSection() ?>