<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\PtMembership;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Untuk Fonnte API

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();

        $data = [
            'today_attendance_count' => Attendance::whereDate('created_at', $today)->count(),
            'today_omzet' => Transaction::where('admin_id', Auth::id())
                ->whereDate('created_at', $today)
                ->where('status', 'success')
                ->sum('amount'),
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * 1. KASIR CHECK-IN (Smart Pricing)
     */
    public function checkin(Request $request)
    {
        $user = null;
        $price = 0;

        if ($request->has('whatsapp')) {
            $user = User::where('whatsapp', $request->whatsapp)->first();
            if ($user) {
                // Gunakan Helper getVisitPrice dari Model User yang kita buat tadi
                $price = $user->getVisitPrice();
            } else {
                // Jika tidak ada di DB, dianggap Tamu Umum
                $price = (int) Setting::where('key', 'visit_tamu')->value('value') ?? 15000;
            }
        }

        return view('admin.checkin', compact('user', 'price'));
    }

    public function processCheckin(Request $request)
    {
        $request->validate(['whatsapp' => 'required']);

        $user = User::firstOrCreate(
            ['whatsapp' => $request->whatsapp],
            ['name' => $request->name ?? 'Tamu Umum', 'role' => 'member', 'password' => bcrypt('gym123')]
        );

        $price = $user->getVisitPrice();

        // 1. Simpan Transaksi (Jika harga > 0)
        if ($price > 0) {
            Transaction::create([
                'invoice_code' => 'INV-'.strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'admin_id' => Auth::id(),
                'category' => 'visit',
                'amount' => $price,
                'payment_method' => 'cash',
                'status' => 'success',
            ]);
        }

        // 2. Catat Absensi
        Attendance::create([
            'user_id' => $user->id,
            'type' => $price == 0 ? 'member_package' : 'paid_visit',
        ]);

        // 3. Kirim WA via Fonnte
        // $this->sendWhatsapp($user->whatsapp, "Halo {$user->name}, Check-in berhasil. Selamat latihan di UB GYM!");

        return redirect()->route('admin.checkin')->with('success', 'Check-in Berhasil!');
    }

    /**
     * 2. REGISTRASI & AKTIVASI MEMBER BARU (80rb)
     */
    public function activateMember(Request $request)
    {
        $user = User::where('whatsapp', $request->whatsapp)->first();

        if (! $user) {
            return back()->with('error', 'User tidak ditemukan');
        }

        $biaya = (int) Setting::where('key', 'biaya_aktivasi')->value('value') ?? 80000;

        // Update User jadi Active Member
        $user->update([
            'is_active_member' => true,
            'member_code' => 'UB-'.str_pad($user->id, 3, '0', STR_PAD_LEFT),
        ]);

        // Catat Transaksi Aktivasi
        Transaction::create([
            'invoice_code' => 'ACT-'.strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'category' => 'activation',
            'amount' => $biaya,
            'payment_method' => 'cash',
            'status' => 'success',
        ]);

        $this->sendWhatsapp($user->whatsapp, "Selamat! Akun Anda telah AKTIF sebagai Member UB GYM. ID Anda: {$user->member_code}");

        return back()->with('success', 'Aktivasi Member Berhasil!');
    }

    /**
     * 3. SESI PERSONAL TRAINER (Potong Sesi)
     */
    public function ptSessions()
    {
        $pt_members = PtMembership::with('user', 'package')->where('status', 'active')->get();

        return view('admin.pt_sessions', compact('pt_members'));
    }

    public function substractPtSession($id)
    {
        $membership = PtMembership::findOrFail($id);

        if ($membership->substractSession()) { // Menggunakan method di model yang kita buat tadi
            $this->sendWhatsapp($membership->user->whatsapp, "Sesi PT berhasil digunakan. Sisa sesi Anda: {$membership->remaining_sessions}");

            return back()->with('success', 'Sesi berhasil dipotong!');
        }

        return back()->with('error', 'Sesi sudah habis!');
    }

    /**
     * PRIVATE FUNCTION: FONNTE INTEGRATION
     */
    private function sendWhatsapp($target, $message)
    {
        // Ganti TOKEN_DISINI dengan token Fonnte punyamu
        Http::withHeaders([
            'Authorization' => 'TOKEN_DISINI',
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
        ]);
    }
    // ... method dashboard, checkin, ptSessions yang sudah ada ...

/**
 * 3. KASIR RETAIL (KANTIN)
 */
public function retail()
{
    $products = \App\Models\Product::where('stok', '>', 0)->get();
    return view('admin.retail', compact('products'));
}

public function processRetail(Request $request)
{
    $request->validate([
        'product_id' => 'required',
        'qty' => 'required|integer|min:1'
    ]);

    $product = \App\Models\Product::findOrFail($request->product_id);
    
    if($product->stok < $request->qty) {
        return back()->with('error', 'Stok tidak mencukupi!');
    }

    // Potong Stok
    $product->decrement('stok', $request->qty);

    // Catat Transaksi
    \App\Models\Transaction::create([
        'invoice_code' => 'RTL-' . strtoupper(Str::random(8)),
        'user_id' => Auth::id(), // Atau biarkan null jika pembeli anonim
        'admin_id' => Auth::id(),
        'category' => 'retail',
        'amount' => $product->harga * $request->qty,
        'payment_method' => 'cash',
        'status' => 'success',
    ]);

    return back()->with('success', 'Penjualan Retail Berhasil!');
}

/**
 * 4. MANAJEMEN MEMBER (List & Filter)
 */
public function members(Request $request)
{
    $query = User::where('role', 'member');
    
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('whatsapp', 'like', "%{$request->search}%");
        });
    }

    $members = $query->latest()->paginate(10);
    return view('admin.members', compact('members'));
}

/**
 * 6. RIWAYAT TRANSAKSI HARI INI
 */
public function todayTransactions()
{
    $transactions = Transaction::where('admin_id', Auth::id())
                    ->whereDate('created_at', now()->toDateString())
                    ->latest()
                    ->get();
    return view('admin.transactions', compact('transactions'));
}
}
