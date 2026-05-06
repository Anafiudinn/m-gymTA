@extends('layouts.admin')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <i class="fa fa-home text-[10px]"></i>
        <span>Dashboard</span>
        <i class="fa fa-chevron-right text-[9px]"></i>
        <span class="text-slate-600 font-semibold">Kehadiran</span>
    </div>
    <h1 class="text-2xl font-extrabold text-slate-800 leading-tight">Kehadiran</h1>
    <p class="text-sm text-slate-400 mt-0.5">Catat kehadiran tamu harian dan check-in member</p>
</div>

@php $activeTab = request('tab', 'guest'); @endphp

{{-- Tab Navigation --}}
<div class="flex gap-2 mb-6">
    <a href="{{ route('admin.attendance.index', ['tab' => 'guest']) }}"
       class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200
              {{ $activeTab == 'guest'
                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-200'
                 : 'bg-white text-slate-500 border border-slate-200 hover:border-orange-300 hover:text-orange-500' }}">
        <i class="fas fa-user text-xs"></i> Tamu Harian
    </a>
    <a href="{{ route('admin.attendance.index', ['tab' => 'member']) }}"
       class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200
              {{ $activeTab == 'member'
                 ? 'bg-blue-600 text-white shadow-lg shadow-blue-200'
                 : 'bg-white text-slate-500 border border-slate-200 hover:border-blue-400 hover:text-blue-600' }}">
        <i class="fas fa-id-card text-xs"></i> Check-in Member
    </a>
</div>

