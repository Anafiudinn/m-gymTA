@extends('layouts.admin')

@section('title', 'Laporan Transaksi')
@section('header-title', 'Laporan Transaksi')

@section('content')

{{-- ═══ PAGE HEADER ═══ --}}
<div style="margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:var(--muted);margin-bottom:6px;">
        <i class="fa-solid fa-house" style="font-size:10px;"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;"></i>
        <span>Laporan</span>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;"></i>
        <span style="color:var(--text);font-weight:600;">Transaksi</span>
    </div>
    <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 2px;">Laporan Transaksi</h1>
    <p style="font-size:12px;color:var(--muted);margin:0;">Semua histori transaksi gym dan retail</p>
</div>

{{-- ═══ FILTER BAR ═══ --}}
<form method="GET" style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;margin-bottom:16px;display:flex;flex-wrap:wrap;gap:8px;align-items:center;">

    {{-- Search --}}
    <div style="position:relative;flex:1;min-width:180px;max-width:240px;">
        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:10px;color:var(--muted);pointer-events:none;"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice / nama..."
               style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:8px 12px 8px 30px;font-size:12.5px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
    </div>

    {{-- Kategori --}}
    <select name="category"
            style="border:1px solid var(--border);border-radius:var(--radius);padding:8px 12px;font-size:12.5px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;cursor:pointer;transition:border-color .15s,box-shadow .15s;"
            onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
            onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
        <option value="">Semua Kategori</option>
        <option value="retail"     {{ request('category')=='retail'     ? 'selected':'' }}>Retail</option>
        <option value="activation" {{ request('category')=='activation' ? 'selected':'' }}>Aktivasi</option>
        <option value="monthly"    {{ request('category')=='monthly'    ? 'selected':'' }}>Membership</option>
        <option value="pt"         {{ request('category')=='pt'         ? 'selected':'' }}>Personal Trainer</option>
        <option value="visit"      {{ request('category')=='visit'      ? 'selected':'' }}>Visit Harian</option>
    </select>

    {{-- Source --}}
    <select name="source"
            style="border:1px solid var(--border);border-radius:var(--radius);padding:8px 12px;font-size:12.5px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;cursor:pointer;transition:border-color .15s,box-shadow .15s;"
            onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
            onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
        <option value="">Semua Source</option>
        <option value="onsite" {{ request('source')=='onsite' ? 'selected':'' }}>Onsite</option>
        <option value="online" {{ request('source')=='online' ? 'selected':'' }}>Online</option>
    </select>

    {{-- Status --}}
    <select name="status"
            style="border:1px solid var(--border);border-radius:var(--radius);padding:8px 12px;font-size:12.5px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;cursor:pointer;transition:border-color .15s,box-shadow .15s;"
            onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
            onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
        <option value="">Semua Status</option>
        <option value="success"   {{ request('status')=='success'   ? 'selected':'' }}>Success</option>
        <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>Pending</option>
        <option value="rejected"  {{ request('status')=='rejected'  ? 'selected':'' }}>Rejected</option>
        <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>Cancelled</option>
    </select>

    {{-- Filter btn --}}
    <button type="submit"
        style="background:var(--text);color:#fff;font-weight:700;font-size:12px;padding:8px 16px;border-radius:var(--radius);border:none;cursor:pointer;font-family:'Outfit',sans-serif;transition:background .15s;white-space:nowrap;"
        onmouseover="this.style.background='#333'" onmouseout="this.style.background='var(--text)'">
        <i class="fa-solid fa-filter" style="font-size:10px;margin-right:5px;"></i> Filter
    </button>

    {{-- Spacer --}}
    <div style="flex:1;"></div>

    {{-- Export btns --}}
    <a href="{{ route('admin.report.transactions.excel', request()->query()) }}"
       style="display:inline-flex;align-items:center;gap:6px;background:rgba(34,197,94,.1);color:#15803d;border:1px solid rgba(34,197,94,.2);font-size:12px;font-weight:700;padding:8px 14px;border-radius:var(--radius);text-decoration:none;transition:background .15s;white-space:nowrap;"
       onmouseover="this.style.background='rgba(34,197,94,.18)'" onmouseout="this.style.background='rgba(34,197,94,.1)'">
        <i class="fa-solid fa-file-excel" style="font-size:11px;"></i> Excel
    </a>
    <a href="{{ route('admin.report.transactions.pdf', request()->query()) }}"
       style="display:inline-flex;align-items:center;gap:6px;background:rgba(239,68,68,.08);color:var(--red);border:1px solid rgba(239,68,68,.15);font-size:12px;font-weight:700;padding:8px 14px;border-radius:var(--radius);text-decoration:none;transition:background .15s;white-space:nowrap;"
       onmouseover="this.style.background='rgba(239,68,68,.14)'" onmouseout="this.style.background='rgba(239,68,68,.08)'">
        <i class="fa-solid fa-file-pdf" style="font-size:11px;"></i> PDF
    </a>
