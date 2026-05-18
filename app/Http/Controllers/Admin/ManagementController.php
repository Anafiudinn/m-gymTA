<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\MembersExport;
use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Product;
use App\Models\PtMembership;
use App\Models\PtPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManagementController extends Controller
{
    // ===============================
    // ManagementController.php
    // ===============================

   public function members(Request $request)
{
    $search = $request->search;
    $status = $request->status;
    $package_filter = $request->package_filter; // 🌟 Variabel filter kategori paket baru

    $query = User::with([
        'activeMembership' => function ($q) {
            $q->where('status', 'active');
        },
        'ptMemberships' => function ($q) {
            $q->where('status', 'active')->with('ptPackage');
        },
    ])
    ->where('role', 'member')
    ->whereNotNull('member_code');

    // 1. Filter Pencarian Teks
    if ($request->filled('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%'.$search.'%')
                ->orWhere('whatsapp', 'like', '%'.$search.'%')
                ->orWhere('member_code', 'like', '%'.$search.'%');
        });
    }

    // 2. Filter Status Registrasi (Member Aktif vs Tamu/Non-Aktif)
    if ($status !== null && $status !== '') {
        $query->where('is_active_member', $status);
    }

    // 3. 🌟 FILTER KATEGORI PAKET (LOGIKA BARU)
    if ($request->filled('package_filter')) {
        if ($package_filter == 'active_monthly') {
            // Hanya tampilkan yang punya Paket Bulanan Aktif
            $query->whereHas('activeMembership', function ($q) {
                $q->where('status', 'active');
            });
        } elseif ($package_filter == 'active_pt') {
            // Hanya tampilkan yang punya Paket PT Aktif
            $query->whereHas('ptMemberships', function ($q) {
                $q->where('status', 'active');
            });
        } elseif ($package_filter == 'both') {
            // Tampilkan yang punya Paket Bulanan AKTIF DAN Paket PT AKTIF sekaligus
            $query->whereHas('activeMembership', function ($q) {
                $q->where('status', 'active');
            })->whereHas('ptMemberships', function ($q) {
                $q->where('status', 'active');
            });
        } elseif ($package_filter == 'no_package') {
            // Tampilkan member yang tidak punya paket aktif sama sekali (Bulanan kosong & PT kosong)
            $query->whereDoesntHave('activeMembership', function ($q) {
                $q->where('status', 'active');
            })->whereDoesntHave('ptMemberships', function ($q) {
                $q->where('status', 'active');
            });
        }
    }

    $members = $query->latest()->paginate(10);

    /* --- Hitungan Statistik Tetap Akurat --- */
    $totalMembers = User::where('role', 'member')->whereNotNull('member_code')->count();
    $activeMembers = User::where('role', 'member')->whereNotNull('member_code')->where('is_active_member', true)->count();
    
    $expiredPackages = Membership::whereHas('user', function ($q) { $q->whereNotNull('member_code'); })
        ->where(function ($q) { $q->where('status', 'expired')->orWhere('end_date', '<', now()); })
        ->distinct('user_id')->count();
        
    $ptActive = PtMembership::whereHas('user', function ($q) { $q->whereNotNull('member_code'); })->where('status', 'active')->count();

    return view('admin.management.members', compact(
        'members', 'search', 'status', 'package_filter', // Lempar package_filter ke view
        'totalMembers', 'activeMembers', 'expiredPackages', 'ptActive'
    ));
}

    // Update Data Member
    public function updateMember(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|unique:users,whatsapp,'.$id,
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
        ]);

        return redirect()->back()->with(
            'success',
            'Data '.$user->name.' berhasil diperbarui!'
        );
    }

    // ===============================
    // TOGGLE STATUS MEMBER
    // ===============================
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $user->is_active_member = ! $user->is_active_member;
        $user->save();

        $status = $user->is_active_member
            ? 'diaktifkan'
            : 'dinonaktifkan';

        return redirect()->back()->with(
            'success',
            'Member '.$user->name.' berhasil '.$status
        );
    }

    public function exportMembers()
    {
        $fileName = 'DATA_MEMBER_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(
            new MembersExport,
            $fileName
        );
    }

    // Tampil Daftar Produk
 // Tampil Daftar Produk
    public function products(Request $request)
    {
        $query = Product::query();
        
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Tampilkan semua produk (baik yang aktif maupun non-aktif) di halaman admin
        $products = $query->latest()->paginate(12);
        
        return view('admin.management.products', compact('products'));
    }

    // Simpan Produk Baru (Input Admin)
    public function storeProduct(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
        ]);

        // Secara otomatis di-set TRUE saat pertama kali produk dibuat
        Product::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'is_active'   => true, 
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // Update Data & Stok Produk
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        
        // Update hanya field data produk, status keaktifan dikontrol via tombol toggle terpisah
        $product->update($request->only(['nama_produk', 'harga', 'stok']));

        return redirect()->back()->with('success', 'Data produk diperbarui!');
    }

    // 🌟 GANTI DESTROY MENJADI TOGGLE STATUS (Hanya Owner)
  public function toggleProductStatus($id)
{
    $product = Product::findOrFail($id);
   

    // Jika produk saat ini AKTIF, Staff/Kasir dibolehkan untuk menonaktifkannya
    $product->is_active = !$product->is_active;
    $product->save();

    $status = $product->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (diarsipkan)';

    return redirect()->back()->with('success', 'Produk ' . $product->nama_produk . ' berhasil ' . $status . '!');
}
}