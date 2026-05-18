<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satrio Gym Fitness – Semarang</title>

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
                    fontSize: {
                        '10': ['10px', { lineHeight: '1.4' }],
                        '11': ['11px', { lineHeight: '1.4' }],
                    },
                    letterSpacing: {
                        wider2: '2px',
                        wider3: '3px',
                    },
                    clipPath: {
                        logo: 'polygon(0 0, 100% 0, 88% 100%, 0 100%)',
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

        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80');
            background-size: cover;
            background-position: center;
            opacity: .18;
            filter: grayscale(60%);
        }

        .about-img {
            background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&q=80');
            background-size: cover;
            background-position: center;
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
    </style>
</head>
<body class="bg-bg font-barlow text-white overflow-x-hidden">

<!-- ═══════════════════════ NAVBAR ═══════════════════════ -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-[rgba(10,10,10,0.97)] backdrop-blur-md border-b border-border flex items-center justify-between px-8 h-[60px]">

    <a href="#hero" class="flex items-center gap-0 no-underline flex-shrink-0">
        <span class="clip-logo bg-red text-white font-bebas text-[22px] tracking-wider leading-none py-1 pl-2.5 pr-[18px]">SGF</span>
        <span class="font-condensed font-extrabold text-[19px] tracking-[2px] uppercase text-white pl-2.5 leading-none">
            SATRIO <span class="text-red">GYM</span>
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
        <a href="/login" class="hidden lg:block text-[#aaa] hover:text-white font-semibold text-[12px] tracking-[1.5px] uppercase no-underline transition-colors">Masuk</a>
        <a href="/register" class="hidden lg:block bg-red hover:bg-red-dark text-white font-extrabold text-[12px] tracking-[2px] uppercase px-[18px] py-[9px] no-underline transition-colors">Daftar</a>

        <button id="navToggle" class="lg:hidden flex flex-col gap-[5px] bg-transparent border-none cursor-pointer p-1" aria-label="Menu">
            <span class="block w-6 h-[2px] bg-white transition-all"></span>
            <span class="block w-6 h-[2px] bg-white transition-all"></span>
            <span class="block w-6 h-[2px] bg-white transition-all"></span>
        </button>
    </div>
</nav>

<!-- Mobile Drawer -->
<div id="mobileNav" class="mobile-nav fixed top-[60px] left-0 right-0 bg-[#0d0d0d] border-b border-border z-40 px-6 pt-5 pb-5 flex-col gap-0">
    <a href="#tentang" onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Tentang</a>
    <a href="#harga"   onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Harga</a>
    <a href="#layanan" onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Layanan</a>
    <a href="#galeri"  onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Galeri</a>
    <a href="#lokasi"  onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Lokasi</a>
    <a href="/login"   onclick="closeMobileNav()" class="text-[#ccc] hover:text-white font-semibold text-[14px] tracking-[1.5px] uppercase no-underline py-3.5 border-b border-border block">Masuk</a>
    <a href="/register" onclick="closeMobileNav()" class="block mt-4 bg-red text-white text-center font-extrabold text-[14px] tracking-[1.5px] uppercase py-3.5 no-underline">Daftar Sekarang →</a>
</div>

<!-- ═══════════════════════ HERO ═══════════════════════ -->
<section id="hero" class="min-h-screen flex items-center px-8 pt-20 pb-12 relative overflow-hidden flex-wrap gap-10 max-sm:px-4 max-sm:pt-18 max-lg:min-h-auto">
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
            Satrio Gym Fitness — pusat angkat beban di jantung kota Semarang.
            Alat lengkap, suasana serius, harga jujur. Untuk kamu yang benar-benar mau berubah.
        </p>

        <div class="flex gap-3 items-center flex-wrap max-sm:flex-col max-sm:items-stretch">
            <a href="/register" class="bg-red hover:bg-red-dark text-white px-7 py-3.5 font-extrabold text-[13px] tracking-[2px] uppercase no-underline inline-flex items-center gap-2.5 border-2 border-red hover:border-red-dark transition-colors justify-center">
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

<!-- ═══════════════════════ TENTANG ═══════════════════════ -->
<section id="tentang" class="px-8 py-24 grid grid-cols-2 gap-16 items-center max-lg:grid-cols-1 max-lg:px-6 max-sm:px-4 max-sm:py-16">
    <div class="relative">
        <div class="relative w-full h-[480px] bg-gradient-to-br from-[#1a0a0a] via-[#2a0f0f] to-[#1a0a0a] overflow-hidden max-lg:h-[340px]">
            <div class="about-img absolute inset-0"></div>
        </div>
        <div class="absolute -bottom-4 -right-4 bg-red px-5 py-4 text-center z-10 max-lg:right-3 max-lg:-bottom-3">
            <span class="font-bebas text-[44px] leading-none block">100%</span>
            <span class="text-[10px] font-bold tracking-[2px] uppercase">Alat Berat</span>
        </div>
    </div>

    <div>
        <div class="section-tag">Tentang Satrio Gym</div>
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

<!-- ═══════════════════════ LAYANAN ═══════════════════════ -->
<section id="layanan" class="px-8 py-24 bg-bg-2 max-lg:px-6 max-sm:px-4 max-sm:py-16">
    <div class="grid grid-cols-2 gap-10 items-end mb-14 max-lg:grid-cols-1 max-lg:gap-6 max-lg:mb-10">
        <div>
            <div class="section-tag">Yang Kami Tawarkan</div>
            <h2 class="section-title">
                FOKUS KE BESI.<br>SISANYA KAMI URUS.
            </h2>
        </div>
        <p class="text-[15px] text-[#aaa] leading-[1.8] mb-0">
            Tidak perlu fasilitas mewah yang bikin terdistraksi. Satrio Gym menyediakan yang paling penting:
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
            <p class="text-[13px] text-muted leading-7">Program 1-on-1 bersama trainer berpengalaman. 10x pertemuan untuk hasil terukur.</p>
        </div>
        <div class="service-card bg-card px-7 py-9 relative transition-colors max-lg:col-span-2 max-sm:col-span-1 max-sm:px-5 max-sm:py-7">
            <span class="service-num absolute top-5 right-6 font-bebas text-5xl leading-none select-none">03</span>
            <div class="text-red text-[26px] mb-5"><i class="fas fa-tint"></i></div>
            <div class="font-condensed text-[20px] font-extrabold tracking-wider uppercase mb-2.5">Retail di Lokasi</div>
            <p class="text-[13px] text-muted leading-7">Air mineral Aqua dan kebutuhan latihan tersedia. Tetap fokus, tanpa keluar gym.</p>
        </div>
    </div>
</section>

<!-- ═══════════════════════ HARGA ═══════════════════════ -->
<section id="harga" class="px-8 py-24 max-lg:px-6 max-sm:px-4 max-sm:py-16">
    <div class="text-center mb-14">
        <div class="section-tag">Daftar Harga</div>
        <h2 class="section-title">PILIH JALAN <span class="text-red">KERASMU.</span></h2>
        <p class="text-[15px] text-[#aaa] max-w-[520px] mx-auto">Harga jujur, tanpa biaya tersembunyi. Bayar sesuai cara latihanmu.</p>
    </div>

    <div class="grid grid-cols-4 gap-[1px] bg-border max-lg:grid-cols-2 max-sm:grid-cols-1 max-sm:gap-0">

        <!-- Tamu Harian -->
        <div class="bg-card px-7 py-9 flex flex-col max-sm:px-5">
            <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-3.5">Tamu Harian</div>
            <div class="mb-2">
                <span class="font-bebas text-[50px] leading-none text-red">15K</span>
                <span class="text-[13px] text-muted ml-1">/ kunjungan</span>
            </div>
            <p class="text-[13px] text-muted mb-6 leading-relaxed">Mau coba dulu? Datang bayar latihan.</p>
            <ul class="list-none flex-1 mb-7">
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Akses semua alat</li>
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Tanpa komitmen</li>
                <li class="text-[13px] text-[#ccc] py-2 flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Cocok untuk freelance</li>
            </ul>
            <a href="https://wa.me/6289674901212" target="_blank" class="btn-price block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white border-2 border-[#444] bg-transparent">Datang Langsung</a>
        </div>

        <!-- Aktivasi Member (featured) -->
        <div class="bg-[#1a0808] border-t-[3px] border-red -mt-2.5 pt-12 px-7 pb-9 flex flex-col relative max-lg:mt-0 max-lg:border-t-0 max-lg:border-l-[3px] max-lg:pt-10 max-sm:px-5">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-red px-3 py-1 text-[10px] font-extrabold tracking-[2px] uppercase whitespace-nowrap flex items-center gap-1.5 max-sm:hidden">⚡ Best Value</div>
            <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-3.5">Aktivasi Member</div>
            <div class="mb-2">
                <span class="font-bebas text-[50px] leading-none text-red">80K</span>
                <span class="text-[13px] text-muted ml-1">selamanya</span>
            </div>
            <p class="text-[13px] text-muted mb-6 leading-relaxed">Bayar sekali, jadi member seumur hidup.</p>
            <ul class="list-none flex-1 mb-7">
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Per kunjungan cuma 7K</li>
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Berlaku selamanya</li>
                <li class="text-[13px] text-[#ccc] py-2 flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Hemat untuk jangka panjang</li>
            </ul>
            <a href="/register" class="btn-price red-btn block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white bg-red border-2 border-red">Aktivasi Sekarang</a>
        </div>

        <!-- Member Bulanan -->
        <div class="bg-card px-7 py-9 flex flex-col max-sm:px-5">
            <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-3.5">Member Bulanan</div>
            <div class="mb-2">
                <span class="font-bebas text-[50px] leading-none text-red">110K</span>
                <span class="text-[13px] text-muted ml-1">/ bulan</span>
            </div>
            <p class="text-[13px] text-muted mb-6 leading-relaxed">Khusus yang sudah aktivasi member.</p>
            <ul class="list-none flex-1 mb-7">
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Akses unlimited 1 bulan</li>
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Tanpa biaya per kunjungan</li>
                <li class="text-[13px] text-[#ccc] py-2 flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Non-member: 200K/bulan</li>
            </ul>
            <a href="/register" class="btn-price block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white border-2 border-[#444] bg-transparent">Pilih Paket</a>
        </div>

        <!-- Personal Trainer -->
        <div class="bg-card px-7 py-9 flex flex-col max-sm:px-5">
            <div class="font-condensed text-[17px] font-extrabold tracking-[2px] uppercase mb-3.5">Personal Trainer</div>
            <div class="mb-2">
                <span class="font-bebas text-[50px] leading-none text-red">900K</span>
                <span class="text-[13px] text-muted ml-1">/ 10 sesi</span>
            </div>
            <p class="text-[13px] text-muted mb-6 leading-relaxed">Program 1-on-1 dengan PT berpengalaman.</p>
            <ul class="list-none flex-1 mb-7">
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> 10x pertemuan intensif</li>
                <li class="text-[13px] text-[#ccc] py-2 border-b border-border flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Program disesuaikan</li>
                <li class="text-[13px] text-[#ccc] py-2 flex items-center gap-2"><i class="fas fa-check text-red text-[11px]"></i> Pendampingan penuh</li>
            </ul>
            <a href="https://wa.me/6289674901212" target="_blank" class="btn-price block w-full py-3.5 font-extrabold text-[12px] tracking-[2px] uppercase text-center no-underline text-white border-2 border-[#444] bg-transparent">Booking PT</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════ GALERI ═══════════════════════ -->
<section id="galeri" class="px-8 py-24 bg-bg-2 max-lg:px-6 max-sm:px-4 max-sm:py-16">
    <div class="text-center mb-14">
        <div class="section-tag">Galeri</div>
        <h2 class="section-title">LIHAT <span class="text-red">TEMPATNYA.</span></h2>
        <p class="text-[15px] text-[#888] mt-3">Suasana asli Satrio Gym Fitness — apa adanya, fokus pada yang penting.</p>
    </div>

    <div class="grid grid-cols-4 gap-1.5 max-lg:grid-cols-2 max-sm:grid-cols-2 max-sm:gap-1">
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&q=80" alt="Satrio Gym" class="gallery-img w-full h-full object-cover block">
        </div>
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=600&q=80" alt="Satrio Gym" class="gallery-img w-full h-full object-cover block">
        </div>
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80" alt="Satrio Gym" class="gallery-img w-full h-full object-cover block">
        </div>
        <div class="gallery-item aspect-[3/4] overflow-hidden relative cursor-pointer">
            <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=600&q=80" alt="Satrio Gym" class="gallery-img w-full h-full object-cover block">
        </div>
    </div>
</section>

<!-- ═══════════════════════ LOKASI ═══════════════════════ -->
<section id="lokasi" class="px-8 py-24 grid grid-cols-2 gap-16 items-center max-lg:grid-cols-1 max-lg:px-6 max-lg:gap-10 max-sm:px-4 max-sm:py-16">
    <div>
        <div class="section-tag">Lokasi Kami</div>
        <h2 class="section-title">DATANG DAN <span class="text-red">RASAKAN</span> SENDIRI.</h2>
        <p class="text-[15px] text-[#aaa] leading-[1.8] mb-7">
            Satrio Gym Fitness berlokasi strategis di Semarang Kota. Mudah dijangkau dari berbagai arah.
        </p>

        <div class="flex flex-col gap-[1px] bg-border">
            <div class="location-item bg-card px-6 py-5 flex items-center gap-4">
                <div class="text-red text-lg w-[22px] text-center flex-shrink-0"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-0.5">Alamat</div>
                    <div class="font-condensed text-[17px] font-extrabold tracking-wider uppercase">Satrio Fitness Club, Semarang</div>
                </div>
            </div>
            <div class="location-item bg-card px-6 py-5 flex items-center gap-4">
                <div class="text-red text-lg w-[22px] text-center flex-shrink-0"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-0.5">Jam Buka</div>
                    <div class="font-condensed text-[17px] font-extrabold tracking-wider uppercase">Setiap Hari · 07:00 – 22:00</div>
                </div>
            </div>
            <div class="location-item bg-card px-6 py-5 flex items-center gap-4">
                <div class="text-red text-lg w-[22px] text-center flex-shrink-0"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-0.5">WhatsApp</div>
                    <div class="font-condensed text-[17px] font-extrabold tracking-wider uppercase">0896 7490 1212</div>
                </div>
            </div>
        </div>
    </div>

    <div class="h-[420px] border border-border overflow-hidden relative max-lg:h-[320px] max-sm:h-[260px]">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15799.623113351641!2d110.43915708696574!3d-6.983480299999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708ccf72359b7b%3A0x6599f51a22f8c56!2sSatrio%20Fitness%20Club!5e1!3m2!1sid!2sid!4v1778149032478!5m2!1sid!2sid"
            class="map-frame w-full h-full border-none"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

<!-- ═══════════════════════ CTA ═══════════════════════ -->
<div class="px-8 pb-18 max-lg:px-6 max-sm:px-4 max-sm:pb-12">
    <div id="cta" class="px-10 py-18 bg-bg-2 border border-border max-sm:px-5 max-sm:py-10">
        <div class="text-center max-w-[680px] mx-auto">
            <h2 class="cta-title mb-4">SIAP MULAI? <span class="text-red">DAFTAR HARI INI.</span></h2>
            <p class="text-[15px] text-[#888] mb-9">Bikin akun, pilih paket, dan langsung mulai latihan. Tidak ada alasan lagi.</p>

            <div class="flex gap-3 justify-center flex-wrap">
                <a href="/register" class="bg-red hover:bg-red-dark text-white px-7 py-3.5 font-extrabold text-[13px] tracking-[2px] uppercase no-underline inline-flex items-center gap-2.5 border-2 border-red transition-colors">
                    Buat Akun <i class="fas fa-arrow-right"></i>
                </a>
                <a href="https://wa.me/6289674901212" target="_blank" class="bg-transparent hover:border-[#888] text-white px-7 py-3.5 font-extrabold text-[13px] tracking-[2px] uppercase no-underline border-2 border-[#444] transition-colors">
                    Chat WhatsApp
                </a>
            </div>

            <div class="grid grid-cols-3 gap-[1px] bg-border mt-12 pt-9 border-t border-border max-sm:grid-cols-1">
                <div class="text-center px-3 py-3">
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1.5">WhatsApp</div>
                    <div class="font-condensed text-[18px] font-extrabold tracking-wider">0896 7490 1212</div>
                </div>
                <div class="text-center px-3 py-3">
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1.5">Instagram</div>
                    <div class="font-condensed text-[18px] font-extrabold tracking-wider">@UBGYM</div>
                </div>
                <div class="text-center px-3 py-3">
                    <div class="text-[10px] font-bold tracking-[2px] uppercase text-muted mb-1.5">Lokasi</div>
                    <div class="font-condensed text-[18px] font-extrabold tracking-wider">SEMARANG KOTA</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════ FOOTER ═══════════════════════ -->
<footer class="bg-[#080808] border-t border-border px-8 py-7 flex items-center justify-between flex-wrap gap-3 max-sm:px-4 max-sm:flex-col max-sm:items-start">
    <a href="#hero" class="flex items-center gap-0 no-underline">
        <span class="clip-logo bg-red text-white font-bebas text-base leading-none py-0.5 pl-2 pr-3.5">SGF</span>
        <span class="font-condensed font-extrabold text-[15px] tracking-[2px] uppercase text-white pl-2 leading-none">
            SATRIO <span class="text-red">GYM</span>
        </span>
    </a>
    <p class="text-[12px] text-muted">© 2026 Satrio Gym Fitness Semarang. Dibangun untuk yang serius.</p>
</footer>

<!-- Float WA -->
<a href="https://wa.me/6289674901212" target="_blank"
   class="float-btn fixed bottom-6 right-6 w-[50px] h-[50px] bg-red rounded-full flex items-center justify-center text-white text-xl z-50 no-underline shadow-[0_4px_20px_rgba(224,32,32,0.4)] transition-transform max-sm:bottom-4 max-sm:right-4 max-sm:w-[46px] max-sm:h-[46px]">
    <i class="fab fa-whatsapp"></i>
</a>

<script>
    const navToggle = document.getElementById('navToggle');
    const mobileNav = document.getElementById('mobileNav');

    navToggle.addEventListener('click', () => mobileNav.classList.toggle('open'));

    function closeMobileNav() { mobileNav.classList.remove('open'); }

    document.addEventListener('click', (e) => {
        if (!navToggle.contains(e.target) && !mobileNav.contains(e.target)) {
            mobileNav.classList.remove('open');
        }
    });
</script>

</body>
</html>