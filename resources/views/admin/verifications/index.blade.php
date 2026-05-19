@extends('layouts.admin')

@section('header-title', 'Verifikasi Pembayaran')

@section('content')

<style>
    /* ── Page Header ── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: var(--muted);
        margin-bottom: 4px;
    }

    .breadcrumb .sep { color: #ddd; }
    .breadcrumb .current { color: #888; }

    .page-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .page-sub { font-size: 12px; color: var(--muted); margin-top: 3px; }

    /* Counter chip — selaras .cart-head-count */
    .counter-chip {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 10px 16px;
        box-shadow: var(--shadow);
    }

    .counter-label { font-size: 12px; color: var(--muted); }
    .counter-val   { font-size: 18px; font-weight: 800; color: var(--text); }

    /* Alert flash — selaras warna semantik admin */
    .flash {
        padding: 12px 16px;
        border-radius: var(--radius);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
        border: 1px solid;
    }

    .flash.success {
        background: rgba(22,163,74,.07);
        color: #166534;
        border-color: rgba(22,163,74,.2);
    }

    .flash.error {
        background: rgba(239,68,68,.07);
        color: #b91c1c;
        border-color: rgba(239,68,68,.2);
    }

    /* ── Table card — selaras .card admin ── */
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-card-head {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-card-title { font-size: 13px; font-weight: 700; color: var(--text); }
    .table-card-sub   { font-size: 11px; color: var(--muted); margin-top: 1px; }

    /* ── Table — selaras .tbl dari pt.blade ── */
    .vtbl { width: 100%; border-collapse: collapse; }

    .vtbl thead th {
        padding: 10px 14px;
        text-align: left;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        white-space: nowrap;
    }

    .vtbl tbody td {
        padding: 12px 14px;
        font-size: 13px;
        color: var(--text);
        border-bottom: 1px solid rgba(0,0,0,.04);
        vertical-align: middle;
    }

    .vtbl tbody tr:last-child td { border-bottom: none; }
    .vtbl tbody tr:hover td { background: #fafafa; }

    /* Member cell */
    .member-name { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.2; }
    .member-wa   { font-size: 11px; color: var(--muted); margin-top: 2px; font-family: monospace; }

    /* Category badge — selaras .pill admin */
    .cat-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        border-radius: var(--radius);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 4px;
    }

    .cat-badge.activation { background: rgba(37,99,235,.1);  color: #1d4ed8; }
    .cat-badge.monthly    { background: rgba(124,58,237,.1);  color: #6d28d9; }
    .cat-badge.pt         { background: rgba(234,88,12,.1);   color: #c2410c; }
    .cat-badge.default    { background: rgba(0,0,0,.05);      color: var(--muted); }

    .cat-name { font-size: 12px; font-weight: 600; color: var(--text); }

    /* Proof button — selaras .hist-view-btn */
    .proof-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: var(--radius);
        background: rgba(37,99,235,.08);
        color: #2563eb;
        border: 1px solid rgba(37,99,235,.15);
        font-size: 11px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: background .15s, color .15s;
    }

    .proof-btn:hover { background: #2563eb; color: #fff; border-color: #2563eb; }
    .proof-btn i { font-size: 10px; }

    /* Action buttons — selaras .btn-cut */
    .btn-approve {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: var(--radius);
        background: rgba(22,163,74,.08);
        color: #166534;
        border: 1px solid rgba(22,163,74,.2);
        font-size: 11px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: background .15s, color .15s;
        white-space: nowrap;
    }

    .btn-approve:hover { background: #16a34a; color: #fff; border-color: #16a34a; }

    .btn-reject {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: var(--radius);
        background: rgba(239,68,68,.08);
        color: var(--red);
        border: 1px solid rgba(239,68,68,.2);
        font-size: 11px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: background .15s, color .15s;
        white-space: nowrap;
    }

    .btn-reject:hover { background: var(--red); color: #fff; border-color: var(--red); }

    /* Empty state */
    .empty-state {
        padding: 52px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .empty-icon {
        width: 42px;
        height: 42px;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
    }

    .empty-icon i { font-size: 18px; color: #ddd; }
    .empty-title  { font-size: 13px; font-weight: 700; color: var(--text); margin: 0; }
    .empty-sub    { font-size: 12px; color: var(--muted); margin: 0; }

    /* ── Image Preview Modal — pakai pola #ubg-alert-backdrop ── */
    #imageModal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.75);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        cursor: zoom-out;
        padding: 20px;
    }

    #imageModal.show { display: flex; }

    #imageModal img {
        max-width: 100%;
        max-height: 90vh;
        border-radius: var(--radius);
        box-shadow: 0 24px 60px rgba(0,0,0,.4);
        animation: alertIn .2s ease;
    }

    @keyframes alertIn {
        from { opacity:0; transform:scale(.95); }
        to   { opacity:1; transform:scale(1); }
    }

    /* ── Reject Modal — selaras #ubg-alert-box ── */
    #rejectModal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.3);
        backdrop-filter: blur(3px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9998;
        padding: 16px;
    }

    #rejectModal.show { display: flex; }

    .reject-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        width: 100%;
        max-width: 420px;
        box-shadow: 0 8px 40px rgba(0,0,0,.12);
        overflow: hidden;
        animation: alertIn .2s ease;
    }

    .reject-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 18px 12px;
        border-bottom: 1px solid var(--border);
    }

    .reject-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius);
        background: rgba(239,68,68,.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--red);
        font-size: 14px;
    }

    .reject-title { font-size: 14px; font-weight: 700; color: var(--text); }
    .reject-sub   { font-size: 11px; color: var(--muted); margin-top: 1px; }

    .reject-body { padding: 16px 18px; }

    .reject-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 6px;
    }

    .reject-textarea {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 10px 12px;
        font-size: 12px;
        font-family: 'Outfit', sans-serif;
        color: var(--text);
        resize: none;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        background: #fafafa;
    }

    .reject-textarea:focus {
        border-color: rgba(239,68,68,.4);
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
        background: var(--surface);
    }

    .reject-textarea::placeholder { color: #bbb; }

    .reject-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 12px 18px;
        border-top: 1px solid var(--border);
        background: #fafafa;
    }

    .btn-cancel {
        padding: 7px 16px;
        border-radius: var(--radius);
        background: rgba(0,0,0,.04);
        color: var(--muted);
        border: 1px solid var(--border);
        font-size: 12px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: background .15s;
    }

    .btn-cancel:hover { background: rgba(0,0,0,.08); color: var(--text); }

    .btn-reject-submit {
        padding: 7px 16px;
        border-radius: var(--radius);
        background: var(--red);
        color: #fff;
        border: none;
        font-size: 12px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: background .15s;
    }

    .btn-reject-submit:hover { background: var(--red-dark); }
</style>

{{-- Page Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:18px;">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:8px;"></i></span>
            <span class="current">Verifikasi</span>
        </div>
        <h1 class="page-title">Verifikasi Pembayaran</h1>
        <p class="page-sub">Daftar pembayaran pendaftaran &amp; paket mandiri dari member (Transfer).</p>
    </div>

    <div class="counter-chip">
        <span class="counter-label">Menunggu Verifikasi</span>
        <span class="counter-val">{{ $transactions->count() }}</span>
    </div>
</div>

@if(session('success'))
<div style="display:flex;gap:12px;align-items:flex-start;background:#fff;border:1px solid var(--border);border-left:3px solid rgba(34,197,94,.8);border-radius:var(--radius);padding:14px 16px;margin-bottom:20px;">
    <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(34,197,94,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-circle-check" style="font-size:13px;color:#22c55e;"></i>
    </div>
    <div style="flex:1;">
        <p style="font-size:13px;font-weight:700;color:#15803d;margin:0 0 2px;">{{ session('success') }}</p>
    </div>
</div>
@endif
{{-- ═══ ERROR ALERT ═══ --}}
@if(session('error'))
<div style="display:flex;gap:12px;align-items:flex-start;background:#fff;border:1px solid var(--border);border-left:3px solid var(--red);border-radius:var(--radius);padding:14px 16px;margin-bottom:20px;">
    <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-circle-exclamation" style="font-size:13px;color:var(--red);"></i>
    </div>
    <div style="flex:1;">
        <p style="font-size:13px;font-weight:700;color:var(--red);margin:0 0 2px;">{{ session('error') }}</p>
    </div>
</div>
@endif

{{-- Table --}}
<div class="table-card">
    <div class="table-card-head">
        <div>
            <p class="table-card-title">Daftar Transaksi Pending</p>
            <p class="table-card-sub">Pembayaran transfer yang menunggu konfirmasi admin.</p>
        </div>
        <span class="pill pill-amber" style="display:inline-flex;align-items:center;padding:3px 9px;border-radius:var(--radius);font-size:10px;font-weight:700;background:rgba(217,119,6,.1);color:#92400e;">
            {{ $transactions->count() }} pending
        </span>
    </div>

    <div style="overflow-x:auto;">
        <table class="vtbl">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Nama Pengirim</th>
                    <th>No. Rekening</th>
                    <th>Bank</th>
                    <th>Nominal</th>
                    <th>Bukti</th>
                    <th>Tanggal</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                @php
                    $catClass = match($trx->category) {
                        'activation' => 'activation',
                        'monthly'    => 'monthly',
                        'pt'         => 'pt',
                        default      => 'default',
                    };

                    $catName = match($trx->category) {
                        'activation' => 'Aktivasi Member',
                        'monthly'    => 'Paket Bulanan',
                        'pt'         => optional(\App\Models\PtPackage::find($trx->package_id))->nama_paket ?? 'Personal Trainer',
                        default      => ucfirst($trx->category),
                    };
                @endphp
                <tr>
                    {{-- Member --}}
                    <td>
                        <p class="member-name">{{ optional($trx->user)->name }}</p>
                        <p class="member-wa">{{ optional($trx->user)->whatsapp }}</p>
                    </td>

                    {{-- Category --}}
                    <td>
                        <span class="cat-badge {{ $catClass }}">{{ strtoupper($trx->category) }}</span>
                        <p class="cat-name">{{ $catName }}</p>
                    </td>

                    {{-- Sender --}}
                    <td style="font-weight:600;">{{ $trx->sender_name ?? '—' }}</td>

                    {{-- Account --}}
                    <td style="font-weight:600;font-family:monospace;">{{ $trx->sender_account ?? '—' }}</td>

                    {{-- Bank --}}
                    <td style="font-weight:600;">{{ $trx->sender_bank ?? '—' }}</td>

                    {{-- Nominal --}}
                    <td style="font-weight:800;color:var(--text);">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>

                    {{-- Proof --}}
                    <td>
                        @if($trx->proof_attachment)
                        <button type="button" class="proof-btn"
                            onclick="previewImage('{{ asset('storage/' . $trx->proof_attachment) }}')">
                            <i class="fa fa-image"></i> Lihat
                        </button>
                        @else
                        <span style="font-size:12px;color:var(--muted);">Tidak ada</span>
                        @endif
                    </td>

                    {{-- Date --}}
                    <td style="font-size:12px;color:var(--muted);white-space:nowrap;">
                        {{ $trx->created_at->format('d M Y') }}<br>
                        <span style="font-size:11px;">{{ $trx->created_at->format('H:i') }}</span>
                    </td>

                    {{-- Actions --}}
                    <td style="text-align:center;">
                        <div style="display:flex;gap:6px;justify-content:center;">
                            {{-- Approve — pakai ubgConfirm dari layout admin --}}
                            <form id="approve-form-{{ $trx->id }}"
                                action="{{ route('admin.verifications.approve', $trx->id) }}"
                                method="POST"
                                style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="button"
                                    class="btn-approve"
                                    data-confirm="Pembayaran <strong>{{ optional($trx->user)->name }}</strong> akan disetujui. Data membership akan otomatis diperbarui."
                                    data-confirm-title="Setujui Pembayaran?"
                                    data-confirm-type="success"
                                    data-confirm-ok="Ya, Setujui"
                                    data-form="#approve-form-{{ $trx->id }}">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            </form>

                            {{-- Reject --}}
                            <button type="button" class="btn-reject"
                                onclick="openRejectModal({{ $trx->id }})">
                                <i class="fa fa-times"></i> Reject
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fa fa-circle-check"></i></div>
                            <p class="empty-title">Semua Bersih!</p>
                            <p class="empty-sub">Tidak ada pembayaran yang perlu diverifikasi saat ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Image Preview Modal --}}
<div id="imageModal" onclick="closeImageModal()">
    <img id="previewImg" src="" alt="Bukti Transfer">
</div>

{{-- Reject Modal — selaras #ubg-alert-box ── --}}
<div id="rejectModal">
    <div class="reject-box">
        <div class="reject-header">
            <div class="reject-icon"><i class="fa fa-circle-xmark"></i></div>
            <div>
                <p class="reject-title">Reject Pembayaran</p>
                <p class="reject-sub">Berikan alasan penolakan agar member mengetahuinya.</p>
            </div>
        </div>

        <div class="reject-body">
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <label class="reject-label">Alasan Penolakan</label>
                <textarea name="rejection_reason" required rows="4" class="reject-textarea"
                    placeholder="Contoh: Bukti transfer tidak jelas atau nominal tidak sesuai..."></textarea>
            </form>
        </div>

        <div class="reject-footer">
            <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
            <button type="submit" class="btn-reject-submit" onclick="document.getElementById('rejectForm').submit()">
                <i class="fa fa-times" style="font-size:10px;margin-right:3px;"></i>Ya, Tolak
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(url) {
        const modal = document.getElementById('imageModal');
        document.getElementById('previewImg').src = url;
        modal.classList.add('show');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.remove('show');
    }

    function openRejectModal(id) {
        document.getElementById('rejectForm').action = `/admin/verifications/reject/${id}`;
        document.getElementById('rejectModal').classList.add('show');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('show');
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeImageModal(); closeRejectModal(); }
    });
</script>
@endpush

@endsection