{{-- ═══════════ TAMU TAB ═══════════ --}}
@if($activeTab == 'guest')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

    {{-- Form Tamu --}}
    <div class="lg:col-span-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            {{-- Card header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center">
                    <i class="fas fa-user-plus text-orange-500 text-sm"></i>
                </div>
                <div>
                    <p class="font-bold text-slate-800 text-sm leading-tight">Daftar Tamu Baru</p>
                    <p class="text-[11px] text-slate-400">Day pass Rp 15.000</p>
                </div>
            </div>

            <form action="{{ route('admin.attendance.process') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="type"   value="guest">
                <input type="hidden" name="amount" value="15000">

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                    <input type="text" name="name" required placeholder="Nama tamu"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300
                               focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">No. WhatsApp</label>
                    <input type="text" name="whatsapp" placeholder="08xx"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300
                               focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Biaya Day Pass</label>
                    <div class="w-full border border-orange-200 bg-orange-50 rounded-xl px-4 py-3 flex items-center justify-between">
                        <span class="text-sm text-slate-500">Day Pass</span>
                        <span class="font-extrabold text-orange-500">Rp 15.000</span>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="group border border-slate-200 rounded-xl p-3 flex items-center justify-center gap-2 cursor-pointer
                                      has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50 transition">
                            <input type="radio" name="payment_method" value="cash" checked class="accent-orange-500">
                            <i class="fas fa-money-bill-wave text-xs text-slate-400 group-has-[:checked]:text-orange-500"></i>
                            <span class="text-sm font-bold text-slate-600 group-has-[:checked]:text-orange-600">CASH</span>
                        </label>
                        <label class="group border border-slate-200 rounded-xl p-3 flex items-center justify-center gap-2 cursor-pointer
                                      has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50 transition">
                            <input type="radio" name="payment_method" value="transfer" class="accent-orange-500">
                            <i class="fas fa-qrcode text-xs text-slate-400 group-has-[:checked]:text-orange-500"></i>
                            <span class="text-sm font-bold text-slate-600 group-has-[:checked]:text-orange-600">TRANSFER</span>
                        </label>
                    </div>
                </div>

                {{-- Submit with confirm --}}
                <button type="submit"
                    data-confirm
                    data-confirm-title="Catat Kehadiran Tamu?"
                    data-confirm-desc="Pastikan nama tamu dan metode pembayaran sudah benar sebelum menyimpan."
                    data-confirm-type="info"
                    data-confirm-label="Ya, Catat Sekarang"
                    class="w-full bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-bold py-3.5 rounded-xl
                           transition-all duration-200 shadow-md shadow-orange-200 flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle text-sm"></i>
                    Catat Kehadiran
                </button>
            </form>
        </div>
    </div>

    {{-- History Tamu --}}
    <div class="lg:col-span-7">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-clock text-orange-500 text-sm"></i>
                    </div>
                    <p class="font-bold text-slate-800 text-sm">Tamu Hari Ini</p>
                </div>
                <span class="bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1.5 rounded-full">
                    {{ $historyTamu->count() }} tamu
                </span>
            </div>

            @if($historyTamu->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-slate-200 gap-3">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center">
                    <i class="fas fa-users text-3xl text-slate-200"></i>
                </div>
                <p class="text-sm text-slate-400 font-medium">Belum ada tamu hari ini</p>
            </div>
            @else
            <div class="divide-y divide-slate-50 px-2 py-2">
                @foreach($historyTamu as $item)
                <div class="flex items-center justify-between px-4 py-3.5 hover:bg-slate-50 rounded-xl transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-orange-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm leading-tight">{{ $item->guest_name }}</p>
                            <p class="text-xs text-slate-400">{{ $item->guest_whatsapp ?? 'Tidak ada WA' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-extrabold text-orange-500">Rp 15.000</p>
                            <p class="text-[10px] text-slate-400 font-mono">{{ $item->created_at->format('H:i') }}</p>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center">
                            <i class="fas fa-check text-orange-500 text-[10px]"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- ═══════════ MEMBER TAB ═══════════ --}}
@if($activeTab == 'member')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

    {{-- Form Member --}}
    <div class="lg:col-span-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-id-card text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="font-bold text-slate-800 text-sm leading-tight">Cari / Scan Member</p>
                    <p class="text-[11px] text-slate-400">ID Member atau No. WhatsApp</p>
                </div>
            </div>

            <div class="p-6">
                {{-- Search --}}
                <form action="{{ route('admin.attendance.index') }}" method="GET" class="flex gap-2 mb-5">
                    <input type="hidden" name="tab" value="member">
                    <input type="text" name="search" value="{{ request('search') }}" autofocus
                        placeholder="ID Member / No WA..."
                        class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                    <button type="submit"
                        class="bg-slate-800 hover:bg-slate-700 active:scale-95 text-white font-bold px-5 py-3 rounded-xl text-sm transition-all">
                        <i class="fas fa-search mr-1 text-xs"></i> Cari
                    </button>
                </form>

                @if($user)
                {{-- Member Card --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl overflow-hidden">
                    {{-- Member info header --}}
                    <div class="p-5 text-center border-b border-blue-100">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mx-auto mb-3 shadow-md shadow-blue-200">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <span class="inline-block text-[10px] font-bold px-3 py-1 rounded-full mb-2
                            {{ $price == 0 ? 'bg-green-500 text-white' : 'bg-blue-600 text-white' }}">
                            {{ strtoupper($status_label) }}
                        </span>
                        <h4 class="text-lg font-extrabold text-slate-800">{{ $user->name }}</h4>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $user->member_code ?? $user->whatsapp }}</p>
                    </div>

                    {{-- Check-in Form --}}
                    <form action="{{ route('admin.attendance.process') }}" method="POST" class="p-5 space-y-3">
                        @csrf
                        <input type="hidden" name="type"           value="member">
                        <input type="hidden" name="user_id_found"  value="{{ $user->id }}">
                        <input type="hidden" name="amount"         value="{{ $price }}">

                        @if($price > 0)
                        {{-- Paid --}}
                        <div class="bg-white border border-blue-100 rounded-xl p-4">
                            <p class="text-xs text-center text-slate-400 mb-1">Biaya Kunjungan</p>
                            <p class="text-2xl font-extrabold text-center text-blue-600">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </p>
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <label class="group border border-slate-200 rounded-lg p-2.5 flex items-center justify-center gap-1.5 cursor-pointer
                                              has-[:checked]:bg-blue-600 has-[:checked]:border-blue-600 transition">
                                    <input type="radio" name="payment_method" value="cash" checked class="hidden">
                                    <i class="fas fa-money-bill-wave text-[10px] text-slate-400 group-has-[:checked]:text-white"></i>
                                    <span class="text-xs font-bold text-slate-600 group-has-[:checked]:text-white">CASH</span>
                                </label>
                                <label class="group border border-slate-200 rounded-lg p-2.5 flex items-center justify-center gap-1.5 cursor-pointer
                                              has-[:checked]:bg-blue-600 has-[:checked]:border-blue-600 transition">
                                    <input type="radio" name="payment_method" value="transfer" class="hidden">
                                    <i class="fas fa-qrcode text-[10px] text-slate-400 group-has-[:checked]:text-white"></i>
                                    <span class="text-xs font-bold text-slate-600 group-has-[:checked]:text-white">TRANSFER</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                            data-confirm
                            data-confirm-title="Check-in Member Berbayar?"
                            data-confirm-desc="Member akan dikenakan biaya Rp {{ number_format($price, 0, ',', '.') }}. Pastikan pembayaran sudah diterima."
                            data-confirm-type="warning"
                            data-confirm-label="Ya, Check-in"
                            class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-bold py-3.5 rounded-xl
                                   transition-all duration-200 shadow-md shadow-blue-200 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt text-sm"></i> Check-in Sekarang
                        </button>

                        @else
                        {{-- Free --}}
                        <input type="hidden" name="payment_method" value="cash">
                        <div class="bg-green-500 text-white rounded-xl p-3.5 flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm font-bold">Paket Aktif — Gratis</span>
                        </div>

                        <button type="submit"
                            data-confirm
                            data-confirm-title="Check-in Member Gratis?"
                            data-confirm-desc="Paket member aktif. Konfirmasi check-in {{ $user->name }} sekarang?"
                            data-confirm-type="success"
                            data-confirm-label="Ya, Check-in"
                            class="w-full bg-slate-900 hover:bg-slate-800 active:scale-95 text-white font-bold py-3.5 rounded-xl
                                   transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt text-sm"></i> Check-in Sekarang
                        </button>
                        @endif
                    </form>
                </div>

                @elseif(request('search'))
                <div class="bg-red-50 border border-red-100 rounded-xl p-5 text-center">
                    <i class="fas fa-user-times text-red-300 text-2xl mb-2"></i>
                    <p class="text-sm text-red-400 font-semibold">Member tidak ditemukan</p>
                    <p class="text-xs text-slate-400 mt-1">Coba dengan ID lain atau periksa kembali</p>
                </div>
                @else
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-5 text-center">
                    <i class="fas fa-search text-slate-200 text-2xl mb-2"></i>
                    <p class="text-sm text-slate-400 font-medium">Masukkan ID atau nomor WA member</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- History Member --}}
    <div class="lg:col-span-7">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-clock text-blue-500 text-sm"></i>
                    </div>
                    <p class="font-bold text-slate-800 text-sm">Check-in Hari Ini</p>
                </div>
                <span class="bg-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full">
                    {{ $historyMember->count() }} member
                </span>
            </div>

            @if($historyMember->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 gap-3">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center">
                    <i class="fas fa-id-badge text-3xl text-slate-200"></i>
                </div>
                <p class="text-sm text-slate-400 font-medium">Belum ada check-in member hari ini</p>
            </div>
            @else
            <div class="divide-y divide-slate-50 px-2 py-2">
                @foreach($historyMember as $item)
                <div class="flex items-center justify-between px-4 py-3.5 hover:bg-slate-50 rounded-xl transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-blue-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm leading-tight">{{ optional($item->user)->name }}</p>
                            <p class="text-xs text-slate-400 font-mono">{{ optional($item->user)->member_code }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            @if($item->type === 'member_package')
                            <span class="text-sm font-extrabold text-green-500">GRATIS</span>
                            @else
                            <span class="text-sm font-extrabold text-blue-500">BERBAYAR</span>
                            @endif
                            <p class="text-[10px] text-slate-400 font-mono">{{ $item->created_at->format('H:i') }}</p>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-check text-blue-500 text-[10px]"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endif

@endsection