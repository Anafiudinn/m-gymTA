@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800">
                Halo, {{ explode(' ', auth()->user()->name)[0] }} 👋
            </h1>

            <p class="text-slate-500 mt-1">
                Ringkasan aktivitas gym hari ini.
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded px-5 py-4 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold">HARI INI</p>

            <h3 class="text-lg font-bold text-slate-700">
                {{ now()->translatedFormat('l, d F Y') }}
            </h3>
        </div>
    </div>

    {{-- TOP STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- CHECKIN --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa fa-users text-xl"></i>
                </div>

                <span class="text-xs font-bold text-slate-400">
                    CHECK-IN
                </span>
            </div>

            <div class="mt-5">
                <h2 class="text-4xl font-black text-slate-800">
                    {{ $todayAttendance }}
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Orang masuk hari ini
                </p>
            </div>
        </div>

        {{-- OMZET --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded bg-green-100 text-green-600 flex items-center justify-center">
                    <i class="fa fa-wallet text-xl"></i>
                </div>

                <span class="text-xs font-bold text-slate-400">
                    OMZET
                </span>
            </div>

            <div class="mt-5">
                <h2 class="text-3xl font-black text-slate-800">
                    Rp {{ number_format($todayOmzet, 0, ',', '.') }}
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Pemasukan hari ini
                </p>
            </div>
        </div>

        {{-- PENDING --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded bg-yellow-100 text-yellow-600 flex items-center justify-center">
                    <i class="fa fa-clock text-xl"></i>
                </div>

                <span class="text-xs font-bold text-slate-400">
                    PENDING
                </span>
            </div>

            <div class="mt-5">
                <h2 class="text-4xl font-black text-slate-800">
                    {{ $pendingVerifications }}
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Menunggu verifikasi
                </p>
            </div>
        </div>

        {{-- PT --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded bg-purple-100 text-purple-600 flex items-center justify-center">
                    <i class="fa fa-dumbbell text-xl"></i>
                </div>

                <span class="text-xs font-bold text-slate-400">
                    PT AKTIF
                </span>
            </div>

            <div class="mt-5">
                <h2 class="text-4xl font-black text-slate-800">
                    {{ $activePT }}
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Membership PT aktif
                </p>
            </div>
        </div>
    </div>

    {{-- CHART + SIDE --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- CHART --}}
        <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">
                        Grafik Pemasukan
                    </h3>

                    <p class="text-sm text-slate-400">
                        7 hari terakhir
                    </p>
                </div>
            </div>

            <canvas id="incomeChart" height="120"></canvas>
        </div>

        {{-- SIDE STATS --}}
        <div class="space-y-5">

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-bold text-slate-700 mb-5">
                    Statistik Member
                </h3>

                <div class="space-y-4">

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">
                            Member Aktif
                        </span>

                        <span class="font-black text-slate-800">
                            {{ $activeMembers }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">
                            Paket Aktif
                        </span>

                        <span class="font-black text-slate-800">
                            {{ $activeMemberships }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">
                            Transaksi Hari Ini
                        </span>

                        <span class="font-black text-slate-800">
                            {{ $todayTransactions }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- LOW STOCK --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

                <h3 class="font-bold text-slate-700 mb-5">
                    Stok Menipis
                </h3>

                <div class="space-y-4">

                    @forelse($lowStockProducts as $product)

                        <div class="flex items-center justify-between">

                            <div>
                                <h4 class="font-semibold text-slate-700">
                                    {{ $product->nama_produk }}
                                </h4>

                                <p class="text-xs text-slate-400">
                                    Hampir habis
                                </p>
                            </div>

                            <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full">
                                {{ $product->stok }} pcs
                            </span>
                        </div>

                    @empty

                        <p class="text-sm text-slate-400">
                            Semua stok aman ✅
                        </p>

                    @endforelse

                </div>
            </div>

        </div>
    </div>

    {{-- TABLES --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- TRANSAKSI --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-slate-800">
                    Transaksi Terbaru
                </h3>
            </div>

            <div class="space-y-4">

                @foreach($recentTransactions as $trx)

                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">

                        <div>
                            <h4 class="font-semibold text-slate-700">
                                {{ $trx->user->name ?? $trx->guest_name }}
                            </h4>

                            <p class="text-xs text-slate-400 uppercase">
                                {{ $trx->category }}
                            </p>
                        </div>

                        <div class="text-right">
                            <h4 class="font-black text-slate-800">
                                Rp {{ number_format($trx->amount,0,',','.') }}
                            </h4>

                            <span class="
                                text-xs px-2 py-1 rounded-full
                                {{ $trx->status == 'success'
                                    ? 'bg-green-100 text-green-600'
                                    : 'bg-yellow-100 text-yellow-600'
                                }}
                            ">
                                {{ $trx->status }}
                            </span>
                        </div>

                    </div>

                @endforeach

            </div>
        </div>

        {{-- ATTENDANCE --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-slate-800">
                    Check-in Terbaru
                </h3>
            </div>

            <div class="space-y-4">

                @foreach($recentAttendances as $attendance)

                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">

                        <div>
                            <h4 class="font-semibold text-slate-700">
                                {{ $attendance->user->name ?? $attendance->guest_name }}
                            </h4>

                            <p class="text-xs text-slate-400">
                                {{ $attendance->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <span class="bg-blue-100 text-blue-600 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $attendance->type }}
                        </span>

                    </div>

                @endforeach

            </div>
        </div>
    </div>

</div>

<script>

const ctx = document.getElementById('incomeChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Omzet',
            data: @json($chartData),
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

</script>

@endsection