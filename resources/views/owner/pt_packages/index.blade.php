@extends('layouts.owner')
@section('title', 'Master Paket Personal Trainer')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm mb-6">
    <form action="{{ route('owner.pt-packages.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        @csrf
        <div>
            <label class="block text-sm font-medium">Nama Paket</label>
            <input type="text" name="nama_paket" placeholder="Contoh: Paket 10 Sesi" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label class="block text-sm font-medium">Jumlah Sesi</label>
            <input type="number" name="jumlah_sesi" placeholder="10" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label class="block text-sm font-medium">Harga (Rp)</label>
            <input type="number" name="harga" placeholder="900000" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 font-bold">
            + Tambah Paket
        </button>
    </form>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm">
    <table class="w-full text-left">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-3 border-b">Nama Paket</th>
                <th class="p-3 border-b">Jumlah Sesi</th>
                <th class="p-3 border-b">Harga</th>
                <th class="p-3 border-b">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $package)
            <tr>
                <td class="p-3 border-b font-medium">{{ $package->nama_paket }}</td>
                <td class="p-3 border-b">{{ $package->jumlah_sesi }} Sesi</td>
                <td class="p-3 border-b text-blue-600 font-bold">Rp {{ number_format($package->harga, 0, ',', '.') }}</td>
                <td class="p-3 border-b">
                    <span class="px-2 py-1 text-xs rounded {{ $package->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $package->is_active ? 'Aktif' : 'Non-aktif' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection