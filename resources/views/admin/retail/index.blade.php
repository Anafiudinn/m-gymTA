@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">
                Kasir Retail
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Penjualan minuman, suplemen, dan merchandise gym.
            </p>
        </div>

        <!-- Search -->
        <div class="relative w-full lg:w-[320px]">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

            <input type="text"
                id="searchProduct"
                placeholder="Cari produk..."
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
        </div>
    </div>

    <!-- Main -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        <!-- PRODUCT LIST -->
        <div class="xl:col-span-8">

            <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">

                <!-- top -->
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800">
                            Produk Retail
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Klik produk untuk menambahkan ke transaksi.
                        </p>
                    </div>

                    <div class="hidden md:flex items-center gap-2 bg-slate-100 px-3 py-2 rounded-xl">
                        <i class="fas fa-box text-slate-500 text-xs"></i>

                        <span class="text-xs font-bold text-slate-600">
                            {{ count($products) }} Produk
                        </span>
                    </div>
                </div>

                <!-- product list -->
                <div class="p-4 max-h-[72vh] overflow-y-auto">

                    <div class="space-y-3" id="productWrapper">

                        @foreach($products as $p)
                        <div
                            class="product-item group bg-slate-50 hover:bg-white border border-slate-100 hover:border-blue-200 rounded-2xl p-4 transition-all duration-200 hover:shadow-md cursor-pointer"
                            data-name="{{ strtolower($p->nama_produk) }}"
                            onclick="selectProduct('{{ $p->id }}', '{{ $p->nama_produk }}', '{{ $p->harga }}', '{{ $p->stok }}', this)">

                            <div class="flex items-center justify-between gap-4">

                                <!-- left -->
                                <div class="flex items-center gap-4 min-w-0">

                                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center group-hover:bg-blue-50 transition">
                                        <i class="fas fa-box text-slate-400 group-hover:text-blue-500 transition"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 truncate">
                                            {{ $p->nama_produk }}
                                        </h4>

                                        <div class="flex items-center gap-2 mt-1 flex-wrap">

                                            <span class="text-blue-600 font-extrabold text-sm">
                                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                                            </span>

                                            @if($p->stok <= 5)
                                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider">
                                                Stok Menipis
                                            </span>
                                            @else
                                            <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                                                Ready
                                            </span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <!-- right -->
                                <div class="text-right flex-shrink-0">
                                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                                        Stok
                                    </p>

                                    <h5 class="font-extrabold text-slate-700">
                                        {{ $p->stok }}
                                    </h5>
                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>

        <!-- ORDER -->
        <div class="xl:col-span-4">

            <div class="sticky top-6">

                <div class="bg-slate-900 rounded-3xl overflow-hidden shadow-2xl shadow-slate-300">

                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-white/10">
                        <div class="flex items-center justify-between">

                            <div>
                                <h3 class="font-extrabold text-white text-lg">
                                    Detail Order
                                </h3>

                                <p class="text-xs text-slate-400 mt-1">
                                    Transaksi retail kasir.
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-2xl bg-red-500/15 flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-red-400"></i>
                            </div>

                        </div>
                    </div>

                  <form action="{{ route('admin.retail.store') }}" method="POST" id="retailForm">
    @csrf

    <div class="p-6 space-y-6">

        <!-- CART -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-bold text-white">
                    Keranjang
                </h4>

                <span id="cart_count"
                    class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                    0 Item
                </span>
            </div>

            <div id="cart_items"
                class="space-y-3 max-h-[320px] overflow-y-auto pr-1">

                <!-- ITEM -->
                <div class="text-center py-10 text-slate-500 text-sm italic">
                    Belum ada produk dipilih
                </div>

            </div>
        </div>

        <!-- TOTAL -->
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-5">

            <p class="text-[10px] uppercase tracking-widest text-blue-100 font-bold mb-2">
                Total Pembayaran
            </p>

            <h2 id="display_total"
                class="text-3xl font-black text-white tracking-tight">
                Rp 0
            </h2>

        </div>

        <!-- hidden input -->
        <div id="hidden_inputs"></div>

        <!-- submit -->
        <button type="submit"
            id="btn_submit"
            disabled
            class="w-full py-4 rounded-2xl bg-red-600 hover:bg-red-700 disabled:bg-slate-800 disabled:text-slate-600 text-white font-black text-xs uppercase tracking-[0.2em] transition-all">
            Proses Transaksi
        </button>

    </div>
