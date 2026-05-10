@extends('layouts.admin')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <i class="fa fa-home" style="font-size:10px;"></i>
            <span>Dashboard</span>
            <span class="sep"><i class="fa fa-chevron-right" style="font-size:9px;"></i></span>
            <span class="current">Data Produk</span>
        </div>
        <h1 class="page-title">Data Produk</h1>
        <p class="page-sub">Manajemen stok retail gym, suplemen, minuman, dan merchandise.</p>
    </div>
    <button class="btn btn-primary" onclick="openAddModal()">
        <i class="fa fa-plus"></i> Tambah Produk
    </button>
</div>

{{-- Stat Cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:20px;">

    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;">
            <i class="fa fa-box" style="font-size:16px;color:#3b82f6;"></i>
        </div>
        <div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-value">{{ $products->total() }}</div>
            <div class="stat-badge badge-up"><i class="fa fa-tag" style="font-size:9px;"></i> SKU</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fff1f2;">
            <i class="fa fa-exclamation-circle" style="font-size:16px;color:#ef4444;"></i>
        </div>
        <div>
            <div class="stat-label">Stok Menipis</div>
            <div class="stat-value" style="color:#ef4444;">{{ $products->where('stok', '<=', 5)->count() }}</div>
            <div class="stat-badge badge-down">kurng 5 pcs</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;">
            <i class="fa fa-check-circle" style="font-size:16px;color:#22c55e;"></i>
        </div>
        <div>
            <div class="stat-label">Stok Aman</div>
            <div class="stat-value" style="color:#22c55e;">{{ $products->where('stok', '>', 5)->count() }}</div>
            <div class="stat-badge badge-up">lebih 5 pcs</div>
        </div>
    </div>

</div>

{{-- Table Card --}}
<div class="card" style="padding:0;overflow:hidden;">

    {{-- Toolbar --}}
    <div style="padding:14px 18px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;background:#f8fafc;">
        <div>
            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0 0 1px;">List Produk</p>
            <p style="font-size:11.5px;color:#94a3b8;margin:0;">Semua data inventori retail gym.</p>
        </div>
        <div style="display:flex;align-items:center;gap:8px;background:#fff;border:1px solid #e8ecf0;border-radius:8px;padding:0 10px;height:34px;transition:border-color .15s,box-shadow .15s;" id="searchWrap">
            <i class="fa fa-search" style="font-size:11px;color:#94a3b8;"></i>
            <input type="text" id="prodSearch" placeholder="Cari produk..."
                   oninput="filterTable(this.value)"
                   onfocus="document.getElementById('searchWrap').style.borderColor='#93c5fd';document.getElementById('searchWrap').style.boxShadow='0 0 0 3px #eff6ff';"
                   onblur="document.getElementById('searchWrap').style.borderColor='#e8ecf0';document.getElementById('searchWrap').style.boxShadow='none';"
                   style="border:none;outline:none;background:transparent;font-size:12.5px;color:#1c2434;font-family:'Outfit',sans-serif;width:180px;">
        </div>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table class="tbl" id="prodTable">
            <thead>
                <tr>
                    <th style="width:40%;">Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr data-name="{{ strtolower($p->nama_produk) }}">
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa fa-box" style="font-size:12px;color:#94a3b8;"></i>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:600;color:#1c2434;margin:0;line-height:1.3;">{{ $p->nama_produk }}</p>
                                <p style="font-size:11px;color:#94a3b8;margin:0;font-family:'JetBrains Mono',monospace;">#{{ $p->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:13px;font-weight:700;color:#1c2434;">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span style="font-size:14px;font-weight:700;color:#1c2434;">{{ $p->stok }}</span>
                        <span style="font-size:11px;color:#94a3b8;margin-left:2px;">pcs</span>
                    </td>
                    <td style="text-align:center;">
                        @if($p->stok <= 5)
                            <span class="pill pill-red">Menipis</span>
                        @else
                            <span class="pill pill-green">Aman</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                            <button class="btn btn-secondary btn-sm" title="Edit"
                                onclick="openEditProduct('{{ $p->id }}','{{ addslashes($p->nama_produk) }}','{{ $p->harga }}','{{ $p->stok }}')">
                                <i class="fa fa-pen"></i>
                            </button>
                            @if(auth()->user()->role == 'owner')
                            <form action="{{ route('admin.data.products.delete', $p->id) }}" method="POST"
                                  id="del-prod-{{ $p->id }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                    data-confirm
                                    data-confirm-title="Hapus Produk?"
                                    data-confirm-desc="Data produk '{{ $p->nama_produk }}' akan dihapus permanen."
                                    data-confirm-type="danger"
                                    data-confirm-label="Ya, Hapus"
                                    data-confirm-form="del-prod-{{ $p->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:48px 24px;text-align:center;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                            <div style="width:44px;height:44px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                <i class="fa fa-box-open" style="font-size:18px;color:#cbd5e1;"></i>
                            </div>
                            <p style="font-size:13.5px;font-weight:700;color:#1c2434;margin:0;">Belum Ada Produk</p>
                            <p style="font-size:12px;color:#94a3b8;margin:0;">Tambahkan data produk baru untuk retail gym.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="padding:12px 18px;border-top:1px solid #e8ecf0;background:#f8fafc;">
        {{ $products->links() }}
    </div>
</div>


{{-- ── MODAL TAMBAH ── --}}
<div id="addModal" style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:16px;">
    <div style="position:absolute;inset:0;background:rgba(0,0,0,.35);backdrop-filter:blur(4px);" onclick="closeAddModal()"></div>
    <div style="position:relative;z-index:1;background:#fff;width:100%;max-width:420px;border-radius:16px;overflow:hidden;
                box-shadow:0 20px 60px rgba(0,0,0,.14);animation:modalIn .22s cubic-bezier(.34,1.56,.64,1);">
        <div style="padding:18px 20px 14px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;justify-content:space-between;">
            <div>
                <p style="font-size:14px;font-weight:800;color:#1c2434;margin:0 0 2px;">Tambah Produk</p>
                <p style="font-size:11.5px;color:#94a3b8;margin:0;">Input produk retail baru ke inventori.</p>
            </div>
            <button onclick="closeAddModal()" style="width:28px;height:28px;border-radius:7px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                <i class="fa fa-times" style="font-size:11px;color:#64748b;"></i>
            </button>
        </div>
        <form action="{{ route('admin.data.products.store') }}" method="POST">
            @csrf
            <div style="padding:18px 20px;display:flex;flex-direction:column;gap:14px;">
                <div>
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-input" required placeholder="Contoh: Whey Protein 1kg">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-input" required placeholder="0" min="0">
                    </div>
                    <div>
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-input" required placeholder="0" min="0">
                    </div>
                </div>
            </div>
            <div style="padding:12px 20px;border-top:1px solid #e8ecf0;display:flex;align-items:center;justify-content:flex-end;gap:8px;background:#f8fafc;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ── --}}
<div id="editModal" style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:16px;">
    <div style="position:absolute;inset:0;background:rgba(0,0,0,.35);backdrop-filter:blur(4px);" onclick="closeEditModal()"></div>
    <div style="position:relative;z-index:1;background:#fff;width:100%;max-width:420px;border-radius:16px;overflow:hidden;
                box-shadow:0 20px 60px rgba(0,0,0,.14);animation:modalIn .22s cubic-bezier(.34,1.56,.64,1);">
        <div style="padding:18px 20px 14px;border-bottom:1px solid #e8ecf0;display:flex;align-items:center;justify-content:space-between;">
            <div>
                <p style="font-size:14px;font-weight:800;color:#1c2434;margin:0 0 2px;">Edit Produk</p>
                <p style="font-size:11.5px;color:#94a3b8;margin:0;">Update data harga dan stok produk.</p>
            </div>
            <button onclick="closeEditModal()" style="width:28px;height:28px;border-radius:7px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                <i class="fa fa-times" style="font-size:11px;color:#64748b;"></i>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div style="padding:18px 20px;display:flex;flex-direction:column;gap:14px;">
                <div>
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" id="edit_nama" class="form-input" required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" id="edit_harga" class="form-input" required min="0">
                    </div>
                    <div>
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" id="edit_stok" class="form-input" required min="0">
                    </div>
                </div>
            </div>
            <div style="padding:12px 20px;border-top:1px solid #e8ecf0;display:flex;align-items:center;justify-content:flex-end;gap:8px;background:#f8fafc;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Update Produk</button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(.94) translateY(10px); }
    to   { opacity:1; transform:scale(1)   translateY(0);    }
}
</style>

@endsection

@push('scripts')
<script>
function openAddModal(){
    const m=document.getElementById('addModal');
    m.style.display='flex';
    document.body.style.overflow='hidden';
}
function closeAddModal(){
    document.getElementById('addModal').style.display='none';
    document.body.style.overflow='';
}
function openEditProduct(id,nama,harga,stok){
    document.getElementById('editForm').action=`/admin/data/products/update/${id}`;
    document.getElementById('edit_nama').value=nama;
    document.getElementById('edit_harga').value=harga;
    document.getElementById('edit_stok').value=stok;
    const m=document.getElementById('editModal');
    m.style.display='flex';
    document.body.style.overflow='hidden';
}
function closeEditModal(){
    document.getElementById('editModal').style.display='none';
    document.body.style.overflow='';
}
function filterTable(q){
    const rows=document.querySelectorAll('#prodTable tbody tr[data-name]');
    q=q.toLowerCase();
    rows.forEach(r=>{ r.style.display=r.dataset.name.includes(q)?'':'none'; });
}
document.addEventListener('keydown',e=>{
    if(e.key==='Escape'){ closeAddModal(); closeEditModal(); }
});
</script>
@endpush