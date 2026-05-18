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
        :root{
            --red:#ff2d2d;
            --red-dark:#d81f1f;
            --red-dim:rgba(255,45,45,.10);
            --red-glow:rgba(255,45,45,.25);

            --bg:#070709;
            --bg2:#0d0d11;
            --bg3:#14141a;

            --border:rgba(255,255,255,.07);

            --text:#f3f3f3;
            --muted:#7a7a84;

            --green:#10b981;
            --green-dim:rgba(16,185,129,.12);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            background:var(--bg);
            color:var(--text);
            font-family:'Barlow',sans-serif;
            min-height:100vh;
            overflow-x:hidden;
            position:relative;
        }

        body::before{
            content:'';
            position:fixed;
            inset:0;
            background-image:
                radial-gradient(rgba(255,255,255,.018) 1px, transparent 1px);
            background-size:4px 4px;
            pointer-events:none;
            z-index:0;
        }

        a{
            text-decoration:none;
            color:inherit;
        }

        button,
        input,
        textarea,
        select{
            font-family:inherit;
        }

        /* =========================================================
           BACKGROUND
        ========================================================= */

        .bg-ornament{
            position:fixed;
            inset:0;
            pointer-events:none;
            z-index:0;
            overflow:hidden;
        }

        .bg-ornament::before{
            content:'';
            position:absolute;
            inset:0;
            background-image:
                linear-gradient(rgba(255,255,255,.022) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.022) 1px, transparent 1px);
            background-size:60px 60px;
        }

        .bg-ornament::after{
            content:'';
            position:absolute;
            top:-160px;
            left:-160px;
            width:520px;
            height:520px;
            border-radius:50%;
            background:
                radial-gradient(circle,
                rgba(255,45,45,.16) 0%,
                transparent 70%);
        }

        .bg-extra{
            position:fixed;
            bottom:-180px;
            right:-180px;
            width:620px;
            height:620px;
            border-radius:50%;
            background:
                radial-gradient(circle,
                rgba(255,45,45,.06) 0%,
                transparent 70%);
            pointer-events:none;
            z-index:0;
        }

        .bg-line{
            position:fixed;
            top:0;
            right:16%;
            width:1px;
            height:100vh;
            background:
                linear-gradient(
                    to bottom,
                    transparent,
                    rgba(255,45,45,.18),
                    transparent
                );
            pointer-events:none;
            z-index:0;
        }

        /* =========================================================
           TOPBAR
        ========================================================= */

        .topbar{
            position:sticky;
            top:0;
            z-index:100;

            height:68px;

            display:flex;
            align-items:center;
            justify-content:space-between;

            padding:0 24px;

            border-bottom:1px solid var(--border);

            background:rgba(7,7,9,.82);

            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
        }

        .topbar::after{
            content:'';
            position:absolute;
            left:0;
            bottom:0;
            width:100%;
            height:1px;
            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,45,45,.4),
                    transparent
                );
        }

        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            flex-shrink:0;
        }

        .brand-logo{
            width:38px;
            height:38px;

            background:var(--red);

            display:flex;
            align-items:center;
            justify-content:center;

            color:#fff;
            font-size:15px;

            clip-path:
                polygon(0 0,100% 0,88% 100%,0 100%);

            box-shadow:
                0 0 24px rgba(255,45,45,.22);
        }

        .brand-text{
            font-family:'Bebas Neue',sans-serif;
            font-size:22px;
            letter-spacing:.12em;
            line-height:1;
        }

        .brand-text span{
            color:var(--red);
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:10px;
        }

        /* =========================================================
           MEMBER BOX
        ========================================================= */

        .member-box{
            position:relative;
            overflow:hidden;

            display:flex;
            align-items:center;
            gap:10px;

            min-width:0;

            padding:7px 13px;

            background:var(--bg2);

            border:1px solid var(--border);
        }

        .member-box::before{
            content:'';
            position:absolute;
            inset:0;
            background:
                linear-gradient(
                    135deg,
                    rgba(255,45,45,.08),
                    transparent 60%
                );
            pointer-events:none;
        }

        .member-avatar{
            width:34px;
            height:34px;

            border-radius:50%;

            background:var(--red-dim);

            border:1px solid rgba(255,45,45,.3);

            display:flex;
            align-items:center;
            justify-content:center;

            color:var(--red);

            flex-shrink:0;

            box-shadow:
                0 0 18px rgba(255,45,45,.14);
        }

        .member-info{
            min-width:0;
        }

        .member-name{
            font-size:13px;
            font-weight:700;
            line-height:1.1;

            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .member-code{
            margin-top:2px;

            font-size:10px;
            color:var(--muted);

            font-family:'Barlow Condensed',sans-serif;
            letter-spacing:.08em;
        }

        /* =========================================================
           BUTTON
        ========================================================= */

        .logout-btn{
            height:48px;

            padding:0 16px;

            border:1px solid var(--border);

            background:var(--bg2);

            color:var(--text);

            display:flex;
            align-items:center;
            gap:8px;

            cursor:pointer;

            font-size:12px;
            font-weight:800;
            letter-spacing:.08em;

            transition:.2s;

            white-space:nowrap;
        }

        .logout-btn:hover{
            color:var(--red);
            border-color:rgba(255,45,45,.4);
            background:rgba(255,45,45,.05);
        }

        /* =========================================================
           MAIN CONTENT
        ========================================================= */

        .member-content{
            position:relative;
            z-index:1;

            width:100%;
            max-width:1280px;

            margin:0 auto;

            padding:28px 24px 80px;
        }

        /* =========================================================
           HERO
        ========================================================= */

        .hero-wrap{
            position:relative;
            overflow:hidden;

            padding:34px;

            margin-bottom:30px;

            border:1px solid var(--border);

            background:
                linear-gradient(
                    135deg,
                    rgba(255,45,45,.08),
                    transparent 45%
                ),
                var(--bg2);
        }

        .hero-wrap::before{
            content:'';
            position:absolute;
            top:0;
            left:0;

            width:100px;
            height:2px;

            background:var(--red);
        }

        .hero-label{
            color:var(--red);

            font-size:11px;
            font-weight:700;

            letter-spacing:.22em;
            text-transform:uppercase;

            margin-bottom:12px;
        }

        .hero-title{
            font-family:'Bebas Neue',sans-serif;

            font-size:clamp(44px,7vw,82px);

            line-height:.95;
            letter-spacing:.04em;

            margin-bottom:14px;

            text-shadow:
                0 0 30px rgba(255,45,45,.08);
        }

        .hero-title span{
            color:var(--red);
        }

        .hero-sub{
            max-width:560px;

            color:var(--muted);

            font-size:15px;
            line-height:1.8;
        }

        .hero-sub strong{
            color:var(--text);
            border-bottom:1px solid var(--red);
        }

        /* =========================================================
           PANEL SYSTEM
        ========================================================= */

        .panel{
            position:relative;
            overflow:hidden;

            background:var(--bg2);

            border:1px solid var(--border);

            padding:24px;
        }

        .panel::before{
            content:'';
            position:absolute;
            top:0;
            left:0;

            width:90px;
            height:2px;

            background:var(--red);
        }

        /* =========================================================
           TABS
        ========================================================= */

        .member-tabs{
            display:flex;
            align-items:center;

            overflow-x:auto;

            border-bottom:1px solid var(--border);

            margin-bottom:28px;

            scrollbar-width:none;
        }

        .member-tabs::-webkit-scrollbar{
            display:none;
        }

        .member-tab{
            position:relative;

            flex-shrink:0;

            padding:14px 20px;

            color:var(--muted);

            font-size:12px;
            font-weight:800;

            letter-spacing:.12em;
            text-transform:uppercase;

            transition:.2s;
        }

        .member-tab:hover{
            color:var(--text);
        }

        .member-tab.active{
            color:var(--red);
        }

        .member-tab.active::after{
            content:'';

            position:absolute;

            left:50%;
            bottom:-1px;

            transform:translateX(-50%);

            width:70%;
            height:2px;

            background:var(--red);

            box-shadow:
                0 0 14px rgba(255,45,45,.55);
        }

        /* =========================================================
           BADGES
        ========================================================= */

        .badge{
            display:inline-flex;
            align-items:center;
            gap:6px;

            padding:7px 11px;

            font-size:10px;
            font-weight:800;

            letter-spacing:.08em;
            text-transform:uppercase;

            border:1px solid var(--border);

            white-space:nowrap;
        }

        .badge.success{
            color:var(--green);
            background:var(--green-dim);
        }

        .badge.danger{
            color:var(--red);
            background:var(--red-dim);
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media(max-width:768px){

            body{
                padding-bottom:90px;
            }

            .topbar{
                height:62px;
                padding:0 14px;
            }

            .brand{
                gap:10px;
            }

            .brand-logo{
                width:34px;
                height:34px;
                font-size:13px;
            }

            .brand-text{
                font-size:18px;
            }

            .topbar-right{
                gap:8px;
            }

            .member-box{
                padding:5px 8px;
            }

            .member-name,
            .member-code{
                display:none;
            }

            .member-avatar{
                width:30px;
                height:30px;
                font-size:12px;
            }

            .logout-btn{
                height:40px;
                width:40px;
                padding:0;
                justify-content:center;
            }

            .logout-btn span{
                display:none;
            }

            .member-content{
                padding:18px 14px 80px;
            }

            .hero-wrap{
                padding:22px 18px;
                margin-bottom:22px;
            }

            .hero-title{
                font-size:44px;
                line-height:.92;
            }

            .hero-sub{
                font-size:13px;
                line-height:1.7;
            }

            .member-tabs{
                margin-bottom:22px;
            }

            .member-tab{
                padding:12px 14px;
                font-size:11px;
            }

            .panel{
                padding:18px;
            }
        }

    </style>

    @stack('styles')
</head>

<body>

    {{-- BACKGROUND --}}
    <div class="bg-ornament"></div>
    <div class="bg-extra"></div>
    <div class="bg-line"></div>

    {{-- TOPBAR --}}
    <div class="topbar">

        <div class="brand">
            <div class="brand-logo">
                <i class="fa-solid fa-dumbbell"></i>
            </div>

            <div class="brand-text">
                SATRIO <span>GYM</span>
            </div>
        </div>

        <div class="topbar-right">

            <div class="member-box">
                <div class="member-avatar">
                    <i class="fa-regular fa-user"></i>
                </div>

                <div class="member-info">
                    <div class="member-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="member-code">
                        {{ auth()->user()->member_code }}
                    </div>
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

    {{-- CONTENT --}}
    <div class="member-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>

</html>