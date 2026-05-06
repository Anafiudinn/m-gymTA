<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\PtMembership;
use App\Models\PtPackage;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $user = null;

        $tab = $request->tab ?? 'aktivasi';

        if ($request->filled('search')) {

            $user = User::where('whatsapp', $request->search)
                ->orWhere('member_code', $request->search)
                ->first();

            if (! $user) {

                return redirect()->route('admin.package.index', [
                    'tab' => $tab,
                ])->with('error', 'Data member "'.$request->search.'" tidak ditemukan!');

            }
        }

        $bulananMember = Setting::where('key', 'bulanan_member')
            ->value('value') ?? 110000;

        $ptPackages = PtPackage::all();

        $transactions = Transaction::with('user')
            ->whereIn('category', ['activation', 'monthly', 'pt'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.package.index', compact(
            'user',
            'tab',
            'bulananMember',
            'ptPackages',
            'transactions'
        ));
    }

    // LOGIC 1: AKTIVASI (80k)
    public function activateMember(Request $request)
    {
        // 1. Validasi: WA harus unik. Jika sudah ada, Laravel otomatis kirim error balik.
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|unique:users,whatsapp',
            'payment_method' => 'required',
        ], [
            'whatsapp.unique' => 'Nomor WA ini sudah terdaftar sebagai member! Silakan cek di Tab Beli Paket.',
        ]);

        // 2. Buat User Baru (Otomatis jadi member aktif)
        $user = User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'password' => bcrypt('12345678'), // Default password
            'role' => 'member',
            'is_active_member' => true,
            'member_code' => 'UB-'.str_pad(User::count() + 1, 4, '0', STR_PAD_LEFT),
        ]);

        // 3. Catat Transaksi Aktivasi (80k)
        Transaction::create([
            'invoice_code' => 'ACT-'.strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'category' => 'activation',
            'amount' => 80000,
            'payment_method' => $request->payment_method,
            'status' => 'success',
        ]);

        return redirect()->route('admin.package.index', [
            'tab' => 'aktivasi',
        ])
            ->with('success',
                'Berhasil! '.$user->name.
                ' resmi jadi member dengan kode: '.
                $user->member_code
            );
    }

    // LOGIC 2: BELI PAKET BULANAN (150k)
    public function buyPackage(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // Tentukan tanggal mulai (jika masih ada paket aktif, sambung dari tanggal expired lama)
        $lastMembership = Membership::where('user_id', $user->id)
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'desc')
            ->first();

        $startDate = $lastMembership ? Carbon::parse($lastMembership->end_date)->addDay() : now();
        $endDate = Carbon::parse($startDate)->addDays(30);

        // 1. Catat ke tabel Membership
        Membership::create([
            'user_id' => $user->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        // 2. Catat Transaksi
        Transaction::create([
            'invoice_code' => 'PKG-'.strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'category' => 'monthly',
            'amount' => 150000, // Sesuaikan harga paketmu
            'payment_method' => $request->payment_method,
            'status' => 'success',
        ]);

        return redirect()->route('admin.package.index', [
            'tab' => 'bulanan',
            'search' => $user->member_code,
        ])
            ->with('success', 'Paket Bulanan Berhasil Ditambahkan!');
    }

public function buyPT(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'pt_package_id' => 'required',
        'payment_method' => 'required',
    ]);

    $user = User::findOrFail($request->user_id);
    $package = PtPackage::findOrFail($request->pt_package_id);

    // 1. Simpan transaksi PT (Urusan Keuangan)
    Transaction::create([
        'invoice_code' => 'PT-' . strtoupper(Str::random(8)),
        'user_id' => $user->id,
        'admin_id' => Auth::id(),
        'category' => 'pt',
        'amount' => $package->harga,
        'payment_method' => $request->payment_method,
        'status' => 'success',
    ]);

    // 2. Update atau Buat Saldo Sesi (Urusan Latihan)
    // Sesuai migration: total_sessions, remaining_sessions, status
    PtMembership::create([
        'user_id' => $user->id,
        'pt_package_id' => $package->id,
        'total_sessions' => $package->jumlah_sesi, // Pastikan di tabel pt_packages ada kolom ini
        'remaining_sessions' => $package->jumlah_sesi,
        'status' => 'active',
    ]);

    return redirect()->route('admin.package.index', [
        'tab' => 'pt',
        'search' => $user->member_code,
    ])->with('success', 'Paket PT ' . $package->nama_paket . ' berhasil ditambahkan!');
}
}
