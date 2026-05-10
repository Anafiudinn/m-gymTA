<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satrio Gym Fitness – Semarang</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700;800;900&family=Barlow+Condensed:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --red: #e02020;
            --red-dark: #b91c1c;
            --bg: #0a0a0a;
            --bg2: #111111;
            --bg3: #1a1a1a;
            --border: #2a2a2a;
            --text: #ffffff;
            --muted: #888888;
            --card: #161616;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Barlow', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(10,10,10,0.97);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 60px;
        }

        /* ── LOGO BARU ── */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0;
            text-decoration: none;
            flex-shrink: 0;
        }

        .logo-mark {
            background: var(--red);
            color: #fff;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            letter-spacing: 1px;
            padding: 4px 10px 3px;
            line-height: 1;
            clip-path: polygon(0 0, 100% 0, 88% 100%, 0 100%);
            padding-right: 18px;
        }

        .logo-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 19px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text);
            padding-left: 10px;
            line-height: 1;
        }

        .logo-name span {
            color: var(--red);
        }

        .nav-links {
            display: flex;
            gap: 28px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #aaa;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: color .2s;
        }

        .nav-links a:hover { color: var(--text); }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .btn-masuk {
            background: none; border: none; cursor: pointer;
            color: #aaa; font-weight: 600; font-size: 12px;
            letter-spacing: 1.5px; text-transform: uppercase;
            transition: color .2s; text-decoration: none;
        }
        .btn-masuk:hover { color: var(--text); }

        .btn-daftar {
            background: var(--red);
            color: #fff;
            border: none; cursor: pointer;
            font-family: 'Barlow', sans-serif;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 9px 18px;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-daftar:hover { background: var(--red-dark); }

        /* Hamburger */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            flex-direction: column;
            gap: 5px;
        }

        .nav-toggle span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--text);
            transition: all .3s;
        }

        /* Mobile nav drawer */
        .mobile-nav {
            display: none;
            position: fixed;
            top: 60px; left: 0; right: 0;
            background: #0d0d0d;
            border-bottom: 1px solid var(--border);
            z-index: 999;
            padding: 20px 24px;
            flex-direction: column;
            gap: 0;
        }

        .mobile-nav.open { display: flex; }

        .mobile-nav a {
            text-decoration: none;
            color: #ccc;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
            transition: color .2s;
        }

        .mobile-nav a:last-child { border-bottom: none; }
        .mobile-nav a:hover { color: var(--text); }

        .mobile-nav .mob-daftar {
            margin-top: 16px;
            background: var(--red);
            color: #fff;
            text-align: center;
            padding: 13px;
            font-weight: 800;
            border-bottom: none;
        }

        /* ── HERO ── */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 80px 32px 48px;
            position: relative;
            overflow: hidden;
            flex-wrap: wrap;
            gap: 40px;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.18;
            filter: grayscale(60%);
        }
        .hero-bg,
.hero-overlay {
    pointer-events: none;
}



        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(10,10,10,0.85) 50%, rgba(10,10,10,0.5) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            flex: 1;
            min-width: 280px;
            max-width: 600px;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1.5px solid var(--red);
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text);
            margin-bottom: 28px;
        }

        .hero-tag::before {
            content: '■';
            color: var(--red);
            font-size: 8px;
        }

        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(70px, 10vw, 130px);
            line-height: 0.9;
            letter-spacing: 2px;
            margin-bottom: 24px;
        }

        .hero-title .red { color: var(--red); }

        .hero-desc {
            font-size: 15px;
            color: #aaa;
            line-height: 1.7;
            max-width: 460px;
            margin-bottom: 36px;
        }

        .hero-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--red);
            color: #fff;
            padding: 14px 28px;
            font-family: 'Barlow', sans-serif;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: background .2s;
            border: 2px solid var(--red);
        }
        .btn-primary:hover { background: var(--red-dark); border-color: var(--red-dark); }

        .btn-outline {
            background: transparent;
            color: #fff;
            padding: 14px 28px;
            font-family: 'Barlow', sans-serif;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            border: 2px solid #444;
            transition: border-color .2s;
        }
        .btn-outline:hover { border-color: #888; }

        .hero-cards {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-width: 240px;
            flex-shrink: 0;
        }

        .info-card {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 18px 22px;
        }

        .info-card-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 6px;
        }

        .info-card-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .info-card-sub {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── TENTANG ── */
        #tentang {
            padding: 100px 32px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .about-image-wrap {
            position: relative;
        }

        .about-image-placeholder {
            width: 100%;
            height: 480px;
            background: linear-gradient(135deg, #1a0a0a 0%, #2a0f0f 50%, #1a0a0a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .about-image-placeholder::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.6;
            filter: grayscale(40%);
        }

        .about-badge {
            position: absolute;
            bottom: -16px; right: -16px;
            background: var(--red);
            padding: 18px 22px;
            text-align: center;
            z-index: 2;
        }

        .about-badge-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 44px;
            line-height: 1;
            display: block;
        }

        .about-badge-text {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

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
            line-height: 0.95;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .section-title .red { color: var(--red); }

        .section-desc {
            font-size: 15px;
            color: #aaa;
            line-height: 1.8;
            margin-bottom: 36px;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
        }

        .stat-item {
            background: var(--card);
            padding: 20px 16px;
            text-align: center;
        }

        .stat-icon { color: var(--red); font-size: 18px; margin-bottom: 10px; }

        .stat-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .stat-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 15px;
            font-weight: 800;
        }

        /* ── LAYANAN ── */
        #layanan {
            padding: 100px 32px;
            background: var(--bg2);
        }

        .section-header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: end;
            margin-bottom: 56px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--border);
        }

        .service-card {
            background: var(--card);
            padding: 36px 28px;
            position: relative;
            transition: background .3s;
        }

        .service-card:hover { background: #1e1e1e; }

        .service-num {
            position: absolute;
            top: 20px; right: 24px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 48px;
            color: #1e1e1e;
            line-height: 1;
            transition: color .3s;
        }

        .service-card:hover .service-num { color: #252525; }

        .service-icon {
            color: var(--red);
            font-size: 26px;
            margin-bottom: 20px;
        }

        .service-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .service-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.7;
        }

        /* ── HARGA ── */
        #harga {
            padding: 100px 32px;
        }

        .pricing-header { text-align: center; margin-bottom: 56px; }
        .pricing-header .section-desc { max-width: 520px; margin: 0 auto; }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--border);
        }

        .price-card {
            background: var(--card);
            padding: 36px 28px;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .price-card.featured {
            background: #1a0808;
            border-top: 3px solid var(--red);
            margin-top: -10px;
            padding-top: 48px;
        }

        .price-badge {
            position: absolute;
            top: -10px; left: 50%; transform: translateX(-50%);
            background: var(--red);
            padding: 4px 12px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex; align-items: center; gap: 5px;
        }

        .price-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .price-amount {
            margin-bottom: 8px;
        }

        .price-amount .amount {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 50px;
            line-height: 1;
            color: var(--red);
        }

        .price-amount .period {
            font-size: 13px;
            color: var(--muted);
            margin-left: 3px;
        }

        .price-tagline {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .price-features {
            list-style: none;
            flex: 1;
            margin-bottom: 28px;
        }

        .price-features li {
            font-size: 13px;
            color: #ccc;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 8px;
        }

        .price-features li:last-child { border-bottom: none; }
        .price-features li i { color: var(--red); font-size: 11px; flex-shrink: 0; }

        .btn-price {
            width: 100%;
            padding: 13px;
            font-family: 'Barlow', sans-serif;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: 2px solid #444;
            background: transparent;
            color: #fff;
            transition: all .2s;
            display: block;
        }

        .btn-price:hover { border-color: #888; }

        .btn-price.red {
            background: var(--red);
            border-color: var(--red);
        }

        .btn-price.red:hover { background: var(--red-dark); border-color: var(--red-dark); }

        /* ── GALERI ── */
        #galeri {
            padding: 100px 32px;
            background: var(--bg2);
        }

        .gallery-header { text-align: center; margin-bottom: 56px; }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
        }

        .gallery-item {
            aspect-ratio: 3/4;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }

        .gallery-img {
            width: 100%; height: 100%;
            object-fit: cover;
            filter: grayscale(100%);
            transition: filter .4s, transform .4s;
            display: block;
        }

        .gallery-item:hover .gallery-img {
            filter: grayscale(30%);
            transform: scale(1.04);
        }

        /* ── LOKASI ── */
        #lokasi {
            padding: 100px 32px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .location-info .section-desc { margin-bottom: 28px; }

        .location-details {
            display: flex;
            flex-direction: column;
            gap: 1px;
            background: var(--border);
        }

        .location-detail-item {
            background: var(--card);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-left: 3px solid transparent;
            transition: border-color .2s;
        }

        .location-detail-item:hover { border-color: var(--red); }

        .location-detail-icon { color: var(--red); font-size: 18px; width: 22px; text-align: center; flex-shrink: 0; }

        .location-detail-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 3px;
        }

        .location-detail-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .map-container {
            height: 420px;
            border: 1px solid var(--border);
            overflow: hidden;
            position: relative;
        }

        .map-container iframe {
            width: 100%; height: 100%;
            border: none;
            filter: grayscale(40%) invert(90%) hue-rotate(180deg);
        }

        /* ── CTA ── */
        .cta-wrapper {
            padding: 0 32px 72px;
        }

        #cta {
            padding: 72px 40px;
            background: var(--bg2);
            border: 1px solid var(--border);
        }

        .cta-inner {
            text-align: center;
            max-width: 680px;
            margin: 0 auto;
        }

        .cta-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(42px, 6vw, 76px);
            line-height: 0.95;
            margin-bottom: 18px;
        }

        .cta-title .red { color: var(--red); }

        .cta-desc {
            font-size: 15px;
            color: #888;
            margin-bottom: 36px;
        }

        .cta-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-contacts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--border);
            margin-top: 48px;
            border-top: 1px solid var(--border);
            padding-top: 36px;
        }

        .cta-contact-item {
            text-align: center;
            padding: 12px;
        }

        .cta-contact-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .cta-contact-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        /* ── FOOTER ── */
        footer {
            background: #080808;
            border-top: 1px solid var(--border);
            padding: 28px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-size: 12px;
            color: var(--muted);
        }

        /* ── FLOAT CHAT ── */
        .float-chat {
            position: fixed;
            bottom: 24px; right: 24px;
            width: 50px; height: 50px;
            background: var(--red);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 20px;
            cursor: pointer;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(224,32,32,0.4);
            text-decoration: none;
            transition: transform .2s;
        }
        .float-chat:hover { transform: scale(1.1); }

        /* ════════════════════════════
           RESPONSIVE — TABLET & MOBILE
        ════════════════════════════ */

        /* Tablet ≤ 1024px */
        @media (max-width: 1024px) {
            nav { padding: 0 24px; }

            .nav-links { display: none; }

            .nav-toggle { display: flex; }

            .btn-masuk { display: none; }

            .btn-daftar { display: none; }

            #hero {
                padding: 80px 24px 48px;
                flex-direction: column;
                min-height: auto;
                padding-bottom: 64px;
            }

            .hero-content { max-width: 100%; }

            .hero-cards {
                flex-direction: row;
                width: 100%;
            }

            .info-card { flex: 1; }

            #tentang {
                grid-template-columns: 1fr;
                padding: 80px 24px;
                gap: 40px;
            }

            .about-image-placeholder { height: 340px; }

            .about-badge { bottom: -12px; right: 12px; }

            .section-header {
                grid-template-columns: 1fr;
                gap: 24px;
                margin-bottom: 40px;
            }

            .services-grid {
                grid-template-columns: 1fr 1fr;
            }

            #layanan { padding: 80px 24px; }

            .pricing-grid {
                grid-template-columns: 1fr 1fr;
            }

            #harga { padding: 80px 24px; }

            .price-card.featured {
                margin-top: 0;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            #galeri { padding: 80px 24px; }

            #lokasi {
                grid-template-columns: 1fr;
                padding: 80px 24px;
                gap: 40px;
            }

            .map-container { height: 320px; }

            .cta-wrapper { padding: 0 24px 60px; }
            #cta { padding: 56px 28px; }
        }

        /* Mobile ≤ 640px */
        @media (max-width: 640px) {
            nav { padding: 0 16px; height: 56px; }

            .logo-mark { font-size: 18px; }
            .logo-name { font-size: 16px; }

            .mobile-nav { top: 56px; padding: 16px; }

            #hero {
                padding: 72px 16px 48px;
            }

            .hero-title { font-size: clamp(60px, 18vw, 90px); }

            .hero-desc { font-size: 14px; }

            .hero-cards {
                flex-direction: column;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary, .btn-outline {
                text-align: center;
                justify-content: center;
            }

            #tentang { padding: 64px 16px; }

            .about-stats { grid-template-columns: 1fr; }

            .stat-item { padding: 16px; }

            .section-title { font-size: clamp(38px, 11vw, 58px); }

            #layanan { padding: 64px 16px; }

            .services-grid { grid-template-columns: 1fr; }

            .service-card { padding: 28px 22px; }

            #harga { padding: 64px 16px; }

            .pricing-grid { grid-template-columns: 1fr; gap: 0; }

            .price-card.featured {
                margin-top: 0;
                border-top: none;
                border-left: 3px solid var(--red);
                padding-top: 40px;
            }

            .price-badge { display: none; }

            #galeri { padding: 64px 16px; }

            .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 4px; }

            #lokasi { padding: 64px 16px; }

            .map-container { height: 260px; }

            .cta-wrapper { padding: 0 16px 48px; }
            #cta { padding: 40px 20px; }

            .cta-contacts { grid-template-columns: 1fr; }

            .cta-contact-item { padding: 14px; }

            footer { padding: 24px 16px; flex-direction: column; align-items: flex-start; }

            .float-chat { bottom: 16px; right: 16px; width: 46px; height: 46px; }
        }
        
    </style>
