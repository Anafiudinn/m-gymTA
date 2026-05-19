@php
    // 🌟 Deteksi layout otomatis berdasarkan role user
    $userRole = Auth::user()->role ?? 'admin';
    $layoutFile = $userRole === 'owner' ? 'layouts.owner' : 'layouts.admin';
@endphp

@extends($layoutFile)

@section('title', 'Edit Profil')
@section('header-title', 'Edit Profil')

@section('content')

<div style=" width:100%; height:100%;">

    {{-- ===== PAGE HEADING ===== --}}
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 20px; font-weight: 800; color: #111; margin-bottom: 4px;">
            Edit Profil
        </h1>
        <p style="font-size: 13px; color: #888;">
            Perbarui informasi akun dan kata sandi Anda.
        </p>
    </div>

    {{-- ===== ALERT: profile-updated ===== --}}
    @if(session('status') === 'profile-updated')
        <div style="
            display: flex; align-items: center; gap: 10px;
            background: #f0fdf4; border: 1px solid #86efac;
            border-radius: 1px; padding: 12px 16px;
            margin-bottom: 20px; font-size: 13px; color: #166534;
        ">
            <i class="fa-solid fa-circle-check" style="color: #22c55e; font-size: 14px;"></i>
            Profil berhasil diperbarui.
        </div>
    @endif

    {{-- ===== CARD: INFORMASI PROFIL ===== --}}
    <div class="card" style="margin-bottom: 16px;">

        {{-- Header Card --}}
        <div style="
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 20px; padding-bottom: 16px;
            border-bottom: 1px solid rgba(0,0,0,.07);
        ">
            {{-- Avatar besar --}}
            <div style="
                width: 52px; height: 52px;
                background: linear-gradient(135deg, #ef4444, #991b1b);
                border-radius: 1px;
                display: flex; align-items: center; justify-content: center;
                font-size: 18px; font-weight: 800; color: #fff;
                flex-shrink: 0;
                box-shadow: 0 4px 14px rgba(239,68,68,.22);
            ">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <div style="font-size: 15px; font-weight: 800; color: #111;">
                    {{ $user->name }}
                </div>
                <div style="font-size: 12px; color: #aaa; margin-top: 2px; text-transform: capitalize;">
                    {{ ucfirst($user->role) }}
                    &nbsp;·&nbsp;
                    <span style="color: #bbb;">Bergabung {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Form Update Profil --}}
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            {{-- Nama --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 6px; letter-spacing: .03em; text-transform: uppercase;">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    autocomplete="name"
                    style="
                        width: 100%; padding: 10px 12px;
                        border: 1px solid {{ $errors->get('name') ? '#fca5a5' : 'rgba(0,0,0,.12)' }};
                        border-radius: 1px;
                        font-size: 13px; font-weight: 600; color: #111;
                        font-family: 'Outfit', sans-serif;
                        background: {{ $errors->get('name') ? '#fef2f2' : '#fafafa' }};
                        outline: none;
                        transition: .15s ease;
                    "
                    onfocus="this.style.borderColor='#ef4444'; this.style.background='#fff';"
                    onblur="this.style.borderColor='rgba(0,0,0,.12)'; this.style.background='#fafafa';"
                >
                @error('name')
                    <p style="font-size: 11px; color: #ef4444; margin-top: 5px; font-weight: 600;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- WhatsApp --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 6px; letter-spacing: .03em; text-transform: uppercase;">
                    Nomor WhatsApp
                </label>
                <div style="position: relative;">
                    <span style="
                        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
                        font-size: 13px; color: #aaa;
                    ">
                        <i class="fa-brands fa-whatsapp" style="color: #25D366;"></i>
                    </span>
                    <input
                        type="text"
                        name="whatsapp"
                        value="{{ old('whatsapp', $user->whatsapp) }}"
                        placeholder="08xxxxxxxxxx"
                        autocomplete="tel"
                        style="
                            width: 100%; padding: 10px 12px 10px 34px;
                            border: 1px solid {{ $errors->get('whatsapp') ? '#fca5a5' : 'rgba(0,0,0,.12)' }};
                            border-radius: 1px;
                            font-size: 13px; font-weight: 600; color: #111;
                            font-family: 'Outfit', sans-serif;
                            background: {{ $errors->get('whatsapp') ? '#fef2f2' : '#fafafa' }};
                            outline: none;
                            transition: .15s ease;
                        "
                        onfocus="this.style.borderColor='#25D366'; this.style.background='#fff';"
                        onblur="this.style.borderColor='rgba(0,0,0,.12)'; this.style.background='#fafafa';"
                    >
                </div>
                @error('whatsapp')
                    <p style="font-size: 11px; color: #ef4444; margin-top: 5px; font-weight: 600;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tombol Simpan --}}
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" style="
                    padding: 10px 22px;
                    background: #ef4444; color: #fff;
                    border: none; border-radius: 1px;
                    font-size: 13px; font-weight: 700;
                    font-family: 'Outfit', sans-serif;
                    cursor: pointer;
                    display: flex; align-items: center; gap: 8px;
                    transition: background .15s ease;
                "
                onmouseover="this.style.background='#dc2626';"
                onmouseout="this.style.background='#ef4444';"
                >
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

    {{-- ===== CARD: GANTI PASSWORD ===== --}}
    <div class="card">

        <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,.07);">
            <div style="font-size: 14px; font-weight: 800; color: #111; margin-bottom: 2px;">
                Ganti Kata Sandi
            </div>
            <div style="font-size: 12px; color: #aaa;">
                Pastikan akun Anda menggunakan kata sandi yang kuat dan unik.
            </div>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            {{-- Password Saat Ini --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 6px; letter-spacing: .03em; text-transform: uppercase;">
                    Kata Sandi Saat Ini
                </label>
                <div style="position: relative;">
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        autocomplete="current-password"
                        style="
                            width: 100%; padding: 10px 40px 10px 12px;
                            border: 1px solid {{ $errors->updatePassword->get('current_password') ? '#fca5a5' : 'rgba(0,0,0,.12)' }};
                            border-radius: 1px;
                            font-size: 13px; font-weight: 600; color: #111;
                            font-family: 'Outfit', sans-serif;
                            background: {{ $errors->updatePassword->get('current_password') ? '#fef2f2' : '#fafafa' }};
                            outline: none; transition: .15s ease;
                        "
                        onfocus="this.style.borderColor='#ef4444'; this.style.background='#fff';"
                        onblur="this.style.borderColor='rgba(0,0,0,.12)'; this.style.background='#fafafa';"
                    >
                    <button type="button" onclick="togglePwd('current_password', this)" style="
                        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
                        background: none; border: none; cursor: pointer; color: #bbb; padding: 4px;
                    ">
                        <i class="fa-regular fa-eye" style="font-size: 13px;"></i>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <p style="font-size: 11px; color: #ef4444; margin-top: 5px; font-weight: 600;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 6px; letter-spacing: .03em; text-transform: uppercase;">
                    Kata Sandi Baru
                </label>
                <div style="position: relative;">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        style="
                            width: 100%; padding: 10px 40px 10px 12px;
                            border: 1px solid {{ $errors->updatePassword->get('password') ? '#fca5a5' : 'rgba(0,0,0,.12)' }};
                            border-radius: 1px;
                            font-size: 13px; font-weight: 600; color: #111;
                            font-family: 'Outfit', sans-serif;
                            background: {{ $errors->updatePassword->get('password') ? '#fef2f2' : '#fafafa' }};
                            outline: none; transition: .15s ease;
                        "
                        onfocus="this.style.borderColor='#ef4444'; this.style.background='#fff';"
                        onblur="this.style.borderColor='rgba(0,0,0,.12)'; this.style.background='#fafafa';"
                    >
                    <button type="button" onclick="togglePwd('password', this)" style="
                        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
                        background: none; border: none; cursor: pointer; color: #bbb; padding: 4px;
                    ">
                        <i class="fa-regular fa-eye" style="font-size: 13px;"></i>
                    </button>
                </div>
                @error('password', 'updatePassword')
                    <p style="font-size: 11px; color: #ef4444; margin-top: 5px; font-weight: 600;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 6px; letter-spacing: .03em; text-transform: uppercase;">
                    Konfirmasi Kata Sandi Baru
                </label>
                <div style="position: relative;">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        style="
                            width: 100%; padding: 10px 40px 10px 12px;
                            border: 1px solid {{ $errors->updatePassword->get('password_confirmation') ? '#fca5a5' : 'rgba(0,0,0,.12)' }};
                            border-radius: 1px;
                            font-size: 13px; font-weight: 600; color: #111;
                            font-family: 'Outfit', sans-serif;
                            background: {{ $errors->updatePassword->get('password_confirmation') ? '#fef2f2' : '#fafafa' }};
                            outline: none; transition: .15s ease;
                        "
                        onfocus="this.style.borderColor='#ef4444'; this.style.background='#fff';"
                        onblur="this.style.borderColor='rgba(0,0,0,.12)'; this.style.background='#fafafa';"
                    >
                    <button type="button" onclick="togglePwd('password_confirmation', this)" style="
                        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
                        background: none; border: none; cursor: pointer; color: #bbb; padding: 4px;
                    ">
                        <i class="fa-regular fa-eye" style="font-size: 13px;"></i>
                    </button>
                </div>
                @error('password_confirmation', 'updatePassword')
                    <p style="font-size: 11px; color: #ef4444; margin-top: 5px; font-weight: 600;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tombol Simpan --}}
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" style="
                    padding: 10px 22px;
                    background: #111; color: #fff;
                    border: none; border-radius: 1px;
                    font-size: 13px; font-weight: 700;
                    font-family: 'Outfit', sans-serif;
                    cursor: pointer;
                    display: flex; align-items: center; gap: 8px;
                    transition: background .15s ease;
                "
                onmouseover="this.style.background='#333';"
                onmouseout="this.style.background='#111';"
                >
                    <i class="fa-solid fa-lock"></i>
                    Perbarui Kata Sandi
                </button>
            </div>

        </form>

    </div>

</div>

@push('scripts')
<script>
    function togglePwd(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon  = btn.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-regular fa-eye-slash';
            btn.style.color = '#ef4444';
        } else {
            input.type = 'password';
            icon.className = 'fa-regular fa-eye';
            btn.style.color = '#bbb';
        }
    }

    // Auto-fire alert dari session flash (untuk layout admin yang pakai ubgAlert)
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('status') === 'profile-updated')
            // Cek apakah pakai showAlert (owner layout) atau tidak
            if (typeof showAlert === 'function') {
                showAlert('success', 'Profil berhasil diperbarui.');
            }
        @endif

        @if(session('status') === 'password-updated')
            if (typeof showAlert === 'function') {
                showAlert('success', 'Kata sandi berhasil diperbarui.');
            }
        @endif
    });
</script>
@endpush

@endsection