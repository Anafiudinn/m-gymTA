@extends('layouts.owner')

@section('title', 'Dashboard Owner')
@section('header-title', 'Dashboard')

@section('content')

{{-- Chart.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<style>
    /* ── STAT CARDS ── */
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 1px;
        padding: 22px;
        box-shadow: var(--shadow);
        transition: .22s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(0,0,0,.10);
    }

    /* ── SECTION CARD ── */
    .section-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 1px;
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    .section-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface-2);
    }
    .section-header-icon {
        width: 32px; height: 32px;
        border-radius: 1px;
        background: rgba(239,68,68,.10);
        color: var(--red);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }
    .section-title {
        font-size: .88rem;
        font-weight: 800;
        color: var(--text);
    }

    /* ── QUICK LINK ── */
    .quick-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        border-radius: 1px;
        background: var(--surface-2);
        text-decoration: none;
        color: var(--text);
        border: 1px solid var(--border);
        transition: .18s ease;
        font-weight: 600;
        font-size: .85rem;
    }
    .quick-link:hover {
        background: rgba(239,68,68,.06);
        border-color: rgba(239,68,68,.25);
        color: var(--red);
        transform: translateX(3px);
    }
    .badge-pending {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
        background: rgba(239,68,68,.10);
        color: var(--red);
    }

    /* ── TX ROW ── */
    .tx-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 20px;
        border-bottom: 1px solid var(--border);
        transition: .15s;
        gap: 10px;
    }
    .tx-row:last-child { border-bottom: none; }
    .tx-row:hover { background: var(--surface-2); }
    .tx-name {
        font-size: .83rem;
        font-weight: 700;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }
    .tx-meta {
        font-size: .72rem;
        color: var(--muted);
        text-transform: capitalize;
        white-space: nowrap;
    }

    /* ── ANIMATION ── */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-value { animation: countUp .45s ease both; }

    /* ══════════════════════════════════════════
       RESPONSIVE GRID SYSTEM
    ══════════════════════════════════════════ */

    /* Stat cards */
    .grid-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    /* Chart row */
    .grid-charts {
        display: grid;
        grid-template-columns: 1.55fr 1fr;
        gap: 20px;
        align-items: start;
    }

    /* Bottom row */
    .grid-bottom {
        display: grid;
        grid-template-columns: 1.55fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .col-right {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* Banner */
    .banner-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    /* Donut layout */
    .donut-wrap {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* ── 1280px ── */
    @media (max-width: 1280px) {
        .grid-charts,
        .grid-bottom {
            grid-template-columns: 1.3fr 1fr;
        }
    }

    /* ── 1024px: chart & bottom stack ── */
    @media (max-width: 1024px) {
        .grid-stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .grid-charts,
        .grid-bottom {
            grid-template-columns: 1fr;
        }
        .donut-wrap {
            flex-direction: row;
            align-items: center;
        }
        .donut-canvas-wrap {
            flex-shrink: 0;
            width: 160px;
        }
        .donut-legend {
            flex: 1;
        }
        .tx-name { max-width: 200px; }
    }

    /* ── 768px ── */
    @media (max-width: 768px) {
        .banner-inner {
            flex-direction: column;
            align-items: flex-start;
        }
        .banner-right {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,.10);
            border-radius: 14px;
            padding: 10px 16px;
        }
        .banner-num { font-size: 1.6rem !important; }
        .grid-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .stat-card { padding: 16px 18px; border-radius: 18px; }
        .stat-value { font-size: 1.15rem !important; }
        .donut-wrap { flex-direction: column; }
        .donut-canvas-wrap { width: auto; }
        .tx-name { max-width: 120px; }
    }

    /* ── 520px: 1-col stats, horizontal card layout ── */
    @media (max-width: 520px) {
        .grid-stats {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .stat-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 16px;
            padding: 14px 16px;
            border-radius: 16px;
        }
        .stat-icon { margin-bottom: 0 !important; flex-shrink: 0; }
        .stat-card::before { display: none; }
        .grid-charts, .grid-bottom { gap: 12px; }
        .section-header { padding: 12px 14px; }
        .tx-row { padding: 10px 14px; }
        .tx-name { max-width: 90px; }
        .section-card { border-radius: 1px; }
        .col-right { gap: 12px; }
    }
</style>

<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- =============================================
         GREETING BANNER
    ============================================= --}}
    <div style="
        background: linear-gradient(135deg, var(--red), #991b1b);
        border-radius: 1px;
        padding: 24px 28px;
        box-shadow: 0 8px 28px rgba(239,68,68,.28);
        overflow: hidden;
        position: relative;
    ">
        <div style="position:absolute;right:-20px;top:-20px;width:160px;height:160px;border-radius:999px;background:rgba(255,255,255,.06);pointer-events:none;"></div>
        <div style="position:absolute;right:60px;bottom:-40px;width:100px;height:100px;border-radius:999px;background:rgba(255,255,255,.04);pointer-events:none;"></div>

        <div class="banner-inner">
            <div>
                <div style="font-size:.72rem;font-weight:700;color:rgba(255,255,255,.65);letter-spacing:.1em;text-transform:uppercase;margin-bottom:6px;">
                    Selamat datang kembali
                </div>
                <div style="font-size:1.35rem;font-weight:800;color:#fff;margin-bottom:4px;">
                    {{ Auth::user()->name }} 👋
                </div>
                <div style="font-size:.8rem;color:rgba(255,255,255,.68);">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <div class="banner-right" style="z-index:1;text-align:right;">
                <div style="font-size:.7rem;color:rgba(255,255,255,.6);font-weight:700;margin-bottom:2px;">
                    KEHADIRAN HARI INI
                </div>
                <div class="banner-num" style="font-size:2.4rem;font-weight:800;color:#fff;line-height:1;">
                    {{ $attendanceToday }}
                </div>
                <div style="font-size:.7rem;color:rgba(255,255,255,.6);">pengunjung</div>
            </div>
        </div>
    </div>

    {{-- =============================================
         STAT CARDS
    ============================================= --}}
    <div class="grid-stats">

        <div class="stat-card">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;border-radius:0 22px 0 80px;background:#2563eb;opacity:.07;"></div>
            <div class="stat-icon" style="width:44px;height:44px;border-radius:1px;background:#dbeafe;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:14px;flex-shrink:0;">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <div style="font-size:.68rem;font-weight:800;color:var(--muted);letter-spacing:.08em;text-transform:uppercase;margin-bottom:5px;">Omzet Hari Ini</div>
                <div class="stat-value" style="font-size:1.3rem;font-weight:800;color:var(--text);line-height:1.2;">
                    Rp {{ number_format($incomeToday, 0, ',', '.') }}
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-top:5px;">{{ $transactionsToday }} transaksi</div>
            </div>
        </div>

        <div class="stat-card">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;border-radius:0 22px 0 80px;background:#16a34a;opacity:.07;"></div>
            <div class="stat-icon" style="width:44px;height:44px;border-radius:1px;background:#dcfce7;color:#16a34a;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:14px;flex-shrink:0;">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <div style="font-size:.68rem;font-weight:800;color:var(--muted);letter-spacing:.08em;text-transform:uppercase;margin-bottom:5px;">Omzet Bulan Ini</div>
                <div class="stat-value" style="font-size:1.3rem;font-weight:800;color:var(--text);line-height:1.2;">
                    Rp {{ number_format($incomeMonth, 0, ',', '.') }}
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-top:5px;">{{ now()->translatedFormat('F Y') }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;border-radius:0 22px 0 80px;background:#7c3aed;opacity:.07;"></div>
            <div class="stat-icon" style="width:44px;height:44px;border-radius:1px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:14px;flex-shrink:0;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div style="font-size:.68rem;font-weight:800;color:var(--muted);letter-spacing:.08em;text-transform:uppercase;margin-bottom:5px;">Member Aktif</div>
                <div class="stat-value" style="font-size:1.3rem;font-weight:800;color:var(--text);line-height:1.2;">
                    {{ $activeMembers }}
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-top:5px;">dari {{ $totalMembers }} total</div>
            </div>
        </div>

        <div class="stat-card">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;border-radius:0 22px 0 80px;background:#d97706;opacity:.07;"></div>
            <div class="stat-icon" style="width:44px;height:44px;border-radius:1px;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:14px;flex-shrink:0;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div style="font-size:.68rem;font-weight:800;color:var(--muted);letter-spacing:.08em;text-transform:uppercase;margin-bottom:5px;">Pending Verifikasi</div>
                <div class="stat-value" style="font-size:1.3rem;font-weight:800;color:var(--text);line-height:1.2;">
                    {{ $pendingVerifications }}
                </div>
                <div style="font-size:.72rem;margin-top:5px;">
                    @if($pendingVerifications > 0)
                        <span style="color:#d97706;font-weight:700;">⚠ Perlu tindakan</span>
                    @else
                        <span style="color:var(--muted);">Semua terverifikasi</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- =============================================
         CHARTS ROW
    ============================================= --}}
    <div class="grid-charts">

        <div class="section-card">
            <div class="section-header">
                <div class="section-header-icon"><i class="fa-solid fa-chart-area"></i></div>
                <div class="section-title">Grafik Omzet Bulan Ini</div>
            </div>
            <div style="padding:20px;height:220px;">
                <canvas id="chartOmzet" style="width:100%;height:100%;"></canvas>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <div class="section-header-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <div class="section-title">Komposisi Omzet</div>
            </div>
            <div style="padding:20px;">
                <div class="donut-wrap">
                    <div class="donut-canvas-wrap" style="display:flex;justify-content:center;">
                        <canvas id="chartKategori" style="max-width:150px;max-height:150px;"></canvas>
                    </div>

                    <div class="donut-legend" style="display:flex;flex-direction:column;gap:9px;">
                        @php
                            $catColorsMap = [
                                'activation' => ['#2563eb','#dbeafe'],
                                'monthly'    => ['#7c3aed','#ede9fe'],
                                'pt'         => ['#ea580c','#ffedd5'],
                                'retail'     => ['#16a34a','#dcfce7'],
                                'visit'      => ['#0891b2','#cffafe'],
                            ];
                            $totalAll = $statsCategory->sum('total') ?: 1;
                        @endphp

                        @foreach($statsCategory as $stat)
                            @php
                                $cc  = $catColorsMap[$stat->category] ?? ['#6b7280','#f3f4f6'];
                                $pct = round($stat->total / $totalAll * 100);
                            @endphp
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                <div style="display:flex;align-items:center;gap:7px;min-width:0;">
                                    <div style="width:9px;height:9px;border-radius:3px;background:{{ $cc[0] }};flex-shrink:0;"></div>
                                    <span style="font-size:.77rem;font-weight:700;color:var(--text);text-transform:capitalize;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $stat->category }}</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:7px;flex-shrink:0;">
                                    <div style="width:50px;height:5px;border-radius:999px;background:{{ $cc[1] }};">
                                        <div style="width:{{ $pct }}%;height:100%;border-radius:999px;background:{{ $cc[0] }};"></div>
                                    </div>
                                    <span style="font-size:.73rem;font-weight:800;color:var(--muted);min-width:28px;text-align:right;">{{ $pct }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- =============================================
         BOTTOM ROW
    ============================================= --}}
    <div class="grid-bottom">

        <div class="section-card">
            <div class="section-header" style="justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="section-header-icon"><i class="fa-solid fa-receipt"></i></div>
                    <div class="section-title">Transaksi Terbaru</div>
                </div>
                <a href="{{ route('owner.reports.transactions') }}"
                   style="font-size:.75rem;font-weight:700;color:var(--red);text-decoration:none;white-space:nowrap;">
                    Lihat semua →
                </a>
            </div>

            <div>
                @forelse($recentTransactions as $tx)
                    @php
                        $statusColor = match($tx->status) {
                            'success' => ['#16a34a','#dcfce7'],
                            'pending' => ['#d97706','#fef3c7'],
                            default   => ['#6b7280','#f3f4f6'],
                        };
                        $catIcon = match($tx->category ?? '') {
                            'activation' => 'fa-id-card',
                            'monthly'    => 'fa-calendar',
                            'pt'         => 'fa-dumbbell',
                            'retail'     => 'fa-box',
                            'visit'      => 'fa-person-walking',
                            default      => 'fa-receipt',
                        };
                    @endphp
                    <div class="tx-row">
                        <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                            <div style="width:34px;height:34px;border-radius:1px;background:var(--surface-2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:12px;flex-shrink:0;">
                                <i class="fa-solid {{ $catIcon }}"></i>
                            </div>
                            <div style="min-width:0;">
                                <div class="tx-name">{{ $tx->user->name ?? 'Guest' }}</div>
                                <div class="tx-meta">{{ $tx->category }} · {{ $tx->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:.84rem;font-weight:800;color:var(--text);white-space:nowrap;">
                                Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </div>
                            <span style="font-size:.68rem;font-weight:700;color:{{ $statusColor[0] }};background:{{ $statusColor[1] }};padding:2px 8px;border-radius:999px;display:inline-block;margin-top:2px;">
                                {{ $tx->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="padding:32px;text-align:center;color:var(--muted);font-size:.85rem;">
                        Belum ada transaksi
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-right">

            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-icon"><i class="fa-solid fa-user-group"></i></div>
                    <div class="section-title">Statistik Member</div>
                </div>
                <div style="padding:18px;display:flex;flex-direction:column;gap:12px;">
                    @php $activePct = $totalMembers > 0 ? round($activeMembers / $totalMembers * 100) : 0; @endphp

                    <div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                            <span style="font-size:.77rem;font-weight:700;color:var(--muted);">Member Aktif</span>
                            <span style="font-size:.77rem;font-weight:800;color:var(--text);">{{ $activeMembers }} / {{ $totalMembers }}</span>
                        </div>
                        <div style="height:7px;border-radius:999px;background:var(--surface-2);border:1px solid var(--border);">
                            <div style="width:{{ $activePct }}%;height:100%;border-radius:999px;background:linear-gradient(90deg,var(--red),#f87171);"></div>
                        </div>
                        <div style="font-size:.72rem;color:var(--muted);margin-top:4px;">{{ $activePct }}% dari total member</div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div style="background:var(--surface-2);border:1px solid var(--border);border-radius:1px;padding:12px;text-align:center;">
                            <div style="font-size:1.2rem;font-weight:800;color:var(--text);">{{ $newMembersThisMonth }}</div>
                            <div style="font-size:.68rem;color:var(--muted);font-weight:700;margin-top:2px;">Member Baru</div>
                        </div>
                        <div style="background:var(--surface-2);border:1px solid var(--border);border-radius:1px;padding:12px;text-align:center;">
                            <div style="font-size:1.2rem;font-weight:800;color:var(--text);">{{ $totalAdmins }}</div>
                            <div style="font-size:.68rem;color:var(--muted);font-weight:700;margin-top:2px;">Total Admin</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-icon"><i class="fa-solid fa-bolt"></i></div>
                    <div class="section-title">Quick Access</div>
                </div>
                <div style="padding:14px;display:flex;flex-direction:column;gap:9px;">

                    <a href="{{ route('owner.admins.index') }}" class="quick-link">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fa-solid fa-user-shield"></i><span>Kelola Admin</span>
                        </div>
                        <i class="fa-solid fa-chevron-right" style="font-size:.7rem;opacity:.4;"></i>
                    </a>

                    <a href="{{ route('owner.settings.index') }}" class="quick-link">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fa-solid fa-gear"></i><span>Pengaturan Gym</span>
                        </div>
                        <i class="fa-solid fa-chevron-right" style="font-size:.7rem;opacity:.4;"></i>
                    </a>

                    <a href="{{ route('owner.pt-packages.index') }}" class="quick-link">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fa-solid fa-dumbbell"></i><span>Paket PT</span>
                        </div>
                        <i class="fa-solid fa-chevron-right" style="font-size:.7rem;opacity:.4;"></i>
                    </a>

                    <a href="{{ route('owner.reports.transactions') }}" class="quick-link">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fa-solid fa-chart-column"></i><span>Laporan Transaksi</span>
                        </div>
                        @if($pendingVerifications > 0)
                            <span class="badge-pending">{{ $pendingVerifications }}</span>
                        @else
                            <i class="fa-solid fa-chevron-right" style="font-size:.7rem;opacity:.4;"></i>
                        @endif
                    </a>

                </div>
            </div>

        </div>
    </div>

</div>

{{-- CHART.JS --}}
<script>
const monthlyLabels = @json($monthlyIncome->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M')));
const monthlyData   = @json($monthlyIncome->pluck('total'));
const catLabels     = @json($statsCategory->pluck('category')->map(fn($c) => ucfirst($c)));
const catData       = @json($statsCategory->pluck('total'));
const catColors     = ['#2563eb','#7c3aed','#ea580c','#16a34a','#0891b2','#6b7280'];

// LINE
const ctxLine = document.getElementById('chartOmzet').getContext('2d');
const grad = ctxLine.createLinearGradient(0, 0, 0, 180);
grad.addColorStop(0, 'rgba(239,68,68,.16)');
grad.addColorStop(1, 'rgba(239,68,68,0)');

new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [{
            data: monthlyData,
            borderColor: '#ef4444',
            backgroundColor: grad,
            borderWidth: 2.5,
            tension: .4,
            fill: true,
            pointBackgroundColor: '#ef4444',
            pointRadius: monthlyData.length > 20 ? 0 : 3,
            pointHoverRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: { label: c => ' Rp ' + c.parsed.y.toLocaleString('id-ID') },
                backgroundColor: '#111', titleColor: '#aaa', bodyColor: '#fff',
                padding: 10, cornerRadius: 10,
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { family: 'Outfit', size: 10 }, color: '#888', maxTicksLimit: 10 }
            },
            y: {
                grid: { color: 'rgba(0,0,0,.05)' },
                ticks: {
                    font: { family: 'Outfit', size: 10 }, color: '#888',
                    callback: v => v >= 1000000 ? (v/1000000).toFixed(1)+'jt'
                                 : v >= 1000    ? (v/1000).toFixed(0)+'rb' : v
                }
            }
        }
    }
});

// DONUT
new Chart(document.getElementById('chartKategori').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: catLabels,
        datasets: [{
            data: catData,
            backgroundColor: catColors,
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 6,
        }]
    },
    options: {
        cutout: '68%',
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: { label: c => ' Rp ' + c.parsed.toLocaleString('id-ID') },
                backgroundColor: '#111', bodyColor: '#fff', padding: 10, cornerRadius: 10,
            }
        }
    }
});
</script>

@endsection