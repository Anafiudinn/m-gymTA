<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password – Satrio Gym Fitness</title>
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

        body {
            font-family: 'Barlow', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ── LEFT PANEL ── */
        .auth-left {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 48px;
            min-height: 100vh;
            overflow: hidden;
        }

        .auth-left-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=900&q=80');
            background-size: cover;
            background-position: center;
            filter: grayscale(50%);
        }

        .auth-left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(10,10,10,0.97) 0%, rgba(10,10,10,0.5) 60%, rgba(10,10,10,0.3) 100%);
        }

        .auth-left-content {
            position: relative;
            z-index: 2;
        }

        .auth-tagline {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(52px, 6vw, 88px);
            line-height: 0.9;
            letter-spacing: 2px;
            margin-bottom: 16px;
        }

        .auth-tagline .red { color: var(--red); }

        .auth-sub {
            font-size: 14px;
            color: #999;
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 32px;
        }

        .auth-stats {
            display: flex;
            gap: 1px;
            background: var(--border);
            width: fit-content;
        }

        .auth-stat {
            background: rgba(22,22,22,0.9);
            padding: 14px 22px;
            backdrop-filter: blur(4px);
        }

        .auth-stat-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 4px;
        }

        .auth-stat-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        /* ── RIGHT PANEL ── */
        .auth-right {
            width: 480px;
            flex-shrink: 0;
            background: var(--bg2);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .auth-right-inner {
            padding: 48px 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ── LOGO ── */
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 0;
            text-decoration: none;
            margin-bottom: 48px;
        }

        .logo-mark {
            background: var(--red);
            color: #fff;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 18px;
            letter-spacing: 1px;
            padding: 3px 16px 3px 8px;
            line-height: 1;
            clip-path: polygon(0 0, 100% 0, 88% 100%, 0 100%);
        }

        .logo-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 16px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text);
            padding-left: 10px;
            line-height: 1;
        }

        .logo-name span { color: var(--red); }

        /* ── FORM HEADER ── */
        .form-tag {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 10px;
        }

        .form-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 44px;
            line-height: 0.95;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 36px;
            line-height: 1.6;
        }

        /* ── OTP STEPS INDICATOR ── */
        .steps-bar {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 28px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0;
            flex-shrink: 0;
        }

        .step.done .step-num {
            background: var(--red);
            color: #fff;
        }

        .step.active .step-num {
            background: transparent;
            border: 2px solid var(--red);
            color: var(--red);
        }

        .step-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .step.done .step-label { color: var(--red); }
        .step.active .step-label { color: #ccc; }

        .step-line {
            flex: 1;
            height: 1px;
            background: var(--border);
            margin: 0 8px;
            max-width: 32px;
        }

        /* ── SESSION STATUS ── */
        .session-status {
            background: rgba(34,197,94,0.08);
            border: 1px solid rgba(34,197,94,0.25);
            border-left: 3px solid #22c55e;
            padding: 12px 16px;
            font-size: 13px;
            color: #86efac;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── FORM FIELDS ── */
        .field-group {
            margin-bottom: 20px;
        }

        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 8px;
        }

        .field-input-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 13px;
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            background: var(--card);
            border: 1px solid var(--border);
            border-top: 2px solid var(--border);
            color: var(--text);
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            font-weight: 600;
            padding: 13px 14px 13px 40px;
            outline: none;
            transition: border-color .2s, background .2s;
            -webkit-appearance: none;
        }

        .field-input:focus {
            border-color: var(--red);
            background: #1a1a1a;
        }

        .field-input::placeholder { color: #444; font-weight: 400; }
        .field-input.is-error { border-color: #c0392b; }

        /* OTP field: bigger, more prominent */
        .field-input.otp-input {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 10px;
            text-align: center;
            padding: 14px 14px;
        }

        .field-error {
            font-size: 12px;
            color: #e74c3c;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* ── SUBMIT BTN ── */
        .btn-submit {
            width: 100%;
            background: var(--red);
            color: #fff;
            border: none;
            padding: 15px 24px;
            font-family: 'Barlow', sans-serif;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background .2s;
            margin-top: 8px;
        }

        .btn-submit:hover { background: var(--red-dark); }

        /* ── DIVIDER ── */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 28px 0;
        }

        .form-divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .form-divider-text {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #444;
        }

        /* ── BACK LINK ── */
        .btn-back {
            width: 100%;
            background: transparent;
            color: #ccc;
            border: 1px solid var(--border);
            padding: 14px 24px;
            font-family: 'Barlow', sans-serif;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: border-color .2s, color .2s;
            text-align: center;
        }

        .btn-back:hover { border-color: #666; color: var(--text); }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right {
                width: 100%;
                border-left: none;
                min-height: 100vh;
            }
            .auth-right-inner { justify-content: flex-start; }
        }

        @media (max-width: 480px) {
            .auth-right-inner { padding: 32px 24px; }
            .form-title { font-size: 36px; }
        }
    </style>
</head>
<body>

<!-- ── LEFT PANEL ── -->
<div class="auth-left">
    <div class="auth-left-bg"></div>
    <div class="auth-left-overlay"></div>
    <div class="auth-left-content">
        <h2 class="auth-tagline">
            SATU<br>
            LANGKAH<br>
            <span class="red">LAGI.</span>
        </h2>
        <p class="auth-sub">
            Kode OTP sudah dikirim ke WhatsApp kamu. Masukkan kode dan buat password baru sekarang.
        </p>
        <div class="auth-stats">
            <div class="auth-stat">
                <div class="auth-stat-label"><i class="fas fa-key"></i>&nbsp; Kode OTP</div>
                <div class="auth-stat-value">6 DIGIT</div>
            </div>
            <div class="auth-stat">
                <div class="auth-stat-label"><i class="fas fa-clock"></i>&nbsp; Berlaku</div>
                <div class="auth-stat-value">10 MENIT</div>
            </div>
        </div>
    </div>
</div>

<!-- ── RIGHT PANEL ── -->
<div class="auth-right">
    <div class="auth-right-inner">

        <a href="{{ url('/') }}" class="auth-logo">
            <span class="logo-mark">SGF</span>
            <span class="logo-name">SATRIO <span>GYM</span></span>
        </a>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="session-status">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        {{-- Step Indicator --}}
        <div class="steps-bar">
            <div class="step done">
                <div class="step-num"><i class="fas fa-check" style="font-size:9px;"></i></div>
                <span class="step-label">OTP Dikirim</span>
            </div>
            <div class="step-line"></div>
            <div class="step active">
                <div class="step-num">2</div>
                <span class="step-label">Reset Password</span>
            </div>
        </div>

        <div class="form-tag">Langkah Terakhir</div>
        <h1 class="form-title">RESET PASSWORD</h1>
        <p class="form-subtitle">Masukkan kode OTP 6-digit dari WhatsApp kamu dan buat password baru.</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="whatsapp" value="{{ $whatsapp }}">

            {{-- Kode OTP --}}
            <div class="field-group">
                <label class="field-label" for="token">Kode OTP WhatsApp</label>
                <div class="field-input-wrap">
                    <input
                        id="token"
                        class="field-input otp-input @error('token') is-error @enderror"
                        type="text"
                        name="token"
                        placeholder="• • • • • •"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        required
                        autofocus
                    >
                </div>
                @error('token')
                    <p class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="field-group">
                <label class="field-label" for="password">Password Baru</label>
                <div class="field-input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        id="password"
                        class="field-input @error('password') is-error @enderror"
                        type="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                        autocomplete="new-password"
                    >
                </div>
                @error('password')
                    <p class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="field-group">
                <label class="field-label" for="password_confirmation">Konfirmasi Password Baru</label>
                <div class="field-input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        id="password_confirmation"
                        class="field-input"
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password baru"
                        required
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Simpan Password Baru <i class="fas fa-save"></i>
            </button>
        </form>

        <div class="form-divider">
            <div class="form-divider-line"></div>
            <span class="form-divider-text">atau</span>
            <div class="form-divider-line"></div>
        </div>

        <a href="{{ route('password.request') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kirim Ulang Kode OTP
        </a>

    </div>
</div>

</body>
</html>