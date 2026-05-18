@extends('layouts.owner')

@section('title', 'Laporan Transaksi')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- HEADER --}}
    <div>
        <h1 style="font-size:22px; font-weight:700; color:#111;">Laporan Transaksi</h1>
        <p style="font-size:13px; color:#999; margin-top:4px;">Monitoring pemasukan gym, membership, PT, visit, dan penjualan produk.</p>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="card" style="padding:18px 22px;">
        @php $inputStyle = "width:100%; border:1px solid var(--border); border-radius:1px; padding:10px 14px; font-size:13px; font-family:'Outfit',sans-serif; outline:none; color:#111; background:#fafafa; transition:.15s;"; @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Tanggal Mulai</label>
                <input type="date" name="start_date"
                       value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Tanggal Selesai</label>
                <input type="date" name="end_date"
                       value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Jenis Transaksi</label>
                <select name="category" style="{{ $inputStyle }} appearance:none; cursor:pointer;"
                        onfocus="this.style.borderColor='var(--red)'"
                        onblur="this.style.borderColor='var(--border)'">
                    <option value="">Semua Transaksi</option>
                    <option value="activation" {{ $category == 'activation' ? 'selected' : '' }}>Aktivasi Member</option>
                    <option value="monthly"    {{ $category == 'monthly'    ? 'selected' : '' }}>Membership Bulanan</option>
                    <option value="pt"         {{ $category == 'pt'         ? 'selected' : '' }}>Paket PT</option>
                    <option value="visit"      {{ $category == 'visit'      ? 'selected' : '' }}>Visit Harian</option>
                    <option value="retail"     {{ $category == 'retail'     ? 'selected' : '' }}>Penjualan Produk</option>
                </select>
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Metode Pembayaran</label>
                <select name="payment_method" style="{{ $inputStyle }} appearance:none; cursor:pointer;"
                        onfocus="this.style.borderColor='var(--red)'"
                        onblur="this.style.borderColor='var(--border)'">
                    <option value="">Semua Metode</option>
                    <option value="cash"     {{ $paymentMethod == 'cash'     ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ $paymentMethod == 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
            </div>

            <div style="display:flex; align-items:flex-end;">
                <button type="submit"
                        style="width:100%; background:var(--red); color:#fff; border:none; padding:10px 18px; border-radius:1px; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.18s; display:flex; align-items:center; justify-content:center; gap:6px;"
                        onmouseover="this.style.background='var(--red-dark)'"
                        onmouseout="this.style.background='var(--red)'">
                    <i class="fa-solid fa-filter"></i> Filter Data
                </button>
            </div>

        </div>
    </form>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-money-bill-wave" style="color:#555; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Pemasukan</div>
                <div style="font-size:18px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-receipt" style="color:#555; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Transaksi</div>
                <div style="font-size:28px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">{{ $totalTransactions }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-money-bill" style="color:#16a34a; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Cash</div>
                <div style="font-size:18px; font-weight:800; color:#16a34a; line-height:1.2; margin-top:2px;">Rp {{ number_format($cashIncome, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-building-columns" style="color:#1d4ed8; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Transfer</div>
                <div style="font-size:18px; font-weight:800; color:#1d4ed8; line-height:1.2; margin-top:2px;">Rp {{ number_format($transferIncome, 0, ',', '.') }}</div>
            </div>
        </div>

    </div>

    {{-- EXPORT --}}
    <div style="display:flex; flex-wrap:wrap; gap:10px;">
        <a href="{{ route('owner.reports.transactions.export.excel', request()->query()) }}"
           style="display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:1px; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; font-size:13px; font-weight:700; text-decoration:none; transition:.15s;"
           onmouseover="this.style.background='#dcfce7'"
           onmouseout="this.style.background='#f0fdf4'">
            <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('owner.reports.transactions.export.pdf', request()->query()) }}"
           style="display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:1px; background:#fff1f2; color:#be123c; border:1px solid #fecdd3; font-size:13px; font-weight:700; text-decoration:none; transition:.15s;"
           onmouseover="this.style.background='#ffe4e6'"
           onmouseout="this.style.background='#fff1f2'">
            <i class="fa-solid fa-file-pdf"></i> Export PDF
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card" style="padding:0; overflow:hidden;">

        <div style="padding:18px 22px; border-bottom:1px solid var(--border);">
            <div style="font-size:14px; font-weight:700; color:#111;">
                <i class="fa-solid fa-table-list" style="color:var(--red); margin-right:8px;"></i>Riwayat Transaksi
            </div>
            <div style="font-size:12px; color:#aaa; margin-top:3px;">Semua transaksi yang tercatat di sistem</div>
        </div>

        @if($transactions->count() == 0)
            <div style="padding:56px; text-align:center; color:#bbb; font-size:14px;">
                <i class="fa-solid fa-file-invoice" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
                Belum ada data transaksi
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9f9f9;">
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Member</th>
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Jenis</th>
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Source</th>
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Bayar</th>
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Nominal</th>
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Admin</th>
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Waktu</th>
                            <th style="padding:12px 18px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Status</th>
                            <th style="padding:12px 18px; text-align:right; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                        @php
                            $categoryLabel = match($trx->category) {
                                'activation' => 'Aktivasi Member',
                                'monthly'    => 'Membership Bulanan',
                                'pt'         => 'Paket PT',
                                'visit'      => 'Visit Harian',
                                'retail'     => 'Penjualan Produk',
                                default      => ucfirst($trx->category),
                            };
                        @endphp
                        <tr style="border-top:1px solid var(--border); transition:.15s;"
                            onmouseover="this.style.background='#fafafa'"
                            onmouseout="this.style.background='transparent'">

                            <td style="padding:13px 18px;">
                                <div style="font-size:13px; font-weight:600; color:#111;">{{ $trx->guest_name ?? $trx->user->name ?? '-' }}</div>
                                <div style="font-size:11px; color:#bbb; margin-top:2px;">{{ $trx->user->member_code ?? 'Non Member' }}</div>
                            </td>

                            <td style="padding:13px 18px;">
                                <div style="font-size:13px; font-weight:600; color:#111;">{{ $categoryLabel }}</div>
                                @if($trx->category == 'pt' && $trx->ptPackage)
                                    <div style="font-size:11px; color:#aaa; margin-top:2px;">{{ $trx->ptPackage->nama_paket }}</div>
                                @endif
                            </td>

                            <td style="padding:13px 18px;">
                                @if($trx->source == 'online')
                                    <span style="display:inline-flex; align-items:center; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">Online</span>
                                @else
                                    <span style="display:inline-flex; align-items:center; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#fff7ed; color:#c2410c; border:1px solid #fed7aa;">Onsite</span>
                                @endif
                            </td>

                            <td style="padding:13px 18px;">
                                @if($trx->payment_method == 'cash')
                                    <span style="display:inline-flex; align-items:center; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">Cash</span>
                                @else
                                    <span style="display:inline-flex; align-items:center; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">Transfer</span>
                                @endif
                            </td>

                            <td style="padding:13px 18px; font-size:14px; font-weight:700; color:#111;">
                                Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>

                            <td style="padding:13px 18px; font-size:13px; color:#555;">{{ $trx->admin->name ?? '-' }}</td>

                            <td style="padding:13px 18px;">
                                <div style="font-size:13px; color:#555;">{{ $trx->created_at->format('d M Y') }}</div>
                                <div style="font-size:11px; color:#bbb; margin-top:2px;">{{ $trx->created_at->format('H:i') }}</div>
                            </td>

                            <td style="padding:13px 18px;">
                                @if($trx->status == 'success')
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                                        <span style="width:5px;height:5px;border-radius:999px;background:#16a34a;"></span> Berhasil
                                    </span>
                                @elseif($trx->status == 'pending')
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#fefce8; color:#a16207; border:1px solid #fde68a;">
                                        <span style="width:5px;height:5px;border-radius:999px;background:#ca8a04;"></span> Pending
                                    </span>
                                @elseif($trx->status == 'rejected')
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#fff1f2; color:#be123c; border:1px solid #fecdd3;">
                                        <span style="width:5px;height:5px;border-radius:999px;background:var(--red);"></span> Ditolak
                                    </span>
                                @else
                                    <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; background:#f5f5f5; color:#999; border:1px solid #e5e5e5;">
                                        Cancel
                                    </span>
                                @endif
                            </td>

                            <td style="padding:13px 18px; text-align:right;">
                                @php
                                    $modalData = [
                                        'invoice'     => $trx->invoice_code,
                                        'member'      => $trx->guest_name ?? $trx->user->name ?? '-',
                                        'member_code' => $trx->user->member_code ?? 'Non Member',
                                        'category'    => $categoryLabel,
                                        'amount'      => number_format($trx->amount, 0, ',', '.'),
                                        'payment'     => ucfirst($trx->payment_method),
                                        'source'      => ucfirst($trx->source),
                                        'status'      => ucfirst($trx->status),
                                        'bank'        => $trx->sender_bank ?? '-',
                                        'sender'      => $trx->sender_account ?? '-',
                                        'proof'       => $trx->proof_attachment ? asset('storage/'.$trx->proof_attachment) : null,
                                        'package'     => $trx->ptPackage->nama_paket ?? '-',
                                        'items'       => [],
                                    ];
                                    if($trx->transactionItems) {
                                        foreach($trx->transactionItems as $item) {
                                            $modalData['items'][] = [
                                                'name'     => $item->product->nama_produk ?? '-',
                                                'qty'      => $item->qty,
                                                'subtotal' => number_format($item->subtotal, 0, ',', '.'),
                                            ];
                                        }
                                    }
                                @endphp
                                <button onclick='openTransactionModal(@json($modalData))'
                                        style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:1px; background:rgba(0,0,0,.05); color:#111; font-size:12px; font-weight:700; border:1px solid var(--border); cursor:pointer; transition:.15s; font-family:'Outfit',sans-serif;"
                                        onmouseover="this.style.background='rgba(0,0,0,.09)'"
                                        onmouseout="this.style.background='rgba(0,0,0,.05)'">
                                    <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i> Detail
                                </button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 22px; border-top:1px solid var(--border);">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</div>

{{-- MODAL --}}
<div id="transactionModal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,.35); backdrop-filter:blur(4px);">

    <div style="background:#fff; width:100%; max-width:640px; border-radius:1px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.12);">

        <div style="display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid var(--border);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-receipt" style="color:#fff; font-size:13px;"></i>
                </div>
                <span style="font-size:16px; font-weight:800; color:#111;">Detail Transaksi</span>
            </div>
            <button onclick="closeTransactionModal()"
                    style="width:36px; height:36px; border-radius:1px; border:1px solid var(--border); background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#999; font-size:18px; transition:.15s;"
                    onmouseover="this.style.background='#f5f5f5'; this.style.color='#111'"
                    onmouseout="this.style.background='transparent'; this.style.color='#999'">×</button>
        </div>

        <div style="padding:22px; display:flex; flex-direction:column; gap:16px; max-height:80vh; overflow-y:auto;">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach([
                    ['modal_invoice',  'Invoice'],
                    ['modal_member',   'Member'],
                    ['modal_category', 'Jenis Transaksi'],
                    ['modal_amount',   'Nominal'],
                    ['modal_payment',  'Metode Pembayaran'],
                    ['modal_source',   'Source'],
                    ['modal_status',   'Status'],
                    ['modal_package',  'Paket PT'],
                    ['modal_bank',     'Bank Pengirim'],
                    ['modal_sender',   'Nama Rekening'],
                ] as [$id, $lbl])
                    <div style="background:#f9f9f9; border-radius:1px; padding:12px 14px;">
                        <div style="font-size:11px; color:#aaa; font-weight:600; text-transform:uppercase; letter-spacing:.08em; margin-bottom:5px;">{{ $lbl }}</div>
                        <div id="{{ $id }}" style="font-size:14px; font-weight:700; color:#111;"></div>
                    </div>
                @endforeach
            </div>

            <div id="modal_items_wrapper" class="hidden">
                <div style="font-size:13px; font-weight:700; color:#111; margin-bottom:10px;">Detail Produk</div>
                <div id="modal_items" style="display:flex; flex-direction:column; gap:8px;"></div>
            </div>

            <div id="modal_proof_wrapper" class="hidden">
                <div style="font-size:13px; font-weight:700; color:#111; margin-bottom:10px;">Bukti Transfer</div>
                <img id="modal_proof" src="" style="width:100%; border-radius:1px; border:1px solid var(--border);">
            </div>

        </div>
    </div>
</div>

<script>
    function openTransactionModal(data) {
        document.getElementById('modal_invoice').innerText  = data.invoice  ?? '-';
        document.getElementById('modal_member').innerText   = data.member   ?? '-';
        document.getElementById('modal_category').innerText = data.category ?? '-';
        document.getElementById('modal_amount').innerText   = 'Rp ' + (data.amount ?? '0');
        document.getElementById('modal_payment').innerText  = data.payment  ?? '-';
        document.getElementById('modal_source').innerText   = data.source   ?? '-';
        document.getElementById('modal_status').innerText   = data.status   ?? '-';

        const pkgWrap = document.getElementById('modal_package').parentElement;
        if(data.package && data.package !== '-') { pkgWrap.classList.remove('hidden'); document.getElementById('modal_package').innerText = data.package; }
        else pkgWrap.classList.add('hidden');

        const bankWrap   = document.getElementById('modal_bank').parentElement;
        const senderWrap = document.getElementById('modal_sender').parentElement;
        if(data.source === 'Online') {
            bankWrap.classList.remove('hidden'); senderWrap.classList.remove('hidden');
            document.getElementById('modal_bank').innerText   = data.bank   ?? '-';
            document.getElementById('modal_sender').innerText = data.sender ?? '-';
        } else { bankWrap.classList.add('hidden'); senderWrap.classList.add('hidden'); }

        const proofWrap = document.getElementById('modal_proof_wrapper');
        if(data.proof) { proofWrap.classList.remove('hidden'); document.getElementById('modal_proof').src = data.proof; }
        else proofWrap.classList.add('hidden');

        const itemsWrap = document.getElementById('modal_items_wrapper');
        const itemsCont = document.getElementById('modal_items');
        itemsCont.innerHTML = '';
        if(data.items && data.items.length > 0) {
            itemsWrap.classList.remove('hidden');
            data.items.forEach(item => {
                itemsCont.innerHTML += `
                    <div style="display:flex; align-items:center; justify-content:space-between; border:1px solid var(--border); border-radius:1px; padding:12px 14px; background:#fafafa;">
                        <div>
                            <div style="font-size:13px; font-weight:600; color:#111;">${item.name}</div>
                            <div style="font-size:11px; color:#aaa; margin-top:2px;">Qty: ${item.qty}</div>
                        </div>
                        <div style="font-size:14px; font-weight:700; color:#111;">Rp ${item.subtotal}</div>
                    </div>`;
            });
        } else itemsWrap.classList.add('hidden');

        const modal = document.getElementById('transactionModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeTransactionModal() {
        const modal = document.getElementById('transactionModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

@endsection