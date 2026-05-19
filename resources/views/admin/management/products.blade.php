@extends('layouts.admin')

@section('title', 'Data Produk')
@section('header-title', 'Data Produk')

@section('content')

<div style="display:flex; flex-direction:column; gap:20px;">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; align-items:flex-start; justify-content:space-between; gap:12px;">
        <div>
            <h1 style="font-size:20px; font-weight:800; color:#111; margin:0;">Data Produk</h1>
            <p style="font-size:13px; color:#999; margin:4px 0 0;">Manajemen stok retail gym, suplemen, minuman, dan merchandise.</p>
        </div>
        <button onclick="openAddModal()"
                style="display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:1px; background:var(--red); color:#fff; border:none; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.15s;"
                onmouseover="this.style.background='var(--red-dark)'"
                onmouseout="this.style.background='var(--red)'">
            <i class="fa-solid fa-plus" style="font-size:11px;"></i> Tambah Produk
        </button>
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
        <p style="font-size:13px;font-weight:700;color:var(--red);margin:0 0 2px;">{{ session('error') }}</p>
    </div>
</div>
@endif

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

        <div class="card" style="display:flex; align-items:center; gap:14px; padding:16px 18px;">
            <div style="width:44px; height:44px; border-radius:1px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-box" style="font-size:17px; color:#2563eb;"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Total Produk</div>
                <div style="font-size:26px; font-weight:800; color:#111; line-height:1.2; margin-top:1px;">{{ $products->total() }}</div>
                <div style="font-size:11px; color:#aaa; margin-top:2px;">SKU terdaftar</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:14px; padding:16px 18px;">
            <div style="width:44px; height:44px; border-radius:1px; background:#fff1f2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:17px; color:var(--red);"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Stok Menipis</div>
                <div style="font-size:26px; font-weight:800; color:var(--red); line-height:1.2; margin-top:1px;">{{ $products->where('stok', '<=', 5)->count() }}</div>
                <div style="font-size:11px; color:#aaa; margin-top:2px;">Kurang dari 5 pcs</div>
            </div>
        </div>

        <div class="card" style="display:flex; align-items:center; gap:14px; padding:16px 18px;">
            <div style="width:44px; height:44px; border-radius:1px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-circle-check" style="font-size:17px; color:#16a34a;"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Stok Aman</div>
                <div style="font-size:26px; font-weight:800; color:#16a34a; line-height:1.2; margin-top:1px;">{{ $products->where('stok', '>', 5)->count() }}</div>
                <div style="font-size:11px; color:#aaa; margin-top:2px;">Lebih dari 5 pcs</div>
            </div>
        </div>
        {{-- 🌟 Tambahan Statistik Produk Diarsipkan --}}
        <div class="card" style="display:flex; align-items:center; gap:14px; padding:16px 18px;">
            <div style="width:44px; height:44px; border-radius:1px; background:#f4f4f5; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-archive" style="font-size:17px; color:#71717a;"></i>
            </div>
            <div>
                <div style="font-size:11px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:.08em;">Diarsipkan</div>
                <div style="font-size:26px; font-weight:800; color:#71717a; line-height:1.2; margin-top:1px;">{{ $products->where('is_active', false)->count() }}</div>
                <div style="font-size:11px; color:#aaa; margin-top:2px;">Tidak aktif</div>
            </div>
    </div>
    </div>

    {{-- TABLE --}}

    {{-- TABLE CARD --}}
   <div class="card" style="padding:0; overflow:hidden;">

    {{-- TOOLBAR --}}
    <div style="padding:14px 18px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; background:#fafafa;">
        <div>
            <div style="font-size:13px; font-weight:700; color:#111;">List Produk</div>
            <div style="font-size:11px; color:#aaa; margin-top:1px;">Semua data inventori retail gym.</div>
        </div>
        <div style="display:flex; align-items:center; gap:8px; background:#fff; border:1px solid var(--border); border-radius:1px; padding:0 10px; height:34px; transition:.15s;" id="searchWrap">
            <i class="fa-solid fa-magnifying-glass" style="font-size:11px; color:#bbb;"></i>
            <input type="text" id="prodSearch" placeholder="Cari produk..."
                   oninput="filterTable(this.value)"
                   onfocus="document.getElementById('searchWrap').style.borderColor='var(--red)'"
                   onblur="document.getElementById('searchWrap').style.borderColor='var(--border)'"
                   style="border:none; outline:none; background:transparent; font-size:12px; color:#111; font-family:'Outfit',sans-serif; width:180px;">
        </div>
    </div>
    

    {{-- TABLE --}}
    <div style="overflow-x:auto;">
        <table id="prodTable" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f9f9f9;">
                    <th style="padding:11px 18px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; width:40%;">Produk</th>
                    <th style="padding:11px 18px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em;">Harga</th>
                    <th style="padding:11px 18px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em;">Stok</th>
                    <th style="padding:11px 18px; text-align:center; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em;">Status</th>
                    <th style="padding:11px 18px; text-align:right; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr data-name="{{ strtolower($p->nama_produk) }}"
                    {{-- 🌟 Efek visual opasitas tipis jika produk dinonaktifkan (diarsipkan) --}}
                    style="border-top:1px solid var(--border); transition:.13s; {{ !$p->is_active ? 'opacity: 0.6; background: #fcfcfc;' : '' }}"
                    onmouseover="this.style.background='{{ $p->is_active ? '#fafafa' : '#f5f5f5' }}'"
                    onmouseout="this.style.background='{{ $p->is_active ? 'transparent' : '#fcfcfc' }}'">

                    <td style="padding:13px 18px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; border-radius:1px; background:rgba(0,0,0,.05); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fa-solid fa-box" style="font-size:12px; color:#aaa;"></i>
                            </div>
                            <div>
                                <div style="font-size:13px; font-weight:600; color:#111; line-height:1.3;">{{ $p->nama_produk }}</div>
                                <div style="font-size:11px; color:#ccc; margin-top:1px; font-family:monospace;">#{{ $p->id }}</div>
                            </div>
                        </div>
                    </td>

                    <td style="padding:13px 18px; font-size:13px; font-weight:700; color:#111;">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </td>

                    <td style="padding:13px 18px;">
                        <span style="font-size:14px; font-weight:700; color:#111;">{{ $p->stok }}</span>
                        <span style="font-size:11px; color:#aaa; margin-left:2px;">pcs</span>
                    </td>

                    <td style="padding:13px 18px; text-align:center;">
                        {{-- 🌟 KONDISI STATUS BARU --}}
                        @if(!$p->is_active)
                            <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:1px; font-size:11px; font-weight:700; background:#f4f4f5; color:#71717a; border:1px solid #e4e4e7;">
                                <i class="fa-solid fa-archive" style="font-size:9px;"></i> Diarsipkan
                            </span>
                        @elseif($p->stok <= 5)
                            <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:1px; font-size:11px; font-weight:700; background:#fff1f2; color:#be123c; border:1px solid #fecdd3;">
                                <i class="fa-solid fa-triangle-exclamation" style="font-size:9px;"></i> Menipis
                            </span>
                        @else
                            <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:1px; font-size:11px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                                <i class="fa-solid fa-circle-check" style="font-size:9px;"></i> Aman
                            </span>
                        @endif
                    </td>

                    <td style="padding:13px 18px; text-align:right;">
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">

                            {{-- EDIT --}}
                            <button title="Edit"
                                    onclick="openEditProduct('{{ $p->id }}','{{ addslashes($p->nama_produk) }}','{{ $p->harga }}','{{ $p->stok }}')"
                                    style="width:32px; height:32px; border-radius:1px; border:1px solid var(--border); background:rgba(0,0,0,.03); color:#555; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.13s; font-size:12px;"
                                    onmouseover="this.style.background='rgba(0,0,0,.08)'"
                                    onmouseout="this.style.background='rgba(0,0,0,.03)'">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            {{-- 🌟 ACTION TOGGLE STATUS BARU (HANYO OWNER) --}}
                      
                            <form action="{{ route('admin.data.products.toggle', $p->id) }}" method="POST"
                                  id="toggle-prod-{{ $p->id }}" style="display:inline;">
                                @csrf 
                                @method('PATCH')
                                
                                @if($p->is_active)
                                    {{-- Tampilan Tombol untuk MENGOFFKAN (Arsipkan) --}}
                                    <button type="button" title="Arsipkan Produk"
                                            style="width:32px; height:32px; border-radius:1px; border:1px solid #fed7aa; background:#fff7ed; color:#ea580c; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.13s; font-size:12px;"
                                            onmouseover="this.style.background='#ffedd5'"
                                            onmouseout="this.style.background='#fff7ed'"
                                            data-confirm="Produk <strong>{{ $p->nama_produk }}</strong> akan disembunyikan dari katalog kasir dan member."
                                            data-confirm-title="Arsipkan Produk?"
                                            data-confirm-type="warning"
                                            data-confirm-ok="Ya, Arsipkan">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </button>
                                @else
                                    {{-- Tampilan Tombol untuk MENGONKAN (Aktifkan Lagi) --}}
                                    <button type="button" title="Aktifkan Produk"
                                            style="width:32px; height:32px; border-radius:1px; border:1px solid #bbf7d0; background:#f0fdf4; color:#16a34a; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.13s; font-size:12px;"
                                            onmouseover="this.style.background='#dcfce7'"
                                            onmouseout="this.style.background='#f0fdf4'"
                                            data-confirm="Produk <strong>{{ $p->nama_produk }}</strong> akan dimunculkan kembali di katalog penjualan kasir."
                                            data-confirm-title="Aktifkan Produk?"
                                            data-confirm-type="success"
                                            data-confirm-ok="Ya, Aktifkan">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                @endif
                            </form>
                        

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:52px 24px; text-align:center; color:#bbb;">
                        <i class="fa-solid fa-box-open" style="font-size:30px; display:block; margin-bottom:10px; opacity:.35;"></i>
                        <div style="font-size:13px; font-weight:700; color:#aaa; margin-bottom:3px;">Belum Ada Produk</div>
                        <div style="font-size:12px; color:#ccc;">Tambahkan data produk baru untuk retail gym.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


        {{-- PAGINATION --}}
        <div style="padding:12px 18px; border-top:1px solid var(--border); background:#fafafa;">
            {{ $products->links() }}
        </div>

    </div>

