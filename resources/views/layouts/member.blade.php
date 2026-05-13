<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Member Area') — Satrio Gym</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700;800;900&family=Barlow+Condensed:wght@400;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>


    <style>
        :root {
            --red:       #ff2d2d;
            --red-dim:   rgba(255,45,45,.12);
            --red-glow:  rgba(255,45,45,.35);
            --bg:        #070709;
            --bg2:       #0e0e12;
            --bg3:       #14141a;
            --border:    rgba(255,255,255,.07);
            --text:      #f0f0f0;
            --muted:     #71717a;
            --green:     #10b981;
            --green-dim: rgba(16,185,129,.12);
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Barlow', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }

        /* ========================================================
           BACKGROUND ORNAMENTS
        ======================================================== */
        .bg-ornament {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        /* Grid lines */
        .bg-ornament::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Top-left red glow blob */
        .bg-ornament::after {
            content: '';
            position: absolute;
            top: -120px;
            left: -120px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,45,45,.18) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Bottom-right subtle glow */
        .bg-extra {
            position: fixed;
            bottom: -150px;
            right: -150px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,45,45,.07) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Diagonal accent line */
        .bg-line {
            position: fixed;
            top: 0;
            right: 15%;
            width: 1px;
            height: 100vh;
            background: linear-gradient(to bottom, transparent, rgba(255,45,45,.15) 40%, transparent);
            pointer-events: none;
            z-index: 0;
        }

        /* ========================================================
           TOPBAR
        ======================================================== */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            height: 72px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            background: rgba(7,7,9,.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
            clip-path: polygon(0 0, 90% 0, 100% 10%, 100% 100%, 10% 100%, 0 90%);
        }

        .brand-text {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            letter-spacing: .1em;
        }

        .brand-text span { color: var(--red); }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .member-box {
            border: 1px solid var(--border);
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg2);
            min-width: 0;
        }

        .member-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--red-dim);
            border: 1px solid rgba(255,45,45,.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--red);
            font-size: 13px;
            flex-shrink: 0;
        }

        .member-name {
            font-size: 13px;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
        }

        .member-code {
            font-size: 11px;
            color: var(--muted);
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: .05em;
        }

        .logout-btn {
            height: 50px;
            padding: 0 18px;
            border: 1px solid var(--border);
            background: var(--bg2);
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 13px;
            font-family: 'Barlow', sans-serif;
            cursor: pointer;
            transition: .2s;
            white-space: nowrap;
        }

        .logout-btn:hover {
            border-color: var(--red);
            color: var(--red);
        }

        /* ========================================================
           CONTENT WRAPPER
        ======================================================== */
        .member-content {
            position: relative;
            z-index: 1;
            padding: 40px 36px 60px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ========================================================
           HERO
        ======================================================== */
        .hero-label {
            color: var(--red);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(52px, 8vw, 88px);
            line-height: 1;
            letter-spacing: .03em;
            margin-bottom: 14px;
        }

        .hero-title span { color: var(--red); }

        .hero-sub {
            color: var(--muted);
            font-size: 16px;
            margin-bottom: 36px;
            max-width: 560px;
        }

        .hero-sub strong {
            color: var(--text);
            border-bottom: 1px solid var(--red);
            padding-bottom: 1px;
        }

        /* ========================================================
           TABS
        ======================================================== */
        .member-tabs {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border);
            margin-bottom: 36px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .member-tabs::-webkit-scrollbar { display: none; }

        .member-tab {
            padding: 14px 28px;
            color: var(--muted);
            font-weight: 700;
            font-size: 13px;
            letter-spacing: .1em;
            text-transform: uppercase;
            transition: .2s;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .member-tab.active {
            color: var(--red);
            border-color: var(--red);
        }

        .member-tab:hover { color: var(--text); }

        /* ========================================================
           RESPONSIVE
        ======================================================== */
        @media (max-width: 768px) {
            .topbar {
                padding: 0 16px;
                height: 64px;
            }

            .member-box .member-name,
            .member-box .member-code { display: none; }

            .logout-btn span { display: none; }

            .logout-btn {
                padding: 0 14px;
                height: 44px;
            }

            .member-content {
                padding: 24px 16px 48px;
            }

            .hero-sub { font-size: 14px; }
        }
        
    </style>

    @stack('styles')
</head>
<body>

<div class="bg-ornament"></div>
<div class="bg-extra"></div>
<div class="bg-line"></div>

{{-- TOPBAR --}}
<div class="topbar">
    <div class="brand">
        <div class="brand-logo">
            <i class="fa-solid fa-dumbbell"></i>
        </div>
        <div class="brand-text">SATRIO <span>GYM</span></div>
    </div>

    <div class="topbar-right">
        <div class="member-box">
            <div class="member-avatar">
                <i class="fa-regular fa-user"></i>
            </div>
            <div>
                <div class="member-name">{{ auth()->user()->name }}</div>
                <div class="member-code">{{ auth()->user()->member_code }}</div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>KELUAR</span>
            </button>
        </form>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="member-content">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>