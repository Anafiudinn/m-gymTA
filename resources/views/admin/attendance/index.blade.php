@extends('layouts.admin')

@section('title', 'Check-in & Kehadiran')
@section('header-title', 'Check-in & Kehadiran')

@section('content')

{{-- ═══ PAGE HEADER ═══ --}}
<div style="margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:var(--muted);margin-bottom:6px;">
        <i class="fa-solid fa-house" style="font-size:10px;"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;"></i>
        <span style="color:var(--text);font-weight:600;">Kehadiran</span>
    </div>
    <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 2px;">Check-in & Kehadiran</h1>
    <p style="font-size:12px;color:var(--muted);margin:0;">Catat check-in member dan kunjungan tamu harian</p>
</div>

@php $activeTab = request('tab', 'member'); @endphp

{{-- ═══ TAB NAV — sinkron dengan gaya layout admin ═══ --}}
<div style="display:flex;gap:6px;margin-bottom:20px;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:5px;width:fit-content;">
    <a href="{{ route('admin.attendance.index', ['tab' => 'member']) }}"
       style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:var(--radius);font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;
              {{ $activeTab == 'member'
                 ? 'background:var(--red);color:#fff;box-shadow:0 3px 10px rgba(239,68,68,.25);'
                 : 'color:var(--muted);background:transparent;' }}">
        <i class="fa-solid fa-id-card" style="font-size:11px;"></i> Check-in Member
    </a>
    <a href="{{ route('admin.attendance.index', ['tab' => 'guest']) }}"
       style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:var(--radius);font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;
              {{ $activeTab == 'guest'
                 ? 'background:var(--red);color:#fff;box-shadow:0 3px 10px rgba(239,68,68,.25);'
                 : 'color:var(--muted);background:transparent;' }}">
        <i class="fa-solid fa-user" style="font-size:11px;"></i> Tamu Harian
    </a>
</div>

