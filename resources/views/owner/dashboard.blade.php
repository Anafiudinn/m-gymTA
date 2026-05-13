@extends('layouts.owner')

@section('title', 'Dashboard Owner')

@section('content')

<div style="padding:24px;">

    {{-- =====================================================
        PAGE HEADER
    ====================================================== --}}
    <div style="margin-bottom:28px;">
        <h1 style="font-size:30px;font-weight:800;color:#111827;margin-bottom:6px;">
            Dashboard Owner
        </h1>

        <p style="color:#6b7280;font-size:14px;">
            Ringkasan performa gym, transaksi, member aktif, dan aktivitas harian.
        </p>
    </div>

    {{-- =====================================================
        TOP STATS
    ====================================================== --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
        gap:18px;
        margin-bottom:28px;
    ">

        {{-- Omzet Hari Ini --}}
        <div style="
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:22px;
        ">
            <div style="
                width:48px;
                height:48px;
                border-radius:14px;
                background:#dbeafe;
                color:#2563eb;
                display:flex;
                align-items:center;
                justify-content:center;
                margin-bottom:16px;
                font-size:20px;
            ">
                <i class="fa-solid fa-wallet"></i>
            </div>

            <div style="font-size:13px;color:#6b7280;margin-bottom:6px;">
                OMZET HARI INI
            </div>

            <div style="font-size:28px;font-weight:800;color:#111827;">
                Rp {{ number_format($incomeToday, 0, ',', '.') }}
            </div>
        </div>

        {{-- Member Aktif --}}
        <div style="
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:22px;
        ">
            <div style="
                width:48px;
                height:48px;
                border-radius:14px;
                background:#dcfce7;
                color:#16a34a;
                display:flex;
                align-items:center;
                justify-content:center;
                margin-bottom:16px;
                font-size:20px;
            ">
                <i class="fa-solid fa-users"></i>
            </div>

            <div style="font-size:13px;color:#6b7280;margin-bottom:6px;">
                MEMBER AKTIF
            </div>

            <div style="font-size:28px;font-weight:800;color:#111827;">
                {{ $activeMembers }}
            </div>
        </div>

        {{-- Total Admin --}}
        <div style="
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:22px;
        ">
            <div style="
                width:48px;
                height:48px;
                border-radius:14px;
                background:#ede9fe;
                color:#7c3aed;
                display:flex;
                align-items:center;
                justify-content:center;
                margin-bottom:16px;
                font-size:20px;
            ">
                <i class="fa-solid fa-user-shield"></i>
            </div>

            <div style="font-size:13px;color:#6b7280;margin-bottom:6px;">
                TOTAL ADMIN
            </div>

            <div style="font-size:28px;font-weight:800;color:#111827;">
                {{ $totalAdmins }}
            </div>
        </div>

        {{-- Pending Verification --}}
        <div style="
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:22px;
        ">
            <div style="
                width:48px;
                height:48px;
                border-radius:14px;
                background:#fef3c7;
                color:#d97706;
                display:flex;
                align-items:center;
                justify-content:center;
                margin-bottom:16px;
                font-size:20px;
            ">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div style="font-size:13px;color:#6b7280;margin-bottom:6px;">
                VERIFIKASI PENDING
            </div>

            <div style="font-size:28px;font-weight:800;color:#111827;">
                {{ $pendingVerifications }}
            </div>
        </div>

    </div>

    {{-- =====================================================
        CHART / SUMMARY
    ====================================================== --}}
    <div style="
        display:grid;
        grid-template-columns:2fr 1fr;
        gap:20px;
        margin-bottom:28px;
    ">

        {{-- Omzet Per Kategori --}}
        <div style="
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:18px;
            overflow:hidden;
        ">

            <div style="
                padding:20px 24px;
                border-bottom:1px solid #f3f4f6;
                font-weight:700;
                color:#111827;
                font-size:16px;
            ">
                Omzet Berdasarkan Kategori
            </div>

            <div style="padding:10px 0;">

                @foreach($statsCategory as $stat)

                    @php
                        $color = match($stat->category) {
                            'activation' => '#2563eb',
                            'monthly' => '#7c3aed',
                            'pt' => '#ea580c',
                            'retail' => '#16a34a',
                            default => '#6b7280'
                        };
                    @endphp

                    <div style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        padding:16px 24px;
                        border-bottom:1px solid #f9fafb;
                    ">

                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="
                                width:12px;
                                height:12px;
                                border-radius:999px;
                                background:{{ $color }};
                            "></div>

                            <div style="
                                font-size:14px;
                                font-weight:600;
                                color:#111827;
                                text-transform:capitalize;
                            ">
                                {{ $stat->category }}
                            </div>
                        </div>

                        <div style="
                            font-size:14px;
                            font-weight:700;
                            color:#111827;
                        ">
                            Rp {{ number_format($stat->total, 0, ',', '.') }}
                        </div>

                    </div>

                @endforeach

            </div>
        </div>

        {{-- Quick Access --}}
        <div style="
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:18px;
            overflow:hidden;
        ">

            <div style="
                padding:20px 24px;
                border-bottom:1px solid #f3f4f6;
                font-weight:700;
                color:#111827;
                font-size:16px;
            ">
                Quick Access
            </div>

            <div style="padding:20px;display:flex;flex-direction:column;gap:14px;">

                <a href="{{ route('owner.admins.index') }}"
                   style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    padding:16px;
                    border-radius:14px;
                    background:#f9fafb;
                    text-decoration:none;
                    color:#111827;
                    border:1px solid #f3f4f6;
                   ">

                    <div style="display:flex;align-items:center;gap:12px;">
                        <i class="fa-solid fa-user-shield"></i>
                        <span style="font-weight:600;">Kelola Admin</span>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('owner.settings.index') }}"
                   style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    padding:16px;
                    border-radius:14px;
                    background:#f9fafb;
                    text-decoration:none;
                    color:#111827;
                    border:1px solid #f3f4f6;
                   ">

                    <div style="display:flex;align-items:center;gap:12px;">
                        <i class="fa-solid fa-gear"></i>
                        <span style="font-weight:600;">Pengaturan Gym</span>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('owner.pt-packages.index') }}"
                   style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    padding:16px;
                    border-radius:14px;
                    background:#f9fafb;
                    text-decoration:none;
                    color:#111827;
                    border:1px solid #f3f4f6;
                   ">

                    <div style="display:flex;align-items:center;gap:12px;">
                        <i class="fa-solid fa-dumbbell"></i>
                        <span style="font-weight:600;">Paket Personal Trainer</span>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('owner.reports.transactions') }}"
                   style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    padding:16px;
                    border-radius:14px;
                    background:#f9fafb;
                    text-decoration:none;
                    color:#111827;
                    border:1px solid #f3f4f6;
                   ">

                    <div style="display:flex;align-items:center;gap:12px;">
                        <i class="fa-solid fa-chart-column"></i>
                        <span style="font-weight:600;">Laporan Transaksi</span>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

            </div>
        </div>

    </div>

</div>
@endsection