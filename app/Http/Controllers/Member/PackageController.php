<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type'             => 'required|in:activation,monthly,pt',
            'package_id'       => 'required_if:type,pt',

            'amount'           => 'required|numeric|min:1',

            'sender_bank'      => 'required|string|max:100',
            'sender_name'      => 'required|string|max:100',
            'sender_account'   => 'required|string|max:50',

            'proof_attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CEK TRANSAKSI PENDING
        |--------------------------------------------------------------------------
        */

        $pendingTransaction = Transaction::where('user_id', $user->id)
            ->where('category', $request->type)

            // KHUSUS PT → cek per paket
            ->when($request->type === 'pt', function ($query) use ($request) {
                $query->where('package_id', $request->package_id);
            })

            ->where('status', 'pending')
            ->first();

        if ($pendingTransaction) {

            if ($request->type === 'pt') {
                return back()->with(
                    'error',
                    'Paket PT ini masih dalam proses verifikasi admin.'
                );
            }

            return back()->with(
                'error',
                'Anda masih memiliki transaksi '
                . strtoupper($request->type)
                . ' yang sedang diproses admin.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CEK AKTIVASI MEMBER
        |--------------------------------------------------------------------------
        */

        if (
            $request->type === 'activation'
            && $user->is_active_member
        ) {
            return back()->with(
                'error',
                'Akun Anda sudah aktif sebagai member.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | UPLOAD BUKTI
        |--------------------------------------------------------------------------
        */

        $proofPath = $request->file('proof_attachment')
            ->store('proofs', 'public');

        /*
        |--------------------------------------------------------------------------
        | SIMPAN TRANSAKSI
        |--------------------------------------------------------------------------
        */

        Transaction::create([

            'invoice_code' => 'TRX-' . strtoupper(Str::random(8)),

            'user_id'      => $user->id,

            // null = belum diverifikasi admin
            'admin_id'     => null,

            'category'     => $request->type,

            // khusus PT
            'package_id'   => $request->type === 'pt'
                ? $request->package_id
                : null,

            'amount'       => $request->amount,

            'payment_method' => 'transfer',

            // online / onsite
            'source'       => 'online',

            /*
            |--------------------------------------------------------------------------
            | DATA PENGIRIM
            |--------------------------------------------------------------------------
            */

            'sender_bank'    => $request->sender_bank,
            'sender_name'    => $request->sender_name,
            'sender_account' => $request->sender_account,

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => 'pending',

            /*
            |--------------------------------------------------------------------------
            | BUKTI
            |--------------------------------------------------------------------------
            */

            'proof_attachment' => $proofPath,
        ]);

        return redirect()
            ->route('member.dashboard', ['tab' => 'history'])
            ->with(
                'success',
                'Pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.'
            );
    }

    public function reupload(Request $request, $id)
    {
        $request->validate([
            'sender_bank'      => 'required|string|max:100',
            'sender_name'      => 'required|string|max:100',
            'sender_account'   => 'required|string|max:50',

            'proof_attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL TRANSAKSI USER
        |--------------------------------------------------------------------------
        */

        $transaction = Transaction::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | HANYA BOLEH REUPLOAD JIKA REJECTED
        |--------------------------------------------------------------------------
        */

        if ($transaction->status !== 'rejected') {
            return back()->with(
                'error',
                'Transaksi ini tidak dapat diupload ulang.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | UPLOAD BUKTI BARU
        |--------------------------------------------------------------------------
        */

        $proofPath = $request->file('proof_attachment')
            ->store('proofs', 'public');

        /*
        |--------------------------------------------------------------------------
        | UPDATE TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $transaction->update([

            'sender_bank'    => $request->sender_bank,
            'sender_name'    => $request->sender_name,
            'sender_account' => $request->sender_account,

            'proof_attachment' => $proofPath,

            // kembali diproses
            'status' => 'pending',

            // reset alasan reject
            'rejection_reason' => null,

            // reset admin verifier
            'admin_id' => null,
        ]);

        return redirect()
            ->route('member.dashboard', ['tab' => 'history'])
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim ulang.'
            );
    }
}