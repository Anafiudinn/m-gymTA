@extends('layouts.admin')

@section('header-title', 'Data Member')

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

    /* ── Stats — selaras .stat-card dari pt.blade ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

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

    .stat-value { font-size: 26px; font-weight: 800; line-height: 1; margin: 0; color: var(--text); }
    .stat-value.green  { color: #16a34a; }
    .stat-value.red    { color: var(--red); }
    .stat-value.orange { color: #d97706; }

    /* ── Table card — selaras .card admin ── */
    .mem-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .mem-panel-head {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }

    .mem-panel-title { font-size: 13px; font-weight: 700; color: var(--text); margin: 0 0 1px; }
    .mem-panel-sub   { font-size: 11px; color: var(--muted); margin: 0; }

    /* ── Search — selaras .retail-search ── */
    .mem-search {
        display: flex; align-items: center; gap: 8px;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 0 12px; height: 34px;
        transition: border-color .15s, box-shadow .15s;
    }

    .mem-search:focus-within {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
    }

    .mem-search i { font-size: 11px; color: var(--muted); }

    .mem-search input {
        border: none; outline: none; background: transparent;
        font-size: 12px; color: var(--text);
        font-family: 'Outfit', sans-serif; width: 200px;
    }

    .mem-search input::placeholder { color: #bbb; }

    /* Export btn — selaras .cart-submit merah tapi hijau ── */
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

    /* ── Table — selaras .tbl / .vtbl ── */
    .mem-table { width: 100%; min-width: 760px; border-collapse: collapse; }

    .mem-table thead th {
        padding: 10px 14px;
        font-size: 10px; font-weight: 800;
        text-transform: uppercase; letter-spacing: .1em;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        white-space: nowrap;
        text-align: left;
    }

    .mem-table thead th:last-child { text-align: right; }

    .mem-table tbody td {
        padding: 11px 14px;
        font-size: 13px; color: var(--text);
        border-bottom: 1px solid rgba(0,0,0,.04);
        vertical-align: middle;
    }

    .mem-table tbody tr:last-child td { border-bottom: none; }
    .mem-table tbody tr:hover td { background: #fafafa; }

    /* Member avatar — selaras .sb-avatar ── */
    .mem-avatar {
        width: 34px; height: 34px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--red), #991b1b);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 800; color: #fff;
        flex-shrink: 0;
    }

    .mem-name  { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.2; }
    .mem-code  { font-size: 10px; color: var(--red); font-weight: 700; font-family: monospace; }
    .mem-wa    { font-size: 10px; color: var(--muted); }

    /* ── Pills — selaras .pill dari pt.blade ── */
    .pill {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px; border-radius: var(--radius);
        font-size: 10px; font-weight: 700; white-space: nowrap;
    }

    .pill-dot { width: 5px; height: 5px; border-radius: 50%; }

    .pill-green  { background: rgba(22,163,74,.08);  color: #166534; }
    .pill-green  .pill-dot { background: #16a34a; }
    .pill-red    { background: rgba(239,68,68,.08);  color: #b91c1c; }
    .pill-red    .pill-dot { background: var(--red); }
    .pill-amber  { background: rgba(217,119,6,.08);  color: #92400e; }
    .pill-amber  .pill-dot { background: #d97706; }
    .pill-gray   { background: rgba(0,0,0,.05);      color: var(--muted); }

    /* Package info */
    .pkg-name    { font-size: 12px; font-weight: 700; color: var(--text); }
    .pkg-sub     { font-size: 11px; margin-top: 1px; }
    .pkg-active  { color: #16a34a; }
    .pkg-expired { color: var(--red); }
    .pkg-none    { font-size: 12px; color: var(--muted); font-style: italic; }
    .pkg-date    { font-size: 12px; font-weight: 700; color: var(--text); }
    .pkg-date-sub{ font-size: 11px; color: var(--muted); margin-top: 1px; }

    /* ── Action buttons — selaras .btn-cut dari pt.blade ── */
    .act-btn {
        width: 30px; height: 30px;
        border-radius: var(--radius);
        display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid var(--border);
        background: rgba(0,0,0,.03);
        cursor: pointer; transition: background .15s, border-color .15s;
        flex-shrink: 0;
    }

    .act-btn i { font-size: 11px; color: var(--muted); transition: color .15s; }
    .act-btn:hover { background: var(--text); border-color: var(--text); }
    .act-btn:hover i { color: #fff; }

    .act-btn-detail { background: rgba(217,119,6,.06); border-color: rgba(217,119,6,.15); }
    .act-btn-detail i { color: #d97706; }
    .act-btn-detail:hover { background: #d97706; border-color: #d97706; }

    .act-btn-edit { background: rgba(37,99,235,.06); border-color: rgba(37,99,235,.15); }
    .act-btn-edit i { color: #2563eb; }
    .act-btn-edit:hover { background: #2563eb; border-color: #2563eb; }

    /* Empty state */
    .empty-state {
        padding: 52px 24px; text-align: center;
        display: flex; flex-direction: column; align-items: center; gap: 8px;
    }

    .empty-icon {
        width: 42px; height: 42px; border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        display: flex; align-items: center; justify-content: center; margin-bottom: 4px;
    }

    .empty-icon i { font-size: 18px; color: #ddd; }
    .empty-title  { font-size: 13px; font-weight: 700; color: var(--text); margin: 0; }
    .empty-sub    { font-size: 12px; color: var(--muted); margin: 0; }

    /* ══════════════════════════════
       MODAL BASE — selaras #ubg-alert-box
    ══════════════════════════════ */
    .ub-modal {
        display: none; position: fixed; inset: 0; z-index: 200;
        align-items: center; justify-content: center; padding: 16px;
    }

    .ub-modal.open { display: flex; }

    .ub-backdrop {
        position: absolute; inset: 0;
        background: rgba(0,0,0,.3);
        backdrop-filter: blur(3px);
    }

    .ub-box {
        position: relative; z-index: 1;
        background: var(--surface);
        border: 1px solid var(--border);
        width: 100%; border-radius: var(--radius);
        box-shadow: 0 8px 40px rgba(0,0,0,.12);
        overflow: hidden;
        animation: alertIn .2s ease;
        max-height: 90vh; overflow-y: auto;
    }

    @keyframes alertIn {
        from { opacity:0; transform:scale(.95) translateY(-6px); }
        to   { opacity:1; transform:scale(1)  translateY(0); }
    }

    /* Modal header — selaras .ubg-alert-header */
    .ub-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 18px 12px;
        border-bottom: 1px solid var(--border);
        position: sticky; top: 0; background: var(--surface); z-index: 2;
    }

    .ub-title { font-size: 14px; font-weight: 700; color: var(--text); margin: 0 0 2px; }
    .ub-sub   { font-size: 11px; color: var(--muted); margin: 0; }

    /* Close btn — selaras .sb-toggle */
    .ub-close {
        width: 28px; height: 28px;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        transition: background .15s;
    }

    .ub-close:hover { background: rgba(0,0,0,.08); }
    .ub-close i { font-size: 11px; color: var(--muted); }

    /* Modal footer — selaras .ubg-alert-footer */
    .ub-foot {
        display: flex; justify-content: flex-end; gap: 8px;
        padding: 12px 18px;
        border-top: 1px solid var(--border);
        background: #fafafa;
        position: sticky; bottom: 0;
    }

    /* ── Digital Member Card — warna selaras sidebar #111 ── */
    .digi-card {
        margin: 14px;
        border-radius: var(--radius);
        background: #111111;
        padding: 18px;
        color: #fff;
        position: relative;
        overflow: hidden;
        min-height: 150px;
    }

    /* Decorative circles — tone merah selaras --red */
    .digi-deco1 {
        position: absolute; width: 110px; height: 110px;
        border-radius: 50%; background: rgba(255,255,255,.03);
        top: -28px; right: -28px;
    }

    .digi-deco2 {
        position: absolute; width: 110px; height: 110px;
        border-radius: 50%; background: rgba(239,68,68,.12);
        bottom: -28px; left: -28px;
    }

    .digi-brand {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 14px; position: relative;
    }

    /* Brand icon — identik .sb-logo */
    .digi-brand-icon {
        width: 28px; height: 28px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--red), #991b1b);
        display: flex; align-items: center; justify-content: center;
    }

    .digi-brand-icon svg { width: 12px; height: 12px; }
    .digi-brand-name { font-size: 11px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }

    .digi-member-row {
        display: flex; align-items: center; gap: 10px;
        position: relative; margin-bottom: 14px;
    }

    /* Avatar — selaras .sb-avatar warna gradient */
    .digi-avatar {
        width: 38px; height: 38px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--red), #991b1b);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 800;
        border: 1px solid rgba(255,255,255,.15);
        flex-shrink: 0;
    }

    .digi-mname { font-size: 15px; font-weight: 800; }

    .digi-footer {
        display: flex; justify-content: space-between; align-items: flex-end;
        border-top: 1px solid rgba(255,255,255,.08);
        padding-top: 10px; position: relative;
    }

    .digi-fl { font-size: 9px; text-transform: uppercase; color: rgba(255,255,255,.4); font-weight: 700; margin-bottom: 3px; }
    .digi-fv  { font-size: 12px; font-weight: 800; font-family: monospace; color: #fb923c; }
    .digi-fv2 { font-size: 12px; font-weight: 700; color: #fff; text-align: right; }

    /* ── Detail rows ── */
    .detail-rows { padding: 0 14px 14px; }

    .view-more-btn {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        width: 100%; padding: 9px; background: none; border: none; cursor: pointer;
        font-size: 12px; font-weight: 700; color: var(--muted);
        font-family: 'Outfit', sans-serif; transition: color .15s;
        border-top: 1px solid var(--border); margin-top: 4px;
    }

    .view-more-btn:hover { color: var(--red); }

    .vm-icon {
        width: 20px; height: 20px;
        border-radius: 50%; background: rgba(0,0,0,.04);
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }

    .view-more-btn:hover .vm-icon { background: rgba(239,68,68,.08); }
    .vm-icon i { font-size: 9px; transition: transform .22s; }

    .ext-details { display: none; padding-top: 12px; border-top: 1px solid var(--border); margin-top: 8px; }
    .ext-details.open { display: block; }

    .ext-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 7px 0; border-bottom: 1px solid rgba(0,0,0,.04);
    }

    .ext-row:last-child { border-bottom: none; }
    .ext-key { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; }
    .ext-val { font-size: 12px; font-weight: 700; color: var(--text); text-align: right; }

    /* Edit from detail btn — selaras .cart-submit */
    .btn-edit-full {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        width: 100%; padding: 10px;
        border-radius: var(--radius);
        background: var(--red); color: #fff;
        font-size: 12px; font-weight: 700;
        border: none; cursor: pointer;
        font-family: 'Outfit', sans-serif;
        margin-top: 14px;
        transition: background .15s;
    }

    .btn-edit-full:hover { background: var(--red-dark); }

    /* ── Edit modal fields — selaras .retail-field / .reject-textarea ── */
    .field-label {
        display: block; font-size: 10px; font-weight: 700;
        color: var(--muted); text-transform: uppercase;
        letter-spacing: .08em; margin-bottom: 5px;
    }

    .field-input {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 8px 12px; font-size: 13px; color: var(--text);
        outline: none; font-family: 'Outfit', sans-serif;
        background: #fafafa;
        transition: border-color .15s, box-shadow .15s;
        box-sizing: border-box;
    }

    .field-input:focus {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
        background: var(--surface);
    }

    /* Modal buttons — selaras .ubg-btn */
    .btn-cancel {
        padding: 7px 14px; border-radius: var(--radius);
        background: rgba(0,0,0,.04); color: var(--muted);
        border: 1px solid var(--border);
        font-size: 12px; font-weight: 700;
        font-family: 'Outfit', sans-serif; cursor: pointer;
        transition: background .15s;
    }

    .btn-cancel:hover { background: rgba(0,0,0,.08); color: var(--text); }

    .btn-save {
        padding: 7px 16px; border-radius: var(--radius);
        background: var(--red); color: #fff;
        border: none; font-size: 12px; font-weight: 700;
        font-family: 'Outfit', sans-serif; cursor: pointer;
        transition: background .15s;
    }

    .btn-save:hover { background: var(--red-dark); }
</style>

{{-- Page Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:16px;">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:8px;"></i></span>
            <span class="current">Data Member</span>
        </div>
        <h1 class="page-title">Data Member</h1>
        <p class="page-sub">Kelola member, paket, dan aktivitas gym.</p>
    </div>
</div>
@if(session('success'))
<div style="display:flex;gap:12px;align-items:flex-start;background:#fff;border:1px solid var(--border);border-left:3px solid rgba(34,197,94,.8);border-radius:var(--radius);padding:14px 16px;margin-bottom:20px;">
    <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(34,197,94,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-circle-check" style="font-size:13px;color:#22c55e;"></i>
    </div>
    <div style="flex:1;">
        <p style="font-size:13px;font-weight:700;color:#15803d;margin:0 0 2px;">{{ session('success') }}</p>
    </div>
</div>
@endif
{{-- ═══ ERROR ALERT ═══ --}}
@if(session('error'))
<div style="display:flex;gap:12px;align-items:flex-start;background:#fff;border:1px solid var(--border);border-left:3px solid var(--red);border-radius:var(--radius);padding:14px 16px;margin-bottom:20px;">
    <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-circle-exclamation" style="font-size:13px;color:var(--red);"></i>
    </div>
    <div style="flex:1;">
        <p style="font-size:13px;font-weight:700;color:var(--red);margin:0 0 2px;">{{ session('error') }}</p>
    </div>
</div>
@endif
{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <p class="stat-label">Total Member</p>
        <p class="stat-value">{{ $totalMembers }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Sudah Aktivasi</p>
        <p class="stat-value green">{{ $activeMembers }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Paket Expired</p>
        <p class="stat-value red">{{ $expiredPackages }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">PT Aktif</p>
        <p class="stat-value orange">{{ $ptActive }}</p>
    </div>
</div>

{{-- Table Panel --}}
<div class="mem-panel">


<div class="mem-panel-head">
    <div>
        <p class="mem-panel-title">List Member</p>
        <p class="mem-panel-sub">Semua data member terdaftar.</p>
    </div>
    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        
        <form method="GET" action="{{ route('admin.data.members') }}" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin:0;">
            
            {{-- Filter 1: Status Registrasi Akun --}}
            <div class="mem-select-wrapper">
                <select name="status" class="form-select" onchange="this.form.submit()" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 13px; outline: none; background-color: #fff;">
                    <option value="">-- Semua Registrasi --</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Member Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tamu / Non-Aktif</option>
                </select>
            </div>

            {{-- Filter 2: 🌟 Kategori Kepemilikan Paket (Bulanan / PT / Dua-duanya) --}}
            <div class="mem-select-wrapper">
                <select name="package_filter" class="form-select" onchange="this.form.submit()" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 13px; outline: none; background-color: #fff;">
                    <option value="">-- Semua Jenis Paket --</option>
                    <option value="active_monthly" {{ request('package_filter') === 'active_monthly' ? 'selected' : '' }}>Punya Paket Bulanan</option>
                    <option value="active_pt" {{ request('package_filter') === 'active_pt' ? 'selected' : '' }}>Punya Paket PT</option>
                    <option value="both" {{ request('package_filter') === 'both' ? 'selected' : '' }}>Punya Bulanan & PT</option>
                    <option value="no_package" {{ request('package_filter') === 'no_package' ? 'selected' : '' }}>Tidak Ada Paket Aktif</option>
                </select>
            </div>

            {{-- Input Search Teks --}}
            <div class="mem-search">
                <i class="fa fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama / kode / WA...">
            </div>

        </form>

        <a href="{{ route('admin.data.members.export', request()->query()) }}" class="export-btn">
            <i class="fa fa-file-excel"></i> Export Excel
        </a>
        </div>
</div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table class="mem-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Status Aktivasi</th>
                    <th>Paket</th>
                    <th>Berakhir</th>
                    <th style="text-align:center;">PT</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $m)
                @php
                    $membership     = $m->activeMembership;
                    $hasPackage     = (bool) $membership;
                    $packageExpired = $membership ? \Carbon\Carbon::parse($membership->end_date)->isPast() : false;
                    $hasPT          = $m->ptMemberships->where('status','active')->count();
                @endphp
                <tr>
                    {{-- Member --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="mem-avatar">{{ strtoupper(substr($m->name,0,1)) }}</div>
                            <div>
                                <p class="mem-name">{{ $m->name }}</p>
                                <div style="display:flex;align-items:center;gap:5px;margin-top:2px;">
                                    <span class="mem-code">{{ $m->member_code ?? 'NON MEMBER' }}</span>
                                    <span style="color:#ddd;">·</span>
                                    <span class="mem-wa">{{ $m->whatsapp }}</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($m->is_active_member)
                            <span class="pill pill-green"><span class="pill-dot"></span>Aktivasi</span>
                        @else
                            <span class="pill pill-red"><span class="pill-dot"></span>Non-Aktivasi</span>
                        @endif
                    </td>

                    {{-- Paket --}}
                    <td>
                        @if(!$hasPackage)
                            <span class="pkg-none">Belum ada paket</span>
                        @elseif($packageExpired)
                            <p class="pkg-name" style="color:var(--red);">{{ $membership->package_name }}</p>
                            <p class="pkg-sub pkg-expired">Expired</p>
                        @else
                            <p class="pkg-name">{{ $membership->package_name }}</p>
                            <p class="pkg-sub pkg-active">Aktif</p>
                        @endif
                    </td>

                    {{-- Berakhir --}}
                    <td>
                        @if($membership)
                            <p class="pkg-date">{{ \Carbon\Carbon::parse($membership->end_date)->format('d M Y') }}</p>
                            <p class="pkg-date-sub" style="color:{{ $packageExpired ? 'var(--red)' : '#16a34a' }};">
                                {{ $packageExpired ? 'Sudah habis' : 'Masih aktif' }}
                            </p>
                        @else
                            <span style="color:#ddd;">—</span>
                        @endif
                    </td>

                    {{-- PT --}}
                    <td style="text-align:center;">
                        @if($hasPT)
                            <span class="pill pill-amber"><span class="pill-dot"></span>{{ $hasPT }} Aktif</span>
                        @else
                            <span style="color:#ddd;">—</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:5px;">
                            {{-- Detail --}}
                            <button type="button" class="act-btn act-btn-detail" title="Detail Member"
                                onclick="openDetail({
                                    id:'{{ $m->id }}',
                                    name:'{{ addslashes($m->name) }}',
                                    whatsapp:'{{ $m->whatsapp }}',
                                    member_code:'{{ $m->member_code ?? 'NON MEMBER' }}',
                                    activation:'{{ $m->is_active_member ? 'AKTIF' : 'NON AKTIVASI' }}',
                                    package:'{{ $membership ? addslashes($membership->package_name) : 'Belum Ada Paket' }}',
                                    expired:'{{ $membership ? \Carbon\Carbon::parse($membership->end_date)->format('d M Y') : '-' }}',
                                    package_status:'{{ !$hasPackage ? 'Belum Ada Paket' : ($packageExpired ? 'Expired' : 'Aktif') }}',
                                    pt:'{{ $hasPT ? $hasPT.' Sesi Aktif' : 'Tidak Ada' }}',
                                    created_at:'{{ $m->created_at->format('d M Y') }}'
                                })">
                                <i class="fa fa-id-card"></i>
                            </button>

                            {{-- Edit --}}
                            <button type="button" class="act-btn act-btn-edit" title="Edit Member"
                                onclick="openEdit('{{ $m->id }}','{{ addslashes($m->name) }}','{{ $m->whatsapp }}')">
                                <i class="fa fa-pen"></i>
                            </button>

                            {{-- Toggle Aktif — pakai ubgConfirm dari layout admin ── --}}
                            <form action="{{ route('admin.data.members.toggle', $m->id) }}"
                                method="POST" id="toggle-{{ $m->id }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="button" class="act-btn" title="Toggle Aktif"
                                    data-confirm="{{ $m->name }} akan {{ $m->is_active_member ? 'dinonaktifkan' : 'diaktifkan' }}."
                                    data-confirm-title="{{ $m->is_active_member ? 'Non-aktifkan Member?' : 'Aktifkan Member?' }}"
                                    data-confirm-type="{{ $m->is_active_member ? 'warn' : 'success' }}"
                                    data-confirm-ok="{{ $m->is_active_member ? 'Non-aktifkan' : 'Aktifkan' }}"
                                    data-form="#toggle-{{ $m->id }}">
                                    <i class="fa fa-power-off" style="font-size:11px;color:{{ $m->is_active_member ? '#d97706' : 'var(--muted)' }};"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fa fa-users"></i></div>
                            <p class="empty-title">Belum Ada Member</p>
                            <p class="empty-sub">Tambahkan data member gym.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="padding:12px 16px;border-top:1px solid var(--border);">
        {{ $members->links() }}
    </div>

</div>


{{-- ═══ MODAL DETAIL ═══ --}}
<div class="ub-modal" id="detailModal">
    <div class="ub-backdrop" onclick="closeDetail()"></div>
    <div class="ub-box" style="max-width:420px;">

        <div class="ub-head">
            <div>
                <p class="ub-title">Member Card</p>
                <p class="ub-sub">Informasi lengkap member gym.</p>
            </div>
            <button class="ub-close" onclick="closeDetail()"><i class="fa fa-times"></i></button>
        </div>

        {{-- Digital Card — warna #111 selaras sidebar ── --}}
        <div class="digi-card">
            <div class="digi-deco1"></div>
            <div class="digi-deco2"></div>

            <div class="digi-brand">
                <div class="digi-brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                        <rect x="2"  y="9" width="3" height="6" rx="1"/>
                        <rect x="19" y="9" width="3" height="6" rx="1"/>
                        <rect x="5"  y="7" width="3" height="10" rx="1"/>
                        <rect x="16" y="7" width="3" height="10" rx="1"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                    </svg>
                </div>
                <span class="digi-brand-name">{{ $settings['gym_name'] ?? 'Satrio Gym Fitness' }}</span>
            </div>

            <div class="digi-member-row">
                <div>
                    <p class="digi-mname" id="dc_name">—</p>
                </div>
            </div>

            <div class="digi-footer">
                <div>
                    <p class="digi-fl">Kode Member</p>
                    <p class="digi-fv" id="dc_code">—</p>
                </div>
                <div style="text-align:right;">
                    <p class="digi-fl">Berlaku S/D</p>
                    <p class="digi-fv2" id="dc_expired">—</p>
                </div>
            </div>
        </div>

        <div class="detail-rows">
            <button type="button" class="view-more-btn" onclick="toggleViewMore()" id="vm_btn">
                <span id="vm_text">Lihat Detail Lengkap</span>
                <div class="vm-icon"><i class="fa fa-chevron-down" id="vm_icon"></i></div>
            </button>

            <div class="ext-details" id="ext_details">
                <div class="ext-row"><span class="ext-key">Nama</span><span class="ext-val" id="ed_name">—</span></div>
                <div class="ext-row"><span class="ext-key">WhatsApp</span><span class="ext-val" id="ed_wa">—</span></div>
                <div class="ext-row"><span class="ext-key">Kode Member</span><span class="ext-val" id="ed_code">—</span></div>
                <div class="ext-row"><span class="ext-key">Status Aktivasi</span><span class="ext-val" id="ed_activation">—</span></div>
                <div class="ext-row"><span class="ext-key">Paket Gym</span><span class="ext-val" id="ed_package">—</span></div>
                <div class="ext-row"><span class="ext-key">Masa Aktif</span><span class="ext-val" id="ed_expired">—</span></div>
                <div class="ext-row"><span class="ext-key">Status Paket</span><span class="ext-val" id="ed_pkg_status">—</span></div>
                <div class="ext-row"><span class="ext-key">Paket PT</span><span class="ext-val" id="ed_pt">—</span></div>
                <div class="ext-row"><span class="ext-key">Terdaftar</span><span class="ext-val" id="ed_created">—</span></div>

                <button type="button" class="btn-edit-full" id="btn_edit_from_detail">
                    <i class="fa fa-pen"></i> Edit Data Member
                </button>
            </div>
        </div>

    </div>
</div>


{{-- ═══ MODAL EDIT ═══ --}}
<div class="ub-modal" id="editModal">
    <div class="ub-backdrop" onclick="closeEdit()"></div>
    <div class="ub-box" style="max-width:400px;">

        <div class="ub-head">
            <div>
                <p class="ub-title">Edit Member</p>
                <p class="ub-sub">Perbarui informasi data member.</p>
            </div>
            <button class="ub-close" onclick="closeEdit()"><i class="fa fa-times"></i></button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            
            <div style="padding:16px 18px;display:flex;flex-direction:column;gap:12px;">
                <div>
                    <label class="field-label">Nama Member</label>
                    <input type="text" name="name" id="edit_name" class="field-input" required placeholder="Nama lengkap member">
                </div>
                <div>
                    <label class="field-label">No WhatsApp</label>
                    <input type="text" name="whatsapp" id="edit_wa" class="field-input" required placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <div class="ub-foot">
                <button type="button" class="btn-cancel" onclick="closeEdit()">Batal</button>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    let _vmOpen = false;

    function openDetail(m) {
        _vmOpen = false;
        document.getElementById('ext_details').classList.remove('open');
        document.getElementById('vm_icon').style.transform = '';
        document.getElementById('vm_text').textContent = 'Lihat Detail Lengkap';

        document.getElementById('dc_name').textContent    = m.name;
        document.getElementById('dc_code').textContent    = m.member_code || 'NON MEMBER';
        document.getElementById('dc_expired').textContent = m.expired || '—';

        document.getElementById('ed_name').textContent       = m.name;
        document.getElementById('ed_wa').textContent         = m.whatsapp;
        document.getElementById('ed_code').textContent       = m.member_code || 'NON MEMBER';
        document.getElementById('ed_activation').textContent = m.activation;
        document.getElementById('ed_package').textContent    = m.package;
        document.getElementById('ed_expired').textContent    = m.expired;
        document.getElementById('ed_pkg_status').textContent = m.package_status;
        document.getElementById('ed_pt').textContent         = m.pt;
        document.getElementById('ed_created').textContent    = m.created_at;

        document.getElementById('btn_edit_from_detail').onclick = () => {
            closeDetail();
            setTimeout(() => openEdit(m.id, m.name, m.whatsapp), 120);
        };

        document.getElementById('detailModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function toggleViewMore() {
        _vmOpen = !_vmOpen;
        document.getElementById('ext_details').classList.toggle('open', _vmOpen);
        document.getElementById('vm_icon').style.transform = _vmOpen ? 'rotate(180deg)' : '';
        document.getElementById('vm_text').textContent = _vmOpen ? 'Sembunyikan Detail' : 'Lihat Detail Lengkap';
    }

    function openEdit(id, name, whatsapp) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_wa').value   = whatsapp;
        document.getElementById('editForm').action = `/admin/data/members/update/${id}`;
        document.getElementById('editModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeEdit() {
        document.getElementById('editModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeDetail(); closeEdit(); }
    });
</script>
@endpush

@endsection