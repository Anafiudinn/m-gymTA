@push('styles')
<style>
    /* ============================================================
   HISTORY SECTION
============================================================ */
    .history-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        align-items: flex-start;
    }

    .history-column {
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 28px;
        min-height: 420px;
    }

    .history-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 18px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 28px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border);
    }

    .history-title i {
        color: var(--red);
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
        padding: 40px 20px;
        color: var(--muted);
    }

    .empty-icon-box {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid var(--border);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 22px;
        color: var(--muted);
    }

    .empty-state h5 {
        color: var(--text);
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 13px;
        line-height: 1.65;
        max-width: 240px;
    }

    /* ============================================================
   TABLE
============================================================ */
    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table th {
        text-align: left;
        font-size: 11px;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .1em;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border);
        font-weight: 700;
    }

    .history-table td {
        padding: 14px 0;
        font-size: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, .03);
        vertical-align: middle;
    }

    .history-table tr:last-child td {
        border-bottom: none;
    }

    .history-table tr:hover td {
        background: rgba(255, 255, 255, .01);
    }

    /* Status pills */
    .status-pill {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .status-success {
        background: rgba(34, 197, 94, .1);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, .2);
    }

    .status-pending {
        background: rgba(234, 179, 8, .1);
        color: #eab308;
        border: 1px solid rgba(234, 179, 8, .2);
    }

    /* Invoice code */
    .invoice-code {
        font-family: 'Barlow Condensed', monospace;
        color: var(--red);
        font-weight: 700;
        letter-spacing: .05em;
    }

    /* ============================================================
   RESPONSIVE
============================================================ */
    @media (max-width: 768px) {
        .history-grid {
            grid-template-columns: 1fr;
        }

        .history-table th:nth-child(3),
        .history-table td:nth-child(3) {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .history-column {
            padding: 20px;
        }
    }
</style>
@endpush

<div class="history-grid">

    {{-- KOLOM KIRI: RIWAYAT KUNJUNGAN --}}
    <div class="history-column">
        <div class="history-title">
            <i class="fa-solid fa-clock-rotate-left"></i> RIWAYAT KUNJUNGAN
        </div>

        @if($attendances->isEmpty())
        <div class="empty-state">
            <div class="empty-icon-box">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <h5>BELUM ADA KUNJUNGAN</h5>
            <p>Riwayat check-in kamu akan muncul di sini setelah aktivasi & datang ke gym.</p>
        </div>
        @else
        <table class="history-table">
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>TIPE</th>
                    <th>JAM</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $row)
                <tr>
                    <td style="font-weight: 600;">{{ $row->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="status-pill status-success">
                            {{ strtoupper(str_replace('_', ' ', $row->type)) }}
                        </span>
                    </td>
                    <td style="color: var(--muted);">{{ $row->created_at->format('H:i') }} WIB</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- KOLOM KANAN: RIWAYAT PEMBAYARAN --}}
    <div class="history-column">
        <div class="history-title">
            <i class="fa-solid fa-money-bill-transfer"></i> RIWAYAT PEMBAYARAN
        </div>

        @if($transactions->isEmpty())
        <div class="empty-state">
            <div class="empty-icon-box">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <h5>BELUM ADA PEMBAYARAN</h5>
            <p>Setelah kamu beli paket atau aktivasi, transaksi akan tercatat di sini.</p>
        </div>
        @else
        <table class="history-table">
            <thead>
                <tr>
                    <th>INVOICE</th>
                    <th>KATEGORI</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            {{-- Ganti bagian <tbody> pada Riwayat Pembayaran --}}
            <tbody>
                @foreach($transactions as $trx)
                <tr style="border-bottom: 1px solid var(--border);">
                    <td>
                        <span class="invoice-code">#{{ $trx->invoice_code }}</span>
                        <div style="font-size: 10px; color: var(--muted);">{{ $trx->created_at->format('d/m/y H:i') }}</div>
                    </td>
                    <td style="text-transform: capitalize; color: var(--muted);">{{ $trx->category }}</td>
                    <td style="font-weight: 700;">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td>
                        {{-- Status Pill --}}
                        @php
                        $statusClass = match($trx->status) {
                        'success' => 'status-success',
                        'rejected' => 'status-danger',
                        default => 'status-pending'
                        };
                        @endphp

                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <span class="status-pill {{ $statusClass }}" style="text-align: center;">
                                {{ strtoupper($trx->status) }}
                            </span>

                            {{-- Tombol View More / Detail --}}
                            <button onclick="openTrackingModal('{{ $trx->id }}')"
                                style="padding: 5px 10px; font-size: 10px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 6px; color: var(--text); cursor: pointer; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                <i class="fa-solid fa-circle-info"></i> LIHAT DETAIL
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>


@include('member.partials.tracking-modal')
@include('member.partials.reupload-modal')
@include('member.partials.payment-script')