@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">
                Data Produk
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Manajemen stok retail gym, suplemen, minuman, dan merchandise.
            </p>
        </div>

        <button onclick="openAddModal()"
            class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-slate-200">
            <i class="fas fa-plus-circle text-[11px]"></i>
            Tambah Produk
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">
                Total Produk
            </p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-2">
                {{ $products->total() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">
                Stok Menipis
            </p>
            <h3 class="text-2xl font-extrabold text-red-500 mt-2">
                {{ $products->where('stok', '<=', 5)->count() }}
            </h3>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">

        <!-- Table Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-800">
                    List Produk
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Semua data inventori retail gym.
                </p>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">
                            Produk
                        </th>

                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">
                            Harga
                        </th>

                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">
                            Stok
                        </th>

                        <th class="px-6 py-4 text-center text-[11px] uppercase tracking-widest font-bold text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-[11px] uppercase tracking-widest font-bold text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($products as $p)
                    <tr class="hover:bg-slate-50/70 transition-all">

                        <!-- Produk -->
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-box text-slate-500"></i>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-800 leading-tight">
                                        {{ $p->nama_produk }}
                                    </h4>

                                    <p class="text-xs text-slate-400 mt-1">
                                        ID Produk #{{ $p->id }}
                                    </p>
                                </div>

                            </div>
                        </td>

                        <!-- Harga -->
                        <td class="px-6 py-5">
                            <span class="font-extrabold text-slate-800">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </span>
                        </td>

                        <!-- Stok -->
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-700">
                                    {{ $p->stok }}
                                </span>

                                <span class="text-xs text-slate-400">
                                    pcs
                                </span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-5 text-center">

                            @if($p->stok <= 5)
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-circle text-[7px]"></i>
                                Menipis
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-circle text-[7px]"></i>
                                Aman
                            </span>
                            @endif

                        </td>

                        <!-- Action -->
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-2">

                                <button
                                    onclick="openEditProduct('{{ $p->id }}', '{{ $p->nama_produk }}', '{{ $p->harga }}', '{{ $p->stok }}')"
                                    class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-900 text-slate-600 hover:text-white transition-all flex items-center justify-center">
                                    <i class="fas fa-pen text-[12px]"></i>
                                </button>

                                @if(auth()->user()->role == 'owner')
                                <form action="{{ route('admin.data.products.delete', $p->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        data-confirm
                                        data-confirm-title="Hapus Produk?"
                                        data-confirm-desc="Data produk akan dihapus permanen dari sistem."
                                        data-confirm-type="danger"
                                        data-confirm-label="Ya, Hapus"
                                        class="w-10 h-10 rounded-xl bg-red-50 hover:bg-red-600 text-red-500 hover:text-white transition-all flex items-center justify-center">
                                        <i class="fas fa-trash text-[12px]"></i>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>

                    </tr>
                    @empty

                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-5">
                                    <i class="fas fa-box-open text-3xl text-slate-300"></i>
                                </div>

                                <h3 class="font-bold text-slate-700">
                                    Belum Ada Produk
                                </h3>

                                <p class="text-sm text-slate-400 mt-1">
                                    Tambahkan data produk baru untuk retail gym.
                                </p>
                            </div>
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-5 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="addModal"
    class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-100">
            <h3 class="text-xl font-extrabold text-slate-800">
                Tambah Produk
            </h3>

            <p class="text-sm text-slate-400 mt-1">
                Input produk retail baru.
            </p>
        </div>

        <form action="{{ route('admin.data.products.store') }}" method="POST">
            @csrf

            <div class="p-8 space-y-5">

                <div>
                    <label class="text-xs font-bold text-slate-500 block mb-2 uppercase tracking-wider">
                        Nama Produk
                    </label>

                    <input type="text"
                        name="nama_produk"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="text-xs font-bold text-slate-500 block mb-2 uppercase tracking-wider">
                            Harga
                        </label>

                        <input type="number"
                            name="harga"
                            required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500 block mb-2 uppercase tracking-wider">
                            Stok
                        </label>

                        <input type="number"
                            name="stok"
                            required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                </div>

            </div>

            <div class="px-8 py-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button"
                    onclick="closeAddModal()"
                    class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider transition-all">
                    Batal
                </button>

                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-bold uppercase tracking-wider transition-all">
                    Simpan Produk
                </button>
            </div>

        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="editModal"
    class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-100">
            <h3 class="text-xl font-extrabold text-slate-800">
                Edit Produk
            </h3>

            <p class="text-sm text-slate-400 mt-1">
                Update harga dan stok produk.
            </p>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-5">

                <div>
                    <label class="text-xs font-bold text-slate-500 block mb-2 uppercase tracking-wider">
                        Nama Produk
                    </label>

                    <input type="text"
                        name="nama_produk"
                        id="edit_nama"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="text-xs font-bold text-slate-500 block mb-2 uppercase tracking-wider">
                            Harga
                        </label>

                        <input type="number"
                            name="harga"
                            id="edit_harga"
                            required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500 block mb-2 uppercase tracking-wider">
                            Stok
                        </label>

                        <input type="number"
                            name="stok"
                            id="edit_stok"
                            required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                </div>

            </div>

            <div class="px-8 py-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button"
                    onclick="closeEditModal()"
                    class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider transition-all">
                    Batal
                </button>

                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-slate-900 text-white text-xs font-bold uppercase tracking-wider transition-all">
                    Update Produk
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function openEditProduct(id, nama, harga, stok) {
        const form = document.getElementById('editForm');

        form.action = `/admin/data/products/update/${id}`;

        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_stok').value = stok;

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection