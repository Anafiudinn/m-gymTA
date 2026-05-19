<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Helpers\WhatsappFormat; // Panggil helper di sini
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
                // Ikut bersihkan kata kunci pencarian jika yang dimasukkan berupa nomor WA acak-acakan
                $searchKey = WhatsappFormat::formatNumber($search) ?? $search;

                $query->where(function ($q) use ($search, $searchKey) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('whatsapp', 'like', '%' . $searchKey . '%');
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
        // 1. SANITASI INPUT: Ubah format nomor WA masukan owner menjadi angka murni standar (628...)
        if ($request->filled('whatsapp')) {
            $cleanedInput = WhatsappFormat::formatNumber($request->whatsapp);
            if ($cleanedInput) {
                $request->merge(['whatsapp' => $cleanedInput]);
            }
        }

        // 2. VALIDASI DATA
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => [
                'required',
                'string',
                'max:30',
                'unique:users,whatsapp',
                function ($attribute, $value, $fail) {
                    // Karena sudah melalui helper, tinggal pastikan polanya valid seluler Indonesia
                    if (!preg_match('/^(628|8)\d{7,13}$/', $value)) {
                        $fail('Nomor WhatsApp Admin tidak valid untuk operator Indonesia (harus diawali 08, 628, atau 8).');
                    }
                }
            ],
            'password' => 'required|string|min:8',
        ], [
            'whatsapp.unique' => 'Nomor WhatsApp ini sudah terdaftar untuk pengguna lain di sistem.',
        ]);

        User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp, // Sudah otomatis tersimpan rapi
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_active_account' => true, // Default aktif saat dibuat
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        // 1. SANITASI INPUT: Bersihkan nomor WA sebelum dicek keunikan datanya
        if ($request->filled('whatsapp')) {
            $cleanedInput = WhatsappFormat::formatNumber($request->whatsapp);
            if ($cleanedInput) {
                $request->merge(['whatsapp' => $cleanedInput]);
            }
        }

        // 2. VALIDASI DATA
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => [
                'required',
                'string',
                'max:30',
                'unique:users,whatsapp,' . $admin->id,
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(628|8)\d{7,13}$/', $value)) {
                        $fail('Nomor WhatsApp Admin tidak valid untuk operator Indonesia.');
                    }
                }
            ],
        ], [
            'whatsapp.unique' => 'Nomor WhatsApp ini sudah digunakan oleh akun lain.',
        ]);

        $admin->update([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp, // Tersimpan bersih ke database
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