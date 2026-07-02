<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h4 class="fw-bold mb-4">
    <i class="fas fa-wallet text-primary"></i>
    Rekening Pembayaran
</h4>
<div class="card">
    <div class="card-body">
        <form method="post"
            action="<?= base_url('admin/payment-account/store') ?>">
            <div class="row">
                <div class="col-md-3">
                    <label>Jenis</label>
                    <select name="type" class="form-control">
                        <option>Bank</option>
                        <option>E-Wallet</option>
                        <option>QRIS</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Nama</label>
                    <input
                        name="account_name"
                        class="form-control"
                        placeholder="BCA / Dana">
                </div>
                <div class="col-md-3">
                    <label>Nomor</label>
                    <input
                        name="account_number"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Pemilik</label>
                    <input
                        name="holder_name"
                        class="form-control">
                </div>
            </div>
            <button class="btn btn-primary mt-3">
                Tambah Rekening
            </button>
        </form>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Nama</th>
                    <th>Nomor</th>
                    <th>Pemilik</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $a): ?>
                    <tr>
                        <td><?= $a['type'] ?></td>
                        <td><?= $a['account_name'] ?></td>
                        <td><?= $a['account_number'] ?></td>
                        <td><?= $a['holder_name'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>