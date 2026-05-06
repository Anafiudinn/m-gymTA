@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header & Search --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Personal Trainer Session</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola penggunaan sesi personal trainer member gym.</p>
        </div>
        {{-- Search Form --}}
        <form method="GET" class="w-full lg:w-auto">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode member / whatsapp..." class="w-full lg:w-[320px] bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none shadow-sm">
            </div>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">PT Aktif</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ $totalActive }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Hampir Habis</p>
            <h3 class="text-2xl font-extrabold text-orange-500 mt-2">{{ $lowSession }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Sesi Habis</p>
            <h3 class="text-2xl font-extrabold text-red-500 mt-2">{{ $emptySession }}</h3>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Ditampilkan</p>
            <h3 class="text-2xl font-extrabold text-blue-500 mt-2">{{ $ptMemberships->count() }}</h3>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        {{-- Table Header --}}
        <div class="px-6 py-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Data PT Member</h3>
            <p class="text-xs text-slate-400 mt-1">List member dengan paket personal trainer aktif.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Member</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">WhatsApp</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Paket PT</th>
                        <th class="px-6 py-4 text-center text-[11px] uppercase tracking-widest font-bold text-slate-500">Sisa Sesi</th>
                        <th class="px-6 py-4 text-center text-[11px] uppercase tracking-widest font-bold text-slate-500">Status</th>
                        <th class="px-6 py-4 text-right text-[11px] uppercase tracking-widest font-bold text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($ptMemberships as $pt)
                    <tr class="hover:bg-slate-50/70 transition-all">
                        {{-- Member --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center flex-shrink-0"><i class="fas fa-dumbbell text-orange-500 text-sm"></i></div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $pt->user->name }}</h4>
                                    <p class="text-xs text-slate-400 mt-1">{{ $pt->user->member_code }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- WhatsApp --}}
                        <td class="px-6 py-5">
                            <h4 class="font-semibold text-slate-700">{{ $pt->user->whatsapp }}</h4>
                        </td>
                        {{-- Package --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-bold text-slate-700">{{ optional($pt->package)->nama_paket }}</h4>
                            </div>
                        </td>
                        {{-- Session --}}
                        <td class="px-6 py-5 text-center">
                            <span class="text-2xl font-black {{ $pt->remaining_sessions <= 3 ? 'text-red-500' : 'text-orange-500' }}">{{ $pt->remaining_sessions }}</span>
                        </td>
                        {{-- Status --}}
                        <td class="px-6 py-5 text-center">
                            @if($pt->remaining_sessions <= 0)
                            <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider">Habis</span>
                            @elseif($pt->remaining_sessions <= 3)
                            <span class="px-3 py-1.5 rounded-full bg-orange-100 text-orange-600 text-[10px] font-bold uppercase tracking-wider">Low</span>
                            @else
                            <span class="px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">Active</span>
                            @endif
                        </td>
                        {{-- Action --}}
                        <td class="px-6 py-5 text-right">
                            <form id="cut-form-{{ $pt->id }}" action="{{ route('admin.pt.cut', $pt->id) }}" method="POST">@csrf
                            <button type="button" data-confirm data-confirm-title="Gunakan 1 Sesi PT?" data-confirm-desc="Sistem akan mengurangi 1 sesi PT member ini." data-confirm-type="warning" data-confirm-label="Ya, Gunakan" data-confirm-form="cut-form-{{ $pt->id }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all shadow-sm">Gunakan Sesi</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mb-6"><i class="fas fa-dumbbell text-4xl text-slate-300"></i></div>
                                <h3 class="font-bold text-slate-700 text-lg">Tidak Ada Member PT</h3>
                                <p class="text-sm text-slate-400 mt-2">Member dengan paket PT aktif akan tampil di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="px-6 py-5 border-t border-slate-100">{{ $ptMemberships->withQueryString()->links() }}</div>
    </div>
</div>
@endsection