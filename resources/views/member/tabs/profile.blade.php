
@push('styles')
<style>

    .page-label {
        color: var(--red);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .22em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .page-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(36px, 6vw, 58px);
        line-height: .95;
        letter-spacing: .04em;
        margin-bottom: 6px;
    }

    .page-title span { color: var(--red); }

    .page-sub {
        color: var(--muted);
        font-size: 14px;
        line-height: 1.7;
    }

    /* ── GRID ── */
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 28px;
    }

    @media(max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ── PANEL HEADER ── */
    .panel-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border);
    }

    .panel-head-icon {
        width: 38px;
        height: 38px;
        background: var(--red-dim);
        border: 1px solid rgba(255,45,45,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 14px;
        flex-shrink: 0;
    }

    .panel-head-title {
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--text);
    }

    .panel-head-sub {
        font-size: 11px;
        color: var(--muted);
        margin-top: 2px;
    }

    /* ── AVATAR BLOCK ── */
    .avatar-block {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 22px;
        padding: 16px;
        background: rgba(255,45,45,.04);
        border: 1px solid rgba(255,45,45,.1);
    }

    .avatar-big {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--red-dim);
        border: 2px solid rgba(255,45,45,.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        color: var(--red);
        flex-shrink: 0;
        box-shadow: 0 0 28px rgba(255,45,45,.18);
    }

    .avatar-info-name {
        font-size: 15px;
        font-weight: 800;
        color: var(--text);
    }

    .avatar-info-meta {
        font-size: 11px;
        color: var(--muted);
        margin-top: 3px;
        font-family: 'Barlow Condensed', sans-serif;
        letter-spacing: .08em;
    }

    .avatar-info-meta span {
        color: var(--red);
    }

    /* ── FIELD ── */
    .field {
        margin-bottom: 18px;
    }

    .field label {
        display: block;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 7px;
    }

    .field-wrap {
        position: relative;
    }

    .field-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 13px;
        pointer-events: none;
        transition: color .2s;
    }

    .field input {
        width: 100%;
        padding: 11px 14px 11px 38px;
        background: var(--bg3);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: 13px;
        font-weight: 600;
        font-family: 'Barlow', sans-serif;
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
        -webkit-appearance: none;
    }

    .field input:focus {
        border-color: rgba(255,45,45,.5);
        background: rgba(255,45,45,.03);
        box-shadow: 0 0 0 3px rgba(255,45,45,.06), inset 0 0 0 1px rgba(255,45,45,.15);
    }

    .field input:focus + .field-icon,
    .field-wrap:focus-within .field-icon {
        color: var(--red);
    }

    .field input:disabled {
        opacity: .45;
        cursor: not-allowed;
        background: rgba(255,255,255,.03);
    }

    .field input.has-error {
        border-color: rgba(255,45,45,.6);
        background: rgba(255,45,45,.05);
    }

    .field-error {
        margin-top: 6px;
        font-size: 11px;
        font-weight: 700;
        color: var(--red);
        letter-spacing: .04em;
    }

    .field-error i { margin-right: 4px; }

    /* Toggle password btn */
    .pwd-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--muted);
        cursor: pointer;
        padding: 4px;
        font-size: 13px;
        transition: color .18s;
    }

    .pwd-toggle:hover { color: var(--red); }

    .field input.has-pwd-toggle {
        padding-right: 40px;
    }

    /* ── DISABLED LABEL ── */
    .field-disabled-note {
        display: inline-block;
        margin-left: 6px;
        font-size: 9px;
        font-weight: 600;
        color: var(--muted);
        letter-spacing: .06em;
        text-transform: none;
        font-style: italic;
    }

    /* ── SUBMIT BUTTON ── */
    .btn-submit {
        position: relative;
        overflow: hidden;
        width: 100%;
        padding: 13px 20px;
        background: var(--red);
        border: none;
        color: #fff;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 17px;
        letter-spacing: .12em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background .2s, box-shadow .2s;
        margin-top: 4px;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,.08), transparent);
        pointer-events: none;
    }

    .btn-submit:hover {
        background: var(--red-dark);
        box-shadow: 0 0 28px rgba(255,45,45,.3);
    }

    .btn-submit.dark {
        background: rgba(255,255,255,.08);
        border: 1px solid var(--border);
        color: var(--text);
    }

    .btn-submit.dark:hover {
        background: rgba(255,255,255,.13);
        box-shadow: none;
        border-color: rgba(255,255,255,.18);
    }

    /* ── ALERT FLASH ── */
    .flash-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        margin-bottom: 22px;
        border: 1px solid;
        font-size: 13px;
        font-weight: 600;
    }

    .flash-alert.success {
        background: rgba(16,185,129,.08);
        border-color: rgba(16,185,129,.25);
        color: var(--green);
    }

    .flash-alert.error {
        background: var(--red-dim);
        border-color: rgba(255,45,45,.25);
        color: var(--red);
    }

    .flash-alert i { font-size: 15px; flex-shrink: 0; }

</style>
@endpush

@section('content')

{{-- ── PAGE HEADING ── --}}
<div style="margin-bottom: 28px;">
    <div class="page-label">Akun Saya</div>
    <div class="page-title">EDIT <span>PROFIL</span></div>
    <div class="page-sub">Perbarui informasi pribadi dan kata sandi akun kamu.</div>
</div>

{{-- ── FLASH ALERTS ── --}}
@if(session('status') === 'profile-updated')
    <div class="flash-alert success">
        <i class="fa-solid fa-circle-check"></i>
        Profil berhasil diperbarui.
    </div>
@endif

