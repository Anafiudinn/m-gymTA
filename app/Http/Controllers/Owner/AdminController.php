<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * =========================================================
     * LIST ADMIN
     * =========================================================
     */
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

        $totalAdmins = User::where('role', 'admin')->count();

        return view('owner.admins.index', compact(
            'admins',
            'totalAdmins',
            'search'
        ));
    }

    /**
     * =========================================================
     * STORE ADMIN
     * =========================================================
     */
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
        ]);

        return back()->with(
            'success',
            'Admin berhasil ditambahkan.'
        );
    }

    /**
     * =========================================================
     * UPDATE ADMIN
     * =========================================================
     */
    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',

            'whatsapp' => 'required|string|max:20|unique:users,whatsapp,' . $admin->id,
        ]);

        $admin->update([
            'name' => $request->name,

            'whatsapp' => $request->whatsapp,
        ]);

        return back()->with(
            'success',
            'Data admin berhasil diperbarui.'
        );
    }

    /**
     * =========================================================
     * UPDATE PASSWORD ADMIN
     * =========================================================
     */
    public function updatePassword(Request $request, $id)
    {
        $admin = User::where('role', 'admin')
            ->findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with(
            'success',
            'Password admin berhasil diperbarui.'
        );
    }

    /**
     * =========================================================
     * DELETE ADMIN
     * =========================================================
     */
    public function destroy($id)
    {
        $admin = User::where('role', 'admin')
            ->findOrFail($id);

        // Biar owner gak bisa hapus dirinya sendiri
        if ($admin->id == auth()->id()) {

            return back()->with(
                'error',
                'Kamu tidak bisa menghapus akun sendiri.'
            );
        }

        $admin->delete();

        return back()->with(
            'success',
            'Admin berhasil dihapus.'
        );
    }
}