@extends('layouts.owner')
@section('title', 'Manajemen Admin/Kasir')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah Admin -->
    <div class="bg-white p-6 rounded-lg shadow-sm h-fit">
        <h3 class="text-lg font-bold mb-4">Tambah Admin Baru</h3>
        <form action="{{ route('owner.admins.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">WhatsApp (Untuk Login)</label>
                    <input type="text" name="whatsapp" placeholder="62812..." class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Password</label>
                    <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <button type="submit" class="w-full bg-slate-900 text-white py-2 rounded hover:bg-slate-800">
                    Simpan Akun Admin
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Admin -->
    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
        <h3 class="text-lg font-bold mb-4">Daftar Admin Aktif</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-sm">
                    <th class="p-3 border-b">Nama</th>
                    <th class="p-3 border-b">WhatsApp</th>
                    <th class="p-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $admin->name }}</td>
                    <td class="p-3 border-b">{{ $admin->whatsapp }}</td>
                    <td class="p-3 border-b text-center">
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection