@push('styles')
<style>
    /* ============================================================
        HISTORY SECTION
    ============================================================ */
    .history-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 22px;
        align-items: flex-start;
    }

    .history-column {
        background: linear-gradient(180deg,
                rgba(255, 255, 255, .02),
                rgba(255, 255, 255, .01));
        border: 1px solid var(--border);
        border-radius: 20px;
       padding:24px;
min-height:auto;
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
    }

    .history-column::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top right,
                rgba(239, 68, 68, .08),
                transparent 35%);
        pointer-events: none;
    }

    .history-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 26px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        position: relative;
        z-index: 2;
    }

    .history-title i {
        color: var(--red);
        font-size: 18px;
    }

    /* ============================================================
        EMPTY STATE
    ============================================================ */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 50px 20px;
        color: var(--muted);
    }

    .empty-icon-box {
        width: 72px;
        height: 72px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid rgba(255, 255, 255, .06);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 24px;
        color: var(--red);
    }

    .empty-state h5 {
        color: var(--text);
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 13px;
        line-height: 1.7;
        max-width: 260px;
    }

    /* ============================================================
        TABLE
    ============================================================ */
    .history-table {
        width: 100%;
        border-collapse: collapse;
        position: relative;
        z-index: 2;
    }

    .history-table th {
        text-align: left;
        font-size: 10px;
        color: #7b7b7b;
        text-transform: uppercase;
        letter-spacing: .15em;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        font-weight: 800;
    }

    .history-table td {
        padding: 14px 0;
        font-size: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, .04);
        vertical-align: middle;
    }

    .history-table tr:last-child td {
        border-bottom: none;
    }

    .history-table tr {
        transition: .2s ease;
    }

    .history-table tr:hover {
        transform: translateX(2px);
    }
/* ============================================================
    FOOTER
============================================================ */
.history-footer{
    margin-top:20px;
    padding-top:18px;
    border-top:1px solid rgba(255,255,255,.06);
    display:flex;
    justify-content:center;
}

.history-footer a{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:11px 16px;
    border-radius:12px;
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.07);
    color:#ddd;
    text-decoration:none;
    font-size:12px;
    font-weight:700;
    transition:.2s ease;
}

.history-footer a:hover{
    background:rgba(239,68,68,.08);
    border-color:rgba(239,68,68,.18);
    color:#fff;
    transform:translateY(-2px);
}
    /* ============================================================
        STATUS
    ============================================================ */
    .status-pill {
        padding: 5px 11px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
        white-space: nowrap;
        width: fit-content;
    }

    .status-success {
        background: rgba(34, 197, 94, .12);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, .2);
    }

    .status-pending {
        background: rgba(234, 179, 8, .12);
        color: #facc15;
        border: 1px solid rgba(234, 179, 8, .2);
    }

    .status-danger {
        background: rgba(239, 68, 68, .12);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, .2);
    }

    .status-info {
        background: rgba(59, 130, 246, .12);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, .2);
    }

    /* ============================================================
        SMALL TEXT
    ============================================================ */
    .muted-text {
        font-size: 11px;
        color: var(--muted);
        line-height: 1.6;
    }

    .invoice-code {
        font-family: 'Barlow Condensed', monospace;
        color: var(--red);
        font-size: 15px;
        font-weight: 800;
        letter-spacing: .08em;
    }

   .detail-btn {
    padding:8px 12px;
    font-size:10px;
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.08);
    border-radius:10px;
    color:var(--text);
    cursor:pointer;
    font-weight:800;
    display:flex;
    align-items:center;
    gap:6px;
    transition:.2s ease;
    white-space:nowrap;
}

    .detail-btn:hover {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .14);
    }

    .activity-wrap {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    /* ============================================================
        RESPONSIVE
    ============================================================ */
    @media(max-width:950px) {
        .history-grid {
            grid-template-columns: 1fr;
        }
    }

  @media(max-width:768px){

    .history-grid{
        grid-template-columns:1fr;
        gap:16px;
    }

    .history-column{
        padding:18px;
        border-radius:18px;
        overflow-x:auto;
    }

    .history-table{
        min-width:620px;
    }

    .history-title{
        font-size:18px;
        margin-bottom:20px;
    }
}
</style>
@endpush

{{-- =========================================================
    HISTORY GRID
========================================================= --}}
<div class="history-grid">

    {{-- =========================================================
        KOLOM KIRI — AKTIVITAS GYM
    ========================================================= --}}
    <div class="history-column">

        <div class="history-title">
            <i class="fa-solid fa-dumbbell"></i>
            AKTIVITAS MEMBER
        </div>

        @if($activities->isEmpty())

        <div class="empty-state">

            <div class="empty-icon-box">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>

            <h5>BELUM ADA AKTIVITAS</h5>

            <p>
                Aktivitas check-in gym dan penggunaan sesi PT akan tampil di sini.
            </p>

        </div>

        @else

        <table class="history-table">

            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>AKTIVITAS</th>
                    <th>JAM</th>
                </tr>
            </thead>

            <tbody>

                @foreach($activities as $row)

                <tr>

                    {{-- DATE --}}
                    <td style="font-weight:700;">
                        {{ $row->date->format('d M Y') }}
                    </td>

                    {{-- ACTIVITY --}}
                    <td>

                        <div class="activity-wrap">

                            <span class="status-pill {{ $row->badge_class }}">
                                {{ $row->badge }}
                            </span>

                            <div class="muted-text">
                                {{ $row->description }}
                            </div>

                        </div>

                    </td>

                    {{-- TIME --}}
                    <td style="color:var(--muted); font-size:13px;">
                        {{ $row->date->format('H:i') }} WIB
                    </td>

                </tr>


                @endforeach

            </tbody>


        </table>
        <div class="history-footer">
            <a href="{{ route('member.activities') }}">
                Lihat Semua Aktivitas
            </a>
        </div>

        @endif

    </div>

    {{-- =========================================================
        KOLOM KANAN — RIWAYAT PAKET
    ========================================================= --}}
    <div class="history-column">

        <div class="history-title">
            <i class="fa-solid fa-wallet"></i>
            RIWAYAT PAKET
        </div>

        @if($transactions->isEmpty())

        <div class="empty-state">

            <div class="empty-icon-box">
                <i class="fa-solid fa-receipt"></i>
            </div>

            <h5>BELUM ADA TRANSAKSI</h5>

            <p>
                Riwayat pembelian membership dan paket PT akan muncul di sini.
            </p>

        </div>

        @else

        <table class="history-table">

            <thead>
                <tr>
                    <th>INVOICE</th>
                    <th>PAKET</th>
                    <th>TOTAL</th>
                    <th style="text-align:right;">STATUS</th>
                </tr>
            </thead>

            <tbody>

                @foreach($transactions as $trx)

                @php

                $packageLabel = match($trx->category) {

                'activation' => 'Aktivasi Member',

                'monthly' => match((int) $trx->amount) {

                (int) ($settings['bulanan_member'] ?? 0)
                => 'Membership Member',

                (int) ($settings['bulanan_tamu'] ?? 0)
                => 'Membership Tamu',

                default
                => 'Membership Bulanan',
                },

                'pt'
                => $trx->ptPackage->nama_paket ?? 'Paket PT',

                default
                => ucfirst($trx->category),
                };

                $statusClass = match($trx->status) {

                'success'
                => 'status-success',

                'rejected'
                => 'status-danger',

                default
                => 'status-pending',
                };

                @endphp

                <tr>

                    {{-- INVOICE --}}
                    <td>

                        <div class="invoice-code">
                            #{{ $trx->invoice_code }}
                        </div>

                        <div class="muted-text" style="margin-top:5px;">
                            {{ $trx->created_at->format('d M Y • H:i') }}
                        </div>

                    </td>

                    {{-- PACKAGE --}}
                    <td>

                        <div style="font-weight:700; color:var(--text);">
                            {{ $packageLabel }}
                        </div>

                        <div class="muted-text" style="margin-top:5px;">
                            {{ strtoupper($trx->payment_method) }}
                        </div>

                    </td>

                    {{-- TOTAL --}}
                    <td style="font-weight:800; white-space:nowrap;">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>

                    {{-- STATUS --}}
                    <td>

                        <div style="
                                display:flex;
                                justify-content:flex-end;
                                align-items:center;
                                gap:8px;
                            ">

                            <span class="status-pill {{ $statusClass }}">
                                {{ strtoupper($trx->status) }}
                            </span>

                            <button
                                onclick="openTrackingModal('{{ $trx->id }}')"
                                class="detail-btn">

                                <i class="fa-solid fa-circle-info"></i>
                                DETAIL

                            </button>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>
        <div class="history-footer">
            <a href="{{ route('member.transactions') }}">
                Lihat Semua Riwayat
            </a>
        </div>

        @endif

    </div>

</div>

@include('member.partials.tracking-modal')
@include('member.partials.reupload-modal')
@include('member.partials.payment-script')