</head>
<body>

<!-- ── NAVBAR ── -->
<nav>
    <a href="#hero" class="nav-logo">
        <span class="logo-mark">SGF</span>
        <span class="logo-name">SATRIO <span>GYM</span></span>
    </a>

    <ul class="nav-links">
        <li><a href="#tentang">Tentang</a></li>
        <li><a href="#harga">Harga</a></li>
        <li><a href="#layanan">Layanan</a></li>
        <li><a href="#galeri">Galeri</a></li>
        <li><a href="#lokasi">Lokasi</a></li>
    </ul>

    <div class="nav-actions">
     <!-- SESUDAH — tambahkan fallback -->
<a href="/login" class="btn-masuk">Masuk</a>
<a href="/register" class="btn-daftar">Daftar</a>
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- Mobile Nav Drawer -->
<div class="mobile-nav" id="mobileNav">
    <a href="#tentang" onclick="closeMobileNav()">Tentang</a>
    <a href="#harga" onclick="closeMobileNav()">Harga</a>
    <a href="#layanan" onclick="closeMobileNav()">Layanan</a>
    <a href="#galeri" onclick="closeMobileNav()">Galeri</a>
    <a href="#lokasi" onclick="closeMobileNav()">Lokasi</a>
    <a href="{{ route('login') }}" onclick="closeMobileNav()">Masuk</a>
    <a href="{{ route('register') }}" class="mob-daftar" onclick="closeMobileNav()">Daftar Sekarang →</a>
