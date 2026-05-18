@extends('layouts.member')

@section('content')

<style>
    :root{
        --bg:#0b0b0b;
        --bg2:#121212;
        --border:rgba(255,255,255,.06);
        --text:#f5f5f5;
        --muted:#8b8b8b;
        --red:#ef4444;
    }

    .transaction-page{
        padding:32px;
    }

    /* =========================================================
        HEADER
    ========================================================= */
    .transaction-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:20px;
        margin-bottom:32px;
        flex-wrap:wrap;
    }

    .transaction-title h1{
        margin:0;
        color:#fff;
        font-size:36px;
        font-weight:900;
        letter-spacing:-.03em;
    }

    .transaction-title p{
        margin-top:10px;
        color:var(--muted);
        font-size:14px;
        line-height:1.7;
        max-width:640px;
    }

    .back-btn{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:12px 18px;
        border-radius:14px;
        background:rgba(255,255,255,.04);
        border:1px solid var(--border);
        color:#fff;
        text-decoration:none;
        font-size:13px;
        font-weight:700;
        transition:.2s;
    }

    .back-btn:hover{
        background:rgba(255,255,255,.07);
    }

    /* =========================================================
        EMPTY
    ========================================================= */
    .empty-state{
        background:var(--bg2);
        border:1px solid var(--border);
        border-radius:24px;
        padding:80px 24px;
        text-align:center;
    }

    .empty-icon{
        width:82px;
        height:82px;
        margin:auto;
        border-radius:24px;
        background:rgba(255,255,255,.04);
        border:1px solid var(--border);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:30px;
        color:#666;
        margin-bottom:24px;
    }

    .empty-state h3{
        color:#fff;
        margin-bottom:10px;
        font-size:24px;
        font-weight:800;
    }

    .empty-state p{
        color:var(--muted);
        max-width:420px;
        margin:auto;
        line-height:1.8;
        font-size:14px;
    }

    /* =========================================================
        TIMELINE
    ========================================================= */
    .timeline{
        position:relative;
        padding-left:28px;
    }

    .timeline::before{
        content:'';
        position:absolute;
        left:8px;
        top:0;
        bottom:0;
        width:2px;
        background:rgba(255,255,255,.06);
    }

    .timeline-item{
        position:relative;
        margin-bottom:24px;
    }

    .timeline-dot{
        position:absolute;
        left:-24px;
        top:24px;
        width:16px;
        height:16px;
        border-radius:50%;
        background:var(--red);
        border:3px solid #0b0b0b;
        z-index:2;
    }

    .timeline-card{
        background:var(--bg2);
        border:1px solid var(--border);
        border-radius:22px;
        padding:24px;
        transition:.2s;
    }

    .timeline-card:hover{
        transform:translateY(-2px);
        border-color:rgba(255,255,255,.12);
    }

    .timeline-top{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:20px;
        margin-bottom:18px;
        flex-wrap:wrap;
    }

    .timeline-date{
        color:var(--muted);
        font-size:12px;
    }

    /* =========================================================
        BADGE
    ========================================================= */
    .timeline-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:8px 14px;
        border-radius:999px;
        font-size:11px;
        font-weight:800;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .status-success{
        background:rgba(34,197,94,.12);
        color:#22c55e;
        border:1px solid rgba(34,197,94,.2);
    }

    .status-pending{
        background:rgba(234,179,8,.12);
        color:#eab308;
        border:1px solid rgba(234,179,8,.2);
    }

    .status-danger{
        background:rgba(239,68,68,.12);
        color:#ef4444;
        border:1px solid rgba(239,68,68,.2);
    }

    /* =========================================================
        CONTENT
    ========================================================= */
    .trx-package{
        font-size:22px;
        color:#fff;
        font-weight:800;
        margin-bottom:10px;
    }

    .trx-price{
        color:var(--red);
        font-size:32px;
        font-weight:900;
        margin-bottom:16px;
    }

    .trx-meta{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-bottom:18px;
    }

    .trx-meta span{
        padding:8px 12px;
        border-radius:10px;
        background:rgba(255,255,255,.04);
        border:1px solid var(--border);
        color:var(--muted);
        font-size:12px;
    }

    .trx-action{
        display:flex;
        justify-content:flex-end;
    }

    .detail-btn{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:12px 16px;
        border:none;
        border-radius:12px;
        background:#1b1b1b;
        border:1px solid var(--border);
        color:#fff;
        cursor:pointer;
        font-size:12px;
        font-weight:700;
        transition:.2s;
    }

    .detail-btn:hover{
        background:#222;
    }

    /* =========================================================
        LOAD MORE
    ========================================================= */
    .load-more-wrap{
        margin-top:32px;
        text-align:center;
    }

    .load-more-btn{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:14px 22px;
        border-radius:14px;
        background:rgba(255,255,255,.04);
        border:1px solid var(--border);
        color:#fff;
        text-decoration:none;
        font-size:13px;
        font-weight:800;
        transition:.2s;
    }

    .load-more-btn:hover{
        background:rgba(255,255,255,.07);
    }

    /* =========================================================
        MOBILE
    ========================================================= */
    @media(max-width:768px){

        .transaction-page{
            padding:20px;
        }

        .transaction-title h1{
            font-size:28px;
        }

        .trx-package{
            font-size:18px;
        }

        .trx-price{
            font-size:26px;
        }

        .timeline{
            padding-left:22px;
        }

        .timeline-dot{
            left:-18px;
        }

    }
</style>

<div class="transaction-page">

    {{-- HEADER --}}
    <div class="transaction-header">

        <div class="transaction-title">

            <h1>Riwayat Paket</h1>

            <p>
                Riwayat lengkap pembelian aktivasi member, membership bulanan,
                dan personal trainer kamu.
            </p>

        </div>

        <a href="{{ route('member.dashboard', ['tab' => 'history']) }}"
           class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Dashboard

        </a>

    </div>

    {{-- EMPTY --}}
    @if($transactions->isEmpty())

    <div class="empty-state">

        <div class="empty-icon">
            <i class="fa-solid fa-wallet"></i>
        </div>

        <h3>Belum Ada Riwayat Paket</h3>

        <p>
            Setelah membeli membership atau paket PT,
            riwayat transaksi akan muncul di halaman ini.
        </p>

    </div>

    @else

    {{-- TIMELINE --}}
    <div class="timeline">

        @foreach($transactions as $trx)

        @php

        $packageLabel = match($trx->category) {

            'activation' => 'Aktivasi Member',

            'monthly' => match((int) $trx->amount) {

                (int) ($settings['bulanan_member'] ?? 0)
                    => 'Membership Member',

                (int) ($settings['bulanan_tamu'] ?? 0)
                    => 'Membership Guest',

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

        <div class="timeline-item">

            <div class="timeline-dot"></div>

            <div class="timeline-card">

                {{-- TOP --}}
                <div class="timeline-top">

                    <span class="timeline-badge {{ $statusClass }}">

                        <i class="fa-solid fa-bolt"></i>

                        {{ strtoupper($trx->status) }}

                    </span>

                    <div class="timeline-date">
                        {{ $trx->created_at->format('d M Y • H:i') }} WIB
                    </div>

                </div>

                {{-- PACKAGE --}}
                <div class="trx-package">
                    {{ $packageLabel }}
                </div>

                {{-- PRICE --}}
                <div class="trx-price">
                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                </div>

                {{-- META --}}
                <div class="trx-meta">

                    <span>
                        <i class="fa-solid fa-receipt"></i>
                        #{{ $trx->invoice_code }}
                    </span>

                    <span>
                        <i class="fa-solid fa-credit-card"></i>
                        {{ strtoupper($trx->payment_method) }}
                    </span>

                    <span>
                        <i class="fa-solid fa-globe"></i>
                        {{ strtoupper($trx->source) }}
                    </span>

                </div>

                {{-- ACTION --}}
                <div class="trx-action">

                    <button
                        onclick="openTrackingModal('{{ $trx->id }}')"
                        class="detail-btn">

                        <i class="fa-solid fa-circle-info"></i>
                        LIHAT DETAIL

                    </button>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    {{-- LOAD MORE --}}
    @if($transactions->count() >= $limit)

    <div class="load-more-wrap">

        <a href="{{ route('member.transactions', ['limit' => $limit + 10]) }}"
           class="load-more-btn">

            <i class="fa-solid fa-clock-rotate-left"></i>
            LOAD MORE

        </a>

    </div>

    @endif

    @endif

</div>

@include('member.partials.tracking-modal')
@include('member.partials.reupload-modal')
@include('member.partials.payment-script')

@endsection