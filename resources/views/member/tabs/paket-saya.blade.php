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
    .member-section-header {
        margin-bottom: 14px;
    }

    .member-section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 26px;
        letter-spacing: .06em;
        line-height: 1;
        margin-bottom: 4px;
    }

    .member-section-sub {
        color: var(--muted);
        font-size: 12px;
        max-width: 620px;
        line-height: 1.5;
    }

    /* ============================================================
       CARD BASE
    ============================================================ */
    .pkg-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, var(--bg2) 0%, rgba(20,20,26,.96) 100%);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
    }

    .pkg-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(255,45,45,.06), transparent 30%);
        pointer-events: none;
    }

    /* ============================================================
       CARD HEADER
    ============================================================ */
    .pkg-head {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .pkg-head-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .pkg-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--red-dim);
        border: 1px solid rgba(255,45,45,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 14px;
        flex-shrink: 0;
    }

    .pkg-label {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 2px;
    }

    .pkg-heading {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: .04em;
        line-height: 1;
    }

    /* ============================================================
       STATUS BADGE
    ============================================================ */
    .status-badge {
        height: 26px;
        padding: 0 10px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .status-badge.active {
        background: var(--green-dim);
        color: var(--green);
        border: 1px solid rgba(16,185,129,.2);
    }

    .status-badge.inactive {
        background: rgba(255,255,255,.03);
        color: var(--muted);
        border: 1px solid var(--border);
    }

    /* ============================================================
       ACTIVATION CARD
    ============================================================ */
    .activation-wrap {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .activation-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        flex: 1;
    }

    .activation-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--red-dim);
        border: 1px solid rgba(255,45,45,.2);
        color: var(--red);
        font-size: 16px;
        flex-shrink: 0;
    }

    .activation-icon.active {
        background: var(--green-dim);
        border-color: rgba(16,185,129,.2);
        color: var(--green);
    }

    .activation-info {
        min-width: 0;
    }

    .activation-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px;
        letter-spacing: .04em;
        line-height: 1;
        margin-bottom: 4px;
    }

    .activation-title.active { color: var(--green); }
    .activation-title.inactive { color: var(--red); }

    .activation-desc {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .activation-desc strong { color: var(--text); }

    .activation-btn {
        height: 38px;
        padding: 0 16px;
        border-radius: 8px;
        background: var(--red);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        transition: .2s;
        flex-shrink: 0;
    }

    .activation-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255,45,45,.25);
        color: #fff;
    }

    .activation-check {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--green-dim);
        border: 1px solid rgba(16,185,129,.2);
        color: var(--green);
        font-size: 16px;
        flex-shrink: 0;
    }

    /* ============================================================
       PACKAGE CONTENT
    ============================================================ */
    .pkg-main-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        line-height: 1;
        letter-spacing: .04em;
        margin-bottom: 6px;
    }

    .pkg-meta {
        color: var(--muted);
        font-size: 12px;
        margin-bottom: 12px;
    }

    .pkg-meta strong { color: var(--text); }

    /* ============================================================
       PROGRESS Bar
    ============================================================ */
    .progress-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 6px;
    }

    .progress-label {
        font-size: 10px;
        font-weight: 800;
        color: var(--muted);
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .progress-value {
        font-size: 11px;
        font-weight: 700;
        color: var(--text);
    }

    .progress-track {
        width: 100%;
        height: 6px;
        border-radius: 999px;
        overflow: hidden;
        background: rgba(255,255,255,.05);
    }

    .progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--red), #ff6767);
    }

    .progress-fill.green {
        background: linear-gradient(90deg, var(--green), #34d399);
    }

    /* ============================================================
       EMPTY STATE
    ============================================================ */
    .empty-state {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .empty-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: rgba(255,255,255,.03);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 16px;
        flex-shrink: 0;
    }

    .empty-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: .04em;
        color: var(--muted);
        margin-bottom: 2px;
    }

    .empty-sub {
        font-size: 12px;
        color: var(--muted);
        line-height: 1.4;
    }

    /* ============================================================
       PERSONAL TRAINER
    ============================================================ */
    .pt-count {
        display: flex;
        align-items: flex-end;
        gap: 4px;
        margin-bottom: 4px;
    }

    .pt-count .big {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        line-height: 1;
        color: var(--red);
    }

    .pt-count .small {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 14px;
        color: var(--muted);
        line-height: 1;
        margin-bottom: 2px;
    }

    .pt-meta {
        color: var(--muted);
        font-size: 12px;
        margin-bottom: 12px;
    }

    /* ============================================================
       COACH BOX
    ============================================================ */
    .coach-box {
        margin-top: 14px;
        background: rgba(255,255,255,.01);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px;
    }

    .coach-label {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 10px;
    }

    .coach-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .coach-profile-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .coach-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--red-dim);
        border: 1px solid rgba(255,45,45,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 14px;
        flex-shrink: 0;
    }

    .coach-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: .04em;
        line-height: 1;
        margin-bottom: 2px;
    }

    .coach-role {
        font-size: 11px;
        color: var(--muted);
    }

    .coach-btn {
        height: 34px;
        padding: 0 12px;
        border-radius: 6px;
        background: #25d366; /* Hijau WhatsApp asli agar intuitif */
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        transition: .2s;
        flex-shrink: 0;
    }

    .coach-btn:hover {
        color: #fff;
        background: #20ba5a;
        transform: translateY(-1px);
    }

    /* ============================================================
       RESPONSIVE (COMPACT MOBILE)
    ============================================================ */
    @media (max-width: 640px) {
        .pkg-card {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .member-section-title { font-size: 22px; }
        .pkg-heading { font-size: 16px; }

        .activation-wrap {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        
        .activation-btn {
            width: 100%;
            height: 36px;
        }

        .coach-row {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .coach-btn {
            width: 100%;
            height: 34px;
            justify-content: center;
        }
    }
</style>
@endpush

{{-- HEADER --}}
<div class="member-section-header">
    <div class="member-section-title">PAKET SAYA</div>
    <div class="member-section-sub">
        Pantau status aktivasi member, paket gym aktif, dan sisa sesi Personal Trainer kamu.
    </div>
</div>

{{-- AKTIVASI --}}
<div class="pkg-card">
    <div class="activation-wrap">
        <div class="activation-left">
            <div class="activation-icon {{ $isActivated ? 'active' : '' }}">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="activation-info">
                @if($isActivated)
                    <div class="activation-title active">MEMBER AKTIF</div>
                    <div class="activation-desc">Akun kamu sudah teraktivasi (Tarif khusus member).</div>
                @else
                    <div class="activation-title inactive">BELUM AKTIVASI</div>
                    <div class="activation-desc">Aktivasi sekali bayar <strong>Rp {{ number_format($settings['activation_price'] ?? 80000,0,',','.') }}</strong> untuk akses harga member selamanya.</div>
                @endif
            </div>
        </div>

        @if($isActivated)
            <div class="activation-check">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        @else
            <a href="{{ route('member.dashboard',['tab'=>'package']) }}" class="activation-btn">
                <i class="fa-solid fa-bolt"></i> Aktivasi Sekarang
            </a>
        @endif
    </div>
</div>

{{-- PAKET BULANAN --}}
<div class="pkg-card">
    <div class="pkg-head">
        <div class="pkg-head-left">
            <div class="pkg-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div>
                <div class="pkg-label">Paket Gym</div>
                <div class="pkg-heading">PAKET BULANAN</div>
            </div>
        </div>
        <div class="status-badge {{ $activePackage ? 'active' : 'inactive' }}">
            {{ $activePackage ? 'AKTIF' : 'TIDAK AKTIF' }}
        </div>
    </div>

    @if($activePackage)
        @php
            $startDate = \Carbon\Carbon::parse($activePackage->start_date);
            $endDate   = \Carbon\Carbon::parse($activePackage->end_date);
            $totalDays = (int) $startDate->diffInDays($endDate) ?: 1;
            $daysLeft  = max(0, (int) ceil(now()->floatDiffInDays($endDate, false)));
            $pct = min(100, round(($daysLeft / $totalDays) * 100));
        @endphp

        <div class="pkg-main-name">{{ strtoupper($activePackage->package_name) }}</div>
        <div class="pkg-meta">Aktif sampai <strong>{{ $endDate->format('d M Y') }}</strong></div>

        <div class="progress-top">
            <div class="progress-label">Sisa Masa Aktif</div>
            <div class="progress-value">{{ $daysLeft }} / {{ $totalDays }} hari</div>
        </div>
        <div class="progress-track">
            <div class="progress-fill" style="width: {{ $pct }}%"></div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-regular fa-calendar-xmark"></i></div>
            <div>
                <div class="empty-title">BELUM ADA PAKET</div>
                <div class="empty-sub">Kamu belum memiliki paket gym aktif saat ini.</div>
            </div>
        </div>
    @endif
</div>

{{-- PERSONAL TRAINER --}}
<div class="pkg-card">
    <div class="pkg-head">
        <div class="pkg-head-left">
            <div class="pkg-icon"><i class="fa-solid fa-person-running"></i></div>
            <div>
                <div class="pkg-label">Coaching</div>
                <div class="pkg-heading">PERSONAL TRAINER</div>
            </div>
        </div>
        <div class="status-badge {{ $hasPt ? 'active' : 'inactive' }}">
            {{ $hasPt ? 'AKTIF' : 'TIDAK AKTIF' }}
        </div>
    </div>

    @if($hasPt)
        @foreach($ptMemberships as $ptM)
            @php
                $package = $ptM->package;
                $sessionsTotal = $package->jumlah_sesi ?? $ptM->total_sessions;
                $sessionsLeft  = $ptM->remaining_sessions;
                $sessionsUsed  = $sessionsTotal - $sessionsLeft;
                $ptPct = $sessionsTotal > 0 ? round(($sessionsLeft / $sessionsTotal) * 100) : 0;
                $startPt = \Carbon\Carbon::parse($ptM->created_at)->format('d M Y');
            @endphp

            <div class="pkg-main-name">{{ strtoupper($package->nama_paket ?? 'PERSONAL TRAINER') }}</div>
            
            <div class="pt-count">
                <div class="big">{{ $sessionsLeft }}</div>
                <div class="small">/{{ $sessionsTotal }} SESI TERSISA</div>
            </div>
            <div class="pt-meta">Dimulai sejak {{ $startPt }}</div>

            <div class="progress-top">
                <div class="progress-label">Progress Sesi</div>
                <div class="progress-value">{{ $sessionsUsed }} sesi digunakan</div>
            </div>
            <div class="progress-track">
                <div class="progress-fill green" style="width: {{ 100 - $ptPct }}%"></div>
            </div>

            @if($package && $package->coach_name)
                <div class="coach-box">
                    <div class="coach-label">Coach Kamu</div>
                    <div class="coach-row">
                        <div class="coach-profile-meta">
                            <div class="coach-avatar"><i class="fa-solid fa-user-tie"></i></div>
                            <div>
                                <div class="coach-name">{{ strtoupper($package->coach_name) }}</div>
                                <div class="coach-role">Personal Trainer</div>
                            </div>
                        </div>
                        @if($package->coach_whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$package->coach_whatsapp) }}" target="_blank" class="coach-btn">
                                <i class="fa-brands fa-whatsapp"></i> Chat Coach
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            @if(!$loop->last)
                <div style="margin:16px 0; border-top:1px solid var(--border);"></div>
            @endif
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-dumbbell"></i></div>
            <div>
                <div class="empty-title">BELUM ADA SESI PT</div>
                <div class="empty-sub">Beli paket Personal Trainer untuk latihan bersama coach.</div>
            </div>
        </div>
    @endif
</div>
