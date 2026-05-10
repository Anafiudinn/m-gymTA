@extends('layouts.admin')

@section('content')

@php $activeTab = request('tab', 'aktivasi'); @endphp

{{-- Page Header --}}
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:9px;"></i></span>
            <span class="current">Beli Paket & Aktivasi</span>
        </div>
        <h1 class="page-title">Beli Paket & Aktivasi</h1>
        <p class="page-sub">Kelola pendaftaran member dan paket latihan</p>
    </div>
</div>

{{-- Error session --}}
@if(session('error'))
<div class="alert alert-error" style="margin-bottom:16px;">
    <div class="alert-icon"><i class="fa fa-search" style="font-size:11px;color:#dc2626;"></i></div>
    <div style="flex:1;">
        <p style="font-size:13px;font-weight:700;color:#b91c1c;margin:0 0 2px;">Data Tidak Ditemukan</p>
        <p style="font-size:12px;color:#b91c1c;margin:0 0 10px;">{{ session('error') }}</p>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('admin.package.index', ['tab' => 'aktivasi']) }}" class="btn btn-sm btn-primary">
                <i class="fa fa-user-plus"></i> Daftarkan Member
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-sm btn-secondary">Tamu Harian</a>
        </div>
    </div>
</div>
@endif

{{-- Tabs --}}
<div style="display:flex;gap:4px;margin-bottom:16px;background:#f1f5f9;padding:3px;border-radius:10px;width:fit-content;border:1px solid #e8ecf0;">
    @php
        $tabs = [
            'aktivasi' => ['label' => 'Aktivasi Member', 'color' => '#f97316'],
            'bulanan'  => ['label' => 'Paket Bulanan',   'color' => '#3b82f6'],
            'pt'       => ['label' => 'Paket PT',        'color' => '#1c2434'],
        ];
    @endphp
    @foreach($tabs as $key => $t)
    <a href="{{ route('admin.package.index', ['tab' => $key]) }}"
       style="padding:7px 16px;border-radius:7px;font-size:12.5px;font-weight:600;text-decoration:none;transition:all .15s;white-space:nowrap;
              {{ $activeTab == $key ? 'background:#fff;color:'.$t['color'].';box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
        {{ $t['label'] }}
    </a>
    @endforeach
</div>

{{-- ── MAIN GRID: form narrow, activity wide ── --}}
<div style="display:grid;grid-template-columns:320px 1fr;gap:16px;align-items:start;">

{{-- ══════════════════════════════════
     KOLOM KIRI — FORM
══════════════════════════════════ --}}
<div style="display:flex;flex-direction:column;gap:12px;">

    {{-- Search member --}}
    <div class="card" style="padding:14px;">
        <p style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin:0 0 10px;">
            <i class="fa fa-search" style="color:#3b82f6;margin-right:5px;font-size:10px;"></i> Cari Member
        </p>
        <form action="{{ route('admin.package.index') }}" method="GET" style="display:flex;flex-direction:column;gap:8px;">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="WA / Kode Member..."
                   class="form-input" style="padding:8px 11px;font-size:12.5px;">
            <button type="submit" class="btn btn-primary" style="padding:8px;font-size:12.5px;justify-content:center;">
                <i class="fa fa-search"></i> Cari Data
            </button>
        </form>
        @if($user)
        <div style="margin-top:10px;padding:10px 12px;background:#f8fafc;border:1px dashed #e8ecf0;border-radius:8px;">
            <p style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;margin:0 0 3px;">Member Terpilih</p>
            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0 0 1px;">{{ $user->name }}</p>
            <p style="font-size:11px;color:#94a3b8;margin:0 0 6px;font-family:'JetBrains Mono',monospace;">{{ $user->whatsapp }}</p>
            <span class="pill {{ $user->is_active_member ? 'pill-green' : 'pill-red' }}">
                {{ $user->is_active_member ? 'Member Aktif' : 'Belum Aktif' }}
            </span>
        </div>
        @endif
    </div>

    {{-- ══ TAB AKTIVASI ══ --}}
    @if($activeTab == 'aktivasi')
    @php
        $activationPrice = \App\Models\Setting::where('key','activation_member')->value('value') ?? 80000;
    @endphp
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:12px 14px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;gap:8px;background:#fff7ed;">
            <div style="width:28px;height:28px;border-radius:7px;background:#fed7aa;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa fa-user-plus" style="font-size:11px;color:#f97316;"></i>
            </div>
            <div>
                <p style="font-size:12.5px;font-weight:700;color:#1c2434;margin:0;line-height:1.3;">Aktivasi Member</p>
                <p style="font-size:10.5px;color:#94a3b8;margin:0;">Biaya: <strong style="color:#f97316;">Rp {{ number_format($activationPrice,0,',','.') }}</strong></p>
            </div>
        </div>
        <div style="padding:14px;">
            @if ($errors->has('whatsapp'))
            <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:8px;padding:9px 12px;font-size:12px;color:#b91c1c;margin-bottom:12px;">
                <i class="fa fa-exclamation-circle" style="margin-right:5px;"></i>{{ $errors->first('whatsapp') }}
            </div>
            @endif

            @if($user && $user->is_active_member)
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 12px;">
                <p style="font-size:12.5px;font-weight:700;color:#15803d;margin:0 0 2px;"><i class="fa fa-check-circle" style="margin-right:5px;"></i>Sudah Member Aktif</p>
                <p style="font-size:11px;color:#16a34a;margin:0;">Tidak perlu aktivasi ulang.</p>
            </div>

            @elseif($user && !$user->is_active_member)
            <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:10px 12px;margin-bottom:12px;">
                <p style="font-size:12px;font-weight:700;color:#9a3412;margin:0 0 2px;"><i class="fa fa-exclamation-triangle" style="margin-right:4px;"></i>Upgrade ke Member</p>
                <p style="font-size:11px;color:#c2410c;margin:0;">User pernah membeli paket non member.</p>
            </div>
            <form action="{{ route('admin.package.activate') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div>
                    <label class="form-label">Nama Member</label>
                    <div class="form-input" style="background:#f8fafc;color:#64748b;font-size:12.5px;cursor:default;">{{ $user->name }}</div>
                </div>
                <div>
                    <label class="form-label">Kode Member <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
                    <input type="text" name="member_code" value="{{ request('search') }}" placeholder="MBR001" class="form-input" style="font-size:12.5px;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    <div>
                        <label class="form-label">Biaya</label>
                        <div class="form-input" style="background:#f8fafc;font-weight:700;font-size:12.5px;cursor:default;">Rp {{ number_format($activationPrice,0,',','.') }}</div>
                    </div>
                    <div>
                        <label class="form-label">Metode</label>
                        <select name="payment_method" class="form-select" style="font-size:12.5px;">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="justify-content:center;background:#f97316;font-size:12.5px;padding:9px;">
                    <i class="fa fa-user-check"></i> AKTIVASI MEMBER
                </button>
            </form>

            @else
            <form action="{{ route('admin.package.activate') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                @csrf
                <div>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Johan Wijaya" class="form-input" style="font-size:12.5px;">
                </div>
                <div>
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" required placeholder="08xxxxxxxxxx" class="form-input" style="font-size:12.5px;">
                </div>
                <div>
                    <label class="form-label">Kode Member <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
                    <input type="text" name="member_code" value="{{ request('search') }}" placeholder="MBR001" class="form-input" style="font-size:12.5px;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    <div>
                        <label class="form-label">Biaya</label>
                        <div class="form-input" style="background:#f8fafc;font-weight:700;font-size:12.5px;cursor:default;">Rp {{ number_format($activationPrice,0,',','.') }}</div>
                    </div>
                    <div>
                        <label class="form-label">Metode</label>
                        <select name="payment_method" class="form-select" style="font-size:12.5px;">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="justify-content:center;background:#f97316;font-size:12.5px;padding:9px;">
                    <i class="fa fa-user-plus"></i> DAFTAR & AKTIFKAN
                </button>
            </form>
            @endif
        </div>
    </div>
    @endif

    {{-- ══ TAB BULANAN ══ --}}
    @if($activeTab == 'bulanan')
    @php
        $isMember = $user?->is_active_member ?? false;
        $monthlyPrice = $isMember
            ? (\App\Models\Setting::where('key','bulanan_member')->value('value') ?? 110000)
            : (\App\Models\Setting::where('key','bulanan_tamu')->value('value') ?? 200000);
    @endphp
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:12px 14px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;gap:8px;background:#eff6ff;">
            <div style="width:28px;height:28px;border-radius:7px;background:#bfdbfe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa fa-dumbbell" style="font-size:11px;color:#3b82f6;"></i>
            </div>
            <div>
                <p style="font-size:12.5px;font-weight:700;color:#1c2434;margin:0;">Paket Bulanan Gym</p>
                <p style="font-size:10.5px;color:#94a3b8;margin:0;">Member & non member</p>
            </div>
        </div>
        <div style="padding:14px;">
            {{-- Status badge --}}
            @if($user)
                @if($isMember)
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:9px 12px;margin-bottom:12px;">
                    <p style="font-size:12px;font-weight:700;color:#15803d;margin:0;"><i class="fa fa-check-circle" style="margin-right:4px;"></i>Member Aktif — harga khusus</p>
                </div>
                @else
                <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:9px 12px;margin-bottom:12px;">
                    <p style="font-size:12px;font-weight:700;color:#9a3412;margin:0;"><i class="fa fa-exclamation-triangle" style="margin-right:4px;"></i>Non Member — harga normal</p>
                </div>
                @endif
            @else
            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:9px 12px;margin-bottom:12px;">
                <p style="font-size:12px;font-weight:700;color:#1d4ed8;margin:0;"><i class="fa fa-user-plus" style="margin-right:4px;"></i>User baru dibuat otomatis</p>
            </div>
            @endif

            {{-- Harga display --}}
            <div style="text-align:center;padding:12px;border-radius:8px;border:1px solid {{ $isMember ? '#bfdbfe' : '#fed7aa' }};background:{{ $isMember ? '#eff6ff' : '#fff7ed' }};margin-bottom:12px;">
                <p style="font-size:10px;color:#94a3b8;margin:0 0 3px;">Harga Paket</p>
                <p style="font-size:22px;font-weight:800;margin:0;color:{{ $isMember ? '#2563eb' : '#ea580c' }};">Rp {{ number_format($monthlyPrice, 0, ',', '.') }}</p>
                <p style="font-size:10px;color:#94a3b8;margin:4px 0 0;">{{ $isMember ? 'harga member' : 'harga non member' }}</p>
            </div>

            <form action="{{ route('admin.package.buy') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                @csrf
                @if($user)
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                @else
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="guest_name" required placeholder="Johan Wijaya" class="form-input" style="font-size:12.5px;">
                    </div>
                    <div>
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="guest_whatsapp" required placeholder="08xxxxxxxxxx" class="form-input" style="font-size:12.5px;">
                    </div>
                @endif
                <div>
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="payment_method" class="form-select" style="font-size:12.5px;">
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="justify-content:center;font-size:12.5px;padding:9px;">
                    <i class="fa fa-credit-card"></i> BAYAR PAKET BULANAN
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- ══ TAB PT ══ --}}
    @if($activeTab == 'pt' && $user)
    @php
        $hasMonthlyPackage = \App\Models\Membership::where('user_id', $user->id)
            ->where('status','active')->where('end_date','>=',now())->exists();
        $canBuyPT = $user->is_active_member || $hasMonthlyPackage;
    @endphp
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:12px 14px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;gap:8px;background:#f8fafc;">
            <div style="width:28px;height:28px;border-radius:7px;background:#e2e8f0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa fa-user-ninja" style="font-size:11px;color:#475569;"></i>
            </div>
            <div>
                <p style="font-size:12.5px;font-weight:700;color:#1c2434;margin:0;">Paket Personal Trainer</p>
                <p style="font-size:10.5px;color:#94a3b8;margin:0;">Khusus member / paket bulanan aktif</p>
            </div>
        </div>
        <div style="padding:14px;">
            @if($canBuyPT)
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:9px 12px;margin-bottom:12px;">
                <p style="font-size:12px;font-weight:700;color:#15803d;margin:0;"><i class="fa fa-check-circle" style="margin-right:4px;"></i>Memenuhi syarat pembelian PT</p>
            </div>
            <form action="{{ route('admin.package.buy_pt') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div>
                    <label class="form-label">Pilih Paket PT</label>
                    <select name="pt_package_id" class="form-select" style="font-size:12.5px;">
                        @foreach($ptPackages as $package)
                        <option value="{{ $package->id }}">
                            {{ $package->nama_paket }} — {{ $package->jumlah_sesi }} sesi — Rp {{ number_format($package->harga, 0, ',', '.') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="payment_method" class="form-select" style="font-size:12.5px;">
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark" style="justify-content:center;font-size:12.5px;padding:9px;">
                    <i class="fa fa-dumbbell"></i> BELI PAKET PT
                </button>
            </form>
            @else
            <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:14px;">
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    <div style="width:32px;height:32px;border-radius:8px;background:#ffedd5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa fa-lock" style="color:#ea580c;font-size:12px;"></i>
                    </div>
                    <div>
                        <p style="font-size:12.5px;font-weight:700;color:#9a3412;margin:0 0 4px;">Akses PT Belum Tersedia</p>
                        <p style="font-size:11.5px;color:#c2410c;margin:0 0 10px;line-height:1.6;">Wajib aktivasi member ATAU punya paket bulanan aktif.</p>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <a href="{{ route('admin.package.index', ['tab'=>'aktivasi']) }}" class="btn btn-sm" style="background:#f97316;color:#fff;font-size:11.5px;">
                                <i class="fa fa-user-plus"></i> Aktivasi
                            </a>
                            <a href="{{ route('admin.package.index', ['tab'=>'bulanan','search'=>$user->member_code]) }}" class="btn btn-sm btn-primary" style="font-size:11.5px;">
                                <i class="fa fa-calendar"></i> Paket Bulanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

</div>{{-- end kolom kiri --}}

{{-- ══════════════════════════════════
     KOLOM KANAN — RIWAYAT AKTIVITAS
══════════════════════════════════ --}}
<div class="card" style="padding:0;overflow:hidden;min-height:500px;display:flex;flex-direction:column;">
    <div style="padding:14px 18px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;background:#f8fafc;">
        <div>
            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0 0 1px;">Aktivitas Hari Ini</p>
            <p style="font-size:11.5px;color:#94a3b8;margin:0;">Riwayat transaksi paket & aktivasi</p>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <span class="pill pill-gray">{{ now()->format('d M Y') }}</span>
            <span class="pill pill-blue">{{ $transactions->count() }} transaksi</span>
        </div>
    </div>

    @if($transactions->isEmpty())
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;padding:60px 24px;">
        <div style="width:44px;height:44px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
            <i class="fa fa-receipt" style="font-size:18px;color:#cbd5e1;"></i>
        </div>
        <p style="font-size:13px;color:#94a3b8;font-weight:500;margin:0;">Belum ada aktivitas hari ini</p>
    </div>
    @else
    <div style="flex:1;overflow-y:auto;padding:12px;">
        {{-- Summary bar --}}
        @php
            $totalToday = $transactions->where('status','success')->sum('amount');
            $countSuccess = $transactions->where('status','success')->count();
        @endphp
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:12px;">
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 12px;text-align:center;">
                <p style="font-size:10px;color:#16a34a;font-weight:700;text-transform:uppercase;margin:0 0 2px;">Sukses</p>
                <p style="font-size:18px;font-weight:800;color:#15803d;margin:0;">{{ $countSuccess }}</p>
            </div>
            <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:8px;padding:10px 12px;text-align:center;">
                <p style="font-size:10px;color:#dc2626;font-weight:700;text-transform:uppercase;margin:0 0 2px;">Dibatalkan</p>
                <p style="font-size:18px;font-weight:800;color:#b91c1c;margin:0;">{{ $transactions->where('status','cancelled')->count() }}</p>
            </div>
            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px 12px;text-align:center;">
                <p style="font-size:10px;color:#2563eb;font-weight:700;text-transform:uppercase;margin:0 0 2px;">Pendapatan</p>
                <p style="font-size:13px;font-weight:800;color:#1d4ed8;margin:0;">{{ number_format($totalToday/1000,0)}}rb</p>
            </div>
        </div>

        {{-- Transaction list --}}
        <div style="display:flex;flex-direction:column;gap:8px;">
        @foreach($transactions as $trx)
        <div style="border:1px solid #e8ecf0;border-radius:10px;padding:12px 14px;transition:background .12s;background:#fff;"
             onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
                <div style="flex:1;min-width:0;">
                    {{-- Category + invoice --}}
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:5px;flex-wrap:wrap;">
                        @if($trx->category == 'activation')
                            <span class="pill pill-amber">Aktivasi</span>
                        @elseif($trx->category == 'monthly')
                            <span class="pill pill-blue">Bulanan</span>
                        @elseif($trx->category == 'pt')
                            <span class="pill pill-gray">PT</span>
                        @endif
                        <span style="font-size:10.5px;color:#94a3b8;font-family:'JetBrains Mono',monospace;">{{ $trx->invoice_code }}</span>
                    </div>
                    {{-- Name --}}
                    <p style="font-size:13px;font-weight:700;color:#1c2434;margin:0 0 1px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ optional($trx->user)->name ?? '-' }}
                    </p>
                    {{-- Meta --}}
                    <p style="font-size:11px;color:#94a3b8;margin:0;font-family:'JetBrains Mono',monospace;">
                        {{ optional($trx->user)->member_code ?? '-' }} · {{ ucfirst($trx->payment_method) }} · {{ $trx->created_at->format('H:i') }}
                    </p>
                </div>
                {{-- Right: amount + status + cancel --}}
                <div style="text-align:right;flex-shrink:0;">
                    <p style="font-size:14px;font-weight:800;color:#1c2434;margin:0 0 4px;">Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                    @if($trx->status == 'success')
                        <span class="pill pill-green">Sukses</span>
                    @elseif($trx->status == 'cancelled')
                        <span class="pill pill-red">Dibatalkan</span>
                    @else
                        <span class="pill pill-gray">{{ strtoupper($trx->status) }}</span>
                    @endif

                    @if($trx->status == 'success' && $trx->created_at->isToday())
                    <form action="{{ route('admin.package.transaction.cancel', $trx->id) }}" method="POST" style="margin-top:6px;">
                        @csrf @method('PATCH')
                        <button type="button"
                            style="font-size:11px;font-weight:600;color:#ef4444;background:none;border:none;cursor:pointer;font-family:'Outfit',sans-serif;padding:0;transition:color .15s;"
                            onmouseover="this.style.color='#b91c1c'" onmouseout="this.style.color='#ef4444'"
                            onclick="UBConfirm.ask({title:'Batalkan Transaksi?',desc:'Transaksi ini akan dibatalkan dan tidak bisa dikembalikan.',type:'danger',label:'Ya, Batalkan'}).then(ok=>{ if(ok) this.closest('form').submit(); })">
                            <i class="fa fa-times-circle" style="margin-right:2px;"></i> Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        </div>
    </div>
    @endif
</div>{{-- end kolom kanan --}}

</div>{{-- end grid --}}

{{-- Responsive: stack on mobile --}}
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:320px"] {
        display: flex !important;
        flex-direction: column !important;
    }
}
</style>

@endsection