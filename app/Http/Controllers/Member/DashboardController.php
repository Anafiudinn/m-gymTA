<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->tab ?? 'overview';
        $user = auth()->user();

        // Ambil semua settings dan ubah jadi key-value pair agar mudah dipanggil
        $settings = \App\Models\Setting::pluck('value', 'key');

        // 1. Status Aktivasi (menggunakan kolom is_active_member dari migration kamu)
        $isActivated = $user->is_active_member;

        // 2. Ambil Paket Bulanan yang statusnya 'active'
        // Kita gunakan relasi memberships() yang baru dibuat
        $activePackage = $user->memberships()
            ->where('status', 'active')
            ->latest()
            ->first();

        // 3. Ambil Sisa Sesi PT dari tabel pt_memberships
        // Kita jumlahkan sisa sesi dari semua paket PT yang statusnya 'active'
        $ptSessionsLeft = $user->ptMemberships()
            ->where('status', 'active')
            ->sum('remaining_sessions');

        // Ambil data PT dari tabel pt_packages
        $ptPackages = \App\Models\PtPackage::where('is_active', true)->get();

        // Data untuk History (Baru)
        $attendances = $user->attendances()->latest()->take(10)->get();
        $transactions = $user->transactions()->latest()->take(10)->get();

        // Cukup ambil datanya saja tanpa di-map menjadi array manual
        $pendingOrRejectedTransactions = Transaction::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'rejected'])
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
            'pendingOrRejectedTransactions'
        ));
    }
   public function getTransactionDetail($id)
{
    $trx = Transaction::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    // ── Resolve package_name ──────────────────────────────────────
    $packageName = match($trx->category) {
        'activation' => 'Aktivasi Member',
        'monthly'    => 'Paket Bulanan',
        'visit'      => 'Kunjungan',
        'pt'         => optional(\App\Models\PtPackage::find($trx->package_id))->nama_paket
                        ?? 'Sesi Personal Trainer',
        default      => ucfirst($trx->category),
    };

    return response()->json([
        'id'               => $trx->id,
        'invoice_code'     => $trx->invoice_code,
        'package_name'     => $packageName,
        'category'         => $trx->category,
        'amount'           => $trx->amount,
        'status'           => $trx->status,
        'source'           => $trx->source,   // ← penting! dikirim ke JS
        'rejection_reason' => $trx->rejection_reason,

        'sender_bank'      => $trx->sender_bank,
        'sender_account'   => $trx->sender_account,
        'sender_name'      => $trx->sender_name,
        'proof_attachment' => $trx->proof_attachment
            ? basename($trx->proof_attachment)
            : null,

        'created_at' => $trx->created_at->format('d M Y, H:i'),
        'updated_at' => $trx->updated_at->format('d M Y, H:i'),
    ]);
}
}