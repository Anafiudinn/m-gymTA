@push('styles')
<style>
    /* ============================================================
   OVERVIEW GRID
============================================================ */
    .overview-top {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 20px;
        margin-bottom: 20px;
        align-items: start;
    }

    .overview-right {
        display: grid;
        grid-template-rows: auto auto;
        gap: 20px;
    }

    .overview-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }


.member-card-digital {
    position: relative;
    border-radius: 12px;
    padding: 20px;
    color: #fff;
    overflow: hidden;
    min-height: 164px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: linear-gradient(135deg, #1a0a0a 0%, #111111 60%);
    border-left: 3px solid #ef4444;
    border-radius: 0;  /* override radius dulu lalu */
    border-radius: 12px;
    transition: box-shadow .25s ease;
}
.member-card-digital:hover {
    box-shadow: 0 16px 48px rgba(0,0,0,.35);
}

/* Satu warna merah untuk semua state — hanya badge yang beda */

.card-shimmer {
    position: absolute; inset: 0; border-radius: 12px;
    background: linear-gradient(125deg,
        transparent 20%, rgba(255,255,255,.03) 40%,
        rgba(255,255,255,.07) 50%, rgba(255,255,255,.03) 60%, transparent 80%);
    pointer-events: none;
    animation: cardShimmer 4s ease-in-out infinite;
}

@keyframes cardShimmer {
    0%,100% { opacity:0; transform:translateX(-100%); }
    50%      { opacity:1; transform:translateX(100%); }
}

.card-deco-circle { position:absolute; border-radius:50%; pointer-events:none; }
.card-deco-circle.c1 {
    width:160px; height:160px; top:-60px; right:-50px;
    background: radial-gradient(circle, rgba(239,68,68,.15) 0%, transparent 70%);
}
.card-deco-circle.c2 {
    width:100px; height:100px; bottom:-35px; left:-20px;
    background: radial-gradient(circle, rgba(255,255,255,.04) 0%, transparent 70%);
}

.card-top {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:14px; position:relative;
}

.card-gym-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 14px; letter-spacing:.18em; color:rgba(255,255,255,.45);
}
.card-gym-name span { color:#ef4444; }

.card-status-badge {
    padding: 3px 10px; border-radius: 20px;
    font-size: 9px; font-weight: 800;
    letter-spacing:.08em; text-transform: uppercase;
}

/* Hanya badge yang beda antara aktif & non-aktif */
.card-status-badge.active {
    background: rgba(239,68,68,.15);
    color: #ef4444;
    border: 1px solid rgba(239,68,68,.3);
}
.card-status-badge.inactive {
    background: rgba(255,255,255,.07);
    color: rgba(255,255,255,.4);
    border: 1px solid rgba(255,255,255,.12);
}

.card-chip {
    width:30px; height:22px;
    background: linear-gradient(135deg, #c0a060, #e8d080, #c0a060);
    border-radius:3px; opacity:.5; margin-bottom:10px; position:relative;
}
.card-chip::before {
    content:''; position:absolute; top:50%; left:0; right:0;
    height:1px; background:rgba(0,0,0,.3); transform:translateY(-50%);
}

.card-member-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 26px; letter-spacing:.06em; line-height:1;
    margin-bottom:4px; text-shadow:0 2px 10px rgba(0,0,0,.5); position:relative;
}

.card-member-id {
    font-size:10px; color:rgba(255,255,255,.4);
    font-family:monospace; letter-spacing:.1em; position:relative;
}

.card-bottom {
    display:flex; align-items:flex-end; justify-content:space-between;
    border-top: 1px solid rgba(255,255,255,.08);
    padding-top:10px; margin-top:12px; position:relative;
}

.card-bottom-label {
    font-size:9px; text-transform:uppercase;
    color:rgba(255,255,255,.4); font-weight:700;
    letter-spacing:.1em; margin-bottom:3px;
}

.card-bottom-code {
    font-size:12px; font-weight:800;
    font-family:monospace; color:#fb923c;
}

.card-bottom-date {
    font-size:12px; font-weight:700;
    color:#fff; text-align:right;
}
.member-card-wrapper{
    display:flex;
    flex-direction:column;
    gap:12px;
}

/* button luar */
.btn-dl-card{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    width:100%;
    padding:11px 14px;

    background:#111111;
    color:#ef4444;

    border:1px solid rgba(239,68,68,.2);
    border-radius:10px;

    font-size:12px;
    font-weight:700;
    letter-spacing:.05em;

    transition:.2s;
}

.btn-dl-card:hover{
    background:#ef4444;
    color:#fff;
    transform:translateY(-2px);
}

/* mode download */
.download-mode{
    box-shadow:none !important;
    transform:none !important;
}

.download-mode .card-shimmer{
    display:none !important;
}

.download-mode .download-hide{
    display:none !important;
}

    /* ============================================================
   INFO CARDS (small)
============================================================ */
    .info-card {
        background: var(--bg2);
        border: 1px solid var(--border);
        padding: 22px 24px;
        border-radius: 12px;
        transition: border-color .2s;
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 0;
        background: var(--red);
        transition: height .3s ease;
    }

    .info-card:hover::before {
        height: 100%;
    }

    .info-card-icon {
        width: 36px;
        height: 36px;
        background: var(--red-dim);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 15px;
        margin-bottom: 14px;
    }

    .info-card-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .1em;
        margin-bottom: 8px;
    }

    .info-card-value {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .info-card-value.empty {
        color: var(--muted);
        font-weight: 400;
    }

    .info-card-value.green {
        color: var(--green);
    }

    .info-card-value .sub {
        display: block;
        font-size: 12px;
        color: var(--muted);
        font-weight: 400;
        margin-top: 4px;
    }

    .info-link {
        color: var(--red);
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: .05em;
        transition: gap .2s;
    }

    .info-link:hover {
        gap: 8px;
    }

    .info-tag {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 800;
        margin-top: 4px;
    }

    .info-tag.green {
        background: var(--green-dim);
        color: var(--green);
    }

    /* ============================================================
   ACTIVATION ALERT
============================================================ */
    .activation-alert {
        background: var(--bg2);
        border: 1px solid rgba(255, 45, 45, .2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 28px;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .activation-alert::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(255, 45, 45, .04) 0%, transparent 60%);
        pointer-events: none;
    }

    .alert-left {
        display: flex;
        align-items: center;
        gap: 18px;
        min-width: 0;
    }

    .alert-icon-wrap {
        width: 46px;
        height: 46px;
        border: 1px solid var(--red);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 18px;
        flex-shrink: 0;
        animation: pulse-ring 2s ease-in-out infinite;
    }

    @keyframes pulse-ring {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(255, 45, 45, .4);
        }

        50% {
            box-shadow: 0 0 0 8px rgba(255, 45, 45, 0);
        }
    }

    .alert-text h4 {
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 4px;
        letter-spacing: .05em;
    }

    .alert-text p {
        color: var(--muted);
        font-size: 13px;
    }

    .btn-activation {
        background: var(--red);
        color: #fff;
        padding: 12px 22px;
        font-weight: 800;
        font-size: 13px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        letter-spacing: .05em;
        transition: transform .2s, box-shadow .2s;
        flex-shrink: 0;
    }

    .btn-activation:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(255, 45, 45, .4);
        color: #fff;
    }

    /* ============================================================
   PAYMENT NOTIFICATION BANNERS
============================================================ */
    .payment-notif-stack {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    .payment-notif {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 20px;
        border-radius: 10px;
        border: 1px solid;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
    }

    .payment-notif:hover {
        opacity: .85;
        transform: translateX(2px);
    }

    .notif-pending {
        background: rgba(234, 179, 8, .08);
        border-color: rgba(234, 179, 8, .25);
        color: #eab308;
    }

    .notif-rejected {
        background: rgba(239, 68, 68, .08);
        border-color: rgba(239, 68, 68, .25);
        color: #ef4444;
    }

    .notif-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }

    .notif-icon {
        font-size: 16px;
        flex-shrink: 0;
    }

    .notif-body {
        font-size: 13px;
        line-height: 1.5;
    }

    .notif-body strong {
        font-weight: 700;
        display: inline;
    }

    .notif-body span {
        color: var(--muted);
        font-size: 12px;
    }

    .notif-action {
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 5px;
        letter-spacing: .06em;
        flex-shrink: 0;
    }

    /* ============================================================
   RESPONSIVE
============================================================ */
    @media (max-width: 1100px) {
        .overview-top {
            grid-template-columns: 320px 1fr;
        }

        .overview-stats {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .overview-top {
            grid-template-columns: 1fr;
        }

        .member-card-digital {
            max-width: 100%;
        }

        .overview-stats {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 600px) {
        .overview-stats {
            grid-template-columns: 1fr 1fr;
        }

        .activation-alert {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .btn-activation {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

{{-- ===== PAYMENT NOTIFICATION BANNERS (di luar grid!) ===== --}}
@if($pendingOrRejectedTransactions->count())
@php
$pendingTrxs = $pendingOrRejectedTransactions->where('status', 'pending');
$rejectedTrxs = $pendingOrRejectedTransactions->where('status', 'rejected');
$firstPending = $pendingTrxs->first();
@endphp
<div class="payment-notif-stack">

    @if($firstPending)
    <div class="payment-notif notif-pending"
        onclick="openTrackingModal({{ $firstPending->id }})"
        role="button" tabindex="0">
        <div class="notif-left">
            <i class="fa-regular fa-clock notif-icon"></i>
            <div class="notif-body">
                <strong>{{ $pendingTrxs->count() }} pembayaran menunggu verifikasi.</strong>
                <span>Simpan kode invoice kamu untuk lacak status.</span>
            </div>
        </div>
        <span class="notif-action">LACAK <i class="fa-solid fa-arrow-right"></i></span>
    </div>
    @endif

    @foreach($rejectedTrxs as $trx)
    <div class="payment-notif notif-rejected"
        onclick="openTrackingModal({{ $trx->id }})"
        role="button" tabindex="0">
        <div class="notif-left">
            <i class="fa-solid fa-circle-xmark notif-icon"></i>
            <div class="notif-body">
                <strong>Pembayaran ditolak.</strong>
                <span>{{ $trx->rejection_reason ?? 'Bukti transfer tidak terbaca atau nominal tidak sesuai.' }}</span>
            </div>
        </div>
        <span class="notif-action">DETAIL <i class="fa-solid fa-arrow-right"></i></span>
    </div>
    @endforeach

</div>
@endif

{{-- ===== OVERVIEW LAYOUT ===== --}}
<div class="overview-top">

 {{-- Load html2canvas --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<div class="member-card-wrapper">

    <div class="member-card-digital clean-download" id="memberCardEl">
        <div class="card-shimmer"></div>
        <div class="card-deco-circle c1"></div>
        <div class="card-deco-circle c2"></div>

        <div class="card-top">
            @php
                $gymParts = explode(' ', $settings['gym_name'] ?? 'Nama gym belum diatur');
                $word1 = strtoupper($gymParts[0]);
                $rest  = strtoupper(implode(' ', array_slice($gymParts, 1)));
            @endphp

            <div class="card-gym-name">
                {{ $word1 }} <span>{{ $rest }}</span>
            </div>

            {{-- BADGE --}}
            <span class="card-status-badge download-hide {{ $isActivated ? 'active' : 'inactive' }}">
                {{ $isActivated ? '● AKTIVASI' : '○ NON-AKTIVASI' }}
            </span>
        </div>

        <div style="position:relative;">
            <div class="card-chip" style="{{ !$isActivated ? 'opacity:.2;' : '' }}"></div>

            <div class="card-member-name"
                style="{{ !$isActivated ? 'color:rgba(255,255,255,.55);' : '' }}">
                {{ strtoupper(auth()->user()->name) }}
            </div>
        </div>

        <div class="card-bottom">
            <div>
                <div class="card-bottom-label">Kode Member</div>

                <div class="card-bottom-code"
                    style="{{ !$isActivated ? 'color:rgba(255,255,255,.25);' : '' }}">
                    {{ auth()->user()->member_code ?? 'NON MEMBER' }}
                </div>
            </div>

            <div>
                <div class="card-bottom-label" style="text-align:right;">
                    Berlaku S/D
                </div>

                <div class="card-bottom-date"
                    style="{{ !$isActivated ? 'color:rgba(255,255,255,.3);' : '' }}">
                    {{ $activePackage ? \Carbon\Carbon::parse($activePackage->end_date)->format('d M Y') : '—' }}
                </div>
            </div>
        </div>
    </div>

    {{-- BUTTON DI LUAR CARD --}}
     <button class="btn-dl-card" onclick="downloadMemberCard()">
        <i class="fa-solid fa-download"></i>
        Unduh Kartu Member
    </button>
</div>



    {{-- ===== RIGHT SIDE ===== --}}
    <div class="overview-right">

        {{-- STATS ROW --}}
        <div class="overview-stats">

            {{-- Aktivasi Member --}}
            <div class="info-card">
                <div class="info-card-icon"><i class="fa-solid fa-id-card-clip"></i></div>
                <div class="info-card-label">AKTIVASI</div>
                @if($isActivated)
                <div class="info-card-value green">
                    TERAKTIVASI
                    <span class="sub">Berlaku Seumur Hidup</span>
                </div>
                <div class="info-tag green"><i class="fa-solid fa-circle-check"></i> Harga Member</div>
                @else
                <div class="info-card-value empty">Belum Aktivasi</div>
                <a href="{{ route('member.dashboard', ['tab' => 'package']) }}" class="info-link">
                    AKTIVASI <i class="fa-solid fa-arrow-right"></i>
                </a>
                @endif
            </div>

            {{-- Status Paket --}}
            <div class="info-card">
                <div class="info-card-icon"><i class="fa-solid fa-box-open"></i></div>
                <div class="info-card-label">STATUS PAKET</div>
                @if($activePackage)
                <div class="info-card-value">
                    {{ $activePackage->package_name }}
                    <span class="sub">Hingga: {{ \Carbon\Carbon::parse($activePackage->end_date)->format('d M Y') }}</span>
                </div>
                @else
                <div class="info-card-value empty">Tidak ada paket aktif</div>
                <a href="{{ route('member.dashboard', ['tab' => 'package']) }}" class="info-link">
                    BELI PAKET <i class="fa-solid fa-arrow-right"></i>
                </a>
                @endif
            </div>

            {{-- Sesi PT --}}
            <div class="info-card">
                <div class="info-card-icon"><i class="fa-solid fa-person-running"></i></div>
                <div class="info-card-label">SESI PT</div>
                @if($ptSessionsLeft > 0)
                <div class="info-card-value" style="font-size: 28px; font-family: 'Bebas Neue', sans-serif; letter-spacing: .05em;">
                    {{ $ptSessionsLeft }}
                    <span class="sub" style="font-family: 'Barlow', sans-serif; font-size: 12px;">Sesi Tersisa</span>
                </div>
                <a href="{{ route('member.dashboard', ['tab' => 'package']) }}" class="info-link">
                    DETAIL <i class="fa-solid fa-arrow-right"></i>
                </a>
                @else
                <div class="info-card-value empty">0 Sesi</div>
                <a href="{{ route('member.dashboard', ['tab' => 'package']) }}" class="info-link">
                    BELI SESI <i class="fa-solid fa-arrow-right"></i>
                </a>
                @endif
            </div>
        </div>

        {{-- ACTIVATION ALERT (only if not activated) --}}
        @if(!$isActivated)
        <div class="activation-alert">
            <div class="alert-left">
                <div class="alert-icon-wrap">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div class="alert-text">
                    <h4>AKTIVASI MEMBER DULU</h4>
                    <p>Aktivasi sekali bayar 80K untuk selamanya. Tarif kunjungan jadi 7K & paket bulanan 110K.</p>
                </div>
            </div>
            <a href="{{ route('member.dashboard', ['tab' => 'package']) }}" class="btn-activation">
                AKTIVASI <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        @endif

    </div>
</div>
<script>
async function downloadMemberCard() {

    const card = document.getElementById('memberCardEl');

    if (!card) {
        console.error('Card element tidak ditemukan');
        return;
    }

    // aktifkan mode download
    card.classList.add('download-mode');

    try {

        const canvas = await html2canvas(card, {
            backgroundColor: null,
            scale: 4,
            useCORS: true
        });

        const image = canvas.toDataURL('image/png');

        const link = document.createElement('a');
        link.href = image;
        link.download = 'member-card.png';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

    } catch (err) {

        console.error('Gagal download kartu:', err);

    } finally {

        // balikin normal
        card.classList.remove('download-mode');
    }
}
</script>

{{-- ===== CHECKOUT MODAL (di luar grid juga) ===== --}}
@include('member.partials.checkout-modal')
@include('member.partials.tracking-modal')
@include('member.partials.payment-script')
@include('member.partials.reupload-modal')