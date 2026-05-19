<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\PtMembership;
use App\Models\Transaction;
use App\Models\User;
use App\Helpers\WhatsappMessage;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'ptPackage'])
            ->where('source', 'online')
            ->where('payment_method', 'transfer')
            ->where('status', 'pending')
            ->whereIn('category', ['activation', 'monthly', 'pt'])
            ->latest()
            ->get();

        return view('admin.verifications.index', compact('transactions'));
    }

    public function approve($id)
    {
        $transaction = Transaction::with(['user', 'ptPackage'])->findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $user = $transaction->user;
        $latestMembership = null;

        DB::beginTransaction();
        try {
            // 1. GENERATE MEMBER CODE (Jika belum punya)
            if ($user && !$user->member_code) {
                do {
                    $memberCode = 'GYM-' . strtoupper(Str::random(5));
                } while (User::where('member_code', $memberCode)->exists());

                $user->update(['member_code' => $memberCode]);
            }

            // 2. LOGIKA PER KATEGORI
            if ($transaction->category === 'activation') {
                $user->update(['is_active_member' => true]);

            } elseif ($transaction->category === 'monthly') {
                // Perbarui paket lama yang harusnya expired
                Membership::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->whereDate('end_date', '<', now())
                    ->update(['status' => 'expired']);

                $lastMembership = Membership::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->whereDate('end_date', '>=', now())
                    ->latest('end_date')
                    ->first();

                $startDate = $lastMembership ? Carbon::parse($lastMembership->end_date)->addDay() : now();
                $endDate = Carbon::parse($startDate)->addDays(30);

                $latestMembership = Membership::create([
                    'user_id' => $user->id,
                    'package_name' => 'Paket Bulanan',
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                ]);

            } elseif ($transaction->category === 'pt') {
                $hasMonthly = Membership::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->whereDate('end_date', '>=', now())
                    ->exists();

                if (!$user->is_active_member && !$hasMonthly) {
                    return back()->with('error', 'User belum menjadi member aktif atau tidak memiliki paket bulanan aktif. Gagal approve PT.');
                }

                $ptPackage = $transaction->ptPackage;
                if (!$ptPackage) {
                    return back()->with('error', 'Paket PT tidak ditemukan.');
                }

                PtMembership::create([
                    'user_id' => $user->id,
                    'pt_package_id' => $ptPackage->id,
                    'total_sessions' => $ptPackage->jumlah_sesi,
                    'remaining_sessions' => $ptPackage->jumlah_sesi,
                    'status' => 'active',
                ]);
            }

            // 3. UPDATE STATUS TRANSAKSI
            $transaction->update([
                'status' => 'success',
                'admin_id' => auth()->id(),
            ]);

            DB::commit();

            // 4. KIRIM NOTIFIKASI WA (Dilakukan setelah DB sukses commit)
            if ($user && $user->whatsapp) {
                $waMessage = WhatsappMessage::verificationApproved($user, $transaction, $latestMembership);
                FonnteService::send($user->whatsapp, $waMessage);
            }

            return back()->with('success', 'Verifikasi berhasil. Member: ' . $user->member_code);

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses verifikasi: ' . $th->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $transaction = Transaction::with('user')->findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        DB::beginTransaction();
        try {
            $transaction->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'admin_id' => auth()->id(),
            ]);

            DB::commit();

            // KIRIM NOTIFIKASI PENOLAKAN VIA WA
            $user = $transaction->user;
            if ($user && $user->whatsapp) {
                $waMessage = WhatsappMessage::verificationRejected($user, $request->rejection_reason);
                FonnteService::send($user->whatsapp, $waMessage);
            }

            return back()->with('success', 'Pembayaran berhasil ditolak.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal menolak transaksi: ' . $th->getMessage());
        }
    }
}