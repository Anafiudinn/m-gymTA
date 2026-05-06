@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-slate-800">Selamat Bekerja, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
    <p class="text-gray-500 text-sm">Berikut ringkasan aktivitas kasir hari ini.</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-lg"><i class="fa fa-users text-xl"></i></div>
            <span class="text-xs font-bold text-gray-400">CHECK-IN</span>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-slate-800">{{ $today_attendance_count ?? 0 }}</h3>
            <p class="text-xs text-gray-400">Orang hari ini</p>
        </div>
    </div>
    
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div class="bg-green-100 text-green-600 p-3 rounded-lg"><i class="fa fa-wallet text-xl"></i></div>
            <span class="text-xs font-bold text-gray-400">OMZET KASIR</span>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($today_omzet ?? 0, 0, ',', '.') }}</h3>
            <p class="text-xs text-gray-400">Total transaksi Anda</p>
        </div>
    </div>
</div>

@endsection