{{-- resources/views/owner/admins/index.blade.php --}}

@extends('layouts.owner')

@section('title', 'Kelola Admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Kelola Admin
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Manajemen akun admin kasir dan operasional gym.
            </p>
        </div>

        <button onclick="document.getElementById('modalAdmin').classList.remove('hidden')"
                class="bg-black text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-gray-800 transition">
            + Tambah Admin
        </button>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl shadow-sm p-5 border">
            <div class="text-sm text-gray-500">Total Admin</div>
            <div class="text-3xl font-bold mt-2">
                {{ $admins->count() }}
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 border">
            <div class="text-sm text-gray-500">Admin Aktif</div>
            <div class="text-3xl font-bold mt-2 text-green-600">
                {{ $admins->where('is_active', true)->count() }}
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 border">
            <div class="text-sm text-gray-500">Admin Nonaktif</div>
            <div class="text-3xl font-bold mt-2 text-red-500">
                {{ $admins->where('is_active', false)->count() }}
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-sm text-gray-600">
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">WhatsApp</th>
                        <th class="px-6 py-4 text-center font-semibold">Dibuat</th>
                        <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $admin->name }}</div>
                                <div class="text-xs text-gray-400">ID #{{ $admin->id }}</div>
                            </td>
                            
                            <td class="px-6 py-4 text-gray-600">
                                {{ $admin->whatsapp }}
                            </td>
                            
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ $admin->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Delete --}}
                                    <form action="{{ route('owner.admins.destroy', $admin->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-black text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-gray-800 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                Belum ada data admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH ADMIN --}}
<div id="modalAdmin" 
     class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    
    <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative">
        {{-- CLOSE BUTTON --}}
        <button onclick="document.getElementById('modalAdmin').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-black">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="mb-6">
            <h2 class="text-xl font-bold">Tambah Admin</h2>
            <p class="text-sm text-gray-500 mt-1">
                Tambahkan akun admin operasional gym.
            </p>
        </div>

        <form action="{{ route('owner.admins.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-2">Nama Admin</label>
                <input type="text" 
                       name="name" 
                       required
                       class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black">
            </div>

            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-2">Nomor WhatsApp</label>
                <input type="text" 
                       name="whatsapp" 
                       required
                       class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black">
            </div>

            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-2">Password</label>
                <input type="password" 
                       name="password" 
                       required
                       class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black">
            </div>

            <button type="submit" 
                    class="w-full bg-black hover:bg-gray-800 text-white py-3 rounded-xl font-semibold transition">
                Simpan Admin
            </button>
        </form>
    </div>
</div>
@endsection