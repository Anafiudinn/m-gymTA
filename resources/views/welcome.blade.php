<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['gym_name'] ?? 'UB GYM' }} – Semarang</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        bebas: ['"Bebas Neue"', 'cursive'],
                        barlow: ['Barlow', 'sans-serif'],
                        condensed: ['"Barlow Condensed"', 'sans-serif'],
                    },
                    colors: {
                        red: { DEFAULT: '#e02020', dark: '#b91c1c' },
                        bg: { DEFAULT: '#0a0a0a', 2: '#111111', 3: '#1a1a1a' },
                        card: '#161616',
                        border: '#2a2a2a',
                        muted: '#888888',
                    },
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700;800;900&family=Barlow+Condensed:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root { --red: #e02020; --red-dark: #b91c1c; }

        .clip-logo { clip-path: polygon(0 0, 100% 0, 88% 100%, 0 100%); }

        /* ── HERO BG: cover penuh, posisi center, tidak burik ── */
        .hero-bg {
            background-image: url('{{ asset("storage/foto_gym/hero.jpg") }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            opacity: .50;
            filter: grayscale(60%);
            will-change: transform;
        }

        /* ── ABOUT IMG: cover penuh, posisi center ── */
        .about-img {
            background-image: url('{{ asset("storage/foto_gym/about.jpg") }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            opacity: .6;
            filter: grayscale(40%);
        }

        .map-frame { filter: grayscale(40%) invert(90%) hue-rotate(180deg); }

        .gallery-img { filter: grayscale(100%); transition: filter .4s, transform .4s; }
        .gallery-item:hover .gallery-img { filter: grayscale(30%); transform: scale(1.04); }

        .service-num { color: #1e1e1e; transition: color .3s; }
        .service-card:hover .service-num { color: #252525; }
        .service-card:hover { background: #1e1e1e; }

        .location-item { border-left: 3px solid transparent; transition: border-color .2s; }
        .location-item:hover { border-left-color: var(--red); }

        .btn-price { transition: all .2s; }
        .btn-price:not(.red-btn):hover { border-color: #888; }
        .btn-price.red-btn:hover { background: var(--red-dark); border-color: var(--red-dark); }

        .float-btn:hover { transform: scale(1.1); }

        .mobile-nav { display: none; }
        .mobile-nav.open { display: flex; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hero-content > * {
            opacity: 0;
            animation: fadeUp .6s ease forwards;
        }
        .hero-content > *:nth-child(1) { animation-delay: .1s; }
        .hero-content > *:nth-child(2) { animation-delay: .25s; }
        .hero-content > *:nth-child(3) { animation-delay: .4s; }
        .hero-content > *:nth-child(4) { animation-delay: .55s; }

        .section-tag {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 16px;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(42px, 5vw, 68px);
            line-height: .95;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .cta-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(42px, 6vw, 76px);
            line-height: .95;
        }

        /* ═══════════════════════════════════════════════════════
           PRICE CAROUSEL — fleksibel: center jika sedikit kartu,
           scroll jika banyak kartu
        ═══════════════════════════════════════════════════════ */

        /* Wrapper carousel dengan overflow hidden */
        .price-wrapper {
            overflow: hidden;
        }

        /* Track: flex, wrap tidak, scroll horizontal */
        .price-track {
            display: flex;
            gap: 18px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 6px;
        }
        .price-track::-webkit-scrollbar { display: none; }

        /* Jika sedikit kartu (via JS class), track jadi centered */
        .price-track.is-centered {
            justify-content: center;
            overflow-x: visible;
            scroll-snap-type: none;
            flex-wrap: wrap;
        }

        /* Kartu harga */
        .price-card {
            flex: 0 0 340px;
            min-height: 100%;
            scroll-snap-align: start;
            display: flex;
            flex-direction: column;
            background: #161616;
            position: relative;
            border: 1px solid #252525;
            transition: transform .25s, box-shadow .25s, border-color .25s;
        }

        /* Saat centered, kartu boleh grow tapi ada max-width */
        .price-track.is-centered .price-card {
            flex: 0 1 340px;
            scroll-snap-align: unset;
        }

        .price-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,.6);
            border-color: #3a3a3a;
            z-index: 2;
        }

        .price-card.featured {
            background: #1a0808;
            border-top: 3px solid var(--red);
        }

        /* Tablet */
        @media (max-width: 1024px) {
            .price-card { flex: 0 0 300px; }
            .price-track { gap: 14px; }
            .price-track.is-centered .price-card { flex: 0 1 300px; }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .price-card { flex: 0 0 85%; }
            .price-track { gap: 10px; }
            /* Di mobile tetap scroll, override centered */
            .price-track.is-centered {
                justify-content: flex-start;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                flex-wrap: nowrap;
            }
            .price-track.is-centered .price-card {
                flex: 0 0 85%;
                scroll-snap-align: start;
            }
        }

        .carousel-btn {
            width: 44px;
            height: 44px;
            background: #222;
            border: 1px solid #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s, border-color .2s;
            flex-shrink: 0;
        }
        .carousel-btn:hover { background: var(--red); border-color: var(--red); }
        .carousel-btn:disabled { opacity: .3; cursor: not-allowed; }
        .carousel-btn:disabled:hover { background: #222; border-color: #333; }

        /* Sembunyikan nav arrow jika centered (cukup sedikit kartu) */
        .price-nav-hidden { visibility: hidden; pointer-events: none; }

        /* Progress dots */
        .price-dot {
            width: 20px;
            height: 3px;
            background: #333;
            transition: background .3s, width .3s;
            cursor: pointer;
        }
        .price-dot.active { background: var(--red); width: 32px; }

        .waQuickBtn{
            width:100%;
            border:none;
            outline:none;
            cursor:pointer;
            text-align:left;
            padding:14px 16px;
            border-radius:12px;
            background:linear-gradient(to right,#1f2937,#23272f);
            color:#fff;
            font-weight:600;
            font-size:14px;
            transition:all .2s;
        }
        .waQuickBtn:hover{
            background:linear-gradient(to right,#25D36622,#23272f);
            transform:translateX(4px);
        }
        
    </style>
</head>
<body class="bg-bg font-barlow text-white overflow-x-hidden">

{{-- ═══════════════════════ NAVBAR ═══════════════════════ --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-[rgba(10,10,10,0.97)] backdrop-blur-md border-b border-border flex items-center justify-between px-8 h-[60px]">

    <a href="#hero" class="flex items-center gap-0 no-underline flex-shrink-0">
        <span class="clip-logo bg-red text-white font-bebas text-[22px] tracking-wider leading-none py-1 pl-2.5 pr-[18px]">UBG</span>
        <span class="font-bebas text-[19px] tracking-[2px] uppercase text-white pl-2.5 leading-none">
            {{ \Illuminate\Support\Str::upper($settings['gym_name'] ?? 'UB GYM') }}
        </span>
    </a>

    <ul class="hidden lg:flex gap-7 list-none">
        <li><a href="#tentang" class="text-[#aaa] hover:text-white font-semibold text-[12px] tracking-[1.5px] uppercase no-underline transition-colors">Tentang</a></li>
        <li><a href="#harga"   class="text-[#aaa] hover:text-white font-semibold text-[12px] tracking-[1.5px] uppercase no-underline transition-colors">Harga</a></li>
        <li><a href="#layanan" class="text-[#aaa] hover:text-white font-semibold text-[12px] tracking-[1.5px] uppercase no-underline transition-colors">Layanan</a></li>
        <li><a href="#galeri"  class="text-[#aaa] hover:text-white font-semibold text-[12px] tracking-[1.5px] uppercase no-underline transition-colors">Galeri</a></li>
        <li><a href="#lokasi"  class="text-[#aaa] hover:text-white font-semibold text-[12px] tracking-[1.5px] uppercase no-underline transition-colors">Lokasi</a></li>
    </ul>

    <div class="flex items-center gap-3 flex-shrink-0">
        <a href="{{ route('login') }}" class="hidden lg:block text-[#aaa] hover:text-white font-semibold text-[12px] tracking-[1.5px] uppercase no-underline transition-colors">Masuk</a>
        <a href="{{ route('register') }}" class="hidden lg:block bg-red hover:bg-red-dark text-white font-extrabold text-[12px] tracking-[2px] uppercase px-[18px] py-[9px] no-underline transition-colors">Daftar</a>

        <button id="navToggle" class="lg:hidden flex flex-col gap-[5px] bg-transparent border-none cursor-pointer p-1" aria-label="Menu">
            <span class="block w-6 h-[2px] bg-white transition-all"></span>
            <span class="block w-6 h-[2px] bg-white transition-all"></span>
            <span class="block w-6 h-[2px] bg-white transition-all"></span>
        </button>
    </div>
</nav>

{{-- Mobile Drawer --}}
<div id="mobileNav" class="mobile-nav fixed top-[60px] left-0 right-0 bg-[#0d0d0d] border-b border-border z-40 px-6 pt-5 pb-5 flex-col gap-0">
    <a href="#tentang" onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Tentang</a>
    <a href="#harga"   onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Harga</a>
    <a href="#layanan" onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Layanan</a>
    <a href="#galeri"  onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Galeri</a>
    <a href="#lokasi"  onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Lokasi</a>
    <a href="{{ route('login') }}"    onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Masuk</a>
    <a href="{{ route('register') }}" onclick="closeMobileNav()" class="block mt-4 bg-red text-white text-center font-extrabold text-[14px] tracking-[1.5px] uppercase py-3.5 no-underline">Daftar Sekarang →</a>
</div>

{{-- ═══════════════════════ HERO ═══════════════════════ --}}
<section id="hero" class="min-h-screen flex items-center px-8 pt-20 pb-12 relative overflow-hidden flex-wrap gap-10 max-sm:px-4">
    {{-- Hero BG: absolute inset, cover, tidak terpotong --}}
    <div class="hero-bg absolute inset-0 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[rgba(10,10,10,0.85)] via-[rgba(10,10,10,0.7)] to-[rgba(10,10,10,0.5)] pointer-events-none"></div>

    <div class="hero-content relative z-10 flex-1 min-w-[280px] max-w-[600px]">
        <div class="inline-flex items-center gap-2 border border-red px-3.5 py-1.5 text-[11px] font-bold tracking-[2px] uppercase text-white mb-7">
            <span class="text-red text-[8px]">■</span>
            Buka Setiap Hari · Semarang
        </div>

        <h1 class="font-bebas leading-[.9] tracking-[2px] mb-6" style="font-size: clamp(70px, 10vw, 130px)">
            ANGKAT.<br>
            KUAT.<br>
            <span class="text-red">MENANG.</span>
        </h1>

        <p class="text-[15px] text-[#aaa] leading-7 max-w-[460px] mb-9">
            {{ $settings['gym_name'] ?? 'UB GYM' }} — pusat angkat beban di jantung kota Semarang.
            Alat lengkap, suasana serius, harga jujur. Untuk kamu yang benar-benar mau berubah.
        </p>

        <div class="flex gap-3 items-center flex-wrap max-sm:flex-col max-sm:items-stretch">
            <a href="{{ route('register') }}" class="bg-red hover:bg-red-dark text-white px-7 py-3.5 font-extrabold text-[13px] tracking-[2px] uppercase no-underline inline-flex items-center gap-2.5 border-2 border-red hover:border-red-dark transition-colors justify-center">
                Daftar Sekarang <i class="fas fa-arrow-right"></i>
            </a>
            <a href="#harga" class="bg-transparent hover:border-[#888] text-white px-7 py-3.5 font-extrabold text-[13px] tracking-[2px] uppercase no-underline border-2 border-[#444] transition-colors text-center">
                Lihat Harga
            </a>
        </div>
    </div>

    <div class="relative z-10 flex flex-col gap-3 min-w-[240px] flex-shrink-0 max-lg:flex-row max-lg:w-full max-sm:flex-col">
        <div class="bg-card border border-border px-5 py-4 flex-1">
            <div class="text-[11px] font-bold tracking-[2px] uppercase text-red mb-1.5"><i class="fas fa-clock mr-1"></i> Jam Operasional</div>
            <div class="font-condensed text-[24px] font-extrabold tracking-wider">07:00 – 22:00</div>
            <div class="text-[13px] text-muted mt-1">Buka setiap hari</div>
        </div>
        <div class="bg-card border border-border px-5 py-4 flex-1">
            <div class="text-[11px] font-bold tracking-[2px] uppercase text-red mb-1.5"><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</div>
            <div class="font-condensed text-[24px] font-extrabold tracking-wider">SEMARANG KOTA</div>
            <div class="text-[13px] text-muted mt-1">Strategis &amp; mudah dijangkau</div>
        </div>
    </div>
</section>

{{-- ═══════════════════════ TENTANG ═══════════════════════ --}}
<section id="tentang" class="px-8 py-24 grid grid-cols-2 gap-16 items-center max-lg:grid-cols-1 max-lg:px-6 max-sm:px-4 max-sm:py-16">
    <div class="relative">
        {{-- About image: tinggi fixed, tapi bg-cover agar tidak burik di semua ukuran --}}
        <div class="relative w-full overflow-hidden max-lg:h-[340px]" style="height: 480px;">
            <div class="about-img absolute inset-0"></div>
        </div>
        <div class="absolute -bottom-4 -right-4 bg-red px-5 py-4 text-center z-10 max-lg:right-3 max-lg:-bottom-3">
            <span class="font-bebas text-[44px] leading-none block">100%</span>
            <span class="text-[10px] font-bold tracking-[2px] uppercase">Alat Berat</span>
        </div>
    </div>

    <div>
        <div class="section-tag">Tentang {{ $settings['gym_name'] ?? 'UB GYM' }}</div>
        <h2 class="section-title">
            TEMPAT DI MANA <span class="text-red">KERINGAT</span><br>BERBICARA.
        </h2>
        <p class="text-[15px] text-[#aaa] leading-[1.8] mb-9">
            Kami fokus ke satu hal: <strong class="text-white">alat berat</strong>. Tidak ada distraksi, tidak ada gimmick.
            Hanya barbel, dumbbell, dan besi yang siap kamu taklukkan setiap hari.
        </p>

        <div class="grid grid-cols-3 gap-[1px] bg-border border border-border max-sm:grid-cols-1">
            <div class="bg-card px-4 py-5 text-center">
                <div class="text-red text-lg mb-2.5"><i class="fas fa-fire"></i></div>
                <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1">Besi Asli</div>
                <div class="font-condensed text-[15px] font-extrabold">Alat berat lengkap</div>
            </div>
            <div class="bg-card px-4 py-5 text-center">
                <div class="text-red text-lg mb-2.5"><i class="fas fa-users"></i></div>
                <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1">Komunitas</div>
                <div class="font-condensed text-[15px] font-extrabold">Suasana serius</div>
            </div>
            <div class="bg-card px-4 py-5 text-center">
                <div class="text-red text-lg mb-2.5"><i class="fas fa-trophy"></i></div>
                <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1">Hasil Nyata</div>
                <div class="font-condensed text-[15px] font-extrabold">Tanpa kompromi</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════ LAYANAN ═══════════════════════ --}}
<section id="layanan" class="px-8 py-24 bg-bg-2 max-lg:px-6 max-sm:px-4 max-sm:py-16">
    <div class="grid grid-cols-2 gap-10 items-end mb-14 max-lg:grid-cols-1 max-lg:gap-6 max-lg:mb-10">
        <div>
            <div class="section-tag">Yang Kami Tawarkan</div>
            <h2 class="section-title">
                FOKUS KE BESI.<br>SISANYA KAMI URUS.
            </h2>
        </div>
        <p class="text-[15px] text-[#aaa] leading-[1.8] mb-0">
            Tidak perlu fasilitas mewah yang bikin terdistraksi. {{ $settings['gym_name'] ?? 'UB GYM' }} menyediakan yang paling penting:
            alat berat berkualitas dan dukungan untuk progres maksimal.
        </p>
    </div>

    <div class="grid grid-cols-3 gap-[1px] bg-border max-lg:grid-cols-2 max-sm:grid-cols-1">
        <div class="service-card bg-card px-7 py-9 relative transition-colors max-sm:px-5 max-sm:py-7">
            <span class="service-num absolute top-5 right-6 font-bebas text-5xl leading-none select-none">01</span>
            <div class="text-red text-[26px] mb-5"><i class="fas fa-dumbbell"></i></div>
            <div class="font-condensed text-[20px] font-extrabold tracking-wider uppercase mb-2.5">Alat Berat Lengkap</div>
            <p class="text-[13px] text-muted leading-7">Barbell, dumbbell, rack, dan mesin untuk semua kebutuhan latihan kekuatan.</p>
        </div>
        <div class="service-card bg-card px-7 py-9 relative transition-colors max-sm:px-5 max-sm:py-7">
            <span class="service-num absolute top-5 right-6 font-bebas text-5xl leading-none select-none">02</span>
            <div class="text-red text-[26px] mb-5"><i class="fas fa-user-friends"></i></div>
            <div class="font-condensed text-[20px] font-extrabold tracking-wider uppercase mb-2.5">Personal Trainer</div>
            <p class="text-[13px] text-muted leading-7">Program 1-on-1 bersama trainer berpengalaman. Sesi intensif untuk hasil terukur.</p>
        </div>
        <div class="service-card bg-card px-7 py-9 relative transition-colors max-lg:col-span-2 max-sm:col-span-1 max-sm:px-5 max-sm:py-7">
            <span class="service-num absolute top-5 right-6 font-bebas text-5xl leading-none select-none">03</span>
            <div class="text-red text-[26px] mb-5"><i class="fas fa-tint"></i></div>
            <div class="font-condensed text-[20px] font-extrabold tracking-wider uppercase mb-2.5">Retail di Lokasi</div>
            <p class="text-[13px] text-muted leading-7">Air mineral dan kebutuhan latihan tersedia. Tetap fokus, tanpa keluar gym.</p>
        </div>
    </div>
</section>

{{-- ═══════════════════════ HARGA ═══════════════════════ --}}
<section id="harga" class="px-8 py-24 max-lg:px-6 max-sm:px-4 max-sm:py-16">

    {{-- Header + Nav Arrows --}}
    <div class="flex items-end justify-between mb-12 flex-wrap gap-6">
        <div>
            <div class="section-tag">Daftar Harga</div>
            <h2 class="section-title mb-3">PILIH JALAN <span class="text-red">KERASMU.</span></h2>
            <p class="text-[15px] text-[#aaa] max-w-[480px]">Harga jujur, tanpa biaya tersembunyi. Bayar sesuai cara latihanmu.</p>
        </div>
        <div id="priceNavWrap" class="flex items-center gap-2">
            <button id="priceLeft" class="carousel-btn" aria-label="Scroll kiri">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            <button id="priceRight" class="carousel-btn" aria-label="Scroll kanan">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>
        </div>
    </div>

    {{-- Track wrapper --}}
    <div class="price-wrapper">
        <div id="priceTrack" class="price-track">

            {{-- ── CARD 1: Tamu Harian ── --}}
            <div class="price-card px-7 py-9 max-sm:px-5">
                <div class="text-[10px] font-bold tracking-[2px] uppercase text-red mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt"></i> Tamu Harian
                </div>
                <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-4">Visit Harian</div>

                <div class="mb-2 flex items-end gap-1">
                    @if(!empty($settings['visit_tamu']))
                        <span class="font-bebas text-[52px] leading-none text-red">
                            {{ number_format($settings['visit_tamu'], 0, ',', '.') }}
                        </span>
                        <span class="text-[13px] text-muted mb-2">/ kunjungan</span>
                    @else
                        <span class="font-bebas text-[32px] leading-none text-muted italic">Hubungi Kami</span>
                    @endif
                </div>

                <p class="text-[13px] text-muted mb-7 leading-relaxed">Mau coba dulu? Datang, bayar, langsung latihan. Tanpa ribet.</p>

                <ul class="list-none flex-1 mb-8 space-y-0">
                    <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5"><i class="fas fa-check text-red text-[11px]"></i> Akses semua alat</li>
                    <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5"><i class="fas fa-check text-red text-[11px]"></i> Tanpa komitmen</li>
                    <li class="text-[13px] text-[#ccc] py-2.5 flex items-center gap-2.5"><i class="fas fa-check text-red text-[11px]"></i> Cocok untuk pemula</li>
                </ul>

                <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings['gym_phone'] ?? '6289674901212') }}"
                   target="_blank"
                   class="btn-price block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white border-2 border-[#444] bg-transparent">
                    Datang Langsung
                </a>
            </div>

            {{-- ── CARD 2: Aktivasi Member (Featured) ── --}}
            <div class="price-card featured px-7 py-9 max-sm:px-5">
                <div class="absolute -top-px left-0 right-0 bg-red py-1 text-center text-[10px] font-extrabold tracking-[2px] uppercase">
                    ⚡ BEST VALUE
                </div>
                <div class="mt-6"></div>

                <div class="text-[10px] font-bold tracking-[2px] uppercase text-red mb-4 flex items-center gap-2">
                    <i class="fas fa-id-card"></i> Keanggotaan
                </div>
                <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-4">Aktivasi Member</div>

                <div class="mb-2 flex items-end gap-1">
                    @if(!empty($settings['biaya_aktivasi']))
                        <span class="font-bebas text-[52px] leading-none text-red">
                            {{ number_format($settings['biaya_aktivasi'], 0, ',', '.') }}
                        </span>
                        <span class="text-[13px] text-muted mb-2">selamanya</span>
                    @else
                        <span class="font-bebas text-[32px] leading-none text-muted italic">Hubungi Kami</span>
                    @endif
                </div>

                <p class="text-[13px] text-muted mb-7 leading-relaxed">Bayar sekali, jadi member seumur hidup. Akses semua harga member.</p>

                <ul class="list-none flex-1 mb-8 space-y-0">
                    @if(!empty($settings['visit_member']))
                        <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5">
                            <i class="fas fa-check text-red text-[11px]"></i>
                            Per kunjungan cuma {{ number_format($settings['visit_member'], 0, ',', '.') }}
                        </li>
                    @endif
                    <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5"><i class="fas fa-check text-red text-[11px]"></i> Berlaku selamanya</li>
                    <li class="text-[13px] text-[#ccc] py-2.5 flex items-center gap-2.5"><i class="fas fa-check text-red text-[11px]"></i> Hemat jangka panjang</li>
                </ul>

                <a href="{{ route('register') }}"
                   class="btn-price red-btn block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white bg-red border-2 border-red">
                    Aktivasi Sekarang
                </a>
            </div>

            {{-- ── CARD 3: Member Bulanan ── --}}
            <div class="price-card px-7 py-9 max-sm:px-5">
                <div class="text-[10px] font-bold tracking-[2px] uppercase text-red mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i> Berlangganan
                </div>
                <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-4">Member Bulanan</div>

                <div class="mb-2 flex items-end gap-1">
                    @if(!empty($settings['bulanan_member']))
                        <span class="font-bebas text-[52px] leading-none text-red">
                            {{ number_format($settings['bulanan_member'], 0, ',', '.') }}
                        </span>
                        <span class="text-[13px] text-muted mb-2">/ bulan</span>
                    @else
                        <span class="font-bebas text-[32px] leading-none text-muted italic">Hubungi Kami</span>
                    @endif
                </div>

                <p class="text-[13px] text-muted mb-7 leading-relaxed">Khusus yang sudah aktivasi member. Akses unlimited satu bulan penuh.</p>

                <ul class="list-none flex-1 mb-8 space-y-0">
                    <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5"><i class="fas fa-check text-red text-[11px]"></i> Akses unlimited 1 bulan</li>
                    <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5"><i class="fas fa-check text-red text-[11px]"></i> Tanpa biaya per kunjungan</li>
                    @if(!empty($settings['bulanan_tamu']))
                        <li class="text-[13px] text-[#ccc] py-2.5 flex items-center gap-2.5">
                            <i class="fas fa-check text-red text-[11px]"></i>
                            Non-member: {{ number_format($settings['bulanan_tamu'], 0, ',', '.') }}/bulan
                        </li>
                    @endif
                </ul>

                <a href="{{ route('register') }}"
                   class="btn-price block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white border-2 border-[#444] bg-transparent">
                    Pilih Paket
                </a>
            </div>

            {{-- ── CARDS: Paket Personal Trainer dari DB ── --}}
            @forelse($paket_pt as $index => $paket)
            <div class="price-card px-7 py-9 max-sm:px-5">
                <div class="text-[10px] font-bold tracking-[2px] uppercase text-red mb-4 flex items-center gap-2">
                    <i class="fas fa-user-friends"></i> Personal Trainer
                </div>
                <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-4">
                    {{ $paket->nama_paket }}
                </div>

                <div class="mb-2 flex items-end gap-1">
                    <span class="font-bebas text-[52px] leading-none text-red">
                        {{ number_format($paket->harga, 0, ',', '.') }}
                    </span>
                    <span class="text-[13px] text-muted mb-2">/ {{ $paket->jumlah_sesi }} sesi</span>
                </div>

                <p class="text-[13px] text-muted mb-7 leading-relaxed">
                    Program 1-on-1 intensif bersama
                    <strong class="text-white">{{ $paket->coach_name }}</strong>.
                    {{ $paket->jumlah_sesi }}x pertemuan terstruktur.
                </p>

                <ul class="list-none flex-1 mb-8 space-y-0">
                    <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5">
                        <i class="fas fa-check text-red text-[11px]"></i>
                        {{ $paket->jumlah_sesi }}x pertemuan intensif
                    </li>
                    <li class="text-[13px] text-[#ccc] py-2.5 border-b border-border flex items-center gap-2.5">
                        <i class="fas fa-check text-red text-[11px]"></i> Program disesuaikan
                    </li>
                    <li class="text-[13px] text-[#ccc] py-2.5 flex items-center gap-2.5">
                        <i class="fas fa-check text-red text-[11px]"></i> Pendampingan penuh
                    </li>
                </ul>

                <a href="{{ route('login') }}"
                   target="_blank"
                   class="btn-price block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white border-2 border-[#444] bg-transparent">
                    PILIH PAKET
                </a>
            </div>
            @empty
            @endforelse

        </div>{{-- end #priceTrack --}}
    </div>{{-- end .price-wrapper --}}

    {{-- Progress dots --}}
    <div id="priceDots" class="flex items-center gap-1.5 mt-6 justify-center"></div>

</section>

{{-- ═══════════════════════ GALERI ═══════════════════════ --}}
<section id="galeri" class="px-8 py-24 bg-bg-2 max-lg:px-6 max-sm:px-4 max-sm:py-16">
    <div class="text-center mb-14">
        <div class="section-tag">Galeri</div>
        <h2 class="section-title">LIHAT <span class="text-red">TEMPATNYA.</span></h2>
        <p class="text-[15px] text-[#888] mt-3">Suasana asli {{ $settings['gym_name'] ?? 'UB GYM' }} — apa adanya, fokus pada yang penting.</p>
    </div>

    <div class="grid grid-cols-4 gap-1.5 max-lg:grid-cols-2 max-sm:grid-cols-2 max-sm:gap-1">
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="{{ asset('storage/foto_gym/galery1.jpg') }}" alt="{{ $settings['gym_name'] ?? 'UB GYM' }}" class="gallery-img w-full h-full object-cover block">
        </div>
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="{{ asset('storage/foto_gym/galery2.jpg') }}" alt="{{ $settings['gym_name'] ?? 'UB GYM' }}" class="gallery-img w-full h-full object-cover block">
        </div>
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="{{ asset('storage/foto_gym/galery3.jpg') }}" alt="{{ $settings['gym_name'] ?? 'UB GYM' }}" class="gallery-img w-full h-full object-cover block">
        </div>
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="{{ asset('storage/foto_gym/galery4.jpeg') }}" alt="{{ $settings['gym_name'] ?? 'UB GYM' }}" class="gallery-img w-full h-full object-cover block">
        </div>
    </div>
</section>

{{-- ═══════════════════════ LOKASI ═══════════════════════ --}}
<section id="lokasi" class="px-8 py-24 grid grid-cols-2 gap-16 items-center max-lg:grid-cols-1 max-lg:px-6 max-lg:gap-10 max-sm:px-4 max-sm:py-16">
    <div>
        <div class="section-tag">Lokasi Kami</div>
        <h2 class="section-title">DATANG DAN <span class="text-red">RASAKAN</span> SENDIRI.</h2>
        <p class="text-[15px] text-[#aaa] leading-[1.8] mb-7">
            {{ $settings['gym_name'] ?? 'UB GYM' }} berlokasi strategis di Semarang Kota. Mudah dijangkau dari berbagai arah.
        </p>

        <div class="flex flex-col gap-[1px] bg-border">

            @if(!empty($settings['gym_address']))
            <div class="location-item bg-card px-6 py-5 flex items-center gap-4">
                <div class="text-red text-lg w-[22px] text-center flex-shrink-0"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-0.5">Alamat</div>
                    <div class="font-condensed text-[17px] tracking-wider uppercase">{{ $settings['gym_address'] }}</div>
                </div>
            </div>
            @endif

            <div class="location-item bg-card px-6 py-5 flex items-center gap-4">
                <div class="text-red text-lg w-[22px] text-center flex-shrink-0"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-0.5">Jam Buka</div>
                    <div class="font-condensed text-[17px] tracking-wider uppercase">Setiap Hari · 07:00 – 22:00</div>
                </div>
            </div>

            @if(!empty($settings['gym_phone']))
            <div class="location-item bg-card px-6 py-5 flex items-center gap-4">
                <div class="text-red text-lg w-[22px] text-center flex-shrink-0"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-0.5">WhatsApp</div>
                    <div class="font-condensed text-[17px] tracking-wider uppercase">
                        {{ $settings['gym_phone'] }}
                    </div>
                </div>
            </div>
            @endif

            @if(!empty($settings['instagram']))
            <div class="location-item bg-card px-6 py-5 flex items-center gap-4">
                <div class="text-red text-lg w-[22px] text-center flex-shrink-0"><i class="fab fa-instagram"></i></div>
                <div>
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-0.5">Instagram</div>
                    <div class="font-condensed text-[17px] tracking-wider uppercase">
                        {{ ltrim($settings['instagram'], '@') }}
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    <div class="h-[460px] border border-border overflow-hidden relative max-lg:h-[320px] max-sm:h-[260px]">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15799.623113351641!2d110.43915708696574!3d-6.983480299999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708ccf72359b7b%3A0x6599f51a22f8c56!2sSatrio%20Fitness%20Club!5e1!3m2!1sid!2sid!4v1778149032478!5m2!1sid!2sid"
            class="map-frame w-full h-full border-none"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

{{-- ═══════════════════════ CTA ═══════════════════════ --}}
<div class="px-8 pb-18 max-lg:px-6 max-sm:px-4 max-sm:pb-12">
    <div id="cta" class="px-10 py-20 bg-bg-2 border border-border max-sm:px-5 max-sm:py-10">
        <div class="text-center max-w-[680px] mx-auto">
            <h2 class="cta-title mb-4">SIAP MULAI? <span class="text-red">DAFTAR HARI INI.</span></h2>
            <p class="text-[15px] text-[#888] mb-9">Bikin akun, pilih paket, dan langsung mulai latihan. Tidak ada alasan lagi.</p>

            <div class="flex gap-3 justify-center flex-wrap">
                <a href="{{ route('register') }}" class="bg-red hover:bg-red-dark text-white px-7 py-3.5 font-extrabold text-[13px] tracking-[2px] uppercase no-underline inline-flex items-center gap-2.5 border-2 border-red transition-colors">
                    Buat Akun <i class="fas fa-arrow-right"></i>
                </a>
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings['gym_phone'] ?? '6289674901212') }}" target="_blank" class="bg-transparent hover:border-[#888] text-white px-7 py-3.5 font-extrabold text-[13px] tracking-[2px] uppercase no-underline border-2 border-[#444] transition-colors">
                    Chat WhatsApp
                </a>
            </div>

            <div class="grid grid-cols-3 gap-[1px] bg-border mt-12 pt-6 border-t border-border max-sm:grid-cols-1">
                @if(!empty($settings['gym_phone']))
                <div class="text-center px-3 py-3">
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1.5">WhatsApp</div>
                    <div class="font-bebas text-[18px] tracking-wider">{{ $settings['gym_phone'] }}</div>
                </div>
                @endif
                @if(!empty($settings['instagram']))
                <div class="text-center px-3 py-3">
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1.5">Instagram</div>
                    <div class="font-bebas text-[18px] tracking-wider">{{ ltrim($settings['instagram'], '@') }}</div>
                </div>
                @endif
                @if(!empty($settings['gym_address']))
                <div class="text-center px-3 py-3">
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1.5">Lokasi</div>
                    <div class="font-bebas text-[18px] tracking-wider">{{ Str::upper($settings['gym_address']) }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════ FOOTER ═══════════════════════ --}}
<footer class="bg-[#080808] border-t border-border px-8 py-7 flex items-center justify-between flex-wrap gap-3 max-sm:px-4 max-sm:flex-col max-sm:items-start">
    <a href="#hero" class="flex items-center gap-0 no-underline">
        <span class="clip-logo bg-red text-white font-bebas text-base leading-none py-0.5 pl-2 pr-3.5">UBG</span>
        <span class="font-condensed font-extrabold text-[15px] tracking-[2px] uppercase text-white pl-2 leading-none">
            {{ \Illuminate\Support\Str::upper($settings['gym_name'] ?? 'UB GYM') }}
        </span>
    </a>
    <p class="text-[12px] text-muted">© {{ date('Y') }} {{ $settings['gym_name'] ?? 'UB GYM' }} Semarang. Dibangun untuk yang serius.</p>
</footer>

{{-- ═══════════════════════ FLOAT WA CHAT ═══════════════════════ --}}
<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 max-sm:bottom-4 max-sm:right-4">

    <div id="waPanel"
         class="w-[320px] bg-[#0f1115] border border-[#1f2937] rounded-[24px] overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,.55)] opacity-0 pointer-events-none translate-y-4 scale-95 transition-all duration-300">

        <div class="bg-[#25D366] px-5 py-4 flex items-start justify-between">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white text-lg">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div>
                    <div class="font-bold text-white text-[15px] leading-none">
                        Admin {{ $settings['gym_name'] ?? 'UB GYM' }}
                    </div>
                    <div class="text-white/80 text-[13px] mt-1">
                        Biasanya balas dalam 5 menit
                    </div>
                </div>
            </div>
            <button id="closeWaPanel" class="text-white/90 hover:text-white text-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-5">
            <div class="text-[#9ca3af] text-[14px] mb-4">Pilih topik chat cepat:</div>
            <div class="space-y-3">
                <button class="waQuickBtn" data-message="Halo, saya mau tanya jadwal dan lokasi gym">Tanya jadwal & lokasi</button>
                <button class="waQuickBtn" data-message="Halo, saya mau tanya daftar member gym">Daftar member (80k)</button>
                <button class="waQuickBtn" data-message="Halo, saya mau tanya info kelas atau paket gym">Info kelas</button>
                <button class="waQuickBtn" data-message="Halo, saya mau tanya personal trainer">Tanya personal trainer</button>
            </div>
        </div>
    </div>

    <button id="waFloatBtn"
            class="w-[58px] h-[58px] rounded-full bg-[#25D366] text-white text-[28px] flex items-center justify-center shadow-[0_10px_30px_rgba(37,211,102,.45)] hover:scale-110 transition-all">
        <i class="fab fa-whatsapp"></i>
    </button>
</div>

<script>
    // ── WhatsApp Float ──
    const waFloatBtn  = document.getElementById('waFloatBtn');
    const waPanel     = document.getElementById('waPanel');
    const closeWaBtn  = document.getElementById('closeWaPanel');
    const WA_NUMBER   = "{{ preg_replace('/\D/', '', $settings['gym_phone'] ?? '6289674901212') }}";
    let waOpen = false;

    function openWaPanel() {
        waPanel.classList.remove('opacity-0','pointer-events-none','translate-y-4','scale-95');
        waPanel.classList.add('opacity-100','translate-y-0','scale-100');
        waOpen = true;
    }
    function closeWaPanelFunc() {
        waPanel.classList.add('opacity-0','pointer-events-none','translate-y-4','scale-95');
        waPanel.classList.remove('opacity-100','translate-y-0','scale-100');
        waOpen = false;
    }

    waFloatBtn.addEventListener('click', () => waOpen ? closeWaPanelFunc() : openWaPanel());
    closeWaBtn.addEventListener('click', closeWaPanelFunc);

    document.querySelectorAll('.waQuickBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            window.open(`https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(this.dataset.message)}`, '_blank');
        });
    });

    document.addEventListener('click', function(e){
        if (waOpen && !waPanel.contains(e.target) && !waFloatBtn.contains(e.target)) closeWaPanelFunc();
    });

    // ── Mobile nav ──
    const navToggle = document.getElementById('navToggle');
    const mobileNav = document.getElementById('mobileNav');
    navToggle.addEventListener('click', () => mobileNav.classList.toggle('open'));
    function closeMobileNav() { mobileNav.classList.remove('open'); }
    document.addEventListener('click', (e) => {
        if (!navToggle.contains(e.target) && !mobileNav.contains(e.target)) mobileNav.classList.remove('open');
    });

    // ── Price Carousel ──
    (function () {
        const track      = document.getElementById('priceTrack');
        const btnL       = document.getElementById('priceLeft');
        const btnR       = document.getElementById('priceRight');
        const dotsEl     = document.getElementById('priceDots');
        const navWrap    = document.getElementById('priceNavWrap');
        const cards      = track.querySelectorAll('.price-card');
        const total      = cards.length;
        let   activeDot  = 0;

        // ── Threshold: jika total kartu cukup muat di layar, aktifkan mode centered ──
        function checkIfShouldCenter() {
            // Di mobile (<640px) selalu scroll
            if (window.innerWidth < 640) {
                track.classList.remove('is-centered');
                navWrap.style.visibility = '';
                dotsEl.style.display = '';
                return;
            }

            // Hitung total lebar kartu + gap
            const cardW     = cards[0] ? cards[0].offsetWidth : 340;
            const gap       = 18;
            const totalW    = total * cardW + (total - 1) * gap;
            const available = track.parentElement.offsetWidth;

            if (totalW <= available) {
                // Semua kartu muat → centered, sembunyikan arrow & dots
                track.classList.add('is-centered');
                navWrap.style.visibility = 'hidden';
                navWrap.style.pointerEvents = 'none';
                dotsEl.style.display = 'none';
            } else {
                // Perlu scroll
                track.classList.remove('is-centered');
                navWrap.style.visibility = '';
                navWrap.style.pointerEvents = '';
                dotsEl.style.display = '';
            }
        }

        // Build dots
        const dots = [];
        cards.forEach((_, i) => {
            const d = document.createElement('div');
            d.className = 'price-dot' + (i === 0 ? ' active' : '');
            d.addEventListener('click', () => scrollTo(i));
            dotsEl.appendChild(d);
            dots.push(d);
        });

        function updateDot(idx) {
            dots[activeDot]?.classList.remove('active');
            activeDot = Math.max(0, Math.min(idx, total - 1));
            dots[activeDot]?.classList.add('active');
        }

        function getCardWidth() {
            if (!cards[0]) return 340;
            const style = window.getComputedStyle(track);
            const gap   = parseInt(style.columnGap || style.gap || 18);
            return cards[0].offsetWidth + gap;
        }

        function scrollTo(idx) {
            track.scrollTo({ left: idx * getCardWidth(), behavior: 'smooth' });
            updateDot(idx);
        }

        btnL.addEventListener('click', () => scrollTo(Math.max(0, activeDot - 1)));
        btnR.addEventListener('click', () => scrollTo(Math.min(total - 1, activeDot + 1)));

        let scrollTimer;
        track.addEventListener('scroll', () => {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(() => {
                const idx = Math.round(track.scrollLeft / getCardWidth());
                updateDot(idx);
                btnL.disabled = idx === 0;
                btnR.disabled = idx >= total - 1;
            }, 80);
        }, { passive: true });

        btnL.disabled = true;
        btnR.disabled = total <= 1;

        // Jalankan check saat load dan resize
        checkIfShouldCenter();
        window.addEventListener('resize', checkIfShouldCenter);
    })();
</script>

</body>
</html>