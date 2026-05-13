<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\PtMembership;
use App\Models\PtPackage;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with([
            'user',
            'ptPackage'
        ])

            // hanya transaksi online
            ->where('source', 'online')

            // transfer saja
            ->where('payment_method', 'transfer')

            // pending saja
            ->where('status', 'pending')

            ->whereIn('category', [
                'activation',
                'monthly',
                'pt'
            ])

            ->latest()
            ->get();

        return view(
            'admin.verifications.index',
            compact('transactions')
        );
    }
    public function approve($id)
    {
        $transaction = Transaction::with(['user', 'ptPackage'])->findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $user = $transaction->user;

        // 1. GENERATE MEMBER CODE (Jika belum punya)
        // Apapun kategorinya, karena dia sudah bayar, kita kasih identitas resmi.
        if (!$user->member_code) {
            do {
                $memberCode = 'GYM-' . strtoupper(\Illuminate\Support\Str::random(5));
            } while (\App\Models\User::where('member_code', $memberCode)->exists());

            $user->update(['member_code' => $memberCode]);
        }

        /*
    |--------------------------------------------------------------------------
    | LOGIKA PER KATEGORI
    |--------------------------------------------------------------------------
    */
        if ($transaction->category === 'activation') {
            $user->update(['is_active_member' => true]);
        } elseif ($transaction->category === 'monthly') {
            // Logika Paket Bulanan (sama seperti sebelumnya)
            Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->whereDate('end_date', '<', now())
                ->update(['status' => 'expired']);

            $lastMembership = Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->whereDate('end_date', '>=', now())
                ->latest('end_date')
                ->first();

            $startDate = $lastMembership ? \Carbon\Carbon::parse($lastMembership->end_date)->addDay() : now();
            $endDate = \Carbon\Carbon::parse($startDate)->addDays(30);

            Membership::create([
                'user_id' => $user->id,
                'package_name' => 'Paket Bulanan',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        } elseif ($transaction->category === 'pt') {
            // CEK VALIDASI PT (Wajib Member Aktif ATAU punya Paket Bulanan Aktif)
            $hasMonthly = Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->whereDate('end_date', '>=', now())
                ->exists();

            if (!$user->is_active_member && !$hasMonthly) {
                return back()->with('error', 'User belum menjadi member aktif atau tidak memiliki paket bulanan yang aktif. Gagal approve PT.');
            }

            $ptPackage = $transaction->ptPackage;
            if (!$ptPackage) return back()->with('error', 'Paket PT tidak ditemukan.');

            PtMembership::create([
                'user_id' => $user->id,
                'pt_package_id' => $ptPackage->id,
                'total_sessions' => $ptPackage->jumlah_sesi,
                'remaining_sessions' => $ptPackage->jumlah_sesi,
                'status' => 'active',
            ]);
        }

        // UPDATE STATUS TRANSAKSI
        $transaction->update([
            'status' => 'success',
            'admin_id' => auth()->id(),
        ]);

        return back()->with('success', 'Verifikasi berhasil. Member: ' . $user->member_code);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with(
                'error',
                'Transaksi sudah diproses.'
            );
        }

        $transaction->update([

            'status' => 'rejected',

            'rejection_reason' => $request->rejection_reason,

            // ADMIN PENOLAK
            'admin_id' => auth()->id(),
        ]);

        return back()->with(
            'success',
            'Pembayaran berhasil ditolak.'
        );
    }
}
