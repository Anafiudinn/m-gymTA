<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — UB GYM Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0; padding:0;
            box-sizing:border-box;
            font-family:'Outfit',sans-serif;
        }

        :root{
            --sidebar-width:256px;
            --sidebar-collapsed:60px;
            --header-height:60px;
            --bg:#f4f4f4;
            --surface:#ffffff;
            --border:rgba(0,0,0,.09);
            --text:#111111;
            --muted:#888;
            --red:#ef4444;
            --red-dark:#dc2626;
            --shadow:0 2px 12px rgba(0,0,0,.06);
            --radius:1px;
        }

        html, body{
            width:100%; height:100%;
            overflow:hidden;
            background:var(--bg);
            color:var(--text);
        }

        a{ text-decoration:none; }
        button{ font-family:'Outfit',sans-serif; }

        /* ===================== LAYOUT ===================== */

        #layout{
            width:100%; height:100vh;
            display:flex; overflow:hidden;
        }

        /* ===================== SIDEBAR ==================== */

        #sidebar{
            width:var(--sidebar-width);
            min-width:var(--sidebar-width);        /* FIX: cegah layout jump */
            height:100vh;
            background:var(--surface);
            border-right:1px solid var(--border);
            display:flex; flex-direction:column;
            flex-shrink:0;
            transition:width .25s ease, min-width .25s ease;
            overflow:hidden;
            z-index:100;
            position:relative;                     /* untuk expand button */
        }

        #sidebar.collapsed{
            width:var(--sidebar-collapsed);
            min-width:var(--sidebar-collapsed);    /* FIX: ikut collapse */
        }

        /* BRAND */

        .sb-brand{
            height:var(--header-height);
            display:flex; align-items:center; gap:12px;
            padding:0 14px;
            border-bottom:1px solid var(--border);
            flex-shrink:0;
            overflow:hidden;
            white-space:nowrap;
        }

        .sb-logo{
            width:34px; height:34px;
            border-radius:var(--radius);
            background:linear-gradient(135deg,var(--red),#991b1b);
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0;
            box-shadow:0 4px 12px rgba(239,68,68,.2);
        }

        .sb-logo svg{ width:16px; height:16px; }

        .sb-brand-text{
            overflow:hidden; flex:1;
            transition:opacity .2s ease, max-width .25s ease;
            max-width:200px;
        }

        .sb-brand-name{
            font-size:15px; font-weight:800;
            color:#111; letter-spacing:-.02em;
            white-space:nowrap;
        }

        .sb-brand-sub{
            font-size:9px; color:#bbb;
            letter-spacing:.18em;
            text-transform:uppercase;
            margin-top:1px;
        }

        /* FIX: brand text fade out saat collapse */
        #sidebar.collapsed .sb-brand-text{
            opacity:0; max-width:0; pointer-events:none;
        }

        /* TOGGLE BTN — tombol collapse di header brand */

        .sb-toggle{
            margin-left:auto;
            width:28px; height:28px;
            border:none; border-radius:var(--radius);
            background:transparent;
            color:#aaa;
            cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0;
            transition:.18s ease;
        }

        .sb-toggle:hover{ background:rgba(0,0,0,.05); color:#333; }

        .sb-toggle svg{
            transition:transform .25s ease;
        }

        #sidebar.collapsed .sb-toggle svg{
            transform:rotate(180deg);
        }

        /* EXPAND BUTTON — floating pill di tepi sidebar, muncul hanya saat collapsed */

        .sb-expand-btn{
            display:none;                           /* disembunyikan default */
            position:absolute;
            top:50%;
            right:-14px;
            transform:translateY(-50%);
            width:24px; height:24px;
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:50%;
            align-items:center; justify-content:center;
            cursor:pointer;
            box-shadow:0 2px 10px rgba(0,0,0,.12);
            color:#999;
            transition:color .15s ease, border-color .15s ease, box-shadow .15s ease;
            z-index:200;
            font-size:10px;
        }

        .sb-expand-btn:hover{
            color:var(--red);
            border-color:rgba(239,68,68,.4);
            box-shadow:0 2px 10px rgba(239,68,68,.2);
        }

        /* FIX: tampilkan expand btn hanya saat collapsed */
        #sidebar.collapsed .sb-expand-btn{
            display:flex;
        }

        /* Sembunyikan di mobile */
        @media(max-width:768px){
            .sb-expand-btn{ display:none !important; }
        }

        /* NAV */

        #sb-nav{
            flex:1;
            overflow-y:auto; overflow-x:hidden;
            padding:10px 0;
        }

        #sb-nav::-webkit-scrollbar{ width:0; }

        .sb-section{
            padding:14px 14px 6px;
            color:#ccc;
            font-size:9px; font-weight:800;
            text-transform:uppercase; letter-spacing:.16em;
            white-space:nowrap;
            overflow:hidden;
            /* FIX: animasi height agar tidak bikin layout shift */
            transition:opacity .2s ease, height .2s ease, padding .2s ease;
            height:auto;
        }

        #sidebar.collapsed .sb-section{
            opacity:0;
            height:0;
            padding:0;
            pointer-events:none;
        }

        .nav-item{
            margin:2px 8px;
            padding:9px 10px;
            border-radius:var(--radius);
            display:flex; align-items:center; gap:10px;
            color:#777;
            transition:.15s ease;
            white-space:nowrap;
            overflow:visible;                       /* FIX: biarkan visible agar tooltip tidak terpotong */
            position:relative;
        }

        .nav-item:hover{
            background:#f4f4f4;
            color:#111;
        }

        .nav-item.active{
            background:rgba(239,68,68,.08);
            border-left:2px solid var(--red);
            color:#c0392b;
            padding-left:8px;
        }

        .ni{
            width:32px; height:32px;
            border-radius:var(--radius);
            background:rgba(0,0,0,.04);
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0;
            transition:.15s ease;
        }

        .nav-item:hover .ni{ background:rgba(0,0,0,.07); }

        .nav-item.active .ni{
            background:rgba(239,68,68,.12);
            color:var(--red);
        }

        .ni i{ font-size:13px; }

        .nav-label{
            font-size:13px; font-weight:600;
            overflow:hidden;
            white-space:nowrap;
            /* FIX: pakai max-width transition agar smooth & tidak bikin layout jarring */
            transition:opacity .15s ease, max-width .25s ease;
            max-width:200px;
        }

        #sidebar.collapsed .nav-label{
            opacity:0; max-width:0;
        }

        /* TOOLTIP saat collapsed — pakai position:fixed agar tidak terpotong overflow */

        #sidebar.collapsed .nav-item[data-tip]:hover::after{
            content:attr(data-tip);
            position:fixed;
            left:calc(var(--sidebar-collapsed) + 10px);
            background:#111;
            color:#fff;
            font-size:12px;
            font-weight:600;
            padding:5px 10px;
            border-radius:var(--radius);
            white-space:nowrap;
            z-index:9999;
            pointer-events:none;
            /* FIX: translateY(-50%) untuk centering vertikal relatif ke cursor */
            transform:translateY(-50%);
            margin-top:16px;
        }

        /* FOOTER */

        .sb-footer{
            padding:10px;
            border-top:1px solid var(--border);
        }

        .sb-user{
            display:flex; align-items:center; gap:10px;
            margin-bottom:8px;
            overflow:hidden; white-space:nowrap;
        }

        .sb-avatar{
            width:36px; height:36px;
            border-radius:var(--radius);
            background:linear-gradient(135deg,var(--red),#991b1b);
            display:flex; align-items:center; justify-content:center;
            font-size:12px; font-weight:800; color:#fff;
            flex-shrink:0;
        }

        .sb-user-text{
            overflow:hidden;
            transition:opacity .2s ease, max-width .25s ease;
            max-width:200px;
        }

        .sb-uname{
            font-size:12px; font-weight:700; color:#111;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }

        .sb-urole{
            font-size:10px; color:#bbb; margin-top:1px;
        }

        #sidebar.collapsed .sb-user-text{
            opacity:0; max-width:0; pointer-events:none;
        }

        .logout-btn{
            width:100%; border:none; cursor:pointer;
            display:flex; align-items:center; gap:8px;
            padding:9px 10px;
            border-radius:var(--radius);
            background:rgba(239,68,68,.07);
            color:var(--red);
            transition:.15s ease;
            white-space:nowrap; overflow:hidden;
        }

        .logout-btn:hover{ background:rgba(239,68,68,.13); }

        .logout-text{
            transition:opacity .15s ease, max-width .25s ease;
            max-width:200px;
        }

        #sidebar.collapsed .logout-text{
            opacity:0; max-width:0;
        }

        /* ==================== MAIN ======================== */

        #main-body{
            flex:1; min-width:0;
            display:flex; flex-direction:column;
            overflow:hidden;
        }

        /* ==================== HEADER ====================== */

        #main-header{
            height:var(--header-height);
            display:flex; align-items:center;
            padding:0 20px;
            background:rgba(255,255,255,.94);
            backdrop-filter:blur(10px);
            border-bottom:1px solid var(--border);
            flex-shrink:0; z-index:50;
        }

        .mobile-menu-btn{
            display:none;
            width:36px; height:36px;
            border:none; border-radius:var(--radius);
            background:rgba(0,0,0,.04); color:#111;
            align-items:center; justify-content:center;
            cursor:pointer; margin-right:10px;
        }

        .hdr-title{ font-size:14px; font-weight:700; color:#111; }

        .hdr-right{
            margin-left:auto;
            display:flex; align-items:center; gap:10px;
        }

        .hdr-btn{
            width:36px; height:36px;
            border-radius:var(--radius);
            border:1px solid var(--border);
            background:rgba(0,0,0,.02);
            display:flex; align-items:center; justify-content:center;
            color:#555; cursor:pointer;
            transition:.15s ease; position:relative;
        }

        .hdr-btn:hover{ background:rgba(0,0,0,.05); color:#111; }

        .notif-dot{
            width:6px; height:6px;
            border-radius:50%;
            background:var(--red);
            position:absolute; top:8px; right:8px;
        }

        .user-chip{
            display:flex; align-items:center; gap:8px;
            padding:4px 10px 4px 4px;
            border-radius:var(--radius);
            border:1px solid var(--border);
            background:rgba(0,0,0,.02);
        }

        .uc-avatar{
            width:30px; height:30px;
            border-radius:var(--radius);
            background:linear-gradient(135deg,var(--red),#991b1b);
            display:flex; align-items:center; justify-content:center;
            font-size:10px; font-weight:800; color:#fff;
        }

        .uc-name{ font-size:12px; font-weight:700; color:#111; }
        .uc-role{ font-size:10px; color:#aaa; }

        /* =================== CONTENT ====================== */

        #main-scroll{
            flex:1; overflow-y:auto;
            padding:20px;
            background:var(--bg);
        }

        #main-scroll::-webkit-scrollbar{ width:4px; }
        #main-scroll::-webkit-scrollbar-thumb{
            background:rgba(0,0,0,.1);
            border-radius:999px;
        }

        #main-content{ animation:fadeUp .3s ease; }

        @keyframes fadeUp{
            from{ opacity:0; transform:translateY(8px); }
            to{   opacity:1; transform:translateY(0);   }
        }

        /* ==================== CARD ======================== */

        .card{
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:var(--radius);
            padding:20px;
            box-shadow:var(--shadow);
        }

        /* ================= OVERLAY MOBILE ================= */

        #sidebar-overlay{
            position:fixed; inset:0;
            background:rgba(0,0,0,.3);
            backdrop-filter:blur(3px);
            opacity:0; visibility:hidden;
            transition:.22s ease; z-index:90;
        }

        #sidebar-overlay.active{ opacity:1; visibility:visible; }

        /* ============== ALERT / CONFIRM SYSTEM ============ */

        #ubg-alert-backdrop{
            position:fixed; inset:0; z-index:9999;
            background:rgba(0,0,0,.3);
            backdrop-filter:blur(3px);
            display:none; align-items:center; justify-content:center;
            padding:16px;
        }

        #ubg-alert-backdrop.show{
            display:flex;
        }

        #ubg-alert-box{
            background:#fff;
            border:1px solid var(--border);
            border-radius:var(--radius);
            width:100%; max-width:400px;
            box-shadow:0 8px 40px rgba(0,0,0,.12);
            overflow:hidden;
            animation:alertIn .2s ease;
        }

        @keyframes alertIn{
            from{ opacity:0; transform:scale(.95) translateY(-6px); }
            to{   opacity:1; transform:scale(1)  translateY(0);     }
        }

        .ubg-alert-header{
            display:flex; align-items:center; gap:12px;
            padding:18px 20px 14px;
        }

        .ubg-alert-icon{
            width:38px; height:38px;
            border-radius:var(--radius);
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; font-size:16px;
        }

        .ubg-alert-icon.warn{   background:#fff7ed; color:#c2410c; }
        .ubg-alert-icon.danger{ background:#fff1f2; color:#be123c; }
        .ubg-alert-icon.info{   background:#eff6ff; color:#1d4ed8; }
        .ubg-alert-icon.success{ background:#f0fdf4; color:#15803d; }

        .ubg-alert-title{
            font-size:15px; font-weight:700; color:#111;
        }

        .ubg-alert-body{
            padding:0 20px 16px;
            font-size:13px; color:#666; line-height:1.6;
        }

        .ubg-alert-footer{
            display:flex; justify-content:flex-end; gap:8px;
            padding:12px 20px;
            border-top:1px solid var(--border);
            background:#fafafa;
        }

        .ubg-btn{
            padding:8px 18px;
            border-radius:var(--radius);
            font-size:13px; font-weight:700;
            font-family:'Outfit',sans-serif;
            cursor:pointer; border:none;
            transition:.15s ease;
        }

        .ubg-btn-cancel{
            background:rgba(0,0,0,.05);
            color:#555; border:1px solid var(--border);
        }

        .ubg-btn-cancel:hover{ background:rgba(0,0,0,.09); }

        .ubg-btn-ok{ background:var(--red); color:#fff; }
        .ubg-btn-ok:hover{ background:var(--red-dark); }
        .ubg-btn-ok.warn{ background:#ea580c; }
        .ubg-btn-ok.warn:hover{ background:#c2410c; }
        .ubg-btn-ok.info{ background:#2563eb; }
        .ubg-btn-ok.info:hover{ background:#1d4ed8; }
        .ubg-btn-ok.success{ background:#16a34a; }
        .ubg-btn-ok.success:hover{ background:#15803d; }

        /* =================== RESPONSIVE =================== */

        @media(max-width:768px){

            #sidebar{
                position:fixed; left:0; top:0;
                transform:translateX(-100%);
                width:var(--sidebar-width) !important;
                min-width:var(--sidebar-width) !important;
                /* FIX: pastikan collapsed tidak efek di mobile */
                overflow:hidden;
            }

            #sidebar.open{ transform:translateX(0); }

            /* FIX: paksa expanded state di mobile walau class collapsed ada */
            #sidebar.collapsed{
                width:var(--sidebar-width) !important;
                min-width:var(--sidebar-width) !important;
            }

            #sidebar.collapsed .sb-brand-text{ opacity:1; max-width:200px; pointer-events:auto; }
            #sidebar.collapsed .nav-label{ opacity:1; max-width:200px; }
            #sidebar.collapsed .sb-section{ opacity:1; height:auto; padding:14px 14px 6px; pointer-events:auto; }
            #sidebar.collapsed .sb-user-text{ opacity:1; max-width:200px; pointer-events:auto; }
            #sidebar.collapsed .logout-text{ opacity:1; max-width:200px; }
            #sidebar.collapsed .nav-item[data-tip]:hover::after{ display:none; }

            .mobile-menu-btn{ display:flex; }
            .sb-toggle{ display:none; }
            #main-scroll{ padding:14px; }
        }

        @media(max-width:480px){
            .uc-name, .uc-role{ display:none; }
            .user-chip{ padding:4px; }
            #main-header{ padding:0 12px; }
            #main-scroll{ padding:12px; }
        }

    </style>
</head>
<body>

<div id="layout">

    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    {{-- ============ SIDEBAR ============ --}}
    <aside id="sidebar">

        {{-- BRAND --}}
        <div class="sb-brand">

            <div class="sb-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                    <rect x="2"  y="9" width="3" height="6" rx="1"/>
                    <rect x="19" y="9" width="3" height="6" rx="1"/>
                    <rect x="5"  y="7" width="3" height="10" rx="1"/>
                    <rect x="16" y="7" width="3" height="10" rx="1"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
            </div>

            <div class="sb-brand-text">
                <div class="sb-brand-name">UB GYM</div>
                <div class="sb-brand-sub">Admin Panel</div>
            </div>

            <button class="sb-toggle" onclick="toggleSidebar()" title="Collapse sidebar">
                {{-- Icon pakai SVG agar bisa di-rotate via CSS --}}
                <svg id="toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="13" height="13">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>

        </div>

        {{-- EXPAND BUTTON: muncul di tepi sidebar saat collapsed --}}
        <button class="sb-expand-btn" onclick="toggleSidebar()" title="Expand sidebar" aria-label="Expand sidebar">
            <i class="fa-solid fa-angle-right" style="font-size:10px;"></i>
        </button>

        {{-- NAV --}}
        <nav id="sb-nav">

            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               data-tip="Dashboard">
                <span class="ni"><i class="fa-solid fa-chart-line"></i></span>
                <span class="nav-label">Dashboard</span>
            </a>

            <div class="sb-section">Operasional</div>

            <a href="{{ route('admin.attendance.index') }}"
               class="nav-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}"
               data-tip="Check-in">
                <span class="ni"><i class="fa-solid fa-qrcode"></i></span>
                <span class="nav-label">Check-in Visit</span>
            </a>

            <a href="{{ route('admin.package.index') }}"
               class="nav-item {{ request()->routeIs('admin.package.*') ? 'active' : '' }}"
               data-tip="Paket & Aktivasi">
                <span class="ni"><i class="fa-solid fa-id-card"></i></span>
                <span class="nav-label">Paket & Aktivasi</span>
            </a>

            <a href="{{ route('admin.retail.index') }}"
               class="nav-item {{ request()->routeIs('admin.retail.*') ? 'active' : '' }}"
               data-tip="Penjualan Retail">
                <span class="ni"><i class="fa-solid fa-cart-shopping"></i></span>
                <span class="nav-label">Penjualan Retail</span>
            </a>

            <a href="{{ route('admin.pt.index') }}"
               class="nav-item {{ request()->routeIs('admin.pt.*') ? 'active' : '' }}"
               data-tip="Sesi PT">
                <span class="ni"><i class="fa-solid fa-dumbbell"></i></span>
                <span class="nav-label">Sesi PT</span>
            </a>

            <a href="{{ route('admin.verifications.index') }}"
               class="nav-item {{ request()->routeIs('admin.verifications.*') ? 'active' : '' }}"
               data-tip="Verifikasi">
                <span class="ni"><i class="fa-solid fa-circle-check"></i></span>
                <span class="nav-label">Verifikasi Online</span>
            </a>

            <div class="sb-section">Data</div>

            <a href="{{ route('admin.data.members') }}"
               class="nav-item {{ request()->routeIs('admin.data.members*') ? 'active' : '' }}"
               data-tip="Data Member">
                <span class="ni"><i class="fa-solid fa-users"></i></span>
                <span class="nav-label">Data Member</span>
            </a>

            <a href="{{ route('admin.data.products') }}"
               class="nav-item {{ request()->routeIs('admin.data.products*') ? 'active' : '' }}"
               data-tip="Data Produk">
                <span class="ni"><i class="fa-solid fa-box"></i></span>
                <span class="nav-label">Data Produk</span>
            </a>

            <div class="sb-section">Laporan</div>

            <a href="{{ route('admin.report.transactions') }}"
               class="nav-item {{ request()->routeIs('admin.report.transactions*') ? 'active' : '' }}"
               data-tip="Laporan Transaksi">
                <span class="ni"><i class="fa-solid fa-chart-column"></i></span>
                <span class="nav-label">Laporan Transaksi</span>
            </a>

            <a href="{{ route('admin.report.attendance') }}"
               class="nav-item {{ request()->routeIs('admin.report.attendance*') ? 'active' : '' }}"
               data-tip="Laporan Kehadiran">
                <span class="ni"><i class="fa-solid fa-clipboard-check"></i></span>
                <span class="nav-label">History Visit & PT</span>
            </a>

        </nav>

        {{-- FOOTER --}}
        <div class="sb-footer">

            <div class="sb-user">
                <div class="sb-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="sb-user-text">
                    <div class="sb-uname">{{ Auth::user()->name }}</div>
                    <div class="sb-urole">Admin</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="ni" style="width:24px;height:24px;">
                        <i class="fa-solid fa-right-from-bracket" style="font-size:12px;"></i>
                    </span>
                    <span class="logout-text">Keluar</span>
                </button>
            </form>

        </div>

    </aside>

    {{-- ============ MAIN ============ --}}
    <main id="main-body">

        <header id="main-header">

            <button class="mobile-menu-btn" onclick="openSidebar()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                    <line x1="3" y1="6"  x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            <div class="hdr-title">@yield('header-title', 'Dashboard')</div>

            <div class="hdr-right">

                <button class="hdr-btn">
                    <i class="fa-regular fa-bell" style="font-size:14px;"></i>
                    <span class="notif-dot"></span>
                </button>

                <div class="user-chip">
                    <div class="uc-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="uc-name">{{ Auth::user()->name }}</div>
                        <div class="uc-role">Admin</div>
                    </div>
                </div>

            </div>

        </header>

        <section id="main-scroll">
            <div id="main-content">
                @yield('content')
            </div>
        </section>

    </main>

</div>

{{-- ============ ALERT / CONFIRM BACKDROP ============ --}}
<div id="ubg-alert-backdrop">
    <div id="ubg-alert-box">
        <div class="ubg-alert-header">
            <div class="ubg-alert-icon" id="ubg-icon">
                <i id="ubg-icon-i" class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="ubg-alert-title" id="ubg-title">Peringatan</div>
        </div>
        <div class="ubg-alert-body" id="ubg-body"></div>
        <div class="ubg-alert-footer" id="ubg-footer"></div>
    </div>
</div>

<script>

    /* ============================================================
        SIDEBAR COLLAPSE
    ============================================================ */

    const sidebar    = document.getElementById('sidebar');
    const overlay    = document.getElementById('sidebar-overlay');
    const toggleIcon = document.getElementById('toggle-icon');

    let sidebarCollapsed = false;

    function setCollapsed(val){
        sidebarCollapsed = val;
        sidebar.classList.toggle('collapsed', sidebarCollapsed);
        localStorage.setItem('ubg_sb_collapsed', sidebarCollapsed ? '1' : '0');
    }

    function toggleSidebar(){
        setCollapsed(!sidebarCollapsed);
    }

    /* Restore state — tapi hanya di desktop */
    if(window.innerWidth > 768 && localStorage.getItem('ubg_sb_collapsed') === '1'){
        setCollapsed(true);
    }

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

    window.addEventListener('resize', () => {
        if(window.innerWidth > 768) closeSidebar();
    });

    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => {
            if(window.innerWidth <= 768) closeSidebar();
        });
    });

    document.addEventListener('keydown', e => {
        if(e.key === 'Escape'){
            closeSidebar();
            ubgClose();
        }
    });

    /* ============================================================
        ALERT / CONFIRM SYSTEM
        Usage:
          ubgAlert({ title, message, type })
          ubgConfirm({ title, message, type, confirmText, onConfirm })
    ============================================================ */

    const _backdrop = document.getElementById('ubg-alert-backdrop');
    const _box      = document.getElementById('ubg-alert-box');
    const _iconWrap = document.getElementById('ubg-icon');
    const _iconEl   = document.getElementById('ubg-icon-i');
    const _titleEl  = document.getElementById('ubg-title');
    const _bodyEl   = document.getElementById('ubg-body');
    const _footer   = document.getElementById('ubg-footer');

    const _typeMap = {
        warn:    { icon:'fa-solid fa-triangle-exclamation', label:'Peringatan' },
        danger:  { icon:'fa-solid fa-circle-xmark',         label:'Hapus'      },
        info:    { icon:'fa-solid fa-circle-info',           label:'Informasi'  },
        success: { icon:'fa-solid fa-circle-check',          label:'Berhasil'   },
    };

    function _applyType(type){
        const t = _typeMap[type] || _typeMap['warn'];
        _iconWrap.className = 'ubg-alert-icon ' + type;
        _iconEl.className   = t.icon;
        return t;
    }

    function ubgOpen(){ _backdrop.classList.add('show'); }
    function ubgClose(){ _backdrop.classList.remove('show'); }

    _backdrop.addEventListener('click', e => {
        if(e.target === _backdrop) ubgClose();
    });

    window.ubgAlert = function({ title, message, type = 'info' }){
        const t = _applyType(type);
        _titleEl.textContent = title || t.label;
        _bodyEl.innerHTML    = message;
        _footer.innerHTML    = `
            <button class="ubg-btn ubg-btn-ok ${type}" onclick="ubgClose()">Tutup</button>
        `;
        ubgOpen();
    };

    window.ubgConfirm = function({ title, message, type = 'warn', confirmText, cancelText, onConfirm }){
        const t = _applyType(type);
        _titleEl.textContent = title || t.label;
        _bodyEl.innerHTML    = message;
        _footer.innerHTML    = `
            <button class="ubg-btn ubg-btn-cancel" id="ubg-cancel-btn">${cancelText || 'Batal'}</button>
            <button class="ubg-btn ubg-btn-ok ${type}" id="ubg-ok-btn">${confirmText || 'Ya, Lanjutkan'}</button>
        `;
        document.getElementById('ubg-cancel-btn').onclick = () => ubgClose();
        document.getElementById('ubg-ok-btn').onclick = () => {
            ubgClose();
            if(typeof onConfirm === 'function') onConfirm();
        };
        ubgOpen();
    };

    document.addEventListener('click', function(e){
        const btn = e.target.closest('[data-confirm]');
        if(!btn) return;
        e.preventDefault();
        e.stopPropagation();
        const form = btn.closest('form') || document.querySelector(btn.dataset.form);
        ubgConfirm({
            title:       btn.dataset.confirmTitle  || null,
            message:     btn.dataset.confirm,
            type:        btn.dataset.confirmType   || 'danger',
            confirmText: btn.dataset.confirmOk     || 'Ya, Lanjutkan',
            cancelText:  btn.dataset.confirmCancel || 'Batal',
            onConfirm(){
                if(form) form.submit();
            }
        });
    });

</script>
@stack('scripts')

</body>
</html>