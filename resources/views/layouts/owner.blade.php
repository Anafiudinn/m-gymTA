<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') — UB GYM</title>

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- FONT AWESOME --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- GOOGLE FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Outfit',sans-serif;
        }

        :root{

            --sidebar-width:260px;
            --header-height:64px;

            --bg:#f5f5f5;
            --surface:#ffffff;
            --surface-2:#f9f9f9;

            --border:rgba(0,0,0,.08);

            --text:#111111;
            --muted:#444444;

            --red:#ef4444;
            --red-dark:#dc2626;

            --shadow:
                0 4px 20px rgba(0,0,0,.06);

            /* ALERT COLORS */
            --alert-success-bg:#f0fdf4;
            --alert-success-border:#86efac;
            --alert-success-text:#166534;
            --alert-success-icon:#22c55e;
            --alert-success-bar:#22c55e;

            --alert-error-bg:#fef2f2;
            --alert-error-border:#fca5a5;
            --alert-error-text:#991b1b;
            --alert-error-icon:#ef4444;
            --alert-error-bar:#ef4444;

            --alert-warning-bg:#fffbeb;
            --alert-warning-border:#fcd34d;
            --alert-warning-text:#92400e;
            --alert-warning-icon:#f59e0b;
            --alert-warning-bar:#f59e0b;

            --alert-info-bg:#eff6ff;
            --alert-info-border:#93c5fd;
            --alert-info-text:#1e40af;
            --alert-info-icon:#3b82f6;
            --alert-info-bar:#3b82f6;

        }

        html,
        body{
            width:100%;
            height:100%;
            overflow:hidden;
            background:var(--bg);
            color:var(--text);
        }

        body{
            background:
                radial-gradient(circle at top right,
                    rgba(239,68,68,.05),
                    transparent 30%),
                var(--bg);
        }

        a{
            text-decoration:none;
        }

        button{
            font-family:'Outfit',sans-serif;
        }

        /* =========================================================
            LAYOUT
        ========================================================= */

        #layout{
            width:100%;
            height:100vh;
            display:flex;
            overflow:hidden;
        }

        /* =========================================================
            SIDEBAR
        ========================================================= */

        #sidebar{
            width:var(--sidebar-width);
            height:100vh;

            background:var(--surface);

            border-right:1px solid var(--border);

            display:flex;
            flex-direction:column;

            flex-shrink:0;

            transition:.3s ease;

            z-index:100;
        }

        /* BRAND */

        .sb-brand{
            height:var(--header-height);

            display:flex;
            align-items:center;
            gap:14px;

            padding:0 22px;

            border-bottom:1px solid var(--border);

            flex-shrink:0;
        }

        .sb-logo{
            width:42px;
            height:42px;

            border-radius:1px;

            background:
                linear-gradient(
                    135deg,
                    var(--red),
                    #991b1b
                );

            display:flex;
            align-items:center;
            justify-content:center;

            box-shadow:
                0 6px 18px rgba(239,68,68,.22);
        }

        .sb-logo svg{
            width:18px;
            height:18px;
        }

        .sb-brand-name{
            font-size:16px;
            font-weight:800;
            color:#111;
            letter-spacing:-.03em;
        }

        .sb-brand-sub{
            font-size:10px;
            color:#aaa;
            letter-spacing:.16em;
            text-transform:uppercase;
            margin-top:2px;
        }

        /* NAV */

        #sb-nav{
            flex:1;
            overflow-y:auto;
            overflow-x:hidden;
            padding:14px 0;
        }

        #sb-nav::-webkit-scrollbar{
            width:0;
        }

        .sb-section{
            padding:18px 22px 10px;

            color:#bbb;

            font-size:10px;
            font-weight:800;

            text-transform:uppercase;
            letter-spacing:.14em;
        }

        .nav-item{
            margin:4px 12px;

            padding:11px 13px;

            border-radius:1px;

            display:flex;
            align-items:center;
            gap:12px;

            color:#777;

            transition:.18s ease;

            position:relative;
        }

        .nav-item:hover{
            background:#f5f5f5;
            color:#111;
            transform:translateX(2px);
        }

        .nav-item.active{
            background:
                linear-gradient(
                    135deg,
                    rgba(239,68,68,.10),
                    rgba(239,68,68,.04)
                );

            border:1px solid rgba(239,68,68,.18);

            color:#c0392b;
        }

        .ni{
            width:36px;
            height:36px;

            border-radius:1px;

            background:rgba(0,0,0,.04);

            display:flex;
            align-items:center;
            justify-content:center;

            flex-shrink:0;

            transition:.18s ease;
        }

        .nav-item:hover .ni{
            background:rgba(0,0,0,.07);
        }

        .nav-item.active .ni{
            background:rgba(239,68,68,.12);
            color:var(--red);
        }

        .ni svg{
            width:15px;
            height:15px;
        }

        .nav-label{
            font-size:13px;
            font-weight:700;
        }

        /* FOOTER */

        .sb-footer{
            padding:14px;
            border-top:1px solid var(--border);
            background:rgba(0,0,0,.01);
        }

        .sb-user{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:12px;
        }

        .sb-avatar{
            width:44px;
            height:44px;

            border-radius:1px;

            background:
                linear-gradient(
                    135deg,
                    var(--red),
                    #991b1b
                );

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:13px;
            font-weight:800;

            color:#fff;
        }

        .sb-uname{
            font-size:13px;
            font-weight:700;
            color:#111;
        }

        .sb-urole{
            font-size:11px;
            color:#aaa;
            margin-top:2px;
        }

        .logout-btn{
            width:100%;

            border:none;
            cursor:pointer;

            display:flex;
            align-items:center;
            gap:10px;

            padding:11px 13px;

            border-radius:1px;

            background:rgba(239,68,68,.07);

            color:var(--red);

            transition:.18s ease;
        }

        .logout-btn:hover{
            background:rgba(239,68,68,.13);
        }

        /* =========================================================
            MAIN
        ========================================================= */

        #main-body{
            flex:1;

            min-width:0;

            display:flex;
            flex-direction:column;

            overflow:hidden;
        }

        /* =========================================================
            HEADER
        ========================================================= */

        #main-header{
            height:var(--header-height);

            display:flex;
            align-items:center;

            padding:0 22px;

            background:rgba(255,255,255,.92);

            backdrop-filter:blur(12px);

            border-bottom:1px solid var(--border);

            flex-shrink:0;

            z-index:50;
        }

        .mobile-menu-btn{
            display:none;

            width:42px;
            height:42px;

            border:none;

            border-radius:1px;

            background:rgba(0,0,0,.04);

            color:#111;

            align-items:center;
            justify-content:center;

            cursor:pointer;

            margin-right:12px;
        }

        .mobile-menu-btn svg{
            width:18px;
            height:18px;
        }

        .hdr-title{
            font-size:15px;
            font-weight:700;
            color:#111;
        }

        .hdr-right{
            margin-left:auto;

            display:flex;
            align-items:center;
            gap:12px;
        }

        .hdr-btn{
            width:42px;
            height:42px;

            border-radius:1px;

            border:1px solid var(--border);

            background:rgba(0,0,0,.02);

            display:flex;
            align-items:center;
            justify-content:center;

            color:#555;

            cursor:pointer;

            transition:.18s ease;

            position:relative;
        }

        .hdr-btn:hover{
            background:rgba(0,0,0,.05);
            color:#111;
        }

        .hdr-btn svg{
            width:16px;
            height:16px;
        }

        .notif-dot{
            width:7px;
            height:7px;

            border-radius:1px;

            background:var(--red);

            position:absolute;
            top:9px;
            right:9px;
        }

        .user-chip{
            display:flex;
            align-items:center;
            gap:10px;

            padding:5px 12px 5px 5px;

            border-radius:1px;

            border:1px solid var(--border);

            background:rgba(0,0,0,.02);
        }

        .uc-avatar{
            width:36px;
            height:36px;

            border-radius:1px;

            background:
                linear-gradient(
                    135deg,
                    var(--red),
                    #991b1b
                );

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:11px;
            font-weight:800;

            color:#fff;
        }

        .uc-name{
            font-size:13px;
            font-weight:700;
            color:#111;
        }

        .uc-role{
            font-size:11px;
            color:#aaa;
        }

        /* =========================================================
            CONTENT
        ========================================================= */

        #main-scroll{
            flex:1;

            overflow-y:auto;

            padding:24px;

            background:var(--bg);
        }

        #main-scroll::-webkit-scrollbar{
            width:5px;
        }

        #main-scroll::-webkit-scrollbar-thumb{
            background:rgba(0,0,0,.10);
            border-radius:1px;
        }

        #main-content{
            animation:fadeUp .35s ease;
        }

        @keyframes fadeUp{

            from{
                opacity:0;
                transform:translateY(10px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }

        }

        /* =========================================================
            CARD
        ========================================================= */

        .card{
            background:var(--surface);

            border:1px solid var(--border);

            border-radius:1px;

            padding:18px;

            box-shadow:var(--shadow);
        }

        /* =========================================================
            OVERLAY
        ========================================================= */

        #sidebar-overlay{
            position:fixed;
            inset:0;

            background:rgba(0,0,0,.35);

            backdrop-filter:blur(4px);

            opacity:0;
            visibility:hidden;

            transition:.25s ease;

            z-index:90;
        }

        #sidebar-overlay.active{
            opacity:1;
            visibility:visible;
        }

        /* =========================================================
            ALERT / TOAST SYSTEM
        ========================================================= */

        #alert-container{
            position:fixed;
            top:20px;
            right:20px;

            z-index:9999;

            display:flex;
            flex-direction:column;
            gap:10px;

            pointer-events:none;

            max-width:360px;
            width:calc(100vw - 40px);
        }

        .alert-toast{
            pointer-events:all;

            background:var(--surface);
            border:1px solid var(--border);
            border-radius:1px;

            box-shadow:
                0 8px 32px rgba(0,0,0,.10),
                0 2px 8px rgba(0,0,0,.06);

            overflow:hidden;

            display:flex;
            flex-direction:column;

            /* ANIMATE IN */
            animation: alertSlideIn .28s cubic-bezier(.34,1.56,.64,1) forwards;

            /* dismiss */
            transition: opacity .22s ease, transform .22s ease, margin-top .22s ease, max-height .22s ease;
        }

        .alert-toast.dismissing{
            opacity:0;
            transform:translateX(16px);
            max-height:0 !important;
            margin-top:-10px;
            pointer-events:none;
        }

        @keyframes alertSlideIn{
            from{
                opacity:0;
                transform:translateX(24px);
            }
            to{
                opacity:1;
                transform:translateX(0);
            }
        }

        .alert-body{
            display:flex;
            align-items:flex-start;
            gap:12px;
            padding:14px 14px 12px;
        }

        .alert-icon-wrap{
            width:34px;
            height:34px;
            border-radius:1px;
            flex-shrink:0;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:14px;
        }

        .alert-text-wrap{
            flex:1;
            min-width:0;
        }

        .alert-title{
            font-size:13px;
            font-weight:700;
            line-height:1.3;
        }

        .alert-msg{
            font-size:12px;
            font-weight:500;
            margin-top:3px;
            line-height:1.45;
            opacity:.75;
        }

        .alert-close{
            background:none;
            border:none;
            cursor:pointer;
            padding:4px;
            border-radius:1px;
            display:flex;
            align-items:center;
            justify-content:center;
            opacity:.45;
            transition:.15s ease;
            font-size:12px;
            align-self:flex-start;
            margin-top:2px;
        }

        .alert-close:hover{
            opacity:1;
        }

        /* PROGRESS BAR */

        .alert-progress{
            height:3px;
            width:100%;
            background:rgba(0,0,0,.06);
        }

        .alert-progress-bar{
            height:100%;
            width:100%;
            border-radius:0;
            transform-origin:left;
            transition:transform linear;
        }

        /* TYPE VARIANTS */

        /* SUCCESS */
        .alert-toast.success{
            border-color: var(--alert-success-border);
        }
        .alert-toast.success .alert-icon-wrap{
            background:rgba(34,197,94,.12);
            color:var(--alert-success-icon);
        }
        .alert-toast.success .alert-title{
            color:var(--alert-success-text);
        }
        .alert-toast.success .alert-progress-bar{
            background:var(--alert-success-bar);
        }
        .alert-toast.success .alert-close{
            color:var(--alert-success-text);
        }

        /* ERROR */
        .alert-toast.error{
            border-color: var(--alert-error-border);
        }
        .alert-toast.error .alert-icon-wrap{
            background:rgba(239,68,68,.12);
            color:var(--alert-error-icon);
        }
        .alert-toast.error .alert-title{
            color:var(--alert-error-text);
        }
        .alert-toast.error .alert-progress-bar{
            background:var(--alert-error-bar);
        }
        .alert-toast.error .alert-close{
            color:var(--alert-error-text);
        }

        /* WARNING */
        .alert-toast.warning{
            border-color: var(--alert-warning-border);
        }
        .alert-toast.warning .alert-icon-wrap{
            background:rgba(245,158,11,.12);
            color:var(--alert-warning-icon);
        }
        .alert-toast.warning .alert-title{
            color:var(--alert-warning-text);
        }
        .alert-toast.warning .alert-progress-bar{
            background:var(--alert-warning-bar);
        }
        .alert-toast.warning .alert-close{
            color:var(--alert-warning-text);
        }

        /* INFO */
        .alert-toast.info{
            border-color: var(--alert-info-border);
        }
        .alert-toast.info .alert-icon-wrap{
            background:rgba(59,130,246,.12);
            color:var(--alert-info-icon);
        }
        .alert-toast.info .alert-title{
            color:var(--alert-info-text);
        }
        .alert-toast.info .alert-progress-bar{
            background:var(--alert-info-bar);
        }
        .alert-toast.info .alert-close{
            color:var(--alert-info-text);
        }

        /* =========================================================
            RESPONSIVE
        ========================================================= */

        @media(max-width:768px){

            #sidebar{
                position:fixed;
                left:0;
                top:0;

                transform:translateX(-100%);
            }

            #sidebar.open{
                transform:translateX(0);
            }

            .mobile-menu-btn{
                display:flex;
            }

            #main-scroll{
                padding:16px;
            }

            #alert-container{
                top:auto;
                bottom:20px;
                right:12px;
                left:12px;
                max-width:100%;
                width:auto;
            }

        }

        @media(max-width:480px){

            .uc-name,
            .uc-role{
                display:none;
            }

            .user-chip{
                padding:5px;
            }

            #main-header{
                padding:0 14px;
            }

            #main-scroll{
                padding:14px;
            }

            .card{
                padding:18px;
                border-radius:1px;
            }

        }

    </style>
