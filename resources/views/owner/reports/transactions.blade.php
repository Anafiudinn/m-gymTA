{{-- resources/views/owner/reports/transactions.blade.php --}}

@extends('layouts.owner')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Laporan Transaksi
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Monitoring pemasukan gym, membership, PT, visit, dan penjualan produk
        </p>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="bg-white border border-gray-100 rounded-2xl p-5 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">

            {{-- START DATE --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">
                    Tanggal Mulai
                </label>

                <input type="date"
                    name="start_date"
                    value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">
            </div>

            {{-- END DATE --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">
                    Tanggal Selesai
                </label>

                <input type="date"
                    name="end_date"
                    value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">
            </div>

            {{-- CATEGORY --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">
                    Jenis Transaksi
                </label>

                <select name="category"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">

                    <option value="">Semua Transaksi</option>

                    <option value="activation" {{ $category == 'activation' ? 'selected' : '' }}>
                        Aktivasi Member
                    </option>

                    <option value="monthly" {{ $category == 'monthly' ? 'selected' : '' }}>
                        Membership Bulanan
                    </option>

                    <option value="pt" {{ $category == 'pt' ? 'selected' : '' }}>
                        Paket PT
                    </option>

                    <option value="visit" {{ $category == 'visit' ? 'selected' : '' }}>
                        Visit Harian
                    </option>

                    <option value="retail" {{ $category == 'retail' ? 'selected' : '' }}>
                        Penjualan Produk
                    </option>

                </select>
            </div>

            {{-- PAYMENT --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">
                    Metode Pembayaran
                </label>

                <select name="payment_method"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-gray-400">

                    <option value="">Semua Metode</option>

                    <option value="cash" {{ $paymentMethod == 'cash' ? 'selected' : '' }}>
                        Cash
                    </option>

                    <option value="transfer" {{ $paymentMethod == 'transfer' ? 'selected' : '' }}>
                        Transfer
                    </option>

                </select>
            </div>

            {{-- BUTTON --}}
            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-black text-white text-sm font-medium py-2.5 rounded-xl transition">

                    Filter Data

                </button>
            </div>

        </div>

    </form>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">
                TOTAL PEMASUKAN
            </p>

            <h2 class="text-2xl font-bold text-gray-900">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">
                TOTAL TRANSAKSI
            </p>

            <h2 class="text-2xl font-bold text-gray-900">
                {{ $totalTransactions }}
            </h2>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">
                PEMBAYARAN CASH
            </p>

            <h2 class="text-2xl font-bold text-emerald-600">
                Rp {{ number_format($cashIncome, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-2">
                PEMBAYARAN TRANSFER
            </p>

            <h2 class="text-2xl font-bold text-blue-600">
                Rp {{ number_format($transferIncome, 0, ',', '.') }}
            </h2>
        </div>

    </div>

    {{-- EXPORT --}}
    <div class="flex flex-wrap gap-3 mb-6">

        <a href="{{ route('owner.reports.transactions.export.excel', request()->query()) }}"
            class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">

            Export Excel

        </a>

        <a href="{{ route('owner.reports.transactions.export.pdf', request()->query()) }}"
            class="inline-flex items-center px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition">

            Export PDF

        </a>

    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">

            <h2 class="font-semibold text-gray-900">
                Riwayat Transaksi
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                Semua transaksi yang tercatat di sistem
            </p>

        </div>

        @if($transactions->count() == 0)

        <div class="py-16 text-center text-gray-400 text-sm">
            Belum ada data transaksi
        </div>

        @else

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Member / Pelanggan
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Jenis Transaksi
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Source
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Pembayaran
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Nominal
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Admin
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Waktu
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach($transactions as $trx)

                    @php

                    $categoryLabel = match($trx->category) {
                    'activation' => 'Aktivasi Member',
                    'monthly' => 'Membership Bulanan',
                    'pt' => 'Paket PT',
                    'visit' => 'Visit Harian',
                    'retail' => 'Penjualan Produk',
                    default => ucfirst($trx->category),
                    };

                    @endphp

                    <tr class="hover:bg-gray-50 transition">

                        {{-- MEMBER --}}
                        <td class="px-5 py-4">

                            <div class="font-semibold text-gray-900 text-sm">
                                {{ $trx->guest_name ?? $trx->user->name ?? '-' }}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                {{ $trx->user->member_code ?? 'Non Member' }}
                            </div>

                        </td>

                        {{-- CATEGORY --}}
                        <td class="px-5 py-4">

                            <div class="font-semibold text-gray-900 text-sm">
                                {{ $categoryLabel }}
                            </div>

                            {{-- PT PACKAGE --}}
                            @if($trx->category == 'pt' && $trx->ptPackage)

                            <div class="text-xs text-gray-500 mt-1">
                                {{ $trx->ptPackage->nama_paket }}
                            </div>

                            @endif

                        </td>

                        {{-- SOURCE --}}
                        <td class="px-5 py-4">

                            @if($trx->source == 'online')

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                Online
                            </span>

                            @else

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                Onsite
                            </span>

                            @endif

                        </td>

                        {{-- PAYMENT --}}
                        <td class="px-5 py-4">

                            @if($trx->payment_method == 'cash')

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                Cash
                            </span>

                            @else

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                Transfer
                            </span>

                            @endif

                        </td>

                        {{-- AMOUNT --}}
                        <td class="px-5 py-4">

                            <div class="font-bold text-gray-900 text-sm">
                                Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </div>

                        </td>

                        {{-- ADMIN --}}
                        <td class="px-5 py-4 text-sm text-gray-700">
                            {{ $trx->admin->name ?? '-' }}
                        </td>

                        {{-- DATE --}}
                        <td class="px-5 py-4">

                            <div class="text-sm text-gray-700">
                                {{ $trx->created_at->format('d M Y') }}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                {{ $trx->created_at->format('H:i') }}
                            </div>

                        </td>

                        {{-- STATUS --}}
                        <td class="px-5 py-4">

                            @if($trx->status == 'success')

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                Berhasil
                            </span>

                            @elseif($trx->status == 'pending')

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                Pending
                            </span>

                            @elseif($trx->status == 'rejected')

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                Ditolak
                            </span>

                            @else

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                Cancel
                            </span>

                            @endif

                        </td>

                        {{-- ACTION --}}
                        {{-- ACTION --}}
                        <td class="px-5 py-4 text-right">

                            @php
                            $modalData = [
                            'invoice' => $trx->invoice_code,
                            'member' => $trx->guest_name ?? $trx->user->name ?? '-',
                            'member_code' => $trx->user->member_code ?? 'Non Member',
                            'category' => $categoryLabel,
                            'amount' => number_format($trx->amount, 0, ',', '.'),
                            'payment' => ucfirst($trx->payment_method),
                            'source' => ucfirst($trx->source),
                            'status' => ucfirst($trx->status),
                            'bank' => $trx->sender_bank ?? '-',
                            'sender' => $trx->sender_account ?? '-',
                            'proof' => $trx->proof_attachment
                            ? asset('storage/' . $trx->proof_attachment)
                            : null,
                            'package' => $trx->ptPackage->nama_paket ?? '-',
                            'items' => [],
                            ];

                            if ($trx->transactionItems) {
                            foreach ($trx->transactionItems as $item) {
                            $modalData['items'][] = [
                            'name' => $item->product->nama_produk ?? '-',
                            'qty' => $item->qty,
                            'subtotal' => number_format($item->subtotal, 0, ',', '.'),
                            ];
                            }
                            }
                            @endphp

                            <button
                                onclick='openTransactionModal(@json($modalData))'
                                class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-medium transition">

                                Detail

                            </button>

                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>

        @endif

    </div>

</div>

{{-- MODAL --}}
<div id="transactionModal"
    class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">

    <div class="bg-white w-full max-w-2xl rounded-3xl overflow-hidden">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">

            <h2 class="text-lg font-bold text-gray-900">
                Detail Transaksi
            </h2>

            <button onclick="closeTransactionModal()"
                class="text-gray-400 hover:text-black text-2xl">
                ×
            </button>

        </div>

        {{-- BODY --}}
        <div class="p-6 space-y-5 max-h-[80vh] overflow-y-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <p class="text-xs text-gray-500 mb-1">Invoice</p>
                    <h3 id="modal_invoice" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Member</p>
                    <h3 id="modal_member" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Jenis Transaksi</p>
                    <h3 id="modal_category" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Nominal</p>
                    <h3 id="modal_amount" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Metode Pembayaran</p>
                    <h3 id="modal_payment" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Source</p>
                    <h3 id="modal_source" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Status</p>
                    <h3 id="modal_status" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Paket PT</p>
                    <h3 id="modal_package" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Bank Pengirim</p>
                    <h3 id="modal_bank" class="font-semibold text-gray-900"></h3>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Nama Rekening</p>
                    <h3 id="modal_sender" class="font-semibold text-gray-900"></h3>
                </div>

            </div>

            {{-- RETAIL ITEMS --}}
            <div id="modal_items_wrapper" class="hidden">

                <p class="text-sm font-semibold text-gray-900 mb-3">
                    Detail Produk
                </p>

                <div id="modal_items"
                    class="space-y-2">
                </div>

            </div>

            {{-- PROOF --}}
            <div id="modal_proof_wrapper" class="hidden">

                <p class="text-sm font-semibold text-gray-900 mb-3">
                    Bukti Transfer
                </p>

                <img id="modal_proof"
                    src=""
                    class="w-full rounded-2xl border border-gray-200">

            </div>

        </div>

    </div>

</div>
<script>
    function openTransactionModal(data) {

        // =========================
        // BASIC
        // =========================
        document.getElementById('modal_invoice').innerText = data.invoice ?? '-';
        document.getElementById('modal_member').innerText = data.member ?? '-';
        document.getElementById('modal_category').innerText = data.category ?? '-';
        document.getElementById('modal_amount').innerText = 'Rp ' + (data.amount ?? '0');
        document.getElementById('modal_payment').innerText = data.payment ?? '-';
        document.getElementById('modal_source').innerText = data.source ?? '-';
        document.getElementById('modal_status').innerText = data.status ?? '-';

        // =========================
        // PT PACKAGE
        // =========================
        const packageWrapper = document.getElementById('modal_package').parentElement;

        if (data.package && data.package !== '-') {

            packageWrapper.classList.remove('hidden');

            document.getElementById('modal_package').innerText = data.package;

        } else {

            packageWrapper.classList.add('hidden');
        }

        // =========================
        // ONLINE PAYMENT
        // =========================
        const bankWrapper = document.getElementById('modal_bank').parentElement;
        const senderWrapper = document.getElementById('modal_sender').parentElement;

        if (data.source === 'Online') {

            bankWrapper.classList.remove('hidden');
            senderWrapper.classList.remove('hidden');

            document.getElementById('modal_bank').innerText = data.bank ?? '-';
            document.getElementById('modal_sender').innerText = data.sender ?? '-';

        } else {

            bankWrapper.classList.add('hidden');
            senderWrapper.classList.add('hidden');
        }

        // =========================
        // PROOF IMAGE
        // =========================
        const proofWrapper = document.getElementById('modal_proof_wrapper');

        if (data.proof) {

            proofWrapper.classList.remove('hidden');

            document.getElementById('modal_proof').src = data.proof;

        } else {

            proofWrapper.classList.add('hidden');
        }

        // =========================
        // RETAIL ITEMS
        // =========================
        const itemsWrapper = document.getElementById('modal_items_wrapper');
        const itemsContainer = document.getElementById('modal_items');

        itemsContainer.innerHTML = '';

        if (data.items && data.items.length > 0) {

            itemsWrapper.classList.remove('hidden');

            data.items.forEach(item => {

                itemsContainer.innerHTML += `
                    <div class="flex items-center justify-between border border-gray-100 rounded-xl px-4 py-3">
                        
                        <div>
                            <div class="text-sm font-semibold text-gray-900">
                                ${item.name}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                Qty: ${item.qty}
                            </div>
                        </div>

                        <div class="text-sm font-bold text-gray-900">
                            Rp ${item.subtotal}
                        </div>

                    </div>
                `;
            });

        } else {

            itemsWrapper.classList.add('hidden');
        }

        // =========================
        // OPEN MODAL
        // =========================
        document.getElementById('transactionModal')
            .classList.remove('hidden');

        document.getElementById('transactionModal')
            .classList.add('flex');
    }

    function closeTransactionModal() {

        document.getElementById('transactionModal')
            .classList.add('hidden');

        document.getElementById('transactionModal')
            .classList.remove('flex');
    }
</script>
@endsection