</form>

{{-- ═══ STAT CARDS ═══ --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px;">
    @php
        $statCards = [
            ['label'=>'Total Transaksi', 'val'=>$transactions->total(),                              'color'=>'var(--text)'],
            ['label'=>'Retail',          'val'=>$transactions->where('category','retail')->count(),   'color'=>'var(--text)'],
            ['label'=>'Membership',      'val'=>$transactions->where('category','monthly')->count(),  'color'=>'var(--text)'],
            ['label'=>'Pending',         'val'=>$transactions->where('status','pending')->count(),    'color'=>'var(--red)'],
        ];
    @endphp
    @foreach($statCards as $s)
    <div class="card" style="padding:16px;">
        <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin:0 0 8px;">{{ $s['label'] }}</p>
        <p style="font-size:24px;font-weight:800;color:{{ $s['color'] }};margin:0;">{{ $s['val'] }}</p>
    </div>
    @endforeach
</div>

{{-- ═══ TABLE CARD ═══ --}}
<div class="card" style="padding:0;overflow:hidden;">

    {{-- Card Header --}}
    <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
        <div>
            <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">List Transaksi</p>
            <p style="font-size:11px;color:var(--muted);margin:2px 0 0;">Histori pembayaran gym dan retail</p>
        </div>
        <span style="font-size:11px;font-weight:700;color:var(--muted);background:#fafafa;border:1px solid var(--border);padding:3px 10px;border-radius:999px;">
            {{ $transactions->total() }} total
        </span>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table style="width:100%;min-width:960px;border-collapse:collapse;">
            <thead>
                <tr style="background:#fafafa;border-bottom:1px solid var(--border);">
                    @foreach(['Invoice','Pelanggan','Kategori','Source','Pembayaran','Total','Status','Aksi'] as $th)
                    <th style="padding:11px 16px;text-align:{{ $th=='Aksi'?'center':'left' }};font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;">{{ $th }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)

                {{-- Simpan data ke JS --}}
                <script>
                window['trx_{{ $trx->id }}'] = {
                    invoice: "{{ $trx->invoice_code }}",
                    customer: "{{ addslashes($trx->guest_name ?? optional($trx->user)->name ?? '-') }}",
                    category: "{{ $trx->category }}",
                    detail: "{{ addslashes($trx->detail_label ?? '-') }}",
                    source: "{{ $trx->source }}",
                    payment: "{{ $trx->payment_method }}",
                    status: "{{ $trx->status }}",
                    total: "{{ number_format($trx->amount,0,',','.') }}",
                    sender_bank: "{{ addslashes($trx->sender_bank ?? '-') }}",
                    sender_account: "{{ addslashes($trx->sender_account ?? '-') }}",
                    rejection_reason: "{{ addslashes($trx->rejection_reason ?? '-') }}",
                    proof: "{{ $trx->proof_attachment ? asset('storage/'.$trx->proof_attachment) : '' }}",
                    items: [
                        @foreach($trx->items as $item)
                        {
                            product: "{{ addslashes($item->product->nama_produk ?? '-') }}",
                            qty: "{{ $item->qty }}",
                            subtotal: "{{ number_format($item->subtotal,0,',','.') }}"
                        }{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    ]
                };
                </script>

                <tr style="border-bottom:1px solid var(--border);transition:background .12s;"
                    onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">

                    {{-- Invoice --}}
                    <td style="padding:13px 16px;">
                        <p style="font-size:12.5px;font-weight:700;color:var(--text);margin:0;font-variant-numeric:tabular-nums;">{{ $trx->invoice_code }}</p>
                        <p style="font-size:10.5px;color:var(--muted);margin:2px 0 0;">{{ $trx->created_at->format('d M Y · H:i') }}</p>
                    </td>

                    {{-- Pelanggan --}}
                    <td style="padding:13px 16px;">
                        <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">
                            {{ $trx->guest_name ?? optional($trx->user)->name ?? '-' }}
                        </p>
                        <p style="font-size:10.5px;color:var(--muted);margin:2px 0 0;">{{ optional($trx->admin)->name ?? 'Admin' }}</p>
                    </td>

                    {{-- Kategori --}}
                    <td style="padding:13px 16px;">
                        @php
                            $catMap = [
                                'retail'     => 'Retail',
                                'monthly'    => 'Membership',
                                'activation' => 'Aktivasi',
                                'visit'      => 'Visit Harian',
                                'pt'         => 'Personal Trainer',
                            ];
                        @endphp
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;white-space:nowrap;background:rgba(239,68,68,.08);color:var(--red);">
                            {{ $catMap[$trx->category] ?? $trx->category }}
                        </span>
                    </td>

                    {{-- Source --}}
                    <td style="padding:13px 16px;">
                        @if($trx->source == 'online')
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:rgba(34,197,94,.1);color:#15803d;">Online</span>
                        @else
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:#fafafa;border:1px solid var(--border);color:var(--muted);">Onsite</span>
                        @endif
                    </td>

                    {{-- Pembayaran --}}
                    <td style="padding:13px 16px;">
                        <p style="font-size:12.5px;font-weight:700;color:var(--text);margin:0;text-transform:uppercase;">{{ $trx->payment_method }}</p>
                    </td>

                    {{-- Total --}}
                    <td style="padding:13px 16px;">
                        <p style="font-size:13px;font-weight:800;color:var(--text);margin:0;white-space:nowrap;">Rp {{ number_format($trx->amount,0,',','.') }}</p>
                    </td>

                    {{-- Status --}}
                    <td style="padding:13px 16px;">
                        @if($trx->status == 'success')
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:rgba(34,197,94,.1);color:#15803d;">Success</span>
                        @elseif($trx->status == 'pending')
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:rgba(245,158,11,.1);color:#b45309;">Pending</span>
                        @elseif($trx->status == 'rejected')
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:rgba(239,68,68,.08);color:var(--red);">Rejected</span>
                        @else
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:#fafafa;border:1px solid var(--border);color:var(--muted);">Cancelled</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td style="padding:13px 16px;text-align:center;">
                        <button onclick="openDetailModal({{ $trx->id }})"
                            style="width:32px;height:32px;border-radius:var(--radius);background:#fafafa;border:1px solid var(--border);color:var(--muted);cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:all .15s;font-size:11px;"
                            onmouseover="this.style.background='var(--red)';this.style.color='#fff';this.style.borderColor='var(--red)';"
                            onmouseout="this.style.background='#fafafa';this.style.color='var(--muted)';this.style.borderColor='var(--border)';">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:72px 24px;text-align:center;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:10px;">
                            <div style="width:44px;height:44px;border-radius:var(--radius);background:#fafafa;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-receipt" style="font-size:18px;color:#ddd;"></i>
                            </div>
                            <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">Belum Ada Transaksi</p>
                            <p style="font-size:12px;color:var(--muted);margin:0;">Histori transaksi akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="padding:14px 18px;border-top:1px solid var(--border);">
        {{ $transactions->withQueryString()->links() }}
    </div>

</div>

{{-- ═══════════════════════════════════════════
     DETAIL MODAL
═══════════════════════════════════════════ --}}
<div id="detailModal"
     style="display:none;position:fixed;inset:0;z-index:9000;background:rgba(0,0,0,.35);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;width:100%;max-width:580px;border-radius:var(--radius);border:1px solid var(--border);box-shadow:0 16px 48px rgba(0,0,0,.14);overflow:hidden;animation:alertIn .2s ease;">

        {{-- Modal Header --}}
        <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <div>
                <p style="font-size:14px;font-weight:800;color:var(--text);margin:0;">Detail Transaksi</p>
                <p id="modal_invoice" style="font-size:11.5px;color:var(--muted);margin:2px 0 0;font-variant-numeric:tabular-nums;">-</p>
            </div>
            <button onclick="closeDetailModal()"
                style="width:30px;height:30px;border-radius:var(--radius);background:#fafafa;border:1px solid var(--border);color:var(--muted);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:11px;transition:all .15s;"
                onmouseover="this.style.background='var(--red)';this.style.color='#fff';this.style.borderColor='var(--red)';"
                onmouseout="this.style.background='#fafafa';this.style.color='var(--muted)';this.style.borderColor='var(--border)';">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <div style="padding:18px 20px;display:flex;flex-direction:column;gap:14px;max-height:72vh;overflow-y:auto;">

            {{-- Info grid --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                @foreach([
                    ['id'=>'modal_customer', 'label'=>'Pelanggan'],
                    ['id'=>'modal_category', 'label'=>'Kategori'],
                    ['id'=>'modal_detail',   'label'=>'Detail Paket'],
                    ['id'=>'modal_source',   'label'=>'Source'],
                    ['id'=>'modal_payment',  'label'=>'Pembayaran'],
                ] as $f)
                <div style="background:#fafafa;border:1px solid var(--border);border-radius:var(--radius);padding:11px 13px;">
                    <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 3px;">{{ $f['label'] }}</p>
                    <p id="{{ $f['id'] }}" style="font-size:13px;font-weight:700;color:var(--text);margin:0;text-transform:uppercase;">-</p>
                </div>
                @endforeach
            </div>

            {{-- Retail items --}}
            <div id="modal_items_wrapper">
                <p style="font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 8px;">Detail Item</p>
                <div id="modal_items" style="display:flex;flex-direction:column;gap:6px;"></div>
            </div>

            {{-- Online info --}}
            <div id="modal_online" style="display:none;">
                <p style="font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 8px;">Info Transfer</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    <div style="background:#fafafa;border:1px solid var(--border);border-radius:var(--radius);padding:11px 13px;">
                        <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 3px;">Bank Pengirim</p>
                        <p id="modal_bank" style="font-size:13px;font-weight:700;color:var(--text);margin:0;">-</p>
                    </div>
                    <div style="background:#fafafa;border:1px solid var(--border);border-radius:var(--radius);padding:11px 13px;">
                        <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 3px;">Nama Pengirim</p>
                        <p id="modal_sender" style="font-size:13px;font-weight:700;color:var(--text);margin:0;">-</p>
                    </div>
                </div>
                <div id="proof_wrapper" style="margin-top:10px;">
                    <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 6px;">Bukti Transfer</p>
                    <img id="modal_proof" src="" style="width:100%;border-radius:var(--radius);border:1px solid var(--border);object-fit:cover;">
                </div>
            </div>

            {{-- Reject reason --}}
            <div id="modal_reject" style="display:none;background:#fafafa;border:1px solid var(--border);border-left:3px solid var(--red);border-radius:var(--radius);padding:12px 14px;">
                <p style="font-size:10px;font-weight:700;color:var(--red);text-transform:uppercase;letter-spacing:.07em;margin:0 0 5px;">Alasan Rejected</p>
                <p id="modal_reject_reason" style="font-size:12.5px;color:var(--text);margin:0;line-height:1.6;">-</p>
            </div>

            {{-- Total bar --}}
            <div style="background:var(--text);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p style="font-size:10px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.08em;margin:0 0 4px;">Total Pembayaran</p>
                    <p style="font-size:22px;font-weight:800;color:#fff;margin:0;">Rp <span id="modal_total">0</span></p>
                </div>
                <div style="width:42px;height:42px;border-radius:var(--radius);background:rgba(239,68,68,.15);display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-wallet" style="color:var(--red);font-size:16px;"></i>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
const _catLabels = {
    retail:     'Retail',
    monthly:    'Membership',
    activation: 'Aktivasi Member',
    visit:      'Visit Harian',
    pt:         'Personal Trainer'
};

function openDetailModal(id) {
    const trx = window['trx_' + id];
    if (!trx) return;

    const modal = document.getElementById('detailModal');
    modal.style.display = 'flex';

    document.getElementById('modal_invoice').innerText  = trx.invoice;
    document.getElementById('modal_customer').innerText = trx.customer;
    document.getElementById('modal_category').innerText = _catLabels[trx.category] || trx.category;
    document.getElementById('modal_detail').innerText   = trx.detail;
    document.getElementById('modal_source').innerText   = trx.source;
    document.getElementById('modal_payment').innerText  = trx.payment;
    document.getElementById('modal_total').innerText    = trx.total;

    // Retail items
    const itemsWrap = document.getElementById('modal_items_wrapper');
    const itemsBox  = document.getElementById('modal_items');
    if (trx.category === 'retail' && trx.items && trx.items.length) {
        let html = '';
        trx.items.forEach(item => {
            html += `
            <div style="background:#fafafa;border:1px solid var(--border);border-radius:var(--radius);padding:11px 13px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">${item.product}</p>
                    <p style="font-size:11px;color:var(--muted);margin:2px 0 0;">Qty: ${item.qty}</p>
                </div>
                <p style="font-size:13px;font-weight:800;color:var(--text);margin:0;white-space:nowrap;">Rp ${item.subtotal}</p>
            </div>`;
        });
        itemsBox.innerHTML = html;
        itemsWrap.style.display = 'block';
    } else {
        itemsWrap.style.display = 'none';
    }

    // Online info
    const onlineDiv = document.getElementById('modal_online');
    if (trx.source === 'online') {
        onlineDiv.style.display = 'block';
        document.getElementById('modal_bank').innerText   = trx.sender_bank;
        document.getElementById('modal_sender').innerText = trx.sender_account;
        const proofWrap = document.getElementById('proof_wrapper');
        if (trx.proof) {
            document.getElementById('modal_proof').src = trx.proof;
            proofWrap.style.display = 'block';
        } else {
            proofWrap.style.display = 'none';
        }
    } else {
        onlineDiv.style.display = 'none';
    }

    // Reject reason
    const rejectDiv = document.getElementById('modal_reject');
    if (trx.status === 'rejected') {
        rejectDiv.style.display = 'block';
        document.getElementById('modal_reject_reason').innerText = trx.rejection_reason;
    } else {
        rejectDiv.style.display = 'none';
    }
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

// Close on backdrop click
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) closeDetailModal();
});

// Close on ESC (layout.blade.js handles it too, but keep as backup)
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDetailModal();
});
</script>

@endsection