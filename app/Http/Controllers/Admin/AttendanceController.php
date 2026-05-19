<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WhatsappFormat;
use App\Helpers\WhatsappMessage;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Transaction;
use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $price = \App\Models\Setting::where('key', 'visit_tamu')->value('value') ?? 15000;
        $status_label = 'Tamu Umum';

        if ($request->filled('search')) {
            $user = User::where('whatsapp', $request->search)
                ->orWhere('member_code', $request->search)
                ->first();

            if ($user) {
                $price = $user->getVisitPrice();

                if ($user->role === 'guest') {
                    $status_label = 'Tamu Umum';
                } elseif ($price == 0) {
                    $status_label = 'Member Bulanan Aktif';
                } elseif ($user->is_active_member) {
                    $status_label = 'Member Aktivasi (Visit)';
                } else {
                    $status_label = 'Belum Aktivasi Member';
                }
            }
        }

        $attendanceHistory = Attendance::with('user')
            ->whereDate('created_at', today())
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($item) {
                $transaction = Transaction::where('user_id', $item->user_id)
                    ->where('category', 'visit')
                    ->whereDate('created_at', $item->created_at->format('Y-m-d'))
                    ->latest()
                    ->first();

                $item->amount = $transaction->amount ?? 0;
                $item->payment_method = $transaction->payment_method ?? 'cash';
                return $item;
            });

        return view('admin.attendance.index', compact(
            'user',
            'price',
            'status_label',
            'attendanceHistory'
        ));
    }

public function process(Request $request)
{
    // 1. VALIDASI UTAMA
    $request->validate([
        'payment_method' => 'required|in:cash,transfer',
        // Validasi bersyarat: Jika input whatsapp diisi oleh kasir, cek polanya
        'whatsapp' => [
            'nullable',
            'string',
            'max:30',
            function ($attribute, $value, $fail) {
                if ($value) {
                    $cleaned = preg_replace('/[^0-9]/', '', $value);
                    if (!preg_match('/^(08|628|8)\d{7,13}$/', $cleaned)) {
                        $fail('Nomor WhatsApp tamu tidak valid untuk operator Indonesia (harus diawali 08, 628, atau 8).');
                    }
                }
            },
        ],
    ]);

    try {
        // Bungkus variabel agar bisa dipakai di luar closure untuk redirect & kirim WA
        $redirectData = DB::transaction(function () use ($request) {
            $guestName = null;
            $guestWhatsapp = null;
            $finalAmount = 0;
            $attendanceType = 'paid_visit';
            $statusLabel = 'Tamu Umum';
            $targetWhatsapp = null;

            // 2. EVALUASI JIKA MEMBER TERDAFTAR
            if ($request->filled('user_id_found')) {
                $user = User::findOrFail($request->user_id_found);
                $finalAmount = $user->getVisitPrice();

                $attendanceType = $finalAmount == 0 ? 'member_package' : 'paid_visit';
                $targetWhatsapp = WhatsappFormat::formatNumber($user->whatsapp);

                // Tentukan ulang label status asli untuk keperluan pesan WA
                if ($finalAmount == 0) {
                    $statusLabel = 'Member Bulanan Aktif';
                } elseif ($user->is_active_member) {
                    $statusLabel = 'Member Aktivasi (Visit)';
                } else {
                    $statusLabel = 'Belum Aktivasi Member';
                }
            } 
            // 3. EVALUASI JIKA SEBAGAI GUEST (TAMU HARIAN)
            else {
                $user = User::where('role', 'guest')->first();

                if (!$user) {
                    // Gunakan throw exception agar transaksi aman bergulir kembali (rollback)
                    throw new \Exception('Akun penampung Guest belum dibuat di sistem!');
                }

                $guestName = $request->name ?? 'Tamu Harian';
                $guestWhatsapp = $request->whatsapp ?? null;

                // Jika diisi kasir, bersihkan dengan helper
                if ($guestWhatsapp) {
                    $targetWhatsapp = WhatsappFormat::formatNumber($guestWhatsapp);
                }

                $finalAmount = \App\Models\Setting::where('key', 'visit_tamu')->value('value') ?? 15000;
                $attendanceType = 'paid_visit';
                $statusLabel = 'Tamu Umum Harian';
            }

            // 4. SIMPAN DATA ATTENDANCE
            Attendance::create([
                'user_id'        => $user->id,
                'guest_name'     => $guestName,
                'guest_whatsapp' => $guestWhatsapp, // Tetap simpan apa adanya atau ganti $targetWhatsapp jika ingin bersih di DB
                'type'           => $attendanceType,
                'admin_id'       => Auth::id(),
            ]);

            // 5. SIMPAN DATA TRANSAKSI JIKA BERBAYAR
            if ($finalAmount > 0) {
                Transaction::create([
                    'invoice_code'   => 'VIS-' . strtoupper(Str::random(8)),
                    'user_id'        => $user->id,
                    'guest_name'     => $guestName,
                    'admin_id'       => Auth::id(),
                    'category'       => 'visit',
                    'amount'         => $finalAmount,
                    'payment_method' => $request->payment_method,
                    'status'         => 'success',
                    'source'         => 'onsite',
                ]);
            }

            $displayName = $guestName ?? $user->name;

            // Kembalikan data yang dibutuhkan untuk proses kirim WA di luar closure DB
            return compact('targetWhatsapp', 'displayName', 'statusLabel', 'finalAmount');
        });

        // 6. KIRIM NOTIFIKASI WHATSAPP SECARA OTOMATIS (Di luar DB Transaction agar tidak membebani database lock)
        if ($redirectData['targetWhatsapp']) {
            $waMessage = WhatsappMessage::attendanceCheckIn(
                $redirectData['displayName'], 
                $redirectData['statusLabel'], 
                $redirectData['finalAmount'], 
                $request->payment_method
            );
            FonnteService::send($redirectData['targetWhatsapp'], $waMessage);
        }

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', 'Check-in ' . $redirectData['displayName'] . ' berhasil dicatat!');

    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
}
}