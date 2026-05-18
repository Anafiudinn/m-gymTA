{{-- resources/views/owner/products/show.blade.php --}}

@extends('layouts.owner')

@section('title', 'Detail Produk')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- HEADER CARD --}}
    <div class="card">
        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px;">

            {{-- LEFT --}}
            <div style="display:flex; align-items:center; gap:16px;">
                <div style="width:52px; height:52px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-box" style="color:#fff; font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:20px; font-weight:800; color:#111;">{{ $product->nama_produk }}</div>
                    <div style="font-size:13px; color:#aaa; margin-top:3px;">Monitoring detail penjualan produk</div>
                </div>
            </div>

            {{-- STOCK BADGE --}}
            @if($product->stok <= 5)
                <span style="display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:1px; font-size:13px; font-weight:700; background:#fff1f2; color:#be123c; border:1px solid #fecdd3;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size:11px;"></i> Stok Menipis
                </span>
            @else
                <span style="display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:1px; font-size:13px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                    <i class="fa-solid fa-circle-check" style="font-size:11px;"></i> Stok Aman
                </span>
            @endif

        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-tag" style="color:#555; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Harga Produk</div>
                <div style="font-size:20px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-cart-shopping" style="color:#1d4ed8; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Terjual</div>
                <div style="font-size:28px; font-weight:800; color:#1d4ed8; line-height:1.2; margin-top:2px;">{{ $totalSold }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-sack-dollar" style="color:#16a34a; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Omzet</div>
                <div style="font-size:20px; font-weight:800; color:#16a34a; line-height:1.2; margin-top:2px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>

    </div>

    {{-- PRODUCT INFO --}}
    <div class="card">
        <div style="font-size:14px; font-weight:700; color:#111; margin-bottom:16px;">
            <i class="fa-solid fa-circle-info" style="color:var(--red); margin-right:8px;"></i>Informasi Produk
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div style="background:#f9f9f9; border-radius:1px; padding:14px 16px;">
                <div style="font-size:11px; color:#aaa; font-weight:600; text-transform:uppercase; letter-spacing:.08em; margin-bottom:6px;">Nama Produk</div>
                <div style="font-size:14px; font-weight:700; color:#111;">{{ $product->nama_produk }}</div>
            </div>

            <div style="background:#f9f9f9; border-radius:1px; padding:14px 16px;">
                <div style="font-size:11px; color:#aaa; font-weight:600; text-transform:uppercase; letter-spacing:.08em; margin-bottom:6px;">Stok Saat Ini</div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="font-size:14px; font-weight:700; color:#111;">{{ $product->stok }} unit</div>
                    @if($product->stok <= 5)
                        <span style="font-size:11px; font-weight:700; color:#be123c; background:#fff1f2; padding:3px 8px; border-radius:1px; border:1px solid #fecdd3;">Menipis</span>
                    @else
                        <span style="font-size:11px; font-weight:700; color:#15803d; background:#f0fdf4; padding:3px 8px; border-radius:1px; border:1px solid #bbf7d0;">Aman</span>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- SALES HISTORY --}}
    <div class="card" style="padding:0; overflow:hidden;">

        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:14px; font-weight:700; color:#111;">
                <i class="fa-solid fa-chart-line" style="color:var(--red); margin-right:8px;"></i>Riwayat Penjualan
            </span>
            @if($salesHistory->count() > 0)
                <span style="font-size:12px; color:#999;">{{ $salesHistory->total() }} transaksi</span>
            @endif
        </div>

        @if($salesHistory->count() == 0)
            <div style="padding:56px; text-align:center; color:#bbb; font-size:14px;">
                <i class="fa-solid fa-chart-simple" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
                Belum ada riwayat penjualan
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9f9f9;">
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Invoice</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Qty</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Harga</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Subtotal</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesHistory as $item)
                            <tr style="border-top:1px solid var(--border); transition:.15s;"
                                onmouseover="this.style.background='#fafafa'"
                                onmouseout="this.style.background='transparent'">

                                <td style="padding:14px 22px;">
                                    <span style="font-size:12px; font-weight:700; color:#555; background:#f5f5f5; padding:3px 10px; border-radius:8px; font-family:monospace;">
                                        {{ $item->transaction->invoice_code ?? '-' }}
                                    </span>
                                </td>

                                <td style="padding:14px 22px;">
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:700; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">
                                        {{ $item->qty }}x
                                    </span>
                                </td>

                                <td style="padding:14px 22px; font-size:13px; color:#555;">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td style="padding:14px 22px; font-size:14px; font-weight:700; color:#111;">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>

                                <td style="padding:14px 22px; font-size:13px; color:#999;">
                                    {{ $item->created_at->format('d M Y H:i') }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:16px 22px; border-top:1px solid var(--border);">
                {{ $salesHistory->links() }}
            </div>
        @endif

    </div>

</div>

@endsection