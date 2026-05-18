@extends('layouts.owner')

@section('title', 'Laporan Kehadiran')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- HEADER --}}
    <div>
        <h1 style="font-size:22px; font-weight:700; color:#111;">Laporan Kehadiran</h1>
        <p style="font-size:13px; color:#999; margin-top:4px;">Monitoring aktivitas check-in member gym.</p>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="card" style="padding:18px 22px;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php $inputStyle = "width:100%; border:1px solid var(--border); border-radius:1px; padding:10px 14px; font-size:13px; font-family:'Outfit',sans-serif; outline:none; color:#111; background:#fafafa; transition:.15s;"; @endphp

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Tanggal Mulai</label>
                <input type="date" name="start_date"
                       value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Tanggal Selesai</label>
                <input type="date" name="end_date"
                       value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
            </div>

            <div style="display:flex; align-items:flex-end;">
                <button type="submit"
                        style="width:100%; background:var(--red); color:#fff; border:none; padding:10px 18px; border-radius:1px; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.18s; display:flex; align-items:center; justify-content:center; gap:6px;"
                        onmouseover="this.style.background='var(--red-dark)'"
                        onmouseout="this.style.background='var(--red)'">
                    <i class="fa-solid fa-filter"></i> Filter Data
                </button>
            </div>
        </div>
    </form>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-clipboard-check" style="color:#555; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Kehadiran</div>
                <div style="font-size:28px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">{{ $totalAttendance }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-id-card" style="color:#16a34a; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Member Aktif</div>
                <div style="font-size:28px; font-weight:800; color:#16a34a; line-height:1.2; margin-top:2px;">{{ $memberAttendance }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#fff7ed; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-person-walking" style="color:#c2410c; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Guest / Non Member</div>
                <div style="font-size:28px; font-weight:800; color:#c2410c; line-height:1.2; margin-top:2px;">{{ $guestAttendance }}</div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="card" style="padding:0; overflow:hidden;">
        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:14px; font-weight:700; color:#111;">
                <i class="fa-solid fa-list-check" style="color:var(--red); margin-right:8px;"></i>Data Kehadiran
            </span>
            @if($attendances->count() > 0)
                <span style="font-size:12px; color:#999;">{{ $attendances->total() }} data</span>
            @endif
        </div>

        @if($attendances->count() == 0)
            <div style="padding:56px; text-align:center; color:#bbb; font-size:14px;">
                <i class="fa-solid fa-calendar-xmark" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
                Belum ada data kehadiran
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9f9f9;">
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em;">Member</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em;">Admin</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em;">Waktu Check-in</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr style="border-top:1px solid var(--border); transition:.15s;"
                                onmouseover="this.style.background='#fafafa'"
                                onmouseout="this.style.background='transparent'">
                                <td style="padding:14px 22px;">
                                    @if($attendance->guest_name)
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="width:34px; height:34px; border-radius:1px; background:#fff7ed; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                <i class="fa-solid fa-person-walking" style="color:#c2410c; font-size:13px;"></i>
                                            </div>
                                            <div>
                                                <div style="font-size:13px; font-weight:600; color:#111;">{{ $attendance->guest_name }}</div>
                                                <div style="font-size:11px; color:#c2410c; margin-top:2px; font-weight:600;">Guest / Non Member</div>
                                            </div>
                                        </div>
                                    @else
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="width:34px; height:34px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; color:#fff; flex-shrink:0;">
                                                {{ strtoupper(substr($attendance->user->name ?? '??', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div style="font-size:13px; font-weight:600; color:#111;">{{ $attendance->user->name ?? '-' }}</div>
                                                <div style="font-size:11px; color:#16a34a; margin-top:2px; font-weight:600;">Member Aktif</div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td style="padding:14px 22px; font-size:13px; color:#555;">{{ $attendance->admin->name ?? '-' }}</td>
                                <td style="padding:14px 22px; font-size:13px; color:#999;">{{ $attendance->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 22px; border-top:1px solid var(--border);">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

</div>

@endsection