</div>


{{-- ============ MODAL TAMBAH ============ --}}
<div id="addModal"
     style="display:none; position:fixed; inset:0; z-index:200; align-items:center; justify-content:center; padding:16px; background:rgba(0,0,0,.3); backdrop-filter:blur(3px);">

    <div style="position:relative; background:#fff; width:100%; max-width:420px; border-radius:1px; overflow:hidden; box-shadow:0 16px 50px rgba(0,0,0,.13); animation:modalIn .2s ease;">

        {{-- HEADER --}}
        <div style="padding:16px 18px 12px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:1px; background:linear-gradient(135deg,var(--red),#991b1b); display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-plus" style="color:#fff; font-size:12px;"></i>
                </div>
                <div>
                    <div style="font-size:14px; font-weight:800; color:#111;">Tambah Produk</div>
                    <div style="font-size:11px; color:#aaa; margin-top:1px;">Input produk retail baru ke inventori.</div>
                </div>
            </div>
            <button onclick="closeAddModal()"
                    style="width:28px; height:28px; border-radius:1px; background:rgba(0,0,0,.05); border:1px solid var(--border); cursor:pointer; display:flex; align-items:center; justify-content:center; color:#999; transition:.13s;"
                    onmouseover="this.style.background='rgba(0,0,0,.09)'; this.style.color='#111'"
                    onmouseout="this.style.background='rgba(0,0,0,.05)'; this.style.color='#999'">
                <i class="fa-solid fa-xmark" style="font-size:12px;"></i>
            </button>
        </div>

        {{-- BODY --}}
        <form action="{{ route('admin.data.products.store') }}" method="POST">
            @csrf
            <div style="padding:18px; display:flex; flex-direction:column; gap:14px;">

                <div>
                    <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:5px; text-transform:uppercase; letter-spacing:.08em;">Nama Produk</label>
                    <input type="text" name="nama_produk" required placeholder="Contoh: Whey Protein 1kg"
                           style="width:100%; border:1px solid var(--border); border-radius:1px; padding:9px 12px; font-size:13px; font-family:'Outfit',sans-serif; color:#111; background:#fafafa; outline:none; transition:.13s;"
                           onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                           onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:5px; text-transform:uppercase; letter-spacing:.08em;">Harga (Rp)</label>
                        <input type="number" name="harga" required placeholder="0" min="0"
                               style="width:100%; border:1px solid var(--border); border-radius:1px; padding:9px 12px; font-size:13px; font-family:'Outfit',sans-serif; color:#111; background:#fafafa; outline:none; transition:.13s;"
                               onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                               onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
                    </div>
                    <div>
                        <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:5px; text-transform:uppercase; letter-spacing:.08em;">Stok</label>
                        <input type="number" name="stok" required placeholder="0" min="0"
                               style="width:100%; border:1px solid var(--border); border-radius:1px; padding:9px 12px; font-size:13px; font-family:'Outfit',sans-serif; color:#111; background:#fafafa; outline:none; transition:.13s;"
                               onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                               onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
                    </div>
                </div>

            </div>

            <div style="padding:12px 18px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:flex-end; gap:8px; background:#fafafa;">
                <button type="button" onclick="closeAddModal()"
                        style="padding:8px 16px; border-radius:1px; background:rgba(0,0,0,.05); border:1px solid var(--border); color:#555; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.13s;"
                        onmouseover="this.style.background='rgba(0,0,0,.09)'"
                        onmouseout="this.style.background='rgba(0,0,0,.05)'">Batal</button>
                <button type="submit"
                        style="padding:8px 18px; border-radius:1px; background:var(--red); color:#fff; border:none; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.13s;"
                        onmouseover="this.style.background='var(--red-dark)'"
                        onmouseout="this.style.background='var(--red)'">Simpan Produk</button>
            </div>
        </form>

    </div>
