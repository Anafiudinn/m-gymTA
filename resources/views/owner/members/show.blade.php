{{-- resources/views/owner/members/show.blade.php --}}

@extends('layouts.owner')

@section('title', 'Detail Member')

@section('content')

<div class="p-6">

    @php
        $activePackage = $member->memberships
            ->where('status', 'active')
            ->first();
    @endphp

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div class="bg-white border border-gray-100 rounded-2xl p-6 mb-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            {{-- LEFT --}}
            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $member->name }}
                </h1>

                <div class="mt-3 space-y-1">

                    <p class="text-sm text-gray-500">
                        WhatsApp :
                        <span class="text-gray-700 font-medium">
                            {{ $member->whatsapp }}
                        </span>
                    </p>

                    <p class="text-sm text-gray-500">
                        Kode Member :
                        <span class="text-gray-700 font-medium">
                            {{ $member->member_code ?? '-' }}
                        </span>
                    </p>

                    <p class="text-sm text-gray-500">
                        Bergabung :
                        <span class="text-gray-700 font-medium">
                            {{ $member->created_at->format('d M Y') }}
                        </span>
                    </p>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="flex flex-wrap gap-3">

                {{-- STATUS AKTIVASI --}}
                @if($member->is_active_member)

                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700">
                        Sudah Aktivasi
                    </span>

                @else

                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                        Belum Aktivasi
                    </span>

                @endif

                {{-- STATUS PAKET --}}
                @if($activePackage)

                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">
                        Paket Bulanan Aktif
                    </span>

                @else

                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-700">
                        Tidak Ada Paket Aktif
                    </span>

                @endif

            </div>

        </div>

    </div>

    {{-- =====================================================
        SUMMARY
    ====================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        {{-- TOTAL CHECK-IN --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5">

            <p class="text-xs text-gray-500 mb-2">
                TOTAL CHECK-IN
            </p>

            <h2 class="text-3xl font-bold text-gray-900">
                {{ $totalAttendance }}
            </h2>

        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5">

            <p class="text-xs text-gray-500 mb-2">
                TOTAL TRANSAKSI BERHASIL
            </p>

            <h2 class="text-3xl font-bold text-blue-600">
                Rp {{ number_format($totalTransaction, 0, ',', '.') }}
            </h2>

        </div>

        {{-- STATUS MEMBERSHIP --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5">

            <p class="text-xs text-gray-500 mb-2">
                STATUS PAKET BULANAN
            </p>

            @if($membership)

                <div class="text-sm font-semibold text-gray-900">
                    {{ $membership->package_name }}
                </div>

                <div class="text-xs text-gray-500 mt-1">
                    {{ \Carbon\Carbon::parse($membership->start_date)->format('d M Y') }}
                    -
                    {{ \Carbon\Carbon::parse($membership->end_date)->format('d M Y') }}
                </div>

                <div class="mt-3">

                    @if($membership->status == 'active')

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                            Paket Aktif
                        </span>

                    @elseif($membership->status == 'expired')

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                            Paket Expired
                        </span>

                    @else

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                            Nonaktif
                        </span>

                    @endif

                </div>

            @else

                <div class="text-sm text-gray-400">
                    Belum memiliki paket bulanan
                </div>

            @endif

        </div>

    </div>

    {{-- =====================================================
        RIWAYAT KEHADIRAN
    ====================================================== --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden mb-6">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">
                Riwayat Kehadiran
            </h2>
        </div>

        @if($attendances->count() == 0)

            <div class="py-14 text-center text-gray-400 text-sm">
                Belum ada riwayat kehadiran
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Jenis Check-in
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Status
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Waktu
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($attendances as $attendance)

                            <tr>

                                {{-- TYPE --}}
                                <td class="px-5 py-4 text-sm text-gray-700">

                                    @if($attendance->type == 'member_package')

                                        Member Paket Bulanan

                                    @elseif($attendance->type == 'paid_visit')

                                        Visit Harian

                                    @else

                                        {{ $attendance->type }}

                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td class="px-5 py-4">

                                    @if($attendance->type == 'member_package')

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Gratis Check-in
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                            Berbayar
                                        </span>

                                    @endif

                                </td>

                                {{-- DATE --}}
                                <td class="px-5 py-4 text-sm text-gray-500">
                                    {{ $attendance->created_at->format('d M Y H:i') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

    {{-- =====================================================
        RIWAYAT TRANSAKSI
    ====================================================== --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">
                Riwayat Transaksi
            </h2>
        </div>

        @if($transactions->count() == 0)

            <div class="py-14 text-center text-gray-400 text-sm">
                Belum ada transaksi
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Invoice
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Jenis Transaksi
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Pembayaran
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Total
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Tanggal
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($transactions as $trx)

                            <tr>

                                {{-- INVOICE --}}
                                <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                    {{ $trx->invoice_code }}
                                </td>

                                {{-- CATEGORY --}}
                                <td class="px-5 py-4 text-sm text-gray-700 capitalize">

                                    @switch($trx->category)

                                        @case('activation')
                                            Aktivasi Member
                                            @break

                                        @case('monthly')
                                            Paket Bulanan
                                            @break

                                        @case('pt')
                                            Personal Trainer
                                            @break

                                        @case('visit')
                                            Visit Harian
                                            @break

                                        @case('retail')
                                            Produk / Retail
                                            @break

                                        @default
                                            {{ $trx->category }}

                                    @endswitch

                                </td>

                                {{-- PAYMENT --}}
                                <td class="px-5 py-4 text-sm text-gray-700 capitalize">
                                    {{ $trx->payment_method }}
                                </td>

                                {{-- AMOUNT --}}
                                <td class="px-5 py-4 text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>

                                {{-- DATE --}}
                                <td class="px-5 py-4 text-sm text-gray-500">
                                    {{ $trx->created_at->format('d M Y H:i') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@endsection