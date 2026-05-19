{{-- resources/views/owner/admins/index.blade.php --}}

@extends('layouts.owner')

@section('title', 'Kelola Admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 style="font-size:22px; font-weight:700; color:#111;">
                Kelola Admin
            </h1>
            <p style="font-size:13px; color:#999; margin-top:4px;">
                Manajemen akun admin kasir dan operasional gym.
            </p>
        </div>

        <button onclick="document.getElementById('modalAdmin').classList.remove('hidden'); document.getElementById('modalAdmin').classList.add('flex')"
            style="background:var(--red); color:#fff; padding:11px 20px; border-radius:1px; font-size:13px; font-weight:700; border:none; cursor:pointer; transition:.18s ease; display:flex; align-items:center; gap:8px;"
            onmouseover="this.style.background='var(--red-dark)'"
            onmouseout="this.style.background='var(--red)'">
            <i class="fa-solid fa-plus"></i>
            Tambah Admin
        </button>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px;">
            <div style="width:48px; height:48px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-users-gear" style="color:#555; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Admin</div>
                <div style="font-size:28px; font-weight:800; color:#111; line-height:1.2; margin-top:2px;">{{ $admins->count() }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-circle-check" style="color:#16a34a; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Admin Aktif</div>
                <div style="font-size:28px; font-weight:800; color:#16a34a; line-height:1.2; margin-top:2px;">{{ $activeAdmins }}</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:16px; border-radius:1px;">
            <div style="width:48px; height:48px; border-radius:1px; background:#fff1f2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-circle-xmark" style="color:var(--red); font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Admin Nonaktif</div>
                <div style="font-size:28px; font-weight:800; color:var(--red); line-height:1.2; margin-top:2px;">{{ $inactiveAdmins }}</div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="card" style="padding:0; overflow:hidden; border-radius:1px;">

        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:14px; font-weight:700; color:#111;">
                <i class="fa-solid fa-user-shield" style="color:var(--red); margin-right:8px;"></i>
                Daftar Admin
            </span>
            <span style="font-size:12px; color:#999;">{{ $admins->count() }} admin</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f9f9f9;">
                        <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Nama</th>
                        <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">WhatsApp</th>
                        <th style="padding:12px 22px; text-align:center; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Dibuat</th>
                        <th style="padding:12px 22px; text-align:right; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($admins as $admin)
                    <tr style="border-top:1px solid var(--border); transition:.15s ease;"
                        onmouseover="this.style.background='#fafafa'"
                        onmouseout="this.style.background='transparent'">

                        <td style="padding:16px 22px;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div style="width:38px; height:38px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; color:#fff; flex-shrink:0;">
                                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-size:14px; font-weight:700; color:#111;">{{ $admin->name }}</div>
                                    <div style="display: flex; align-items: center; gap: 6px; margin-top:2px;">
                                        <span style="font-size:11px; color:#bbb;">ID #{{ $admin->id }}</span>
                                        @if($admin->is_active_account)
                                        <span style="font-size: 10px; background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 1px; font-weight: 700;">Aktif</span>
                                        @else
                                        <span style="font-size: 10px; background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 1px; font-weight: 700;">Nonaktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:16px 22px; font-size:13px; color:#555;">
                            <i class="fa-brands fa-whatsapp" style="color:#25d366; margin-right:5px;"></i>
                            {{ $admin->whatsapp }}
                        </td>

                        <td style="padding:16px 22px; text-align:center; font-size:13px; color:#999;">
                            {{ $admin->created_at->format('d M Y') }}
                        </td>
                        <td style="padding:16px 22px; text-align:right;">
                            <div style="display:flex; justify-content:flex-end; gap:8px;">

                                {{-- EDIT ADMIN --}}
                                <button
                                    onclick="document.getElementById('editAdminModal{{ $admin->id }}').classList.remove('hidden'); document.getElementById('editAdminModal{{ $admin->id }}').classList.add('flex')"
                                    style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; padding:8px 14px; border-radius:1px; font-size:12px; font-weight:700; cursor:pointer;">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                {{-- PASSWORD --}}
                                <button
                                    onclick="document.getElementById('passwordAdminModal{{ $admin->id }}').classList.remove('hidden'); document.getElementById('passwordAdminModal{{ $admin->id }}').classList.add('flex')"
                                    style="background:#faf5ff; color:#9333ea; border:1px solid #e9d5ff; padding:8px 14px; border-radius:1px; font-size:12px; font-weight:700; cursor:pointer;">
                                    <i class="fa-solid fa-key"></i>
                                </button>

                                {{-- TOGGLE --}}
                                <form action="{{ route('owner.admins.destroy', $admin->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('{{ $admin->is_active_account ? 'Apakah Anda yakin ingin menonaktifkan akun admin ini?' : 'Apakah Anda yakin ingin mengaktifkan akun admin ini?' }}')">
                                    @csrf
                                    @method('DELETE')

                                    @if($admin->is_active_account)
                                    <button type="submit"
                                        style="background:#fff1f2; color:var(--red); border:1px solid #fecdd3; padding:8px 16px; border-radius:1px; font-size:12px; font-weight:700; cursor:pointer;">
                                        <i class="fa-solid fa-user-minus"></i>
                                    </button>
                                    @else
                                    <button type="submit"
                                        style="background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; padding:8px 16px; border-radius:1px; font-size:12px; font-weight:700; cursor:pointer;">
                                        <i class="fa-solid fa-user-check"></i>
                                    </button>
                                    @endif
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding:48px; text-align:center; color:#bbb; font-size:14px;">
                            <i class="fa-solid fa-user-slash" style="font-size:32px; display:block; margin-bottom:10px; opacity:.4;"></i>
                            Belum ada data admin.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- MODAL TAMBAH ADMIN --}}
