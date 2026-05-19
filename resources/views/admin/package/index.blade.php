@extends('layouts.admin')

@section('title', 'Paket & Aktivasi')
@section('header-title', 'Paket & Aktivasi')

@section('content')

@php $activeTab = request('tab', 'aktivasi'); @endphp

{{-- ═══ PAGE HEADER ═══ --}}
<div style="margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:var(--muted);margin-bottom:6px;">
        <i class="fa-solid fa-house" style="font-size:10px;"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;"></i>
        <span style="color:var(--text);font-weight:600;">Paket & Aktivasi</span>
    </div>
    <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 2px;">Paket & Aktivasi</h1>
    <p style="font-size:12px;color:var(--muted);margin:0;">Kelola pendaftaran member dan pembelian paket latihan</p>
</div>
{{-- succes alert --}}
@if(session('success'))
<div style="display:flex;gap:12px;align-items:flex-start;background:#fff;border:1px solid var(--border);border-left:3px solid rgba(34,197,94,.8);border-radius:var(--radius);padding:14px 16px;margin-bottom:20px;">
    <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(34,197,94,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-circle-check" style="font-size:13px;color:#22c55e;"></i>
    </div>
    <div style="flex:1;">
        <p style="font-size:13px;font-weight:700;color:#15803d;margin:0 0 2px;">{{ session('success') }}</p>
    </div>
</div>
@endif
{{-- ═══ ERROR ALERT ═══ --}}
@if(session('error'))
<div style="display:flex;gap:12px;align-items:flex-start;background:#fff;border:1px solid var(--border);border-left:3px solid var(--red);border-radius:var(--radius);padding:14px 16px;margin-bottom:20px;">
    <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-circle-exclamation" style="font-size:13px;color:var(--red);"></i>
    </div>
    <div style="flex:1;">
        <p style="font-size:13px;font-weight:700;color:var(--text);margin:0 0 2px;">Data Tidak Ditemukan</p>
        <p style="font-size:12px;color:var(--muted);margin:0 0 10px;">{{ session('error') }}</p>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('admin.package.index', ['tab'=>'aktivasi']) }}"
               style="display:inline-flex;align-items:center;gap:6px;background:var(--red);color:#fff;font-size:12px;font-weight:700;padding:7px 14px;border-radius:var(--radius);text-decoration:none;">
                <i class="fa-solid fa-user-plus" style="font-size:10px;"></i> Daftarkan Member
            </a>
            <a href="{{ route('admin.attendance.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;background:#fff;color:var(--muted);border:1px solid var(--border);font-size:12px;font-weight:700;padding:7px 14px;border-radius:var(--radius);text-decoration:none;">
                Tamu Harian
            </a>
        </div>
    </div>
</div>
@endif

{{-- ═══ TAB NAV ═══ --}}
@php
    $tabs = [
        'aktivasi' => ['label' => 'Aktivasi Member', 'icon' => 'fa-user-plus'],
        'bulanan'  => ['label' => 'Paket Bulanan',   'icon' => 'fa-calendar-days'],
        'pt'       => ['label' => 'Paket PT',        'icon' => 'fa-dumbbell'],
    ];
@endphp
<div style="display:flex;gap:6px;margin-bottom:20px;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:5px;width:fit-content;">
    @foreach($tabs as $key => $t)
    <a href="{{ route('admin.package.index', ['tab'=>$key]) }}"
       style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:var(--radius);font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;white-space:nowrap;
              {{ $activeTab == $key
                 ? 'background:var(--red);color:#fff;box-shadow:0 3px 10px rgba(239,68,68,.25);'
                 : 'color:var(--muted);background:transparent;' }}">
        <i class="fa-solid {{ $t['icon'] }}" style="font-size:10px;"></i> {{ $t['label'] }}
    </a>
    @endforeach
</div>

