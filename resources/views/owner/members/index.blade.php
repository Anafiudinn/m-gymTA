{{-- resources/views/owner/members/index.blade.php --}}

@extends('layouts.owner')

@section('title', 'Monitoring Member')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Monitoring Member
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Data member yang sudah melakukan aktivasi atau pembelian paket gym.
        </p>
    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        {{-- TOTAL MEMBER --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">TOTAL MEMBER TERDAFTAR</p>
            <h2 class="text-3xl font-bold text-gray-900">
                {{ $totalMembers }}
            </h2>
        </div>

        {{-- MEMBER AKTIVASI --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">MEMBER SUDAH AKTIVASI</p>
            <h2 class="text-3xl font-bold text-emerald-600">
                {{ $activeMembers }}
            </h2>
        </div>

        {{-- MEMBER BELUM AKTIVASI --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">BELUM AKTIVASI</p>
            <h2 class="text-3xl font-bold text-red-500">
                {{ $inactiveMembers }}
            </h2>
        </div>

    </div>

    {{-- FILTER --}}
    <form method="GET" class="bg-white border border-gray-100 rounded-2xl p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- SEARCH --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Cari Member</label>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Nama / WhatsApp / Kode Member"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status Aktivasi</label>
                <select name="status"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">
                    <option value="">Semua Status</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Sudah Aktivasi</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Belum Aktivasi</option>
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-gray-900 hover:bg-black text-white text-sm font-medium py-2.5 rounded-xl transition">
                    Filter Data
                </button>
            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Data Member Gym</h2>
        </div>

        @if($members->count() == 0)
            <div class="py-16 text-center text-gray-400 text-sm">
                Belum ada data member
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Member</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">WhatsApp</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Kode Member</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Status Aktivasi</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Paket Bulanan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Bergabung</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($members as $member)
                            @php
                                $activePackage = $member->memberships
                                    ->where('status', 'active')
                                    ->first();
                            @endphp

                            <tr class="hover:bg-gray-50 transition">
                                {{-- MEMBER --}}
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-gray-900 text-sm">{{ $member->name }}</div>
                                </td>

                                {{-- WHATSAPP --}}
                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $member->whatsapp }}
                                </td>

                                {{-- MEMBER CODE --}}
                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $member->member_code ?? '-' }}
                                </td>

                                {{-- STATUS AKTIVASI --}}
                                <td class="px-5 py-4">
                                    @if($member->is_active_member)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            Sudah Aktivasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            Belum Aktivasi
                                        </span>
                                    @endif
                                </td>

                                {{-- PAKET BULANAN --}}
                                <td class="px-5 py-4">
                                    @if($activePackage)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Paket Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            Tidak Ada Paket
                                        </span>
                                    @endif
                                </td>

                                {{-- JOIN DATE --}}
                                <td class="px-5 py-4 text-sm text-gray-500">
                                    {{ $member->created_at->format('d M Y') }}
                                </td>

                                {{-- ACTION --}}
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('owner.members.show', $member->id) }}"
                                       class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-medium transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $members->links() }}
            </div>
        @endif
    </div>

</div>
@endsection