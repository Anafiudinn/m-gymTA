<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
// ===============================
// ManagementController.php
// ===============================

public function members(Request $request)
{
    $query = User::with([
        'latestMembership',
        'ptMemberships'
    ])->where('role', 'member');

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('whatsapp', 'like', '%' . $request->search . '%')
              ->orWhere('member_code', 'like', '%' . $request->search . '%');
        });
    }

    $members = $query->latest()->paginate(10);

    // Statistik
    $totalMembers = User::where('role', 'member')->count();

    $activeMembers = User::where('role', 'member')
        ->where('is_active_member', true)
        ->count();

    $expiredPackages = User::whereHas('latestMembership', function ($q) {
        $q->where('end_date', '<', now());
    })->count();

    $ptActive = \App\Models\PtMembership::where('status', 'active')->count();

    return view('admin.management.members', compact(
        'members',
        'totalMembers',
        'activeMembers',
        'expiredPackages',
        'ptActive'
    ));
}
// Update Data Member
 public function updateMember(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'whatsapp'  => 'required|unique:users,whatsapp,' . $id,
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name'      => $request->name,
            'whatsapp'  => $request->whatsapp,
        ]);

        return redirect()->back()->with(
            'success',
            'Data ' . $user->name . ' berhasil diperbarui!'
        );
    }

    // ===============================
    // TOGGLE STATUS MEMBER
    // ===============================
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $user->is_active_member = !$user->is_active_member;
        $user->save();

        $status = $user->is_active_member
            ? 'diaktifkan'
            : 'dinonaktifkan';

        return redirect()->back()->with(
            'success',
            'Member ' . $user->name . ' berhasil ' . $status
        );
    }

  // Tampil Daftar Produk
    public function products(Request $request)
    {
        $query = Product::query();
        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }
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

        Product::create($request->all());

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // Update Data & Stok Produk
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->back()->with('success', 'Data produk diperbarui!');
    }

    // Hapus Produk (Hanya Owner)
    public function destroyProduct($id)
    {
        if (auth()->user()->role !== 'owner') {
            return redirect()->back()->with('error', 'Hanya Owner yang boleh menghapus produk!');
        }

        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Produk dihapus!');
    }
}