</div>

<!-- ── HERO ── -->
<section id="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <div class="hero-tag">Buka Setiap Hari &middot; Semarang</div>

        <h1 class="hero-title">
            ANGKAT.<br>
            KUAT.<br>
            <span class="red">MENANG.</span>
        </h1>

        <p class="hero-desc">
            Satrio Gym Fitness — pusat angkat beban di jantung kota Semarang.
            Alat lengkap, suasana serius, harga jujur. Untuk kamu yang benar-benar mau berubah.
        </p>

        <div class="hero-buttons">
            <a href="{{ route('register') }}" class="btn-primary">
                Daftar Sekarang <i class="fas fa-arrow-right"></i>
            </a>
            <a href="#harga" class="btn-outline">Lihat Harga</a>
        </div>
    </div>

    <div class="hero-cards">
        <div class="info-card">
            <div class="info-card-label"><i class="fas fa-clock"></i>&nbsp; Jam Operasional</div>
            <div class="info-card-value">07:00 – 22:00</div>
            <div class="info-card-sub">Buka setiap hari</div>
        </div>
        <div class="info-card">
            <div class="info-card-label"><i class="fas fa-map-marker-alt"></i>&nbsp; Lokasi</div>
            <div class="info-card-value">SEMARANG KOTA</div>
            <div class="info-card-sub">Strategis &amp; mudah dijangkau</div>
        </div>
    </div>