<div id="modalAdmin"
    class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background:rgba(0,0,0,.35); backdrop-filter:blur(4px);">

    <div style="background:#fff; border-radius:1px; width:100%; max-width:480px; padding:28px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,.12);">

        {{-- CLOSE --}}
        <button onclick="document.getElementById('modalAdmin').classList.add('hidden'); document.getElementById('modalAdmin').classList.remove('flex')"
            style="position:absolute; top:16px; right:16px; width:36px; height:36px; border-radius:1px; border:1px solid var(--border); background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#999; transition:.15s ease;"
            onmouseover="this.style.background='#f5f5f5'; this.style.color='#111'"
            onmouseout="this.style.background='transparent'; this.style.color='#999'">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="margin-bottom:24px;">
            <div style="width:44px; height:44px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center; margin-bottom:14px;">
                <i class="fa-solid fa-user-plus" style="color:#fff; font-size:16px;"></i>
            </div>
            <h2 style="font-size:18px; font-weight:800; color:#111;">Tambah Admin</h2>
            <p style="font-size:13px; color:#999; margin-top:4px;">Tambahkan akun admin operasional gym.</p>
        </div>

      <form action="{{ route('owner.admins.store') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
    @csrf

    <div>
        <label style="font-size:12px; font-weight:700; color:#555; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.06em;">Nama Admin</label>
        <input type="text"
            name="name"
            required
            placeholder="Contoh: Budi Santoso"
            style="width:100%; border:1px solid var(--border); border-radius:1px; padding:11px 14px; font-size:14px; font-family:'Outfit',sans-serif; outline:none; color:#111; transition:.15s ease; background:#fafafa;"
            onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
            onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
    </div>

    <div>
        <label style="font-size:12px; font-weight:700; color:#555; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.06em;">Nomor WhatsApp</label>
        <input type="text"
            name="whatsapp"
            required
            inputmode="numeric"
            placeholder="Contoh: 08123456789 atau 628123456789"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
            style="width:100%; border:1px solid var(--border); border-radius:1px; padding:11px 14px; font-size:14px; font-family:'Outfit',sans-serif; outline:none; color:#111; transition:.15s ease; background:#fafafa;"
            onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
            onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
    </div>

    <div>
        <label style="font-size:12px; font-weight:700; color:#555; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.06em;">Password</label>
        <input type="password"
            name="password"
            required
            placeholder="Min. 8 karakter"
            style="width:100%; border:1px solid var(--border); border-radius:1px; padding:11px 14px; font-size:14px; font-family:'Outfit',sans-serif; outline:none; color:#111; transition:.15s ease; background:#fafafa;"
            onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
            onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
    </div>

    <button type="submit"
        style="width:100%; background:var(--red); color:#fff; border:none; padding:13px; border-radius:1px; font-size:14px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.18s ease; margin-top:4px;"
        onmouseover="this.style.background='var(--red-dark)'"
        onmouseout="this.style.background='var(--red)'">
        Simpan Admin
    </button>
