<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\PtPackage;
use App\Models\PtSessionLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->tab ?? 'overview';

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SETTINGS
        |--------------------------------------------------------------------------
        */
        $settings = \App\Models\Setting::pluck('value', 'key');

        /*
        |--------------------------------------------------------------------------
        | STATUS MEMBER
        |--------------------------------------------------------------------------
        */
        $isActivated = $user->is_active_member;

        /*
        |--------------------------------------------------------------------------
        | MEMBERSHIP AKTIF
        |--------------------------------------------------------------------------
        */
        $activePackage = $user->memberships()
            ->where('status', 'active')
            ->latest()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | TOTAL SISA SESI PT
        |--------------------------------------------------------------------------
        */
        $ptSessionsLeft = $user->ptMemberships()
            ->where('status', 'active')
            ->sum('remaining_sessions');

        /*
        |--------------------------------------------------------------------------
        | LIST PAKET PT
        |--------------------------------------------------------------------------
        */
        $ptPackages = PtPackage::where('is_active', true)
            ->latest()
            ->get();

        /*
|--------------------------------------------------------------------------
| ACTIVITY HISTORY
|--------------------------------------------------------------------------
|
| Gabungkan:
| - Attendance
| - PT Session Logs
|
*/

        $attendanceActivities = $user->attendances()
            ->latest()
            ->get()
            ->map(function ($attendance) {

                return (object)[
                    'type' => 'attendance',

                    'title' => $attendance->type == 'member_package'
                        ? 'Member Gym'
                        : 'Visit Harian',

                    'description' => 'Check-in gym',

                    'date' => $attendance->created_at,

                    'badge' => $attendance->type == 'member_package'
                        ? 'MEMBER GYM'
                        : 'VISIT HARIAN',

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

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT MEMBERSHIP
        |--------------------------------------------------------------------------
        | Hanya:
        | - activation
        | - monthly
        | - pt
        |
        | Retail tidak ditampilkan
        |--------------------------------------------------------------------------
        */
        // History transaksi membership saja
        $transactions = $user->transactions()
            ->with('ptPackage')
            ->whereIn('category', [
                'activation',
                'monthly',
                'pt'
            ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PT MEMBERSHIP AKTIF
        |--------------------------------------------------------------------------
        */
        $ptMemberships = $user->ptMemberships()
            ->where('status', 'active')
            ->with('package')
            ->latest()
            ->get();

        $hasPt = $ptMemberships->isNotEmpty();

        /*
        |--------------------------------------------------------------------------
        | PENDING / REJECTED TRANSACTIONS
        |--------------------------------------------------------------------------
        | Dipakai untuk:
        | - badge notif
        | - tombol reupload
        | - status pembayaran
        |--------------------------------------------------------------------------
        */
        $pendingOrRejectedTransactions = Transaction::where(
            'user_id',
            Auth::id()
        )
            ->whereIn('status', [
                'pending',
                'rejected'
            ])
            ->latest()
            ->get();

        return view('member.dashboard', compact(
            'activeTab',

            'settings',

            'user',
            'isActivated',

            'activePackage',

            'ptPackages',
            'ptMemberships',
            'ptSessionsLeft',
            'hasPt',

            'transactions',

            'activities',

            'pendingOrRejectedTransactions'
        ));
    }

    public function getTransactionDetail($id)
    {
        $trx = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Resolve Nama Paket
        |--------------------------------------------------------------------------
        */
        $packageName = match ($trx->category) {

            'activation' => 'Aktivasi Member',

            'monthly' => 'Paket Bulanan',

            'visit' => 'Kunjungan Gym',

            'pt' => optional(
                PtPackage::find($trx->package_id)
            )->nama_paket
                ?? 'Personal Trainer',

            default => ucfirst($trx->category),
        };

        /*
        |--------------------------------------------------------------------------
        | Response JSON
        |--------------------------------------------------------------------------
        */
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

            /*
            |--------------------------------------------------------------------------
            | Sender Info
            |--------------------------------------------------------------------------
            */
            'sender_bank' => $trx->sender_bank,

            'sender_account' => $trx->sender_account,

            'sender_name' => $trx->sender_name,

            /*
            |--------------------------------------------------------------------------
            | Bukti Transfer
            |--------------------------------------------------------------------------
            */
            'proof_attachment' => $trx->proof_attachment
                ? asset('storage/' . $trx->proof_attachment)
                : null,

            /*
            |--------------------------------------------------------------------------
            | Tanggal
            |--------------------------------------------------------------------------
            */
            'created_at' => $trx->created_at->format('d M Y, H:i'),

            'updated_at' => $trx->updated_at->format('d M Y, H:i'),
        ]);
    }

    public function activities(Request $request)
    {
        $user = auth()->user();

        /*
    |--------------------------------------------------------------------------
    | ATTENDANCE ACTIVITIES
    |--------------------------------------------------------------------------
    */

        $attendanceActivities = $user->attendances()
            ->latest()
            ->get()
            ->map(function ($attendance) {

                return (object)[
                    'date' => $attendance->created_at,

                    'badge' => $attendance->type == 'member_package'
                        ? 'CHECK-IN MEMBER'
                        : 'GUEST VISIT',

                    'badge_class' => 'badge-success',

                    'description' => $attendance->type == 'member_package'
                        ? 'Berhasil check-in menggunakan membership.'
                        : 'Berhasil melakukan guest visit gym.',
                ];
            });

        /*
    |--------------------------------------------------------------------------
    | PT SESSION ACTIVITIES
    |--------------------------------------------------------------------------
    */

        $ptActivities = PtSessionLog::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($log) {

                $used = $log->previous_session - $log->current_session;

                return (object)[
                    'date' => $log->created_at,

                    'badge' => 'PT SESSION',

                    'badge_class' => 'badge-info',

                    'description' =>
                    'Menggunakan '
                        . $used .
                        ' sesi PT bersama coach '
                        . $log->coach_name .
                        '. Sisa sesi: '
                        . $log->current_session,
                ];
            });

        /*
    |--------------------------------------------------------------------------
    | MERGE ACTIVITIES
    |--------------------------------------------------------------------------
    */
       $limit = (int) $request->get('limit', 10);

        $activities = $attendanceActivities
            ->concat($ptActivities)
            ->sortByDesc('date')
            ->take($limit)
            ->values();

        return view(
            'member.activities',
            compact('activities', 'limit')
        );
    }
    public function transactions(Request $request)
{
    $user = auth()->user();

    $limit = (int) $request->get('limit', 10);

    $transactions = $user->transactions()
        ->with('ptPackage')
        ->whereIn('category', [
            'activation',
            'monthly',
            'pt'
        ])
        ->latest()
        ->take($limit)
        ->get();

    $settings = \App\Models\Setting::pluck('value', 'key');

    return view('member.transactions', compact(
        'transactions',
        'settings',
        'limit'
    ));
}
}
