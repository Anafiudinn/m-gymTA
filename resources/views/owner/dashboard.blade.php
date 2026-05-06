@extends('layouts.owner')
@section('title', 'Dashboard Ringkasan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
        <div class="text-gray-500 text-sm font-medium uppercase">Pendapatan Hari Ini</div>
        <div class="text-2xl font-bold">Rp {{ number_format($income_today, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
        <div class="text-gray-500 text-sm font-medium uppercase">Total Member Aktif</div>
        <div class="text-2xl font-bold">{{ $active_members }} Orang</div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm">
    <h3 class="text-lg font-bold mb-4">Omzet Per Kategori (Berhasil)</h3>
    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-50">
                <th class="p-3 border-b">Kategori</th>
                <th class="p-3 border-b text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats_category as $stat)
            <tr>
                <td class="p-3 border-b capitalize">{{ $stat->category }}</td>
                <td class="p-3 border-b text-right font-semibold">Rp {{ number_format($stat->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection