@extends('layouts.admin')

@section('header-title', 'Personal Trainer Sessions')

@section('content')

<style>
    /* ── Page Header ── */
    .page-header { margin-bottom: 18px; }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: var(--muted);
        margin-bottom: 4px;
    }

    .breadcrumb .sep { color: #ddd; }
    .breadcrumb .current { color: #888; }

    .page-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .page-sub {
        font-size: 12px;
        color: var(--muted);
        margin-top: 3px;
    }

    /* ── Search — selaras .retail-search ── */
    .pt-search {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 0 12px;
        height: 36px;
        transition: border-color .15s, box-shadow .15s;
        width: 260px;
        position: relative;
    }

    .pt-search:focus-within {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
    }

    .pt-search i { font-size: 11px; color: var(--muted); flex-shrink: 0; }

    .pt-search input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 13px;
        color: var(--text);
        font-family: 'Outfit', sans-serif;
        width: 100%;
    }

    .pt-search input::placeholder { color: #bbb; }

    /* ── Stats Grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    @media (max-width: 900px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 560px) { .stats-grid { grid-template-columns: 1fr; } }

    /* Stat card — selaras .card admin */
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: box-shadow .2s;
    }

    .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); }

    /* Dark stat card — selaras .cart-panel warna sidebar #111 */
    .stat-card.dark {
        background: #111111;
        border-color: rgba(255,255,255,.06);
    }

    .stat-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .stat-card.dark .stat-label { color: rgba(255,255,255,.4); }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-card.dark .stat-value { color: #fff; }

    .stat-value.amber { color: #d97706; }

    .stat-desc { font-size: 11px; color: var(--muted); }
    .stat-card.dark .stat-desc { color: rgba(255,255,255,.35); }

    /* Stat icon — selaras .ni icon di sidebar */
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 16px;
    }

    .stat-icon.blue  { background: rgba(37,99,235,.08);  color: #2563eb; }
    .stat-icon.amber { background: rgba(217,119,6,.08);  color: #d97706; }
    .stat-icon.dark  { background: rgba(255,255,255,.08); color: rgba(255,255,255,.6); }

    /* ── Main Grid ── */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 14px;
        align-items: start;
    }

    @media (max-width: 1024px) { .main-grid { grid-template-columns: 1fr; } }

    /* ── Card — sama persis dengan .card admin ── */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-head {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-head-title { font-size: 13px; font-weight: 700; color: var(--text); }
    .card-head-sub   { font-size: 11px; color: var(--muted); margin-top: 1px; }

    /* ── Pill badges — selaras warna admin ── */
    .pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: var(--radius);
        font-size: 10px;
        font-weight: 700;
    }

    .pill-blue   { background: rgba(37,99,235,.1);  color: #1d4ed8; }
    .pill-green  { background: rgba(22,163,74,.1);   color: #166534; }
    .pill-amber  { background: rgba(217,119,6,.1);   color: #92400e; }
    .pill-red    { background: rgba(239,68,68,.1);   color: #b91c1c; }
    .pill-gray   { background: rgba(0,0,0,.05);      color: var(--muted); }

    /* ── Table — selaras admin tbl style ── */
    .tbl {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl thead th {
        padding: 10px 14px;
        text-align: left;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        white-space: nowrap;
    }

    .tbl tbody td {
        padding: 11px 14px;
        font-size: 13px;
        color: var(--text);
        border-bottom: 1px solid rgba(0,0,0,.04);
        vertical-align: middle;
    }

    .tbl tbody tr:last-child td { border-bottom: none; }
    .tbl tbody tr:hover td { background: #fafafa; }

    /* Member avatar — selaras .sb-avatar */
    .member-avatar {
        width: 36px;
        height: 36px;
        border-radius: var(--radius);
        background: #e11616;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .member-avatar i { font-size: 11px; color: rgba(36, 27, 27, 0.99); }

    .member-name { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.2; }
    .member-code { font-size: 11px; color: var(--muted); margin-top: 2px; font-family: monospace; }

    /* Progress bar */
    .prog-wrap { width: 100%; }
    .prog-meta { display: flex; align-items: center; justify-content: space-between; font-size: 11px; margin-bottom: 5px; }
    .prog-meta-used { font-weight: 700; color: var(--text); }
    .prog-meta-sisa { color: var(--muted); }

    .prog-bar {
        width: 100%;
        height: 5px;
        border-radius: 99px;
        background: rgba(0,0,0,.06);
        overflow: hidden;
    }

    .prog-fill {
        height: 100%;
        border-radius: 99px;
        background: var(--red);
        transition: width .3s ease;
    }

    /* Action button — selaras .logout-btn merah admin */
    .btn-cut {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: var(--radius);
        background: rgba(239,68,68,.08);
        color: var(--red);
        border: 1px solid rgba(239,68,68,.2);
        font-size: 11px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: background .15s, color .15s;
        white-space: nowrap;
    }

    .btn-cut:hover { background: var(--red); color: #fff; border-color: var(--red); }
    .btn-cut:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }
    .btn-cut i { font-size: 10px; }

    /* Empty state — selaras .hist-empty */
    .empty-state {
        padding: 48px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .empty-icon {
        width: 42px;
        height: 42px;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
    }

    .empty-icon i { font-size: 18px; color: #ddd; }
    .empty-title  { font-size: 13px; font-weight: 700; color: var(--text); margin: 0; }
    .empty-sub    { font-size: 12px; color: var(--muted); margin: 0; }

    /* ── Activity feed — selaras cart dark panel ── */
    .activity-item {
        padding: 12px 14px;
        border-bottom: 1px solid rgba(0,0,0,.04);
        display: flex;
        gap: 10px;
        transition: background .12s;
    }

    .activity-item:last-child { border-bottom: none; }
    .activity-item:hover { background: #fafafa; }

    .activity-icon {
        width: 34px;
        height: 34px;
        border-radius: var(--radius);
        background: rgba(217,119,6,.08);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 12px;
        color: #d97706;
    }

    .activity-name { font-size: 12px; font-weight: 700; color: var(--text); line-height: 1.2; }
    .activity-coach { font-size: 11px; color: var(--muted); margin-top: 1px; }
    .activity-time  { font-size: 10px; color: var(--muted); white-space: nowrap; }

    /* Session flow chips — selaras .pay-badge */
    .sess-flow {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
    }

    .sess-chip {
        padding: 3px 8px;
        border-radius: var(--radius);
        font-size: 11px;
        font-weight: 700;
    }

    .sess-chip.prev { background: rgba(239,68,68,.1); color: #b91c1c; }
    .sess-chip.curr { background: rgba(22,163,74,.1);  color: #166534; }
    .sess-arrow { font-size: 9px; color: var(--muted); }

    .activity-by { font-size: 11px; color: var(--muted); margin-top: 6px; }
    .activity-by span { font-weight: 600; color: #555; }

    /* Pagination wrapper */
    .pagination-wrap {
        padding: 12px 16px;
        border-top: 1px solid var(--border);
    }
</style>

{{-- Page Header --}}
<div class="page-header">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;">
        <div>
            <div class="breadcrumb">
                <i class="fa fa-home" style="font-size:10px;"></i>
                <span>Dashboard</span>
                <span class="sep"><i class="fa fa-chevron-right" style="font-size:8px;"></i></span>
                <span class="current">PT Sessions</span>
            </div>
            <h1 class="page-title">Personal Trainer Sessions</h1>
            <p class="page-sub">Kelola penggunaan sesi personal trainer member gym.</p>
        </div>

        <form method="GET" style="display:flex;align-items:center;gap:8px;">
            <div class="pt-search">
                <i class="fa fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari member / kode / whatsapp...">
            </div>
            <button type="submit"
                style="padding:0 14px;height:36px;border-radius:var(--radius);background:var(--red);color:#fff;border:none;font-size:12px;font-weight:700;font-family:'Outfit',sans-serif;cursor:pointer;transition:background .15s;"
                onmouseover="this.style.background='var(--red-dark)'"
                onmouseout="this.style.background='var(--red)'">
                Cari
            </button>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid">

    <div class="stat-card">
        <div>
            <p class="stat-label">PT Aktif</p>
            <p class="stat-value">{{ $totalActive }}</p>
            <p class="stat-desc">Member dengan paket PT aktif.</p>
        </div>
        <div class="stat-icon blue"><i class="fa fa-users"></i></div>
    </div>

    <div class="stat-card">
        <div>
            <p class="stat-label">Hampir Habis</p>
            <p class="stat-value amber">{{ $lowSession }}</p>
            <p class="stat-desc">Sisa sesi PT kurang dari 3.</p>
        </div>
        <div class="stat-icon amber"><i class="fa fa-exclamation-triangle"></i></div>
    </div>

    <div class="stat-card">
        <div>
            <p class="stat-label">Aktivitas Hari Ini</p>
            <p class="stat-value">{{ $todayActivity }}</p>
            <p class="stat-desc">Penggunaan sesi PT hari ini.</p>
        </div>
        <div class="stat-icon dark"><i class="fa fa-chart-line"></i></div>
    </div>

</div>

{{-- Main Grid --}}
<div class="main-grid">

    {{-- LEFT: Table --}}
    <div class="card">
        <div class="card-head">
            <div>
                <p class="card-head-title">Active PT Members</p>
                <p class="card-head-sub">Member dengan paket personal trainer aktif.</p>
            </div>
            <span class="pill pill-blue">{{ $ptMemberships->total() }} Member</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Coach</th>
                        <th style="width:220px;">Progress</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ptMemberships as $pt)
                    @php
                        $used       = $pt->total_sessions - $pt->remaining_sessions;
                        $percentage = $pt->total_sessions > 0
                            ? round(($used / $pt->total_sessions) * 100)
                            : 0;
                    @endphp
                    <tr>
                        {{-- Member --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="member-avatar">
                                    <i class="fa fa-dumbbell"></i>
                                </div>
                                <div>
                                    <p class="member-name">{{ $pt->user->name }}</p>
                                    <p class="member-code">{{ $pt->user->member_code }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Coach --}}
                        <td>
                            <p style="font-size:13px;font-weight:600;color:var(--text);">
                                {{ $pt->package->coach_name ?? 'No Coach' }}
                            </p>
                            <p style="font-size:11px;color:var(--muted);margin-top:2px;">
                                {{ $pt->package->nama_paket ?? '-' }}
                            </p>
                        </td>

                        {{-- Progress --}}
                        <td>
                            <div class="prog-wrap">
                                <div class="prog-meta">
                                    <span class="prog-meta-used">{{ $used }} / {{ $pt->total_sessions }} sesi</span>
                                    <span class="prog-meta-sisa">Sisa {{ $pt->remaining_sessions }}</span>
                                </div>
                                <div class="prog-bar">
                                    <div class="prog-fill" style="width:{{ $percentage }}%;"></div>
                                </div>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($pt->remaining_sessions <= 0)
                                <span class="pill pill-red">Habis</span>
                            @elseif($pt->remaining_sessions <= 3)
                                <span class="pill pill-amber">Low</span>
                            @else
                                <span class="pill pill-green">Active</span>
                            @endif
                        </td>

                        {{-- Action --}}
                        <td style="text-align:right;">
                            <form id="cut-form-{{ $pt->id }}"
                                action="{{ route('admin.pt.cut', $pt->id) }}"
                                method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="button"
                                    class="btn-cut"
                                    {{ $pt->remaining_sessions <= 0 ? 'disabled' : '' }}
                                    data-confirm="Sistem akan mengurangi 1 sesi PT untuk <strong>{{ $pt->user->name }}</strong>."
                                    data-confirm-title="Gunakan 1 Sesi PT?"
                                    data-confirm-type="warn"
                                    data-confirm-ok="Ya, Gunakan"
                                    data-form="#cut-form-{{ $pt->id }}">
                                    <i class="fa fa-minus-circle"></i> Potong
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fa fa-dumbbell"></i></div>
                                <p class="empty-title">Tidak Ada Member PT</p>
                                <p class="empty-sub">Belum ada paket PT aktif saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ptMemberships->hasPages())
        <div class="pagination-wrap">
            {{ $ptMemberships->withQueryString()->links() }}
        </div>
        @endif
    </div>

    {{-- RIGHT: Activity --}}
    <div class="card">
        <div class="card-head">
            <div>
                <p class="card-head-title">Recent Activity</p>
                <p class="card-head-sub">Aktivitas realtime penggunaan sesi PT.</p>
            </div>
            <span class="pill pill-gray">{{ $recentActivities->count() }}</span>
        </div>

        @forelse($recentActivities as $log)
        <div class="activity-item">
            <div class="activity-icon"><i class="fa fa-history"></i></div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:6px;">
                    <div>
                        <p class="activity-name">{{ $log->member_name }}</p>
                        <p class="activity-coach">Coach: {{ $log->coach_name }}</p>
                    </div>
                    <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                </div>
                <div class="sess-flow">
                    <span class="sess-chip prev">{{ $log->previous_session }}</span>
                    <i class="fa fa-arrow-right sess-arrow"></i>
                    <span class="sess-chip curr">{{ $log->current_session }}</span>
                </div>
                <p class="activity-by">
                    Diproses oleh
                    <span>{{ $log->admin->name ?? 'System' }}</span>
                </p>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-history"></i></div>
            <p class="empty-title">Belum Ada Aktivitas</p>
            <p class="empty-sub">Aktivitas penggunaan sesi PT akan muncul di sini.</p>
        </div>
        @endforelse
    </div>

</div>

@endsection