</section>

<!-- ── TENTANG ── -->
<section id="tentang">
    <div class="about-image-wrap">
        <div class="about-image-placeholder"></div>
        <div class="about-badge">
            <span class="about-badge-num">100%</span>
            <span class="about-badge-text">Alat Berat</span>
        </div>
    </div>

    <div class="about-info">
        <div class="section-tag">Tentang Satrio Gym</div>
        <h2 class="section-title">
            TEMPAT DI MANA <span class="red">KERINGAT</span><br>
            BERBICARA.
        </h2>
        <p class="section-desc">
            Kami fokus ke satu hal: <strong>alat berat</strong>. Tidak ada distraksi, tidak ada gimmick.
            Hanya barbel, dumbbell, dan besi yang siap kamu taklukkan setiap hari.
        </p>

        <div class="about-stats">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-fire"></i></div>
                <div class="stat-label">Besi Asli</div>
                <div class="stat-value">Alat berat lengkap</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">Komunitas</div>
                <div class="stat-value">Suasana serius</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                <div class="stat-label">Hasil Nyata</div>
                <div class="stat-value">Tanpa kompromi</div>
            </div>
        </div>
    </div>
</section>

<!-- ── LAYANAN ── -->
<section id="layanan">
    <div class="section-header">
        <div>
            <div class="section-tag">Yang Kami Tawarkan</div>
            <h2 class="section-title">
                FOKUS KE BESI.<br>
                SISANYA KAMI URUS.
            </h2>
        </div>
        <p class="section-desc" style="margin-bottom:0">
            Tidak perlu fasilitas mewah yang bikin terdistraksi. Satrio Gym menyediakan yang paling penting:
            alat berat berkualitas dan dukungan untuk progres maksimal.
        </p>
    </div>

    <div class="services-grid">
        <div class="service-card">
            <span class="service-num">01</span>
            <div class="service-icon"><i class="fas fa-dumbbell"></i></div>
            <div class="service-name">Alat Berat Lengkap</div>
            <p class="service-desc">Barbell, dumbbell, rack, dan mesin untuk semua kebutuhan latihan kekuatan.</p>
        </div>
        <div class="service-card">
            <span class="service-num">02</span>
            <div class="service-icon"><i class="fas fa-user-friends"></i></div>
            <div class="service-name">Personal Trainer</div>
            <p class="service-desc">Program 1-on-1 bersama trainer berpengalaman. 10x pertemuan untuk hasil terukur.</p>
        </div>
        <div class="service-card">
            <span class="service-num">03</span>
            <div class="service-icon"><i class="fas fa-tint"></i></div>
            <div class="service-name">Retail di Lokasi</div>
            <p class="service-desc">Air mineral Aqua dan kebutuhan latihan tersedia. Tetap fokus, tanpa keluar gym.</p>
        </div>
    </div>
</section>