{{-- ═══ 2-COLUMN GRID ═══ --}}
<div style="display:grid;grid-template-columns:360px 1fr;gap:16px;align-items:start;">

    {{-- ══════════════════════════════════
         LEFT — FORM
    ══════════════════════════════════ --}}
    <div>

        {{-- ═══ MEMBER TAB ═══ --}}
        @if($activeTab == 'member')
        <div class="card" style="padding:0;overflow:hidden;">

            {{-- Card Header --}}
            <div style="padding:16px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-id-card" style="font-size:12px;color:var(--red);"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;line-height:1.3;">Cari / Scan Member</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">ID Member atau No. WhatsApp</p>
                </div>
            </div>

            <div style="padding:18px;">

                {{-- Search Form --}}
                <form action="{{ route('admin.attendance.index') }}" method="GET" style="display:flex;gap:8px;margin-bottom:16px;">
                    <input type="hidden" name="tab" value="member">
                    <div style="flex:1;position:relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:11px;color:var(--muted);pointer-events:none;"></i>
                        <input type="text" name="search" value="{{ request('search') }}" autofocus
                            placeholder="ID Member / No WA..."
                            style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px 9px 32px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                            onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                            onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                    <button type="submit"
                        style="background:var(--red);color:#fff;font-weight:700;font-size:12.5px;padding:9px 16px;border-radius:var(--radius);border:none;cursor:pointer;white-space:nowrap;font-family:'Outfit',sans-serif;transition:background .15s;"
                        onmouseover="this.style.background='var(--red-dark)'" onmouseout="this.style.background='var(--red)'">
                        Cari
                    </button>
                </form>

                @if($user)
                {{-- ─── Member Found ─── --}}
                <div style="border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;">

                    {{-- Member Info --}}
                    <div style="padding:16px;background:#fafafa;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;">
                        <div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--red),#991b1b);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 10px rgba(239,68,68,.2);">
                            <span style="font-size:13px;font-weight:800;color:#fff;">{{ strtoupper(substr($user->name,0,2)) }}</span>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:13.5px;font-weight:800;color:var(--text);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $user->name }}</p>
                            <p style="font-size:11px;color:var(--muted);margin:2px 0 0;">{{ $user->member_code ?? $user->whatsapp }}</p>
                        </div>
                        <span style="font-size:10px;font-weight:800;padding:4px 10px;border-radius:999px;white-space:nowrap;flex-shrink:0;
                              {{ $price == 0 ? 'background:rgba(34,197,94,.12);color:#15803d;' : 'background:rgba(239,68,68,.1);color:var(--red);' }}">
                            {{ strtoupper($status_label) }}
                        </span>
                    </div>

                    <form action="{{ route('admin.attendance.process') }}" method="POST" style="padding:16px;display:flex;flex-direction:column;gap:12px;">
                        @csrf
                        <input type="hidden" name="type" value="member">
                        <input type="hidden" name="user_id_found" value="{{ $user->id }}">
                        <input type="hidden" name="amount" value="{{ $price }}">

                        @if($price > 0)
                        {{-- Paid --}}
                        <div style="background:#fafafa;border:1px solid var(--border);border-radius:var(--radius);padding:14px;text-align:center;">
                            <p style="font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 4px;">Biaya Kunjungan</p>
                            <p style="font-size:22px;font-weight:800;color:var(--text);margin:0;">Rp {{ number_format($price,0,',','.') }}</p>
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <p style="font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 8px;">Metode Pembayaran</p>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                <label id="mem-cash-label" onclick="selectPay('mem','cash','var(--red)')"
                                    style="border:2px solid var(--red);background:rgba(239,68,68,.06);border-radius:var(--radius);padding:10px;display:flex;align-items:center;justify-content:center;gap:7px;cursor:pointer;transition:all .15s;">
                                    <input type="radio" name="payment_method" value="cash" checked style="display:none;">
                                    <i class="fa-solid fa-money-bill-wave" style="font-size:11px;color:var(--red);"></i>
                                    <span style="font-size:12px;font-weight:700;color:var(--red);">CASH</span>
                                </label>
                                <label id="mem-transfer-label" onclick="selectPay('mem','transfer','var(--red)')"
                                    style="border:1px solid var(--border);border-radius:var(--radius);padding:10px;display:flex;align-items:center;justify-content:center;gap:7px;cursor:pointer;transition:all .15s;">
                                    <input type="radio" name="payment_method" value="transfer" style="display:none;">
                                    <i class="fa-solid fa-qrcode" style="font-size:11px;color:var(--muted);"></i>
                                    <span style="font-size:12px;font-weight:700;color:var(--muted);">TRANSFER</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                            data-confirm="Member akan dikenakan biaya Rp {{ number_format($price,0,',','.') }}. Pastikan pembayaran sudah diterima."
                            data-confirm-title="Check-in Member Berbayar?"
                            data-confirm-type="warn"
                            data-confirm-ok="Ya, Check-in"
                            style="width:100%;background:var(--red);color:#fff;font-weight:700;font-size:13px;padding:12px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Outfit',sans-serif;box-shadow:0 4px 12px rgba(239,68,68,.25);transition:background .15s;"
                            onmouseover="this.style.background='var(--red-dark)'" onmouseout="this.style.background='var(--red)'">
                            <i class="fa-solid fa-right-to-bracket"></i> Check-in Sekarang
                        </button>

                        @else
                        {{-- Free --}}
                        <input type="hidden" name="payment_method" value="cash">
                        <div style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:var(--radius);padding:11px;display:flex;align-items:center;justify-content:center;gap:8px;font-size:13px;font-weight:700;color:#15803d;">
                            <i class="fa-solid fa-circle-check"></i> Paket Aktif — Gratis
                        </div>
                        <button type="submit"
                            data-confirm="Paket member aktif. Konfirmasi check-in {{ $user->name }} sekarang?"
                            data-confirm-title="Check-in Member Gratis?"
                            data-confirm-type="info"
                            data-confirm-ok="Ya, Check-in"
                            style="width:100%;background:var(--text);color:#fff;font-weight:700;font-size:13px;padding:12px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Outfit',sans-serif;transition:background .15s;"
                            onmouseover="this.style.background='#333'" onmouseout="this.style.background='var(--text)'">
                            <i class="fa-solid fa-right-to-bracket"></i> Check-in Sekarang
                        </button>
                        @endif
                    </form>
                </div>

                @elseif(request('search'))
                {{-- ─── Not Found ─── --}}
                <div style="border:1px solid var(--border);border-radius:var(--radius);padding:28px;text-align:center;">
                    <div style="width:44px;height:44px;border-radius:var(--radius);background:#fafafa;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                        <i class="fa-solid fa-user-slash" style="font-size:18px;color:#ddd;"></i>
                    </div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0 0 3px;">Member tidak ditemukan</p>
                    <p style="font-size:11.5px;color:var(--muted);margin:0;">Coba ID atau nomor lain</p>
                </div>

                @else
                {{-- ─── Empty State ─── --}}
                <div style="border:1px solid var(--border);border-radius:var(--radius);padding:28px;text-align:center;background:#fafafa;">
                    <div style="width:44px;height:44px;border-radius:var(--radius);background:#f0f0f0;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                        <i class="fa-solid fa-magnifying-glass" style="font-size:18px;color:#ccc;"></i>
                    </div>
                    <p style="font-size:13px;color:var(--muted);font-weight:500;margin:0;">Masukkan ID atau nomor WA member</p>
                </div>
                @endif

            </div>
        </div>
        @endif

        {{-- ═══ GUEST TAB ═══ --}}
        @if($activeTab == 'guest')
        <div class="card" style="padding:0;overflow:hidden;">

            {{-- Card Header --}}
            <div style="padding:16px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-user-plus" style="font-size:12px;color:var(--red);"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;line-height:1.3;">Daftar Tamu Baru</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">Day pass Rp 15.000</p>
                </div>
            </div>

            <form action="{{ route('admin.attendance.process') }}" method="POST" style="padding:18px;display:flex;flex-direction:column;gap:14px;">
                @csrf
                <input type="hidden" name="type" value="guest">
                <input type="hidden" name="amount" value="15000">

                {{-- Nama Lengkap --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">
                        Nama Lengkap <span style="color:var(--red);">*</span>
                    </label>
                    <input type="text" name="name" required placeholder="Nama tamu"
                        style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                        onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                        onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">
                        No. WhatsApp
                    </label>
                    <input type="text" name="whatsapp" placeholder="08xx"
                        style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                        onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                        onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>

                {{-- Biaya Day Pass --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Biaya Day Pass</label>
                    <div style="border:1px solid var(--border);background:#fafafa;border-radius:var(--radius);padding:10px 12px;display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:var(--muted);">Day Pass</span>
                        <span style="font-size:14px;font-weight:800;color:var(--text);">Rp 15.000</span>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Metode Pembayaran</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        <label id="gst-cash-label" onclick="selectPay('gst','cash','var(--red)')"
                            style="border:2px solid var(--red);background:rgba(239,68,68,.06);border-radius:var(--radius);padding:10px;display:flex;align-items:center;justify-content:center;gap:7px;cursor:pointer;transition:all .15s;">
                            <input type="radio" name="payment_method" value="cash" checked style="display:none;">
                            <i class="fa-solid fa-money-bill-wave" style="font-size:11px;color:var(--red);"></i>
                            <span style="font-size:12px;font-weight:700;color:var(--red);">CASH</span>
                        </label>
                        <label id="gst-transfer-label" onclick="selectPay('gst','transfer','var(--red)')"
                            style="border:1px solid var(--border);border-radius:var(--radius);padding:10px;display:flex;align-items:center;justify-content:center;gap:7px;cursor:pointer;transition:all .15s;">
                            <input type="radio" name="payment_method" value="transfer" style="display:none;">
                            <i class="fa-solid fa-qrcode" style="font-size:11px;color:var(--muted);"></i>
                            <span style="font-size:12px;font-weight:700;color:var(--muted);">TRANSFER</span>
                        </label>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    data-confirm="Pastikan nama tamu dan metode pembayaran sudah benar sebelum menyimpan."
                    data-confirm-title="Catat Kehadiran Tamu?"
                    data-confirm-type="info"
                    data-confirm-ok="Ya, Catat Sekarang"
                    style="width:100%;background:var(--red);color:#fff;font-weight:700;font-size:13px;padding:12px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Outfit',sans-serif;box-shadow:0 4px 12px rgba(239,68,68,.25);transition:background .15s;"
                    onmouseover="this.style.background='var(--red-dark)'" onmouseout="this.style.background='var(--red)'">
                    <i class="fa-solid fa-circle-check"></i> Catat Kehadiran
                </button>
            </form>
        </div>
        @endif

    </div>

    {{-- ══════════════════════════════════
         RIGHT — RIWAYAT
    ══════════════════════════════════ --}}
    <div class="card" style="padding:0;overflow:hidden;">

        {{-- Header --}}
        <div style="padding:16px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;border-radius:var(--radius);background:#fafafa;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size:12px;color:var(--muted);"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;line-height:1.3;">Riwayat Kehadiran Hari Ini</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
            <span style="background:#fafafa;border:1px solid var(--border);color:var(--muted);font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:999px;white-space:nowrap;">
                {{ $attendanceHistory->count() }} aktivitas
            </span>
        </div>

        @if($attendanceHistory->isEmpty())
        {{-- Empty --}}
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:72px 24px;gap:10px;">
            <div style="width:48px;height:48px;border-radius:var(--radius);background:#fafafa;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                <i class="fa-regular fa-clock" style="font-size:20px;color:#ddd;"></i>
            </div>
            <p style="font-size:13px;color:var(--muted);font-weight:500;margin:0;">Belum ada aktivitas hari ini</p>
        </div>

        @else

        {{-- Summary Stat Bar --}}
        @php
            $totalGuest   = $attendanceHistory->whereIn('type', ['guest','paid_visit'])->count();
            $totalMember  = $attendanceHistory->where('type', 'member_package')->count();
            $totalIncome  = $attendanceHistory->sum('amount');
        @endphp

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;background:#fafafa;border-bottom:1px solid var(--border);">
            <div style="padding:12px 16px;text-align:center;border-right:1px solid var(--border);">
                <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin:0 0 3px;">Tamu / Visit</p>
                <p style="font-size:20px;font-weight:800;color:var(--text);margin:0;">{{ $totalGuest }}</p>
            </div>
            <div style="padding:12px 16px;text-align:center;border-right:1px solid var(--border);">
                <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin:0 0 3px;">Member Paket</p>
                <p style="font-size:20px;font-weight:800;color:var(--text);margin:0;">{{ $totalMember }}</p>
            </div>
            <div style="padding:12px 16px;text-align:center;">
                <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin:0 0 3px;">Pemasukan</p>
                <p style="font-size:15px;font-weight:800;color:var(--text);margin:0;">Rp {{ number_format($totalIncome,0,',','.') }}</p>
            </div>
        </div>

        {{-- List --}}
        <div style="max-height:580px;overflow-y:auto;">
            @foreach($attendanceHistory as $item)
            @php
                $isGuest   = $item->guest_name != null;
                $isPackage = $item->type == 'member_package';
            @endphp

            <div style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid var(--border);transition:background .12s;"
                 onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">

                {{-- Avatar --}}
                <div style="width:36px;height:36px;border-radius:50%;flex-shrink:0;border:1px solid var(--border);
                            background:{{ $isGuest ? '#fff7ed' : ($isPackage ? 'rgba(34,197,94,.08)' : 'rgba(239,68,68,.06)') }};
                            display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-user" style="font-size:12px;color:{{ $isGuest ? '#f97316' : ($isPackage ? '#16a34a' : 'var(--red)') }};"></i>
                </div>

                {{-- Name & Type --}}
                <div style="flex:1;min-width:0;">
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $item->guest_name ?? optional($item->user)->name ?? '-' }}
                    </p>
                    <p style="font-size:11px;color:var(--muted);margin:2px 0 0;">
                        @if($isGuest) Visit Harian
                        @elseif($isPackage) Membership Aktif
                        @else Visit Harian Member
                        @endif
                    </p>
                </div>

                {{-- Amount / Badge --}}
                <div style="text-align:right;flex-shrink:0;">
                    @if($isPackage)
                    <span style="font-size:12.5px;font-weight:800;color:#16a34a;">GRATIS</span><br>
                    <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:999px;background:rgba(34,197,94,.1);color:#15803d;">Membership</span>
                    @else
                    <span style="font-size:12.5px;font-weight:800;color:var(--text);">Rp {{ number_format($item->amount ?? 0,0,',','.') }}</span><br>
                    <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:999px;background:#fafafa;border:1px solid var(--border);color:var(--muted);">
                        {{ ucfirst($item->payment_method ?? 'cash') }}
                    </span>
                    @endif
                </div>

                {{-- Time --}}
                <div style="text-align:right;flex-shrink:0;min-width:38px;">
                    <p style="font-size:12.5px;font-weight:700;color:var(--text);margin:0;font-variant-numeric:tabular-nums;">{{ $item->created_at->format('H:i') }}</p>
                    <p style="font-size:10px;color:var(--muted);margin:1px 0 0;">WIB</p>
                </div>

                {{-- Check --}}
                <div style="width:26px;height:26px;border-radius:50%;background:rgba(34,197,94,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-check" style="font-size:9px;color:#16a34a;"></i>
                </div>

            </div>
            @endforeach
        </div>

        @endif
    </div>

</div>

{{-- ═══ RESPONSIVE MOBILE ═══ --}}
<style>
@media(max-width:900px){
    .attendance-grid-wrap > div:first-child,
    div[style*="grid-template-columns:360px"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

@endsection

@push('scripts')
<script>
/**
 * Unified payment selector
 * prefix: 'mem' | 'gst'
 * method: 'cash' | 'transfer'
 * accent: CSS color value
 */
function selectPay(prefix, method, accent) {
    const cashEl     = document.getElementById(prefix + '-cash-label');
    const transferEl = document.getElementById(prefix + '-transfer-label');
    if (!cashEl || !transferEl) return;

    const active   = method === 'cash' ? cashEl : transferEl;
    const inactive = method === 'cash' ? transferEl : cashEl;

    active.style.border   = '2px solid var(--red)';
    active.style.background = 'rgba(239,68,68,.06)';
    active.querySelector('i').style.color    = 'var(--red)';
    active.querySelector('span').style.color = 'var(--red)';

    inactive.style.border   = '1px solid var(--border)';
    inactive.style.background = 'transparent';
    inactive.querySelector('i').style.color    = 'var(--muted)';
    inactive.querySelector('span').style.color = 'var(--muted)';

    const radio = document.querySelector(`input[name="payment_method"][value="${method}"]`);
    if (radio) radio.checked = true;
}
</script>
@endpush