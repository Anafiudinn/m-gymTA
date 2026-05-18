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

    @endif

</div>

{{-- =========================================================
   ALERT
========================================================= --}}

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'BERHASIL!',
        text: "{{ session('success') }}",

        background: '#0f0f13',
        color: '#fff',

        confirmButtonColor: '#ff2d2d',

        borderRadius: 0,

        customClass:{
            popup:'animated fadeInUp'
        }
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'WADUH!',
        text: "{{ session('error') }}",

        background: '#0f0f13',
        color: '#fff',

        confirmButtonColor: '#ff2d2d',

        borderRadius: 0
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'warning',
        title: 'ADA KESALAHAN',
        text: "{{ $errors->first() }}",

        background: '#0f0f13',
        color: '#fff',

        confirmButtonColor: '#ff2d2d',

        borderRadius: 0
    });
</script>
@endif

@endsection