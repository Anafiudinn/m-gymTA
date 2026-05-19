<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Member Area') —  {{ $settings['gym_name'] ?? 'Satrio Gym Fitness' }}</title>

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

        button,input,textarea,select{
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
            background:radial-gradient(circle, rgba(255,45,45,.16) 0%, transparent 70%);
        }

        .bg-extra{
            position:fixed;
            bottom:-180px;
            right:-180px;
            width:620px;
            height:620px;
            border-radius:50%;
            background:radial-gradient(circle, rgba(255,45,45,.06) 0%, transparent 70%);
            pointer-events:none;
            z-index:0;
        }

        .bg-line{
            position:fixed;
            top:0;
            right:16%;
            width:1px;
            height:100vh;
            background:linear-gradient(to bottom, transparent, rgba(255,45,45,.18), transparent);
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
            background:linear-gradient(90deg, transparent, rgba(255,45,45,.4), transparent);
        }

        /* inner wrapper sejajar dengan konten */
        .topbar-inner{
            width:100%;
            max-width:1280px;
            margin:0 auto;
            height:100%;
            padding:0 24px;
            display:flex;
            align-items:center;
            justify-content:space-between;
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
            clip-path:polygon(0 0,100% 0,88% 100%,0 100%);
            box-shadow:0 0 24px rgba(255,45,45,.22);
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

        /* =========================================================
           ACCOUNT DROPDOWN
        ========================================================= */

        .account-wrap{
            position:relative;
        }

        .account-trigger{
            position:relative;
            overflow:hidden;
            display:flex;
            align-items:center;
            gap:10px;
            padding:7px 13px;
            background:var(--bg2);
            border:1px solid var(--border);
            cursor:pointer;
            transition:.2s;
            user-select:none;
        }

        .account-trigger::before{
            content:'';
            position:absolute;
            inset:0;
            background:linear-gradient(135deg, rgba(255,45,45,.08), transparent 60%);
            pointer-events:none;
        }

        .account-trigger:hover{
            border-color:rgba(255,45,45,.3);
            background:rgba(255,45,45,.04);
        }

        .account-trigger.open{
            border-color:rgba(255,45,45,.4);
            background:rgba(255,45,45,.06);
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
            box-shadow:0 0 18px rgba(255,45,45,.14);
            transition:.2s;
        }

        .account-trigger:hover .member-avatar,
        .account-trigger.open .member-avatar{
            box-shadow:0 0 24px rgba(255,45,45,.3);
            border-color:rgba(255,45,45,.6);
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

        .account-chevron{
            font-size:10px;
            color:var(--muted);
            margin-left:2px;
            transition:transform .25s;
            flex-shrink:0;
        }

        .account-trigger.open .account-chevron{
            transform:rotate(180deg);
            color:var(--red);
        }

        /* DROPDOWN PANEL */
        .account-dropdown{
            position:absolute;
            top:calc(100% + 8px);
            right:0;
            min-width:220px;
            background:var(--bg2);
            border:1px solid var(--border);
            overflow:hidden;
            opacity:0;
            transform:translateY(-8px) scaleY(.96);
            transform-origin:top right;
            pointer-events:none;
            transition:opacity .22s, transform .22s;
            z-index:200;
        }

        .account-dropdown::before{
            content:'';
            position:absolute;
            top:0;
            left:0;
            width:70px;
            height:2px;
            background:var(--red);
        }

        .account-dropdown.show{
            opacity:1;
            transform:translateY(0) scaleY(1);
            pointer-events:all;
        }

        .dropdown-header{
            padding:16px 16px 12px;
            border-bottom:1px solid var(--border);
        }

        .dropdown-label{
            font-size:9px;
            font-weight:800;
            letter-spacing:.18em;
            text-transform:uppercase;
            color:var(--red);
            margin-bottom:8px;
        }

        .dropdown-name{
            font-size:15px;
            font-weight:700;
            line-height:1.1;
        }

        .dropdown-code{
            margin-top:3px;
            font-size:11px;
            color:var(--muted);
            font-family:'Barlow Condensed',sans-serif;
            letter-spacing:.1em;
        }

        .dropdown-divider{
            height:1px;
            background:var(--border);
        }

        .dropdown-item{
            display:flex;
            align-items:center;
            gap:10px;
            padding:13px 16px;
            font-size:12px;
            font-weight:700;
            letter-spacing:.06em;
            color:var(--muted);
            cursor:pointer;
            transition:.2s;
            border:none;
            background:transparent;
            width:100%;
            text-align:left;
        }

        .dropdown-item i{
            width:16px;
            text-align:center;
            font-size:13px;
        }

        .dropdown-item:hover{
            color:var(--text);
            background:rgba(255,255,255,.04);
        }

        .dropdown-item.danger{
            color:var(--red);
        }

        .dropdown-item.danger:hover{
            background:var(--red-dim);
            color:var(--red);
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
                linear-gradient(135deg, rgba(255,45,45,.08), transparent 45%),
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
            text-shadow:0 0 30px rgba(255,45,45,.08);
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
            box-shadow:0 0 14px rgba(255,45,45,.55);
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
           SWEETALERT OVERRIDE
        ========================================================= */

        .swal2-popup{
            background:var(--bg2) !important;
            border:1px solid var(--border) !important;
            border-radius:0 !important;
            font-family:'Barlow',sans-serif !important;
            color:var(--text) !important;
        }

        .swal2-title{
            color:var(--text) !important;
            font-family:'Bebas Neue',sans-serif !important;
            font-size:28px !important;
            letter-spacing:.08em !important;
        }

        .swal2-html-container{
            color:var(--muted) !important;
            font-size:14px !important;
        }

        .swal2-confirm{
            background:var(--red) !important;
            border-radius:0 !important;
            font-family:'Barlow',sans-serif !important;
            font-weight:800 !important;
            letter-spacing:.08em !important;
            font-size:12px !important;
            padding:12px 24px !important;
        }

        .swal2-cancel{
            background:var(--bg3) !important;
            border:1px solid var(--border) !important;
            border-radius:0 !important;
            color:var(--text) !important;
            font-family:'Barlow',sans-serif !important;
            font-weight:800 !important;
            letter-spacing:.08em !important;
            font-size:12px !important;
            padding:12px 24px !important;
        }

        .swal2-icon.swal2-warning{
            border-color:var(--red) !important;
            color:var(--red) !important;
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media(max-width:768px){

            body{
                padding-bottom:90px;
            }

            .topbar-inner{
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

            .account-trigger{
                padding:5px 8px;
            }

            .member-name,
            .member-code,
            .account-chevron{
                display:none;
            }

            .member-avatar{
                width:30px;
                height:30px;
                font-size:12px;
            }

            .account-dropdown{
                min-width:190px;
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
        <div class="topbar-inner">

            <div class="brand">
                <div class="brand-logo">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
                <div class="brand-text">
                     {{ $settings['gym_name'] ?? 'Satrio Gym Fitness' }} </span>
                </div>
            </div>

            {{-- ACCOUNT DROPDOWN --}}
            <div class="account-wrap" id="accountWrap">

                <div class="account-trigger" id="accountTrigger" onclick="toggleDropdown()">
                    <div class="member-avatar">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="member-info">
                        <div class="member-name">{{ auth()->user()->name }}</div>
                        <div class="member-code">{{ auth()->user()->member_code }}</div>
                    </div>
                    <i class="fa-solid fa-chevron-down account-chevron"></i>
                </div>

                <div class="account-dropdown" id="accountDropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-label">Akun Saya</div>
                        <div class="dropdown-name">{{ auth()->user()->name }}</div>
                        <div class="dropdown-code">{{ auth()->user()->member_code }}</div>
                    </div>

                    {{-- Tambah item profil lain di sini kalau ada --}}
                    <a href="/profile" class="dropdown-item">
                        <i class="fa-regular fa-id-card"></i> Profil Saya
                    </a>
                    <di class="dropdown-divider"></di>

                    <button class="dropdown-item danger" onclick="confirmLogout()">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        KELUAR
                    </button>
                </div>

            </div>

        </div>
    </div>

    {{-- Hidden logout form --}}
    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    {{-- CONTENT --}}
    <div class="member-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* =========================================================
       SWEETALERT HELPER — pastikan selalu ready
    ========================================================= */
    function _swal(opts) {
        return Swal.fire(Object.assign({
            background: '#0d0d11',
            color: '#f3f3f3',
            confirmButtonColor: '#ff2d2d',
            cancelButtonColor: '#14141a',
            borderRadius: 0,
            customClass: {
                popup: 'swal2-popup',
                confirmButton: 'swal2-confirm',
                cancelButton: 'swal2-cancel',
            }
        }, opts));
    }

    /* =========================================================
       ACCOUNT DROPDOWN
    ========================================================= */
    function toggleDropdown() {
        const trigger  = document.getElementById('accountTrigger');
        const dropdown = document.getElementById('accountDropdown');
        if (dropdown.classList.contains('show')) {
            closeDropdown();
        } else {
            trigger.classList.add('open');
            dropdown.classList.add('show');
        }
    }

    function closeDropdown() {
        document.getElementById('accountTrigger').classList.remove('open');
        document.getElementById('accountDropdown').classList.remove('show');
    }

    document.addEventListener('click', function (e) {
        const wrap = document.getElementById('accountWrap');
        if (wrap && !wrap.contains(e.target)) closeDropdown();
    });

    /* =========================================================
       CONFIRM LOGOUT
    ========================================================= */
    let _logoutPending = false;

    function confirmLogout() {
        closeDropdown();
        if (_logoutPending) return;

        _swal({
            title: 'KELUAR?',
            html: 'Kamu akan keluar dari sesi ini.<br><small style="color:#7a7a84">Pastikan aktivitasmu sudah tersimpan.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;YA, KELUAR',
            cancelButtonText: 'BATAL',
            reverseButtons: true,
            focusCancel: true,
            allowOutsideClick: false,
        }).then(function (result) {
            if (result.isConfirmed) {
                _logoutPending = true;
                _swal({
                    title: 'Keluar...',
                    html: 'Sedang memproses, harap tunggu.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: function () { Swal.showLoading(); }
                });
                document.getElementById('logoutForm').submit();
            }
        });
    }

    /* =========================================================
       ANTI DOUBLE SUBMIT — khusus form biasa (bukan logoutForm)
       CATATAN: tidak langsung disable di sini, biarkan
       SweetAlert confirm di payment-script.js yang handle
    ========================================================= */
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form:not(#logoutForm)').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                const btn = form.querySelector('[type="submit"]');
                if (!btn) return;
                if (btn.dataset.submitting === '1') { e.preventDefault(); return; }

                btn.dataset.submitting = '1';
                btn.disabled = true;

                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>&nbsp;Memproses...';

                setTimeout(function () {
                    btn.disabled = false;
                    btn.dataset.submitting = '0';
                    btn.innerHTML = originalHTML;
                }, 10000);
            });
        });
    });
</script>
    @stack('scripts')

</body>

</html>