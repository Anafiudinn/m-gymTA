@extends('layouts.owner')
@section('title', 'Paket PT')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px;">
        <div>
            <h1 style="font-size:22px; font-weight:700; color:#111;">Paket PT</h1>
            <p style="font-size:13px; color:#999; margin-top:4px;">Total Paket: {{ $totalPackages }}</p>
        </div>

        {{-- SEARCH --}}
        <form method="GET" style="width:100%; max-width:280px;">
            <div style="position:relative;">
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari paket / coach..."
                       style="width:100%; border:1px solid var(--border); border-radius:1px; padding:10px 14px 10px 38px; font-size:13px; font-family:'Outfit',sans-serif; outline:none; color:#111; background:#fafafa; transition:.15s;"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#bbb; font-size:13px;"></i>
            </div>
        </form>
    </div>

    {{-- FORM TAMBAH --}}
    <div class="card">
        <div style="margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:4px;">
                <div style="width:36px; height:36px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-plus" style="color:#fff; font-size:13px;"></i>
                </div>
                <div>
                    <div style="font-size:14px; font-weight:700; color:#111;">Tambah Paket PT</div>
                    <div style="font-size:12px; color:#aaa;">Tambahkan paket personal trainer baru</div>
                </div>
            </div>
        </div>

        <form action="{{ route('owner.pt-packages.store') }}"
              method="POST"
              id="form-add-package"
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            @csrf

            @php
            $inputStyle = "width:100%; border:1px solid var(--border); border-radius:1px; padding:10px 14px; font-size:13px; font-family:'Outfit',sans-serif; outline:none; color:#111; background:#fafafa; transition:.15s;";
            $labelStyle = "font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:.08em;";
            @endphp

            <div>
                <label style="{{ $labelStyle }}">Nama Paket</label>
                <input type="text" name="nama_paket" value="{{ old('nama_paket') }}" placeholder="Paket 10 Sesi"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'" required>
            </div>

            <div>
                <label style="{{ $labelStyle }}">Jumlah Sesi</label>
                <input type="number" name="jumlah_sesi" value="{{ old('jumlah_sesi') }}" min="1" placeholder="10"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'" required>
            </div>

            <div>
                <label style="{{ $labelStyle }}">Harga</label>
                <input type="number" name="harga" value="{{ old('harga') }}" min="0" placeholder="900000"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'" required>
            </div>

            <div>
                <label style="{{ $labelStyle }}">Nama Coach</label>
                <input type="text" name="coach_name" value="{{ old('coach_name') }}" placeholder="Coach John"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
            </div>

            <div>
                <label style="{{ $labelStyle }}">WhatsApp Coach</label>
                <input type="text" name="coach_whatsapp" value="{{ old('coach_whatsapp') }}" placeholder="08123456789"
                       style="{{ $inputStyle }}"
                       onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                       onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
            </div>

            <div class="md:col-span-2 xl:col-span-5">
                <button type="submit" id="btn-add-package"
                        style="background:var(--red); color:#fff; border:none; padding:11px 22px; border-radius:1px; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.18s; display:inline-flex; align-items:center; gap:6px;"
                        onmouseover="this.style.background='var(--red-dark)'"
                        onmouseout="this.style.background='var(--red)'">
                    <i class="fa-solid fa-plus"></i> Tambah Paket
                </button>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="card" style="padding:0; overflow:hidden;">
        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:14px; font-weight:700; color:#111;">
                <i class="fa-solid fa-dumbbell" style="color:var(--red); margin-right:8px;"></i>Daftar Paket PT
            </span>
            <span style="font-size:12px; color:#999;">{{ $packages->count() }} paket</span>
        </div>

        @if($packages->count() == 0)
            <div style="padding:56px; text-align:center; color:#bbb; font-size:14px;">
                <i class="fa-solid fa-dumbbell" style="font-size:32px; display:block; margin-bottom:10px; opacity:.35;"></i>
                Belum ada paket PT
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9f9f9;">
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Paket</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Sesi</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Harga</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Coach</th>
                            <th style="padding:12px 22px; text-align:left; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Status</th>
                            <th style="padding:12px 22px; text-align:right; font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:.1em;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                            <tr style="border-top:1px solid var(--border); transition:.15s;"
                                onmouseover="this.style.background='#fafafa'"
                                onmouseout="this.style.background='transparent'">

                                <td style="padding:14px 22px;">
                                    <div style="font-size:14px; font-weight:700; color:#111;">{{ $package->nama_paket }}</div>
                                    <div style="font-size:11px; color:#bbb; margin-top:2px;">ID #{{ $package->id }}</div>
                                </td>

                                <td style="padding:14px 22px; font-size:13px; color:#555;">{{ $package->jumlah_sesi }} sesi</td>

                                <td style="padding:14px 22px; font-size:14px; font-weight:700; color:#111;">
                                    Rp {{ number_format($package->harga, 0, ',', '.') }}
                                </td>

                                <td style="padding:14px 22px;">
                                    @if($package->coach_name)
                                        <div style="font-size:13px; font-weight:600; color:#111;">{{ $package->coach_name }}</div>
                                        @if($package->coach_whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $package->coach_whatsapp) }}"
                                               target="_blank"
                                               style="font-size:12px; color:#25d366; text-decoration:none;">
                                                <i class="fa-brands fa-whatsapp" style="margin-right:3px;"></i>{{ $package->coach_whatsapp }}
                                            </a>
                                        @endif
                                    @else
                                        <span style="font-size:12px; color:#ccc; font-style:italic;">Tidak ada coach</span>
                                    @endif
                                </td>

                                <td style="padding:14px 22px;">
                                    @if($package->is_active)
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:1px; font-size:12px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                                            <span style="width:6px;height:6px;border-radius:999px;background:#16a34a;"></span> Aktif
                                        </span>
                                    @else
                                        <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:1px; font-size:12px; font-weight:700; background:#f5f5f5; color:#999; border:1px solid #e5e5e5;">
                                            <span style="width:6px;height:6px;border-radius:999px;background:#bbb;"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td style="padding:14px 22px; text-align:right;">
                                    <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px;">

                                        <form action="{{ route('owner.pt-packages.toggle', $package->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    style="padding:7px 14px; border-radius:1px; font-size:12px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.15s; border:1px solid {{ $package->is_active ? '#fed7aa' : '#bbf7d0' }}; color:{{ $package->is_active ? '#c2410c' : '#15803d' }}; background:{{ $package->is_active ? '#fff7ed' : '#f0fdf4' }};"
                                                    onmouseover="this.style.opacity='.8'"
                                                    onmouseout="this.style.opacity='1'">
                                                {{ $package->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('owner.pt-packages.delete', $package->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus paket ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    style="padding:7px 14px; border-radius:1px; font-size:12px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.15s; border:1px solid #fecdd3; color:#be123c; background:#fff1f2;"
                                                    onmouseover="this.style.background='#ffe4e6'"
                                                    onmouseout="this.style.background='#fff1f2'">
                                                <i class="fa-solid fa-trash-can" style="margin-right:4px;"></i>Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 22px; border-top:1px solid var(--border);">
                {{ $packages->links() }}
            </div>
        @endif
    </div>

</div>

<script>
    const formPkg = document.getElementById('form-add-package');
    const btnPkg  = document.getElementById('btn-add-package');
    formPkg.addEventListener('submit', function() {
        btnPkg.disabled = true;
        btnPkg.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
    });
</script>

@endsection