</form>

    </div>
</div>
@foreach($admins as $admin)

{{-- MODAL EDIT ADMIN --}}
<div id="editAdminModal{{ $admin->id }}"
    class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background:rgba(0,0,0,.35); backdrop-filter:blur(4px);">

    <div style="background:#fff; width:100%; max-width:500px; padding:28px; border-radius:1px; position:relative;">

        <button
            onclick="document.getElementById('editAdminModal{{ $admin->id }}').classList.add('hidden'); document.getElementById('editAdminModal{{ $admin->id }}').classList.remove('flex')"
            style="position:absolute; top:16px; right:16px; width:34px; height:34px; border:none; background:#f5f5f5; cursor:pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 style="font-size:20px; font-weight:800; margin-bottom:20px;">
            Edit Admin
        </h2>

     <form action="{{ route('owner.admins.update', $admin->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div style="margin-bottom:16px;">
        <label style="font-size:12px; font-weight:700;">Nama</label>
        <input type="text"
            name="name"
            value="{{ $admin->name }}"
            required
            style="width:100%; border:1px solid var(--border); padding:12px; margin-top:6px;">
    </div>

    <div style="margin-bottom:20px;">
        <label style="font-size:12px; font-weight:700;">WhatsApp</label>
        <input type="text"
            name="whatsapp"
            value="{{ $admin->whatsapp }}"
            required
            inputmode="numeric"
            placeholder="Contoh: 08123456789 atau 628123456789"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
            style="width:100%; border:1px solid var(--border); padding:12px; margin-top:6px;">
    </div>

    <button type="submit"
        style="width:100%; background:var(--red); color:#fff; border:none; padding:13px; font-weight:700; cursor:pointer;">
        Simpan Perubahan
    </button>
</form>

    </div>
</div>

{{-- MODAL PASSWORD --}}
<div id="passwordAdminModal{{ $admin->id }}"
    class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background:rgba(0,0,0,.35); backdrop-filter:blur(4px);">

    <div style="background:#fff; width:100%; max-width:500px; padding:28px; border-radius:1px; position:relative;">

        <button
            onclick="document.getElementById('passwordAdminModal{{ $admin->id }}').classList.add('hidden'); document.getElementById('passwordAdminModal{{ $admin->id }}').classList.remove('flex')"
            style="position:absolute; top:16px; right:16px; width:34px; height:34px; border:none; background:#f5f5f5; cursor:pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 style="font-size:20px; font-weight:800; margin-bottom:20px;">
            Ubah Password
        </h2>

        <form action="{{ route('owner.admins.password', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:700;">Password Baru</label>
                <input type="password"
                    name="password"
                    required
                    minlength="8"
                    style="width:100%; border:1px solid var(--border); padding:12px; margin-top:6px;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:12px; font-weight:700;">Konfirmasi Password</label>
                <input type="password"
                    name="password_confirmation"
                    required
                    minlength="8"
                    style="width:100%; border:1px solid var(--border); padding:12px; margin-top:6px;">
            </div>

            <button type="submit"
                style="width:100%; background:#9333ea; color:#fff; border:none; padding:13px; font-weight:700; cursor:pointer;">
                Update Password
            </button>
        </form>

    </div>
</div>

@endforeach

@endsection