</div>


{{-- ============ MODAL EDIT ============ --}}
<div id="editModal"
     style="display:none; position:fixed; inset:0; z-index:200; align-items:center; justify-content:center; padding:16px; background:rgba(0,0,0,.3); backdrop-filter:blur(3px);">

    <div style="position:relative; background:#fff; width:100%; max-width:420px; border-radius:1px; overflow:hidden; box-shadow:0 16px 50px rgba(0,0,0,.13); animation:modalIn .2s ease;">

        {{-- HEADER --}}
        <div style="padding:16px 18px 12px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:1px; background:linear-gradient(135deg,#2563eb,#1d4ed8); display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-pen" style="color:#fff; font-size:12px;"></i>
                </div>
                <div>
                    <div style="font-size:14px; font-weight:800; color:#111;">Edit Produk</div>
                    <div style="font-size:11px; color:#aaa; margin-top:1px;">Update data harga dan stok produk.</div>
                </div>
            </div>
            <button onclick="closeEditModal()"
                    style="width:28px; height:28px; border-radius:1px; background:rgba(0,0,0,.05); border:1px solid var(--border); cursor:pointer; display:flex; align-items:center; justify-content:center; color:#999; transition:.13s;"
                    onmouseover="this.style.background='rgba(0,0,0,.09)'; this.style.color='#111'"
                    onmouseout="this.style.background='rgba(0,0,0,.05)'; this.style.color='#999'">
                <i class="fa-solid fa-xmark" style="font-size:12px;"></i>
            </button>
        </div>

        {{-- BODY --}}
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div style="padding:18px; display:flex; flex-direction:column; gap:14px;">

                <div>
                    <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:5px; text-transform:uppercase; letter-spacing:.08em;">Nama Produk</label>
                    <input type="text" name="nama_produk" id="edit_nama" required
                           style="width:100%; border:1px solid var(--border); border-radius:1px; padding:9px 12px; font-size:13px; font-family:'Outfit',sans-serif; color:#111; background:#fafafa; outline:none; transition:.13s;"
                           onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                           onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:5px; text-transform:uppercase; letter-spacing:.08em;">Harga (Rp)</label>
                        <input type="number" name="harga" id="edit_harga" required min="0"
                               style="width:100%; border:1px solid var(--border); border-radius:1px; padding:9px 12px; font-size:13px; font-family:'Outfit',sans-serif; color:#111; background:#fafafa; outline:none; transition:.13s;"
                               onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                               onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
                    </div>
                    <div>
                        <label style="font-size:11px; font-weight:700; color:#aaa; display:block; margin-bottom:5px; text-transform:uppercase; letter-spacing:.08em;">Stok</label>
                        <input type="number" name="stok" id="edit_stok" required min="0"
                               style="width:100%; border:1px solid var(--border); border-radius:1px; padding:9px 12px; font-size:13px; font-family:'Outfit',sans-serif; color:#111; background:#fafafa; outline:none; transition:.13s;"
                               onfocus="this.style.borderColor='var(--red)'; this.style.background='#fff'"
                               onblur="this.style.borderColor='var(--border)'; this.style.background='#fafafa'">
                    </div>
                </div>

            </div>

            <div style="padding:12px 18px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:flex-end; gap:8px; background:#fafafa;">
                <button type="button" onclick="closeEditModal()"
                        style="padding:8px 16px; border-radius:1px; background:rgba(0,0,0,.05); border:1px solid var(--border); color:#555; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.13s;"
                        onmouseover="this.style.background='rgba(0,0,0,.09)'"
                        onmouseout="this.style.background='rgba(0,0,0,.05)'">Batal</button>
                <button type="submit"
                        style="padding:8px 18px; border-radius:1px; background:#2563eb; color:#fff; border:none; font-size:13px; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; transition:.13s;"
                        onmouseover="this.style.background='#1d4ed8'"
                        onmouseout="this.style.background='#2563eb'">Update Produk</button>
            </div>
        </form>

    </div>
