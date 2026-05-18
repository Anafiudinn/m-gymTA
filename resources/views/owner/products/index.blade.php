@extends('layouts.owner') {{-- Sesuaikan dengan nama layout owner kamu --}}

@section('content')

{{-- STATS GRID --}}
{{-- 🌟 Diubah menjadi grid-cols-2 md:grid-cols-4 agar 4 kartu sejajar lurus ke samping --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-5" style="margin-bottom: 20px;">

    {{-- STAT 1: TOTAL SKU --}}
    <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px; padding:16px 18px;">
        <div style="width:48px; height:48px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="fa-solid fa-box-open" style="color:#555; font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Produk</div>
            <div style="font-size:28px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">{{ $totalProducts }}</div>
        </div>
    </div>

    {{-- STAT 2: TOTAL STOK AKTIF --}}
    <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px; padding:16px 18px;">
        <div style="width:48px; height:48px; border-radius:1px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="fa-solid fa-cubes" style="color:#1d4ed8; font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Stok</div>
            <div style="font-size:28px; font-weight:800; color:#1d4ed8; line-height:1.2; margin-top:2px;">{{ $totalStock }}</div>
        </div>
    </div>

    {{-- STAT 3: STOK MENIPIS --}}
    <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px; padding:16px 18px;">
        <div style="width:48px; height:48px; border-radius:1px; background:#fff1f2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="fa-solid fa-triangle-exclamation" style="color:var(--red); font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Stok Menipis</div>
            <div style="font-size:28px; font-weight:800; color:var(--red); line-height:1.2; margin-top:2px;">{{ $lowStockProducts }}</div>
        </div>
    </div>

    {{-- 🌟 STAT 4: PRODUK DIARSIPKAN (BARU DAN SUDAH SINKRON) --}}
    <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px; padding:16px 18px;">
        <div style="width:48px; height:48px; border-radius:1px; background:#f4f4f5; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="fa-solid fa-box-archive" style="color:#71717a; font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Diarsipkan</div>
            <div style="font-size:28px; font-weight:800; color:#71717a; line-height:1.2; margin-top:2px;">{{ $archivedProducts }}</div>
        </div>
    </div>

</div> {{-- Penutup tag Grid Stats Utama yang tadi hilang --}}

{{-- FILTER FORM --}}
<form method="GET" class="card" style="padding:18px 22px; border-radius:1px; margin-bottom: 20px;">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Cari Produk</label>
            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Nama produk..."
                   style="width:100%; border:1px solid var(--border); border-radius:1px; padding:10px 14px; font-size:13px; font-family:'Outfit',sans-serif; outline:none; color:#111; background:#fafafa; transition:.15s;"
                   onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                   onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
        </div>
        <div style="display:flex; align-items:flex-end;">
            <button type="submit"
                    style="width:100%; background:var(--red); color:#fff; border:none; padding:10px 18px; border-radius:1px; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.18s; display:flex; align-items:center; justify-content:center; gap:6px;"
                    onmouseover="this.style.background='var(--red-dark)'"
                    onmouseout="this.style.background='var(--red)'">
                <i class="fa-solid fa-magnifying-glass"></i> Filter Produk
            </button>
        </div>
    </div>
</form>

{{-- BEST SELLER --}}
<div class="card" style="padding:0; overflow:hidden; border-radius:1px; margin-bottom: 20px;">
    <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
        <span style="font-size:14px; font-weight:700; color:#111;">
            <i class="fa-solid fa-fire" style="color:var(--red); margin-right:8px;"></i>Produk Terlaris
        </span>
    </div>

    @if($bestSellerProducts->count() == 0)
        <div style="padding:48px; text-align:center; color:#bbb; font-size:14px;">
            <i class="fa-solid fa-chart-simple" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
            Belum ada penjualan produk
        </div>
    @else
        @foreach($bestSellerProducts as $index => $item)
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 22px; border-top:{{ $index > 0 ? '1px solid var(--border)' : 'none' }}; transition:.15s;"
                 onmouseover="this.style.background='#fafafa'"
                 onmouseout="this.style.background='transparent'">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:28px; height:28px; border-radius:1px; background:{{ $index === 0 ? 'linear-gradient(135deg,var(--red),#991b1b)' : 'rgba(0,0,0,.05)' }}; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; color:{{ $index === 0 ? '#fff' : '#999' }};">
                        {{ $index + 1 }}
                    </div>
                    <div style="font-size:14px; font-weight:600; color:#111;">
                        {{ $item->product->nama_produk ?? '-' }}
                        {{-- Indikator kecil jika produk terlaris ini ternyata sudah diarsipkan --}}
                        @if($item->product && !$item->product->is_active)
                            <small style="color: #71717a; background: #f4f4f5; padding: 2px 6px; font-size: 10px; margin-left: 4px; font-weight: normal;">Diarsipkan</small>
                        @endif
                    </div>
                </div>
                <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:1px; font-size:12px; font-weight:700; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">
                    <i class="fa-solid fa-arrow-trend-up" style="font-size:10px;"></i> {{ $item->total_qty }} Terjual
                </span>
            </div>
        @endforeach
    @endif
</div>

{{-- DATA TABLE --}}
<div class="card" style="padding:0; overflow:hidden; border-radius:1px;">
    <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
        <span style="font-size:14px; font-weight:700; color:#111;">
            <i class="fa-solid fa-box" style="color:var(--red); margin-right:8px;"></i>Data Produk
        </span>
        <span style="font-size:12px; color:#999;">{{ $products->total() }} produk</span>
    </div>

    @if($products->count() == 0)
        <div style="padding:56px; text-align:center; color:#bbb; font-size:14px;">
            <i class="fa-solid fa-box-open" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
            Belum ada produk
        </div>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f9f9f9;">
                        <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em; width:35%;">Produk</th>
                        <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Harga</th>
                        <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Stok</th>
                        {{-- 🌟 TAMBAH HEAD STATUS --}}
                        <th style="padding:12px 22px; text-align:center; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Status</th>
                        <th style="padding:12px 22px; text-align:right; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr style="border-top:1px solid var(--border); transition:.15s; {{ !$product->is_active ? 'opacity: 0.6; background: #fafafa;' : '' }}"
                            onmouseover="this.style.background='{{ $product->is_active ? '#fafafa' : '#f5f5f5' }}'"
                            onmouseout="this.style.background='{{ $product->is_active ? 'transparent' : '#fafafa' }}'">
                            
                            <td style="padding:14px 22px; font-size:14px; font-weight:600; color:#111;">
                                {{ $product->nama_produk }}
                                <div style="font-size:11px; color:#ccc; margin-top:2px; font-family:monospace; font-weight:normal;">#{{ $product->id }}</div>
                            </td>
                            
                            <td style="padding:14px 22px; font-size:14px; font-weight:700; color:#111;">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </td>
                            
                            <td style="padding:14px 22px;">
                                <span style="font-size:14px; font-weight:700; color:#111;">{{ $product->stok }}</span>
                                <span style="font-size:11px; color:#aaa; margin-left:2px;">pcs</span>
                            </td>

                            {{-- 🌟 KOLOM STATUS SINKRON DENGAN ADMIN --}}
                            <td style="padding:14px 22px; text-align:center;">
                                @if(!$product->is_active)
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:1px; font-size:11px; font-weight:700; background:#f4f4f5; color:#71717a; border:1px solid #e4e4e7;">
                                        <i class="fa-solid fa-archive" style="font-size:9px;"></i> Diarsipkan
                                    </span>
                                @elseif($product->stok <= 5)
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:1px; font-size:11px; font-weight:700; background:#fff1f2; color:#be123c; border:1px solid #fecdd3;">
                                        <i class="fa-solid fa-triangle-exclamation" style="font-size:9px;"></i> Menipis
                                    </span>
                                @else
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:1px; font-size:11px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                                        <i class="fa-solid fa-circle-check" style="font-size:9px;"></i> Aman
                                    </span>
                                @endif
                            </td>
                            
                            <td style="padding:14px 22px; text-align:right;">
                                <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
                                    
                                    {{-- 🌟 ACTION TOGGLE STATUS UNTUK OWNER --}}
                                    {{-- Form ini menembak route toggle milik admin karena fungsinya sama, tinggal manfaatkan endpoint yang sudah ada --}}
                                    <form action="{{ route('owner.products.toggle', $product->id) }}"
      method="POST"
      style="display:inline;">
    @csrf
    @method('PATCH')

    @if($product->is_active)
        <button type="submit" title="Arsipkan Produk"
                style="width:32px; height:32px; border-radius:1px; border:1px solid #fed7aa; background:#fff7ed; color:#ea580c; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.13s; font-size:12px;">
            <i class="fa-solid fa-box-archive"></i>
        </button>
    @else
        <button type="submit" title="Aktifkan Produk"
                style="width:32px; height:32px; border-radius:1px; border:1px solid #bbf7d0; background:#f0fdf4; color:#16a34a; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.13s; font-size:12px;">
            <i class="fa-solid fa-eye"></i>
        </button>
    @endif
</form>

                                    {{-- TOMBOL DETAIL BAWAAN --}}
                                    <a href="{{ route('owner.products.show', $product->id) }}" title="Lihat Detail Analisis"
                                       style="width:32px; height:32px; border-radius:1px; background:rgba(0,0,0,.04); color:#111; display:inline-flex; align-items:center; justify-content:center; text-decoration:none; border:1px solid var(--border); transition:.15s; font-size:12px;"
                                       onmouseover="this.style.background='rgba(0,0,0,.09)'"
                                       onmouseout="this.style.background='rgba(0,0,0,.04)'">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 22px; border-top:1px solid var(--border);">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection