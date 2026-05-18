@extends('layouts.admin')

@section('header-title', 'Kasir Retail')

@section('content')

<style>
    /* ── Search — selaras dengan .hdr-btn style layout admin ── */
    .retail-search {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 0 12px;
        height: 36px;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
        max-width: 260px;
    }

    .retail-search:focus-within {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
    }

    .retail-search i {
        font-size: 11px;
        color: var(--muted);
        flex-shrink: 0;
    }

    .retail-search input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 13px;
        color: var(--text);
        font-family: 'Outfit', sans-serif;
        width: 100%;
    }

    .retail-search input::placeholder { color: #bbb; }

    /* ── Page header — sinkron dengan admin layout ── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: var(--muted);
        margin-bottom: 4px;
    }

    .breadcrumb .sep { color: #ddd; }
    .breadcrumb .current { color: #888; }

    .page-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .page-sub {
        font-size: 12px;
        color: var(--muted);
        margin-top: 3px;
    }

    /* ── Tabs — border-radius & color selaras admin ── */
    .tab-bar {
        display: flex;
        gap: 4px;
        margin-bottom: 18px;
    }

    .tab-btn {
        padding: 7px 14px;
        border-radius: var(--radius);
        font-size: 12px;
        font-weight: 700;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--muted);
        cursor: pointer;
        transition: background .15s, color .15s, border-color .15s;
        text-decoration: none;
        font-family: 'Outfit', sans-serif;
    }

    .tab-btn:hover { background: #f4f4f4; color: var(--text); }

    .tab-btn.active {
        background: var(--text);
        color: #fff;
        border-color: var(--text);
    }

    /* ── Product panel — pakai .card dari admin ── */
    .prod-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .prod-panel-head {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .prod-panel-count { font-size: 11px; color: var(--muted); font-weight: 500; }

    .prod-panel-body {
        padding: 10px;
        max-height: 65vh;
        overflow-y: auto;
    }

    .prod-panel-body::-webkit-scrollbar { width: 3px; }
    .prod-panel-body::-webkit-scrollbar-thumb { background: rgba(0,0,0,.08); border-radius: 99px; }

    /* Prod card — hover border memakai --red agar selaras active nav */
    .prod-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius);
        border: 1px solid #f3f4f6;
        background: #fafafa;
        cursor: pointer;
        margin-bottom: 5px;
        transition: all .15s;
    }

    .prod-card:last-child { margin-bottom: 0; }

    .prod-card:hover {
        background: var(--surface);
        border-color: var(--red);
        box-shadow: 0 2px 10px rgba(239,68,68,.08);
    }

    .prod-card.out-of-stock { opacity: .4; cursor: not-allowed; pointer-events: none; }

    .prod-card-icon {
        width: 30px;
        height: 30px;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .prod-card-icon i { font-size: 12px; color: var(--muted); }

    .prod-card-name { font-size: 13px; font-weight: 600; color: var(--text); line-height: 1.3; }

    /* Harga pakai --red selaras warna aktif navigasi */
    .prod-card-price { font-size: 11px; color: var(--red); font-weight: 700; margin-top: 1px; }

    .prod-card-stock { font-size: 11px; color: var(--muted); font-weight: 600; white-space: nowrap; }
    .prod-card-stock.low { color: var(--red); }

    .prod-card-add {
        width: 26px;
        height: 26px;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background .15s;
    }

    .prod-card-add i { font-size: 10px; color: var(--muted); transition: color .15s; }
    .prod-card:hover .prod-card-add { background: var(--red); }
    .prod-card:hover .prod-card-add i { color: #fff; }

    /* ── Cart — warna #111 selaras sidebar footer admin ── */
    .cart-panel {
        background: #111111;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        position: sticky;
        top: 20px;
    }

    .cart-head {
        padding: 13px 14px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cart-head-title { font-size: 13px; font-weight: 700; color: #fff; }

    .cart-head-count {
        font-size: 10px;
        font-weight: 700;
        color: #fd9a93;
        background: rgba(210, 49, 28, 0.25);
        padding: 2px 8px;
        border-radius: 20px;
    }

    .cart-body { padding: 10px; max-height: 280px; overflow-y: auto; }
    .cart-body::-webkit-scrollbar { width: 3px; }
    .cart-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 99px; }

    .cart-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
        padding: 28px 14px;
        text-align: center;
    }

    .cart-empty-icon {
        width: 38px;
        height: 38px;
        border-radius: var(--radius);
        background: rgba(255,255,255,.06);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-empty-icon i { font-size: 16px; color: rgba(255,255,255,.2); }
    .cart-empty p { font-size: 12px; color: rgba(255,255,255,.3); margin: 0; }

    /* Cart item */
    .cart-item {
        background: rgba(255,255,255,.06);
        border-radius: var(--radius);
        padding: 9px 10px;
        margin-bottom: 5px;
        border: 1px solid rgba(255,255,255,.07);
    }

    .cart-item:last-child { margin-bottom: 0; }
    .cart-item-name { font-size: 12px; font-weight: 600; color: #f9fafb; margin-bottom: 7px; }

    .cart-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .qty-ctrl { display: flex; align-items: center; gap: 7px; }

    .qty-btn {
        width: 24px;
        height: 24px;
        border-radius: var(--radius);
        background: rgba(255,255,255,.1);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        transition: background .15s;
        font-family: 'Outfit', sans-serif;
    }

    .qty-btn:hover { background: rgba(255,255,255,.2); }

    .qty-val { font-size: 12px; font-weight: 700; color: #fff; min-width: 16px; text-align: center; }

    .cart-item-sub { font-size: 12px; font-weight: 700; color: #93c5fd; }

    .cart-item-del {
        background: none;
        border: none;
        cursor: pointer;
        color: rgba(255,255,255,.3);
        font-size: 11px;
        padding: 3px;
        border-radius: var(--radius);
        transition: color .15s;
    }

    .cart-item-del:hover { color: var(--red); }

    /* Total */
    .cart-total {
        margin: 10px;
        padding: 12px 14px;
        border-radius: var(--radius);
        background: #eb3f25;
    }

    .cart-total-label { font-size: 10px; color: rgba(255,255,255,.7); font-weight: 600; margin: 0 0 2px; }
    .cart-total-amount { font-size: 20px; font-weight: 800; color: #fff; margin: 0; line-height: 1.15; }

    /* Form fields — selaras gaya input admin */
    .cart-fields { padding: 0 10px 10px; display: flex; flex-direction: column; gap: 9px; }

    .cart-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        color: rgba(255,255,255,.6);
        margin-bottom: 5px;
    }

    .retail-field {
        width: 100%;
        height: 36px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: var(--radius);
        background: rgba(255,255,255,.07);
        color: #fff;
        padding: 0 12px;
        font-size: 12px;
        font-family: 'Outfit', sans-serif;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }

    .retail-field:focus {
        border-color: rgba(250, 124, 96, 0.6);
        box-shadow: 0 0 0 3px rgba(250, 129, 96, 0.12);
    }

    .retail-field::placeholder { color: rgba(255,255,255,.3); }
    .retail-field option { color: #111; }

    /* Submit — selaras .logout-btn warna merah admin */
    .cart-submit {
        margin: 0 10px 10px;
        width: calc(100% - 20px);
        padding: 10px;
        border-radius: var(--radius);
        background: var(--red);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        font-family: 'Outfit', sans-serif;
        transition: background .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .cart-submit:hover { background: var(--red-dark); }

    .cart-submit:disabled {
        background: rgba(255,255,255,.08);
        color: rgba(255,255,255,.25);
        cursor: not-allowed;
    }

    .cart-submit i { font-size: 11px; }

    /* ── History panel — selaras .card admin ── */
    .hist-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .hist-head {
        padding: 13px 18px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .hist-head-count { font-size: 11px; color: var(--muted); font-weight: 500; }

    .hist-item {
        padding: 13px 18px;
        border-bottom: 1px solid rgba(0,0,0,.04);
        transition: background .12s;
    }

    .hist-item:last-child { border-bottom: none; }
    .hist-item:hover { background: #fafafa; }

    .hist-item-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .hist-invoice { font-size: 12px; font-weight: 700; color: var(--text); font-family: monospace; }
    .hist-date { font-size: 11px; color: var(--muted); margin-top: 1px; }
    .hist-buyer { font-size: 12px; color: var(--muted); margin-top: 5px; }
    .hist-buyer i { font-size: 10px; }
    .hist-amount { font-size: 13px; font-weight: 800; color: #eb3f25; text-align: right; }
    .hist-qty { font-size: 11px; color: var(--muted); margin-top: 2px; text-align: right; }

    /* Payment badge — selaras warna semantik admin */
    .pay-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 7px;
        border-radius: var(--radius);
        font-size: 10px;
        font-weight: 700;
    }

    .pay-badge i { font-size: 9px; }
    .pay-badge.cash { background: rgba(22,163,74,.1); color: #166534; }
    .pay-badge.transfer { background: rgba(37,99,235,.1); color: #1d4ed8; }
    .pay-badge.qris { background: rgba(126,34,206,.1); color: #7e22ce; }

    /* View btn — selaras .hdr-btn */
    .hist-view-btn {
        font-size: 11px;
        font-weight: 700;
        color: var(--muted);
        background: rgba(0,0,0,.04);
        border: 1px solid var(--border);
        cursor: pointer;
        padding: 4px 8px;
        border-radius: var(--radius);
        font-family: 'Outfit', sans-serif;
        transition: background .15s, color .15s;
        margin-top: 5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .hist-view-btn:hover { background: var(--text); color: #fff; border-color: var(--text); }

    .hist-detail {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid rgba(0,0,0,.05);
        display: none;
    }

    .hist-detail.open { display: block; }

    .hist-meta { margin-bottom: 10px; display: flex; flex-direction: column; gap: 5px; }

    .hist-meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: var(--muted);
    }

    .hist-meta-row strong { color: var(--text); font-weight: 700; }

    .hist-detail-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 4px 0;
    }

    .hist-detail-name { font-size: 12px; font-weight: 600; color: #374151; margin: 0; }
    .hist-detail-unit { font-size: 11px; color: var(--muted); margin: 2px 0 0; }
    .hist-detail-sub { font-size: 12px; font-weight: 700; color: var(--text); }

    /* Empty states */
    .hist-empty {
        padding: 52px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .hist-empty-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hist-empty-icon i { font-size: 18px; color: #ddd; }
    .hist-empty-title { font-size: 13px; font-weight: 700; color: var(--text); margin: 0; }
    .hist-empty-sub { font-size: 12px; color: var(--muted); margin: 0; }
</style>

{{-- Page Header --}}
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:8px;"></i></span>
            <span class="current">Kasir Retail</span>
        </div>
        <h1 class="page-title">Kasir Retail</h1>
        <p class="page-sub">Penjualan minuman, suplemen, dan merchandise gym.</p>
    </div>
    @if($tab === 'katalog')
    <div class="retail-search">
        <i class="fa fa-search"></i>
        <input type="text" id="searchProduct" placeholder="Cari produk...">
    </div>
    @endif
</div>

{{-- Tabs --}}
<div class="tab-bar">
    <a href="?tab=katalog" class="tab-btn {{ $tab=='katalog' ? 'active' : '' }}">
        <i class="fa fa-shopping-cart" style="font-size:10px;margin-right:4px;"></i>Katalog
    </a>
    <a href="?tab=history" class="tab-btn {{ $tab=='history' ? 'active' : '' }}">
        <i class="fa fa-history" style="font-size:10px;margin-right:4px;"></i>History
    </a>
</div>


{{-- ═══════════════ KATALOG ═══════════════ --}}
@if($tab === 'katalog')
<div style="display:grid;grid-template-columns:1fr 320px;gap:16px;align-items:start;">

    {{-- Produk --}}
    <div class="prod-panel">
        <div class="prod-panel-head">
            <span>Produk</span>
            <span class="prod-panel-count">{{ count($products) }} item</span>
        </div>
        <div class="prod-panel-body">
            @foreach($products as $p)
          <div class="prod-card {{ $p->stok <= 0 ? 'out-of-stock' : '' }} product-item"
    data-name="{{ strtolower($p->nama_produk) }}"
    onclick='selectProduct(
        @json($p->id),
        @json($p->nama_produk),
        @json($p->harga),
        @json($p->stok)
    )'>


                <div class="prod-card-icon"><i class="fa fa-box"></i></div>

                <div style="flex:1;min-width:0;">
                    <p class="prod-card-name">{{ $p->nama_produk }}</p>
                    <p class="prod-card-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                </div>

                <span class="prod-card-stock {{ $p->stok <= 5 ? 'low' : '' }}">
                    {{ $p->stok }} pcs
                </span>

                <button class="prod-card-add" tabindex="-1">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Cart --}}
    <div class="cart-panel">
        <div class="cart-head">
            <span class="cart-head-title">Detail Order</span>
            <span class="cart-head-count" id="cart_count">0 item</span>
        </div>

        <form method="POST" action="{{ route('admin.retail.store') }}" id="retail_form">
            @csrf

            <div class="cart-body" id="cart_body">
                <div class="cart-empty" id="cart_empty">
                    <div class="cart-empty-icon"><i class="fa fa-shopping-basket"></i></div>
                    <p>Belum ada produk dipilih</p>
                </div>
            </div>

            <div class="cart-total">
                <p class="cart-total-label">Total Pembayaran</p>
                <p class="cart-total-amount" id="display_total">Rp 0</p>
            </div>

            <div class="cart-fields">
                <div>
                    <label class="cart-label">
                        Nama Pembeli <span style="opacity:.5;">(opsional)</span>
                    </label>
                    <input type="text" name="guest_name" placeholder="Contoh: Budi" class="retail-field">
                </div>
                <div>
                    <label class="cart-label">Metode Pembayaran</label>
                    <select name="payment_method" class="retail-field" required>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
            </div>

            <div id="hidden_inputs"></div>

            <button type="submit" class="cart-submit" id="btn_submit" disabled>
                <i class="fa fa-check-circle"></i> Proses Transaksi
            </button>
        </form>
    </div>

</div>
@endif


{{-- ═══════════════ HISTORY ═══════════════ --}}
@if($tab === 'history')
<div class="hist-panel">
    <div class="hist-head">
        Transaksi Hari Ini
        <span class="hist-head-count">{{ $history->count() }} transaksi</span>
    </div>

    @forelse($history as $trx)
    @php
        $buyer   = $trx->guest_name ?: 'Guest / Walk-in';
        $payment = $trx->payment_method;
        $totalQty = $trx->items->sum('qty');
    @endphp

    <div class="hist-item">
        <div class="hist-item-top">
            <div>
                <div style="display:flex;align-items:center;gap:7px;flex-wrap:wrap;">
                    <p class="hist-invoice">{{ $trx->invoice_code }}</p>
                    @if($payment === 'cash')
                        <span class="pay-badge cash"><i class="fa fa-money-bill-wave"></i> CASH</span>
                    @elseif($payment === 'transfer')
                        <span class="pay-badge transfer"><i class="fa fa-university"></i> TRANSFER</span>
                    @else
                        <span class="pay-badge qris"><i class="fa fa-qrcode"></i> QRIS</span>
                    @endif
                </div>
                <p class="hist-date">{{ $trx->created_at->format('d M Y · H:i') }}</p>
                <p class="hist-buyer"><i class="fa fa-user"></i> {{ $buyer }}</p>
            </div>
            <div style="flex-shrink:0;text-align:right;">
                <p class="hist-amount">Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                <p class="hist-qty">{{ $totalQty }} item</p>
                <button class="hist-view-btn" onclick="toggleDetail({{ $trx->id }}, this)">
                    Detail <i class="fa fa-chevron-down" style="font-size:8px;"></i>
                </button>
            </div>
        </div>

        <div class="hist-detail" id="detail-{{ $trx->id }}">
            <div class="hist-meta">
                <div class="hist-meta-row">
                    <span>Pembeli</span><strong>{{ $buyer }}</strong>
                </div>
                <div class="hist-meta-row">
                    <span>Pembayaran</span>
                    <strong style="text-transform:capitalize;">{{ $payment }}</strong>
                </div>
                <div class="hist-meta-row">
                    <span>Kasir</span>
                    <strong>{{ optional($trx->admin)->name ?? 'Admin' }}</strong>
                </div>
            </div>

            @foreach($trx->items as $item)
            <div class="hist-detail-row">
                <div>
                    <p class="hist-detail-name">{{ $item->product->nama_produk }}</p>
                    <p class="hist-detail-unit">{{ $item->qty }} × Rp {{ number_format($item->price,0,',','.') }}</p>
                </div>
                <span class="hist-detail-sub">Rp {{ number_format($item->subtotal,0,',','.') }}</span>
            </div>
            @endforeach
        </div>
    </div>

    @empty
    <div class="hist-empty">
        <div class="hist-empty-icon"><i class="fa fa-receipt"></i></div>
        <p class="hist-empty-title">Belum Ada Transaksi</p>
        <p class="hist-empty-sub">Transaksi retail hari ini akan muncul di sini.</p>
    </div>
    @endforelse
</div>
@endif

@endsection

@push('scripts')
<script>
    let cart = [];

    function selectProduct(id, nama, harga, stok) {
        harga = parseInt(harga);
        stok  = parseInt(stok);
        let exist = cart.find(i => i.id == id);
        if (exist) {
            if (exist.qty < stok) {
                exist.qty++;
            } else {
                ubgAlert({ title: 'Stok Maksimum', message: `Stok <strong>${nama}</strong> sudah mencapai batas.`, type: 'warn' });
                return;
            }
        } else {
            cart.push({ id, nama, harga, stok, qty: 1 });
        }
        renderCart();
    }

    function renderCart() {
        const bodyEl   = document.getElementById('cart_body');
        const emptyEl  = document.getElementById('cart_empty');
        const hiddenEl = document.getElementById('hidden_inputs');
        const totalEl  = document.getElementById('display_total');
        const countEl  = document.getElementById('cart_count');
        const btnEl    = document.getElementById('btn_submit');

        hiddenEl.innerHTML = '';
        bodyEl.querySelectorAll('.cart-item').forEach(el => el.remove());

        let total    = 0;
        let totalQty = 0;

        if (cart.length === 0) {
            if (emptyEl) emptyEl.style.display = '';
            btnEl.disabled = true;
            totalEl.textContent = 'Rp 0';
            countEl.textContent = '0 item';
            return;
        }

        if (emptyEl) emptyEl.style.display = 'none';
        btnEl.disabled = false;

        cart.forEach((item, index) => {
            const subtotal = item.qty * item.harga;
            total    += subtotal;
            totalQty += item.qty;

            const el = document.createElement('div');
            el.className = 'cart-item';
            el.innerHTML = `
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:6px;">
                    <p class="cart-item-name">${item.nama}</p>
                    <button type="button" class="cart-item-del" onclick="removeItem(${index})" title="Hapus">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="cart-item-row">
                    <div class="qty-ctrl">
                        <button type="button" class="qty-btn" onclick="decrease(${index})">−</button>
                        <span class="qty-val">${item.qty}</span>
                        <button type="button" class="qty-btn" onclick="increase(${index})">+</button>
                    </div>
                    <span class="cart-item-sub">Rp ${subtotal.toLocaleString('id-ID')}</span>
                </div>
            `;
            bodyEl.appendChild(el);

            hiddenEl.innerHTML += `
                <input type="hidden" name="products[${index}][id]"  value="${item.id}">
                <input type="hidden" name="products[${index}][qty]" value="${item.qty}">
            `;
        });

        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        countEl.textContent = totalQty + ' item';
    }

    function increase(i) {
        if (cart[i].qty < cart[i].stok) { cart[i].qty++; renderCart(); }
        else ubgAlert({ title: 'Stok Maksimum', message: `Stok <strong>${cart[i].nama}</strong> sudah mencapai batas.`, type: 'warn' });
    }

    function decrease(i) {
        if (cart[i].qty > 1) cart[i].qty--;
        else cart.splice(i, 1);
        renderCart();
    }

    function removeItem(i) { cart.splice(i, 1); renderCart(); }

    function toggleDetail(id, btn) {
        const el = document.getElementById('detail-' + id);
        el.classList.toggle('open');
        const icon = btn.querySelector('i');
        if (icon) { icon.style.transform = el.classList.contains('open') ? 'rotate(180deg)' : ''; icon.style.transition = 'transform .2s'; }
    }

    const searchEl = document.getElementById('searchProduct');
    if (searchEl) {
        searchEl.addEventListener('input', function () {
            const val = this.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(el => {
                el.style.display = el.dataset.name.includes(val) ? '' : 'none';
            });
        });
    }

    function checkLayout() {
        const grid = document.querySelector('[style*="grid-template-columns"]');
        if (!grid) return;
        grid.style.gridTemplateColumns = window.innerWidth < 900 ? '1fr' : '1fr 320px';
    }
    checkLayout();
    window.addEventListener('resize', checkLayout);

    /* =========================================================
    CONFIRM PROCESS TRANSACTION
========================================================= */

document.getElementById('retail_form').addEventListener('submit', function(e){

    e.preventDefault();

    if(cart.length === 0){
        ubgAlert({
            title: 'Keranjang Kosong',
            message: 'Pilih minimal 1 produk sebelum memproses transaksi.',
            type: 'warn'
        });
        return;
    }

    const totalQty = cart.reduce((t, i) => t + i.qty, 0);

    ubgConfirm({
        title: 'Proses Transaksi',
        message: `
            Total item: <strong>${totalQty}</strong><br>
            Total pembayaran: <strong>${document.getElementById('display_total').textContent}</strong><br><br>
            Yakin ingin memproses transaksi ini?
        `,
        type: 'info',
        confirmText: 'Ya, Proses',
        cancelText: 'Batal',
        onConfirm: () => {

            const btn = document.getElementById('btn_submit');

            btn.disabled = true;

            btn.innerHTML = `
                <i class="fa fa-spinner fa-spin"></i>
                Memproses...
            `;

            e.target.submit();
        }
    });

});
</script>
@endpush