@if(session('status') === 'password-updated')
    <div class="flash-alert success">
        <i class="fa-solid fa-circle-check"></i>
        Kata sandi berhasil diperbarui.
    </div>
@endif

@if(session('error'))
    <div class="flash-alert error">
        <i class="fa-solid fa-circle-xmark"></i>
        {{ session('error') }}
    </div>
@endif

{{-- ── GRID ── --}}
<div class="profile-grid">

    {{-- ══════════════════════════════
         CARD KIRI — INFO PROFIL
    ══════════════════════════════ --}}
    <div class="panel">

        <div class="panel-head">
            <div class="panel-head-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>
            <div>
                <div class="panel-head-title">Informasi Profil</div>
                <div class="panel-head-sub">Nama & nomor WhatsApp kamu</div>
            </div>
        </div>

        {{-- Avatar info block --}}
        <div class="avatar-block">
            <div class="avatar-big">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <div class="avatar-info-name">{{ $user->name }}</div>
                <div class="avatar-info-meta">
                    {{ $user->member_code ?? '—' }}
                    &nbsp;·&nbsp;
                    <span>Member</span>
                    &nbsp;·&nbsp;
                    Bergabung {{ $user->created_at->format('M Y') }}
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            {{-- Nama --}}
            <div class="field">
                <label for="name">Nama Lengkap</label>
                <div class="field-wrap">
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        autocomplete="name"
                        class="{{ $errors->get('name') ? 'has-error' : '' }}"
                        placeholder="Nama kamu..."
                    >
                    <span class="field-icon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                </div>
                @error('name')
                    <div class="field-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- WhatsApp --}}
            <div class="field">
                <label for="whatsapp">Nomor WhatsApp</label>
                <div class="field-wrap">
                    <input
                        type="text"
                        id="whatsapp"
                        name="whatsapp"
                        value="{{ old('whatsapp', $user->whatsapp) }}"
                        placeholder="08xxxxxxxxxx"
                        autocomplete="tel"
                        class="{{ $errors->get('whatsapp') ? 'has-error' : '' }}"
                    >
                    <span class="field-icon">
                        <i class="fa-brands fa-whatsapp" style="color: #25D366;"></i>
                    </span>
                </div>
                @error('whatsapp')
                    <div class="field-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email (read-only) --}}
            <div class="field">
                <label>
                    Email
                    <span class="field-disabled-note">— tidak dapat diubah</span>
                </label>
                <div class="field-wrap">
                    <input
                        type="email"
                        value="{{ $user->email }}"
                        disabled
                    >
                    <span class="field-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-floppy-disk"></i>
                SIMPAN PERUBAHAN
            </button>

        </form>

    </div>

    {{-- ══════════════════════════════
         CARD KANAN — GANTI PASSWORD
    ══════════════════════════════ --}}
    <div class="panel">

        <div class="panel-head">
            <div class="panel-head-icon">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <div class="panel-head-title">Keamanan Akun</div>
                <div class="panel-head-sub">Ganti kata sandi kamu</div>
            </div>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            {{-- Password Saat Ini --}}
            <div class="field">
                <label for="current_password">Kata Sandi Saat Ini</label>
                <div class="field-wrap">
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="has-pwd-toggle {{ $errors->updatePassword->get('current_password') ? 'has-error' : '' }}"
                    >
                    <span class="field-icon">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    <button type="button" class="pwd-toggle" onclick="togglePwd('current_password', this)">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <div class="field-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="field">
                <label for="password">Kata Sandi Baru</label>
                <div class="field-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="has-pwd-toggle {{ $errors->updatePassword->get('password') ? 'has-error' : '' }}"
                    >
                    <span class="field-icon">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <button type="button" class="pwd-toggle" onclick="togglePwd('password', this)">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password', 'updatePassword')
                    <div class="field-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="field">
                <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                <div class="field-wrap">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="has-pwd-toggle {{ $errors->updatePassword->get('password_confirmation') ? 'has-error' : '' }}"
                    >
                    <span class="field-icon">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <button type="button" class="pwd-toggle" onclick="togglePwd('password_confirmation', this)">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password_confirmation', 'updatePassword')
                    <div class="field-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password strength hint --}}
            <div style="
                padding: 12px 14px;
                background: rgba(255,255,255,.03);
                border: 1px solid var(--border);
                margin-bottom: 18px;
            ">
                <div style="font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px;">
                    Tips Kata Sandi Kuat
                </div>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <div style="font-size: 11px; color: var(--muted); display: flex; align-items: center; gap: 7px;">
                        <i class="fa-solid fa-angle-right" style="color: var(--red); font-size: 9px;"></i>
                        Minimal 8 karakter
                    </div>
                    <div style="font-size: 11px; color: var(--muted); display: flex; align-items: center; gap: 7px;">
                        <i class="fa-solid fa-angle-right" style="color: var(--red); font-size: 9px;"></i>
                        Kombinasi huruf besar, kecil & angka
                    </div>
                    <div style="font-size: 11px; color: var(--muted); display: flex; align-items: center; gap: 7px;">
                        <i class="fa-solid fa-angle-right" style="color: var(--red); font-size: 9px;"></i>
                        Jangan gunakan nama atau tanggal lahir
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit dark">
                <i class="fa-solid fa-shield-halved"></i>
                PERBARUI KATA SANDI
            </button>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
    function togglePwd(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon  = btn.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-regular fa-eye-slash';
            btn.style.color = 'var(--red)';
        } else {
            input.type = 'password';
            icon.className = 'fa-regular fa-eye';
            btn.style.color = '';
        }
    }
</script>
@endpush