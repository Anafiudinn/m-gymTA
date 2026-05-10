@extends('layouts.owner')
@section('title', 'Laporan Keuangan')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-xl border border-gray-100 p-5 mb-5">
    <p class="text-[13px] font-semibold text-gray-900 mb-3.5">Filter Periode</p>
    <form action="{{ route('owner.reports') }}" method="GET"
          id="form-filter"
          class="flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 transition">
        </div>
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 transition">
        </div>
        <button type="submit" id="btn-filter"
                class="bg-gray-900 text-white text-[13px] font-medium px-5 py-2 rounded-lg
                       hover:bg-gray-800 active:scale-[.98] transition disabled:opacity-50 disabled:cursor-not-allowed">
            Tampilkan
        </button>
        @if(request('start_date') || request('end_date'))
            <a href="{{ route('owner.reports') }}"
               class="text-[13px] text-gray-400 hover:text-gray-600 transition py-2">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- Summary --}}
<div class="bg-white rounded-xl border border-gray-100 p-5 mb-5">
    <p class="text-[12px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Total Omzet Periode Ini</p>
    <p class="text-[24px] font-semibold text-gray-900 tracking-tight">
        Rp {{ number_format($total_omzet, 0, ',', '.') }}
    </p>
</div>

{{-- Tabel Transaksi --}}
<div class="bg-white rounded-xl border border-gray-100 p-5">
    <p class="text-[13px] font-semibold text-gray-900 mb-4">Riwayat Transaksi</p>

    @if($transactions->isEmpty())
        <div class="py-14 text-center text-gray-300">
            <svg class="w-8 h-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/>
            </svg>
            <p class="text-[13px]">Tidak ada transaksi pada periode ini</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Tgl / Waktu</th>
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Invoice</th>
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Member</th>
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Kategori</th>
                        <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($transactions as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-1 text-[12.5px] text-gray-500">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-1 font-mono text-[11.5px] text-gray-400">{{ $trx->invoice_code }}</td>
                        <td class="py-3 px-1 text-[13px] text-gray-800">{{ $trx->user->name }}</td>
                        <td class="py-3 px-1">
                            <span class="text-[12px] capitalize text-gray-500">{{ $trx->category }}</span>
                        </td>
                        <td class="py-3 px-1 text-right text-[13px] font-semibold text-gray-900">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination jika ada --}}
        @if(method_exists($transactions, 'links'))
            <div class="mt-4">{{ $transactions->links() }}</div>
        @endif
    @endif
</div>

<script>
    const formFilter = document.getElementById('form-filter');
    const btnFilter  = document.getElementById('btn-filter');
    formFilter.addEventListener('submit', function() {
        btnFilter.disabled = true;
        btnFilter.textContent = 'Memuat...';
    });
</script>
@endsection