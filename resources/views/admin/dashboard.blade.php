@extends('layouts.admin')

@section('header-title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

    /* ─── PAGE TOKENS (inherits layout CSS vars) ─── */

    .dash-section-label {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #bbb;
        margin-bottom: 14px;
    }

    /* ─── STAT CARDS ─── */

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    @media(max-width: 1100px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media(max-width: 560px) {
        .stat-grid { grid-template-columns: 1fr; }
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 1px;
        padding: 20px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
        transition: .18s ease;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: var(--accent-color, var(--red));
        opacity: 0;
        transition: .18s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(0,0,0,.09);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .stat-badge {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #ccc;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
        letter-spacing: -.02em;
    }

    .stat-label {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
        font-weight: 500;
    }

    /* ─── ICON COLOR VARIANTS ─── */

    .ic-red   { background: rgba(239,68,68,.10);  color: #ef4444; }
    .ic-green { background: rgba(34,197,94,.10);  color: #16a34a; }
    .ic-amber { background: rgba(245,158,11,.10); color: #d97706; }
    .ic-blue  { background: rgba(59,130,246,.10); color: #2563eb; }

    /* ─── MAIN ROW ─── */

    .main-row {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 14px;
        margin-bottom: 24px;
    }

    @media(max-width: 1100px) {
        .main-row { grid-template-columns: 1fr; }
    }

    /* ─── PANEL (card wrapper) ─── */

    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 1px;
        box-shadow: var(--shadow);
        padding: 22px;
    }

    .panel-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 4px;
    }

    .panel-sub {
        font-size: 11px;
        color: #aaa;
        font-weight: 500;
    }

    .panel-header {
        margin-bottom: 20px;
    }

    /* ─── SIDE COLUMN ─── */

    .side-col {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* ─── STATS LIST ─── */

    .stats-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .stats-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
    }

    .stats-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .stats-row:first-child {
        padding-top: 0;
    }

    .stats-row-label {
        font-size: 12px;
        color: #888;
        font-weight: 500;
    }

    .stats-row-value {
        font-size: 14px;
        font-weight: 800;
        color: var(--text);
    }

    /* ─── LOW STOCK ITEMS ─── */

    .stock-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
    }

    .stock-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .stock-item:first-child {
        padding-top: 0;
    }

    .stock-name {
        font-size: 12px;
        font-weight: 700;
        color: var(--text);
    }

    .stock-sub {
        font-size: 11px;
        color: #aaa;
        margin-top: 2px;
    }

    .stock-badge {
        font-size: 10px;
        font-weight: 800;
        padding: 3px 9px;
        border-radius: 1px;
        background: rgba(239,68,68,.10);
        color: var(--red);
        white-space: nowrap;
    }

    /* ─── BOTTOM ROW ─── */

    .bottom-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media(max-width: 900px) {
        .bottom-row { grid-template-columns: 1fr; }
    }

    /* ─── TRX LIST ─── */

    .trx-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
    }

    .trx-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .trx-item:first-child {
        padding-top: 0;
    }

    .trx-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
    }

    .trx-cat {
        font-size: 10px;
        color: #aaa;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-top: 2px;
    }

    .trx-amount {
        font-size: 13px;
        font-weight: 800;
        color: var(--text);
        text-align: right;
    }

    .trx-status {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 1px;
        margin-top: 3px;
    }

    .trx-status.success {
        background: rgba(34,197,94,.10);
        color: #15803d;
    }

    .trx-status.pending {
        background: rgba(245,158,11,.10);
        color: #b45309;
    }

    /* ─── ATTENDANCE LIST ─── */

    .att-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
    }

    .att-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .att-item:first-child {
        padding-top: 0;
    }

    .att-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
    }

    .att-time {
        font-size: 11px;
        color: #aaa;
        margin-top: 2px;
    }

    .att-badge {
        font-size: 10px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 1px;
        background: rgba(239,68,68,.10);
        color: var(--red);
        white-space: nowrap;
    }

    /* ─── GREETING HEADER ─── */

    .dash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .dash-greeting {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.02em;
    }

    .dash-greeting span {
        color: var(--red);
    }

    .dash-greeting-sub {
        font-size: 12px;
        color: #aaa;
        font-weight: 500;
        margin-top: 4px;
    }

    .date-chip {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 1px;
        padding: 10px 16px;
        box-shadow: var(--shadow);
        flex-shrink: 0;
    }

    .date-chip-label {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #ccc;
        margin-bottom: 3px;
    }

    .date-chip-value {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
    }

    /* ─── CHART OVERRIDES ─── */

    #incomeChart {
        max-height: 200px;
    }

    /* ─── EMPTY STATE ─── */

    .empty-state {
        font-size: 12px;
        color: #bbb;
        font-weight: 500;
        padding: 8px 0;
    }

</style>

<div>

    {{-- GREETING HEADER --}}
    <div class="dash-header">
        <div>
            <div class="dash-greeting">
                Halo, <span>{{ explode(' ', auth()->user()->name)[0] }}</span> 👋
            </div>
            <div class="dash-greeting-sub">
                Ringkasan aktivitas gym hari ini
            </div>
        </div>

        <div class="date-chip">
            <div class="date-chip-label">Hari Ini</div>
            <div class="date-chip-value">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-grid">

        {{-- CHECK-IN --}}
        <div class="stat-card" style="--accent-color:#2563eb">
            <div class="stat-top">
                <div class="stat-icon ic-blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="stat-badge">Check-in</span>
            </div>
            <div class="stat-number">{{ $todayAttendance }}</div>
            <div class="stat-label">Orang masuk hari ini</div>
        </div>

        {{-- OMZET --}}
        <div class="stat-card" style="--accent-color:#16a34a">
            <div class="stat-top">
                <div class="stat-icon ic-green">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <span class="stat-badge">Omzet</span>
            </div>
            <div class="stat-number" style="font-size:22px;letter-spacing:-.01em">
                Rp {{ number_format($todayOmzet, 0, ',', '.') }}
            </div>
            <div class="stat-label">Pemasukan hari ini</div>
        </div>

        {{-- PENDING --}}
        <div class="stat-card" style="--accent-color:#d97706">
            <div class="stat-top">
                <div class="stat-icon ic-amber">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <span class="stat-badge">Pending</span>
            </div>
            <div class="stat-number">{{ $pendingVerifications }}</div>
            <div class="stat-label">Menunggu verifikasi</div>
        </div>

        {{-- PT AKTIF --}}
        <div class="stat-card" style="--accent-color:#ef4444">
            <div class="stat-top">
                <div class="stat-icon ic-red">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
                <span class="stat-badge">PT Aktif</span>
            </div>
            <div class="stat-number">{{ $activePT }}</div>
            <div class="stat-label">Membership PT aktif</div>
        </div>

    </div>

    {{-- CHART + SIDE --}}
    <div class="main-row">

        {{-- CHART --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Grafik Pemasukan</div>
                <div class="panel-sub">7 hari terakhir</div>
            </div>
            <canvas id="incomeChart"></canvas>
        </div>

        {{-- SIDE COLUMN --}}
        <div class="side-col">

            {{-- MEMBER STATS --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Statistik Member</div>
                </div>
                <div class="stats-list">
                    <div class="stats-row">
                        <span class="stats-row-label">Member Aktif</span>
                        <span class="stats-row-value">{{ $activeMembers }}</span>
                    </div>
                    <div class="stats-row">
                        <span class="stats-row-label">Paket Aktif</span>
                        <span class="stats-row-value">{{ $activeMemberships }}</span>
                    </div>
                    <div class="stats-row">
                        <span class="stats-row-label">Transaksi Hari Ini</span>
                        <span class="stats-row-value">{{ $todayTransactions }}</span>
                    </div>
                </div>
            </div>

            {{-- LOW STOCK --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Stok Menipis</div>
                </div>
                <div>
                    @forelse($lowStockProducts as $product)
                        <div class="stock-item">
                            <div>
                                <div class="stock-name">{{ $product->nama_produk }}</div>
                                <div class="stock-sub">Hampir habis</div>
                            </div>
                            <span class="stock-badge">{{ $product->stok }} pcs</span>
                        </div>
                    @empty
                        <p class="empty-state">Semua stok aman ✅</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- BOTTOM TABLES --}}
    <div class="bottom-row">

        {{-- TRANSAKSI TERBARU --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Transaksi Terbaru</div>
            </div>
            <div>
                @foreach($recentTransactions as $trx)
                    <div class="trx-item">
                        <div>
                            <div class="trx-name">
                                {{ $trx->user->name ?? $trx->guest_name }}
                            </div>
                            <div class="trx-cat">{{ $trx->category_label }}</div>
                        </div>
                        <div class="trx-amount">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            <br>
                            <span class="trx-status {{ $trx->status == 'success' ? 'success' : 'pending' }}">
                                {{ $trx->status_label }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CHECK-IN TERBARU --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Check-in Terbaru</div>
            </div>
            <div>
                @foreach($recentAttendances as $attendance)
                    <div class="att-item">
                        <div>
                            <div class="att-name">
                                {{ $attendance->user->name ?? $attendance->guest_name }}
                            </div>
                            <div class="att-time">
                                {{ $attendance->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <span class="att-badge">{{ $attendance->type_label }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- CHART SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('incomeChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Omzet',
                data: @json($chartData),
                tension: 0.45,
                fill: true,
                borderColor: '#ef4444',
                borderWidth: 2,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const { ctx: c, chartArea } = chart;
                    if (!chartArea) return 'rgba(239,68,68,0)';
                    const gradient = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    gradient.addColorStop(0, 'rgba(239,68,68,0.15)');
                    gradient.addColorStop(1, 'rgba(239,68,68,0.00)');
                    return gradient;
                },
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    borderColor: 'rgba(0,0,0,.08)',
                    borderWidth: 1,
                    titleColor: '#111',
                    bodyColor: '#666',
                    padding: 10,
                    titleFont: { family: 'Outfit', weight: '700', size: 12 },
                    bodyFont: { family: 'Outfit', size: 12 },
                    callbacks: {
                        label: function(context) {
                            return ' Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: '#aaa',
                        font: { family: 'Outfit', size: 11, weight: '600' }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0,0,0,.05)',
                        drawBorder: false
                    },
                    border: { display: false, dash: [4,4] },
                    ticks: {
                        color: '#aaa',
                        font: { family: 'Outfit', size: 11, weight: '600' },
                        callback: function(val) {
                            if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'jt';
                            if (val >= 1000) return 'Rp ' + (val/1000).toFixed(0) + 'rb';
                            return 'Rp ' + val;
                        }
                    }
                }
            }
        }
    });

});
</script>

@endsection