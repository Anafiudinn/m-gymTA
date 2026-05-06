<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\PtPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class OwnerController extends Controller
{
    /**
     * 1. DASHBOARD UTAMA
     * Menampilkan ringkasan statistik untuk Owner.
     */
    public function dashboard()
    {
        $today = now()->format('Y-m-d');
        
        $data = [
            'income_today' => Transaction::whereDate('created_at', $today)
                                ->where('status', 'success')
                                ->sum('amount'),
            'active_members' => User::where('role', 'member')
                                ->where('is_active_member', true)
                                ->count(),
            // Chart Data: Omzet per kategori
            'stats_category' => Transaction::select('category', DB::raw('SUM(amount) as total'))
                                ->where('status', 'success')
                                ->groupBy('category')
                                ->get()
        ];

        return view('owner.dashboard', $data);
    }

    /**
     * 2. MANAJEMEN KARYAWAN (CRUD ADMIN)
     */
    public function indexAdmin()
    {
        $admins = User::where('role', 'admin')->get();
        return view('owner.admins.index', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|unique:users,whatsapp',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * 3. PENGATURAN HARGA (MASTER SETTINGS)
     * Mengelola biaya aktivasi, visit member, dan visit tamu.
     */
    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('owner.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Harga master berhasil diperbarui.');
    }

    /**
     * 4. MASTER PAKET PT
     */
    public function indexPtPackage()
    {
        $packages = PtPackage::all();
        return view('owner.pt_packages.index', compact('packages'));
    }

    public function storePtPackage(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'jumlah_sesi' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        PtPackage::create($request->all());
        return back()->with('success', 'Paket PT berhasil dibuat.');
    }

    /**
     * 5. LAPORAN KEUANGAN
     */
    public function report(Request $request)
    {
        $query = Transaction::where('status', 'success');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->latest()->get();
        $total_omzet = $transactions->sum('amount');

        return view('owner.reports.index', compact('transactions', 'total_omzet'));
    }
}