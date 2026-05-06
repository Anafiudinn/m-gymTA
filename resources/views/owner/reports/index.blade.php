@extends('layouts.owner')
@section('title', 'Laporan Keuangan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm mb-6">
    <form action="{{ route('owner.reports') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="mt-1 border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="mt-1 border-gray-300 rounded-md shadow-sm">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Filter Laporan
        </button>
        <a href="{{ route('owner.reports') }}" class="text-gray-500 hover:underline">Reset</a>
    </form>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm">
    <div class="mb-4 flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-800">Total Omzet: <span class="text-green-600">Rp {{ number_format($total_omzet, 0, ',', '.') }}</span></h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border-b">Tgl/Waktu</th>
                    <th class="p-3 border-b">Invoice</th>
                    <th class="p-3 border-b">Member</th>
                    <th class="p-3 border-b">Kategori</th>
                    <th class="p-3 border-b text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b text-sm">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3 border-b font-mono text-xs">{{ $trx->invoice_code }}</td>
                    <td class="p-3 border-b">{{ $trx->user->name }}</td>
                    <td class="p-3 border-b italic capitalize">{{ $trx->category }}</td>
                    <td class="p-3 border-b text-right font-bold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-400">Tidak ada transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection