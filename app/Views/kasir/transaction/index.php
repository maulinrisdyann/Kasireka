<?= $this->extend('layouts/kasir') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0 fw-bold"><i class="fas fa-cash-register me-2" style="color:#9c27b0"></i>Kasir POS</h4>
    <a href="<?= base_url('kasir/transaction/history') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-history me-1"></i> Riwayat
    </a>
</div>

<div class="row g-3">
    <!-- Panel Kiri: Cari Produk -->
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchProduct" class="form-control form-control-lg"
                           placeholder="Scan barcode atau ketik nama produk...">
                </div>
                <div id="searchResults" class="list-group mt-2" style="display:none"></div>
            </div>
        </div>

        <!-- Keranjang -->
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-shopping-cart me-2 text-primary"></i>Keranjang</h6>
            </div>
            <div class="card-body pt-0">
                <div id="cartEmpty" class="text-center text-muted py-5">
                    <i class="fas fa-shopping-cart fs-1 mb-3 opacity-25"></i>
                    <p>Belum ada produk. Scan barcode atau cari produk.</p>
                </div>
                <div class="table-responsive" id="cartTableWrap" style="display:none">
                    <table class="table align-middle mb-0" id="cartTable">
                        <thead class="table-light">
                            <tr><th>Produk</th><th>Harga</th><th style="width:130px">Qty</th><th>Subtotal</th><th></th></tr>
                        </thead>
                        <tbody id="cartBody"></tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Total</td>
                                <td id="cartTotal">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Kanan: Pembayaran -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-wallet me-2 text-success"></i>Pembayaran</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="payCash" value="cash" checked>
                            <label class="form-check-label" for="payCash"><i class="fas fa-money-bill me-1"></i>Tunai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="payTransfer" value="transfer">
                            <label class="form-check-label" for="payTransfer"><i class="fas fa-university me-1"></i>Transfer</label>
                        </div>
                    </div>
                </div>

                <div class="bg-light rounded p-3 mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Belanja</span>
                        <span class="fw-bold fs-5" id="summaryTotal">Rp 0</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Uang Diterima (Rp)</label>
                    <input type="number" id="paymentAmount" class="form-control form-control-lg text-end" placeholder="0" min="0" step="1000">
                    <div class="d-flex gap-2 mt-2 flex-wrap" id="quickCash">
                        <button class="btn btn-outline-secondary btn-sm quick-cash" data-val="5000">5rb</button>
                        <button class="btn btn-outline-secondary btn-sm quick-cash" data-val="10000">10rb</button>
                        <button class="btn btn-outline-secondary btn-sm quick-cash" data-val="20000">20rb</button>
                        <button class="btn btn-outline-secondary btn-sm quick-cash" data-val="50000">50rb</button>
                        <button class="btn btn-outline-secondary btn-sm quick-cash" data-val="100000">100rb</button>
                        <button class="btn btn-outline-primary btn-sm" id="exactPayBtn">Pas</button>
                    </div>
                </div>

                <div class="bg-primary bg-opacity-10 rounded p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold text-primary">Kembalian</span>
                        <span class="fw-bold fs-4 text-primary" id="changeAmount">Rp 0</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <input type="text" id="transNote" class="form-control" placeholder="Catatan transaksi...">
                </div>

                <button id="btnProcess" class="btn btn-success btn-lg w-100 fw-bold" disabled>
                    <i class="fas fa-check-circle me-2"></i>Proses Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="text-success mb-3"><i class="fas fa-check-circle" style="font-size:4rem"></i></div>
                <h4 class="fw-bold mb-1">Transaksi Berhasil!</h4>
                <p class="text-muted" id="modalInvoice"></p>
                <div class="bg-light rounded p-3 mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total</span><span class="fw-bold" id="modalTotal"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Bayar</span><span id="modalPay"></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Kembalian</span><span class="fw-bold text-primary" id="modalChange"></span>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <a id="btnPrint" href="#" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-print me-1"></i>Cetak Struk
                    </a>
                    <button class="btn btn-success" onclick="resetPOS()">
                        <i class="fas fa-plus-circle me-1"></i>Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
const BASE_URL  = '<?= base_url() ?>';
const CSRF_TOKEN = '<?= csrf_hash() ?>';
const CSRF_NAME  = '<?= csrf_token() ?>';

let cart     = [];
let debounce = null;

// ---- Search ----
document.getElementById('searchProduct').addEventListener('input', function () {
    clearTimeout(debounce);
    const q = this.value.trim();
    if (q.length < 2) { hideResults(); return; }
    debounce = setTimeout(() => searchProducts(q), 300);
});

document.getElementById('searchProduct').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        clearTimeout(debounce);
        searchProducts(this.value.trim(), true);
    }
});

function searchProducts(q, exact = false) {
    fetch(`${BASE_URL}kasir/products/search?q=${encodeURIComponent(q)}`)
        .then(r => r.json())
        .then(data => {
            if (exact && data.length === 1) {
                addToCart(data[0]);
                document.getElementById('searchProduct').value = '';
                hideResults();
                return;
            }
            renderResults(data);
        });
}

function renderResults(products) {
    const el = document.getElementById('searchResults');
    if (!products.length) { el.innerHTML = '<div class="list-group-item text-muted small">Tidak ditemukan.</div>'; el.style.display = 'block'; return; }
    el.innerHTML = products.map(p =>
        `<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                 onclick="addToCart(${JSON.stringify(p).replace(/"/g,'&quot;')})">
            <span><strong>${p.name}</strong><br><small class="text-muted">${p.barcode ?? ''}</small></span>
            <span class="badge bg-primary rounded-pill">Rp ${numFmt(p.price)}</span>
        </button>`
    ).join('');
    el.style.display = 'block';
}

function hideResults() { document.getElementById('searchResults').style.display = 'none'; }
document.addEventListener('click', e => { if (!e.target.closest('#searchProduct') && !e.target.closest('#searchResults')) hideResults(); });

// ---- Cart ----
function addToCart(product) {
    const existing = cart.find(i => i.id === product.id);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id: product.id, name: product.name, price: parseFloat(product.price), qty: 1, unit: product.unit, stock: parseInt(product.stock) });
    }
    renderCart();
    hideResults();
    document.getElementById('searchProduct').value = '';
    document.getElementById('searchProduct').focus();
}

function renderCart() {
    const body = document.getElementById('cartBody');
    if (!cart.length) {
        document.getElementById('cartEmpty').style.display = '';
        document.getElementById('cartTableWrap').style.display = 'none';
        document.getElementById('btnProcess').disabled = true;
        return;
    }
    document.getElementById('cartEmpty').style.display = 'none';
    document.getElementById('cartTableWrap').style.display = '';

    body.innerHTML = cart.map((item, idx) =>
        `<tr>
            <td><div class="fw-semibold">${item.name}</div><small class="text-muted">@ Rp ${numFmt(item.price)}</small></td>
            <td>Rp ${numFmt(item.price)}</td>
            <td>
                <div class="input-group input-group-sm">
                    <button class="btn btn-outline-secondary" onclick="changeQty(${idx}, -1)">−</button>
                    <input type="number" class="form-control text-center" value="${item.qty}" min="1" max="${item.stock}"
                           onchange="setQty(${idx}, this.value)" style="width:55px">
                    <button class="btn btn-outline-secondary" onclick="changeQty(${idx}, 1)">+</button>
                </div>
            </td>
            <td class="fw-semibold">Rp ${numFmt(item.price * item.qty)}</td>
            <td><button class="btn btn-sm btn-outline-danger py-0 px-2" onclick="removeItem(${idx})"><i class="fas fa-times"></i></button></td>
        </tr>`
    ).join('');

    const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
    document.getElementById('cartTotal').textContent = 'Rp ' + numFmt(total);
    document.getElementById('summaryTotal').textContent = 'Rp ' + numFmt(total);
    document.getElementById('btnProcess').disabled = false;
    calcChange();
}

function changeQty(idx, delta) { cart[idx].qty = Math.max(1, Math.min(cart[idx].stock, cart[idx].qty + delta)); renderCart(); }
function setQty(idx, v) { cart[idx].qty = Math.max(1, Math.min(cart[idx].stock, parseInt(v) || 1)); renderCart(); }
function removeItem(idx) { cart.splice(idx, 1); renderCart(); }

// ---- Payment ----
document.getElementById('paymentAmount').addEventListener('input', calcChange);
document.querySelectorAll('.quick-cash').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('paymentAmount').value = parseInt(this.dataset.val) + parseInt(document.getElementById('paymentAmount').value || 0);
        calcChange();
    });
});
document.getElementById('exactPayBtn').addEventListener('click', function () {
    const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
    document.getElementById('paymentAmount').value = total;
    calcChange();
});

function calcChange() {
    const total   = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const paid    = parseFloat(document.getElementById('paymentAmount').value) || 0;
    const change  = paid - total;
    document.getElementById('changeAmount').textContent = change >= 0 ? 'Rp ' + numFmt(change) : '— (kurang Rp ' + numFmt(Math.abs(change)) + ')';
    document.getElementById('changeAmount').className = 'fw-bold fs-4 ' + (change >= 0 ? 'text-primary' : 'text-danger');
}

// ---- Process ----
document.getElementById('btnProcess').addEventListener('click', function () {
    const total  = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const paid   = parseFloat(document.getElementById('paymentAmount').value) || 0;
    if (paid < total) { alert('Pembayaran kurang!'); return; }

    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

    const method = document.querySelector('input[name="paymentMethod"]:checked').value;
    const note   = document.getElementById('transNote').value;
    const items  = cart.map(i => ({ id: i.id, name: i.name, qty: i.qty }));

    const form = new FormData();
    form.append(CSRF_NAME, CSRF_TOKEN);
    form.append('items', JSON.stringify(items));
    form.append('payment_amount', paid);
    form.append('payment_method', method);
    form.append('note', note);

    fetch(`${BASE_URL}kasir/transaction`, { method: 'POST', body: form })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalInvoice').textContent = 'Invoice: ' + data.invoice_number;
                document.getElementById('modalTotal').textContent = 'Rp ' + numFmt(data.total_amount);
                document.getElementById('modalPay').textContent = 'Rp ' + numFmt(data.payment_amount);
                document.getElementById('modalChange').textContent = 'Rp ' + numFmt(data.change_amount);
                document.getElementById('btnPrint').href = data.print_url;
                new bootstrap.Modal(document.getElementById('successModal')).show();
            } else {
                alert(data.message);
                document.getElementById('btnProcess').disabled = false;
                document.getElementById('btnProcess').innerHTML = '<i class="fas fa-check-circle me-2"></i>Proses Transaksi';
            }
        });
});

function resetPOS() {
    cart = [];
    renderCart();
    document.getElementById('paymentAmount').value = '';
    document.getElementById('transNote').value = '';
    document.getElementById('summaryTotal').textContent = 'Rp 0';
    document.getElementById('changeAmount').textContent = 'Rp 0';
    bootstrap.Modal.getInstance(document.getElementById('successModal')).hide();
    document.getElementById('btnProcess').disabled = true;
    document.getElementById('btnProcess').innerHTML = '<i class="fas fa-check-circle me-2"></i>Proses Transaksi';
    document.getElementById('searchProduct').focus();
}

function numFmt(n) { return Number(n).toLocaleString('id-ID'); }
</script>
<?= $this->endSection() ?>
