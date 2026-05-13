@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">
                Riwayat Transaksi
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Semua histori transaksi gym dan retail.
            </p>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="flex flex-col sm:flex-row flex-wrap gap-3 w-full lg:w-auto">
            {{-- Search --}}
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari invoice / nama..."
                    class="w-full sm:w-[240px] bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
            </div>

            {{-- Category --}}
            <select name="category" class="bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
                <option value="">Semua Kategori</option>
                <option value="retail" {{ request('category') == 'retail' ? 'selected' : '' }}>Retail</option>
                <option value="activation" {{ request('category') == 'activation' ? 'selected' : '' }}>Aktivasi</option>
                <option value="monthly" {{ request('category') == 'monthly' ? 'selected' : '' }}>Membership</option>
                <option value="pt" {{ request('category') == 'pt' ? 'selected' : '' }}>Personal Trainer</option>
                <option value="visit" {{ request('category') == 'visit' ? 'selected' : '' }}>Visit Harian</option>
            </select>

            {{-- Source --}}
            <select name="source" class="bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
                <option value="">Semua Source</option>
                <option value="onsite" {{ request('source') == 'onsite' ? 'selected' : '' }}>Onsite</option>
                <option value="online" {{ request('source') == 'online' ? 'selected' : '' }}>Online</option>
            </select>

            {{-- Status --}}
            <select name="status" class="bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
                <option value="">Semua Status</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            {{-- Submit --}}
            <button type="submit" class="bg-slate-900 hover:bg-blue-600 text-white px-5 py-3 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                Filter
            </button>
        </form>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Total Transaksi</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ $transactions->total() }}</h3>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Retail</p>
            <h3 class="text-2xl font-extrabold text-blue-600 mt-2">{{ $transactions->where('category', 'retail')->count() }}</h3>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Membership</p>
            <h3 class="text-2xl font-extrabold text-emerald-600 mt-2">{{ $transactions->where('category', 'monthly')->count() }}</h3>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-400">Pending</p>
            <h3 class="text-2xl font-extrabold text-amber-500 mt-2">{{ $transactions->where('status', 'pending')->count() }}</h3>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800">List Transaksi</h3>
                <p class="text-xs text-slate-400 mt-1">Histori pembayaran gym dan retail.</p>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Invoice</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Kategori</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Source</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Pembayaran</th>
                        <th class="px-6 py-4 text-left text-[11px] uppercase tracking-widest font-bold text-slate-500">Total</th>
                        <th class="px-6 py-4 text-center text-[11px] uppercase tracking-widest font-bold text-slate-500">Status</th>
                        <th class="px-6 py-4 text-right text-[11px] uppercase tracking-widest font-bold text-slate-500">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/70 transition-all">
                        {{-- Invoice --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $trx->invoice_code }}</h4>
                                <p class="text-xs text-slate-400 mt-1">{{ $trx->created_at->format('d M Y - H:i') }}</p>
                            </div>
                        </td>

                        {{-- Customer --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-semibold text-slate-700">{{ $trx->guest_name ?? $trx->user->name ?? '-' }}</h4>
                                <p class="text-xs text-slate-400 mt-1">Admin : {{ $trx->admin->name ?? '-' }}</p>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="px-6 py-5">
                            @php
                            $categoryColors = [
                            'retail' => 'bg-blue-100 text-blue-600',
                            'monthly' => 'bg-emerald-100 text-emerald-600',
                            'activation' => 'bg-purple-100 text-purple-600',
                            'visit' => 'bg-amber-100 text-amber-600',
                            'pt' => 'bg-pink-100 text-pink-600',
                            ];
                            @endphp

                            @php
                            $categoryLabels = [
                            'retail' => 'Retail',
                            'monthly' => 'Paket Bulanan',
                            'activation' => 'Aktivasi Member',
                            'visit' => 'Visit Harian',
                            'pt' => 'Paket PT',
                            ];
                            @endphp

                            <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $categoryColors[$trx->category] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $categoryLabels[$trx->category] ?? $trx->category }}
                            </span>
                        </td>

                        {{-- SOURCE --}}
                        <td class="px-6 py-5">
                            @if($trx->source == 'online')
                            <span class="px-3 py-1.5 rounded-full bg-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider">
                                Online
                            </span>
                            @else
                            <span class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">
                                Onsite
                            </span>
                            @endif
                        </td>

                        {{-- Payment --}}
                        <td class="px-6 py-5">
                            <div>
                                <h4 class="font-semibold text-slate-700 uppercase">{{ $trx->payment_method }}</h4>
                            </div>
                        </td>

                        {{-- Amount --}}
                        <td class="px-6 py-5">
                            <h4 class="font-extrabold text-slate-800">Rp {{ number_format($trx->amount, 0, ',', '.') }}</h4>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-5 text-center">
                            @if($trx->status == 'success')
                            <span class="px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                                Success
                            </span>
                            @elseif($trx->status == 'pending')
                            <span class="px-3 py-1.5 rounded-full bg-amber-100 text-amber-600 text-[10px] font-bold uppercase tracking-wider">
                                Pending
                            </span>
                            @elseif($trx->status == 'rejected')
                            <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider">
                                Rejected
                            </span>
                            @else
                            <span class="px-3 py-1.5 rounded-full bg-slate-200 text-slate-700 text-[10px] font-bold uppercase tracking-wider">
                                Cancelled
                            </span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="px-6 py-5">
                            <div class="flex justify-end">
                                @if($trx->category == 'retail' || $trx->source == 'online')
                                <button onclick="openDetailModal({{ $trx->id }})"
                                    class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-600 transition-all flex items-center justify-center">
                                    <i class="fas fa-eye text-[12px]"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- DATA --}}
                    <script>
                        window['trx_{{ $trx->id }}'] = {
                            invoice: "{{ $trx->invoice_code }}",
                            customer: "{{ $trx->guest_name ?? $trx->user->name ?? '-' }}",
                            category: "{{ $trx->category }}",
                            source: "{{ $trx->source }}",
                            payment: "{{ $trx->payment_method }}",
                            status: "{{ $trx->status }}",
                            total: "{{ number_format($trx->amount, 0, ',', '.') }}",
                            sender_bank: "{{ $trx->sender_bank ?? '-' }}",
                            sender_account: "{{ $trx->sender_account ?? '-' }}",
                            rejection_reason: "{{ $trx->rejection_reason ?? '-' }}",
                            proof: "{{ $trx->proof_attachment ? asset('storage/'.$trx->proof_attachment) : '' }}",
                           items: [
    @foreach($trx->items as $item)
    {
        product: "{{ $item->product->nama_produk ?? '-' }}",
        qty: "{{ $item->qty }}",
        subtotal: "{{ number_format($item->subtotal, 0, ',', '.') }}"
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
]
                        };
                    </script>
                    @empty
                    <tr>
                        <td colspan="8" class="py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-5">
                                    <i class="fas fa-receipt text-3xl text-slate-300"></i>
                                </div>
                                <h3 class="font-bold text-slate-700">Belum Ada Transaksi</h3>
                                <p class="text-sm text-slate-400 mt-1">Histori transaksi akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-5 border-t border-slate-100">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- MODAL --}}
<div id="detailModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[70] flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden">
        {{-- HEADER --}}
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-extrabold text-slate-800">Detail Transaksi</h3>
                <p class="text-sm text-slate-400 mt-1" id="modal_invoice">-</p>
            </div>
            <button onclick="closeDetailModal()" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div class="p-8 space-y-6">
            {{-- INFO --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Pelanggan</p>
                    <h4 id="modal_customer" class="font-bold text-slate-800">-</h4>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Kategori</p>
                    <h4 id="modal_category" class="font-bold text-slate-800 uppercase">-</h4>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Source</p>
                    <h4 id="modal_source" class="font-bold text-slate-800 uppercase">-</h4>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Payment</p>
                    <h4 id="modal_payment" class="font-bold text-slate-800 uppercase">-</h4>
                </div>
            </div>

            {{-- RETAIL ITEMS --}}
            <div id="modal_items_wrapper">
                <div class="mb-3">
                    <h4 class="font-bold text-slate-700">Detail Item</h4>
                </div>
                <div class="space-y-3" id="modal_items"></div>
            </div>

            {{-- ONLINE INFO --}}
            <div id="modal_online" class="hidden">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-xs text-slate-400 mb-1">Bank Pengirim</p>
                        <h4 id="modal_bank" class="font-bold text-slate-800">-</h4>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-xs text-slate-400 mb-1">Nama Pengirim</p>
                        <h4 id="modal_sender" class="font-bold text-slate-800">-</h4>
                    </div>
                </div>
                {{-- Bukti --}}
                <div class="mt-5" id="proof_wrapper">
                    <p class="text-xs text-slate-400 mb-2">Bukti Transfer</p>
                    <img id="modal_proof" src="" class="w-full rounded-2xl border border-slate-200 object-cover">
                </div>
            </div>

            {{-- REJECT --}}
            <div id="modal_reject" class="hidden bg-red-50 border border-red-100 rounded-2xl p-4">
                <p class="text-xs text-red-400 uppercase tracking-widest font-bold mb-2">Alasan Rejected</p>
                <p id="modal_reject_reason" class="text-sm text-red-600 font-medium">-</p>
            </div>

            {{-- TOTAL --}}
            <div class="bg-slate-900 rounded-3xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Total Pembayaran</p>
                    <h3 class="text-2xl font-extrabold text-white mt-1">Rp <span id="modal_total">0</span></h3>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-red-500/15 flex items-center justify-center">
                    <i class="fas fa-wallet text-red-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openDetailModal(id) {
        const trx = window['trx_' + id];
        document.getElementById('detailModal').classList.remove('hidden');

        document.getElementById('modal_invoice').innerText = trx.invoice;
        document.getElementById('modal_customer').innerText = trx.customer;
        document.getElementById('modal_category').innerText = trx.category;
        document.getElementById('modal_source').innerText = trx.source;
        document.getElementById('modal_payment').innerText = trx.payment;
        document.getElementById('modal_total').innerText = trx.total;

        // RETAIL ITEMS
        let html = '';
        trx.items.forEach(item => {
            html += `
            <div class="bg-slate-50 rounded-2xl p-4 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-slate-800">${item.product}</h4>
                    <p class="text-xs text-slate-400 mt-1">Qty : ${item.qty}</p>
                </div>
                <h5 class="font-extrabold text-blue-600">Rp ${item.subtotal}</h5>
            </div>
        `;
        });
        document.getElementById('modal_items').innerHTML = html;

        if (trx.category === 'retail') {
            document.getElementById('modal_items_wrapper').classList.remove('hidden');
        } else {
            document.getElementById('modal_items_wrapper').classList.add('hidden');
        }

        // ONLINE
        if (trx.source === 'online') {
            document.getElementById('modal_online').classList.remove('hidden');
            document.getElementById('modal_bank').innerText = trx.sender_bank;
            document.getElementById('modal_sender').innerText = trx.sender_account;

            if (trx.proof !== '') {
                document.getElementById('proof_wrapper').classList.remove('hidden');
                document.getElementById('modal_proof').src = trx.proof;
            } else {
                document.getElementById('proof_wrapper').classList.add('hidden');
            }
        } else {
            document.getElementById('modal_online').classList.add('hidden');
        }

        // REJECT
        if (trx.status === 'rejected') {
            document.getElementById('modal_reject').classList.remove('hidden');
            document.getElementById('modal_reject_reason').innerText = trx.rejection_reason;
        } else {
            document.getElementById('modal_reject').classList.add('hidden');
        }
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection