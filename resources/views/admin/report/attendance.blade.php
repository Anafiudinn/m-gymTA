@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- HEADER --}}
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Kehadiran & PT</h1>
            <p class="text-sm text-slate-500 mt-1">Monitoring check-in gym dan histori aktivitas PT member.</p>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">
            <input type="hidden" name="tab" value="{{ $tab }}">
            
            {{-- SEARCH --}}
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / whatsapp..."
                    class="w-full sm:w-[240px] bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
            </div>

            {{-- FILTER ATTENDANCE --}}
            @if($tab == 'attendance')
            <select name="type" class="bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
                <option value="">Semua Tipe</option>
                <option value="member_package" {{ request('type') == 'member_package' ? 'selected' : '' }}>Member</option>
                <option value="paid_visit" {{ request('type') == 'paid_visit' ? 'selected' : '' }}>Guest Visit</option>
            </select>
            @endif

            {{-- FILTER PT --}}
            @if($tab == 'pt')
            <select name="status" class="bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @endif

            <button type="submit" class="bg-slate-900 hover:bg-blue-600 text-white px-5 py-3 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                Filter
            </button>
        </form>
    </div>

    {{-- TABS --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.report.attendance', ['tab' => 'attendance']) }}"
           class="px-5 py-3 rounded-2xl text-sm font-bold transition-all {{ $tab == 'attendance' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Kehadiran Gym
        </a>
        <a href="{{ route('admin.report.attendance', ['tab' => 'pt']) }}"
           class="px-5 py-3 rounded-2xl text-sm font-bold transition-all {{ $tab == 'pt' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            PT History
        </a>
    </div>

    {{-- ===================================================== --}}
    {{-- ATTENDANCE TAB --}}
    {{-- ===================================================== --}}
    @if($tab == 'attendance')
    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Total Kehadiran</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ $totalAttendance }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Member</p>
            <h3 class="text-2xl font-extrabold text-emerald-600 mt-2">{{ $memberAttendance }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Guest Visit</p>
            <h3 class="text-2xl font-extrabold text-blue-600 mt-2">{{ $guestAttendance }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Hari Ini</p>
            <h3 class="text-2xl font-extrabold text-amber-500 mt-2">{{ $todayAttendance }}</h3>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Data Kehadiran</h3>
            <p class="text-xs text-slate-400 mt-1">Riwayat check-in member dan guest gym.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Nama</th>
                                               <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Member Code</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">WhatsApp</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Tipe</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Check-in</th>
                        <th class="px-6 py-4 text-right text-[11px] uppercase tracking-widest font-bold text-slate-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($attendances as $attendance)
                    <tr class="hover:bg-slate-50/70 transition-all">
                        {{-- NAME --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-user text-slate-400 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $attendance->guest_name ?? $attendance->user->name ?? '-' }}</h4>
                                    <p class="text-xs text-slate-400 mt-1">ID: #{{ $attendance->id }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- MEMBER CODE --}}
                        <td class="px-6 py-5">
                            <h4 class="font-semibold text-slate-700">{{ $attendance->user->member_code ?? '-' }}</h4>
                        </td>
                        {{-- WHATSAPP --}}
                        <td class="px-6 py-5">
                            <h4 class="font-semibold text-slate-700">{{ $attendance->guest_whatsapp ?? $attendance->user->whatsapp ?? '-' }}</h4>
                        </td>
                        {{-- TYPE --}}
                        <td class="px-6 py-5">
                            @if($attendance->type == 'member_package')
                                <span class="px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">Member</span>
                            @else
                                <span class="px-3 py-1.5 rounded-full bg-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider">Guest Visit</span>
                            @endif
                        </td>
                        {{-- TIME --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-semibold text-slate-700">{{ $attendance->created_at->format('d M Y') }}</h4>
                                <p class="text-xs text-slate-400 mt-1">{{ $attendance->created_at->format('H:i') }} WIB</p>
                            </div>
                        </td>
                        {{-- STATUS --}}
                        <td class="px-6 py-5 text-right">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>Checked-in
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-5">
                                    <i class="fas fa-calendar-check text-3xl text-slate-300"></i>
                                </div>
                                <h3 class="font-bold text-slate-700">Belum Ada Kehadiran</h3>
                                <p class="text-sm text-slate-400 mt-1">Data check-in gym akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-5 border-t border-slate-100">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>
    @endif

    {{-- ===================================================== --}}
    {{-- PT REPORT TAB --}}
    {{-- ===================================================== --}}
    @if($tab == 'pt')
    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Total PT</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ $totalPt }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Active</p>
            <h3 class="text-2xl font-extrabold text-emerald-600 mt-2">{{ $activePt }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Completed</p>
            <h3 class="text-2xl font-extrabold text-blue-600 mt-2">{{ $finishedPt }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Low Session</p>
            <h3 class="text-2xl font-extrabold text-amber-500 mt-2">{{ $lowSessionPt }}</h3>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">PT Activity Report</h3>
            <p class="text-xs text-slate-400 mt-1">Monitoring aktivitas penggunaan sesi PT member.</p>
        </div>

     <div class="overflow-x-auto">
    <table class="w-full min-w-[850px]">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Member</th>
                <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Coach</th>
                <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Aktivitas Potong Sesi</th>
                <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Waktu</th>
                <th class="px-6 py-4 text-right text-[11px] uppercase tracking-widest font-bold text-slate-500">Sisa Sesi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($ptReports as $log)
            <tr class="hover:bg-slate-50/70 transition-all">
                {{-- MEMBER --}}
                <td class="px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-indigo-50 flex items-center justify-center">
                            <i class="fas fa-user text-indigo-400 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $log->user->name }}</h4>
                            <p class="text-xs text-slate-400 mt-1">{{ $log->user->member_code }}</p>
                        </div>
                    </div>
                </td>

                {{-- COACH --}}
                <td class="px-6 py-5">
                    <div>
                        <h4 class="font-semibold text-slate-700">{{ $log->coach->name ?? 'No Coach' }}</h4>
                        <p class="text-xs text-slate-400 mt-1">Personal Trainer</p>
                    </div>
                </td>

                {{-- ACTIVITY --}}
                <td class="px-6 py-5">
                    <div class="flex flex-col gap-1">
                        <span class="inline-flex items-center w-fit px-2.5 py-1 rounded-md bg-orange-50 text-orange-600 text-[10px] font-bold uppercase tracking-wider border border-orange-100">
                            <i class="fas fa-cut mr-1.5"></i> Potong {{ $log->sessions_used }} Sesi
                        </span>
                        <p class="text-[11px] text-slate-500 italic">"{{ $log->notes ?? 'Latihan rutin' }}"</p>
                    </div>
                </td>

                {{-- DATE --}}
                <td class="px-6 py-5">
                    <div>
                        <h4 class="font-semibold text-slate-700">{{ $log->created_at->format('d M Y') }}</h4>
                        <p class="text-xs text-slate-400 mt-1">{{ $log->created_at->format('H:i') }} WIB</p>
                    </div>
                </td>

                {{-- REMAINING STATUS --}}
                <td class="px-6 py-5 text-right">
                    <div class="inline-block text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Sisa Paket</p>
                        <span class="text-sm font-bold text-slate-700">
                            {{ $log->current_remaining_sessions }} <span class="text-slate-400 font-normal">Sesi</span>
                        </span>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-24 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-5">
                            <i class="fas fa-history text-3xl text-slate-300"></i>
                        </div>
                        <h3 class="font-bold text-slate-700">Belum Ada Riwayat Potong Sesi</h3>
                        <p class="text-sm text-slate-400 mt-1">Setiap kali sesi dipotong, datanya akan muncul di sini.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
        {{-- PAGINATION --}}
        <div class="px-6 py-5 border-t border-slate-100">
            {{ $ptReports->withQueryString()->links() }}
        </div>
    </div>
    @endif
</div>
@endsection