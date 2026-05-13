<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\PtPackage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->tab ?? 'overview';

        $user = auth()->user();

        // Settings
        $settings = \App\Models\Setting::pluck('value', 'key');

        // Status aktivasi
        $isActivated = $user->is_active_member;

        // Paket bulanan aktif
        $activePackage = $user->memberships()
            ->where('status', 'active')
            ->latest()
            ->first();

        // Total sisa sesi PT
        $ptSessionsLeft = $user->ptMemberships()
            ->where('status', 'active')
            ->sum('remaining_sessions');

        // Paket PT aktif
        $ptPackages = PtPackage::where('is_active', true)->get();

        // History attendance
        $attendances = $user->attendances()
            ->latest()
            ->take(10)
            ->get();

        // History transaksi
        $transactions = $user->transactions()
            ->latest()
            ->take(10)
            ->get();

        $ptMemberships = $user->ptMemberships()
            ->where('status', 'active')
            ->with('package')
            ->latest()
            ->get();

        $hasPt = $ptMemberships->isNotEmpty();

        /*
        |--------------------------------------------------------------------------
        | Pending / Rejected
        |--------------------------------------------------------------------------
        | Dipakai buat:
        | - badge notif di tab history
        | - tombol "sedang diproses"
        | - tombol "perbaiki bukti"
        |
        | PT sekarang sudah aman karena punya package_id
        |--------------------------------------------------------------------------
        */
        $pendingOrRejectedTransactions = Transaction::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'rejected'])
            ->latest()
            ->get();

        return view('member.dashboard', compact(
            'activeTab',
            'isActivated',
            'activePackage',
            'ptSessionsLeft',
            'user',
            'attendances',
            'transactions',
            'ptPackages',
            'settings',
            'pendingOrRejectedTransactions',
                'hasPt',
                'ptMemberships'
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
}
