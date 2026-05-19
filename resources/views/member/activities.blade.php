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
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .activity-title h1 {
        margin: 0;
        color: var(--text);
        font-size: 28px;
        font-weight: 900;
        letter-spacing: .02em;
    }

    .activity-title p {
        margin-top: 6px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        background: var(--bg2);
        border: 1px solid var(--border);
        color: var(--text);
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .back-btn:hover {
        border-color: rgba(255, 255, 255, .12);
        background: rgba(255, 255, 255, .02);
        transform: translateY(-1px);
    }

    /* ============================================================
        CONTAINER WRAPPER & TABLE
    ============================================================ */
    .activity-container {
        background: linear-gradient(180deg, rgba(255, 255, 255, .02), rgba(255, 255, 255, .01));
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        backdrop-filter: blur(10px);
        position: relative;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-table th {
        text-align: left;
        font-size: 10px;
        color: #7b7b7b;
        text-transform: uppercase;
        letter-spacing: .12em;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        font-weight: 800;
    }

    .activity-table td {
        padding: 14px 0;
        font-size: 13px;
        border-bottom: 1px solid rgba(255, 255, 255, .04);
        vertical-align: middle;
    }

    .activity-table tr:last-child td {
        border-bottom: none;
    }

    .activity-table tr {
        transition: .2s ease;
    }

    .activity-table tr:hover {
        transform: translateX(2px);
    }

    /* ============================================================
        COMPONENTS & BADGES
    ============================================================ */
    .status-pill {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
        width: fit-content;
        display: inline-block;
    }

    .badge-success { background: rgba(34, 197, 94, .1); color: #22c55e; border: 1px solid rgba(34, 197, 94, .15); }
    .badge-info    { background: rgba(59, 130, 246, .1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, .15); }
    .badge-warning { background: rgba(234, 179, 8, .1); color: #facc15; border: 1px solid rgba(234, 179, 8, .15); }

    .muted-text {
        font-size: 11px;
        color: var(--muted);
        line-height: 1.5;
    }

    .meta-inline {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 5px;
    }

    .meta-inline span {
        padding: 2px 6px;
        border-radius: 4px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid rgba(255, 255, 255, .05);
        color: var(--muted);
        font-size: 10px;
    }

    /* ============================================================
        MOBILE CARD LIST (Sembunyi di Desktop)
    ============================================================ */
    .mobile-activity-list {
        display: none;
        flex-direction: column;
        gap: 12px;
    }

    .mobile-activity-card {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 12px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .mobile-card-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    /* ============================================================
        EMPTY STATE & LOAD MORE
    ============================================================ */
    .empty-state {
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        margin: auto;
        border-radius: 16px;
        background: rgba(255, 255, 255, .02);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 22px;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        color: var(--text);
        margin-bottom: 6px;
        font-size: 16px;
        font-weight: 800;
    }

    .load-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 10px;
        background: rgba(255,255,255,.03);
        border: 1px solid var(--border);
        color: var(--text);
        text-decoration: none;
        font-weight: 700;
        font-size: 12px;
        transition: .2s ease;
    }

    .load-more-btn:hover {
        background: rgba(239, 68, 68, .06);
        border-color: rgba(239, 68, 68, .16);
        transform: translateY(-1px);
    }

    /* ============================================================
        RESPONSIVE BREAKPOINTS
    ============================================================ */
    @media(max-width:768px) {
        .activity-page {
            padding: 16px;
        }

        .activity-title h1 {
            font-size: 24px;
        }

        .activity-table {
            display: none;
        }

        .mobile-activity-list {
            display: flex;
        }
    }
</style>

<div class="activity-page">

    {{-- HEADER --}}
    <div class="activity-header">
        <div class="activity-title">
            <h1>Aktivitas Gym</h1>
            <p>Riwayat lengkap aktivitas membership, check-in gym, dan sesi personal trainer.</p>
        </div>

        <a href="{{ route('member.dashboard', ['tab' => 'history']) }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if($activities->isEmpty())
    {{-- EMPTY --}}
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <h3>Belum Ada Aktivitas</h3>
        <p>Aktivitas gym dan penggunaan sesi PT akan muncul di halaman ini.</p>
    </div>
    @else

    {{-- CONTAINER UTAMA --}}
    <div class="activity-container">

        {{-- Desktop Table View --}}
        <table class="activity-table">
            <thead>
                <tr>
                    <th style="width: 20%;">TANGGAL</th>
                    <th style="width: 60%;">AKTIVITAS / DETAIL</th>
                    <th style="width: 20%; text-align: right;">JAM</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr>
                    {{-- DATE --}}
                    <td style="font-weight:700; color: var(--text);">
                        {{ $activity->date->format('d M Y') }}
                    </td>

                    {{-- ACTIVITY CONTENT --}}
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div>
                                <span class="status-pill {{ $activity->badge_class }}">
                                    {{ $activity->badge }}
                                </span>
                            </div>
                            <div class="muted-text">
                                {{ $activity->description }}
                            </div>

                            @if(isset($activity->meta) && is_array($activity->meta))
                            <div class="meta-inline">
                                @foreach($activity->meta as $meta)
                                <span>{{ $meta }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </td>

                    {{-- TIME --}}
                    <td style="color:var(--muted); font-size:12px; text-align: right;">
                        {{ $activity->date->format('H:i') }} WIB
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Mobile Card View --}}
        <div class="mobile-activity-list">
            @foreach($activities as $activity)
            <div class="mobile-activity-card">
                <div class="mobile-card-row">
                    <span style="font-weight: 700; font-size: 13px; color: var(--text);">
                        {{ $activity->date->format('d M Y') }}
                    </span>
                    <span class="muted-text" style="font-size: 11px;">
                        {{ $activity->date->format('H:i') }} WIB
                    </span>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <div>
                        <span class="status-pill {{ $activity->badge_class }}">
                            {{ $activity->badge }}
                        </span>
                    </div>
                    <div class="muted-text" style="font-size: 12px;">
                        {{ $activity->description }}
                    </div>

                    @if(isset($activity->meta) && is_array($activity->meta))
                    <div class="meta-inline">
                        @foreach($activity->meta as $meta)
                        <span>{{ $meta }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>

    {{-- BUTTON LOAD MORE --}}
    @if($activities->count() >= $limit)
    <div style="margin-top: 20px; text-align: center;">
        <a href="{{ route('member.activities', ['limit' => $limit + 10]) }}" class="load-more-btn">
            <i class="fa-solid fa-clock-rotate-left"></i> LOAD MORE
        </a>
    </div>
    @endif

    @endif

</div>

@endsection