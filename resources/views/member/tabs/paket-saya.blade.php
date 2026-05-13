{{--
|--------------------------------------------------------------------------
| resources/views/member/tabs/paket-saya.blade.php
|--------------------------------------------------------------------------
--}}

@push('styles')
<style>
    /* ============================================================
       SECTION HEADER
    ============================================================ */
    .section-header {
        margin-bottom: 28px;
    }

    .section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 32px;
        letter-spacing: .08em;
        line-height: 1;
        margin-bottom: 6px;
    }

    .section-sub {
        color: var(--muted);
        font-size: 14px;
    }

    /* ============================================================
       CARD BASE
    ============================================================ */
    .pkg-card {
        background: var(--bg2);
        border: 1px solid var(--border);
        padding: 28px 30px;
        margin-bottom: 16px;
        position: relative;
        overflow: hidden;
        transition: border-color .2s;
    }

    .pkg-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(255,45,45,.03) 0%, transparent 60%);
        pointer-events: none;
    }

    .pkg-card:hover {
        border-color: rgba(255,45,45,.25);
    }

    /* ============================================================
       CARD HEADER ROW
    ============================================================ */
    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .card-head-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--red-dim);
        border: 1px solid rgba(255,45,45,.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 15px;
        flex-shrink: 0;
    }

    .card-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--muted);
        font-family: 'Barlow Condensed', sans-serif;
    }

    /* Badge status */
    .status-badge {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        font-family: 'Barlow Condensed', sans-serif;
        padding: 5px 12px;
        border: 1px solid;
    }

    .status-badge.active {
        color: var(--green);
        border-color: rgba(16,185,129,.3);
        background: var(--green-dim);
    }

    .status-badge.inactive {
        color: var(--muted);
        border-color: var(--border);
        background: transparent;
    }

    /* ============================================================
       ACTIVATION CARD
    ============================================================ */
    .activation-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .activation-left {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .activation-shield {
        width: 44px;
        height: 44px;
        background: var(--red-dim);
        border: 1px solid rgba(255,45,45,.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 18px;
        flex-shrink: 0;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    }

    .activation-shield.activated {
        background: var(--green-dim);
        border-color: rgba(16,185,129,.3);
        color: var(--green);
    }

    .activation-info .label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: var(--muted);
        font-family: 'Barlow Condensed', sans-serif;
        margin-bottom: 4px;
    }

    .activation-info .value {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: .06em;
        line-height: 1;
    }

    .activation-info .value.activated {
        color: var(--green);
    }

    .activation-info .value.not-activated {
        color: var(--red);
    }

    .activation-info .desc {
        font-size: 13px;
        color: var(--muted);
        margin-top: 4px;
    }

    .activation-btn {
        height: 48px;
        padding: 0 28px;
        background: var(--red);
        color: #fff;
        font-family: 'Barlow', sans-serif;
        font-weight: 800;
        font-size: 13px;
        letter-spacing: .1em;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        text-transform: uppercase;
        transition: background .2s, transform .15s;
        flex-shrink: 0;
    }

    .activation-btn:hover {
        background: #e01e1e;
        transform: translateY(-1px);
    }

    .activated-check {
        width: 48px;
        height: 48px;
        background: var(--green-dim);
        border: 1px solid rgba(16,185,129,.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--green);
        font-size: 20px;
        flex-shrink: 0;
    }

    /* ============================================================
       MONTHLY PACKAGE CARD
    ============================================================ */
    .pkg-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 28px;
        letter-spacing: .06em;
        margin-bottom: 4px;
        line-height: 1;
    }

    .pkg-expire {
        font-size: 14px;
        color: var(--muted);
        margin-bottom: 20px;
    }

    .pkg-expire strong {
        color: var(--text);
        font-weight: 700;
    }

    /* Progress bar */
    .progress-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .progress-label {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .1em;
        color: var(--muted);
        text-transform: uppercase;
    }

    .progress-value {
        font-size: 13px;
        font-weight: 800;
        font-family: 'Barlow Condensed', sans-serif;
        letter-spacing: .05em;
    }

    .progress-track {
        width: 100%;
        height: 6px;
        background: rgba(255,255,255,.06);
        border-radius: 0;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--red) 0%, #ff6060 100%);
        border-radius: 0;
        transition: width .8s ease;
        position: relative;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: rgba(255,255,255,.4);
        filter: blur(2px);
    }

    .progress-fill.green {
        background: linear-gradient(90deg, var(--green) 0%, #34d399 100%);
    }

    /* Empty state */
    .empty-pkg {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .empty-pkg-icon {
        font-size: 32px;
        color: var(--border);
    }

    .empty-pkg-text .title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px;
        letter-spacing: .06em;
        color: var(--muted);
        margin-bottom: 4px;
    }

    .empty-pkg-text .sub {
        font-size: 13px;
        color: var(--muted);
        opacity: .6;
    }

    /* ============================================================
       PT CARD
    ============================================================ */
    .pt-sessions {
        margin-bottom: 20px;
    }

    .pt-sessions-count {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 2px;
    }

    .pt-sessions-count .big {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 52px;
        line-height: 1;
        color: var(--red);
    }

    .pt-sessions-count .of {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 24px;
        color: var(--muted);
        line-height: 1;
    }

    .pt-start-date {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 18px;
    }

    /* Coach box */
    .coach-box {
        background: var(--bg3);
        border: 1px solid var(--border);
        padding: 18px 20px;
        margin-top: 20px;
    }

    .coach-box-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .15em;
        color: var(--muted);
        text-transform: uppercase;
        margin-bottom: 14px;
        font-family: 'Barlow Condensed', sans-serif;
    }

    .coach-info {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 14px;
    }

    .coach-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--red-dim);
        border: 2px solid rgba(255,45,45,.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 18px;
        flex-shrink: 0;
    }

    .coach-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: .06em;
        line-height: 1;
        margin-bottom: 3px;
    }

    .coach-spec {
        font-size: 12px;
        color: var(--muted);
        font-family: 'Barlow Condensed', sans-serif;
        letter-spacing: .05em;
    }

    .wa-btn {
        display: flex;
        align-items: stretch;
        width: 100%;
        gap: 1px;
        border: none;
        background: transparent;
        cursor: pointer;
        text-decoration: none;
    }

    .wa-btn-main {
        flex: 1;
        background: var(--red);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        font-family: 'Barlow', sans-serif;
        font-weight: 800;
        font-size: 13px;
        letter-spacing: .1em;
        text-transform: uppercase;
        transition: background .2s;
    }

    .wa-btn-main:hover {
        background: #e01e1e;
    }

    .wa-btn-phone {
        background: var(--bg2);
        border: 1px solid var(--border);
        padding: 14px 18px;
        font-size: 12px;
        font-weight: 700;
        font-family: 'Barlow Condensed', sans-serif;
        letter-spacing: .04em;
        color: var(--muted);
        display: flex;
        align-items: center;
        white-space: nowrap;
        transition: color .2s, border-color .2s;
    }

    .wa-btn:hover .wa-btn-phone {
        color: var(--text);
        border-color: rgba(255,255,255,.15);
    }

    /* PT empty */
    .pt-no-sessions {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: .06em;
        color: var(--muted);
        margin-bottom: 4px;
    }

    /* ============================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 640px) {
        .pkg-card { padding: 20px 18px; }
        .pt-sessions-count .big { font-size: 40px; }
        .wa-btn-phone { display: none; }
        .activation-btn { width: 100%; justify-content: center; }
    }
</style>
@endpush

{{-- ============================================================
     SECTION HEADER
============================================================ --}}
<div class="section-header">
    <div class="section-title">PAKET SAYA</div>
    <div class="section-sub">Pantau masa aktif paket bulanan dan sisa sesi Personal Trainer kamu di sini.</div>
</div>

{{-- ============================================================
     1. STATUS AKTIVASI
============================================================ --}}
<div class="pkg-card">
    <div class="activation-card">

        <div class="activation-left">
            {{-- Shield icon --}}
            <div class="activation-shield {{ $isActivated ? 'activated' : '' }}">
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            {{-- Info --}}
            <div class="activation-info">
                <div class="label">STATUS AKTIVASI</div>

                @if($isActivated)
                    <div class="value activated">SUDAH AKTIVASI</div>
                    <div class="desc">Kamu sudah mendapatkan tarif khusus member.</div>
                @else
                    <div class="value not-activated">BELUM AKTIVASI</div>
                    <div class="desc">Aktivasi sekali bayar
                        <strong style="color:var(--text);">
                            Rp {{ number_format($settings['activation_price'] ?? 80000, 0, ',', '.') }}
                        </strong>
                        untuk dapat tarif khusus member.
                    </div>
                @endif
            </div>
        </div>

        {{-- Action --}}
        @if($isActivated)
            <div class="activated-check">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        @else
            <a href="{{ route('member.dashboard', ['tab' => 'package']) }}" class="activation-btn">
                <i class="fa-solid fa-bolt"></i>
                AKTIVASI
            </a>
        @endif

    </div>
</div>

{{-- ============================================================
     2. PAKET BULANAN
============================================================ --}}
<div class="pkg-card">

    {{-- Card Head --}}
    <div class="card-head">
        <div class="card-head-left">
            <div class="card-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="card-label">PAKET BULANAN</div>
        </div>

        @if($activePackage)
            <span class="status-badge active">AKTIF</span>
        @else
            <span class="status-badge inactive">TIDAK AKTIF</span>
        @endif
    </div>

    @if($activePackage)
        @php
            $startDate = \Carbon\Carbon::parse($activePackage->start_date);
            $endDate   = \Carbon\Carbon::parse($activePackage->end_date);
            $totalDays = (int) $startDate->diffInDays($endDate) ?: 1;
            $daysLeft  = max(0, (int) ceil(now()->floatDiffInDays($endDate, false)));
            $pct       = min(100, round(($daysLeft / $totalDays) * 100));
        @endphp

        <div class="pkg-name">{{ strtoupper($activePackage->package_name) }}</div>
        <div class="pkg-expire">
            Berakhir pada <strong>{{ $endDate->format('j/n/Y') }}</strong>
        </div>

        <div class="progress-row">
            <span class="progress-label">Sisa masa aktif</span>
            <span class="progress-value">{{ $daysLeft }} / {{ $totalDays }} hari</span>
        </div>
        <div class="progress-track">
            <div class="progress-fill" style="width: {{ $pct }}%"></div>
        </div>

    @else
        <div class="empty-pkg">
            <div class="empty-pkg-icon"><i class="fa-regular fa-calendar-xmark"></i></div>
            <div class="empty-pkg-text">
                <div class="title">BELUM ADA PAKET AKTIF</div>
                <div class="sub">Beli paket bulanan untuk akses gym unlimited.</div>
            </div>
        </div>
    @endif

</div>
{{-- ============================================================
     3. PERSONAL TRAINER
============================================================ --}}
<div class="pkg-card">

    {{-- Card Head --}}
    <div class="card-head">
        <div class="card-head-left">
            <div class="card-icon">
                <i class="fa-solid fa-person-running"></i>
            </div>

            <div class="card-label">
                PERSONAL TRAINER
            </div>
        </div>

        @if($hasPt)
            <span class="status-badge active">AKTIF</span>
        @else
            <span class="status-badge inactive">TIDAK AKTIF</span>
        @endif
    </div>

    @if($hasPt)

        @foreach($ptMemberships as $ptM)

            @php
                $package = $ptM->package;

                $sessionsTotal = $package->jumlah_sesi ?? $ptM->total_sessions;

                $sessionsLeft = $ptM->remaining_sessions;

                $sessionsUsed = $sessionsTotal - $sessionsLeft;

                $ptPct = $sessionsTotal > 0
                    ? round(($sessionsLeft / $sessionsTotal) * 100)
                    : 0;

                $startPt = \Carbon\Carbon::parse($ptM->created_at)
                    ->format('j/n/Y');
            @endphp

            {{-- SESSION BOX --}}
            <div class="pt-sessions">

                <div class="pkg-name">
                    {{ strtoupper($package->nama_paket ?? 'PERSONAL TRAINER') }}
                </div>

                <div class="pt-sessions-count">
                    <span class="big">{{ $sessionsLeft }}</span>

                    <span class="of">
                        /{{ $sessionsTotal }} SESI TERSISA
                    </span>
                </div>

                <div class="pt-start-date">
                    Dimulai sejak {{ $startPt }}
                </div>

                <div class="progress-row">
                    <span class="progress-label">
                        Progress sesi
                    </span>

                    <span class="progress-value">
                        {{ $sessionsUsed }} sesi terpakai
                    </span>
                </div>

                <div class="progress-track">
                    <div class="progress-fill green"
                         style="width: {{ 100 - $ptPct }}%">
                    </div>
                </div>

            </div>

            {{-- COACH --}}
            @if($package && $package->coach_name)

            <div class="coach-box">

                <div class="coach-box-label">
                    COACH KAMU
                </div>

                <div class="coach-info">

                    <div class="coach-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>

                    <div>

                        <div class="coach-name">
                            {{ strtoupper($package->coach_name) }}
                        </div>

                        <div class="coach-spec">
                            Personal Trainer
                        </div>

                    </div>

                </div>

                @if($package->coach_whatsapp)

                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $package->coach_whatsapp) }}"
                   target="_blank"
                   class="wa-btn">

                    <div class="wa-btn-main">
                        <i class="fa-brands fa-whatsapp"></i>
                        CHAT WHATSAPP COACH
                    </div>

                    <div class="wa-btn-phone">
                        {{ $package->coach_whatsapp }}
                    </div>

                </a>

                @endif

            </div>

            @endif

            {{-- Divider --}}
            @if(!$loop->last)
                <div style="border-top:1px solid var(--border);margin:24px 0;"></div>
            @endif

        @endforeach

    @else

        <div class="empty-pkg">

            <div class="empty-pkg-icon">
                <i class="fa-solid fa-dumbbell"></i>
            </div>

            <div class="empty-pkg-text">

                <div class="title">
                    BELUM ADA SESI PT AKTIF
                </div>

                <div class="sub">
                    Beli paket Personal Trainer untuk sesi latihan bersama coach.
                </div>

            </div>

        </div>

    @endif

</div>