</head>
<body>

{{-- =========================================================
    ALERT CONTAINER
========================================================= --}}
<div id="alert-container"></div>

<div id="layout">

    {{-- OVERLAY --}}
    <div id="sidebar-overlay"
        onclick="closeSidebar()"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar">

        {{-- BRAND --}}
        <div class="sb-brand">

            <div class="sb-logo">

                <svg viewBox="0 0 24 24"
                    fill="none"
                    stroke="#fff"
                    stroke-width="2">

                    <rect x="2" y="9"
                        width="3"
                        height="6"
                        rx="1.5"/>

                    <rect x="19" y="9"
                        width="3"
                        height="6"
                        rx="1.5"/>

                    <rect x="5"
                        y="7"
                        width="3"
                        height="10"
                        rx="1.5"/>

                    <rect x="16"
                        y="7"
                        width="3"
                        height="10"
                        rx="1.5"/>

                    <line x1="8"
                        y1="12"
                        x2="16"
                        y2="12"/>

                </svg>

            </div>

            <div>

                <div class="sb-brand-name">
                    UB GYM
                </div>

                <div class="sb-brand-sub">
                    OWNER PANEL
                </div>

            </div>

        </div>

        {{-- NAV --}}
        <nav id="sb-nav">

            {{-- DASHBOARD --}}
            <a href="{{ route('owner.dashboard') }}"
                class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-chart-line"></i>
                </span>

                <span class="nav-label">
                    Dashboard
                </span>

            </a>

            {{-- MANAJEMEN --}}
            <div class="sb-section">
                Manajemen
            </div>

            <a href="{{ route('owner.admins.index') }}"
                class="nav-item {{ request()->routeIs('owner.admins.*') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-user-shield"></i>
                </span>

                <span class="nav-label">
                    Kelola Admin
                </span>

            </a>

            <a href="{{ route('owner.members.index') }}"
                class="nav-item {{ request()->routeIs('owner.members.*') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-users"></i>
                </span>

                <span class="nav-label">
                    Monitoring Member
                </span>

            </a>

            <a href="{{ route('owner.products.index') }}"
                class="nav-item {{ request()->routeIs('owner.products.*') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-box"></i>
                </span>

                <span class="nav-label">
                    Monitoring Produk
                </span>

            </a>

            <a href="{{ route('owner.pt-packages.index') }}"
                class="nav-item {{ request()->routeIs('owner.pt-packages.*') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-dumbbell"></i>
                </span>

                <span class="nav-label">
                    Paket PT
                </span>

            </a>

            {{-- LAPORAN --}}
            <div class="sb-section">
                Laporan
            </div>

            <a href="{{ route('owner.reports.transactions') }}"
                class="nav-item {{ request()->routeIs('owner.reports.transactions') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-chart-column"></i>
                </span>

                <span class="nav-label">
                    Laporan Transaksi
                </span>

            </a>

            <a href="{{ route('owner.reports.attendance') }}"
                class="nav-item {{ request()->routeIs('owner.reports.attendance') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-clipboard-check"></i>
                </span>

                <span class="nav-label">
                    Laporan Kehadiran
                </span>

            </a>

            {{-- PENGATURAN --}}
            <div class="sb-section">
                Pengaturan
            </div>

            <a href="{{ route('owner.settings.index') }}"
                class="nav-item {{ request()->routeIs('owner.settings.*') ? 'active' : '' }}">

                <span class="ni">
                    <i class="fa-solid fa-gear"></i>
                </span>

                <span class="nav-label">
                    Pengaturan Harga
                </span>

            </a>

        </nav>

        {{-- FOOTER --}}
        <div class="sb-footer">

            <div class="sb-user">

                <div class="sb-avatar">
                    {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                </div>

                <div>

                    <div class="sb-uname">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="sb-urole">
                        Owner
                    </div>

                </div>

            </div>

            <form method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="logout-btn">

                    <span class="ni">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </span>

                    Keluar

                </button>

            </form>

        </div>

    </aside>

    {{-- MAIN --}}
    <main id="main-body">

        {{-- HEADER --}}
        <header id="main-header">

            {{-- MOBILE BTN --}}
            <button class="mobile-menu-btn"
                onclick="openSidebar()">

                <svg viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">

                    <line x1="3"
                        y1="6"
                        x2="21"
                        y2="6"/>

                    <line x1="3"
                        y1="12"
                        x2="21"
                        y2="12"/>

                    <line x1="3"
                        y1="18"
                        x2="21"
                        y2="18"/>

                </svg>

            </button>

            <div class="hdr-title">
                @yield('header-title','Dashboard')
            </div>

            <div class="hdr-right">

                {{-- NOTIF --}}
                <button class="hdr-btn">

                    <i class="fa-regular fa-bell"></i>

                    <span class="notif-dot"></span>

                </button>

                {{-- USER --}}
                <div class="user-chip">

                    <div class="uc-avatar">
                        {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                    </div>

                    <div>

                        <div class="uc-name">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="uc-role">
                            Owner
                        </div>

                    </div>

                </div>

            </div>

        </header>

        {{-- CONTENT --}}
        <section id="main-scroll">

            <div id="main-content">

                @yield('content')

            </div>

        </section>

    </main>

</div>

{{-- =========================================================
    SCRIPT
========================================================= --}}
<script>

    /* =========================================================
        SIDEBAR
    ========================================================= */

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function openSidebar(){
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar(){
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    window.addEventListener('resize', function(){
        if(window.innerWidth > 768){
            closeSidebar();
        }
    });

    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => {
            if(window.innerWidth <= 768){
                closeSidebar();
            }
        });
    });

    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape'){
            closeSidebar();
        }
    });

    /* =========================================================
        ALERT / TOAST SYSTEM
    ========================================================= */

    const ALERT_ICONS = {
        success : 'fa-solid fa-circle-check',
        error   : 'fa-solid fa-circle-xmark',
        warning : 'fa-solid fa-triangle-exclamation',
        info    : 'fa-solid fa-circle-info',
    };

    const ALERT_TITLES = {
        success : 'Berhasil!',
        error   : 'Gagal!',
        warning : 'Perhatian!',
        info    : 'Informasi',
    };

    /**
     * showAlert(type, message, options)
     *
     * @param {string} type     - 'success' | 'error' | 'warning' | 'info'
     * @param {string} message  - Pesan yang ditampilkan
     * @param {object} options
     *   @param {string}  options.title    - Override judul (opsional)
     *   @param {number}  options.duration - Durasi ms sebelum auto-dismiss (default 4000; 0 = tidak auto-dismiss)
     */
    function showAlert(type = 'info', message = '', options = {}){

        const {
            title    = ALERT_TITLES[type] || 'Notifikasi',
            duration = 4000,
        } = options;

        const container = document.getElementById('alert-container');

        /* --- BUILD ELEMENT --- */
        const toast = document.createElement('div');
        toast.className = `alert-toast ${type}`;

        toast.innerHTML = `
            <div class="alert-body">
                <div class="alert-icon-wrap">
                    <i class="${ALERT_ICONS[type] || 'fa-solid fa-bell'}"></i>
                </div>
                <div class="alert-text-wrap">
                    <div class="alert-title">${escHtml(title)}</div>
                    ${message ? `<div class="alert-msg">${escHtml(message)}</div>` : ''}
                </div>
                <button class="alert-close" title="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="alert-progress">
                <div class="alert-progress-bar"></div>
            </div>
        `;

        container.appendChild(toast);

        /* force reflow so transition works */
        toast.getBoundingClientRect();

        /* --- CLOSE HANDLER --- */
        const closeBtn = toast.querySelector('.alert-close');
        closeBtn.addEventListener('click', () => dismissToast(toast));

        /* --- AUTO DISMISS WITH PROGRESS BAR --- */
        if(duration > 0){

            const bar = toast.querySelector('.alert-progress-bar');

            /* kick off shrink animation */
            requestAnimationFrame(() => {
                bar.style.transition = `transform ${duration}ms linear`;
                bar.style.transform  = 'scaleX(0)';
            });

            const timer = setTimeout(() => dismissToast(toast), duration);

            /* pause on hover */
            let remaining  = duration;
            let startedAt  = Date.now();

            toast.addEventListener('mouseenter', () => {
                clearTimeout(timer);
                remaining -= Date.now() - startedAt;
                bar.style.transition = 'none';
            });

            toast.addEventListener('mouseleave', () => {
                startedAt = Date.now();
                bar.style.transition = `transform ${remaining}ms linear`;
                bar.style.transform  = 'scaleX(0)';
                setTimeout(() => dismissToast(toast), remaining);
            });
        } else {
            /* hide progress bar if no auto-dismiss */
            toast.querySelector('.alert-progress').style.display = 'none';
        }
    }

    function dismissToast(toast){
        if(toast.classList.contains('dismissing')) return;
        toast.classList.add('dismissing');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        /* fallback in case transitionend doesn't fire */
        setTimeout(() => toast.remove(), 400);
    }

    function escHtml(str){
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    /* =========================================================
        AUTO-FIRE FROM LARAVEL SESSION FLASH
        Di controller: return redirect()->with('success', 'Data disimpan');
    ========================================================= */

    document.addEventListener('DOMContentLoaded', () => {

        @if(session('success'))
            showAlert('success', @json(session('success')));
        @endif

        @if(session('error'))
            showAlert('error', @json(session('error')));
        @endif

        @if(session('warning'))
            showAlert('warning', @json(session('warning')));
        @endif

        @if(session('info'))
            showAlert('info', @json(session('info')));
        @endif

        {{-- Validasi errors dari Laravel (opsional, ring summary) --}}
        @if($errors->any())
            showAlert('error', 'Periksa kembali form — ada {{ $errors->count() }} kesalahan.', { duration: 6000 });
        @endif

    });

</script>

</body>
</html>