</div>

<style>
@keyframes modalIn{
    from{ opacity:0; transform:scale(.95) translateY(-6px); }
    to{   opacity:1; transform:scale(1)   translateY(0);    }
}
</style>

@endsection

@push('scripts')
<script>

function openAddModal(){
    document.getElementById('addModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeAddModal(){
    document.getElementById('addModal').style.display = 'none';
    document.body.style.overflow = '';
}

function openEditProduct(id, nama, harga, stok){
    document.getElementById('editForm').action = `/admin/data/products/update/${id}`;
    document.getElementById('edit_nama').value  = nama;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_stok').value  = stok;
    document.getElementById('editModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEditModal(){
    document.getElementById('editModal').style.display = 'none';
    document.body.style.overflow = '';
}

function filterTable(q){
    const rows = document.querySelectorAll('#prodTable tbody tr[data-name]');
    q = q.toLowerCase();
    rows.forEach(r => {
        r.style.display = r.dataset.name.includes(q) ? '' : 'none';
    });
}

/* close modals on backdrop click */
document.getElementById('addModal').addEventListener('click', function(e){
    if(e.target === this) closeAddModal();
});
document.getElementById('editModal').addEventListener('click', function(e){
    if(e.target === this) closeEditModal();
});

document.addEventListener('keydown', e => {
    if(e.key === 'Escape'){ closeAddModal(); closeEditModal(); }
});

</script>
@endpush