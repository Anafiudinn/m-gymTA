@extends('layouts.admin')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-black text-orange-600">Beli Paket & Aktivasi</h2>
        <p class="text-sm text-slate-500">Kelola pendaftaran member dan paket latihan</p>
    </div>

    @php $activeTab = request('tab', 'aktivasi'); @endphp

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded-r-lg">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    {{-- Error Alert --}}
    @if(session('error'))
    <div class="mb-6 p-6 bg-white border-2 border-dashed border-red-200 rounded-2xl text-center">
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-search text-2xl"></i>
        </div>
        <h4 class="font-bold text-slate-800">Yah, Data Tidak Ditemukan</h4>
        <p class="text-sm text-slate-500 mb-4">{{ session('error') }}</p>
        <div class="flex flex-col gap-2">
            <a href="{{ route('admin.package.index', ['tab' => 'aktivasi']) }}" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-xl text-sm transition">Daftarkan Jadi Member (80k)</a>
            <a href="{{ route('admin.attendance.index') }}" class="text-slate-500 text-xs font-bold underline">Atau hanya Tamu Harian?</a>
        </div>
    </div>
    @endif

    {{-- Tab Navigation --}}
    <div class="flex gap-2 mb-6 bg-slate-100 p-1 w-fit rounded-xl border">
        <a href="{{ route('admin.package.index', ['tab' => 'aktivasi']) }}" class="px-6 py-2 rounded-lg font-bold text-sm transition {{ $activeTab == 'aktivasi' ? 'bg-white shadow text-orange-600' : 'text-slate-500 hover:text-orange-500' }}">Aktivasi Member</a>
        <a href="{{ route('admin.package.index', ['tab' => 'bulanan']) }}" class="px-6 py-2 rounded-lg font-bold text-sm transition {{ $activeTab == 'bulanan' ? 'bg-white shadow text-blue-600' : 'text-slate-500 hover:text-blue-500' }}">Paket Bulanan</a>
        <a href="{{ route('admin.package.index', ['tab' => 'pt']) }}" class="px-6 py-2 rounded-lg font-bold text-sm transition {{ $activeTab == 'pt' ? 'bg-white shadow text-slate-900' : 'text-slate-500 hover:text-slate-700' }}">Paket PT</a>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Left Panel --}}
        <div class="lg:col-span-5 space-y-6">
            {{-- Search Form --}}
            @if($activeTab != 'aktivasi')
            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <h3 class="font-bold mb-4 flex items-center gap-2"><i class="fas fa-search text-blue-500"></i>Cari Member</h3>
                <form action="{{ route('admin.package.index') }}" method="GET">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full border-slate-200 rounded-xl py-3 px-4 mb-3" placeholder="WA / Kode Member...">
                    <button class="w-full bg-slate-800 hover:bg-slate-700 text-white py-3 rounded-xl text-sm font-bold transition">CARI DATA</button>
                </form>
                @if($user)
                <div class="mt-6 p-4 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Member Terpilih</p>
                    <h4 class="font-black text-lg text-slate-800">{{ $user->name }}</h4>
                    <p class="text-xs text-slate-500">{{ $user->whatsapp }}</p>
                    <div class="mt-2">
                        <span class="px-2 py-1 rounded text-[10px] font-bold {{ $user->is_active_member ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->is_active_member ? 'MEMBER AKTIF' : 'BELUM AKTIF' }}
                        </span>
                    </div>
                </div>
                @endif
            </div>
            @endif

            {{-- Aktivasi Tab --}}
            @if($activeTab == 'aktivasi')
            <div class="bg-white rounded-2xl shadow-sm border p-6 border-orange-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center"><i class="fas fa-user-plus"></i></div>
                    <div>
                        <h3 class="font-bold text-slate-800">Aktivasi Member Baru</h3>
                        <p class="text-xs text-slate-500">Daftarkan member baru permanen</p>
                    </div>
                </div>
                @if ($errors->has('whatsapp'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-xl">{{ $errors->first('whatsapp') }}</div>
                @endif
                <form action="{{ route('admin.package.activate') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full border-slate-200 rounded-xl mt-1" placeholder="Contoh: Johan Wijaya">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" required class="w-full border-slate-200 rounded-xl mt-1" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Biaya Aktivasi</label>
                            <div class="relative mt-1">
                                <span class="absolute left-4 top-3 text-slate-400 font-bold">Rp</span>
                                <input type="text" value="80.000" readonly class="w-full border-slate-200 rounded-xl pl-12 bg-slate-50 font-bold">
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Metode Bayar</label>
                            <select name="payment_method" class="w-full border-slate-200 rounded-xl mt-1">
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black py-4 rounded-2xl transition">DAFTAR & AKTIFKAN MEMBER</button>
                </form>
            </div>
            @endif

            {{-- Bulanan Tab --}}
            @if($activeTab == 'bulanan' && $user)
            <div class="bg-white rounded-2xl shadow-sm border p-6 border-blue-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center"><i class="fas fa-dumbbell"></i></div>
                    <div>
                        <h3 class="font-bold text-slate-800">Paket Bulanan Gym</h3>
                        <p class="text-xs text-slate-400">Harga otomatis dari pengaturan owner</p>
                    </div>
                </div>
                <form action="{{ route('admin.package.buy') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                        <p class="text-xs text-slate-500 mb-2">Harga Paket Bulanan</p>
                        <h2 class="text-3xl font-black text-blue-600">Rp {{ number_format($bulananMember, 0, ',', '.') }}</h2>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full border-slate-200 rounded-xl mt-1">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition">BAYAR PAKET BULANAN</button>
                </form>
            </div>
            @endif

            {{-- PT Tab --}}
            @if($activeTab == 'pt' && $user)
            <div class="bg-white rounded-2xl shadow-sm border p-6 border-slate-200">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center"><i class="fas fa-user-ninja"></i></div>
                    <div>
                        <h3 class="font-bold text-slate-800">Paket Personal Trainer</h3>
                        <p class="text-xs text-slate-400">Pilih paket PT dari master owner</p>
                    </div>
                </div>
                <form action="{{ route('admin.package.buy_pt') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Pilih Paket PT</label>
                        <select name="pt_package_id" class="w-full border-slate-200 rounded-xl mt-1">
                            @foreach($ptPackages as $package)
                            <option value="{{ $package->id }}">{{ $package->nama_paket }} - {{ $package->jumlah_sesi }} sesi - Rp {{ number_format($package->harga, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full border-slate-200 rounded-xl mt-1">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-2xl transition">BELI PAKET PT</button>
                </form>
            </div>
            @endif
        </div>

        {{-- Right Panel - Transaction History --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl shadow-sm border p-6 min-h-[500px]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800">Riwayat Transaksi</h3>
                    <span class="bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1 rounded-full">Paket & Aktivasi</span>
                </div>
                @if($transactions->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-slate-300">
                    <i class="fas fa-receipt text-5xl mb-4"></i>
                    <p class="text-sm">Belum ada transaksi</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($transactions as $trx)
                    <div class="border border-slate-100 rounded-2xl p-4 hover:bg-slate-50 transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    @if($trx->category == 'activation')
                                    <span class="bg-orange-100 text-orange-600 text-[10px] font-black px-2 py-1 rounded-full">AKTIVASI</span>
                                    @elseif($trx->category == 'monthly')
                                    <span class="bg-blue-100 text-blue-600 text-[10px] font-black px-2 py-1 rounded-full">BULANAN</span>
                                    @elseif($trx->category == 'pt')
                                    <span class="bg-slate-200 text-slate-700 text-[10px] font-black px-2 py-1 rounded-full">PT</span>
                                    @endif
                                    <span class="text-[10px] text-slate-400 font-bold">{{ $trx->invoice_code }}</span>
                                </div>
                                <h4 class="font-black text-slate-800">{{ optional($trx->user)->name ?? '-' }}</h4>
                                <p class="text-xs text-slate-400">{{ optional($trx->user)->member_code ?? '-' }}</p>
                                <div class="mt-2 text-xs text-slate-500">
                                    <p>{{ ucfirst($trx->payment_method) }} • {{ $trx->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-slate-800">Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                                <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $trx->status == 'success' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">{{ strtoupper($trx->status) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection