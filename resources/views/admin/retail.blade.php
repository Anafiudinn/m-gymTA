@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Kasir Retail (Kantin)</h2>
    <p class="text-gray-500 text-sm">Pilih produk dan masukkan jumlah untuk transaksi cepat.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- List Produk (Stok Tersedia) -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 bg-slate-50 border-b flex justify-between items-center">
                <h3 class="font-bold text-slate-700 uppercase text-xs tracking-wider">Katalog Produk</h3>
                <span class="text-xs text-blue-600 font-bold italic">*Hanya menampilkan produk dengan stok > 0</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs uppercase text-gray-400 font-semibold bg-gray-50">
                            <th class="px-6 py-3">Produk</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Stok</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $product->nama_produk }}</p>
                            </td>
                            <td class="px-6 py-4 text-blue-700 font-bold">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 px-2 py-1 rounded text-xs font-bold text-slate-600">
                                    {{ $product->stok }} unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" 
                                    onclick="selectProduct({{ $product->id }}, '{{ $product->nama_produk }}', {{ $product->harga }})"
                                    class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs hover:bg-blue-700 shadow-sm">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                Stok produk kosong atau belum diinput Owner.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Transaksi -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 sticky top-24">
            <div class="p-4 bg-blue-700 text-white rounded-t-xl">
                <h3 class="font-bold flex items-center gap-2">
                    <i class="fa fa-shopping-cart"></i> Detail Pesanan
                </h3>
            </div>
            <form action="{{ route('admin.retail.process') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="product_id" id="selected_product_id">
                
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Produk Terpilih</label>
                        <input type="text" id="display_product_name" class="w-full bg-gray-50 border-gray-200 rounded-lg font-bold text-slate-700" readonly placeholder="Klik 'Pilih' di tabel">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Jumlah (Qty)</label>
                            <input type="number" name="qty" id="input_qty" min="1" value="1" oninput="calculateTotal()" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-bold">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Harga Satuan</label>
                            <input type="text" id="display_price" class="w-full bg-gray-50 border-gray-200 rounded-lg text-sm" readonly value="0">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-gray-500 font-medium">Total Bayar:</span>
                            <span class="text-2xl font-black text-slate-900" id="display_total">Rp 0</span>
                        </div>

                        <button type="submit" id="btn_submit" disabled class="w-full bg-slate-400 text-white font-bold py-3 rounded-xl shadow-md transition cursor-not-allowed">
                            PROSES TRANSAKSI
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentPrice = 0;

    function selectProduct(id, name, price) {
        currentPrice = price;
        document.getElementById('selected_product_id').value = id;
        document.getElementById('display_product_name').value = name;
        document.getElementById('display_price').value = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
        
        // Aktifkan tombol
        const btn = document.getElementById('btn_submit');
        btn.disabled = false;
        btn.classList.remove('bg-slate-400', 'cursor-not-allowed');
        btn.classList.add('bg-green-600', 'hover:bg-green-700');

        calculateTotal();
    }

    function calculateTotal() {
        const qty = document.getElementById('input_qty').value;
        const total = currentPrice * qty;
        document.getElementById('display_total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endsection