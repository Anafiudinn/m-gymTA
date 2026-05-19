@push('styles')
<style>
    /* ============================================================
       PACKAGE SECTION
    ============================================================ */
    .package-section {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .package-header {
        margin-bottom: 2px;
    }

    .package-section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 28px;
        letter-spacing: .06em;
        line-height: 1;
        margin-bottom: 4px;
    }

    .package-section-sub {
        color: var(--muted);
        font-size: 13px;
        line-height: 1.5;
        max-width: 720px;
    }

    /* ============================================================
       GRID
    ============================================================ */
    .package-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        align-items: stretch;
    }

    /* ============================================================
       CARD
    ============================================================ */
    .package-card {
        position: relative;
        overflow: hidden;
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        min-height: 100%;
        transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease;
    }

    .package-card:hover {
        transform: translateY(-3px);
        border-color: rgba(255, 45, 45, .25);
        box-shadow: 0 12px 30px rgba(0,0,0,.3);
    }

    .package-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,45,45,.03) 0%, transparent 50%);
        pointer-events: none;
    }

    /* ============================================================
       BADGE
    ============================================================ */
    .pkg-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.08);
        color: var(--muted);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .06em;
        padding: 3px 6px;
        border-radius: 999px;
        z-index: 2;
    }

    /* ============================================================
       TOP ELEMENTS
    ============================================================ */
    .pkg-category {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
        font-family: 'Barlow Condensed', sans-serif;
    }

    .pkg-meta-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .pkg-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--red-dim);
        border: 1px solid rgba(255,45,45,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 15px;
        flex-shrink: 0;
    }

    .pkg-title-block {
        display: flex;
        flex-direction: column;
    }

    .pkg-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        line-height: 1.1;
        letter-spacing: .03em;
    }

    .pkg-price {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 30px;
        line-height: 1;
        letter-spacing: .02em;
        color: var(--red);
        margin-bottom: 10px;
    }

    .pkg-price-strike {
        display: block;
        margin-top: 4px;
        font-size: 11px;
        font-family: 'Barlow', sans-serif;
        font-weight: 500;
        color: var(--muted);
        text-decoration: line-through;
    }

    .pkg-desc {
        font-size: 12px;
        line-height: 1.5;
        color: var(--muted);
        margin-bottom: 14px;
        flex-grow: 1;
    }

    .pkg-desc strong {
        color: var(--text);
    }

    /* ============================================================
       BUTTON & DIVIDER
    ============================================================ */
    .pkg-divider {
        width: 100%;
        height: 1px;
        background: var(--border);
        margin-bottom: 12px;
    }

    .btn-buy {
        width: 100%;
        height: 40px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,.12);
        background: transparent;
        color: var(--text);
        font-family: 'Barlow', sans-serif;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        transition: background .2s ease, border-color .2s ease, color .2s ease, transform .15s ease;
    }

    .btn-buy:hover {
        background: var(--red);
        border-color: var(--red);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255,45,45,.25);
    }

    .btn-buy:disabled {
        cursor: not-allowed;
        opacity: .75;
    }

    .btn-buy.done { background: var(--green-dim); border-color: rgba(16,185,129,.25); color: var(--green); }
    .btn-buy.pending { border-color: rgba(234,179,8,.35); color: #eab308; }
    .btn-buy.rejected { border-color: rgba(239,68,68,.35); color: #ef4444; }
    .btn-buy.locked { background: rgba(255,255,255,.03); border: 1px dashed rgba(255,255,255,.18); color: #9ca3af; }
    .btn-buy.locked:hover { background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.25); color: #d1d5db; box-shadow: none; }

    /* ============================================================
       RESPONSIVE (COMPACT MOBILE PRO)
    ============================================================ */
    @media (max-width: 1024px) {
        .package-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }
    }

    @media (max-width: 640px) {
        .package-section { gap: 12px; }
        .package-grid { grid-template-columns: 1fr; gap: 12px; }
        .package-card { padding: 14px; border-radius: 10px; }
        .package-section-title { font-size: 24px; }
        .package-section-sub { font-size: 12px; }
        
        /* Mengubah penempatan header di dalam card agar menyamping di HP */
        .pkg-meta-wrap { margin-bottom: 8px; gap: 10px; }
        .pkg-icon { width: 34px; height: 34px; font-size: 14px; border-radius: 8px; }
        .pkg-name { font-size: 19px; }
        .pkg-price { font-size: 24px; margin-bottom: 8px; }
        .pkg-desc { font-size: 11px; margin-bottom: 10px; line-height: 1.4; }
        .pkg-divider { margin-bottom: 10px; }
        .btn-buy { height: 36px; font-size: 11px; border-radius: 6px; }
    }
</style>
@endpush

<div class="package-section">

    {{-- HEADER --}}
    <div class="package-header">
        <div class="package-section-title">PILIH PAKET</div>
        <div class="package-section-sub">
            Aktivasi akun, beli paket gym bulanan, atau ambil sesi Personal Trainer sesuai kebutuhan latihan kamu.
        </div>
    </div>

    {{-- GRID --}}
    <div class="package-grid">

        {{-- 1. AKTIVASI MEMBER --}}
        @php
            $pendingActivation = $pendingOrRejectedTransactions->where('category', 'activation')->where('status', 'pending')->first();
            $rejectedActivation = $pendingOrRejectedTransactions->where('category', 'activation')->where('status', 'rejected')->first();
        @endphp

        <div class="package-card">
            <div class="pkg-category">SEKALI BAYAR</div>
            
            <div class="pkg-meta-wrap">
                <div class="pkg-icon"><i class="fa-solid fa-id-card-clip"></i></div>
                <div class="pkg-title-block">
                    <div class="pkg-name">Aktivasi Member</div>
                </div>
            </div>

            <div class="pkg-price">
                Rp {{ number_format($settings['biaya_aktivasi'] ?? 80000, 0, ',', '.') }}
            </div>

            <div class="pkg-desc">
                Aktivasi akun sekali bayar seumur hidup untuk mendapatkan harga khusus member.
            </div>

            <div class="pkg-divider"></div>

            @if($isActivated)
                <button class="btn-buy done" disabled>
                    <i class="fa-solid fa-circle-check"></i> SUDAH AKTIF
                </button>
            @elseif($pendingActivation)
                <button type="button" class="btn-buy pending" onclick="openTrackingModal('{{ $pendingActivation->id }}')">
                    <i class="fa-solid fa-spinner fa-spin"></i> SEDANG DIPROSES
                </button>
            @elseif($rejectedActivation)
                <button type="button" class="btn-buy rejected" onclick="openTrackingModal('{{ $rejectedActivation->id }}')">
                    <i class="fa-solid fa-circle-exclamation"></i> PERBAIKI BUKTI
                </button>
            @else
                <button type="button" class="btn-buy" onclick="openCheckoutModal('Aktivasi Member', '{{ $settings['biaya_aktivasi'] ?? 80000 }}', 'activation')">
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
            @if(!$isActivated)
                <div class="pkg-badge">NON MEMBER</div>
            @endif

            <div class="pkg-category">BULANAN</div>

            <div class="pkg-meta-wrap">
                <div class="pkg-icon"><i class="fa-solid fa-calendar-days"></i></div>
                <div class="pkg-title-block">
                    <div class="pkg-name">Paket Bulanan</div>
                </div>
            </div>

            <div class="pkg-price">
                Rp {{ number_format($isActivated ? ($settings['bulanan_member'] ?? 110000) : ($settings['bulanan_tamu'] ?? 200000), 0, ',', '.') }}
                @if(!$isActivated)
                    <span class="pkg-price-strike">Harga member lebih murah setelah aktivasi</span>
                @endif
            </div>

            <div class="pkg-desc">
                Akses gym unlimited selama 30 hari penuh tanpa batas kunjungan.
            </div>

            <div class="pkg-divider"></div>

            @if($pendingMonthly)
                <button type="button" class="btn-buy pending" onclick="openTrackingModal('{{ $pendingMonthly->id }}')">
                    <i class="fa-solid fa-spinner fa-spin"></i> SEDANG DIPROSES
                </button>
            @elseif($rejectedMonthly)
                <button type="button" class="btn-buy rejected" onclick="openTrackingModal('{{ $rejectedMonthly->id }}')">
                    <i class="fa-solid fa-circle-exclamation"></i> PERBAIKI BUKTI
                </button>
            @else
                <button type="button" class="btn-buy" onclick="openCheckoutModal('Paket Bulanan', '{{ $isActivated ? ($settings['bulanan_member'] ?? 110000) : ($settings['bulanan_tamu'] ?? 200000) }}', 'monthly')">
                    PILIH PAKET
                </button>
            @endif
        </div>

        {{-- 3. PT PACKAGES --}}
        @foreach($ptPackages as $pt)
            @php
                $pendingPT = $pendingOrRejectedTransactions->where('category', 'pt')->where('package_id', $pt->id)->where('status', 'pending')->first();
                $rejectedPT = $pendingOrRejectedTransactions->where('category', 'pt')->where('package_id', $pt->id)->where('status', 'rejected')->first();
                $isEligibleForPT = $isActivated || $activePackage;
            @endphp

            <div class="package-card">
                <div class="pkg-category">PERSONAL TRAINER</div>

                <div class="pkg-meta-wrap">
                    <div class="pkg-icon"><i class="fa-solid fa-person-running"></i></div>
                    <div class="pkg-title-block">
                        <div class="pkg-name">{{ strtoupper($pt->nama_paket) }}</div>
                    </div>
                </div>

                <div class="pkg-price">
                    Rp {{ number_format($pt->harga, 0, ',', '.') }}
                </div>

                <div class="pkg-desc">
                    Program private training <strong>{{ $pt->jumlah_sesi }} sesi</strong>@if($pt->coach_name) bersama coach <strong>{{ $pt->coach_name }}</strong>.@endif
                </div>

                <div class="pkg-divider"></div>

                @if($pendingPT)
                    <button type="button" class="btn-buy pending" onclick="openTrackingModal('{{ $pendingPT->id }}')">
                        <i class="fa-solid fa-spinner fa-spin"></i> SEDANG DIPROSES
                    </button>
                @elseif($rejectedPT)
                    <button type="button" class="btn-buy rejected" onclick="openTrackingModal('{{ $rejectedPT->id }}')">
                        <i class="fa-solid fa-circle-exclamation"></i> PERBAIKI BUKTI
                    </button>
                @else
                    @if($isEligibleForPT)
                        <button type="button" class="btn-buy" onclick="openCheckoutModal('{{ $pt->nama_paket }}', '{{ $pt->harga }}', 'pt', '{{ $pt->id }}')">
                            PILIH PAKET
                        </button>
                    @else
                        <button type="button" class="btn-buy locked" onclick="showPTRequirements()">
                            <i class="fa-solid fa-circle-info"></i> CEK SYARAT PT
                        </button>
                    @endif
                @endif
            </div>
        @endforeach

    </div>
</div>

<script>
    function showPTRequirements() {
        Swal.fire({
            title: 'Syarat Paket PT',
            html: `
                <div style="text-align:left;font-size:13px;line-height:1.6;">
                    <p style="margin-bottom:8px;">Paket Personal Trainer hanya tersedia untuk:</p>
                    <ul style="padding-left:16px;margin:0;">
                        <li style="margin-bottom:4px;">Member yang sudah aktivasi</li>
                        <li>Member dengan paket bulanan aktif</li>
                    </ul>
                    <p style="margin-top:12px;color:#9ca3af;">Silakan aktivasi akun atau beli paket bulanan terlebih dahulu.</p>
                </div>
            `,
            icon: 'info',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#ef4444',
            background: '#111827',
            color: '#fff'
        });
    }
</script>

@include('member.partials.checkout-modal')
@include('member.partials.tracking-modal')
@include('member.partials.reupload-modal')
@include('member.partials.payment-script')