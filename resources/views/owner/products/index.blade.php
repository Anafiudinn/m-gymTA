{{-- resources/views/owner/products/index.blade.php --}}

@extends('layouts.owner')

@section('title', 'Monitoring Produk')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Monitoring Produk
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Monitoring stok dan penjualan produk gym
        </p>
    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">
                TOTAL PRODUK
            </p>

            <h2 class="text-3xl font-bold text-gray-900">
                {{ $totalProducts }}
            </h2>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">
                TOTAL STOK
            </p>

            <h2 class="text-3xl font-bold text-blue-600">
                {{ $totalStock }}
            </h2>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">
                STOK MENIPIS
            </p>

            <h2 class="text-3xl font-bold text-red-500">
                {{ $lowStockProducts }}
            </h2>
        </div>

    </div>

    {{-- FILTER --}}
    <form method="GET"
          class="bg-white border border-gray-100 rounded-2xl p-5 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">
                    Cari Produk
                </label>

                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Nama produk..."
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-gray-900 hover:bg-black text-white text-sm font-medium py-2.5 rounded-xl transition">
                    Filter Produk
                </button>
            </div>

        </div>

    </form>

    {{-- BEST SELLER --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden mb-6">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">
                Produk Terlaris
            </h2>
        </div>

        @if($bestSellerProducts->count() == 0)

            <div class="py-14 text-center text-gray-400 text-sm">
                Belum ada penjualan produk
            </div>

        @else

            <div class="divide-y divide-gray-100">

                @foreach($bestSellerProducts as $item)

                    <div class="flex items-center justify-between px-5 py-4">

                        <div>

                            <div class="font-semibold text-sm text-gray-900">
                                {{ $item->product->nama_produk ?? '-' }}
                            </div>

                        </div>

                        <div class="text-sm font-bold text-blue-600">
                            {{ $item->total_qty }} Terjual
                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">
                Data Produk
            </h2>
        </div>

        @if($products->count() == 0)

            <div class="py-16 text-center text-gray-400 text-sm">
                Belum ada produk
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Produk
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Harga
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                                Stok
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($products as $product)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-5 py-4">

                                    <div class="font-semibold text-gray-900 text-sm">
                                        {{ $product->nama_produk }}
                                    </div>

                                </td>

                                <td class="px-5 py-4 text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4">

                                    @if($product->stok <= 5)

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            {{ $product->stok }} Stok
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            {{ $product->stok }} Stok
                                        </span>

                                    @endif

                                </td>

                                <td class="px-5 py-4 text-right">

                                    <a href="{{ route('owner.products.show', $product->id) }}"
                                       class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-medium transition">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="px-5 py-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>

        @endif

    </div>

</div>

@endsection