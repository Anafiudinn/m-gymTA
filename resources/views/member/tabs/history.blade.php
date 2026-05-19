@push('styles')
<style>
    /* ============================================================
        HISTORY SECTION (OPTIMIZED)
    ============================================================ */
    .history-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px; /* Lebih compact dari 22px */
        align-items: flex-start;
    }

    .history-column {
        background: linear-gradient(180deg,
                rgba(255, 255, 255, .02),
                rgba(255, 255, 255, .01));
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px; /* Diperkecil dari 24px agar hemat ruang */
        min-height: auto;
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
    }

    .history-column::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(239, 68, 68, .06), transparent 30%);
        pointer-events: none;
    }

    .history-title {
        display: flex;
        align-items: center;
        gap: 10px;
  font-family: 'Bebas Neue', sans-serif;
        font-size: 18px; /* Lebih proporsional */
        font-weight: 900;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        position: relative;
        z-index: 2;
    }

    .history-title i {
        color: var(--red);
        font-size: 16px;
    }

    /* ============================================================
        TABLE STYLES (DESKTOP ONLY)
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
        letter-spacing: .1em;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        font-weight: 800;
    }

    .history-table td {
        padding: 12px 0; /* Dipersempit agar compact */
        font-size: 13px; /* Sedikit dikecilkan agar pas */
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
        MOBILE CARD LIST (Sembunyi di Desktop)
    ============================================================ */
    .mobile-history-list {
        display: none;
        flex-direction: column;
        gap: 12px;
        position: relative;
        z-index: 2;
    }

    .mobile-history-card {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 12px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .mobile-card-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    /* ============================================================
        COMPONENTS & BADGES
    ============================================================ */
    .status-pill {
        padding: 4px 8px;
        border-radius: 6px; /* Kotak rounded lebih modern & compact dari 999px */
        font-size: 9px;
        font-weight: 900;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
        width: fit-content;
    }

    .status-success { background: rgba(34, 197, 94, .1); color: #22c55e; border: 1px solid rgba(34, 197, 94, .15); }
    .status-pending { background: rgba(234, 179, 8, .1); color: #facc15; border: 1px solid rgba(234, 179, 8, .15); }
    .status-danger  { background: rgba(239, 68, 68, .1); color: #ef4444; border: 1px solid rgba(239, 68, 68, .15); }
    .status-info    { background: rgba(59, 130, 246, .1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, .15); }

    .invoice-code {
        font-family: 'Barlow Condensed', sans-serif;
        color: var(--red);
        font-size: 14px;
        font-weight: 800;
        letter-spacing: .05em;
    }

    .muted-text {
        font-size: 11px;
        color: var(--muted);
        line-height: 1.5;
    }

    .detail-btn {
        padding: 6px 10px;
        font-size: 10px;
        background: rgba(255, 255, 255, .04);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 8px;
        color: var(--text);
        cursor: pointer;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: .2s ease;
    }

    .detail-btn:hover {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .14);
    }

    .history-footer {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, .06);
        display: flex;
        justify-content: center;
    }

    .history-footer a {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .02);
        border: 1px solid rgba(255, 255, 255, .06);
        color: #bbb;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .history-footer a:hover {
        background: rgba(239, 68, 68, .08);
        border-color: rgba(239, 68, 68, .18);
        color: #fff;
        transform: translateY(-1px);
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 16px;
        color: var(--muted);
    }

    .empty-icon-box {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, .02);
        border: 1px solid rgba(255, 255, 255, .05);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        font-size: 20px;
        color: var(--red);
    }

    .empty-state h5 {
        color: var(--text);
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 12px;
        line-height: 1.6;
        max-width: 240px;
    }

    /* ============================================================
        RESPONSIVE BREAKPOINTS
    ============================================================ */
    @media(max-width: 1024px) {
        .history-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    @media(max-width: 768px) {
        .history-column {
            padding: 16px;
        }
        
        /* SEMBUNYIKAN TABEL DI HP */
        .history-table {
            display: none;
        }

        /* TAMPILKAN MODE CARD DI HP */
        .mobile-history-list {
            display: flex;
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
            <p>Aktivitas check-in gym dan penggunaan sesi PT akan tampil di sini.</p>
        </div>
        @else

        {{-- Desktop Table View --}}
        <table class="history-table">
            <thead>
                <tr>
                    <th style="width: 25%;">TANGGAL</th>
                    <th style="width: 55%;">AKTIVITAS</th>
                    <th style="width: 20%; text-align: right;">JAM</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $row)
                <tr>
                    <td style="font-weight:700;">{{ $row->date->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <span class="status-pill {{ $row->badge_class }}">{{ $row->badge }}</span>
                            <div class="muted-text">{{ $row->description }}</div>
                        </div>
                    </td>
                    <td style="color:var(--muted); font-size:12px; text-align: right;">
                        {{ $row->date->format('H:i') }} WIB
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Mobile Card View --}}
        <div class="mobile-history-list">
            @foreach($activities as $row)
            <div class="mobile-history-card">
                <div class="mobile-card-row">
                    <span style="font-weight: 700; font-size: 13px;">{{ $row->date->format('d M Y') }}</span>
                    <span class="muted-text" style="font-size: 12px;">{{ $row->date->format('H:i') }} WIB</span>
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <span class="status-pill {{ $row->badge_class }}">{{ $row->badge }}</span>
                    <div class="muted-text">{{ $row->description }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="history-footer">
            <a href="{{ route('member.activities') }}">Lihat Semua Aktivitas</a>
        </div>
        @endif
    </div>

    {{-- =========================================================
        KOLOM KAIAN — RIWAYAT PAKET
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
            <p>Riwayat pembelian membership dan paket PT akan muncul di sini.</p>
        </div>
        @else

        {{-- Desktop Table View --}}
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
                            (int) ($settings['bulanan_member'] ?? 0) => 'Membership Member',
                            (int) ($settings['bulanan_tamu'] ?? 0) => 'Membership Tamu',
                            default => 'Membership Bulanan',
                        },
                        'pt' => $trx->ptPackage->nama_paket ?? 'Paket PT',
                        default => ucfirst($trx->category),
                    };

                    $statusClass = match($trx->status) {
                        'success' => 'status-success',
                        'rejected' => 'status-danger',
                        default => 'status-pending',
                    };
                @endphp
                <tr>
                    <td>
                        <div class="invoice-code">#{{ $trx->invoice_code }}</div>
                        <div class="muted-text" style="margin-top:2px;">
                            {{ $trx->created_at->format('d M Y • H:i') }}
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:700; color:var(--text);">{{ $packageLabel }}</div>
                        <div class="muted-text" style="margin-top:2px;">
                            {{ strtoupper($trx->payment_method) }}
                        </div>
                    </td>
                    <td style="font-weight:800; white-space:nowrap;">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                    <td>
                        <div style="display:flex; justify-content:flex-end; align-items:center; gap:6px;">
                            <span class="status-pill {{ $statusClass }}">{{ strtoupper($trx->status) }}</span>
                            <button onclick="openTrackingModal('{{ $trx->id }}')" class="detail-btn">
                                <i class="fa-solid fa-circle-info"></i> DETAIL
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Mobile Card View --}}
        <div class="mobile-history-list">
            @foreach($transactions as $trx)
            @php
                $packageLabel = match($trx->category) {
                    'activation' => 'Aktivasi Member',
                    'monthly' => match((int) $trx->amount) {
                        (int) ($settings['bulanan_member'] ?? 0) => 'Membership Member',
                        (int) ($settings['bulanan_tamu'] ?? 0) => 'Membership Tamu',
                        default => 'Membership Bulanan',
                    },
                    'pt' => $trx->ptPackage->nama_paket ?? 'Paket PT',
                    default => ucfirst($trx->category),
                };

                $statusClass = match($trx->status) {
                    'success' => 'status-success',
                    'rejected' => 'status-danger',
                    default => 'status-pending',
                };
            @endphp
            <div class="mobile-history-card">
                <div class="mobile-card-row">
                    <div class="invoice-code">#{{ $trx->invoice_code }}</div>
                    <span class="status-pill {{ $statusClass }}">{{ strtoupper($trx->status) }}</span>
                </div>
                
                <div class="mobile-card-row" style="align-items: flex-start;">
                    <div>
                        <div style="font-weight:700; color:var(--text); font-size: 13px;">{{ $packageLabel }}</div>
                        <div class="muted-text">{{ strtoupper($trx->payment_method) }} • {{ $trx->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight:800; color: var(--text); font-size: 13px;">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 2px;">
                    <button onclick="openTrackingModal('{{ $trx->id }}')" class="detail-btn" style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-circle-info"></i> LIHAT DETAIL TRACKING
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="history-footer">
            <a href="{{ route('member.transactions') }}">Lihat Semua Riwayat</a>
        </div>
        @endif
    </div>

</div>

@include('member.partials.tracking-modal')
@include('member.partials.reupload-modal')
@include('member.partials.payment-script')