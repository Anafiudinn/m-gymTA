@extends('layouts.admin')

@section('content')
{{-- ═══════════════════════════════════════════════════════════════════════════════ --}}
{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:9px;"></i></span>
            <span class="current">Kehadiran</span>
        </div>
        <h1 class="page-title">Kehadiran</h1>
        <p class="page-sub">Catat kehadiran tamu harian dan check-in member</p>
    </div>
</div>

@php $activeTab = request('tab', 'guest'); @endphp

{{-- ═══════════════════════════════════════════════════════════════════════════════ --}}
{{-- TAB NAVIGATION --}}
<div style="display:flex;gap:8px;margin-bottom:24px;">
    <a href="{{ route('admin.attendance.index', ['tab' => 'guest']) }}"
        style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;
              {{ $activeTab == 'guest'
                 ? 'background:#f97316;color:#fff;box-shadow:0 4px 14px rgba(249,115,22,.25);'
                 : 'background:#fff;color:#6b7280;border:1px solid #e5e7eb;' }}">
        <i class="fa fa-user" style="font-size:11px;"></i> Tamu Harian
    </a>
    <a href="{{ route('admin.attendance.index', ['tab' => 'member']) }}"
        style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;
              {{ $activeTab == 'member'
                 ? 'background:#2563eb;color:#fff;box-shadow:0 4px 14px rgba(37,99,235,.2);'
                 : 'background:#fff;color:#6b7280;border:1px solid #e5e7eb;' }}">
        <i class="fa fa-id-card" style="font-size:11px;"></i> Check-in Member
    </a>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════════════ --}}
{{-- MAIN 2-COLUMN LAYOUT --}}
<div class="attendance-grid" style="display:grid;grid-template-columns:380px 1fr;gap:20px;align-items:start;">

    {{-- ═══ LEFT COLUMN — FORM INPUT ═══ --}}
    <div>
        {{-- ═══ GUEST TAB FORM ═══ --}}
        @if($activeTab == 'guest')
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;">
            <div style="padding:18px 22px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:12px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#fff7ed;display:flex;align-items:center;justify-content:center;">
                    <i class="fa fa-user-plus" style="font-size:13px;color:#f97316;"></i>
                </div>
                <div>
                    <p style="font-size:13.5px;font-weight:700;color:#111827;margin:0;line-height:1.3;">Daftar Tamu Baru</p>
                    <p style="font-size:11px;color:#9ca3af;margin:0;">Day pass Rp 15.000</p>
                </div>
            </div>

            <form action="{{ route('admin.attendance.process') }}" method="POST" style="padding:22px;display:flex;flex-direction:column;gap:16px;">
                @csrf
                <input type="hidden" name="type" value="guest">
                <input type="hidden" name="amount" value="15000">

                {{-- Nama Lengkap --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">
                        Nama Lengkap <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="name" required placeholder="Nama tamu"
                        style="width:100%;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#111827;outline:none;font-family:inherit;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                        onfocus="this.style.borderColor='#fdba74';this.style.boxShadow='0 0 0 3px #fff7ed';"
                        onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';">
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">
                        No. WhatsApp
                    </label>
                    <input type="text" name="whatsapp" placeholder="08xx"
                        style="width:100%;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#111827;outline:none;font-family:inherit;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                        onfocus="this.style.borderColor='#fdba74';this.style.boxShadow='0 0 0 3px #fff7ed';"
                        onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';">
                </div>

                {{-- Biaya Day Pass --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">
                        Biaya Day Pass
                    </label>
                    <div style="border:1px solid #fed7aa;background:#fff7ed;border-radius:10px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:13px;color:#9ca3af;">Day Pass</span>
                        <span style="font-size:14px;font-weight:800;color:#f97316;">Rp 15.000</span>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div>
                    <label style="display:block;font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">
                        Metode Pembayaran
                    </label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        <label id="pay-cash-label" onclick="selectPayGuest('cash')"
                            style="border:2px solid #f97316;background:#fff7ed;border-radius:10px;padding:11px;display:flex;align-items:center;justify-content:center;gap:8px;cursor:pointer;transition:all .15s;">
                            <input type="radio" name="payment_method" value="cash" checked style="display:none;">
                            <i class="fa fa-money-bill-wave" style="font-size:11px;color:#f97316;"></i>
                            <span style="font-size:12.5px;font-weight:700;color:#ea580c;">CASH</span>
                        </label>
                        <label id="pay-transfer-label" onclick="selectPayGuest('transfer')"
                            style="border:1px solid #e5e7eb;border-radius:10px;padding:11px;display:flex;align-items:center;justify-content:center;gap:8px;cursor:pointer;transition:all .15s;">
                            <input type="radio" name="payment_method" value="transfer" style="display:none;">
                            <i class="fa fa-qrcode" style="font-size:11px;color:#9ca3af;"></i>
                            <span style="font-size:12.5px;font-weight:700;color:#6b7280;">TRANSFER</span>
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    data-confirm
                    data-confirm-title="Catat Kehadiran Tamu?"
                    data-confirm-desc="Pastikan nama tamu dan metode pembayaran sudah benar sebelum menyimpan."
                    data-confirm-type="info"
                    data-confirm-label="Ya, Catat Sekarang"
                    style="width:100%;background:#f97316;color:#fff;font-weight:700;font-size:13.5px;padding:13px;border-radius:10px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:filter .15s;font-family:inherit;box-shadow:0 4px 14px rgba(249,115,22,.25);"
                    onmouseover="this.style.filter='brightness(1.07)'" onmouseout="this.style.filter='none'">
                    <i class="fa fa-check-circle"></i> Catat Kehadiran
                </button>
            </form>
        </div>
        @endif

        {{-- ═══ MEMBER TAB FORM ═══ --}}
        @if($activeTab == 'member')
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;">
            <div style="padding:18px 22px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:12px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                    <i class="fa fa-id-card" style="font-size:13px;color:#2563eb;"></i>
                </div>
                <div>
                    <p style="font-size:13.5px;font-weight:700;color:#111827;margin:0;line-height:1.3;">Cari / Scan Member</p>
                    <p style="font-size:11px;color:#9ca3af;margin:0;">ID Member atau No. WhatsApp</p>
                </div>
            </div>

            <div style="padding:22px;">
                {{-- Search Form --}}
                <form action="{{ route('admin.attendance.index') }}" method="GET" style="display:flex;gap:8px;margin-bottom:20px;">
                    <input type="hidden" name="tab" value="member">
                    <input type="text" name="search" value="{{ request('search') }}" autofocus
                        placeholder="ID Member / No WA..."
                        style="flex:1;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#111827;outline:none;font-family:inherit;transition:border-color .15s,box-shadow .15s;"
                        onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px #eff6ff';"
                        onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';">
                    <button type="submit"
                        style="background:#1e293b;color:#fff;font-weight:700;font-size:13px;padding:10px 18px;border-radius:10px;border:none;cursor:pointer;white-space:nowrap;font-family:inherit;transition:background .15s;"
                        onmouseover="this.style.background='#334155'" onmouseout="this.style.background='#1e293b'">
                        <i class="fa fa-search" style="margin-right:4px;font-size:11px;"></i> Cari
                    </button>
                </form>

                @if($user)
                {{-- Member Found Card --}}
                <div style="background:#f8faff;border:1px solid #dbeafe;border-radius:14px;overflow:hidden;">
                    <div style="padding:20px;text-align:center;border-bottom:1px solid #dbeafe;">
                        <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:0 4px 14px rgba(37,99,235,.25);">
                            <i class="fa fa-user" style="color:#fff;font-size:18px;"></i>
                        </div>
                        <span style="display:inline-block;font-size:10px;font-weight:700;padding:4px 12px;border-radius:20px;margin-bottom:8px;
                                {{ $price == 0 ? 'background:#22c55e;color:#fff;' : 'background:#2563eb;color:#fff;' }}">
                            {{ strtoupper($status_label) }}
                        </span>
                        <h4 style="font-size:16px;font-weight:800;color:#111827;margin:0 0 4px;">{{ $user->name }}</h4>
                        <p style="font-size:11.5px;color:#9ca3af;margin:0;">{{ $user->member_code ?? $user->whatsapp }}</p>
                    </div>

                    <form action="{{ route('admin.attendance.process') }}" method="POST" style="padding:18px;display:flex;flex-direction:column;gap:12px;">
                        @csrf
                        <input type="hidden" name="type" value="member">
                        <input type="hidden" name="user_id_found" value="{{ $user->id }}">
                        <input type="hidden" name="amount" value="{{ $price }}">

                        @if($price > 0)
                        {{-- Paid Member Check-in --}}
                        <div style="background:#fff;border:1px solid #dbeafe;border-radius:12px;padding:16px;text-align:center;">
                            <p style="font-size:11px;color:#9ca3af;margin:0 0 4px;">Biaya Kunjungan</p>
                            <p style="font-size:22px;font-weight:800;color:#2563eb;margin:0;">Rp {{ number_format($price, 0, ',', '.') }}</p>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:12px;">
                                <label id="mem-cash-label" onclick="selectPayMember('cash')"
                                    style="border:2px solid #2563eb;background:#eff6ff;border-radius:8px;padding:9px;display:flex;align-items:center;justify-content:center;gap:6px;cursor:pointer;transition:all .15s;">
                                    <input type="radio" name="payment_method" value="cash" checked style="display:none;">
                                    <i class="fa fa-money-bill-wave" style="font-size:10px;color:#2563eb;"></i>
                                    <span style="font-size:12px;font-weight:700;color:#1d4ed8;">CASH</span>
                                </label>
                                <label id="mem-transfer-label" onclick="selectPayMember('transfer')"
                                    style="border:1px solid #e5e7eb;border-radius:8px;padding:9px;display:flex;align-items:center;justify-content:center;gap:6px;cursor:pointer;transition:all .15s;">
                                    <input type="radio" name="payment_method" value="transfer" style="display:none;">
                                    <i class="fa fa-qrcode" style="font-size:10px;color:#9ca3af;"></i>
                                    <span style="font-size:12px;font-weight:700;color:#6b7280;">TRANSFER</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                            data-confirm
                            data-confirm-title="Check-in Member Berbayar?"
                            data-confirm-desc="Member akan dikenakan biaya Rp {{ number_format($price, 0, ',', '.') }}. Pastikan pembayaran sudah diterima."
                            data-confirm-type="warning"
                            data-confirm-label="Ya, Check-in"
                            style="width:100%;background:#2563eb;color:#fff;font-weight:700;font-size:13.5px;padding:13px;border-radius:10px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:inherit;box-shadow:0 4px 14px rgba(37,99,235,.2);transition:filter .15s;"
                            onmouseover="this.style.filter='brightness(1.08)'" onmouseout="this.style.filter='none'">
                            <i class="fa fa-sign-in-alt"></i> Check-in Sekarang
                        </button>

                        @else
                        {{-- Free Member Check-in --}}
                        <input type="hidden" name="payment_method" value="cash">
                        <div style="background:#22c55e;color:#fff;border-radius:10px;padding:12px;display:flex;align-items:center;justify-content:center;gap:8px;font-size:13px;font-weight:700;">
                            <i class="fa fa-check-circle"></i> Paket Aktif — Gratis
                        </div>
                        <button type="submit"
                            data-confirm
                            data-confirm-title="Check-in Member Gratis?"
                            data-confirm-desc="Paket member aktif. Konfirmasi check-in {{ $user->name }} sekarang?"
                            data-confirm-type="success"
                            data-confirm-label="Ya, Check-in"
                            style="width:100%;background:#1e293b;color:#fff;font-weight:700;font-size:13.5px;padding:13px;border-radius:10px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:inherit;transition:background .15s;"
                            onmouseover="this.style.background='#334155'" onmouseout="this.style.background='#1e293b'">
                            <i class="fa fa-sign-in-alt"></i> Check-in Sekarang
                        </button>
                        @endif
                    </form>
                </div>

                @elseif(request('search'))
                {{-- Member Not Found --}}
                <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:12px;padding:24px;text-align:center;">
                    <i class="fa fa-user-times" style="font-size:28px;color:#fca5a5;display:block;margin-bottom:10px;"></i>
                    <p style="font-size:13px;font-weight:700;color:#b91c1c;margin:0 0 4px;">Member tidak ditemukan</p>
                    <p style="font-size:11.5px;color:#9ca3af;margin:0;">Coba dengan ID lain atau periksa kembali</p>
                </div>
                @else
                {{-- No Search --}}
                <div style="background:#f9fafb;border:1px solid #f3f4f6;border-radius:12px;padding:24px;text-align:center;">
                    <i class="fa fa-search" style="font-size:28px;color:#e5e7eb;display:block;margin-bottom:10px;"></i>
                    <p style="font-size:13px;color:#9ca3af;font-weight:500;margin:0;">Masukkan ID atau nomor WA member</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- ═══ RIGHT COLUMN — ATTENDANCE HISTORY ═══ --}}
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;">
        {{-- Header --}}
        <div style="padding:18px 22px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#f8fafc;display:flex;align-items:center;justify-content:center;">
                    <i class="fa fa-clock" style="font-size:13px;color:#475569;"></i>
                </div>
                <div>
                    <p style="font-size:13.5px;font-weight:700;color:#111827;margin:0;line-height:1.3;">Riwayat Kehadiran Hari Ini</p>
                    <p style="font-size:11px;color:#9ca3af;margin:0;">{{ now()->format('l, d F Y') }}</p>
                </div>
            </div>
            <span style="background:#f1f5f9;color:#334155;font-size:11.5px;font-weight:700;padding:5px 12px;border-radius:20px;white-space:nowrap;">
                {{ $attendanceHistory->count() }} aktivitas
            </span>
        </div>

        @if($attendanceHistory->isEmpty())
        {{-- Empty State --}}
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:80px 24px;gap:12px;">
            <div style="width:56px;height:56px;border-radius:14px;background:#f9fafb;display:flex;align-items:center;justify-content:center;">
                <i class="fa fa-clock" style="font-size:24px;color:#e5e7eb;"></i>
            </div>
            <p style="font-size:13px;color:#9ca3af;font-weight:500;margin:0;">Belum ada aktivitas hari ini</p>
        </div>
        @else
        {{-- ═══ SUMMARY CARDS ═══ --}}
        @php
        $totalGuest = $attendanceHistory->whereIn('type', ['guest', 'paid_visit'])->count();
        $totalMember = $attendanceHistory->where('type', 'member_package')->count();
        $totalIncome = $attendanceHistory->sum('amount');
        @endphp

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1px;background:#f3f4f6;border-bottom:1px solid #f3f4f6;">
            {{-- Tamu / Visit --}}
            <div style="background:#fff;padding:14px 18px;text-align:center;">
                <p style="font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.06em;margin:0 0 4px;">Tamu / Visit</p>
                <p style="font-size:20px;font-weight:800;color:#f97316;margin:0;">{{ $totalGuest }}</p>
            </div>

            {{-- Member Paket --}}
            <div style="background:#fff;padding:14px 18px;text-align:center;">
                <p style="font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.06em;margin:0 0 4px;">Member Paket</p>
                <p style="font-size:20px;font-weight:800;color:#2563eb;margin:0;">{{ $totalMember }}</p>
            </div>

            {{-- Pemasukan --}}
            <div style="background:#fff;padding:14px 18px;text-align:center;">
                <p style="font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.06em;margin:0 0 4px;">Pemasukan</p>
                <p style="font-size:16px;font-weight:800;color:#111827;margin:0;">Rp {{ number_format($totalIncome,0,',','.') }}</p>
            </div>
        </div>

        {{-- ═══ ATTENDANCE LIST ═══ --}}
        <div style="padding:8px;max-height:600px;overflow-y:auto;">
            @foreach($attendanceHistory as $item)
            @php
            $isGuest = $item->guest_name != null;
            $isPackage = $item->type == 'member_package';
            @endphp

            <div style="display:flex;align-items:center;justify-content:space-between;padding:13px 14px;border-radius:10px;transition:background .15s;"
                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">

                {{-- LEFT: Avatar + Name --}}
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:38px;height:38px;border-radius:50%;flex-shrink:0;
                                        {{ $isGuest ? 'background:#fff7ed;' : 'background:#eff6ff;' }}
                                        display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-user" style="font-size:13px;
                                    {{ $isGuest ? 'color:#f97316;' : 'color:#2563eb;' }}"></i>
                    </div>
                    <div>
                        <p style="font-size:13.5px;font-weight:700;color:#111827;margin:0;line-height:1.3;">
                            {{ $item->guest_name ?? optional($item->user)->name ?? '-' }}
                        </p>
                        <p style="font-size:11.5px;color:#9ca3af;margin:2px 0 0;">
                            @if($isGuest)
                            Visit Harian
                            @elseif($isPackage)
                            Membership Aktif
                            @else
                            Visit Harian Member
                            @endif
                        </p>
                    </div>
                </div>

                {{-- RIGHT: Amount + Time + Status --}}
                <div style="display:flex;align-items:center;gap:14px;flex-shrink:0;">
                    {{-- Amount / Status --}}
                    <div style="text-align:right;">
                        @if($isPackage)
                        <span style="display:block;font-size:13px;font-weight:800;color:#16a34a;">GRATIS</span>
                        <span style="display:inline-block;font-size:10.5px;font-weight:600;padding:2px 8px;border-radius:20px;background:#f0fdf4;color:#15803d;margin-top:2px;">
                            Membership
                        </span>
                        @else
                        <span style="display:block;font-size:13px;font-weight:800;
                                        {{ $isGuest ? 'color:#f97316;' : 'color:#2563eb;' }}">
                            Rp {{ number_format($item->amount ?? 0,0,',','.') }}
                        </span>
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:10.5px;font-weight:600;padding:2px 8px;border-radius:20px;margin-top:2px;
                                        {{ $isGuest ? 'background:#fff7ed;color:#c2410c;' : 'background:#eff6ff;color:#1d4ed8;' }}">
                            <i class="fa {{ $isGuest ? 'fa-money-bill-wave' : 'fa-id-card' }}" style="font-size:9px;"></i>
                            {{ ucfirst($item->payment_method ?? 'cash') }}
                        </span>
                        @endif
                    </div>

                    {{-- Time --}}
                    <div style="text-align:right;">
                        <p style="font-size:13px;font-weight:700;color:#374151;margin:0;font-family:'DM Mono',monospace;">
                            {{ $item->created_at->format('H:i') }}
                        </p>
                        <p style="font-size:10.5px;color:#9ca3af;margin:2px 0 0;">WIB</p>
                    </div>

                    {{-- Check Icon --}}
                    <div style="width:28px;height:28px;border-radius:50%;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa fa-check" style="font-size:10px;color:#16a34a;"></i>
                    </div>
                </div>
            </div>

            @if(!$loop->last)
            <div style="border-bottom:1px solid #f9fafb;margin:0 14px;"></div>
            @endif
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    function selectPayGuest(method) {
        const cash = document.getElementById('pay-cash-label');
        const transfer = document.getElementById('pay-transfer-label');

        if (method === 'cash') {
            cash.style.cssText += ';border:2px solid #f97316;background:#fff7ed;';
            transfer.style.cssText += ';border:1px solid #e5e7eb;background:transparent;';
            cash.querySelector('i').style.color = '#f97316';
            cash.querySelector('span').style.color = '#ea580c';
            transfer.querySelector('i').style.color = '#9ca3af';
            transfer.querySelector('span').style.color = '#6b7280';
        } else {
            transfer.style.cssText += ';border:2px solid #f97316;background:#fff7ed;';
            cash.style.cssText += ';border:1px solid #e5e7eb;background:transparent;';
            transfer.querySelector('i').style.color = '#f97316';
            transfer.querySelector('span').style.color = '#ea580c';
            cash.querySelector('i').style.color = '#9ca3af';
            cash.querySelector('span').style.color = '#6b7280';
        }
        document.querySelector(`input[name="payment_method"][value="${method}"]`).checked = true;
    }

    function selectPayMember(method) {
        const cash = document.getElementById('mem-cash-label');
        const transfer = document.getElementById('mem-transfer-label');

        if (!cash || !transfer) return;

        if (method === 'cash') {
            cash.style.cssText += ';border:2px solid #2563eb;background:#eff6ff;';
            transfer.style.cssText += ';border:1px solid #e5e7eb;background:transparent;';
            cash.querySelector('i').style.color = '#2563eb';
            cash.querySelector('span').style.color = '#1d4ed8';
            transfer.querySelector('i').style.color = '#9ca3af';
            transfer.querySelector('span').style.color = '#6b7280';
        } else {
            transfer.style.cssText += ';border:2px solid #2563eb;background:#eff6ff;';
            cash.style.cssText += ';border:1px solid #e5e7eb;background:transparent;';
            transfer.querySelector('i').style.color = '#2563eb';
            transfer.querySelector('span').style.color = '#1d4ed8';
            cash.querySelector('i').style.color = '#9ca3af';
            cash.querySelector('span').style.color = '#6b7280';
        }
        document.querySelector(`input[name="payment_method"][value="${method}"]`).checked = true;
    }
</script>
@endpush