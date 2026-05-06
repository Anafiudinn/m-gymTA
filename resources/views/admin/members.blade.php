@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Manajemen Member</h2>
        <p class="text-gray-500 text-sm">Kelola data member, registrasi baru, dan aktivasi status.</p>
    </div>
    
    <!-- Pencarian -->
    <form action="{{ route('admin.members') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / WA..." class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 w-64">
        <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-900 transition">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-xs uppercase text-gray-500 font-bold">
                    <th class="px-6 py-4">Info Member</th>
                    <th class="px-6 py-4">Status Aktivasi</th>
                    <th class="px-6 py-4">ID Member</th>
                    <th class="px-6 py-4">Masa Aktif Gym</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($members as $member)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-800">{{ $member->name }}</p>
                        <p class="text-xs text-gray-500"><i class="fab fa-whatsapp text-green-500"></i> {{ $member->whatsapp }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($member->is_active_member)
                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase">
                                <i class="fa fa-check-circle mr-1"></i> Teraktivasi
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase">
                                <i class="fa fa-times-circle mr-1"></i> Belum Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-bold text-slate-600">
                            {{ $member->member_code ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $latestSub = $member->memberships()->where('status', 'active')->latest()->first();
                        @endphp
                        
                        @if($latestSub && $latestSub->end_date->isFuture())
                            <div class="text-xs">
                                <p class="text-blue-600 font-bold">Aktif s/d:</p>
                                <p class="text-slate-700">{{ $latestSub->end_date->format('d M Y') }}</p>
                            </div>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada paket</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if(!$member->is_active_member)
                            <form action="{{ route('admin.member.activate') }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran Aktivasi Member Rp 80.000?')">
                                @csrf
                                <input type="hidden" name="whatsapp" value="{{ $member->whatsapp }}">
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 text-xs font-bold py-2 px-3 rounded-lg shadow-sm transition">
                                    Aktifkan (80k)
                                </button>
                            </form>
                        @else
                            <div class="flex justify-center gap-2">
                                <button class="text-blue-600 hover:text-blue-800 p-2" title="Detail/Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="text-slate-400 hover:text-slate-600 p-2" title="Cetak Kartu">
                                    <i class="fa fa-print"></i>
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fa fa-user-slash text-4xl text-slate-200 mb-3"></i>
                            <p class="text-gray-400 italic">Member tidak ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($members->hasPages())
    <div class="p-4 bg-slate-50 border-t">
        {{ $members->links() }}
    </div>
    @endif
</div>
@endsection