</form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

    let cart = [];

    function selectProduct(id, nama, harga, stok, element) {

        harga = parseInt(harga);
        stok  = parseInt(stok);

        const existing = cart.find(item => item.id == id);

        if(existing){

            if(existing.qty < stok){
                existing.qty += 1;
            }

        } else {

            cart.push({
                id,
                nama,
                harga,
                stok,
                qty : 1
            });

        }

        renderCart();
    }

    function renderCart(){

        const cartItems   = document.getElementById('cart_items');
        const totalText   = document.getElementById('display_total');
        const hiddenInput = document.getElementById('hidden_inputs');
        const cartCount   = document.getElementById('cart_count');

        cartItems.innerHTML = '';
        hiddenInput.innerHTML = '';

        let total = 0;

        if(cart.length == 0){

            cartItems.innerHTML = `
                <div class="text-center py-10 text-slate-500 text-sm italic">
                    Belum ada produk dipilih
                </div>
            `;

            totalText.innerText = 'Rp 0';

            document.getElementById('btn_submit').disabled = true;

            cartCount.innerText = '0 Item';

            return;
        }

        document.getElementById('btn_submit').disabled = false;

        cart.forEach((item,index)=>{

            const subtotal = item.harga * item.qty;

            total += subtotal;

            cartItems.innerHTML += `
                <div class="bg-slate-800 rounded-2xl p-4">

                    <div class="flex justify-between gap-3">

                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-white truncate">
                                ${item.nama}
                            </h4>

                            <p class="text-xs text-slate-400 mt-1">
                                Rp ${new Intl.NumberFormat('id-ID').format(item.harga)}
                            </p>
                        </div>

                        <button type="button"
                            onclick="removeItem(${index})"
                            class="text-red-400 hover:text-red-500">
                            <i class="fas fa-trash"></i>
                        </button>

                    </div>

                    <div class="flex items-center justify-between mt-4">

                        <div class="flex items-center bg-slate-700 rounded-xl overflow-hidden">

                            <button type="button"
                                onclick="decreaseQty(${index})"
                                class="w-9 h-9 text-slate-300 hover:bg-slate-600">
                                -
                            </button>

                            <div class="w-10 text-center text-white font-bold text-sm">
                                ${item.qty}
                            </div>

                            <button type="button"
                                onclick="increaseQty(${index})"
                                class="w-9 h-9 text-slate-300 hover:bg-slate-600">
                                +
                            </button>

                        </div>

                        <h5 class="text-red-400 font-black text-sm">
                            Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}
                        </h5>

                    </div>

                </div>
            `;

            hiddenInput.innerHTML += `
                <input type="hidden" name="products[${index}][id]" value="${item.id}">
                <input type="hidden" name="products[${index}][qty]" value="${item.qty}">
            `;
        });

        totalText.innerText =
            'Rp ' + new Intl.NumberFormat('id-ID').format(total);

        cartCount.innerText =
            cart.length + ' Item';
    }

    function increaseQty(index){

        if(cart[index].qty < cart[index].stok){
            cart[index].qty++;
        }

        renderCart();
    }

    function decreaseQty(index){

        if(cart[index].qty > 1){

            cart[index].qty--;

        } else {

            cart.splice(index,1);

        }

        renderCart();
    }

    function removeItem(index){

        cart.splice(index,1);

        renderCart();
    }

</script>
@endsection