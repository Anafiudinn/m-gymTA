@extends('layouts.member')

@section('content')

{{-- =========================================================
   HERO
========================================================= --}}
<div class="hero-wrap">

    <div class="hero-label">
        MEMBER AREA
    </div>

    <h1 class="hero-title">
        HALO,
        <span>{{ explode(' ', auth()->user()->name)[0] }}</span>
    </h1>

    @if(!$isActivated)

        <p class="hero-sub">
            Akun kamu belum teraktivasi.
            <strong>Aktivasi sekarang</strong>
            untuk mulai latihan dan akses seluruh fitur member.
        </p>

        <div style="margin-top:20px;">
            <span class="badge danger">
                <i class="fa-solid fa-circle"></i>
                BELUM AKTIF
            </span>
        </div>

    @elseif($isActivated && !$activePackage)

        <p class="hero-sub">
            Akun kamu sudah aktif.
            Pilih <strong>paket latihan</strong>
            untuk mulai nge-gym hari ini.
        </p>

        <div style="margin-top:20px;">
            <span class="badge success">
                <i class="fa-solid fa-circle"></i>
                MEMBER AKTIF
            </span>
        </div>

    @else

        <p class="hero-sub">
            Selamat berlatih.
            Paket
            <strong>{{ $activePackage->package_name }}</strong>
            kamu sedang aktif dan siap digunakan.
        </p>

        <div style="
            margin-top:20px;
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        ">

            <span class="badge success">
                <i class="fa-solid fa-circle"></i>
                PAKET AKTIF
            </span>

            @if(isset($activePackage->expired_at))
                <span class="badge">
                    BERAKHIR
                    {{ \Carbon\Carbon::parse($activePackage->expired_at)->translatedFormat('d M Y') }}
                </span>
            @endif

        </div>

    @endif

</div>

{{-- =========================================================
   TABS
========================================================= --}}
<div class="member-tabs">

    <a href="{{ route('member.dashboard', ['tab' => 'overview']) }}"
       class="member-tab {{ $activeTab == 'overview' ? 'active' : '' }}">
        OVERVIEW
    </a>

    <a href="{{ route('member.dashboard', ['tab' => 'my-package']) }}"
       class="member-tab {{ $activeTab == 'my-package' ? 'active' : '' }}">
        PAKET SAYA
    </a>

    <a href="{{ route('member.dashboard', ['tab' => 'package']) }}"
       class="member-tab {{ $activeTab == 'package' ? 'active' : '' }}">
        BELI PAKET
    </a>

    @php
        $pendingCount = $pendingOrRejectedTransactions
            ->where('status', 'pending')
            ->count();

        $rejectedCount = $pendingOrRejectedTransactions
            ->where('status', 'rejected')
            ->count();
    @endphp

    <a href="{{ route('member.dashboard', ['tab' => 'history']) }}"
       class="member-tab {{ $activeTab == 'history' ? 'active' : '' }}"
       style="position:relative;">

        RIWAYAT

        {{-- REJECT --}}
        @if($rejectedCount > 0)

            <span style="
                position:absolute;
                top:6px;
                right:2px;

                min-width:18px;
                height:18px;

                padding:0 5px;

                border-radius:999px;

                display:flex;
                align-items:center;
                justify-content:center;

                background:#ef4444;
                color:#fff;

                font-size:10px;
                font-weight:800;

                box-shadow:
                    0 0 12px rgba(239,68,68,.4);
            ">
                {{ $rejectedCount }}
            </span>

        {{-- PENDING --}}
        @elseif($pendingCount > 0)

            <span style="
                position:absolute;
                top:6px;
                right:2px;

                min-width:18px;
                height:18px;

                padding:0 5px;

                border-radius:999px;

                display:flex;
                align-items:center;
                justify-content:center;

                background:#eab308;
                color:#111;

                font-size:10px;
                font-weight:900;

                box-shadow:
                    0 0 12px rgba(234,179,8,.35);
            ">
                {{ $pendingCount }}
            </span>

        @endif

    </a>
    <a href="{{ route('profile.edit') }}"
       class="member-tab {{ $activeTab == 'profile' ? 'active' : '' }}">
        PROFIL
    </a>

</div>
{{-- =========================================================
    INFO MITRA / KOTAK CS (TAMBAHAN BARU)
========================================================= --}}
<div class="cs-info-wrap" style="
    margin: 15px 0 25px 0;
    padding: 15px;
    background: #0d0d11;
    border: 1px solid #222;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    flex-wrap: wrap;
">
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="
            width: 40px; 
            height: 40px; 
            background: rgba(255, 45, 45, 0.1); 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            color: #ff2d2d;
            font-size: 18px;
        ">
            <i class="fa-solid fa-headset"></i>
        </div>
        <div>
            <h4 style="margin: 0; font-size: 14px; color: #f3f3f3; font-weight: 700;">Butuh Bantuan & Informasi?</h4>
            <p style="margin: 3px 0 0 0; font-size: 12px; color: #999;">Hubungi admin kami untuk kendala member / paket.</p>
        </div>
    </div>
    
    <a href="https://wa.me/{{ $adminWhatsapp }}?text=Halo%20Admin,%20saya%20member%20ingin%20bertanya..." 
       target="_blank" 
       style="
            background: #25d366;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
            transition: all 0.2s ease;
       "
       onmouseover="this.style.transform='translateY(-2px)'"
       onmouseout="this.style.transform='translateY(0)'">
        <i class="fa-brands fa-whatsapp" style="font-size: 15px;"></i>
        CHAT ADMIN
    </a>
</div>

{{-- =========================================================
   CONTENT
========================================================= --}}
<div class="tab-content">

    @if($activeTab == 'overview')

        @include('member.tabs.overview')

    @elseif($activeTab == 'my-package')

        @include('member.tabs.paket-saya')

    @elseif($activeTab == 'package')

        @include('member.tabs.package')

    @elseif($activeTab == 'history')

        @include('member.tabs.history')

    @elseif($activeTab == 'profile')

        @include('member.tabs.profile'
            )
    @endif

</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: @json(session('success')),
            background: '#0d0d11',
            color: '#f3f3f3',
            confirmButtonColor: '#ff2d2d',
            customClass: { popup: 'swal2-popup', confirmButton: 'swal2-confirm' }
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'WADUH!',
            text: @json(session('error')),
            background: '#0d0d11',
            color: '#f3f3f3',
            confirmButtonColor: '#ff2d2d',
            customClass: { popup: 'swal2-popup', confirmButton: 'swal2-confirm' }
        });
        @endif

        @if($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'ADA KESALAHAN',
            text: @json($errors->first()),
            background: '#0d0d11',
            color: '#f3f3f3',
            confirmButtonColor: '#ff2d2d',
            customClass: { popup: 'swal2-popup', confirmButton: 'swal2-confirm' }
        });
        @endif

    });
</script>
@endpush
@endsection