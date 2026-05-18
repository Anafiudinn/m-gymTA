@extends('layouts.member')

@section('content')

<style>
    :root {
        --bg: #0f0f10;
        --bg2: #17181a;
        --border: rgba(255, 255, 255, .06);
        --text: #f5f5f5;
        --muted: #8b8b8b;
        --red: #ef4444;
    }

    .activity-page {
        padding: 32px;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .activity-title h1 {
        margin: 0;
        color: var(--text);
        font-size: 34px;
        font-weight: 900;
        letter-spacing: .03em;
    }

    .activity-title p {
        margin-top: 8px;
        color: var(--muted);
        font-size: 14px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 12px;
        background: var(--bg2);
        border: 1px solid var(--border);
        color: var(--text);
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s;
    }

    .back-btn:hover {
        border-color: rgba(255, 255, 255, .12);
        transform: translateY(-2px);
    }

    /* ======================================================
       TIMELINE
    ====================================================== */

    .timeline {
        position: relative;
        margin-top: 10px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 23px;
        top: 0;
        width: 2px;
        height: 100%;
        background: rgba(255, 255, 255, .08);
    }

    .timeline-item {
        position: relative;
        padding-left: 70px;
        margin-bottom: 24px;
    }

    .timeline-dot {
        position: absolute;
        left: 10px;
        top: 8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--red);
        border: 4px solid var(--bg);
        z-index: 2;
    }

    .timeline-card {
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 22px;
        transition: .2s;
    }

    .timeline-card:hover {
        border-color: rgba(255, 255, 255, .12);
        transform: translateY(-2px);
    }

    .timeline-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .timeline-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .badge-success {
        background: rgba(34, 197, 94, .12);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, .2);
    }

    .badge-info {
        background: rgba(59, 130, 246, .12);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, .2);
    }

    .badge-warning {
        background: rgba(234, 179, 8, .12);
        color: #facc15;
        border: 1px solid rgba(234, 179, 8, .2);
    }

    .timeline-date {
        color: var(--muted);
        font-size: 12px;
        white-space: nowrap;
    }

    .timeline-description {
        color: var(--text);
        font-size: 14px;
        line-height: 1.7;
    }

    .timeline-meta {
        margin-top: 16px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .timeline-meta span {
        padding: 6px 10px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid var(--border);
        color: var(--muted);
        font-size: 11px;
    }

    /* ======================================================
       EMPTY
    ====================================================== */

    .empty-state {
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 80px 30px;
        text-align: center;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: auto;
        border-radius: 20px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 28px;
        margin-bottom: 24px;
    }

    .empty-state h3 {
        color: var(--text);
        margin-bottom: 10px;
        font-size: 20px;
    }

    .empty-state p {
        color: var(--muted);
        font-size: 14px;
    }

    /* ======================================================
       PAGINATION
    ====================================================== */

    .pagination-wrapper {
        margin-top: 35px;
    }

    @media(max-width:768px) {

        .activity-page {
            padding: 20px;
        }

        .timeline-item {
            padding-left: 58px;
        }

        .timeline-card {
            padding: 18px;
        }

        .activity-title h1 {
            font-size: 28px;
        }
    }
</style>

<div class="activity-page">

    {{-- HEADER --}}
    <div class="activity-header">

        <div class="activity-title">
            <h1>Aktivitas Gym</h1>
            <p>
                Riwayat lengkap aktivitas membership, check-in gym, dan sesi personal trainer.
            </p>
        </div>

        <a href="{{ route('member.dashboard', ['tab' => 'history']) }}"
            class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Dashboard

        </a>

    </div>

    {{-- EMPTY --}}
    @if($activities->isEmpty())

    <div class="empty-state">

        <div class="empty-icon">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>

        <h3>Belum Ada Aktivitas</h3>

        <p>
            Aktivitas gym dan penggunaan sesi PT akan muncul di halaman ini.
        </p>

    </div>

    @else

    {{-- TIMELINE --}}
    <div class="timeline">

        @foreach($activities as $activity)

        <div class="timeline-item">

            <div class="timeline-dot"></div>

            <div class="timeline-card">

                <div class="timeline-top">

                    <div>

                        <span class="timeline-badge {{ $activity->badge_class }}">

                            <i class="fa-solid fa-bolt"></i>

                            {{ $activity->badge }}

                        </span>

                    </div>

                    <div class="timeline-date">
                        {{ $activity->date->format('d M Y • H:i') }} WIB
                    </div>

                </div>

                <div class="timeline-description">
                    {{ $activity->description }}
                </div>

                @if(isset($activity->meta))
                <div class="timeline-meta">

                    @foreach($activity->meta as $meta)
                    <span>{{ $meta }}</span>
                    @endforeach

                </div>
                @endif

            </div>

        </div>

        @endforeach

    </div>

    @if($activities->count() >= $limit)

    <div style="margin-top:24px; text-align:center;">

        <a href="{{ route('member.activities', ['limit' => $limit + 10]) }}"
            style="
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:12px 18px;
            border-radius:12px;
            background:rgba(255,255,255,.04);
            border:1px solid var(--border);
            color:var(--text);
            text-decoration:none;
            font-weight:700;
            font-size:13px;
       ">

            <i class="fa-solid fa-clock-rotate-left"></i>
            LOAD MORE

        </a>

    </div>

    @endif

    @endif

</div>

@endsection