<!-- ── HARGA ── -->
<section id="harga">
    <div class="pricing-header">
        <div class="section-tag">Daftar Harga</div>
        <h2 class="section-title">PILIH JALAN <span class="red">KERASMU.</span></h2>
        <p class="section-desc">Harga jujur, tanpa biaya tersembunyi. Bayar sesuai cara latihanmu.</p>
    </div>

    <div class="pricing-grid">
        <!-- Tamu Harian -->
        <div class="price-card">
            <div class="price-name">Tamu Harian</div>
            <div class="price-amount">
                <span class="amount">{{ isset($settings['visit_tamu']) ? number_format($settings['visit_tamu']/1000, 0).'K' : '15K' }}</span>
                <span class="period">/ kunjungan</span>
            </div>
            <p class="price-tagline">Mau coba dulu? Datang bayar latihan.</p>
            <ul class="price-features">
                <li><i class="fas fa-check"></i> Akses semua alat</li>
                <li><i class="fas fa-check"></i> Tanpa komitmen</li>
                <li><i class="fas fa-check"></i> Cocok untuk freelance</li>
            </ul>
            <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6289674901212' }}" target="_blank" class="btn-price">Datang Langsung</a>
        </div>

        <!-- Aktivasi Member -->
        <div class="price-card featured">
            <div class="price-badge">⚡ Best Value</div>
            <div class="price-name">Aktivasi Member</div>
            <div class="price-amount">
                <span class="amount">{{ isset($settings['biaya_aktivasi']) ? number_format($settings['biaya_aktivasi']/1000, 0).'K' : '80K' }}</span>
                <span class="period">selamanya</span>
            </div>
            <p class="price-tagline">Bayar sekali, jadi member seumur hidup.</p>
            <ul class="price-features">
                <li><i class="fas fa-check"></i> Per kunjungan cuma {{ isset($settings['visit_member']) ? number_format($settings['visit_member']/1000, 0).'K' : '7K' }}</li>
                <li><i class="fas fa-check"></i> Berlaku selamanya</li>
                <li><i class="fas fa-check"></i> Hemat untuk jangka panjang</li>
            </ul>
            <a href="{{ route('register') }}" class="btn-price red">Aktivasi Sekarang</a>
        </div>

        <!-- Member Bulanan -->
        <div class="price-card">
            <div class="price-name">Member Bulanan</div>
            <div class="price-amount">
                <span class="amount">{{ isset($settings['bulanan_member']) ? number_format($settings['bulanan_member']/1000, 0).'K' : '110K' }}</span>
                <span class="period">/ bulan</span>
            </div>
            <p class="price-tagline">Khusus yang sudah aktivasi member.</p>
            <ul class="price-features">
                <li><i class="fas fa-check"></i> Akses unlimited 1 bulan</li>
                <li><i class="fas fa-check"></i> Tanpa biaya per kunjungan</li>
                <li><i class="fas fa-check"></i> Non-member: {{ isset($settings['bulanan_tamu']) ? number_format($settings['bulanan_tamu']/1000, 0).'K' : '200K' }}/bulan</li>
            </ul>
            <a href="{{ route('register') }}" class="btn-price">Pilih Paket</a>
        </div>

        <!-- Personal Trainer -->
        @if(isset($paket_pt) && $paket_pt->count())
            @foreach($paket_pt->take(1) as $pt)
            <div class="price-card">
                <div class="price-name">Personal Trainer</div>
                <div class="price-amount">
                    <span class="amount">{{ number_format($pt->harga/1000, 0) }}K</span>
                    <span class="period">/ {{ $pt->jumlah_sesi }} sesi</span>
                </div>
                <p class="price-tagline">Program 1-on-1 dengan PT berpengalaman.</p>
                <ul class="price-features">
                    <li><i class="fas fa-check"></i> {{ $pt->jumlah_sesi }}x pertemuan intensif</li>
                    <li><i class="fas fa-check"></i> Program disesuaikan</li>
                    <li><i class="fas fa-check"></i> Pendampingan penuh</li>
                </ul>
                <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6289674901212' }}" target="_blank" class="btn-price">Booking PT</a>
            </div>
            @endforeach
        @else
            <div class="price-card">
                <div class="price-name">Personal Trainer</div>
                <div class="price-amount">
                    <span class="amount">900K</span>
                    <span class="period">/ 10 sesi</span>
                </div>
                <p class="price-tagline">Program 1-on-1 dengan PT berpengalaman.</p>
                <ul class="price-features">
                    <li><i class="fas fa-check"></i> 10x pertemuan intensif</li>
                    <li><i class="fas fa-check"></i> Program disesuaikan</li>
                    <li><i class="fas fa-check"></i> Pendampingan penuh</li>
                </ul>
                <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6289674901212' }}" target="_blank" class="btn-price">Booking PT</a>
            </div>
        @endif
    </div>
</section>

<!-- ── GALERI ── -->
<section id="galeri">
    <div class="gallery-header">
        <div class="section-tag">Galeri</div>
        <h2 class="section-title">LIHAT <span class="red">TEMPATNYA.</span></h2>
        <p class="section-desc" style="color:#888;font-size:15px;margin-top:12px">
            Suasana asli Satrio Gym Fitness — apa adanya, fokus pada yang penting.
        </p>
    </div>

    <div class="gallery-grid">
        @php
            $galleryImages = [
                'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&q=80',
                'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=600&q=80',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
                'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=600&q=80',
            ];
        @endphp

        @foreach($galleryImages as $img)
        <div class="gallery-item">
            <img src="{{ $img }}" alt="Satrio Gym" class="gallery-img" loading="lazy">
        </div>
        @endforeach
    </div>
