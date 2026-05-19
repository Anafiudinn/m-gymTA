<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Tampilkan halaman input nomor WA
    public function create()
    {
        return view('auth.forgot-password');
    }

    // Generate OTP dan kirim ke WhatsApp (Terbuka untuk semua Role)
    public function store(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string',
        ]);

        // Cari user berdasarkan nomor WhatsApp
        $user = User::where('whatsapp', $request->whatsapp)->first();

        // Jika nomor tidak ada di DB, langsung gagalkan
        if (!$user) {
            return back()->withErrors(['whatsapp' => 'Nomor WhatsApp tidak terdaftar di sistem kami.']);
        }

        // Generate 6 digit kode OTP acak (murni angka)
        $token = rand(100000, 999999);

        // Simpan/Update token ke database dengan masa aktif 15 menit
        DB::table('whatsapp_password_resets')->updateOrInsert(
            ['whatsapp' => $request->whatsapp],
            [
                'token' => Hash::make($token), // Di-hash demi keamanan tingkat tinggi
                'expires_at' => now()->addMinutes(15),
                'created_at' => now(),
            ]
        );

        // Susun template pesan WhatsApp (Fleksibel, otomatis panggil nama & role)
        $pesan = "Halo *{$user->name}* (" . strtoupper($user->role) . ") 👋\n\n";
        $pesan .= "Kami menerima permintaan untuk mereset password akun Satrio Gym Anda.\n";
        $pesan .= "Berikut adalah Kode OTP Keamanan Anda:\n\n";
        $pesan .= "*{$token}*\n\n";
        $pesan .= "Kode ini hanya berlaku selama 15 menit. Jangan bagikan kode ini kepada siapapun demi keamanan akun Anda.\n\n";
        $pesan .= "Salam sehat,\n*Satrio Gym Team*";

        // Kirim menggunakan FonnteService lokal kita
        FonnteService::send($request->whatsapp, $pesan);

        return redirect()->route('password.reset', ['whatsapp' => $request->whatsapp])
            ->with('status', 'Kode OTP keamanan telah dikirim ke WhatsApp Anda.');
    }

    // Tampilkan halaman form input OTP & Password baru
    public function edit($whatsapp)
    {
        return view('auth.reset-password', compact('whatsapp'));
    }

    // Proses validasi OTP dan update password baru
    public function update(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string',
            'token' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Ambil data token aktif dari DB
        $resetData = DB::table('whatsapp_password_resets')
            ->where('whatsapp', $request->whatsapp)
            ->first();

        // Validasi expired time (15 menit)
        if (!$resetData || now()->isAfter($resetData->expires_at)) {
            return redirect()->route('password.request')
                ->withErrors(['whatsapp' => 'Kode OTP kadaluwarsa atau tidak valid. Silakan minta kode baru.']);
        }

        // Validasi kecocokan angka OTP
        if (!Hash::check($request->token, $resetData->token)) {
            return back()->withErrors(['token' => 'Kode OTP yang Anda masukkan salah.']);
        }

        // Hantam update password baru ke tabel users
        User::where('whatsapp', $request->whatsapp)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token dari DB agar tidak bisa disalahgunakan lagi
        DB::table('whatsapp_password_resets')->where('whatsapp', $request->whatsapp)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan masuk menggunakan password baru.');
    }
}