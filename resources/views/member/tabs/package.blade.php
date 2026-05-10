@push('styles')
<style>
/* ============================================================
   PACKAGE SECTION
============================================================ */
.package-section-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 36px;
    letter-spacing: .06em;
    margin-bottom: 28px;
    text-transform: uppercase;
}

.package-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

/* ============================================================
   PACKAGE CARD
============================================================ */
.package-card {
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 28px;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
}

.package-card:hover {
    transform: translateY(-6px);
    border-color: rgba(255,45,45,.4);
    box-shadow: 0 20px 50px rgba(0,0,0,.4), 0 0 0 1px rgba(255,45,45,.1);
}

/* Corner decoration */
.package-card::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background: linear-gradient(225deg, rgba(255,45,45,.1) 0%, transparent 70%);
    border-bottom-left-radius: 50%;
    pointer-events: none;
}

/* Badge */
.pkg-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: rgba(255,255,255,.06);
    padding: 3px 8px;
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    border-radius: 4px;
    letter-spacing: .05em;
}

/* Category */
.pkg-category {
    font-size: 11px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .12em;
    margin-bottom: 10px;
    font-weight: 700;
}

/* Icon */
.pkg-icon {
    width: 42px;
    height: 42px;
    background: var(--red-dim);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--red);
    font-size: 18px;
    margin-bottom: 16px;
}

/* Name */
.pkg-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 22px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 12px;
    line-height: 1.1;
}

/* Price */
.pkg-price {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 36px;
    color: var(--red);
    margin-bottom: 14px;
    letter-spacing: .03em;
    line-height: 1;
}

.pkg-price-strike {
    font-size: 14px;
    color: var(--muted);
    text-decoration: line-through;
    display: block;
    margin-top: 2px;
    font-family: 'Barlow', sans-serif;
    font-weight: 400;
}

/* Description */
.pkg-desc {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.65;
    margin-bottom: 20px;
    flex-grow: 1;
}

/* Promo text */
.promo-text {
    color: var(--red);
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 14px;
    display: block;
    padding: 6px 10px;
    background: var(--red-dim);
    border-radius: 4px;
}

/* Divider */
.pkg-divider {
    height: 1px;
    background: var(--border);
    margin-bottom: 18px;
}

/* Buy button */
.btn-buy {
    width: 100%;
    padding: 13px;
    background: transparent;
    border: 1px solid rgba(255,255,255,.12);
    color: var(--text);
    font-weight: 800;
    font-size: 13px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all .2s ease;
    text-align: center;
    font-family: 'Barlow', sans-serif;
    letter-spacing: .08em;
    border-radius: 8px;
    display: block;
}

.btn-buy:hover {
    background: var(--red);
    border-color: var(--red);
    color: #fff;
    box-shadow: 0 4px 20px rgba(255,45,45,.35);
}

.btn-buy:disabled,
.btn-buy.btn-done {
    opacity: .5;
    cursor: not-allowed;
    background: var(--green-dim);
    border-color: rgba(16,185,129,.3);
    color: var(--green);
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 900px) {
    .package-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .package-grid {
        grid-template-columns: 1fr;
    }
    .pkg-price {
        font-size: 30px;
    }
}
</style>
@endpush

<h2 class="package-section-title">PILIH PAKET</h2>

<div class="package-grid">

  {{-- 1. AKTIVASI MEMBER --}}
    @php
        $pendingActivation = $pendingOrRejectedTransactions->where('category', 'activation')->where('status', 'pending')->first();
        $rejectedActivation = $pendingOrRejectedTransactions->where('category', 'activation')->where('status', 'rejected')->first();
    @endphp

    <div class="package-card">
        <div class="pkg-category">SEKALI BAYAR</div>
        <div class="pkg-icon"><i class="fa-solid fa-id-card-clip"></i></div>
        <div class="pkg-name">Aktivasi Member</div>
        <div class="pkg-price">Rp {{ number_format($settings['biaya_aktivasi'] ?? 80000, 0, ',', '.') }}</div>
        <div class="pkg-desc">
            Aktivasi akun sekali seumur hidup untuk mendapatkan harga member yang jauh lebih murah.
        </div>

        @if($isActivated)
            <button class="btn-buy" style="background:var(--green-dim); color:var(--green); border-color:transparent;" disabled>
                <i class="fa-solid fa-check"></i> SUDAH AKTIF
            </button>
        @elseif($pendingActivation)
            <button type="button" class="btn-buy" style="color:#eab308; border-color:#eab308;" 
                    onclick="openTrackingModal('{{ $pendingActivation->id }}')">
                <i class="fa-solid fa-spinner fa-spin"></i> SEDANG DIPROSES
            </button>
        @elseif($rejectedActivation)
            <button type="button" class="btn-buy" style="color:#ef4444; border-color:#ef4444;" 
                    onclick="openTrackingModal('{{ $rejectedActivation->id }}')">
                <i class="fa-solid fa-circle-exclamation"></i> PERBAIKI BUKTI
            </button>
        @else
            <button type="button" class="btn-buy" 
                    onclick="openCheckoutModal('Aktivasi Member', '{{ $settings['biaya_aktivasi'] ?? 80000 }}', 'activation')">
                AKTIVASI SEKARANG
            </button>
        @endif
    </div>

    {{-- 2. PAKET BULANAN --}}
    @php
        $pendingMonthly = $pendingOrRejectedTransactions->where('category', 'monthly')->where('status', 'pending')->first();
        $rejectedMonthly = $pendingOrRejectedTransactions->where('category', 'monthly')->where('status', 'rejected')->first();
    @endphp
    
    <div class="package-card">
        @if(!$isActivated)<div class="pkg-badge">NON-AKTIVASI</div>@endif
        <div class="pkg-category">BULANAN</div>
        <div class="pkg-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="pkg-name">Paket Bulanan</div>
        <div class="pkg-price">
            Rp {{ number_format($isActivated ? ($settings['bulanan_member'] ?? 110000) : ($settings['bulanan_tamu'] ?? 200000), 0, ',', '.') }}
            @if(!$isActivated)<span class="pkg-price-strike">Harga Tamu</span>@endif
        </div>
        <div class="pkg-desc">Bebas latihan selama 30 hari penuh.</div>

       @if($pendingMonthly)
    {{-- Ubah onclick dari showPendingAlert ke openTrackingModal --}}
    <button type="button" class="btn-buy" style="color:#eab308; border-color:#eab308;" 
            onclick="openTrackingModal('{{ $pendingMonthly->id }}')">
        <i class="fa-solid fa-spinner fa-spin"></i> SEDANG DIPROSES
    </button>
