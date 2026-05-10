@extends('layouts.admin')

@section('content')

<style>
    /* ── Page Header ── */
    .retail-search {
        display: flex; align-items: center; gap: 8px;
        background: #fff; border: 1px solid #ebebeb;
        border-radius: 10px; padding: 0 13px; height: 38px;
        transition: border-color .15s, box-shadow .15s;
        width: 100%; max-width: 280px;
    }
    .retail-search:focus-within { border-color: #93c5fd; box-shadow: 0 0 0 3px #eff6ff; }
    .retail-search i { font-size: 12px; color: #9ca3af; flex-shrink: 0; }
    .retail-search input {
        border: none; outline: none; background: transparent;
        font-size: 13px; color: #111827; font-family: 'DM Sans', sans-serif; width: 100%;
    }
    .retail-search input::placeholder { color: #bbb; }

    /* ── Tabs ── */
    .tab-bar { display: flex; gap: 4px; }
    .tab-btn {
        padding: 8px 16px; border-radius: 9px; font-size: 12.5px; font-weight: 700;
        border: 1px solid #ebebeb; background: #fff; color: #6b7280;
        cursor: pointer; transition: background .15s, color .15s, border-color .15s;
        text-decoration: none; font-family: 'DM Sans', sans-serif;
    }
    .tab-btn:hover { background: #f3f4f6; color: #111827; }
    .tab-btn.active { background: #111827; color: #fff; border-color: #111827; }

    /* ── Product Grid ── */
    .prod-panel {
        background: #fff; border: 1px solid #f0f0f0;
        border-radius: 14px; overflow: hidden;
    }
    .prod-panel-head {
        padding: 14px 18px; border-bottom: 1px solid #f0f0f0;
        font-size: 13px; font-weight: 700; color: #111827;
        display: flex; align-items: center; justify-content: space-between;
    }
    .prod-panel-body { padding: 12px; max-height: 68vh; overflow-y: auto; }
    .prod-panel-body::-webkit-scrollbar { width: 3px; }
    .prod-panel-body::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 3px; }

    .prod-card {
        display: flex; align-items: center; justify-content: space-between;
        padding: 11px 14px; border-radius: 10px;
        border: 1px solid #f3f4f6; background: #fafafa;
        cursor: pointer; margin-bottom: 6px; transition: all .15s;
        gap: 12px;
    }
    .prod-card:last-child { margin-bottom: 0; }
    .prod-card:hover { background: #fff; border-color: #2563eb; box-shadow: 0 2px 10px rgba(37,99,235,.08); }
    .prod-card.out-of-stock { opacity: .45; cursor: not-allowed; pointer-events: none; }

    .prod-card-icon {
        width: 34px; height: 34px; border-radius: 8px; background: #f3f4f6;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .prod-card-icon i { font-size: 13px; color: #9ca3af; }
    .prod-card-name { font-size: 13px; font-weight: 600; color: #111827; line-height: 1.3; }
    .prod-card-price { font-size: 12px; color: #2563eb; font-weight: 700; margin-top: 1px; }
    .prod-card-stock { font-size: 11.5px; color: #9ca3af; font-weight: 600; white-space: nowrap; }
    .prod-card-stock.low { color: #ef4444; }
    .prod-card-add {
        width: 28px; height: 28px; border-radius: 7px;
        background: #f3f4f6; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: background .15s;
    }
    .prod-card-add i { font-size: 10px; color: #6b7280; transition: color .15s; }
    .prod-card:hover .prod-card-add { background: #2563eb; }
    .prod-card:hover .prod-card-add i { color: #fff; }

    /* ── Cart Panel ── */
    .cart-panel {
        background: #111827; border-radius: 14px; overflow: hidden;
        position: sticky; top: 24px;
    }
    .cart-head {
        padding: 14px 18px; border-bottom: 1px solid rgba(255,255,255,.08);
        display: flex; align-items: center; justify-content: space-between;
    }
    .cart-head-title { font-size: 13px; font-weight: 700; color: #fff; }
    .cart-head-count {
        font-size: 10px; font-weight: 700; color: #93c5fd;
        background: rgba(37,99,235,.25); padding: 3px 8px;
        border-radius: 20px;
    }
    .cart-body { padding: 12px; max-height: 300px; overflow-y: auto; }
    .cart-body::-webkit-scrollbar { width: 3px; }
    .cart-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 3px; }

    .cart-empty {
        display: flex; flex-direction: column; align-items: center;
        gap: 8px; padding: 32px 16px; text-align: center;
    }
    .cart-empty-icon {
        width: 44px; height: 44px; border-radius: 11px;
        background: rgba(255,255,255,.06);
        display: flex; align-items: center; justify-content: center;
    }
    .cart-empty-icon i { font-size: 18px; color: rgba(255,255,255,.2); }
    .cart-empty p { font-size: 12.5px; color: rgba(255,255,255,.3); margin: 0; }

    .cart-item {
        background: rgba(255,255,255,.06); border-radius: 9px;
        padding: 10px 12px; margin-bottom: 6px;
        border: 1px solid rgba(255,255,255,.07);
    }
    .cart-item:last-child { margin-bottom: 0; }
    .cart-item-name { font-size: 12.5px; font-weight: 600; color: #f9fafb; margin-bottom: 8px; }
    .cart-item-row { display: flex; align-items: center; justify-content: space-between; }
    .qty-ctrl { display: flex; align-items: center; gap: 8px; }
    .qty-btn {
        width: 26px; height: 26px; border-radius: 6px;
        background: rgba(255,255,255,.1); border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; color: #fff;
        font-size: 12px; font-weight: 700; transition: background .15s;
        font-family: 'DM Sans', sans-serif;
    }
    .qty-btn:hover { background: rgba(255,255,255,.2); }
    .qty-val { font-size: 13px; font-weight: 700; color: #fff; min-width: 18px; text-align: center; }
    .cart-item-sub { font-size: 12.5px; font-weight: 700; color: #93c5fd; }
    .cart-item-del {
        background: none; border: none; cursor: pointer;
        color: rgba(255,255,255,.3); font-size: 11px;
        padding: 4px; border-radius: 5px; transition: color .15s;
    }
    .cart-item-del:hover { color: #ef4444; }

    /* Total */
    .cart-total {
        margin: 12px; padding: 14px 16px; border-radius: 10px;
        background: #2563eb;
    }
    .cart-total-label { font-size: 11px; color: rgba(255,255,255,.7); font-weight: 600; margin: 0 0 3px; }
    .cart-total-amount { font-size: 22px; font-weight: 800; color: #fff; margin: 0; line-height: 1.1; }

    /* Submit btn */
    .cart-submit {
        margin: 0 12px 12px; width: calc(100% - 24px);
        padding: 12px; border-radius: 10px;
        background: #ef4444; color: #fff;
        font-size: 13px; font-weight: 700; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif; transition: background .15s;
        display: flex; align-items: center; justify-content: center; gap: 7px;
    }
    .cart-submit:hover { background: #dc2626; }
    .cart-submit:disabled { background: rgba(255,255,255,.1); color: rgba(255,255,255,.3); cursor: not-allowed; }
    .cart-submit i { font-size: 12px; }

    /* ── History ── */
    .hist-panel {
        background: #fff; border: 1px solid #f0f0f0;
        border-radius: 14px; overflow: hidden;
    }
    .hist-head {
        padding: 14px 22px; border-bottom: 1px solid #f0f0f0;
        font-size: 13px; font-weight: 700; color: #111827;
    }

    .hist-item {
        padding: 14px 22px; border-bottom: 1px solid #f7f7f7;
        transition: background .12s;
    }
    .hist-item:last-child { border-bottom: none; }
    .hist-item:hover { background: #fafafa; }
    .hist-item-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .hist-invoice { font-size: 12px; font-weight: 700; color: #111827; font-family: 'DM Mono', monospace; }
    .hist-date { font-size: 11px; color: #9ca3af; margin-top: 1px; }
    .hist-amount { font-size: 13.5px; font-weight: 800; color: #2563eb; text-align: right; }
    .hist-view-btn {
        font-size: 11px; font-weight: 700; color: #6b7280; background: #f3f4f6;
        border: none; cursor: pointer; padding: 4px 9px; border-radius: 6px;
        font-family: 'DM Sans', sans-serif; transition: background .15s, color .15s;
        margin-top: 4px; display: inline-block;
    }
    .hist-view-btn:hover { background: #111827; color: #fff; }

    .hist-detail { margin-top: 10px; padding-top: 10px; border-top: 1px solid #f3f4f6; display: none; }
    .hist-detail.open { display: block; }
    .hist-detail-row {
        display: flex; align-items: center; justify-content: space-between;
        font-size: 12.5px; color: #6b7280; padding: 3px 0;
    }
    .hist-detail-row span:last-child { color: #374151; font-weight: 600; }

    .hist-empty {
        padding: 60px 24px; text-align: center;
        display: flex; flex-direction: column; align-items: center; gap: 10px;
    }
    .hist-empty-icon {
        width: 48px; height: 48px; border-radius: 12px; background: #f9fafb;
        display: flex; align-items: center; justify-content: center;
    }
    .hist-empty-icon i { font-size: 20px; color: #ddd; }
</style>

{{-- Page Header --}}
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:9px;"></i></span>
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
<div class="tab-bar" style="margin-bottom:22px;">
    <a href="?tab=katalog" class="tab-btn {{ $tab=='katalog' ? 'active' : '' }}">
        <i class="fa fa-shopping-cart" style="font-size:11px;margin-right:5px;"></i> Katalog
    </a>
    <a href="?tab=history" class="tab-btn {{ $tab=='history' ? 'active' : '' }}">
        <i class="fa fa-history" style="font-size:11px;margin-right:5px;"></i> History
    </a>
</div>


{{-- ═══════════════ KATALOG ═══════════════ --}}
@if($tab === 'katalog')
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">

    {{-- Produk List --}}
    <div class="prod-panel">
        <div class="prod-panel-head">
            <span>Produk</span>
            <span style="font-size:11px;color:#9ca3af;font-weight:500;">{{ count($products) }} item</span>
        </div>
        <div class="prod-panel-body">
            @foreach($products as $p)
            <div class="prod-card {{ $p->stok <= 0 ? 'out-of-stock' : '' }} product-item"
                 data-name="{{ strtolower($p->nama_produk) }}"
                 onclick="selectProduct('{{ $p->id }}','{{ addslashes($p->nama_produk) }}','{{ $p->harga }}','{{ $p->stok }}')">

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
        <span style="font-size:11px;color:#9ca3af;font-weight:500;margin-left:6px;">{{ $history->count() }} transaksi</span>
    </div>

    @forelse($history as $trx)
    <div class="hist-item">
        <div class="hist-item-top">
            <div>
                <p class="hist-invoice">{{ $trx->invoice_code }}</p>
                <p class="hist-date">{{ $trx->created_at->format('d M Y · H:i') }}</p>
            </div>
            <div style="text-align:right;flex-shrink:0;">
                <p class="hist-amount">Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                <button class="hist-view-btn" onclick="toggleDetail({{ $trx->id }}, this)">
                    Detail <i class="fa fa-chevron-down" style="font-size:9px;"></i>
                </button>
            </div>
        </div>

        <div class="hist-detail" id="detail-{{ $trx->id }}">
            @foreach($trx->items as $item)
            <div class="hist-detail-row">
                <span>{{ $item->product->nama_produk }} &times;{{ $item->qty }}</span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="hist-empty">
        <div class="hist-empty-icon"><i class="fa fa-receipt"></i></div>
        <p style="font-size:14px;font-weight:700;color:#374151;margin:0;">Belum Ada Transaksi</p>
        <p style="font-size:12.5px;color:#9ca3af;margin:0;">Transaksi retail hari ini akan muncul di sini.</p>
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
        if (exist.qty < stok) { exist.qty++; }
        else { showStockAlert(nama); return; }
    } else {
        cart.push({ id, nama, harga, stok, qty: 1 });
    }
    renderCart();
}

function showStockAlert(nama) {
    // reuse UBConfirm or simple toast
    if (window.UBConfirm) {
        UBConfirm.open({ title: 'Stok Habis', desc: `Stok ${nama} sudah mencapai batas maksimum.`, type: 'warning', label: 'Tutup' });
    }
}

function renderCart() {
    const bodyEl  = document.getElementById('cart_body');
    const emptyEl = document.getElementById('cart_empty');
    const hiddenEl= document.getElementById('hidden_inputs');
    const totalEl = document.getElementById('display_total');
    const countEl = document.getElementById('cart_count');
    const btnEl   = document.getElementById('btn_submit');

    hiddenEl.innerHTML = '';
    let total = 0;
    let totalQty = 0;

    // remove old cart items (keep empty state)
    bodyEl.querySelectorAll('.cart-item').forEach(el => el.remove());

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

    totalEl.textContent  = 'Rp ' + total.toLocaleString('id-ID');
    countEl.textContent  = totalQty + ' item';
}

function increase(i) {
    if (cart[i].qty < cart[i].stok) { cart[i].qty++; renderCart(); }
    else { showStockAlert(cart[i].nama); }
}

function decrease(i) {
    if (cart[i].qty > 1) { cart[i].qty--; } else { cart.splice(i, 1); }
    renderCart();
}

function removeItem(i) {
    cart.splice(i, 1);
    renderCart();
}

function toggleDetail(id, btn) {
    const el = document.getElementById('detail-' + id);
    el.classList.toggle('open');
    const icon = btn.querySelector('i');
    if (icon) {
        icon.style.transform = el.classList.contains('open') ? 'rotate(180deg)' : '';
        icon.style.transition = 'transform .2s';
    }
}

// Search
const searchEl = document.getElementById('searchProduct');
if (searchEl) {
    searchEl.addEventListener('input', function () {
        const val = this.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(el => {
            el.style.display = el.dataset.name.includes(val) ? '' : 'none';
        });
    });
}

// Responsive grid — collapse to single col on small screen
function checkLayout() {
    const grid = document.querySelector('[style*="grid-template-columns"]');
    if (!grid) return;
    if (window.innerWidth < 900) {
        grid.style.gridTemplateColumns = '1fr';
    } else {
        grid.style.gridTemplateColumns = '1fr 340px';
    }
}
checkLayout();
window.addEventListener('resize', checkLayout);
</script>
@endpush