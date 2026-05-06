@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="bg-gray-800 p-4 text-white flex justify-between items-center">
            <h3 class="font-bold uppercase tracking-wider">Kasir Check-in</h3>
            <span class="text-xs bg-blue-600 px-2 py-1 rounded">{{ now()->format('d M Y') }}</span>
        </div>
        
        <div class="p-6">
            <!-- Form Cari User -->
            <form action="{{ route('admin.checkin') }}" method="GET" class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Input Nomor WhatsApp Member/Tamu</label>
                <div class="flex gap-2">
                    <input type="text" name="whatsapp" value="{{ request('whatsapp') }}" placeholder="Contoh: 0812345..." class="flex-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-700" required>
                    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>

            @if(request('whatsapp'))
            <div class="bg-blue-50 rounded-xl p-6 border-2 border-dashed border-blue-200">
                <form action="{{ route('admin.checkin.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="whatsapp" value="{{ request('whatsapp') }}">
                    
                    <div class="text-center mb-6">
                        <h4 class="text-gray-500 text-sm uppercase">Harga Kunjungan</h4>
                        <div class="text-4xl font-black text-blue-900">Rp {{ number_format($price, 0, ',', '.') }}</div>
                        <p class="text-xs text-blue-600 mt-1 font-semibold">
                            {{ $price == 0 ? 'PAKET BULANAN AKTIF' : ($user && $user->is_active_member ? 'HARGA MEMBER' : 'HARGA TAMU UMUM') }}
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500">NAMA LENGKAP</label>
                            <input type="text" name="name" value="{{ $user->name ?? '' }}" class="w-full border-gray-200 rounded-lg bg-white" placeholder="Masukkan nama jika belum terdaftar" {{ $user ? 'readonly' : 'required' }}>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-green-700 transition transform active:scale-95 text-lg">
                            <i class="fa fa-check mr-2"></i> SELESAI & CHECK-IN
                        </button>
                    </div>
                </form>

                @if($user && !$user->is_active_member)
                <div class="mt-6 pt-6 border-t border-blue-200">
                    <form action="{{ route('admin.member.activate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="whatsapp" value="{{ $user->whatsapp }}">
                        <p class="text-xs text-gray-500 mb-2">Ingin jadi member seumur hidup?</p>
                        <button type="submit" class="w-full bg-yellow-500 text-gray-900 font-bold py-2 rounded-lg hover:bg-yellow-400 text-sm">
                            <i class="fa fa-star mr-1"></i> AKTIFKAN MEMBER (Rp 80.000)
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection