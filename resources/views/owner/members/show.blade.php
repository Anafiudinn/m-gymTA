@extends('layouts.owner')

@section('title', 'Detail Member')

@section('content')

@php
    $activePackage = $member->memberships
        ->where('status', 'active')
        ->first();
@endphp

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- =====================================================
        HEADER CARD
    ====================================================== --}}
    <div class="card">
        <div style="display:flex; flex-direction:column; gap:20px;">

            {{-- TOP ROW --}}
            <div style="display:flex; flex-wrap:wrap; align-items:flex-start; justify-content:space-between; gap:16px;">

                {{-- LEFT --}}
                <div style="display:flex; align-items:center; gap:16px;">
                    <div style="width:56px; height:56px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; color:#fff; flex-shrink:0;">
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-size:20px; font-weight:800; color:#111;">{{ $member->name }}</div>
                        <div style="font-size:12px; color:#aaa; margin-top:3px;">Member UB GYM</div>
                    </div>
                </div>

                {{-- BADGES --}}
                <div style="display:flex; flex-wrap:wrap; gap:8px; align-items:center;">
                    @if($member->is_active_member)
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:7px 14px; border-radius:999px; font-size:12px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                            <i class="fa-solid fa-circle-check" style="font-size:10px;"></i> Sudah Aktivasi
                        </span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:7px 14px; border-radius:999px; font-size:12px; font-weight:700; background:#fff1f2; color:#be123c; border:1px solid #fecdd3;">
                            <i class="fa-solid fa-clock" style="font-size:10px;"></i> Belum Aktivasi
                        </span>
                    @endif

                    @if($activePackage)
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:7px 14px; border-radius:999px; font-size:12px; font-weight:700; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">
                            <i class="fa-solid fa-dumbbell" style="font-size:10px;"></i> Paket Bulanan Aktif
                        </span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:7px 14px; border-radius:999px; font-size:12px; font-weight:700; background:#f5f5f5; color:#999; border:1px solid #e5e5e5;">
                            Tidak Ada Paket Aktif
                        </span>
                    @endif
                </div>

            </div>

            {{-- INFO ROW --}}
            <div style="display:flex; flex-wrap:wrap; gap:24px; padding-top:16px; border-top:1px solid var(--border);">
                <div>
                    <div style="font-size:11px; color:#aaa; font-weight:600; text-transform:uppercase; letter-spacing:.08em; margin-bottom:4px;">WhatsApp</div>
                    <div style="font-size:14px; font-weight:600; color:#111;">
                        <i class="fa-brands fa-whatsapp" style="color:#25d366; margin-right:5px;"></i>{{ $member->whatsapp }}
                    </div>
                </div>
                <div>
                    <div style="font-size:11px; color:#aaa; font-weight:600; text-transform:uppercase; letter-spacing:.08em; margin-bottom:4px;">Kode Member</div>
                    <div style="font-size:14px; font-weight:600; color:#111; font-family:monospace; background:#f5f5f5; padding:3px 10px; border-radius:8px;">{{ $member->member_code ?? '-' }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:#aaa; font-weight:600; text-transform:uppercase; letter-spacing:.08em; margin-bottom:4px;">Bergabung</div>
                    <div style="font-size:14px; font-weight:600; color:#111;">{{ $member->created_at->format('d M Y') }}</div>
                </div>
            </div>

        </div>
    </div>

    {{-- =====================================================
        STATS
    ====================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:16px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-clipboard-check" style="color:#555; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Check-in</div>
                <div style="font-size:28px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">{{ $totalAttendance }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:16px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-money-bill-wave" style="color:#1d4ed8; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Transaksi</div>
                <div style="font-size:20px; font-weight:800; color:#1d4ed8; line-height:1.2; margin-top:2px;">Rp {{ number_format($totalTransaction, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="card">
            <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em; margin-bottom:8px;">Status Paket Bulanan</div>
            @if($membership)
                <div style="font-size:14px; font-weight:700; color:#111;">{{ $membership->package_name }}</div>
                <div style="font-size:12px; color:#aaa; margin-top:3px;">
                    {{ \Carbon\Carbon::parse($membership->start_date)->format('d M Y') }} — {{ \Carbon\Carbon::parse($membership->end_date)->format('d M Y') }}
                </div>
                <div style="margin-top:10px;">
                    @if($membership->status == 'active')
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:12px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                            <span style="width:6px;height:6px;border-radius:999px;background:#16a34a;"></span> Paket Aktif
                        </span>
                    @elseif($membership->status == 'expired')
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:12px; font-weight:700; background:#fff1f2; color:#be123c; border:1px solid #fecdd3;">
                            <span style="width:6px;height:6px;border-radius:999px;background:var(--red);"></span> Expired
                        </span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:12px; font-weight:700; background:#f5f5f5; color:#999; border:1px solid #e5e5e5;">
                            Nonaktif
                        </span>
                    @endif
                </div>
            @else
                <div style="font-size:13px; color:#ccc; margin-top:4px;">Belum memiliki paket bulanan</div>
            @endif
        </div>

    </div>

    {{-- =====================================================
        RIWAYAT KEHADIRAN
    ====================================================== --}}
    <div class="card" style="padding:0; overflow:hidden;">

        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:14px; font-weight:700; color:#111;">
                <i class="fa-solid fa-calendar-check" style="color:var(--red); margin-right:8px;"></i>Riwayat Kehadiran
            </span>
            <span style="font-size:12px; color:#999;">{{ $attendances->count() }} kunjungan</span>
        </div>

        @if($attendances->count() == 0)
            <div style="padding:56px; text-align:center; color:#bbb; font-size:14px;">
                <i class="fa-solid fa-calendar-xmark" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
                Belum ada riwayat kehadiran
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9f9f9;">
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Jenis Check-in</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Status</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr style="border-top:1px solid var(--border); transition:.15s;"
                                onmouseover="this.style.background='#fafafa'"
                                onmouseout="this.style.background='transparent'">
                                <td style="padding:14px 22px; font-size:13px; color:#444;">
                                    @if($attendance->type == 'member_package') Member Paket Bulanan
                                    @elseif($attendance->type == 'paid_visit') Visit Harian
                                    @else {{ $attendance->type }}
                                    @endif
                                </td>
                                <td style="padding:14px 22px;">
                                    @if($attendance->type == 'member_package')
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:12px; font-weight:700; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">
                                            <i class="fa-solid fa-star" style="font-size:9px;"></i> Gratis Check-in
                                        </span>
                                    @else
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:12px; font-weight:700; background:#fff7ed; color:#c2410c; border:1px solid #fed7aa;">
                                            <i class="fa-solid fa-coins" style="font-size:9px;"></i> Berbayar
                                        </span>
                                    @endif
                                </td>
                                <td style="padding:14px 22px; font-size:13px; color:#999;">
                                    {{ $attendance->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

    {{-- =====================================================
        RIWAYAT TRANSAKSI
    ====================================================== --}}
    <div class="card" style="padding:0; overflow:hidden;">

        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:14px; font-weight:700; color:#111;">
                <i class="fa-solid fa-receipt" style="color:var(--red); margin-right:8px;"></i>Riwayat Transaksi
            </span>
            <span style="font-size:12px; color:#999;">{{ $transactions->count() }} transaksi</span>
        </div>

        @if($transactions->count() == 0)
            <div style="padding:56px; text-align:center; color:#bbb; font-size:14px;">
                <i class="fa-solid fa-file-invoice" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
                Belum ada transaksi
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9f9f9;">
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Invoice</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Jenis</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Pembayaran</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Total</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                            <tr style="border-top:1px solid var(--border); transition:.15s;"
                                onmouseover="this.style.background='#fafafa'"
                                onmouseout="this.style.background='transparent'">
                                <td style="padding:14px 22px;">
                                    <span style="font-size:12px; font-weight:700; color:#555; background:#f5f5f5; padding:3px 10px; border-radius:8px; font-family:monospace;">{{ $trx->invoice_code }}</span>
                                </td>
                                <td style="padding:14px 22px; font-size:13px; color:#444;">
                                    @switch($trx->category)
                                        @case('activation') Aktivasi Member @break
                                        @case('monthly') Paket Bulanan @break
                                        @case('pt') Personal Trainer @break
                                        @case('visit') Visit Harian @break
                                        @case('retail') Produk / Retail @break
                                        @default {{ $trx->category }}
                                    @endswitch
                                </td>
                                <td style="padding:14px 22px; font-size:13px; color:#555; text-transform:capitalize;">{{ $trx->payment_method }}</td>
                                <td style="padding:14px 22px; font-size:14px; font-weight:700; color:#111;">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td style="padding:14px 22px; font-size:13px; color:#999;">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>

@endsection