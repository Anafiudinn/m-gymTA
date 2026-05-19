@extends('layouts.member')

@section('content')

<style>
    :root {
        --bg: #0b0b0b;
        --bg2: #121212;
        --border: rgba(255, 255, 255, .06);
        --text: #f5f5f5;
        --muted: #8b8b8b;
        --red: #ef4444;
    }

    .transaction-page {
        padding: 32px;
    }

    /* =========================================================
        HEADER
    ========================================================= */
    .transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .transaction-title h1 {
        margin: 0;
        color: #fff;
        font-size: 28px;
        font-weight: 900;
        letter-spacing: .02em;
    }

    .transaction-title p {
        margin-top: 6px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        background: var(--bg2);
        border: 1px solid var(--border);
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .back-btn:hover {
        border-color: rgba(255, 255, 255, .12);
        background: rgba(255, 255, 255, .02);
        transform: translateY(-1px);
    }

    /* =========================================================
        MAIN CONTAINER & TABLE (DESKTOP)
    ========================================================= */
    .trx-container {
        background: linear-gradient(180deg, rgba(255, 255, 255, .02), rgba(255, 255, 255, .01));
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        backdrop-filter: blur(10px);
    }

    .trx-table {
        width: 100%;
        border-collapse: collapse;
    }

    .trx-table th {
        text-align: left;
        font-size: 10px;
        color: #7b7b7b;
        text-transform: uppercase;
        letter-spacing: .12em;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        font-weight: 800;
    }

    .trx-table td {
        padding: 16px 0;
        font-size: 13px;
        border-bottom: 1px solid rgba(255, 255, 255, .04);
        vertical-align: middle;
    }

    .trx-table tr:last-child td {
        border-bottom: none;
    }

    .trx-table tr {
        transition: .2s ease;
    }

    .trx-table tr:hover {
        transform: translateX(2px);
    }

    /* =========================================================
        BADGES & META TAGS
    ========================================================= */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .status-success { background: rgba(34, 197, 94, .1); color: #22c55e; border: 1px solid rgba(34, 197, 94, .15); }
    .status-pending { background: rgba(234, 179, 8, .1); color: #facc15; border: 1px solid rgba(234, 179, 8, .15); }
    .status-danger  { background: rgba(239, 68, 68, .1); color: #ef4444; border: 1px solid rgba(239, 68, 68, .15); }

    .meta-wrap {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 6px;
    }

    .meta-tag {
        padding: 2px 6px;
        border-radius: 4px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid rgba(255, 255, 255, .05);
        color: var(--muted);
        font-size: 10px;
    }

    .detail-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid var(--border);
        color: #fff;
        cursor: pointer;
        font-size: 11px;
        font-weight: 700;
        transition: .2s;
    }

    .detail-btn:hover {
        background: var(--red);
        border-color: var(--red);
        transform: translateY(-1px);
    }

    /* =========================================================
        MOBILE CARD LIST (Sembunyi di Desktop)
    ========================================================= */
    .mobile-trx-list {
        display: none;
        flex-direction: column;
        gap: 12px;
    }

    .mobile-trx-card {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 14px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .mobile-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    /* =========================================================
        EMPTY STATE & LOAD MORE
    ========================================================= */
    .empty-state {
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        margin: auto;
        border-radius: 16px;
        background: rgba(255, 255, 255, .02);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 22px;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        color: #fff;
        margin-bottom: 6px;
        font-size: 16px;
        font-weight: 800;
    }

    .empty-state p {
        color: var(--muted);
        font-size: 13px;
    }

    .load-more-wrap {
        margin-top: 24px;
        text-align: center;
    }

    .load-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid var(--border);
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .load-more-btn:hover {
        background: rgba(239, 68, 68, .06);
        border-color: rgba(239, 68, 68, .16);
        transform: translateY(-1px);
    }

    /* =========================================================
        RESPONSIVE BREAKPOINTS
    ========================================================= */
    @media(max-width:768px) {
        .transaction-page {
            padding: 16px;
        }

        .transaction-title h1 {
            font-size: 24px;
        }

        .trx-table {
            display: none;
        }

        .mobile-trx-list {
            display: flex;
        }
    }
</style>

<div class="transaction-page">

    {{-- HEADER --}}
    <div class="transaction-header">
        <div class="transaction-title">
            <h1>Riwayat Paket</h1>
            <p>Riwayat lengkap pembelian aktivasi member, membership bulanan, dan personal trainer kamu.</p>
        </div>

        <a href="{{ route('member.dashboard', ['tab' => 'history']) }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if($transactions->isEmpty())
    {{-- EMPTY STATE --}}
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fa-solid fa-wallet"></i>
        </div>
        <h3>Belum Ada Riwayat Paket</h3>
        <p>Setelah membeli membership atau paket PT, riwayat transaksi akan muncul di sini.</p>
    </div>
    @else

    {{-- MAIN CONTAINER --}}
    <div class="trx-container">

        {{-- DESKTOP TABLE VIEW --}}
        <table class="trx-table">
            <thead>
                <tr>
                    <th style="width: 15%;">TANGGAL</th>
                    <th style="width: 45%;">PAKET / DETAIL</th>
                    <th style="width: 20%;">TOTAL BAYAR</th>
                    <th style="width: 20%; text-align: right;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                @php
                    $packageLabel = match($trx->category) {
                        'activation' => 'Aktivasi Member',
                        'monthly' => match((int) $trx->amount) {
                            (int) ($settings['bulanan_member'] ?? 0) => 'Membership Member',
                            (int) ($settings['bulanan_tamu'] ?? 0) => 'Membership Guest',
                            default => 'Membership Bulanan',
                        },
                        'pt' => $trx->ptPackage->nama_paket ?? 'Paket PT',
                        default => ucfirst($trx->category),
                    };

                    $statusClass = match($trx->status) {
                        'success' => 'status-success',
                        'rejected' => 'status-danger',
                        default => 'status-pending'
                    };
                @endphp
                <tr>
                    {{-- Tanggal --}}
                    <td style="color: var(--muted); font-size: 12px;">
                        {{ $trx->created_at->format('d M Y') }}
                        <div style="font-size: 10px; margin-top: 2px;">{{ $trx->created_at->format('H:i') }} WIB</div>
                    </td>

                    {{-- Paket & Meta --}}
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 2px;">
                            <div style="font-weight: 700; color: #fff; font-size: 14px;">
                                {{ $packageLabel }}
                            </div>
                            <div class="meta-wrap">
                                <span class="status-pill {{ $statusClass }}">
                                    <i class="fa-solid fa-circle" style="font-size: 6px;"></i> {{ strtoupper($trx->status) }}
                                </span>
                                <span class="meta-tag">#{{ $trx->invoice_code }}</span>
                                <span class="meta-tag"><i class="fa-solid fa-credit-card"></i> {{ strtoupper($trx->payment_method) }}</span>
                                <span class="meta-tag"><i class="fa-solid fa-globe"></i> {{ strtoupper($trx->source) }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Harga --}}
                    <td style="font-weight: 800; color: var(--red); font-size: 15px;">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>

                    {{-- Tombol Aksi --}}
                    <td style="text-align: right;">
                        <button onclick="openTrackingModal('{{ $trx->id }}')" class="detail-btn">
                            <i class="fa-solid fa-circle-info"></i> DETAIL
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- MOBILE CARD VIEW --}}
        <div class="mobile-trx-list">
            @foreach($transactions as $trx)
            @php
                $packageLabel = match($trx->category) {
                    'activation' => 'Aktivasi Member',
                    'monthly' => match((int) $trx->amount) {
                        (int) ($settings['bulanan_member'] ?? 0) => 'Membership Member',
                        (int) ($settings['bulanan_tamu'] ?? 0) => 'Membership Guest',
                        default => 'Membership Bulanan',
                    },
                    'pt' => $trx->ptPackage->nama_paket ?? 'Paket PT',
                    default => ucfirst($trx->category),
                };

                $statusClass = match($trx->status) {
                    'success' => 'status-success',
                    'rejected' => 'status-danger',
                    default => 'status-pending'
                };
            @endphp
            <div class="mobile-trx-card">
                <div class="mobile-row">
                    <span style="font-size: 11px; color: var(--muted);">
                        {{ $trx->created_at->format('d M Y • H:i') }} WIB
                    </span>
                    <span class="status-pill {{ $statusClass }}">
                        {{ strtoupper($trx->status) }}
                    </span>
                </div>

                <div>
                    <div style="font-weight: 700; color: #fff; font-size: 14px; margin-bottom: 2px;">
                        {{ $packageLabel }}
                    </div>
                    <div style="font-weight: 800; color: var(--red); font-size: 16px; margin-bottom: 6px;">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </div>
                    
                    <div class="meta-wrap">
                        <span class="meta-tag">#{{ $trx->invoice_code }}</span>
                        <span class="meta-tag">{{ strtoupper($trx->payment_method) }}</span>
                    </div>
                </div>

                <div class="mobile-row" style="margin-top: 4px; justify-content: flex-end;">
                    <button onclick="openTrackingModal('{{ $trx->id }}')" class="detail-btn" style="width: 100%; justify-content: center; padding: 10px;">
                        <i class="fa-solid fa-circle-info"></i> LIHAT DETAIL
                    </button>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    {{-- LOAD MORE --}}
    @if($transactions->count() >= $limit)
    <div class="load-more-wrap">
        <a href="{{ route('member.transactions', ['limit' => $limit + 10]) }}" class="load-more-btn">
            <i class="fa-solid fa-clock-rotate-left"></i> LOAD MORE
        </a>
    </div>
    @endif

    @endif

</div>

@include('member.partials.tracking-modal')
@include('member.partials.reupload-modal')
@include('member.partials.payment-script')

@endsection