</section>

<!-- ── LOKASI ── -->
<section id="lokasi">
    <div class="location-info">
        <div class="section-tag">Lokasi Kami</div>
        <h2 class="section-title">DATANG DAN <span class="red">RASAKAN</span> SENDIRI.</h2>
        <p class="section-desc">
            Satrio Gym Fitness berlokasi strategis di Semarang Kota. Mudah dijangkau dari berbagai arah.
        </p>

        <div class="location-details">
            <div class="location-detail-item">
                <div class="location-detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <div class="location-detail-label">Alamat</div>
                    <div class="location-detail-value">{{ $settings['alamat'] ?? 'Satrio Fitness Club, Semarang' }}</div>
                </div>
            </div>
            <div class="location-detail-item">
                <div class="location-detail-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="location-detail-label">Jam Buka</div>
                    <div class="location-detail-value">Setiap Hari &middot; 07:00 – 22:00</div>
                </div>
            </div>
            <div class="location-detail-item">
                <div class="location-detail-icon"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <div class="location-detail-label">WhatsApp</div>
                    <div class="location-detail-value">{{ $settings['whatsapp'] ?? '0896 7490 1212' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15799.623113351641!2d110.43915708696574!3d-6.983480299999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708ccf72359b7b%3A0x6599f51a22f8c56!2sSatrio%20Fitness%20Club!5e1!3m2!1sid!2sid!4v1778149032478!5m2!1sid!2sid"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

<!-- ── CTA ── -->
<div class="cta-wrapper">
    <div id="cta">
        <div class="cta-inner">
            <h2 class="cta-title">SIAP MULAI? <span class="red">DAFTAR HARI INI.</span></h2>
            <p class="cta-desc">Bikin akun, pilih paket, dan langsung mulai latihan. Tidak ada alasan lagi.</p>

            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-primary">
                    Buat Akun <i class="fas fa-arrow-right"></i>
                </a>
                <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6289674901212' }}" target="_blank" class="btn-outline">
                    Chat WhatsApp
                </a>
            </div>

            <div class="cta-contacts">
                <div class="cta-contact-item">
                    <div class="cta-contact-label">WhatsApp</div>
                    <div class="cta-contact-value">{{ $settings['whatsapp'] ?? '0896 7490 1212' }}</div>
                </div>
                <div class="cta-contact-item">
                    <div class="cta-contact-label">Instagram</div>
                    <div class="cta-contact-value">{{ $settings['instagram'] ?? '@UBGYM' }}</div>
                </div>
                <div class="cta-contact-item">
                    <div class="cta-contact-label">Lokasi</div>
                    <div class="cta-contact-value">SEMARANG KOTA</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── FOOTER ── -->
<footer>
    <a href="#hero" class="nav-logo">
        <span class="logo-mark" style="font-size:16px;padding:3px 14px 2px 8px">SGF</span>
        <span class="logo-name" style="font-size:15px;padding-left:8px">SATRIO <span>GYM</span></span>
    </a>
    <p class="footer-copy">© 2026 Satrio Gym Fitness Semarang. Dibangun untuk yang serius.</p>
</footer>

<!-- ── FLOAT WHATSAPP ── -->
<a href="https://wa.me/{{ $settings['whatsapp'] ?? '6289674901212' }}" target="_blank" class="float-chat">
    <i class="fab fa-whatsapp"></i>
</a>

<script>
    const navToggle = document.getElementById('navToggle');
    const mobileNav = document.getElementById('mobileNav');

    navToggle.addEventListener('click', () => {
        mobileNav.classList.toggle('open');
    });

    function closeMobileNav() {
        mobileNav.classList.remove('open');
    }

    // Close on outside click
    document.addEventListener('click', (e) => {
        if (!navToggle.contains(e.target) && !mobileNav.contains(e.target)) {
            mobileNav.classList.remove('open');
        }
    });
</script>

</body>
</html>