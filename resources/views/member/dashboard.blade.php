@extends('layouts.member')

@section('content')

<div class="hero-section">
    <div class="hero-label">SELAMAT DATANG</div>
    <h1 class="hero-title">HALO, <span>{{ explode(' ', auth()->user()->name)[0] }}</span></h1>

    @if(!$isActivated)
        <p class="hero-sub">Akun kamu belum teraktivasi. <strong>Aktivasi sekarang</strong> untuk mulai latihan.</p>
    @elseif($isActivated && !$activePackage)
        <p class="hero-sub">Akun kamu sudah aktif! Pilih <strong>paket latihan</strong> untuk mulai nge-gym hari ini.</p>
    @else
        <p class="hero-sub">Selamat berlatih! Paket <strong>{{ $activePackage->package_name }}</strong> kamu sedang aktif.</p>
    @endif
</div>



<div class="member-tabs">
    <a href="{{ route('member.dashboard', ['tab' => 'overview']) }}"
       class="member-tab {{ $activeTab == 'overview' ? 'active' : '' }}">
        OVERVIEW
    </a>
    <a href="{{ route('member.dashboard', ['tab' => 'package']) }}"
       class="member-tab {{ $activeTab == 'package' ? 'active' : '' }}">
        BELI PAKET & AKTIVASI
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

    RIWAYAT SAYA

    {{-- PRIORITAS REJECT --}}
    @if($rejectedCount > 0)

        <span style="
            position:absolute;
            top:-6px;
            right:-6px;
            background:#ef4444;
            color:#fff;
            min-width:22px;
            height:22px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:11px;
            font-weight:800;
            box-shadow:0 0 0 3px rgba(0,0,0,.3);
        ">
            {{ $rejectedCount }}
        </span>

    {{-- JIKA TIDAK ADA REJECT TAPI ADA PENDING --}}
    @elseif($pendingCount > 0)

        <span style="
            position:absolute;
            top:-6px;
            right:-6px;
            background:#eab308;
            color:#111;
            min-width:22px;
            height:22px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:11px;
            font-weight:900;
            box-shadow:0 0 0 3px rgba(0,0,0,.3);
        ">
            {{ $pendingCount }}
        </span>

    @endif

</a>
</div>

<div class="tab-content">
    @if($activeTab == 'overview')
        @include('member.tabs.overview')
    @elseif($activeTab == 'package')
        @include('member.tabs.package')
    @elseif($activeTab == 'history')
        @include('member.tabs.history')
    @endif
</div>
{{-- Logika Notifikasi --}}
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: "{{ session('success') }}",
            background: '#111',
            color: '#fff',
            confirmButtonColor: '#ef4444',
            borderRadius: '15px'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'WADUH!',
            text: "{{ session('error') }}",
            background: '#111',
            color: '#fff',
            confirmButtonColor: '#ef4444'
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'ADA KESALAHAN',
            text: "{{ $errors->first() }}",
            background: '#111',
            color: '#fff',
            confirmButtonColor: '#ef4444'
        });
    </script>
@endif
@endsection