@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header & Filter --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Kehadiran</h1>
            <p class="text-sm text-slate-500 mt-1">Monitoring check-in member dan tamu gym.</p>
        </div>
        {{-- Filter Form --}}
        <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / whatsapp..." class="w-full sm:w-[240px] bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
            </div>
            <select name="type" class="bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
                <option value="">Semua Tipe</option>
                <option value="member_package" {{ request('type') == 'member_package' ? 'selected' : '' }}>Member</option>
                <option value="paid_visit" {{ request('type') == 'paid_visit' ? 'selected' : '' }}>Guest Visit</option>
            </select>
            <button type="submit" class="bg-slate-900 hover:bg-blue-600 text-white px-5 py-3 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all shadow-sm">Filter</button>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Total Kehadiran</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ $attendances->total() }}</h3>
        </div>
        {{-- Member --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Member</p>
            <h3 class="text-2xl font-extrabold text-emerald-600 mt-2">{{ $attendances->where('type', 'member_package')->count() }}</h3>
        </div>
        {{-- Guest --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Guest Visit</p>
            <h3 class="text-2xl font-extrabold text-blue-600 mt-2">{{ $attendances->where('type', 'paid_visit')->count() }}</h3>
        </div>
        {{-- Today --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Hari Ini</p>
            <h3 class="text-2xl font-extrabold text-amber-500 mt-2">{{ $attendances->where('created_at', '>=', now()->startOfDay())->count() }}</h3>
        </div>
    </div>

    {{-- Attendance Table --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        {{-- Table Header --}}
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800">Data Kehadiran</h3>
                <p class="text-xs text-slate-400 mt-1">Riwayat check-in gym member dan tamu.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Nama</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Member Kode</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">WhatsApp</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Tipe</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Waktu Check-in</th>
                        <th class="px-6 py-4 text-right text-[11px] uppercase tracking-widest font-bold text-slate-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($attendances as $attendance)
                    <tr class="hover:bg-slate-50/70 transition-all">
                        {{-- Name --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-slate-100 flex items-center justify-center"><i class="fas fa-user text-slate-400 text-sm"></i></div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $attendance->guest_name ?? $attendance->user->name ?? '-' }}</h4>
                                    <p class="text-xs text-slate-400 mt-1">ID: #{{ $attendance->id }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- Member Code --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-semibold text-slate-700">{{ $attendance->user->member_code ?? '-' }}</h4>
                            </div>
                        </td>
                        {{-- WhatsApp --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-semibold text-slate-700"></h4>{{ $attendance->guest_whatsapp ?? $attendance->user->whatsapp ?? '-' }}</h4>
                            </div>
                        </td>
                        {{-- Type --}}
                        <td class="px-6 py-5">
                            @if($attendance->type == 'member_package')
                            <span class="px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">Member</span>
                            @else
                            <span class="px-3 py-1.5 rounded-full bg-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider">Guest Visit</span>
                            @endif
                        </td>
                        {{-- Time --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-semibold text-slate-700">{{ $attendance->created_at->format('d M Y') }}</h4>
                                <p class="text-xs text-slate-400 mt-1">{{ $attendance->created_at->format('H:i') }} WIB</p>
                            </div>
                        </td>
                        {{-- Status --}}
                        <td class="px-6 py-5 text-right">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>Checked-in
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-5"><i class="fas fa-calendar-check text-3xl text-slate-300"></i></div>
                                <h3 class="font-bold text-slate-700">Belum Ada Kehadiran</h3>
                                <p class="text-sm text-slate-400 mt-1">Data check-in gym akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="px-6 py-5 border-t border-slate-100">{{ $attendances->withQueryString()->links() }}</div>
    </div>
</div>
@endsection