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
        $transactions = Transaction::with('user')

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

        return view('admin.verifications.index', compact('transactions'));
    }

    public function approve($id)
    {
        $transaction = Transaction::with('user')
            ->findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $user = $transaction->user;

        /*
        |--------------------------------------------------------------------------
        | AKTIVASI MEMBER
        |--------------------------------------------------------------------------
        */
        if ($transaction->category === 'activation') {

            $user->update([
                'is_active_member' => true
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PAKET BULANAN
        |--------------------------------------------------------------------------
        */
        elseif ($transaction->category === 'monthly') {

            // expire paket lama
            Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->whereDate('end_date', '<', now())
                ->update([
                    'status' => 'expired'
                ]);

            // cek paket aktif terakhir
            $lastMembership = Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->whereDate('end_date', '>=', now())
                ->latest('end_date')
                ->first();

            $startDate = $lastMembership
                ? Carbon::parse($lastMembership->end_date)->addDay()
                : now();

            $endDate = Carbon::parse($startDate)
                ->addDays(30);

            Membership::create([
                'user_id' => $user->id,
                'package_name' => 'Paket Bulanan',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PT PACKAGE
        |--------------------------------------------------------------------------
        */
        elseif ($transaction->category === 'pt') {

            $ptPackage = PtPackage::find($transaction->package_id);

            if ($ptPackage) {

                PtMembership::create([
                    'user_id' => $user->id,
                    'pt_package_id' => $ptPackage->id,

                    'total_sessions' => $ptPackage->jumlah_sesi,

                    'remaining_sessions' => $ptPackage->jumlah_sesi,

                    'status' => 'active',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE TRANSACTION
        |--------------------------------------------------------------------------
        */
        $transaction->update([

            'status' => 'success',

            // ADMIN YANG MEMVERIFIKASI
            'admin_id' => auth()->id(),
        ]);

        return back()->with(
            'success',
            'Pembayaran berhasil diverifikasi.'
        );
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