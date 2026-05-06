<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $price = 15000;
        $status_label = 'Tamu Umum';

        // Search member
        if ($request->filled('search')) {

            $user = User::where('whatsapp', $request->search)
                        ->orWhere('member_code', $request->search)
                        ->first();

            if ($user) {

                // Guest account
                if ($user->role === 'guest') {

                    $price = 15000;
                    $status_label = 'Tamu Umum';

                }

                // Active member
                elseif ($user->is_active_member) {

                    $hasActivePackage = $user->memberships()
                        ->where('status', 'active')
                        ->where('end_date', '>=', now())
                        ->exists();

                    if ($hasActivePackage) {

                        $price = 0;
                        $status_label = 'Member (Paket Aktif)';

                    } else {

                        $price = 7000;
                        $status_label = 'Member (Tanpa Paket)';

                    }

                }

                // Not active member
                else {

                    $price = 15000;
                    $status_label = 'Member Belum Aktivasi';

                }
            }
        }

        // History tamu harian
        $historyTamu = Attendance::with('user')
            ->whereDate('created_at', now())
            ->whereNotNull('guest_name')
            ->latest()
            ->get();

        // History member
        $historyMember = Attendance::with('user')
            ->whereDate('created_at', now())
            ->whereNull('guest_name')
            ->latest()
            ->get();

        return view('admin.attendance.index', compact(
            'user',
            'price',
            'status_label',
            'historyTamu',
            'historyMember'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer',
            'amount'         => 'required|numeric',
        ]);

        $guestName = null;
        $guestWhatsapp = null;

        // =========================
        // MEMBER
        // =========================
        if ($request->filled('user_id_found')) {

            $user = User::findOrFail($request->user_id_found);

        }

        // =========================
        // GUEST
        // =========================
        else {

            // Ambil akun penampung guest
            $user = User::where('role', 'guest')->first();

            if (!$user) {

                return redirect()->back()
                    ->with('error', 'Akun penampung Guest belum dibuat oleh Owner!');

            }

            $guestName = $request->name ?? 'Tamu Harian';
            $guestWhatsapp = $request->whatsapp ?? null;

        }

        // =========================
        // SIMPAN ATTENDANCE
        // =========================
        Attendance::create([
            'user_id'         => $user->id,
            'guest_name'      => $guestName,
            'guest_whatsapp'  => $guestWhatsapp,
            'type'            => ($request->amount == 0)
                                    ? 'member_package'
                                    : 'paid_visit',
        ]);

        // =========================
        // SIMPAN TRANSACTION
        // =========================
        if ($request->amount > 0) {

            Transaction::create([
                'invoice_code'   => 'VIS-' . strtoupper(Str::random(8)),
                'user_id'        => $user->id,
                'guest_name'     => $guestName,
                'admin_id'       => Auth::id(),
                'category'       => 'visit',
                'amount'         => $request->amount,
                'payment_method' => $request->payment_method,
                'status'         => 'success',
            ]);

        }

        // =========================
        // REDIRECT
        // =========================
        $displayName = $guestName ?? $user->name;

        $tab = $request->type === 'member'
            ? 'member'
            : 'guest';

        return redirect()->route('admin.attendance.index', [
                'tab' => $tab
            ])
            ->with('success', 'Check-in ' . $displayName . ' berhasil!');
    }
}