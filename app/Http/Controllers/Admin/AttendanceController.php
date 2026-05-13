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

        $price = \App\Models\Setting::where('key', 'visit_tamu')
            ->value('value') ?? 15000;

        $status_label = 'Tamu Umum';

        // =====================================================
        // SEARCH USER
        // =====================================================
        if ($request->filled('search')) {

            $user = User::where('whatsapp', $request->search)
                ->orWhere('member_code', $request->search)
                ->first();

            if ($user) {

                // harga otomatis dari helper User model
                $price = $user->getVisitPrice();

                // guest
                if ($user->role === 'guest') {

                    $status_label = 'Tamu Umum';
                }

                // punya paket aktif
                elseif ($price == 0) {

                    $status_label = 'Member Bulanan Aktif';
                }

                // aktivasi member
                elseif ($user->is_active_member) {

                    $status_label = 'Member Aktivasi (Visit)';
                }

                // belum aktivasi
                else {

                    $status_label = 'Belum Aktivasi Member';
                }
            }
        }

        // =====================================================
        // ATTENDANCE HISTORY
        // =====================================================
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

    // =====================================================
    // PROCESS CHECK-IN
    // =====================================================
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $guestName = null;
        $guestWhatsapp = null;

        $finalAmount = 0;

        $attendanceType = 'paid_visit';

        // =====================================================
        // MEMBER CHECK-IN
        // =====================================================
        if ($request->filled('user_id_found')) {

            $user = User::findOrFail($request->user_id_found);

            // otomatis dari helper model
            $finalAmount = $user->getVisitPrice();

            $attendanceType = $finalAmount == 0
                ? 'member_package'
                : 'paid_visit';
        }

        // =====================================================
        // GUEST CHECK-IN
        // =====================================================
        else {

            $user = User::where('role', 'guest')->first();

            if (!$user) {

                return redirect()->back()
                    ->with('error', 'Akun penampung Guest belum dibuat!');
            }

            $guestName = $request->name ?? 'Tamu Harian';

            $guestWhatsapp = $request->whatsapp ?? null;

            $finalAmount = \App\Models\Setting::where('key', 'visit_tamu')
                ->value('value') ?? 15000;

            $attendanceType = 'paid_visit';
        }

        // =====================================================
        // SIMPAN ATTENDANCE
        // =====================================================
        Attendance::create([
            'user_id'        => $user->id,
            'guest_name'     => $guestName,
            'guest_whatsapp' => $guestWhatsapp,
            'type'           => $attendanceType,
            'admin_id'       => Auth::id(),
        ]);

        // =====================================================
        // SIMPAN TRANSACTION
        // =====================================================
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

        // =====================================================
        // REDIRECT
        // =====================================================
        $displayName = $guestName ?? $user->name;

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', 'Check-in ' . $displayName . ' berhasil!');
    }
}