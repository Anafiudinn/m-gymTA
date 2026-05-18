@extends('layouts.admin')

@section('header-title', 'Laporan Kehadiran')

@section('content')

<style>
    /* ── Page Header ── */
    .breadcrumb {
        display: flex; align-items: center; gap: 5px;
        font-size: 11px; color: var(--muted); margin-bottom: 4px;
    }
    .breadcrumb .sep { color: #ddd; }
    .breadcrumb .current { color: #888; }
    .page-title { font-size: 20px; font-weight: 800; color: var(--text); letter-spacing: -.02em; line-height: 1.2; }
    .page-sub   { font-size: 12px; color: var(--muted); margin-top: 3px; }

    /* ── Search & Filter — selaras .retail-search / .pt-search ── */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-search {
        display: flex; align-items: center; gap: 8px;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 0 12px; height: 34px;
        transition: border-color .15s, box-shadow .15s;
    }

    .filter-search:focus-within {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
    }

    .filter-search i { font-size: 11px; color: var(--muted); flex-shrink: 0; }

    .filter-search input {
        border: none; outline: none; background: transparent;
        font-size: 12px; color: var(--text);
        font-family: 'Outfit', sans-serif; width: 200px;
    }

    .filter-search input::placeholder { color: #bbb; }

    /* Select — selaras field-input */
    .filter-select {
        height: 34px; padding: 0 10px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--surface);
        font-size: 12px; font-weight: 600; color: var(--text);
        font-family: 'Outfit', sans-serif;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        cursor: pointer;
    }

    .filter-select:focus {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
    }

    /* Date input — sama dengan filter-select */
    .filter-date {
        height: 34px; padding: 0 10px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--surface);
        font-size: 12px; font-weight: 600; color: var(--text);
        font-family: 'Outfit', sans-serif;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }

    .filter-date:focus {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
    }

    /* Filter submit — selaras .cart-submit */
    .filter-btn {
        height: 34px; padding: 0 14px;
        border-radius: var(--radius);
        background: var(--text); color: #fff;
        border: none; font-size: 11px; font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: background .15s;
    }

    .filter-btn:hover { background: #333; }

    /* Reset btn — selaras .btn-cancel */
    .filter-reset {
        height: 34px; width: 34px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        border: 1px solid var(--border);
        color: var(--muted); font-size: 12px;
        cursor: pointer; transition: background .15s;
        text-decoration: none;
    }

    .filter-reset:hover { background: rgba(0,0,0,.08); color: var(--text); }

    /* ── Tabs — selaras .tab-btn dari retail ── */
    .tab-bar {
        display: flex; align-items: center;
        justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .tab-group { display: flex; gap: 4px; }

    .tab-btn {
        padding: 7px 14px;
        border-radius: var(--radius);
        font-size: 12px; font-weight: 700;
        border: 1px solid var(--border);
        background: var(--surface); color: var(--muted);
        cursor: pointer; text-decoration: none;
        font-family: 'Outfit', sans-serif;
        transition: background .15s, color .15s;
    }

    .tab-btn:hover { background: #f4f4f4; color: var(--text); }

    .tab-btn.active {
        background: var(--text); color: #fff; border-color: var(--text);
    }

    /* Export btn — selaras .export-btn dari members ── */
    .export-btn {
        display: inline-flex; align-items: center; gap: 6px;
        height: 34px; padding: 0 14px;
        border-radius: var(--radius);
        background: rgba(22,163,74,.08);
        color: #166534;
        border: 1px solid rgba(22,163,74,.2);
        font-size: 12px; font-weight: 700;
        font-family: 'Outfit', sans-serif;
        text-decoration: none;
        transition: background .15s, color .15s;
    }

    .export-btn:hover { background: #16a34a; color: #fff; border-color: #16a34a; }
    .export-btn i { font-size: 11px; }

    /* ── Stats — selaras .stat-card dari pt.blade ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    @media (max-width: 900px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 16px;
        box-shadow: var(--shadow);
        transition: box-shadow .15s;
    }

    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }

    .stat-label {
        font-size: 10px; font-weight: 800; color: var(--muted);
        text-transform: uppercase; letter-spacing: .1em; margin: 0 0 6px;
    }

    .stat-value {
        font-size: 26px; font-weight: 800; line-height: 1; margin: 0;
        color: var(--text);
    }

    .stat-value.green  { color: #16a34a; }
    .stat-value.blue   { color: #2563eb; }
    .stat-value.amber  { color: #d97706; }

    /* ── Table card — selaras .card / .vtbl ── */
    .report-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .report-panel-head {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        background: #fafafa;
    }

    .report-panel-title { font-size: 13px; font-weight: 700; color: var(--text); margin: 0 0 1px; }
    .report-panel-sub   { font-size: 11px; color: var(--muted); margin: 0; }

    /* ── Advanced PT filter card ── */
    .filter-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    .filter-card-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 160px 160px auto;
        gap: 8px;
        align-items: center;
    }

    @media (max-width: 900px) { .filter-card-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 560px) { .filter-card-grid { grid-template-columns: 1fr; } }

    /* ── Table — selaras .vtbl / .mem-table ── */
    .rtbl { width: 100%; border-collapse: collapse; }

    .rtbl thead th {
        padding: 10px 14px;
        font-size: 10px; font-weight: 800;
        text-transform: uppercase; letter-spacing: .1em;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        white-space: nowrap;
        text-align: left;
    }

    .rtbl thead th.center { text-align: center; }
    .rtbl thead th.right  { text-align: right; }

    .rtbl tbody td {
        padding: 11px 14px;
        font-size: 13px; color: var(--text);
        border-bottom: 1px solid rgba(0,0,0,.04);
        vertical-align: middle;
    }

    .rtbl tbody tr:last-child td { border-bottom: none; }
    .rtbl tbody tr:hover td { background: #fafafa; }

    /* Row avatar — selaras .member-avatar */
    .row-avatar {
      width: 34px; height: 34px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--red), #991b1b);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 800; color: #fff;
        flex-shrink: 0;
    }

    /* ── Pills — selaras .pill dari pt.blade ── */
    .pill {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px; border-radius: var(--radius);
        font-size: 10px; font-weight: 700; white-space: nowrap;
    }

    .pill-dot { width: 5px; height: 5px; border-radius: 50%; }

    .pill-green  { background: rgba(22,163,74,.08);  color: #166534; }
    .pill-green  .pill-dot { background: #16a34a; }
    .pill-blue   { background: rgba(37,99,235,.08);  color: #1d4ed8; }
    .pill-blue   .pill-dot { background: #2563eb; }
    .pill-amber  { background: rgba(217,119,6,.08);  color: #92400e; }
    .pill-amber  .pill-dot { background: #d97706; }

    /* Session flow chips — selaras .sess-chip dari pt.blade */
    .sess-flow { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .sess-chip { padding: 3px 8px; border-radius: var(--radius); font-size: 11px; font-weight: 700; }
    .sess-chip.prev { background: rgba(239,68,68,.08); color: #b91c1c; }
    .sess-chip.curr { background: rgba(22,163,74,.08); color: #166534; }
    .sess-arrow { font-size: 9px; color: var(--muted); }

    /* Date cell */
    .date-main { font-size: 12px; font-weight: 700; color: var(--text); }
    .date-sub  { font-size: 11px; color: var(--muted); margin-top: 1px; }

    /* Empty state — selaras .empty-state ── */
    .empty-state {
        padding: 52px 24px; text-align: center;
        display: flex; flex-direction: column; align-items: center; gap: 8px;
    }

    .empty-icon {
        width: 42px; height: 42px; border-radius: var(--radius);
        background: rgba(0, 0, 0, 0.79);
        display: flex; align-items: center; justify-content: center; margin-bottom: 4px;
    }

    .empty-icon i { font-size: 18px; color: #ddd; }
    .empty-title  { font-size: 13px; font-weight: 700; color: var(--text); margin: 0; }
    .empty-sub    { font-size: 12px; color: var(--muted); margin: 0; }

    /* Pagination wrap */
    .pagination-wrap { padding: 12px 16px; border-top: 1px solid var(--border); }
</style>

{{-- Page Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:16px;">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:8px;"></i></span>
            <span class="current">Laporan Kehadiran</span>
        </div>
        <h1 class="page-title">Laporan Kehadiran &amp; PT</h1>
        <p class="page-sub">Monitoring check-in gym dan histori aktivitas PT member.</p>
    </div>

    {{-- Search + filter utama --}}
    <form method="GET">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <div class="filter-bar">
            <div class="filter-search">
                <i class="fa fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama / whatsapp...">
            </div>

            @if($tab == 'attendance')
            <select name="type" class="filter-select">
                <option value="">Semua Tipe</option>
                <option value="member_package" {{ request('type') == 'member_package' ? 'selected' : '' }}>Member Bulanan</option>
                <option value="paid_visit"     {{ request('type') == 'paid_visit'     ? 'selected' : '' }}>Visit Harian</option>
            </select>
            @endif

            @if($tab == 'pt')
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="active"    {{ request('status') == 'active'    ? 'selected' : '' }}>Aktif</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
            @endif

            <button type="submit" class="filter-btn">Filter</button>
        </div>
    </form>
</div>

{{-- Tabs + Export --}}
<div class="tab-bar">
    <div class="tab-group">
        <a href="{{ route('admin.report.attendance', ['tab' => 'attendance']) }}"
            class="tab-btn {{ $tab == 'attendance' ? 'active' : '' }}">
            <i class="fa fa-clipboard-check" style="font-size:10px;margin-right:4px;"></i>Kehadiran Gym
        </a>
        <a href="{{ route('admin.report.attendance', ['tab' => 'pt']) }}"
            class="tab-btn {{ $tab == 'pt' ? 'active' : '' }}">
            <i class="fa fa-dumbbell" style="font-size:10px;margin-right:4px;"></i>Aktivitas PT
        </a>
    </div>

    <a href="{{ route('admin.report.attendance.export', request()->query()) }}" class="export-btn">
        <i class="fa fa-file-excel"></i>
        Export {{ $tab == 'attendance' ? 'Kehadiran' : 'Aktivitas PT' }}
    </a>
</div>


{{-- ══════════════════════ ATTENDANCE TAB ══════════════════════ --}}
@if($tab == 'attendance')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <p class="stat-label">Total Kehadiran</p>
        <p class="stat-value">{{ $totalAttendance }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Member Bulanan</p>
        <p class="stat-value green">{{ $memberAttendance }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Visit Harian</p>
        <p class="stat-value blue">{{ $guestAttendance }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Hari Ini</p>
        <p class="stat-value amber">{{ $todayAttendance }}</p>
    </div>
</div>

{{-- Table --}}
<div class="report-panel">
    <div class="report-panel-head">
        <p class="report-panel-title">Data Kehadiran</p>
        <p class="report-panel-sub">Riwayat check-in member dan guest gym.</p>
    </div>

    <div style="overflow-x:auto;">
        <table class="rtbl" style="min-width:760px;">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kode Member</th>
                    <th>WhatsApp</th>
                    <th>Tipe</th>
                    <th>Check-in</th>
                    <th class="right">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                <tr>
                    {{-- Name --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="row-avatar"><i class="fa fa-user"></i></div>
                            <div>
                                <p style="font-size:13px;font-weight:700;color:var(--text);line-height:1.2;">
                                    {{ $attendance->guest_name ?? $attendance->user->name ?? '—' }}
                                </p>
                                <p style="font-size:10px;color:var(--muted);margin-top:2px;">#{{ $attendance->id }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Code --}}
                    <td style="font-size:12px;font-weight:600;font-family:monospace;">
                        {{ $attendance->user->member_code ?? '—' }}
                    </td>

                    {{-- WA --}}
                    <td style="font-size:12px;font-weight:600;">
                        {{ $attendance->guest_whatsapp ?? $attendance->user->whatsapp ?? '—' }}
                    </td>

                    {{-- Type --}}
                    <td>
                        @if($attendance->type == 'member_package')
                            <span class="pill pill-green"><span class="pill-dot"></span>Member Bulanan</span>
                        @else
                            <span class="pill pill-blue"><span class="pill-dot"></span>Visit Harian</span>
                        @endif
                    </td>

                    {{-- Time --}}
                    <td>
                        <p class="date-main">{{ $attendance->created_at->format('d M Y') }}</p>
                        <p class="date-sub">{{ $attendance->created_at->format('H:i') }} WIB</p>
                    </td>

                    {{-- Status --}}
                    <td style="text-align:right;">
                        <span class="pill pill-green">
                            <span class="pill-dot"></span>Berhasil Check-in
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fa fa-calendar-check"></i></div>
                            <p class="empty-title">Belum Ada Kehadiran</p>
                            <p class="empty-sub">Data check-in gym akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $attendances->withQueryString()->links() }}
    </div>
</div>
@endif


{{-- ══════════════════════ PT TAB ══════════════════════ --}}
@if($tab == 'pt')

{{-- Advanced Filter Card — selaras .filter-card ── --}}
<div class="filter-card">
    <form method="GET">
        <input type="hidden" name="tab" value="pt">
        <div class="filter-card-grid">
            <div class="filter-search" style="height:34px;">
                <i class="fa fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari member / coach / admin..." style="width:100%;">
            </div>

            <div style="display:flex;gap:8px;">
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="filter-date" style="flex:1;">
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="filter-date" style="flex:1;">
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit" class="filter-btn" style="flex:1;">Filter</button>
                <a href="{{ route('admin.report.attendance', ['tab' => 'pt']) }}"
                    class="filter-reset">
                    <i class="fa fa-rotate-right"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- PT Table --}}
<div class="report-panel">
    <div class="report-panel-head">
        <p class="report-panel-title">PT Activity Logs</p>
        <p class="report-panel-sub">Riwayat penggunaan sesi personal trainer member gym.</p>
    </div>

    <div style="overflow-x:auto;">
        <table class="rtbl" style="min-width:860px;">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Coach</th>
                    <th class="center">Aktivitas</th>
                    <th class="center">Perubahan Sesi</th>
                    <th>Diproses Oleh</th>
                    <th class="right">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ptReports as $log)
                <tr>
                    {{-- Member --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="row-avatar"><i class="fa fa-user"></i></div>
                            <div>
                                <p style="font-size:13px;font-weight:700;color:var(--text);line-height:1.2;">
                                    {{ $log->member_name }}
                                </p>
                                <p style="font-size:10px;color:var(--muted);margin-top:2px;font-family:monospace;">
                                    {{ $log->user->member_code ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- Coach --}}
                    <td style="font-size:12px;font-weight:600;">{{ $log->coach_name ?? '—' }}</td>

                    {{-- Activity --}}
                    <td style="text-align:center;">
                        <span class="pill pill-amber">
                            <span class="pill-dot"></span>Potong Sesi
                        </span>
                    </td>

                    {{-- Session flow --}}
                    <td>
                        <div class="sess-flow">
                            <span class="sess-chip prev">{{ $log->previous_session }}</span>
                            <i class="fa fa-arrow-right sess-arrow"></i>
                            <span class="sess-chip curr">{{ $log->current_session }}</span>
                        </div>
                    </td>

                    {{-- Admin --}}
                    <td>
                        <p style="font-size:12px;font-weight:600;color:var(--text);">
                            {{ $log->admin->name ?? 'System' }}
                        </p>
                        <p style="font-size:11px;color:var(--muted);margin-top:1px;">Admin Gym</p>
                    </td>

                    {{-- Date --}}
                    <td style="text-align:right;">
                        <p class="date-main">{{ $log->created_at->format('d M Y') }}</p>
                        <p class="date-sub">{{ $log->created_at->format('H:i') }} WIB</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fa fa-dumbbell"></i></div>
                            <p class="empty-title">Belum Ada Aktivitas PT</p>
                            <p class="empty-sub">Riwayat penggunaan sesi PT akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $ptReports->withQueryString()->links() }}
    </div>
</div>
@endif

@endsection