@extends('layouts.admin')

@section('content')
<div style="padding:24px;">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <div>
            <h1 style="font-size:28px; font-weight:800; margin:0; color:#111827;">
                Verifikasi Pembayaran
            </h1>
            <p style="margin-top:6px; color:#6b7280; font-size:14px;">
                Daftar pembayaran pendaftaran & paket mandiri dari member (Transfer)
            </p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:12px 18px;">
            <span style="font-size:13px; color:#6b7280;">
                Menunggu Verifikasi:
            </span>
            <strong style="font-size:18px; margin-left:6px; color:#111827;">
                {{ $transactions->count() }}
            </strong>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:14px 18px; border-radius:12px; margin-bottom:20px;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:14px 18px; border-radius:12px; margin-bottom:20px;">
        {{ session('error') }}
    </div>
    @endif

    {{-- =====================================================
        TABLE
    ====================================================== --}}
    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:18px; overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">Member</th>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">Kategori</th>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">Nama Pengirim</th>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">No. Rekening</th>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">Jenis Bank</th>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">Nominal</th>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">Bukti Transfer</th>
                        <th style="padding:16px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase;">Tanggal</th>
                        <th style="padding:16px; text-align:center; font-size:12px; color:#6b7280; text-transform:uppercase;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $trx)
                    <tr style="border-top:1px solid #f3f4f6;">
                        {{-- MEMBER --}}
                        <td style="padding:18px 16px;">
                            <div>
                                <div style="font-weight:700; color:#111827;">
                                    {{ optional($trx->user)->name }}
                                </div>
                                <div style="font-size:12px; color:#9ca3af; margin-top:4px;">
                                    {{ optional($trx->user)->whatsapp }}
                                </div>
                            </div>
                        </td>

                        {{-- CATEGORY --}}
                        <td style="padding:18px 16px;">
                            @php
                            $badgeColor = match($trx->category) {
                            'activation' => '#2563eb',
                            'monthly' => '#7c3aed',
                            'pt' => '#ea580c',
                            default => '#6b7280'
                            };
                            @endphp
                            <span style="padding:6px 12px; border-radius:999px; font-size:12px; font-weight:700; background:{{ $badgeColor }}15; color:{{ $badgeColor }};">
                                {{ strtoupper($trx->category) }}
                            </span>
                        </td>
                        {{-- SENDER NAME --}}
                        <td style="padding:18px 16px; font-weight:500; color:#111827;">
                            {{ $trx->sender_name ?? '-' }}
                        </td>
                        {{-- ACCOUNT NUMBER --}}
                        <td style="padding:18px 16px; font-weight:500; color:#111827;">
                            {{ $trx->account_number ?? '-' }}
                        </td>
                        {{-- BANK NAME --}}
                        <td style="padding:18px 16px; font-weight:500; color:#111827;">
                            {{ $trx->bank_name ?? '-' }}
                        </td>

                        {{-- NOMINAL --}}
                        <td style="padding:18px 16px; font-weight:700; color:#111827;">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </td>

                        {{-- BUKTI --}}
                        <td style="padding:18px 16px;">
                            @if($trx->proof_attachment)
                            <button type="button"
                                onclick="previewImage('{{ asset('storage/' . $trx->proof_attachment) }}')"
                                style="padding:8px 14px; background:#eff6ff; color:#2563eb; border:none; border-radius:10px; font-size:12px; cursor:pointer; font-weight:700;">
                                Lihat Bukti
                            </button>
                            @else
                            <span style="color:#9ca3af; font-size:13px;">Tidak ada</span>
                            @endif
                        </td>

                        {{-- DATE --}}
                        <td style="padding:18px 16px; font-size:13px; color:#6b7280;">
                            {{ $trx->created_at->format('d M Y H:i') }}
                        </td>

                        {{-- ACTION --}}
                        <td style="padding:18px 16px; text-align:center;">
                            <div style="display:flex; gap:10px; justify-content:center;">
                                {{-- APPROVE --}}
                                <form action="{{ route('admin.verifications.approve', $trx->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pembayaran ini? Data membership user akan otomatis diperbarui.')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="padding:10px 14px; border:none; border-radius:10px; background:#16a34a; color:#fff; font-size:12px; font-weight:700; cursor:pointer;">
                                        Approve
                                    </button>
                                </form>

                                {{-- REJECT --}}
                                <button type="button" onclick="openRejectModal({{ $trx->id }})" style="padding:10px 14px; border:none; border-radius:10px; background:#dc2626; color:#fff; font-size:12px; font-weight:700; cursor:pointer;">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:60px 20px; text-align:center; color:#9ca3af;">
                            Tidak ada pembayaran yang perlu diverifikasi saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- =====================================================
    IMAGE PREVIEW MODAL
===================================================== --}}
<div id="imageModal" onclick="closeImageModal()" style="position:fixed; inset:0; background:rgba(0,0,0,.8); display:none; align-items:center; justify-content:center; z-index:9999; cursor:zoom-out;">
    <img id="previewImg" src="" style="max-width:90%; max-height:90%; border-radius:12px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
</div>

{{-- =====================================================
    REJECT MODAL
===================================================== --}}
<div id="rejectModal" style="position:fixed; inset:0; background:rgba(0,0,0,.5); display:none; align-items:center; justify-content:center; z-index:9998;">
    <div style="width:100%; max-width:420px; background:#fff; border-radius:18px; padding:24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <h3 style="margin-top:0; margin-bottom:8px; font-size:22px; font-weight:800;">
            Reject Pembayaran
        </h3>
        <p style="color:#6b7280; font-size:14px; margin-bottom:20px;">Berikan alasan kenapa pembayaran ini ditolak agar member tahu.</p>

        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:10px; font-size:13px; font-weight:700;">
                    Alasan Penolakan
                </label>
                <textarea name="rejection_reason" required rows="4"
                    placeholder="Contoh: Bukti transfer tidak jelas atau nominal tidak sesuai..."
                    style="width:100%; border:1px solid #d1d5db; border-radius:12px; padding:14px; resize:none; font-family:inherit;"></textarea>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" onclick="closeRejectModal()" style="padding:12px 16px; border:none; border-radius:10px; background:#f3f4f6; color:#4b5563; cursor:pointer; font-weight:700;">
                    Batal
                </button>
                <button type="submit" style="padding:12px 16px; border:none; border-radius:10px; background:#dc2626; color:#fff; cursor:pointer; font-weight:700;">
                    Ya, Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    // Preview Gambar Transfer
    function previewImage(url) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('previewImg');
        img.src = url;
        modal.style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Modal Reject
    function openRejectModal(id) {
        if (confirm('Apakah Anda yakin ingin menolak transaksi ini?')) {
            document.getElementById('rejectModal').style.display = 'flex';
            document.getElementById('rejectForm').action = `/admin/verifications/reject/${id}`;
        }
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    // Shortcut ESC untuk tutup modal
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            closeImageModal();
            closeRejectModal();
        }
    });
</script>
@endsection