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
            'amount'           => 'required|numeric',

            'sender_bank'      => 'required|string|max:100',
            'sender_name'      => 'required|string|max:100',
            'sender_account'   => 'required|string|max:50',

            'proof_attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $userId = Auth::id();

        // 1. Cek apakah ada transaksi kategori ini yang masih PENDING
        // Ini mencegah user spam klik atau beli paket berkali-kali sebelum di-approve
        $pendingTransaction = Transaction::where('user_id', $userId)
            ->where('category', $request->type)
            ->where('status', 'pending')
            ->first();

        if ($pendingTransaction) {
            return redirect()
                ->back()
                ->with('error', 'Anda masih memiliki transaksi ' . strtoupper($request->type) . ' yang sedang menunggu verifikasi admin.');
        }

        // 2. Tambahan: Jika tipe adalah 'activation', cek apakah user sudah aktif
        if ($request->type === 'activation' && Auth::user()->is_active_member) {
            return redirect()
                ->back()
                ->with('error', 'Akun Anda sudah aktif sebagai member.');
        }

        // Upload bukti pembayaran
        $proofPath = $request->file('proof_attachment')
            ->store('proofs', 'public');

        // Simpan transaksi pending
        Transaction::create([
            'invoice_code'     => 'TRX-' . strtoupper(Str::random(8)),
            'user_id'          => $userId,
            'admin_id'         => null,

            'category'         => $request->type,

            'package_id'       => $request->type === 'pt'
                ? $request->package_id
                : null,

            'amount'           => $request->amount,

            'payment_method'   => 'transfer',

            'source'           => 'online',

            'sender_bank'      => $request->sender_bank,
            'sender_name'      => $request->sender_name,
            'sender_account'   => $request->sender_account,

            'status'           => 'pending',

            'proof_attachment' => $proofPath,
        ]);

        return redirect()
            ->route('member.dashboard', ['tab' => 'history'])
            ->with('success', 'Pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.');
    }
public function reupload(Request $request, $id)
{
    $request->validate([
        'sender_bank'      => 'required|string|max:100',
        'sender_name'      => 'required|string|max:100',
        'sender_account'    => 'required|string|max:100',
        'proof_attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $transaction = Transaction::where('user_id', Auth::id())
        ->where('id', $id)
        ->firstOrFail();

    // Upload bukti baru
    $proofPath = $request->file('proof_attachment')
        ->store('proofs', 'public');

    // Update transaksi
    $transaction->update([
        'sender_bank'      => $request->sender_bank,
        'sender_name'      => $request->sender_name,
        'sender_account'   => $request->sender_account,

        'proof_attachment' => $proofPath,

        // balik lagi ke pending
        'status'            => 'pending',

        // hapus alasan reject lama
        'rejection_reason'  => null,
    ]);

    return redirect()
        ->route('member.dashboard', ['tab' => 'history'])
        ->with('success', 'Bukti pembayaran berhasil dikirim ulang.');
}
}
