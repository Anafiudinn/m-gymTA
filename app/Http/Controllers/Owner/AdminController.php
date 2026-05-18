<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $admins = User::where('role', 'admin')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('whatsapp', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        // Menghitung statistik berdasarkan is_active_account
        $totalAdmins = User::where('role', 'admin')->count();
        $activeAdmins = User::where('role', 'admin')->where('is_active_account', true)->count();
        $inactiveAdmins = User::where('role', 'admin')->where('is_active_account', false)->count();

        return view('owner.admins.index', compact(
            'admins',
            'totalAdmins',
            'activeAdmins',
            'inactiveAdmins',
            'search'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20|unique:users,whatsapp',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_active_account' => true, // Default aktif saat dibuat
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20|unique:users,whatsapp,' . $admin->id,
        ]);

        $admin->update([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
        ]);

        return back()->with('success', 'Data admin berhasil diperbarui.');
    }

    public function updatePassword(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password admin berhasil diperbarui.');
    }

    // Fitur hapus ekstrem diubah menjadi Toggle Aktif/Nonaktif
    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        if ($admin->id == auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menonaktifkan akun sendiri.');
        }

        // Toggle status account
        $admin->is_active_account = !$admin->is_active_account;
        $admin->save();

        $statusText = $admin->is_active_account ? 'diaktifkan kembali' : 'dinonaktifkan';

        return back()->with('success', "Akun Admin {$admin->name} berhasil {$statusText}.");
    }
}