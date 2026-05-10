@extends('layouts.owner')
@section('title', 'Paket PT')

@section('content')

{{-- Form Tambah Paket --}}
<div class="bg-white rounded-xl border border-gray-100 p-5 mb-5">
    <p class="text-[13px] font-semibold text-gray-900 mb-4">Tambah Paket Baru</p>
    <form action="{{ route('owner.pt-packages.store') }}" method="POST"
          id="form-add-package"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
        @csrf
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1">Nama Paket</label>
            <input type="text" name="nama_paket"
                   placeholder="Contoh: Paket 10 Sesi"
                   class="w-full text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 transition placeholder-gray-300"
                   required>
        </div>
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1">Jumlah Sesi</label>
            <input type="number" name="jumlah_sesi" min="1"
                   placeholder="10"
                   class="w-full text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 transition placeholder-gray-300"
                   required>
        </div>
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1">Harga (Rp)</label>
            <input type="number" name="harga" min="0"
                   placeholder="900000"
                   class="w-full text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 transition placeholder-gray-300"
                   required>
        </div>
        <button type="submit" id="btn-add-package"
                class="w-full bg-gray-900 text-white text-[13px] font-medium py-2.5 rounded-lg
                       hover:bg-gray-800 active:scale-[.98] transition disabled:opacity-50 disabled:cursor-not-allowed">
            + Tambah Paket
        </button>
    </form>
</div>

{{-- Tabel Paket --}}
<div class="bg-white rounded-xl border border-gray-100 p-5">
    <p class="text-[13px] font-semibold text-gray-900 mb-4">Daftar Paket PT</p>

    @if(count($packages) === 0)
        <div class="py-14 text-center text-gray-300">
            <svg class="w-8 h-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <rect x="1.5" y="9.5" width="3" height="5" rx="1.5"/>
                <rect x="19.5" y="9.5" width="3" height="5" rx="1.5"/>
                <rect x="4.5" y="7.5" width="3" height="9" rx="1.5"/>
                <rect x="16.5" y="7.5" width="3" height="9" rx="1.5"/>
                <line x1="7.5" y1="12" x2="16.5" y2="12"/>
            </svg>
            <p class="text-[13px]">Belum ada paket PT</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Nama Paket</th>
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Sesi</th>
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Harga</th>
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($packages as $package)
                    <tr>
                        <td class="py-3 px-1 text-[13px] font-medium text-gray-800">{{ $package->nama_paket }}</td>
                        <td class="py-3 px-1 text-[13px] text-gray-500">{{ $package->jumlah_sesi }} sesi</td>
                        <td class="py-3 px-1 text-[13px] font-semibold text-gray-900">Rp {{ number_format($package->harga, 0, ',', '.') }}</td>
                        <td class="py-3 px-1">
                            @if($package->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-100 text-gray-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span> Non-aktif
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    const formPkg = document.getElementById('form-add-package');
    const btnPkg  = document.getElementById('btn-add-package');
    formPkg.addEventListener('submit', function() {
        btnPkg.disabled = true;
        btnPkg.textContent = 'Menyimpan...';
    });
</script>
@endsection