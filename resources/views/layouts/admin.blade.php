<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN KASIR - SIM UB GYM</title>
    {{-- logo --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        * { font-family: 'Outfit', sans-serif; }

        :root {
            --sb-w: 240px;
            --hdr-h: 56px;

            /* Sidebar - dark */
            --sb-bg:       #1c2434;
            --sb-bg-hover: #253047;
            --sb-bg-active:#2e3c52;
            --sb-border:   #2a3448;
            --sb-text:     #adb8cc;
            --sb-text-act: #ffffff;
            --sb-section:  #5a6a82;
            --sb-accent:   #4d80e4;

            /* Header & content */
            --hdr-bg:      #ffffff;
            --hdr-border:  #e8ecf0;
            --page-bg:     #f3f6f9;
            --surface:     #ffffff;
            --border:      #e8ecf0;

            --text-1: #1c2434;
            --text-2: #64748b;
            --text-3: #94a3b8;

            --blue:   #3b82f6;
            --green:  #22c55e;
            --red:    #ef4444;
            --amber:  #f59e0b;
        }

        html, body { height: 100%; }
        body { background: var(--page-bg); overflow: hidden; }

        /* ──── LAYOUT ──── */
        #layout { display: flex; height: 100vh; }

        /* ──── SIDEBAR ──── */
        #sidebar {
            width: var(--sb-w);
            flex-shrink: 0;
            background: var(--sb-bg);
            display: flex;
            flex-direction: column;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            z-index: 40;
            overflow: hidden;
        }
        

        /* Brand */
        .sb-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            height: var(--hdr-h);
            padding: 0 18px;
            border-bottom: 1px solid var(--sb-border);
            flex-shrink: 0;
        }
        .sb-logo {
            width: 32px; height: 32px;
            background: var(--sb-accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sb-logo i { color: #fff; font-size: 12px; }
        .sb-brand-name { font-size: 16px; font-weight: 700; color: #fff; letter-spacing: -.2px; }
        .sb-brand-sub  { font-size: 10px; color: var(--sb-section); font-weight: 500; letter-spacing: .05em; text-transform: uppercase; line-height: 1; }

        /* Nav scroll area */
        #sb-nav {
            flex: 1;
            overflow-y: auto;
            padding: 8px 0 12px;
        }
        #sb-nav::-webkit-scrollbar { width: 0; }

        /* Section label */
        .sb-section {
            padding: 16px 18px 5px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--sb-section);
        }

        /* Nav item */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 1px 10px;
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: var(--sb-text);
            text-decoration: none;
            cursor: pointer;
            transition: background .15s, color .15s;
            white-space: nowrap;
        }
        .nav-item .ni {
            width: 28px; height: 28px;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            background: rgba(255,255,255,.06);
            transition: background .15s;
        }
        .nav-item .ni i { font-size: 11px; color: var(--sb-text); transition: color .15s; }

        .nav-item:hover {
            background: var(--sb-bg-hover);
            color: #e2e8f0;
        }
        .nav-item:hover .ni { background: rgba(255,255,255,.1); }
        .nav-item:hover .ni i { color: #e2e8f0; }

        .nav-item.active {
            background: var(--sb-bg-active);
            color: var(--sb-text-act);
        }
        .nav-item.active .ni {
            background: var(--sb-accent);
        }
        .nav-item.active .ni i { color: #fff; }

        /* Sidebar footer */
        .sb-footer {
            border-top: 1px solid var(--sb-border);
            padding: 10px;
        }
        .logout-btn {
            display: flex; align-items: center; gap: 9px;
            width: 100%; padding: 8px 10px;
            border-radius: 7px; border: none;
            background: transparent; cursor: pointer;
            font-size: 13px; font-weight: 500;
            color: #f87171;
            transition: background .15s;
            font-family: 'Outfit', sans-serif;
        }
        .logout-btn .ni {
            width: 28px; height: 28px; border-radius: 6px;
            background: rgba(239,68,68,.15);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .logout-btn .ni i { font-size: 11px; color: #f87171; }
        .logout-btn:hover { background: rgba(239,68,68,.1); }

        /* ──── MAIN BODY ──── */
        #main-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
        }

        /* ──── HEADER ──── */
        #main-header {
            height: var(--hdr-h);
            background: var(--hdr-bg);
            border-bottom: 1px solid var(--hdr-border);
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 10px;
            flex-shrink: 0;
            z-index: 20;
        }

        /* Search */
        .search-wrap {
            display: flex; align-items: center;
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 11px;
            height: 36px;
            transition: border-color .15s, box-shadow .15s;
            max-width: 260px;
            flex: 1;
        }
        .search-wrap:focus-within {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px #eff6ff;
            background: #fff;
        }
        .search-wrap i { color: var(--text-3); font-size: 11px; margin-right: 7px; flex-shrink: 0; }
        .search-wrap input {
            border: none; outline: none; background: transparent;
            font-size: 12.5px; color: var(--text-1);
            font-family: 'Outfit', sans-serif;
            width: 100%;
        }
        .search-wrap input::placeholder { color: var(--text-3); }
        .search-kbd {
            font-size: 9px; color: var(--text-3);
            background: var(--border); border-radius: 4px;
            padding: 2px 5px;
            font-family: 'JetBrains Mono', monospace;
            margin-left: 6px; white-space: nowrap; flex-shrink: 0;
        }

        /* Header icon buttons */
        .hdr-btn {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: var(--page-bg); border: 1px solid var(--border);
            color: var(--text-2); cursor: pointer;
            transition: background .15s, border-color .15s;
            position: relative; flex-shrink: 0;
        }
        .hdr-btn:hover { background: #edf2f7; border-color: #d1dce8; }
        .hdr-btn i { font-size: 13px; }
        .notif-dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--red); border: 2px solid #fff;
        }
        .notif-dot-blue {
            background: var(--blue);
        }
        .hdr-divider { width: 1px; height: 26px; background: var(--border); flex-shrink: 0; }

        .user-chip {
            display: flex; align-items: center; gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 8px; border: 1px solid var(--border);
            background: var(--page-bg); cursor: pointer;
            transition: background .15s, border-color .15s;
            flex-shrink: 0;
        }
        .user-chip:hover { background: #edf2f7; border-color: #d1dce8; }
        .user-avatar {
            width: 28px; height: 28px; border-radius: 6px;
            overflow: hidden; flex-shrink: 0;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex; align-items: center; justify-content: center;
        }
        .user-avatar i { color: #fff; font-size: 10px; }
        .user-name   { font-size: 12.5px; font-weight: 600; color: var(--text-1); line-height: 1.2; }
        .user-role   { font-size: 10px; color: var(--text-3); line-height: 1.2; }
        .user-chip .chev { font-size: 9px; color: var(--text-3); margin-left: 2px; }

        /* ──── CONTENT ──── */
        #main-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        #main-scroll::-webkit-scrollbar { width: 5px; }
        #main-scroll::-webkit-scrollbar-thumb { background: #d1dce8; border-radius: 4px; }
        #main-content { animation: fadeUp .3s cubic-bezier(.4,0,.2,1) both; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

        /* ──── ALERTS ──── */
        .alert {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px; border-radius: 10px;
            margin-bottom: 16px; border: 1px solid transparent;
        }
        .alert-success { background: #f0fdf4; border-color: #bbf7d0; }
        .alert-error   { background: #fff1f2; border-color: #fecdd3; }
        .alert-icon {
            width: 28px; height: 28px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .alert-success .alert-icon { background: #dcfce7; }
        .alert-error   .alert-icon { background: #ffe4e6; }
        .alert-success .alert-icon i { color: #16a34a; font-size: 11px; }
        .alert-error   .alert-icon i { color: #dc2626; font-size: 11px; }
        .alert-text { font-size: 13px; font-weight: 500; flex: 1; }
        .alert-success .alert-text { color: #15803d; }
        .alert-error   .alert-text { color: #b91c1c; }
        .alert-close { background: none; border: none; cursor: pointer; padding: 3px; border-radius: 5px; opacity: .5; transition: opacity .15s; }
        .alert-close:hover { opacity: 1; }

        /* ──── OVERLAY ──── */
        #sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 30;
            backdrop-filter: blur(2px);
        }
        #sidebar-overlay.active { display: block; }

        /* ──── PAGE HEADER HELPER ──── */
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
        }
        .breadcrumb { display: flex; align-items: center; gap: 5px; font-size: 11.5px; color: var(--text-3); margin-bottom: 3px; }
        .breadcrumb .sep { color: #d1dce8; }
        .breadcrumb .current { color: var(--text-2); font-weight: 500; }
        .page-title { font-size: 18px; font-weight: 700; color: var(--text-1); letter-spacing: -.3px; }
        .page-sub   { font-size: 12px; color: var(--text-3); margin-top: 1px; }

        /* ──── CARD HELPER ──── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
        }

        /* ──── STAT CARD HELPER ──── */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex; align-items: center; gap: 14px;
        }
        .stat-icon {
            width: 42px; height: 42px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon i { font-size: 16px; }
        .stat-label { font-size: 11.5px; color: var(--text-3); font-weight: 500; margin-bottom: 2px; }
        .stat-value { font-size: 20px; font-weight: 700; color: var(--text-1); letter-spacing: -.5px; line-height: 1; }
        .stat-badge {
            font-size: 10.5px; font-weight: 600; margin-top: 4px;
            display: inline-flex; align-items: center; gap: 3px;
        }
        .badge-up   { color: #16a34a; }
        .badge-down { color: #dc2626; }

        /* ──── TABLE HELPER ──── */
        .tbl { width: 100%; border-collapse: collapse; }
        .tbl thead th {
            font-size: 11px; font-weight: 600; color: var(--text-3);
            text-transform: uppercase; letter-spacing: .06em;
            padding: 0 12px 10px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        .tbl tbody tr { transition: background .12s; }
        .tbl tbody tr:hover { background: #f8fafc; }
        .tbl tbody td {
            padding: 10px 12px;
            font-size: 13px; color: var(--text-1);
            border-bottom: 1px solid #f1f5f9;
        }
        .tbl tbody tr:last-child td { border-bottom: none; }

        /* ──── BADGE PILL ──── */
        .pill {
            display: inline-flex; align-items: center;
            padding: 2px 8px; border-radius: 99px;
            font-size: 11px; font-weight: 600;
        }
        .pill-green { background: #dcfce7; color: #16a34a; }
        .pill-red   { background: #ffe4e6; color: #dc2626; }
        .pill-blue  { background: #dbeafe; color: #2563eb; }
        .pill-amber { background: #fef3c7; color: #d97706; }
        .pill-gray  { background: #f1f5f9; color: #64748b; }

        /* ──── BUTTON ──── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            border: none; cursor: pointer;
            transition: filter .15s, transform .1s;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
        }
        .btn:active { transform: scale(.97); }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-primary:hover { filter: brightness(1.08); }
        .btn-secondary { background: var(--page-bg); color: var(--text-2); border: 1px solid var(--border); }
        .btn-secondary:hover { background: #edf2f7; }
        .btn-danger { background: var(--red); color: #fff; }
        .btn-danger:hover { filter: brightness(1.08); }
        .btn-sm { padding: 5px 10px; font-size: 12px; border-radius: 6px; }
        .btn i { font-size: 11px; }

        /* ──── FORM INPUTS ──── */
        .form-input, .form-select {
            width: 100%; padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 8px; outline: none;
            font-size: 13px; color: var(--text-1);
            font-family: 'Outfit', sans-serif;
            background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
        }
        .form-input:focus, .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px #eff6ff;
        }
        .form-label { font-size: 12px; font-weight: 600; color: var(--text-2); margin-bottom: 5px; display: block; }

        /* ──── MODAL ──── */
        #confirm-modal {
            position: fixed; inset: 0; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .22s;
        }
        #confirm-modal.show { opacity: 1; pointer-events: all; }
        #confirm-modal .m-backdrop {
            position: absolute; inset: 0;
            background: rgba(0,0,0,.4); backdrop-filter: blur(4px);
        }
        #confirm-modal .m-box {
            position: relative; z-index: 1;
            background: #fff; border-radius: 16px;
            padding: 24px 22px 20px;
            width: 90%; max-width: 340px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
            transform: scale(.94) translateY(10px);
            transition: transform .26s cubic-bezier(.34,1.56,.64,1);
            text-align: center;
        }
        #confirm-modal.show .m-box { transform: scale(1) translateY(0); }
        .m-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px; font-size: 18px;
        }
        .m-title { font-size: 14.5px; font-weight: 700; color: #111827; margin-bottom: 5px; }
        .m-desc  { font-size: 12.5px; color: #6b7280; line-height: 1.6; margin-bottom: 20px; }
        .m-actions { display: flex; gap: 8px; }
        .m-cancel {
            flex: 1; padding: 9px; border-radius: 8px;
            background: #f3f4f6; color: #4b5563;
            font-weight: 600; font-size: 13px;
            border: 1px solid #e5e7eb; cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: background .15s;
        }
        .m-cancel:hover { background: #e5e7eb; }
        .m-ok {
            flex: 1; padding: 9px; border-radius: 8px; color: #fff;
            font-weight: 600; font-size: 13px; border: none; cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: filter .15s, transform .1s;
        }
        .m-ok:hover  { filter: brightness(1.08); }
        .m-ok:active { transform: scale(.97); }

        /* ──── MOBILE ──── */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed; top: 0; left: 0; bottom: 0;
                transform: translateX(-100%);
                box-shadow: 4px 0 20px rgba(0,0,0,.15);
            }
            #sidebar.open { transform: translateX(0); }
            .search-wrap { display: none; }
            #main-scroll { padding: 14px; }
        }
        @media (max-width: 480px) {
            .user-name, .user-role, .user-chip .chev { display: none; }
            .user-chip { padding: 4px; }
            .hdr-divider { display: none; }
        }
        @media (max-width: 768px) {
    .attendance-grid {
        grid-template-columns: 1fr !important;
    }
}
    </style>
</head>
<body>

<div id="layout">

    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- ────────── SIDEBAR ────────── -->
    <aside id="sidebar">

        <div class="sb-brand">
            <div class="sb-logo"><i class="fa fa-dumbbell"></i></div>
            <div>
                <div class="sb-brand-name">UB GYM</div>
                <div class="sb-brand-sub">Kasir Panel</div>
            </div>
        </div>

        <nav id="sb-nav">

            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-home"></i></span>
                Dashboard
            </a>

            <div class="sb-section">KASIR CEPAT</div>

            <a href="{{ route('admin.attendance.index') }}"
               class="nav-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-qrcode"></i></span>
                Check-in
            </a>

            <a href="{{ route('admin.retail.index') }}"
               class="nav-item {{ request()->routeIs('admin.retail.*') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-shopping-basket"></i></span>
                Kasir Retail
            </a>

            <div class="sb-section">Membership</div>

            <a href="{{ route('admin.package.index') }}"
               class="nav-item {{ request()->routeIs('admin.package.*') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-id-card"></i></span>
                Beli Paket & Aktivasi
            </a>
            <a href="{{ route('admin.verifications.index') }}"
                class="nav-item {{ request()->routeIs('admin.verifications.*') ? 'active' : '' }}">
                 <span class="ni"><i class="fa fa-check"></i></span>
                 Verifikasi Online

            <a href="{{ route('admin.pt.index') }}"
               class="nav-item {{ request()->routeIs('admin.pt.*') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-dumbbell"></i></span>
                Sesi PT
            </a>

            <div class="sb-section">Master Data</div>

            <a href="{{ route('admin.data.members') }}"
               class="nav-item {{ request()->routeIs('admin.data.members') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-users"></i></span>
                Data Member
            </a>

            <a href="{{ route('admin.data.products') }}"
               class="nav-item {{ request()->routeIs('admin.data.products') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-box"></i></span>
                Data Produk
            </a>

            <div class="sb-section">Laporan</div>

            <a href="{{ route('admin.report.transactions') }}"
               class="nav-item {{ request()->routeIs('admin.report.transactions') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-file-invoice-dollar"></i></span>
                Riwayat Transaksi
            </a>

            <a href="{{ route('admin.report.attendance') }}"
               class="nav-item {{ request()->routeIs('admin.report.attendance') ? 'active' : '' }}">
                <span class="ni"><i class="fa fa-calendar-check"></i></span>
                Kehadiran dan PT
            </a>

        </nav>

        <div class="sb-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="button" class="logout-btn"
                    data-confirm
                    data-confirm-title="Keluar dari Sistem?"
                    data-confirm-desc="Sesi kamu akan diakhiri. Pastikan semua transaksi sudah tersimpan."
                    data-confirm-type="warning"
                    data-confirm-label="Ya, Keluar"
                    data-confirm-form="logout-form">
                    <span class="ni"><i class="fa fa-sign-out-alt"></i></span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- ────────── MAIN ────────── -->
    <div id="main-body">

        <!-- Header -->
        <header id="main-header">

            <!-- Hamburger (mobile) -->
            <button class="md:hidden hdr-btn" onclick="openSidebar()" style="flex-shrink:0">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Search -->
            <div class="search-wrap">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Cari sesuatu...">
                <span class="search-kbd">⌘K</span>
            </div>

            <!-- Spacer -->
            <div style="flex:1"></div>

            <!-- Right -->
            <div style="display:flex;align-items:center;gap:8px;">

                <div class="hdr-btn">
                    <i class="fa fa-bell"></i>
                    <span class="notif-dot"></span>
                </div>

                <div class="hdr-btn">
                    <i class="fa fa-comment-dots"></i>
                    <span class="notif-dot notif-dot-blue"></span>
                </div>

                <div class="hdr-divider"></div>

                <div class="user-chip">
                    <div class="user-avatar"><i class="fa fa-user"></i></div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Kasir</div>
                    </div>
                    <i class="fa fa-chevron-down chev"></i>
                </div>

            </div>
        </header>

        <!-- Content -->
        <main id="main-scroll">
            <div id="main-content">

                @if(session('success'))
                <div class="alert alert-success" id="flash-ok">
                    <div class="alert-icon"><i class="fa fa-check-circle"></i></div>
                    <p class="alert-text">{{ session('success') }}</p>
                    <button class="alert-close" onclick="this.closest('.alert').remove()">
                        <i class="fa fa-times" style="font-size:11px;color:#16a34a;"></i>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error" id="flash-err">
                    <div class="alert-icon"><i class="fa fa-times-circle"></i></div>
                    <p class="alert-text">{{ session('error') }}</p>
                    <button class="alert-close" onclick="this.closest('.alert').remove()">
                        <i class="fa fa-times" style="font-size:11px;color:#dc2626;"></i>
                    </button>
                </div>
                @endif

                @yield('content')

            </div>
        </main>
    </div>
</div>

<!-- ────────── CONFIRM MODAL ────────── -->
<div id="confirm-modal">
    <div class="m-backdrop" onclick="UBConfirm.cancel()"></div>
    <div class="m-box">
        <div class="m-icon" id="m-icon-wrap"><i id="m-icon" class="fa fa-question"></i></div>
        <div class="m-title" id="m-title">Konfirmasi Aksi</div>
        <div class="m-desc"  id="m-desc">Apakah kamu yakin ingin melanjutkan?</div>
        <div class="m-actions">
            <button class="m-cancel" onclick="UBConfirm.cancel()">Batal</button>
            <button class="m-ok" id="m-ok" onclick="UBConfirm.proceed()">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<script>
/* ── Sidebar ── */
function openSidebar(){
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('active');
    document.body.style.overflow='hidden';
}
function closeSidebar(){
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('active');
    document.body.style.overflow='';
}

/* ── Flash auto-dismiss ── */
['flash-ok','flash-err'].forEach(id=>{
    const el=document.getElementById(id);
    if(!el)return;
    setTimeout(()=>{
        el.style.transition='opacity .4s,transform .4s';
        el.style.opacity='0';
        el.style.transform='translateY(-6px)';
        setTimeout(()=>el.remove(),420);
    },4500);
});

/* ── ESC ── */
document.addEventListener('keydown',e=>{
    if(e.key==='Escape'){ closeSidebar(); UBConfirm.cancel(); }
});

/* ── UBConfirm ── */
const UBConfirm=(()=>{
    const modal   =document.getElementById('confirm-modal');
    const iconWrap=document.getElementById('m-icon-wrap');
    const iconEl  =document.getElementById('m-icon');
    const titleEl =document.getElementById('m-title');
    const descEl  =document.getElementById('m-desc');
    const btnOk   =document.getElementById('m-ok');

    const T={
        danger : {bg:'#fef2f2',col:'#ef4444',btn:'#ef4444',ic:'fa-exclamation-triangle'},
        warning: {bg:'#fffbeb',col:'#f59e0b',btn:'#f59e0b',ic:'fa-exclamation-circle'},
        info   : {bg:'#eff6ff',col:'#3b82f6',btn:'#3b82f6',ic:'fa-info-circle'},
        success: {bg:'#f0fdf4',col:'#22c55e',btn:'#22c55e',ic:'fa-check-circle'},
    };

    let _resolve=null,_form=null,_href=null;

    function _theme(type){
        const t=T[type]||T.danger;
        iconWrap.style.background=t.bg;
        iconEl.style.color=t.col;
        iconEl.className='fa '+t.ic;
        btnOk.style.background=t.btn;
    }
    function open(opts={}){
        _theme(opts.type||'danger');
        titleEl.textContent=opts.title||'Konfirmasi Aksi';
        descEl.textContent =opts.desc ||'Apakah kamu yakin ingin melanjutkan?';
        btnOk.textContent  =opts.label||'Ya, Lanjutkan';
        modal.classList.add('show');
    }
    function cancel(){
        modal.classList.remove('show');
        _form=null;_href=null;
        if(_resolve){_resolve(false);_resolve=null;}
    }
    function proceed(){
        modal.classList.remove('show');
        if(_form){_form.submit();_form=null;return;}
        if(_href){window.location.href=_href;_href=null;return;}
        if(_resolve){_resolve(true);_resolve=null;}
    }
    function ask(opts){
        return new Promise(res=>{_resolve=res;open(opts);});
    }
    document.addEventListener('click',e=>{
        const el=e.target.closest('[data-confirm]');
        if(!el)return;
        e.preventDefault();e.stopPropagation();
        const opts={
            title:el.dataset.confirmTitle||'Konfirmasi Aksi',
            desc :el.dataset.confirmDesc ||'Apakah kamu yakin ingin melanjutkan?',
            type :el.dataset.confirmType ||'danger',
            label:el.dataset.confirmLabel||'Ya, Lanjutkan',
        };
        if(el.tagName==='A'){ _href=el.href; }
        else {
            const fid=el.dataset.confirmForm;
            _form=fid?document.getElementById(fid):el.closest('form');
        }
        open(opts);
    },true);

    return{open,cancel,proceed,ask};
})();
</script>

@stack('scripts')
</body>
</html>