@elseif($rejectedMonthly)
    {{-- Ubah onclick dari showRejectedAlert ke openTrackingModal --}}
    <button type="button" class="btn-buy" style="color:#ef4444; border-color:#ef4444;" 
            onclick="openTrackingModal('{{ $rejectedMonthly->id }}')">
        <i class="fa-solid fa-circle-exclamation"></i> PERBAIKI BUKTI
    </button>
@else
    <button type="button" class="btn-buy" onclick="openCheckoutModal('Paket Bulanan', '{{ $isActivated ? ($settings['bulanan_member'] ?? 110000) : ($settings['bulanan_tamu'] ?? 200000) }}', 'monthly')">
        PILIH PAKET
    </button>
@endif
    </div>


@foreach($ptPackages as $pt)
 @php
    $pendingPT = $pendingOrRejectedTransactions
        ->where('category', 'pt')
        ->where('status', 'pending')
        ->first();

    $rejectedPT = $pendingOrRejectedTransactions
        ->where('category', 'pt')
        ->where('status', 'rejected')
        ->first();
@endphp

    <div class="package-card">
        <div class="pkg-category">PERSONAL TRAINER</div>
        <div class="pkg-icon"><i class="fa-solid fa-person-running"></i></div>
        <div class="pkg-name">{{ $pt->nama_paket }}</div>
        <div class="pkg-price">Rp {{ number_format($pt->harga, 0, ',', '.') }}</div>
        <div class="pkg-desc">Private training sebanyak <strong>{{ $pt->jumlah_sesi }} sesi</strong>.</div>

     @if($pendingPT)
    <button type="button" class="btn-buy" style="color:#eab308; border-color:#eab308;" 
            onclick="openTrackingModal('{{ $pendingPT->id }}')">
        <i class="fa-solid fa-spinner fa-spin"></i> SEDANG DIPROSES
    </button>

@elseif($rejectedPT)
    <button type="button" class="btn-buy" style="color:#ef4444; border-color:#ef4444;" 
            onclick="openTrackingModal('{{ $rejectedPT->id }}')">
        <i class="fa-solid fa-circle-exclamation"></i> PERBAIKI BUKTI
    </button>

@else
    <button type="button" class="btn-buy" 
            onclick="openCheckoutModal('{{ $pt->nama_paket }}', '{{ $pt->harga }}', 'pt', '{{ $pt->id }}')">
        PILIH PAKET
    </button>
@endif
    </div>
@endforeach

<script>
    function showPendingAlert(name) {
        Swal.fire({
            title: 'Pesanan Diproses',
            text: `Pesanan ${name} kamu sedang dicek admin. Cek status berkala di menu Riwayat.`,
            icon: 'info',
            confirmButtonText: 'Ke Riwayat',
            confirmButtonColor: 'var(--red)'
        }).then((res) => { if(res.isConfirmed) switchTab('history'); });
    }

    function showRejectedAlert(name) {
        Swal.fire({
            title: 'Pembayaran Ditolak',
            text: `Bukti transfer ${name} ditolak. Silakan upload ulang di menu Riwayat.`,
            icon: 'warning',
            confirmButtonText: 'Perbaiki Sekarang',
            confirmButtonColor: 'var(--red)'
        }).then((res) => { if(res.isConfirmed) switchTab('history'); });
    }
</script>

@include('member.partials.checkout-modal')
@include('member.partials.tracking-modal')
@include('member.partials.reupload-modal')
@include('member.partials.payment-script')