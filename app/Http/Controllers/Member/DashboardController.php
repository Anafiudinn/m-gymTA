<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\PtPackage;
use App\Models\PtSessionLog;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->tab ?? 'overview';
        $user = auth()->user();

        // Data Settings & Status
        $settings = Setting::pluck('value', 'key');
        $isActivated = $user->is_active_member;

        // Membership Aktif
        $activePackage = $user->memberships()
            ->where('status', 'active')
            ->latest()
            ->first();

        // Sisa Sesi PT & Paket PT
        $ptSessionsLeft = $user->ptMemberships()
            ->where('status', 'active')
            ->sum('remaining_sessions');

        $ptPackages = PtPackage::where('is_active', true)
            ->latest()
            ->get();

        // ACTIVITY HISTORY (Attendance + PT Session Logs)
        $attendanceActivities = $user->attendances()
            ->latest()
            ->get()
            ->map(function ($attendance) {
                $isPackage = $attendance->type == 'member_package';
                return (object)[
                    'type' => 'attendance',
                    'title' => $isPackage ? 'Member Gym' : 'Visit Harian',
                    'description' => 'Check-in gym',
                    'date' => $attendance->created_at,
                    'badge' => $isPackage ? 'MEMBER GYM' : 'VISIT HARIAN',
                    'badge_class' => 'status-success',
                ];
            });

        $ptActivities = PtSessionLog::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($log) {
                $usedSession = $log->previous_session - $log->current_session;
                return (object)[
                    'type' => 'pt',
                    'title' => 'PT Session',
                    'description' => $usedSession . ' sesi digunakan',
                    'date' => $log->created_at,
                    'badge' => 'PT SESSION',
                    'badge_class' => 'status-danger',
                ];
            });

        $activities = $attendanceActivities
            ->concat($ptActivities)
            ->sortByDesc('date')
            ->take(5)
            ->values();

        // Riwayat Membership Transaksi (Tanpa Retail)
        $transactions = $user->transactions()
            ->with('ptPackage')
            ->whereIn('category', ['activation', 'monthly', 'pt'])
            ->latest()
            ->take(5)
            ->get();

        // PT Membership Aktif
        $ptMemberships = $user->ptMemberships()
            ->where('status', 'active')
            ->with('package')
            ->latest()
            ->get();

        $hasPt = $ptMemberships->isNotEmpty();

        // Pending / Rejected Transactions
        $pendingOrRejectedTransactions = Transaction::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'rejected'])
            ->latest()
            ->get();

       // --- TAMBAHKAN LOGIC INI UNTUK MENAMPILKAN CS/MITRA ---
        $activeAdmin = User::where('role', 'admin')->where('is_active_account', true)->first();
        $adminWhatsapp = $activeAdmin ? $activeAdmin->whatsapp : '6281234567890'; // fallback nomor default
        $adminWhatsapp = preg_replace('/[^0-9]/', '', $adminWhatsapp); // bersihkan karakter non-angka
        
        if (str_starts_with($adminWhatsapp, '0')) {
            $adminWhatsapp = '62' . substr($adminWhatsapp, 1); // ubah 08xxx jadi 628xxx
        }
        // --- END LOGIC TAMBAHAN ---

        return view('member.dashboard', compact(
            'activeTab', 'settings', 'user', 'isActivated', 'activePackage',
            'ptPackages', 'ptMemberships', 'ptSessionsLeft', 'hasPt',
            'transactions', 'activities', 'pendingOrRejectedTransactions',
            'adminWhatsapp' // <--- Jangan lupa daftarkan variabel ini ke compact
        ));
    }

    public function getTransactionDetail($id)
    {
        $trx = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Resolve Nama Paket
        $packageName = match ($trx->category) {
            'activation' => 'Aktivasi Member',
            'monthly' => 'Paket Bulanan',
            'visit' => 'Kunjungan Gym',
            'pt' => optional(PtPackage::find($trx->package_id))->nama_paket ?? 'Personal Trainer',
            default => ucfirst($trx->category),
        };

        // Ambil Data Kontak Admin Aktif (with fallback)
        $activeAdmin = User::where('role', 'admin')->where('is_active_account', true)->first();
        $adminWhatsapp = $activeAdmin ? $activeAdmin->whatsapp : '6281234567890';
        $adminWhatsapp = preg_replace('/[^0-9]/', '', $adminWhatsapp);
        
        if (str_starts_with($adminWhatsapp, '0')) {
            $adminWhatsapp = '62' . substr($adminWhatsapp, 1);
        }

        return response()->json([
            'id' => $trx->id,
            'invoice_code' => $trx->invoice_code,
            'package_name' => $packageName,
            'category' => $trx->category,
            'package_id' => $trx->package_id,
            'amount' => $trx->amount,
            'status' => $trx->status,
            'source' => $trx->source,
            'payment_method' => $trx->payment_method,
            'rejection_reason' => $trx->rejection_reason,
            'admin_whatsapp' => $adminWhatsapp,
            'sender_bank' => $trx->sender_bank,
            'sender_account' => $trx->sender_account,
            'sender_name' => $trx->sender_name,
            'proof_attachment' => $trx->proof_attachment ? asset('storage/' . $trx->proof_attachment) : null,
            'created_at' => $trx->created_at->format('d M Y, H:i'),
            'updated_at' => $trx->updated_at->format('d M Y, H:i'),
        ]);
    }

    public function activities(Request $request)
    {
        $user = auth()->user();

        // Attendance Activities
        $attendanceActivities = $user->attendances()
            ->latest()
            ->get()
            ->map(function ($attendance) {
                $isPackage = $attendance->type == 'member_package';
                return (object)[
                    'date' => $attendance->created_at,
                    'badge' => $isPackage ? 'CHECK-IN MEMBER' : 'GUEST VISIT',
                    'badge_class' => 'badge-success',
                    'description' => $isPackage ? 'Berhasil check-in menggunakan membership.' : 'Berhasil melakukan guest visit gym.',
                ];
            });

        // PT Session Activities
        $ptActivities = PtSessionLog::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($log) {
                $used = $log->previous_session - $log->current_session;
                return (object)[
                    'date' => $log->created_at,
                    'badge' => 'PT SESSION',
                    'badge_class' => 'badge-info',
                    'description' => 'Menggunakan ' . $used . ' sesi PT bersama coach ' . $log->coach_name . '. Sisa sesi: ' . $log->current_session,
                ];
            });

        // Merge Activities
        $limit = (int) $request->get('limit', 10);
        $activities = $attendanceActivities
            ->concat($ptActivities)
            ->sortByDesc('date')
            ->take($limit)
            ->values();

        return view('member.activities', compact('activities', 'limit'));
    }

    public function transactions(Request $request)
    {
        $user = auth()->user();
        $limit = (int) $request->get('limit', 10);

        $transactions = $user->transactions()
            ->with('ptPackage')
            ->whereIn('category', ['activation', 'monthly', 'pt'])
            ->latest()
            ->take($limit)
            ->get();

        $settings = Setting::pluck('value', 'key');

        return view('member.transactions', compact('transactions', 'settings', 'limit'));
    }
}