{{-- ═══ 2-COLUMN GRID ═══ --}}
<div style="display:grid;grid-template-columns:340px 1fr;gap:16px;align-items:start;">

    {{-- ══════════════════════════════════
         LEFT — FORM
    ══════════════════════════════════ --}}
    <div style="display:flex;flex-direction:column;gap:12px;">

        {{-- ─── Cari Member ─── --}}
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
                <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size:11px;color:var(--red);"></i>
                </div>
                <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">Cari Member</p>
            </div>
            <div style="padding:14px;">
                <form action="{{ route('admin.package.index') }}" method="GET" style="display:flex;flex-direction:column;gap:8px;">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <div style="position:relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:10px;color:var(--muted);pointer-events:none;"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="WA / Kode Member..."
                               style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px 9px 30px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                    <button type="submit"
                        style="width:100%;background:var(--text);color:#fff;font-weight:700;font-size:12.5px;padding:9px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;font-family:'Outfit',sans-serif;transition:background .15s;"
                        onmouseover="this.style.background='#333'" onmouseout="this.style.background='var(--text)'">
                        <i class="fa-solid fa-magnifying-glass" style="font-size:10px;"></i> Cari Data
                    </button>
                </form>

                {{-- Member found chip --}}
                @if($user)
                <div style="margin-top:10px;padding:12px;background:#fafafa;border:1px solid var(--border);border-radius:var(--radius);display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--red),#991b1b);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="font-size:11px;font-weight:800;color:#fff;">{{ strtoupper(substr($user->name,0,2)) }}</span>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $user->name }}</p>
                        <p style="font-size:11px;color:var(--muted);margin:1px 0 0;">{{ $user->whatsapp }}</p>
                    </div>
                    <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;flex-shrink:0;
                          {{ $user->is_active_member ? 'background:rgba(34,197,94,.1);color:#15803d;' : 'background:rgba(239,68,68,.08);color:var(--red);' }}">
                        {{ $user->is_active_member ? 'Aktif' : 'Non Member' }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        {{-- ─── TAB: AKTIVASI ─── --}}
        @if($activeTab == 'aktivasi')
        @php $activationPrice = \App\Models\Setting::where('key','activation_member')->value('value') ?? 80000; @endphp
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
                <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-user-plus" style="font-size:11px;color:var(--red);"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">Aktivasi Member</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">Biaya: <strong style="color:var(--text);">Rp {{ number_format($activationPrice,0,',','.') }}</strong></p>
                </div>
            </div>
            <div style="padding:16px;">
                {{-- WA error --}}
                @if($errors->has('whatsapp'))
                <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid var(--red);border-radius:var(--radius);padding:10px 12px;font-size:12px;color:var(--red);margin-bottom:12px;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right:5px;"></i>{{ $errors->first('whatsapp') }}
                </div>
                @endif

                @if($user && $user->is_active_member)
                {{-- Already active --}}
                <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid #22c55e;border-radius:var(--radius);padding:12px 14px;">
                    <p style="font-size:13px;font-weight:700;color:#15803d;margin:0 0 2px;"><i class="fa-solid fa-circle-check" style="margin-right:6px;"></i>Sudah Member Aktif</p>
                    <p style="font-size:11.5px;color:var(--muted);margin:0;">Tidak perlu aktivasi ulang.</p>
                </div>

                @elseif($user && !$user->is_active_member)
                {{-- Upgrade existing user --}}
                <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid #f59e0b;border-radius:var(--radius);padding:10px 12px;margin-bottom:14px;">
                    <p style="font-size:12px;font-weight:700;color:var(--text);margin:0 0 2px;"><i class="fa-solid fa-triangle-exclamation" style="margin-right:5px;color:#f59e0b;"></i>Upgrade Menjadi Member</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">User pernah membeli paket non member.</p>
                </div>
                <form action="{{ route('admin.package.activate') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Nama Member</label>
                        <div style="border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--muted);background:#fafafa;">{{ $user->name }}</div>
                    </div>
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Kode Member <span style="color:var(--text);font-weight:400;">(opsional)</span></label>
                        <input type="text" name="member_code" value="{{ request('search') }}" placeholder="MBR001"
                               style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        <div>
                            <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Biaya</label>
                            <div style="border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;font-weight:700;color:var(--text);background:#fafafa;">Rp {{ number_format($activationPrice,0,',','.') }}</div>
                        </div>
                        <div>
                            <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Metode</label>
                            <select name="payment_method"
                                    style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                                    onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                                    onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit"
                        data-confirm="Pastikan data member sudah benar sebelum melanjutkan aktivasi."
                        data-confirm-title="Aktivasi Member?"
                        data-confirm-type="info"
                        data-confirm-ok="Ya, Aktivasi"
                        style="width:100%;background:var(--red);color:#fff;font-weight:700;font-size:13px;padding:11px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Outfit',sans-serif;box-shadow:0 4px 12px rgba(239,68,68,.2);transition:background .15s;"
                        onmouseover="this.style.background='var(--red-dark)'" onmouseout="this.style.background='var(--red)'">
                        <i class="fa-solid fa-user-check"></i> Aktivasi Member
                    </button>
                </form>

                @else
                {{-- New member --}}
                <form action="{{ route('admin.package.activate') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                    @csrf
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Nama Lengkap <span style="color:var(--red);">*</span></label>
                        <input type="text" name="name" required placeholder="Johan Wijaya"
                               style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Nomor WhatsApp <span style="color:var(--red);">*</span></label>
                        <input type="text" name="whatsapp" required placeholder="08xxxxxxxxxx"
                               style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Kode Member <span style="color:var(--text);font-weight:400;">(opsional)</span></label>
                        <input type="text" name="member_code" value="{{ request('search') }}" placeholder="MBR001"
                               style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        <div>
                            <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Biaya</label>
                            <div style="border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;font-weight:700;color:var(--text);background:#fafafa;">Rp {{ number_format($activationPrice,0,',','.') }}</div>
                        </div>
                        <div>
                            <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Metode</label>
                            <select name="payment_method"
                                    style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                                    onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                                    onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit"
                        data-confirm="Data member baru akan didaftarkan dan langsung diaktivasi."
                        data-confirm-title="Daftar & Aktivasi Member?"
                        data-confirm-type="info"
                        data-confirm-ok="Ya, Daftarkan"
                        style="width:100%;background:var(--red);color:#fff;font-weight:700;font-size:13px;padding:11px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Outfit',sans-serif;box-shadow:0 4px 12px rgba(239,68,68,.2);transition:background .15s;"
                        onmouseover="this.style.background='var(--red-dark)'" onmouseout="this.style.background='var(--red)'">
                        <i class="fa-solid fa-user-plus"></i> Daftar & Aktivasi Member
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endif

        {{-- ─── TAB: BULANAN ─── --}}
        @if($activeTab == 'bulanan')
        @php
            $isMember     = $user?->is_active_member ?? false;
            $monthlyPrice = $isMember
                ? (\App\Models\Setting::where('key','bulanan_member')->value('value') ?? 110000)
                : (\App\Models\Setting::where('key','bulanan_tamu')->value('value') ?? 200000);
        @endphp
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
                <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-calendar-days" style="font-size:11px;color:var(--red);"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">Paket Membership Bulanan</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">Member & non member</p>
                </div>
            </div>
            <div style="padding:16px;">
                {{-- Status notice --}}
                @if($user)
                    @if($isMember)
                    <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid #22c55e;border-radius:var(--radius);padding:10px 12px;margin-bottom:12px;">
                        <p style="font-size:12px;font-weight:700;color:#15803d;margin:0;"><i class="fa-solid fa-circle-check" style="margin-right:5px;"></i>Membership Aktif — harga khusus</p>
                    </div>
                    @else
                    <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid #f59e0b;border-radius:var(--radius);padding:10px 12px;margin-bottom:12px;">
                        <p style="font-size:12px;font-weight:700;color:var(--text);margin:0;"><i class="fa-solid fa-triangle-exclamation" style="margin-right:5px;color:#f59e0b;"></i>Non Member — harga normal</p>
                    </div>
                    @endif
                @else
                <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid var(--red);border-radius:var(--radius);padding:10px 12px;margin-bottom:12px;">
                    <p style="font-size:12px;font-weight:700;color:var(--text);margin:0;"><i class="fa-solid fa-user-plus" style="margin-right:5px;color:var(--red);"></i>User baru akan dibuat otomatis</p>
                </div>
                @endif

                {{-- Price display --}}
                <div style="border:1px solid var(--border);border-radius:var(--radius);padding:14px;text-align:center;background:#fafafa;margin-bottom:14px;">
                    <p style="font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin:0 0 4px;">Harga Paket</p>
                    <p style="font-size:24px;font-weight:800;color:var(--text);margin:0;">Rp {{ number_format($monthlyPrice,0,',','.') }}</p>
                    <p style="font-size:11px;color:var(--muted);margin:4px 0 0;">{{ $isMember ? 'harga sudah aktivasi member' : 'harga non aktivasi member' }}</p>
                </div>

                <form action="{{ route('admin.package.buy') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                    @csrf
                    @if($user)
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                    @else
                        <div>
                            <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Nama Lengkap <span style="color:var(--red);">*</span></label>
                            <input type="text" name="guest_name" required placeholder="Johan Wijaya"
                                   style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                                   onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                        </div>
                        <div>
                            <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Nomor WhatsApp <span style="color:var(--red);">*</span></label>
                            <input type="text" name="guest_whatsapp" required placeholder="08xxxxxxxxxx"
                                   style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;box-sizing:border-box;background:#fff;transition:border-color .15s,box-shadow .15s;"
                                   onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                        </div>
                    @endif
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Metode Pembayaran</label>
                        <select name="payment_method"
                                style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                                onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <button type="submit"
                        data-confirm="Konfirmasi pembelian paket bulanan Rp {{ number_format($monthlyPrice,0,',','.') }}."
                        data-confirm-title="Bayar Paket Bulanan?"
                        data-confirm-type="info"
                        data-confirm-ok="Ya, Bayar"
                        style="width:100%;background:var(--red);color:#fff;font-weight:700;font-size:13px;padding:11px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Outfit',sans-serif;box-shadow:0 4px 12px rgba(239,68,68,.2);transition:background .15s;"
                        onmouseover="this.style.background='var(--red-dark)'" onmouseout="this.style.background='var(--red)'">
                        <i class="fa-solid fa-credit-card"></i> Bayar Paket Bulanan
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- ─── TAB: PT ─── --}}
        @if($activeTab == 'pt')
        @php
            $hasMonthlyPackage = $user
                ? \App\Models\Membership::where('user_id',$user->id)->where('status','active')->where('end_date','>=',now())->exists()
                : false;
            $canBuyPT = $user && ($user->is_active_member || $hasMonthlyPackage);
        @endphp
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
                <div style="width:30px;height:30px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-dumbbell" style="font-size:11px;color:var(--red);"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">Paket Personal Trainer</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">Khusus member / paket bulanan aktif</p>
                </div>
            </div>
            <div style="padding:16px;">
                @if(!$user)
                <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid var(--muted);border-radius:var(--radius);padding:12px 14px;text-align:center;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size:20px;color:#ddd;display:block;margin-bottom:8px;"></i>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0 0 3px;">Cari member terlebih dahulu</p>
                    <p style="font-size:11.5px;color:var(--muted);margin:0;">Gunakan form cari di atas</p>
                </div>

                @elseif($canBuyPT)
                <div style="background:#fafafa;border:1px solid var(--border);border-left:3px solid #22c55e;border-radius:var(--radius);padding:10px 12px;margin-bottom:14px;">
                    <p style="font-size:12px;font-weight:700;color:#15803d;margin:0;"><i class="fa-solid fa-circle-check" style="margin-right:5px;"></i>Memenuhi syarat pembelian PT</p>
                </div>
                <form action="{{ route('admin.package.buy_pt') }}" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Pilih Paket PT</label>
                        <select name="pt_package_id"
                                style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                                onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                            @foreach($ptPackages as $package)
                            <option value="{{ $package->id }}">
                                {{ $package->nama_paket }} — {{ $package->jumlah_sesi }} sesi — Rp {{ number_format($package->harga,0,',','.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Metode Pembayaran</label>
                        <select name="payment_method"
                                style="width:100%;border:1px solid var(--border);border-radius:var(--radius);padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:'Outfit',sans-serif;background:#fff;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                                onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.08)';"
                                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <button type="submit"
                        data-confirm="Konfirmasi pembelian paket Personal Trainer untuk {{ $user->name }}."
                        data-confirm-title="Beli Paket PT?"
                        data-confirm-type="info"
                        data-confirm-ok="Ya, Beli"
                        style="width:100%;background:var(--red);color:#fff;font-weight:700;font-size:13px;padding:11px;border-radius:var(--radius);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Outfit',sans-serif;box-shadow:0 4px 12px rgba(239,68,68,.2);transition:background .15s;"
                        onmouseover="this.style.background='var(--red-dark)'" onmouseout="this.style.background='var(--red)'">
                        <i class="fa-solid fa-dumbbell"></i> Beli Paket PT
                    </button>
                </form>

                @else
                <div style="background:#fafafa;border:1px solid var(--border);border-radius:var(--radius);padding:16px;">
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:32px;height:32px;border-radius:var(--radius);background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-lock" style="color:var(--red);font-size:12px;"></i>
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:700;color:var(--text);margin:0 0 4px;">Akses PT Belum Tersedia</p>
                            <p style="font-size:11.5px;color:var(--muted);margin:0 0 12px;line-height:1.6;">Wajib aktivasi member <strong>atau</strong> punya paket bulanan aktif.</p>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <a href="{{ route('admin.package.index',['tab'=>'aktivasi']) }}"
                                   style="display:inline-flex;align-items:center;gap:6px;background:var(--red);color:#fff;font-size:12px;font-weight:700;padding:7px 14px;border-radius:var(--radius);text-decoration:none;">
                                    <i class="fa-solid fa-user-plus" style="font-size:10px;"></i> Aktivasi
                                </a>
                                <a href="{{ route('admin.package.index',['tab'=>'bulanan','search'=>$user->member_code]) }}"
                                   style="display:inline-flex;align-items:center;gap:6px;background:#fff;color:var(--muted);border:1px solid var(--border);font-size:12px;font-weight:700;padding:7px 14px;border-radius:var(--radius);text-decoration:none;">
                                    <i class="fa-solid fa-calendar-days" style="font-size:10px;"></i> Paket Bulanan
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
         RIGHT — RIWAYAT AKTIVITAS
    ══════════════════════════════════ --}}
    <div class="card" style="padding:0;overflow:hidden;min-height:500px;display:flex;flex-direction:column;">

        {{-- Header --}}
        <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:30px;height:30px;border-radius:var(--radius);background:#fafafa;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size:11px;color:var(--muted);"></i>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:var(--text);margin:0;">Aktivitas Hari Ini</p>
                    <p style="font-size:11px;color:var(--muted);margin:0;">Riwayat transaksi paket & aktivasi</p>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <span style="font-size:11px;font-weight:600;color:var(--muted);background:#fafafa;border:1px solid var(--border);padding:3px 10px;border-radius:999px;">
                    {{ now()->format('d M Y') }}
                </span>
                <span style="font-size:11px;font-weight:700;color:var(--text);background:#fafafa;border:1px solid var(--border);padding:3px 10px;border-radius:999px;">
                    {{ $transactions->count() }} transaksi
                </span>
            </div>
        </div>

        @if($transactions->isEmpty())
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;padding:60px 24px;">
            <div style="width:44px;height:44px;border-radius:var(--radius);background:#fafafa;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-receipt" style="font-size:18px;color:#ddd;"></i>
            </div>
            <p style="font-size:13px;color:var(--muted);font-weight:500;margin:0;">Belum ada aktivitas hari ini</p>
        </div>

        @else
        {{-- Summary bar --}}
        @php
            $totalToday   = $transactions->where('status','success')->sum('amount');
            $countSuccess = $transactions->where('status','success')->count();
            $countCancel  = $transactions->where('status','cancelled')->count();
        @endphp
        <div style="display:grid;grid-template-columns:repeat(3,1fr);background:#fafafa;border-bottom:1px solid var(--border);">
            <div style="padding:12px 16px;text-align:center;border-right:1px solid var(--border);">
                <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin:0 0 3px;">Sukses</p>
                <p style="font-size:20px;font-weight:800;color:var(--text);margin:0;">{{ $countSuccess }}</p>
            </div>
            <div style="padding:12px 16px;text-align:center;border-right:1px solid var(--border);">
                <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin:0 0 3px;">Dibatalkan</p>
                <p style="font-size:20px;font-weight:800;color:var(--red);margin:0;">{{ $countCancel }}</p>
            </div>
            <div style="padding:12px 16px;text-align:center;">
                <p style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin:0 0 3px;">Pendapatan</p>
                <p style="font-size:15px;font-weight:800;color:var(--text);margin:0;">Rp {{ number_format($totalToday,0,',','.') }}</p>
            </div>
        </div>

        {{-- List --}}
        <div style="flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;">
            @foreach($transactions as $trx)
            <div style="border:1px solid var(--border);border-radius:var(--radius);padding:12px 14px;background:#fff;transition:background .12s;"
                 onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">

                    {{-- Left --}}
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:6px;margin-bottom:5px;flex-wrap:wrap;">
                            {{-- Category badge --}}
                            @if($trx->category == 'activation')
                            <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:rgba(239,68,68,.08);color:var(--red);">Aktivasi Member</span>
                            @elseif($trx->category == 'monthly')
                            <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:#fafafa;border:1px solid var(--border);color:var(--muted);">Membership Bulanan</span>
                            @elseif($trx->category == 'pt')
                            <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:#fafafa;border:1px solid var(--border);color:var(--muted);">Paket PT</span>
                            @endif
                            {{-- Invoice --}}
                            <span style="font-size:10.5px;color:var(--muted);font-variant-numeric:tabular-nums;">{{ $trx->invoice_code }}</span>
                        </div>
                        <p style="font-size:13px;font-weight:700;color:var(--text);margin:0 0 2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ optional($trx->user)->name ?? '-' }}
                        </p>
                        <p style="font-size:11px;color:var(--muted);margin:0;font-variant-numeric:tabular-nums;">
                            {{ optional($trx->user)->member_code ?? '-' }} · {{ ucfirst($trx->payment_method) }} · {{ $trx->created_at->format('H:i') }}
                        </p>
                    </div>

                    {{-- Right --}}
                    <div style="text-align:right;flex-shrink:0;">
                        <p style="font-size:14px;font-weight:800;color:var(--text);margin:0 0 5px;">Rp {{ number_format($trx->amount,0,',','.') }}</p>
                        @if($trx->status == 'success')
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:rgba(34,197,94,.1);color:#15803d;">Sukses</span>
                        @elseif($trx->status == 'cancelled')
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:rgba(239,68,68,.08);color:var(--red);">Dibatalkan</span>
                        @else
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;background:#fafafa;border:1px solid var(--border);color:var(--muted);">{{ strtoupper($trx->status) }}</span>
                        @endif

                        @if($trx->status == 'success' && $trx->created_at->isToday())
                        <form action="{{ route('admin.package.transaction.cancel',$trx->id) }}" method="POST" style="margin-top:6px;">
                            @csrf @method('PATCH')
                            <button type="button"
                                style="font-size:11px;font-weight:600;color:var(--red);background:none;border:none;cursor:pointer;font-family:'Outfit',sans-serif;padding:0;display:inline-flex;align-items:center;gap:4px;transition:opacity .15s;"
                                onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'"
                                data-confirm="Transaksi ini akan dibatalkan dan tidak bisa dikembalikan."
                                data-confirm-title="Batalkan Transaksi?"
                                data-confirm-type="danger"
                                data-confirm-ok="Ya, Batalkan">
                                <i class="fa-solid fa-xmark" style="font-size:10px;"></i> Batalkan
                            </button>
                        </form>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>{{-- end kolom kanan --}}

</div>{{-- end grid --}}

<style>
@media(max-width:900px){
    div[style*="grid-template-columns:340px"]{
        grid-template-columns:1fr !important;
    }
}
</style>


@endsection