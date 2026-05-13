{{-- resources/views/owner/products/show.blade.php --}}

@extends('layouts.owner')

@section('title', 'Detail Produk')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="bg-white border border-gray-100 rounded-2xl p-6 mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $product->nama_produk }}
                </h1>

                <div class="mt-2 text-sm text-gray-500">
                    Monitoring detail penjualan produk
                </div>

            </div>

            <div>

                @if($product->stok <= 5)

                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                        Stok Menipis
                    </span>

                @else

                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700">
                        Stok Aman
                    </span>

                @endif

            </div>

        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <div class="bg-white border border-gray-100 rounded-2xl p-5">

            <p class="text-xs text-gray-500 mb-2">
                HARGA PRODUK
            </p>

            <h2 class="text-3xl font-bold text-gray-900">
                Rp {{ number_format($product->harga, 0, ',', '.') }}
            </h2>

        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">

            <p class="text-xs text-gray-500 mb-2">
                TOTAL TERJUAL
            </p>

            <h2 class="text-3xl font-bold text-blue-600">
                {{ $totalSold }}
            </h2>

        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">

            <p class="text-xs text-gray-500 mb-2">
                TOTAL OMZET
            </p>

            <h2 class="text-3xl font-bold text-emerald-600">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h2>

        </div>

    </div>

    {{-- PRODUCT INFO --}}
    <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-6">

        <h2 class="font-semibold text-gray-900 mb-4">
            Informasi Produk
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>

                <p class="text-xs text-gray-500 mb-1">
                    Nama Produk
                </p>

                <div class="text-sm font-semibold text-gray-900">
                    {{ $product->nama_produk }}
                </div>

            </div>

            <div>

                <p class="text-xs text-gray-500 mb-1">
                    Stok Saat Ini
                </p>

                <div class="text-sm font-semibold text-gray-900">
                    {{ $product->stok }}
                </div>

            </div>

        </div>

    </div>

    {{-- SALES HISTORY --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">
                Riwayat Penjualan
            </h2>
        </div>

        @if($salesHistory->count() == 0)

            <div class="py-16 text-center text-gray-400 text-sm">
                Belum ada riwayat penjualan
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Invoice
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Qty
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Harga
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Subtotal
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Tanggal
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($salesHistory as $item)

                            <tr>

                                <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                    {{ $item->transaction->invoice_code ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $item->qty }}
                                </td>

                                <td class="px-5 py-4 text-sm text-gray-700">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-sm text-gray-500">
                                    {{ $item->created_at->format('d M Y H:i') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="px-5 py-4 border-t border-gray-100">
                {{ $salesHistory->links() }}
            </div>

        @endif

    </div>

</div>

@endsection