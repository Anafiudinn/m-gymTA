{{-- resources/views/owner/members/index.blade.php --}}

@extends('layouts.owner')

@section('title', 'Monitoring Member')

@section('content')
<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- HEADER --}}
    <div>
        <h1 style="font-size:22px; font-weight:700; color:#111;">
            Monitoring Member
        </h1>
        <p style="font-size:14px; color:#999; margin-top:4px;">
            Data member yang sudah melakukan aktivasi atau pembelian paket gym.
        </p>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px;">
            <div style="width:48px; height:48px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-users" style="color:#555; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Member</div>
                <div style="font-size:28px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">{{ $totalMembers }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-circle-check" style="color:#16a34a; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Sudah Aktivasi</div>
                <div style="font-size:28px; font-weight:800; color:#16a34a; line-height:1.2; margin-top:2px;">{{ $activeMembers }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#fff1f2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-clock" style="color:var(--red); font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Belum Aktivasi</div>
                <div style="font-size:28px; font-weight:800; color:var(--red); line-height:1.2; margin-top:2px;">{{ $inactiveMembers }}</div>
            </div>
        </div>

    </div>

    {{-- FILTER --}}
    <form method="GET" class="card" style="padding:18px 22px; border-radius:1px;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Cari Member</label>
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Nama / WhatsApp / Kode Member"
                       style="width:100%; border:1px solid var(--border); border-radius:1px; padding:10px 14px; font-size:13px; font-family:'Outfit',sans-serif; outline:none; color:#111; background:#fafafa; transition:.15s ease;"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;">Status Aktivasi</label>
                <select name="status"
                        style="width:100%; border:1px solid var(--border); border-radius:1px; padding:10px 14px; font-size:13px; font-family:'Outfit',sans-serif; outline:none; color:#111; background:#fafafa; transition:.15s ease; appearance:none; cursor:pointer;"
                        onfocus="this.style.borderColor='var(--red)'"
                        onblur="this.style.borderColor='var(--border)'">
                    <option value="">Semua Status</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Sudah Aktivasi</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Belum Aktivasi</option>
                </select>
            </div>

            <div style="display:flex; align-items:flex-end;">
                <button type="submit"
                        style="width:100%; background:var(--red); color:#fff; border:none; padding:10px 18px; border-radius:1px; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.18s ease; display:flex; align-items:center; justify-content:center; gap:6px;"
                        onmouseover="this.style.background='var(--red-dark)'"
                        onmouseout="this.style.background='var(--red)'">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Filter Data
                </button>
            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="card" style="padding:0; overflow:hidden; border-radius:1px;">

        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:16px; font-weight:700; color:#111;">
                <i class="fa-solid fa-table-list" style="color:var(--red); margin-right:8px;"></i>
                Data Member Gym
            </span>
            <span style="font-size:12px; color:#999;">{{ $members->total() }} member</span>
        </div>

        @if($members->count() == 0)
            <div style="padding:64px; text-align:center; color:#bbb; font-size:14px;">
                <i class="fa-solid fa-users-slash" style="font-size:36px; display:block; margin-bottom:12px; opacity:.35;"></i>
                Belum ada data member
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9f9f9;">
                            <th style="padding:12px 22px; text-align:left; font-size:12px; font-weight:700;  text-transform:uppercase; letter-spacing:.1em;">Member</th>
                            <th style="padding:12px 22px; text-align:left; font-size:12px; font-weight:700;  text-transform:uppercase; letter-spacing:.1em;">WhatsApp</th>
                            <th style="padding:12px 22px; text-align:left; font-size:12px; font-weight:700;  text-transform:uppercase; letter-spacing:.1em;">Kode Member</th>
                            <th style="padding:12px 22px; text-align:left; font-size:12px; font-weight:700;  text-transform:uppercase; letter-spacing:.1em;">Status Aktivasi</th>
                            <th style="padding:12px 22px; text-align:left; font-size:12px; font-weight:700;  text-transform:uppercase; letter-spacing:.1em;">Paket Bulanan</th>
                            <th style="padding:12px 22px; text-align:left; font-size:12px; font-weight:700;  text-transform:uppercase; letter-spacing:.1em;">Bergabung</th>
                            <th style="padding:12px 22px; text-align:right; font-size:12px; font-weight:700;  text-transform:uppercase; letter-spacing:.1em;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($members as $member)
                            @php
                                $activePackage = $member->memberships
                                    ->where('status', 'active')
                                    ->first();
                            @endphp

                            <tr style="border-top:1px solid var(--border); transition:.15s ease;"
                                onmouseover="this.style.background='#fafafa'"
                                onmouseout="this.style.background='transparent'">

                                {{-- MEMBER --}}
                                <td style="padding:14px 22px;">
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <div style="width:36px; height:36px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; color:#fff; flex-shrink:0;">
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        </div>
                                        <span style="font-size:14px; font-weight:600; color:#111;">{{ $member->name }}</span>
                                    </div>
                                </td>

                                {{-- WHATSAPP --}}
                                <td style="padding:14px 22px; font-size:14px; color:#555;">
                                    <i class="fa-brands fa-whatsapp" style="color:#25d366; margin-right:5px;"></i>
                                    {{ $member->whatsapp }}
                                </td>

                                {{-- KODE MEMBER --}}
                                <td style="padding:14px 22px;">
                                    @if($member->member_code)
                                        <span style="font-size:12px; font-weight:700; color:#555; background:#f5f5f5; padding:4px 10px; border-radius:1px; font-family:monospace;">
                                            {{ $member->member_code }}
                                        </span>
                                    @else
                                        <span style="font-size:14px; color:#ccc;">—</span>
                                    @endif
                                </td>

                                {{-- STATUS AKTIVASI --}}
                                <td style="padding:14px 22px;">
                                    @if($member->is_active_member)
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:1px; font-size:12px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                                            <i class="fa-solid fa-circle-check" style="font-size:10px;"></i>
                                            Sudah Aktivasi
                                        </span>
                                    @else
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:1px; font-size:12px; font-weight:700; background:#fff1f2; color:#be123c; border:1px solid #fecdd3;">
                                            <i class="fa-solid fa-clock" style="font-size:10px;"></i>
                                            Belum Aktivasi
                                        </span>
                                    @endif
                                </td>

                                {{-- PAKET BULANAN --}}
                                <td style="padding:14px 22px;">
                                    @if($activePackage)
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:1px; font-size:12px; font-weight:700; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;">
                                            <i class="fa-solid fa-dumbbell" style="font-size:10px;"></i>
                                            Paket Aktif
                                        </span>
                                    @else
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:1px; font-size:12px; font-weight:700; background:#f5f5f5; color:#999; border:1px solid #e5e5e5;">
                                            Tidak Ada Paket
                                        </span>
                                    @endif
                                </td>

                                {{-- BERGABUNG --}}
                                <td style="padding:14px 22px; font-size:14px; color:#999;">
                                    {{ $member->created_at->format('d M Y') }}
                                </td>

                                {{-- AKSI --}}
                                <td style="padding:14px 22px; text-align:right;">
                                    <a href="{{ route('owner.members.show', $member->id) }}"
                                       style="display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:1px; background:rgba(0,0,0,.05); color:#111; font-size:12px; font-weight:700; text-decoration:none; border:1px solid var(--border); transition:.15s ease;"
                                       onmouseover="this.style.background='rgba(0,0,0,.09)'"
                                       onmouseout="this.style.background='rgba(0,0,0,.05)'">
                                        <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i>
                                        Detail
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div style="padding:16px 22px; border-top:1px solid var(--border);">
                {{ $members->links() }}
            </div>
        @endif

    </div>

</div>
@endsection