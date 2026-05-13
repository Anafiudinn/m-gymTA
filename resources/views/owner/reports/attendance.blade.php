{{-- resources/views/owner/reports/attendance.blade.php --}}

@extends('layouts.owner')

@section('title', 'Laporan Kehadiran')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Laporan Kehadiran
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Monitoring aktivitas check-in member gym
        </p>
    </div>

    {{-- FILTER --}}
    <form method="GET"
        class="bg-white border border-gray-100 rounded-2xl p-5 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">
                    Tanggal Mulai
                </label>

                <input type="date"
                    name="start_date"
                    value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">
                    Tanggal Selesai
                </label>

                <input type="date"
                    name="end_date"
                    value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-black text-white text-sm font-medium py-2.5 rounded-xl transition">
                    Filter Data
                </button>
            </div>

        </div>

    </form>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">TOTAL KEHADIRAN</p>

            <h2 class="text-2xl font-bold text-gray-900">
                {{ $totalAttendance }}
            </h2>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">MEMBER AKTIF</p>

            <h2 class="text-2xl font-bold text-emerald-600">
                {{ $memberAttendance }}
            </h2>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">GUEST / NON MEMBER</p>

            <h2 class="text-2xl font-bold text-orange-500">
                {{ $guestAttendance }}
            </h2>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">
                Data Kehadiran
            </h2>
        </div>

        @if($attendances->count() == 0)

        <div class="py-16 text-center text-gray-400 text-sm">
            Belum ada data kehadiran
        </div>

        @else

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Member
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Admin
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Waktu Checkin
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach($attendances as $attendance)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            @if($attendance->guest_name)

                            <div class="text-sm font-semibold text-gray-900">
                                {{ $attendance->guest_name }}
                            </div>

                            <div class="text-xs text-orange-500 mt-1">
                                Guest / Non Member
                            </div>

                            @else

                            <div class="text-sm font-semibold text-gray-900">
                                {{ $attendance->user->name ?? '-' }}
                            </div>

                            <div class="text-xs text-emerald-600 mt-1">
                                Member Aktif
                            </div>

                            @endif

                        </td>

                        <td class="px-5 py-4 text-sm text-gray-700">
                            {{ $attendance->admin->name ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-500">
                            {{ $attendance->created_at->format('d M Y H:i') }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="px-5 py-4 border-t border-gray-100">
            {{ $attendances->links() }}
        </div>

        @endif

    </div>

</div>

@endsection