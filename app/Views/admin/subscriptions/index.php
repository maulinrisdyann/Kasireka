<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-credit-card me-2 text-primary"></i>Order Langganan</h4>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Tolak Order</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="rejectForm" method="post">
            <?= csrf_field() ?>
            <div class="modal-body">
                <label class="form-label">Alasan Penolakan</label>
                <textarea name="notes" class="form-control" rows="3" required placeholder="Masukkan alasan penolakan..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-times me-1"></i>Tolak Order</button>
            </div>
        </form>
    </div></div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr><th>#</th><th>Tenant</th><th>Paket</th><th>Jumlah</th><th>Bukti</th><th>Status</th><th>Diproses</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $i => $o): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($o['tenant_name']) ?></td>
                            <td><?= esc($o['package_name']) ?> <small class="text-muted">(<?= $o['duration_days'] ?>h)</small></td>
                            <td>Rp <?= number_format($o['amount'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($o['payment_proof']): ?>
                                    <a href="<?= base_url('admin/subscriptions/' . $o['id'] . '/proof') ?>" target="_blank" class="btn btn-xs btn-outline-info btn-sm py-0 px-2">
                                        <i class="fas fa-file-image"></i> Lihat
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($o['status'] === 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php elseif ($o['status'] === 'verified'): ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php else: ?>
                                    <span class="badge bg-danger" title="<?= esc($o['notes'] ?? '') ?>">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td><small><?= $o['verified_by_name'] ? esc($o['verified_by_name']) : '—' ?></small></td>
                            <td><small><?= date('d/m/Y', strtotime($o['created_at'])) ?></small></td>
                            <td>
                                <?php if ($o['status'] === 'pending'): ?>
                                    <form action="<?= base_url('admin/subscriptions/' . $o['id'] . '/verify') ?>" method="post" class="d-inline"
                                          onsubmit="return confirm('Verifikasi order ini? Langganan tenant akan diperpanjang.')">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-sm btn-success py-0 px-2"><i class="fas fa-check"></i></button>
                                    </form>
                                    <button class="btn btn-sm btn-danger py-0 px-2 ms-1"
                                            onclick="openReject(<?= $o['id'] ?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
function openReject(id) {
    document.getElementById('rejectForm').action = '<?= base_url('admin/subscriptions/') ?>' + id + '/reject';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
<?= $this->endSection() ?>
