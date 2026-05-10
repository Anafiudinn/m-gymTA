<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — UB GYM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        * { font-family: 'Outfit', sans-serif; }

        :root {
            --sb-w:        240px;
            --hdr-h:       56px;

            --sb-bg:       #1c2434;
            --sb-bg-hover: #253047;
            --sb-bg-active:#2e3c52;
            --sb-border:   #2a3448;
            --sb-text:     #adb8cc;
            --sb-text-act: #ffffff;
            --sb-section:  #5a6a82;
            --sb-accent:   #4d80e4;

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
        .sb-logo svg { width: 16px; height: 16px; }
        .sb-brand-name { font-size: 16px; font-weight: 700; color: #fff; letter-spacing: -.2px; }
        .sb-brand-sub  { font-size: 10px; color: var(--sb-section); font-weight: 500; letter-spacing: .05em; text-transform: uppercase; line-height: 1; }

        /* Nav scroll */
        #sb-nav { flex: 1; overflow-y: auto; padding: 8px 0 12px; }
        #sb-nav::-webkit-scrollbar { width: 0; }

        /* Section label */
        .sb-section {
            padding: 16px 18px 5px;
            font-size: 10px; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: var(--sb-section);
        }

        /* Nav item */
        .nav-item {
            display: flex; align-items: center; gap: 9px;
            margin: 1px 10px;
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 13px; font-weight: 500;
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
        .nav-item .ni svg { width: 13px; height: 13px; color: var(--sb-text); transition: color .15s; }
        .nav-item:hover { background: var(--sb-bg-hover); color: #e2e8f0; }
        .nav-item:hover .ni { background: rgba(255,255,255,.1); }
        .nav-item:hover .ni svg { color: #e2e8f0; }
        .nav-item.active { background: var(--sb-bg-active); color: var(--sb-text-act); }
        .nav-item.active .ni { background: var(--sb-accent); }
        .nav-item.active .ni svg { color: #fff; }

        /* Sidebar footer */
        .sb-footer { border-top: 1px solid var(--sb-border); padding: 10px; }

        /* User info in footer */
        .sb-user {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 10px 6px;
        }
        .sb-avatar {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg, var(--sb-accent), #6366f1);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .sb-uname { font-size: 12.5px; font-weight: 600; color: #e2e8f0; line-height: 1.2; }
        .sb-urole { font-size: 10px; color: var(--sb-section); line-height: 1.2; }

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
        .logout-btn .ni svg { width: 13px; height: 13px; color: #f87171; }
        .logout-btn:hover { background: rgba(239,68,68,.1); }

        /* ──── MAIN BODY ──── */
        #main-body { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; }

        /* ──── HEADER ──── */
        #main-header {
            height: var(--hdr-h);
            background: var(--hdr-bg);
            border-bottom: 1px solid var(--hdr-border);
            display: flex; align-items: center;
            padding: 0 20px; gap: 10px;
            flex-shrink: 0; z-index: 20;
        }
        .hdr-title { font-size: 13.5px; font-weight: 600; color: var(--text-1); }

        .hdr-btn {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: var(--page-bg); border: 1px solid var(--border);
            color: var(--text-2); cursor: pointer;
            transition: background .15s, border-color .15s;
            position: relative; flex-shrink: 0;
        }
        .hdr-btn:hover { background: #edf2f7; border-color: #d1dce8; }
        .hdr-btn svg { width: 15px; height: 15px; }
        .notif-dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--red); border: 2px solid #fff;
        }
        .hdr-divider { width: 1px; height: 26px; background: var(--border); flex-shrink: 0; }

        .user-chip {
            display: flex; align-items: center; gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 8px; border: 1px solid var(--border);
            background: var(--page-bg); cursor: pointer;
            transition: background .15s, border-color .15s; flex-shrink: 0;
        }
        .user-chip:hover { background: #edf2f7; border-color: #d1dce8; }
        .uc-avatar {
            width: 28px; height: 28px; border-radius: 6px;
            background: #1c2434;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .uc-name { font-size: 12.5px; font-weight: 600; color: var(--text-1); line-height: 1.2; }
        .uc-role { font-size: 10px; color: var(--text-3); line-height: 1.2; }

        /* ──── CONTENT ──── */
        #main-scroll { flex: 1; overflow-y: auto; padding: 20px; }
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
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .alert-success .alert-icon { background: #dcfce7; }
        .alert-error   .alert-icon { background: #ffe4e6; }
        .alert-success .alert-icon svg { width: 13px; height: 13px; color: #16a34a; }
        .alert-error   .alert-icon svg { width: 13px; height: 13px; color: #dc2626; }
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
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px; gap: 12px; flex-wrap: wrap; }
        .breadcrumb { display: flex; align-items: center; gap: 5px; font-size: 11.5px; color: var(--text-3); margin-bottom: 3px; }
        .breadcrumb .sep { color: #d1dce8; }
        .breadcrumb .current { color: var(--text-2); font-weight: 500; }
        .page-title { font-size: 18px; font-weight: 700; color: var(--text-1); letter-spacing: -.3px; }
        .page-sub   { font-size: 12px; color: var(--text-3); margin-top: 1px; }

        /* ──── CARD ──── */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 16px; }

        /* ──── STAT CARD ──── */
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; }
        .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon svg { width: 18px; height: 18px; }
        .stat-label { font-size: 11.5px; color: var(--text-3); font-weight: 500; margin-bottom: 2px; }
        .stat-value { font-size: 20px; font-weight: 700; color: var(--text-1); letter-spacing: -.5px; line-height: 1; }
        .stat-badge { font-size: 10.5px; font-weight: 600; margin-top: 4px; display: inline-flex; align-items: center; gap: 3px; }
        .badge-up   { color: #16a34a; }
        .badge-down { color: #dc2626; }

        /* ──── TABLE ──── */
        .tbl { width: 100%; border-collapse: collapse; }
        .tbl thead th { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .06em; padding: 0 12px 10px; text-align: left; border-bottom: 1px solid var(--border); }
        .tbl tbody tr { transition: background .12s; }
        .tbl tbody tr:hover { background: #f8fafc; }
        .tbl tbody td { padding: 10px 12px; font-size: 13px; color: var(--text-1); border-bottom: 1px solid #f1f5f9; }
        .tbl tbody tr:last-child td { border-bottom: none; }

        /* ──── BADGE PILL ──── */
        .pill { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 99px; font-size: 11px; font-weight: 600; }
        .pill-green { background: #dcfce7; color: #16a34a; }
        .pill-red   { background: #ffe4e6; color: #dc2626; }
        .pill-blue  { background: #dbeafe; color: #2563eb; }
        .pill-amber { background: #fef3c7; color: #d97706; }
        .pill-gray  { background: #f1f5f9; color: #64748b; }

        /* ──── BUTTON ──── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: filter .15s, transform .1s; font-family: 'Outfit', sans-serif; text-decoration: none; }
        .btn:active { transform: scale(.97); }
        .btn-primary   { background: var(--blue); color: #fff; }
        .btn-primary:hover { filter: brightness(1.08); }
        .btn-secondary { background: var(--page-bg); color: var(--text-2); border: 1px solid var(--border); }
        .btn-secondary:hover { background: #edf2f7; }
        .btn-danger    { background: var(--red); color: #fff; }
        .btn-danger:hover { filter: brightness(1.08); }
        .btn-dark      { background: var(--sb-bg); color: #fff; }
        .btn-dark:hover { filter: brightness(1.15); }
        .btn-sm { padding: 5px 10px; font-size: 12px; border-radius: 6px; }
        .btn svg { width: 13px; height: 13px; }

        /* ──── FORM ──── */
        .form-input, .form-select { width: 100%; padding: 8px 11px; border: 1px solid var(--border); border-radius: 8px; outline: none; font-size: 13px; color: var(--text-1); font-family: 'Outfit', sans-serif; background: var(--surface); transition: border-color .15s, box-shadow .15s; }
        .form-input:focus, .form-select:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px #eff6ff; }
        .form-label { font-size: 12px; font-weight: 600; color: var(--text-2); margin-bottom: 5px; display: block; }

        /* ──── MOBILE ──── */
        @media (max-width: 767px) {
            #sidebar { position: fixed; top: 0; left: 0; bottom: 0; transform: translateX(-100%); box-shadow: 4px 0 20px rgba(0,0,0,.15); }
            #sidebar.open { transform: translateX(0); }
            #main-scroll { padding: 14px; }
        }
        @media (max-width: 480px) {
            .uc-name, .uc-role, .uc-chev { display: none; }
            .user-chip { padding: 4px; }
            .hdr-divider { display: none; }
        }
    </style>
</head>
<body>

<div id="layout">

    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- ────────── SIDEBAR ────────── -->
    <aside id="sidebar">

        <!-- Brand -->
        <div class="sb-brand">
            <div class="sb-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="9" width="3" height="6" rx="1.5"/>
                    <rect x="19" y="9" width="3" height="6" rx="1.5"/>
                    <rect x="5" y="7" width="3" height="10" rx="1.5"/>
                    <rect x="16" y="7" width="3" height="10" rx="1.5"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
            </div>
            <div>
                <div class="sb-brand-name">UB GYM</div>
                <div class="sb-brand-sub">Owner Panel</div>
            </div>
        </div>

        <!-- Nav -->
        <nav id="sb-nav">

            <a href="{{ route('owner.dashboard') }}"
               class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                <span class="ni">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="8" rx="2"/>
                        <rect x="14" y="3" width="7" height="4" rx="2"/>
                        <rect x="14" y="11" width="7" height="10" rx="2"/>
                        <rect x="3" y="15" width="7" height="6" rx="2"/>
                    </svg>
                </span>
                Dashboard
            </a>

            <div class="sb-section">Manajemen</div>

            <a href="{{ route('owner.admins') }}"
               class="nav-item {{ request()->routeIs('owner.admins') ? 'active' : '' }}">
                <span class="ni">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <circle cx="8" cy="12" r="2.5"/>
                        <path d="M13 10h5M13 14h3"/>
                    </svg>
                </span>
                Kelola Admin
            </a>

            <a href="{{ route('owner.pt-packages') }}"
               class="nav-item {{ request()->routeIs('owner.pt-packages') ? 'active' : '' }}">
                <span class="ni">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1.5" y="9.5" width="3" height="5" rx="1.5"/>
                        <rect x="19.5" y="9.5" width="3" height="5" rx="1.5"/>
                        <rect x="4.5" y="7.5" width="3" height="9" rx="1.5"/>
                        <rect x="16.5" y="7.5" width="3" height="9" rx="1.5"/>
                        <line x1="7.5" y1="12" x2="16.5" y2="12"/>
                    </svg>
                </span>
                Paket PT
            </a>

            <div class="sb-section">Pengaturan</div>

            <a href="{{ route('owner.settings') }}"
               class="nav-item {{ request()->routeIs('owner.settings') ? 'active' : '' }}">
                <span class="ni">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                        <circle cx="7" cy="7" r="1.5" fill="currentColor" stroke="none"/>
                    </svg>
                </span>
                Pengaturan Harga
            </a>

            <div class="sb-section">Laporan</div>

            <a href="{{ route('owner.reports') }}"
               class="nav-item {{ request()->routeIs('owner.reports') ? 'active' : '' }}">
                <span class="ni">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/>
                        <line x1="12" y1="20" x2="12" y2="4"/>
                        <line x1="6"  y1="20" x2="6"  y2="14"/>
                        <line x1="2"  y1="20" x2="22" y2="20"/>
                    </svg>
                </span>
                Laporan
            </a>

        </nav>

        <!-- Footer -->
        <div class="sb-footer">
            <!-- User info -->
            <div class="sb-user">
                <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div style="min-width:0">
                    <div class="sb-uname" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</div>
                    <div class="sb-urole">Owner</div>
                </div>
            </div>
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="ni">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </span>
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
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6"  x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            <!-- Page title -->
            <span class="hdr-title hidden md:block">@yield('title', 'Dashboard')</span>

            <!-- Spacer -->
            <div style="flex:1"></div>

            <!-- Right -->
            <div style="display:flex;align-items:center;gap:8px;">

                <div class="hdr-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                    <span class="notif-dot"></span>
                </div>

                <div class="hdr-divider"></div>

                <div class="user-chip">
                    <div class="uc-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="hidden sm:block">
                        <div class="uc-name">{{ Auth::user()->name }}</div>
                        <div class="uc-role">Owner</div>
                    </div>
                    <svg class="uc-chev hidden sm:block" style="width:10px;height:10px;color:#94a3b8;margin-left:2px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

            </div>
        </header>

        <!-- Content -->
        <main id="main-scroll">
            <div id="main-content">

                @if(session('success'))
                <div class="alert alert-success" id="flash-ok">
                    <div class="alert-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <p class="alert-text">{{ session('success') }}</p>
                    <button class="alert-close" onclick="this.closest('.alert').remove()">
                        <svg style="width:11px;height:11px;color:#16a34a;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error" id="flash-err">
                    <div class="alert-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <p class="alert-text">{{ session('error') }}</p>
                    <button class="alert-close" onclick="this.closest('.alert').remove()">
                        <svg style="width:11px;height:11px;color:#dc2626;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-error">
                    <div class="alert-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div style="flex:1">
                        @foreach($errors->all() as $error)
                            <p class="alert-text" style="margin-bottom:2px;">— {{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                @yield('content')

            </div>
        </main>
    </div>
</div>

<script>
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
document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeSidebar(); });

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
</script>

@stack('scripts')
</body>
</html>