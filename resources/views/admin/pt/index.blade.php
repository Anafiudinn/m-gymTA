@extends('layouts.admin')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:9px;"></i></span>
            <span class="current">Sesi PT</span>
        </div>
        <h1 class="page-title">Personal Trainer Session</h1>
        <p class="page-sub">Kelola penggunaan sesi personal trainer member gym.</p>
    </div>

    {{-- Search --}}
    <form method="GET" style="display:flex;align-items:center;gap:8px;">
        <input type="hidden" name="tab" value="{{ request('tab', 'active') }}">
        <div style="position:relative;">
            <i class="fa fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:11px;pointer-events:none;"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama / kode / WA..."
                   style="padding:7px 12px 7px 30px;border:1px solid #e8ecf0;border-radius:8px;font-size:12.5px;
                          color:#1c2434;background:#fff;outline:none;width:220px;font-family:'Outfit',sans-serif;
                          transition:border-color .15s,box-shadow .15s;"
                   onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px #eff6ff';"
                   onblur="this.style.borderColor='#e8ecf0';this.style.boxShadow='none';">
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    </form>
</div>

{{-- Stat Cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:20px;">

    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;">
            <i class="fa fa-users" style="font-size:16px;color:#3b82f6;"></i>
        </div>
        <div>
            <div class="stat-label">PT Aktif</div>
            <div class="stat-value">{{ $totalActive }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;">
            <i class="fa fa-exclamation-triangle" style="font-size:16px;color:#f59e0b;"></i>
        </div>
        <div>
            <div class="stat-label">Hampir Habis</div>
            <div class="stat-value" style="color:#f59e0b;">{{ $lowSession }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fff1f2;">
            <i class="fa fa-ban" style="font-size:16px;color:#ef4444;"></i>
        </div>
        <div>
            <div class="stat-label">Sesi Habis</div>
            <div class="stat-value" style="color:#ef4444;">{{ $emptySession }}</div>
        </div>
    </div>

    <div class="stat-card" style="background:#1c2434;border-color:#2a3448;">
        <div class="stat-icon" style="background:rgba(255,255,255,.08);">
            <i class="fa fa-eye" style="font-size:16px;color:#adb8cc;"></i>
        </div>
        <div>
            <div class="stat-label" style="color:#adb8cc;">Ditampilkan</div>
            <div class="stat-value" style="color:#fff;">{{ $tab == 'history' ? $recentActivities->count() : $ptMemberships->count() }}</div>
        </div>
    </div>

</div>

{{-- Tabs --}}
<div style="display:flex;gap:8px;margin-bottom:16px;">
    <a href="?tab=active{{ request('search') ? '&search='.request('search') : '' }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12.5px;font-weight:600;text-decoration:none;transition:all .15s;
              {{ $tab == 'active' ? 'background:#1c2434;color:#fff;border:1px solid #1c2434;' : 'background:#fff;color:#64748b;border:1px solid #e8ecf0;' }}">
        <i class="fa fa-users" style="font-size:11px;"></i> Member Aktif
    </a>
    <a href="?tab=history{{ request('search') ? '&search='.request('search') : '' }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12.5px;font-weight:600;text-decoration:none;transition:all .15s;
              {{ $tab == 'history' ? 'background:#1c2434;color:#fff;border:1px solid #1c2434;' : 'background:#fff;color:#64748b;border:1px solid #e8ecf0;' }}">
        <i class="fa fa-history" style="font-size:11px;"></i> Recent Activity
    </a>
</div>

{{-- ── ACTIVE TAB ── --}}
@if($tab == 'active')
<div class="card" style="padding:0;overflow:hidden;">
    {{-- Card Header --}}
    <div style="padding:14px 18px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;justify-content:space-between;background:#f8fafc;">
        <div>
            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0 0 1px;">Data PT Member</p>
            <p style="font-size:11.5px;color:#94a3b8;margin:0;">List member dengan paket personal trainer aktif.</p>
        </div>
        <span class="pill pill-blue">{{ $ptMemberships->count() }} member</span>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Coach</th>
                    <th>Paket PT</th>
                    <th style="text-align:center;">Sisa Sesi</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ptMemberships as $pt)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:8px;background:#1c2434;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa fa-dumbbell" style="font-size:11px;color:#adb8cc;"></i>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:600;color:#1c2434;margin:0;line-height:1.3;">{{ $pt->user->name }}</p>
                                <p style="font-size:11px;color:#94a3b8;margin:0;font-family:'JetBrains Mono',monospace;">{{ $pt->user->member_code }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($pt->package && $pt->package->coach_name)
                            <p style="font-size:13px;font-weight:500;color:#1c2434;margin:0;">{{ $pt->package->coach_name }}</p>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $pt->package->coach_whatsapp) }}" target="_blank" style="font-size:12px;color:#3b82f6;">
                                {{ $pt->package->coach_whatsapp }}
                            </a>
                        @else
                            <span style="font-size:13px;font-style:italic;color:#94a3b8;">Tidak ada coach</span>
                        @endif
                    <td>
                        <span style="font-size:13px;font-weight:500;color:#1c2434;">{{ optional($pt->package)->nama_paket ?? '—' }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size:20px;font-weight:800;{{ $pt->remaining_sessions <= 3 ? 'color:#ef4444;' : 'color:#3b82f6;' }}">
                            {{ $pt->remaining_sessions }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        @if($pt->remaining_sessions <= 0)
                            <span class="pill pill-red">Habis</span>
                        @elseif($pt->remaining_sessions <= 3)
                            <span class="pill pill-amber">Low</span>
                        @else
                            <span class="pill pill-green">Active</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <form id="cut-form-{{ $pt->id }}" action="{{ route('admin.pt.cut', $pt->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="button"
                                    data-confirm
                                    data-confirm-title="Gunakan 1 Sesi PT?"
                                    data-confirm-desc="Sistem akan mengurangi 1 sesi PT untuk {{ $pt->user->name }}."
                                    data-confirm-type="warning"
                                    data-confirm-label="Ya, Gunakan"
                                    data-confirm-form="cut-form-{{ $pt->id }}"
                                    {{ $pt->remaining_sessions <= 0 ? 'disabled' : '' }}
                                    class="btn btn-sm {{ $pt->remaining_sessions <= 0 ? '' : 'btn-primary' }}"
                                    style="{{ $pt->remaining_sessions <= 0 ? 'background:#f1f5f9;color:#94a3b8;cursor:not-allowed;' : '' }}">
                                <i class="fa fa-minus-circle"></i> Gunakan Sesi
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:48px 24px;text-align:center;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                            <div style="width:44px;height:44px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                <i class="fa fa-dumbbell" style="font-size:18px;color:#cbd5e1;"></i>
                            </div>
                            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0;">Tidak Ada Member PT</p>
                            <p style="font-size:12px;color:#94a3b8;margin:0;">Member dengan paket PT aktif akan tampil di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($ptMemberships->hasPages())
    <div style="padding:12px 18px;border-top:1px solid #e8ecf0;background:#f8fafc;">
        {{ $ptMemberships->withQueryString()->links() }}
    </div>
    @endif
</div>
@endif

{{-- ── HISTORY TAB ── --}}
@if($tab == 'history')
<div class="card" style="padding:0;overflow:hidden;">
    <div style="padding:14px 18px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;justify-content:space-between;background:#f8fafc;">
        <div>
            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0 0 1px;">Recent PT Activity</p>
            <p style="font-size:11.5px;color:#94a3b8;margin:0;">Aktivitas penggunaan sesi PT terbaru member.</p>
        </div>
        <span class="pill pill-gray">{{ $recentActivities->count() }} aktivitas</span>
    </div>

    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Paket PT</th>
                    <th style="text-align:center;">Sisa Sesi</th>
                    <th style="text-align:center;">Digunakan</th>
                    <th>Coach</th>
                    <th style="text-align:right;">Last Activity</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentActivities as $activity)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:8px;background:#1c2434;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa fa-dumbbell" style="font-size:11px;color:#adb8cc;"></i>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:600;color:#1c2434;margin:0;line-height:1.3;">{{ $activity->user->name }}</p>
                                <p style="font-size:11px;color:#94a3b8;margin:0;font-family:'JetBrains Mono',monospace;">{{ $activity->user->member_code }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:13px;font-weight:500;color:#1c2434;">{{ optional($activity->package)->nama_paket ?? '—' }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size:20px;font-weight:800;color:#3b82f6;">{{ $activity->remaining_sessions }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span class="pill pill-red">{{ $activity->total_sessions - $activity->remaining_sessions }} sesi</span>
                    </td>
                    <td>
                        @if($activity->package && $activity->package->coach_name)
                            <p style="font-size:13px;font-weight:500;color:#1c2434;margin:0;">{{ $activity->package->coach_name }}</p>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $activity->package->coach_whatsapp) }}" target="_blank" style="font-size:12px;color:#3b82f6;">
                                {{ $activity->package->coach_whatsapp }}
                            </a>
                        @else
                            <span style="font-size:13px;font-style:italic;color:#94a3b8;">Tidak ada coach</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <span style="font-size:12px;color:#94a3b8;font-family:'JetBrains Mono',monospace;">
                            {{ $activity->updated_at->format('d M Y · H:i') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:48px 24px;text-align:center;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                            <div style="width:44px;height:44px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                <i class="fa fa-clock" style="font-size:18px;color:#cbd5e1;"></i>
                            </div>
                            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0;">Belum Ada Aktivitas PT</p>
                            <p style="font-size:12px;color:#94a3b8;margin:0;">Aktivitas penggunaan sesi PT akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection