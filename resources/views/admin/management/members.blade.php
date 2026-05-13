@extends('layouts.admin')

@section('content')

<style>
    /* ── Stats ── */
    .mem-stat {
        background: #fff; border: 1px solid #f0f0f0;
        border-radius: 12px; padding: 18px 20px;
        transition: box-shadow .15s;
    }
    .mem-stat:hover { box-shadow: 0 2px 12px rgba(0,0,0,.06); }
    .mem-stat-label {
        font-size: 10.5px; font-weight: 700; color: #a0a0a0;
        text-transform: uppercase; letter-spacing: .09em; margin: 0 0 8px;
    }
    .mem-stat-value {
        font-size: 28px; font-weight: 800; line-height: 1; margin: 0;
    }

    /* ── Table Panel ── */
    .mem-panel {
        background: #fff; border: 1px solid #f0f0f0;
        border-radius: 14px; overflow: hidden;
    }
    .mem-panel-head {
        padding: 14px 22px; border-bottom: 1px solid #f0f0f0;
        display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
    }
    .mem-search {
        display: flex; align-items: center; gap: 8px;
        background: #f9fafb; border: 1px solid #ebebeb;
        border-radius: 9px; padding: 0 12px; height: 36px;
        transition: border-color .15s, box-shadow .15s;
    }
    .mem-search:focus-within { border-color: #93c5fd; box-shadow: 0 0 0 3px #eff6ff; background: #fff; }
    .mem-search i { font-size: 12px; color: #9ca3af; }
    .mem-search input {
        border: none; outline: none; background: transparent;
        font-size: 13px; color: #111827; font-family: 'DM Sans', sans-serif; width: 220px;
    }
    .mem-search input::placeholder { color: #bbb; }

    /* ── Table ── */
    .mem-table { width: 100%; min-width: 780px; border-collapse: collapse; }
    .mem-table thead tr { background: #fafafa; }
    .mem-table thead th {
        padding: 11px 18px; font-size: 10.5px; font-weight: 700;
        color: #a0a0a0; text-transform: uppercase; letter-spacing: .07em;
        border-bottom: 1px solid #f0f0f0; white-space: nowrap;
    }
    .mem-table thead th:first-child { padding-left: 22px; }
    .mem-table thead th:last-child  { padding-right: 22px; text-align: right; }
    .mem-table tbody tr { border-bottom: 1px solid #f7f7f7; transition: background .12s; }
    .mem-table tbody tr:last-child { border-bottom: none; }
    .mem-table tbody tr:hover { background: #fafafa; }
    .mem-table tbody td { padding: 14px 18px; vertical-align: middle; font-size: 13px; color: #374151; }
    .mem-table tbody td:first-child { padding-left: 22px; }
    .mem-table tbody td:last-child  { padding-right: 22px; }

    /* ── Avatar ── */
    .mem-avatar {
        width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #f97316, #ef4444);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 800; color: #fff;
    }
    .mem-name { font-size: 13.5px; font-weight: 700; color: #111827; }
    .mem-code { font-size: 11px; color: #f97316; font-weight: 700; font-family: 'DM Mono', monospace; }
    .mem-wa   { font-size: 11px; color: #9ca3af; }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 10px; font-weight: 700; padding: 4px 10px;
        border-radius: 20px; text-transform: uppercase; letter-spacing: .05em; white-space: nowrap;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-green { background: #f0fdf4; color: #15803d; }
    .badge-green .badge-dot { background: #16a34a; }
    .badge-red   { background: #fff1f2; color: #b91c1c; }
    .badge-red   .badge-dot { background: #ef4444; }
    .badge-orange { background: #fff7ed; color: #c2410c; }
    .badge-orange .badge-dot { background: #f97316; }
    .badge-gray   { background: #f3f4f6; color: #6b7280; }

    /* ── Action Buttons ── */
    .act-btn {
        width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; cursor: pointer; transition: background .15s;
        background: #f3f4f6;
    }
    .act-btn i { font-size: 12px; color: #6b7280; transition: color .15s; }
    .act-btn:hover { background: #111827; }
    .act-btn:hover i { color: #fff; }
    .act-btn-orange { background: #fff7ed; }
    .act-btn-orange i { color: #f97316; }
    .act-btn-orange:hover { background: #f97316; }
    .act-btn-orange:hover i { color: #fff; }
    .act-btn-blue { background: #eff6ff; }
    .act-btn-blue i { color: #2563eb; }
    .act-btn-blue:hover { background: #2563eb; }
    .act-btn-blue:hover i { color: #fff; }

    /* ── Package info ── */
    .pkg-name   { font-size: 13px; font-weight: 700; color: #111827; }
    .pkg-sub    { font-size: 11px; margin-top: 1px; }
    .pkg-active { color: #16a34a; }
    .pkg-expired{ color: #ef4444; }
    .pkg-none   { color: #9ca3af; font-style: italic; font-weight: 500; }
    .pkg-date   { font-size: 13px; font-weight: 700; color: #374151; }
    .pkg-date-sub { font-size: 11px; color: #9ca3af; margin-top: 1px; }

    /* ═══════════════════════════════
       MODALS
    ═══════════════════════════════ */
    .ub-modal {
        display: none; position: fixed; inset: 0; z-index: 60;
        align-items: center; justify-content: center; padding: 16px;
    }
    .ub-modal.open { display: flex; }
    .ub-backdrop {
        position: absolute; inset: 0;
        background: rgba(0,0,0,.32); backdrop-filter: blur(4px);
    }
    .ub-box {
        position: relative; z-index: 1; background: #fff;
        width: 100%; border-radius: 18px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.14);
        animation: modalIn .22s cubic-bezier(.34,1.56,.64,1);
        max-height: 90vh; overflow-y: auto;
    }
    @keyframes modalIn { from{opacity:0;transform:scale(.94) translateY(12px);}to{opacity:1;transform:scale(1) translateY(0);} }
    .ub-head {
        padding: 18px 22px; border-bottom: 1px solid #f3f4f6;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; background: #fff; z-index: 2;
    }
    .ub-title { font-size: 14.5px; font-weight: 800; color: #111827; margin: 0 0 2px; }
    .ub-sub   { font-size: 11.5px; color: #9ca3af; margin: 0; }
    .ub-close {
        width: 30px; height: 30px; border-radius: 7px;
        background: #f3f4f6; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ub-close i { font-size: 11px; color: #6b7280; }

    /* ── Digital Card ── */
    .digi-card {
        margin: 18px; border-radius: 14px; overflow: hidden;
        background: linear-gradient(135deg, #111827, #1f2937);
        padding: 20px; color: #fff; position: relative; min-height: 160px;
    }
    .digi-card-deco1 {
        position: absolute; width: 120px; height: 120px; border-radius: 50%;
        background: rgba(255,255,255,.04); top: -30px; right: -30px;
    }
    .digi-card-deco2 {
        position: absolute; width: 120px; height: 120px; border-radius: 50%;
        background: rgba(249,115,22,.15); bottom: -30px; left: -30px;
    }
    .digi-card-brand {
        display: flex; align-items: center; gap: 8px; margin-bottom: 16px; position: relative;
    }
    .digi-card-brand-icon {
        width: 30px; height: 30px; border-radius: 8px; background: #f97316;
        display: flex; align-items: center; justify-content: center;
    }
    .digi-card-brand-icon i { font-size: 11px; color: #fff; }
    .digi-card-brand-name { font-size: 12px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
    .digi-card-status {
        margin-left: auto; font-size: 9px; font-weight: 700; padding: 3px 9px;
        border-radius: 20px; text-transform: uppercase; letter-spacing: .06em;
    }
    .digi-card-member-row { display: flex; align-items: center; gap: 12px; position: relative; margin-bottom: 16px; }
    .digi-card-avatar {
        width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #f97316, #ef4444);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 800; border: 2px solid rgba(255,255,255,.15);
    }
    .digi-card-mname { font-size: 16px; font-weight: 800; }
    .digi-card-footer {
        display: flex; justify-content: space-between; align-items: flex-end;
        border-top: 1px solid rgba(255,255,255,.1); padding-top: 12px; position: relative;
    }
    .digi-card-fl { font-size: 9px; text-transform: uppercase; color: rgba(255,255,255,.4); font-weight: 700; margin-bottom: 3px; }
    .digi-card-fv { font-size: 13px; font-weight: 800; font-family: 'DM Mono', monospace; color: #fb923c; }
    .digi-card-fv2 { font-size: 12px; font-weight: 700; color: #fff; }

    /* ── Detail Rows ── */
    .detail-rows { padding: 0 18px 18px; }
    .view-more-btn {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        width: 100%; padding: 10px; background: none; border: none; cursor: pointer;
        font-size: 12.5px; font-weight: 700; color: #6b7280;
        font-family: 'DM Sans', sans-serif; transition: color .15s;
        border-top: 1px solid #f3f4f6; margin-top: 4px;
    }
    .view-more-btn:hover { color: #f97316; }
    .view-more-btn .vm-icon {
        width: 22px; height: 22px; border-radius: 50%; background: #f3f4f6;
        display: flex; align-items: center; justify-content: center; transition: background .15s;
    }
    .view-more-btn:hover .vm-icon { background: #fff7ed; }
    .vm-icon i { font-size: 9px; transition: transform .25s; }

    .ext-details { display: none; padding-top: 14px; border-top: 1px solid #f3f4f6; margin-top: 8px; }
    .ext-details.open { display: block; }
    .ext-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 8px 0; border-bottom: 1px dashed #f3f4f6;
    }
    .ext-row:last-child { border-bottom: none; }
    .ext-key  { font-size: 10.5px; font-weight: 700; color: #a0a0a0; text-transform: uppercase; letter-spacing: .06em; }
    .ext-val  { font-size: 13px; font-weight: 700; color: #111827; text-align: right; }

    .btn-edit-full {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        width: 100%; padding: 11px; border-radius: 10px;
        background: #f97316; color: #fff;
        font-size: 13px; font-weight: 700; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif; margin-top: 16px;
        transition: background .15s;
    }
    .btn-edit-full:hover { background: #ea6c10; }

    /* ── Edit Modal Fields ── */
    .field-label { display: block; font-size: 10.5px; font-weight: 700; color: #a0a0a0; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 6px; }
    .field-input {
        width: 100%; border: 1px solid #e5e7eb; border-radius: 9px;
        padding: 9px 13px; font-size: 13px; color: #111827;
        outline: none; font-family: 'DM Sans', sans-serif; box-sizing: border-box;
        transition: border-color .15s, box-shadow .15s;
    }
    .field-input:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px #eff6ff; }
    .ub-foot {
        padding: 14px 22px; border-top: 1px solid #f3f4f6;
        display: flex; justify-content: flex-end; gap: 8px;
        position: sticky; bottom: 0; background: #fff;
    }
    .btn-cancel {
        padding: 9px 16px; border-radius: 9px; background: #f3f4f6;
        border: 1px solid #ebebeb; color: #6b7280; font-size: 12.5px;
        font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif;
        transition: background .15s;
    }
    .btn-cancel:hover { background: #e5e7eb; }
    .btn-save-orange {
        padding: 9px 18px; border-radius: 9px; background: #f97316;
        color: #fff; font-size: 12.5px; font-weight: 700;
        border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
        transition: background .15s;
    }
    .btn-save-orange:hover { background: #ea6c10; }

    /* Empty state */
    .mem-empty { padding: 64px 24px; text-align: center; }
    .mem-empty-icon { width: 52px; height: 52px; border-radius: 13px; background: #f9fafb; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; }
    .mem-empty-icon i { font-size: 22px; color: #ddd; }
</style>

{{-- Page Header --}}
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:9px;"></i></span>
            <span class="current">Data Member</span>
        </div>
        <h1 class="page-title">Data Member</h1>
        <p class="page-sub">Kelola member, paket, dan aktivitas gym.</p>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;margin-bottom:22px;">
    <div class="mem-stat">
        <p class="mem-stat-label">Total Member</p>
        <p class="mem-stat-value" style="color:#111827;">{{ $totalMembers }}</p>
    </div>
    <div class="mem-stat">
        <p class="mem-stat-label">Sudah Aktivasi</p>
        <p class="mem-stat-value" style="color:#16a34a;">{{ $activeMembers }}</p>
    </div>
    <div class="mem-stat">
        <p class="mem-stat-label">Paket Expired</p>
        <p class="mem-stat-value" style="color:#ef4444;">{{ $expiredPackages }}</p>
    </div>
    <div class="mem-stat">
        <p class="mem-stat-label">PT Aktif</p>
        <p class="mem-stat-value" style="color:#f97316;">{{ $ptActive }}</p>
    </div>
</div>

{{-- Table Panel --}}
<div class="mem-panel">

    {{-- Toolbar --}}
    <div class="mem-panel-head">
        <div>
            <p style="font-size:13.5px;font-weight:700;color:#111827;margin:0 0 1px;">List Member</p>
            <p style="font-size:11.5px;color:#bbb;margin:0;">Semua data member terdaftar.</p>
        </div>
        <form method="GET" action="{{ route('admin.data.members') }}">
            <div class="mem-search">
                <i class="fa fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode / WA...">
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table class="mem-table">
            <thead>
                <tr>
                    <th style="text-align:left;">Member</th>
                    <th style="text-align:left;">Status AKTIVASI</th>
                    <th style="text-align:left;">Paket</th>
                    <th style="text-align:left;">Berakhir</th>
                    <th style="text-align:center;">PT</th>
                    <th>Aksi</th>
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
                        <div style="display:flex;align-items:center;gap:11px;">
                            <div class="mem-avatar">{{ strtoupper(substr($m->name,0,1)) }}</div>
                            <div>
                                <p class="mem-name">{{ $m->name }}</p>
                                <div style="display:flex;align-items:center;gap:6px;margin-top:2px;">
                                    <span class="mem-code">{{ $m->member_code ?? 'NON MEMBER' }}</span>
                                    <span style="color:#e5e7eb;">·</span>
                                    <span class="mem-wa">{{ $m->whatsapp }}</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Status AKTIVASI --}}
                    <td>
                        @if($m->is_active_member)
                        <span class="badge badge-green"><span class="badge-dot"></span>Aktivasi</span>
                        @else
                        <span class="badge badge-red"><span class="badge-dot"></span>Non-Aktivasi</span>
                        @endif
                    </td>

                    {{-- Paket --}}
                    <td>
                        @if(!$hasPackage)
                            <p class="pkg-none">Belum ada paket</p>
                        @elseif($packageExpired)
                            <p class="pkg-name" style="color:#ef4444;">{{ $membership->package_name }}</p>
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
                            <p class="pkg-date-sub" style="color: #b91c1c;">{{ $packageExpired ? 'Sudah habis' : 'Masih aktif' }}</p>
                        @else
                            <span style="color:#bbb;">—</span>
                        @endif
                    </td>

                    {{-- PT --}}
                    <td style="text-align:center;">
                        @if($hasPT)
                        <span class="badge badge-orange"><span class="badge-dot"></span>{{ $hasPT }} Aktif</span>
                        @else
                        <span style="color:#bbb;">—</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                            {{-- Detail --}}
                            <button type="button" class="act-btn act-btn-orange" title="Detail Member"
                                onclick="openDetail({
                                    id:'{{ $m->id }}',
                                    name:'{{ addslashes($m->name) }}',
                                    whatsapp:'{{ $m->whatsapp }}',
                                    member_code:'{{ $m->member_code ?? "NON MEMBER" }}',
                                    activation:'{{ $m->is_active_member ? "AKTIF" : "NON AKTIVASI" }}',
                                    package:'{{ $membership ? addslashes($membership->package_name) : "Belum Ada Paket" }}',
                                    expired:'{{ $membership ? \Carbon\Carbon::parse($membership->end_date)->format("d M Y") : "-" }}',
                                    package_status:'{{ !$hasPackage ? "Belum Ada Paket" : ($packageExpired ? "Expired" : "Aktif") }}',
                                    is_member:{{ $m->is_active_member ? 'true' : 'false' }},
                                    pt:'{{ $hasPT ? $hasPT." Sesi Aktif" : "Tidak Ada" }}',
                                    created_at:'{{ $m->created_at->format("d M Y") }}'
                                })">
                                <i class="fa fa-id-card"></i>
                            </button>

                            {{-- Edit --}}
                            <button type="button" class="act-btn act-btn-blue" title="Edit Member"
                                onclick="openEdit('{{ $m->id }}','{{ addslashes($m->name) }}','{{ $m->whatsapp }}')">
                                <i class="fa fa-pen"></i>
                            </button>

                            {{-- Toggle Aktif --}}
                            <form action="{{ route('admin.data.members.toggle', $m->id) }}" method="POST"
                                  id="toggle-{{ $m->id }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="button" class="act-btn" title="Toggle Aktif"
                                    data-confirm
                                    data-confirm-title="{{ $m->is_active_member ? 'Non-aktifkan Member?' : 'Aktifkan Member?' }}"
                                    data-confirm-desc="{{ $m->name }} akan {{ $m->is_active_member ? 'dinonaktifkan' : 'diaktifkan' }}."
                                    data-confirm-type="{{ $m->is_active_member ? 'warning' : 'success' }}"
                                    data-confirm-label="{{ $m->is_active_member ? 'Non-aktifkan' : 'Aktifkan' }}"
                                    data-confirm-form="toggle-{{ $m->id }}">
                                    <i class="fa fa-power-off" style="font-size:11px;color:{{ $m->is_active_member ? '#f97316' : '#6b7280' }};"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:0;">
                        <div class="mem-empty">
                            <div class="mem-empty-icon"><i class="fa fa-users"></i></div>
                            <p style="font-size:14px;font-weight:700;color:#374151;margin:0 0 4px;">Belum Ada Member</p>
                            <p style="font-size:12.5px;color:#9ca3af;margin:0;">Tambahkan data member gym.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="padding:14px 22px;border-top:1px solid #f0f0f0;">
        {{ $members->links() }}
    </div>
</div>


{{-- ═══════════════ MODAL DETAIL ═══════════════ --}}
<div class="ub-modal" id="detailModal">
    <div class="ub-backdrop" onclick="closeDetail()"></div>
    <div class="ub-box" style="max-width:440px;">

        <div class="ub-head">
            <div>
                <p class="ub-title">Member Card</p>
                <p class="ub-sub">Informasi lengkap member gym.</p>
            </div>
            <button class="ub-close" onclick="closeDetail()"><i class="fa fa-times"></i></button>
        </div>

        {{-- Digital Card --}}
        <div class="digi-card">
            <div class="digi-card-deco1"></div>
            <div class="digi-card-deco2"></div>
            <div class="digi-card-brand">
                <div class="digi-card-brand-icon"><i class="fa fa-dumbbell"></i></div>
                <span class="digi-card-brand-name">UB GYM</span>
            </div>
            <div class="digi-card-member-row">
                <div class="digi-card-avatar" id="dc_avatar">A</div>
                <div>
                    <p class="digi-card-mname" id="dc_name">—</p>
                </div>
            </div>
            <div class="digi-card-footer">
                <div>
                    <p class="digi-card-fl">Kode Member</p>
                    <p class="digi-card-fv" id="dc_code">—</p>
                </div>
                <div style="text-align:right;">
                    <p class="digi-card-fl">Berlaku S/D</p>
                    <p class="digi-card-fv2" id="dc_expired">—</p>
                </div>
            </div>
        </div>

        {{-- View More --}}
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


{{-- ═══════════════ MODAL EDIT ═══════════════ --}}
<div class="ub-modal" id="editModal">
    <div class="ub-backdrop" onclick="closeEdit()"></div>
    <div class="ub-box" style="max-width:420px;">

        <div class="ub-head">
            <div>
                <p class="ub-title">Edit Member</p>
                <p class="ub-sub">Perbarui informasi data member.</p>
            </div>
            <button class="ub-close" onclick="closeEdit()"><i class="fa fa-times"></i></button>
        </div>

        <form id="editForm" method="POST">
            @csrf @method('PATCH')
            <div style="padding:20px 22px;display:flex;flex-direction:column;gap:14px;">
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
                <button type="submit" class="btn-save-orange">Simpan Perubahan</button>
            </div>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
/* ══════════════════════════════
   STATE
══════════════════════════════ */
let _currentMember = null;
let _vmOpen = false;

/* ══════════════════════════════
   DETAIL MODAL
══════════════════════════════ */
function openDetail(m) {
    _currentMember = m;

    // reset view more
    _vmOpen = false;
    document.getElementById('ext_details').classList.remove('open');
    document.getElementById('vm_icon').style.transform = '';
    document.getElementById('vm_text').textContent = 'Lihat Detail Lengkap';

    // digital card
    document.getElementById('dc_avatar').textContent = m.name.charAt(0).toUpperCase();
    document.getElementById('dc_name').textContent    = m.name;
    document.getElementById('dc_code').textContent    = m.member_code || 'NON MEMBER';
    document.getElementById('dc_expired').textContent = m.expired || '—';


    // extended details
    document.getElementById('ed_name').textContent       = m.name;
    document.getElementById('ed_wa').textContent         = m.whatsapp;
    document.getElementById('ed_code').textContent       = m.member_code || 'NON MEMBER';
    document.getElementById('ed_activation').textContent = m.activation;
    document.getElementById('ed_package').textContent    = m.package;
    document.getElementById('ed_expired').textContent    = m.expired;
    document.getElementById('ed_pkg_status').textContent = m.package_status;
    document.getElementById('ed_pt').textContent         = m.pt;
    document.getElementById('ed_created').textContent    = m.created_at;

    // edit button wires to current member
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
    const ext  = document.getElementById('ext_details');
    const icon = document.getElementById('vm_icon');
    const txt  = document.getElementById('vm_text');
    if (_vmOpen) {
        ext.classList.add('open');
        icon.style.transform = 'rotate(180deg)';
        txt.textContent = 'Sembunyikan Detail';
    } else {
        ext.classList.remove('open');
        icon.style.transform = '';
        txt.textContent = 'Lihat Detail Lengkap';
    }
}

/* ══════════════════════════════
   EDIT MODAL
══════════════════════════════ */
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

/* ══════════════════════════════
   ESC KEY
══════════════════════════════ */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeDetail(); closeEdit(); }
});
</script>
@endpush