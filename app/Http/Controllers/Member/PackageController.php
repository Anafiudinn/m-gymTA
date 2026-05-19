<?php

namespace App\Http\Controllers\Member;

use App\Helpers\WhatsappMessage;
use App\Http\Controllers\Controller;
use App\Models\PtPackage;
use App\Models\Transaction; // Panggil model User untuk cari nomor Admin
use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type'             => 'required|in:activation,monthly,pt',

            // 🌟 FIX: Tambahkan 'nullable' sebelum 'exists'. 
            // Ini memerintahkan Laravel untuk mengabaikan cek database jika nilainya kosong (saat beli monthly/activation)
            'package_id'       => 'required_if:type,pt|nullable|exists:pt_packages,id',

            'sender_bank'      => 'required|string|max:100',
            'sender_name'      => 'required|string|max:100',
            'sender_account'   => 'required|string|max:50',
            'proof_attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        /*
|--------------------------------------------------------------------------
| TENTUKAN AMOUNT DARI BACKEND
|--------------------------------------------------------------------------
*/
        $amount = 0;
        if ($request->type === 'activation') {
            $amount = 80000; // Standar Aktivasi UB GYM
        } elseif ($request->type === 'monthly') {
            $amount = 110000; // Standar Bulanan UB GYM
        } elseif ($request->type === 'pt') {
            // Ambil harga asli langsung dari database berdasarkan paket PT yang dipilih
            $ptPackage = PtPackage::findOrFail($request->package_id);

            // ✨ FIX: Diubah menjadi 'harga' sesuai dengan fillable di model PtPackage
            $amount = $ptPackage->harga;
        }

        // Tambahan rem darurat: Jika karena suatu hal harganya tetap 0 atau null, batalkan proses
        if (! $amount || $amount <= 0) {
            return back()->with('error', 'Sistem gagal menentukan nominal pembayaran paket ini. Mohon hubungi admin.');
        }

        // Cek transaksi pending
        $pendingTransaction = Transaction::where('user_id', $user->id)
            ->where('category', $request->type)
            ->when($request->type === 'pt', function ($query) use ($request) {
                $query->where('package_id', $request->package_id);
            })
            ->where('status', 'pending')
            ->first();

        if ($pendingTransaction) {
            if ($request->type === 'pt') {
                return back()->with('error', 'Paket PT ini masih dalam proses verifikasi admin.');
            }

            return back()->with('error', 'Anda masih memiliki transaksi ' . strtoupper($request->type) . ' yang sedang diproses admin.');
        }

        if ($request->type === 'activation' && $user->is_active_member) {
            return back()->with('error', 'Akun Anda sudah aktif sebagai member.');
        }

        // Upload bukti
        $proofPath = $request->file('proof_attachment')->store('proofs', 'public');

        // Simpan Transaksi
        $transaction = Transaction::create([
            'invoice_code' => 'TRX-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'admin_id' => null,
            'category' => $request->type,
            'package_id' => $request->type === 'pt' ? $request->package_id : null,
            'amount' => $amount,
            'payment_method' => 'transfer',
            'source' => 'online',
            'sender_bank' => $request->sender_bank,
            'sender_name' => $request->sender_name,
            'sender_account' => $request->sender_account,
            'status' => 'pending',
            'proof_attachment' => $proofPath,
        ]);

        /*
        |--------------------------------------------------------------------------
        | ENGINE NOTIFIKASI WHATSAPP (STORE)
        |--------------------------------------------------------------------------
        */
        /*
|--------------------------------------------------------------------------
| ENGINE NOTIFIKASI WHATSAPP (SAMPEL UNTUK STORE & REUPLOAD)
|--------------------------------------------------------------------------
*/
        try {
            // 1. Kirim ke Member Sendiri
            if ($user->whatsapp) {
                $memberMsg = WhatsappMessage::paymentSubmittedToMember($user->name, $request->type, false);
                FonnteService::send($user->whatsapp, $memberMsg);
            }

            // 2. Ambil Nomor Admin yang HANYA berstatus AKUN AKTIF
            $rawAdminPhones = User::where('role', 'admin')
                ->where('is_active_account', true) // ✨ FIX: Menggunakan nama kolom dari model User kamu
                ->whereNotNull('whatsapp')
                ->pluck('whatsapp')
                ->toArray();

            $cleanAdminPhones = [];
            foreach ($rawAdminPhones as $phone) {
                $cleanPhone = \App\Helpers\WhatsappFormat::formatNumber($phone);
                if ($cleanPhone) {
                    $cleanAdminPhones[] = $cleanPhone;
                }
            }

            $cleanAdminPhones = array_unique($cleanAdminPhones);

            if (!empty($cleanAdminPhones)) {
                // Tentukan data berdasarkan konteks (store / reupload)
                $currentAmount = isset($amount) ? $amount : $transaction->amount;
                $currentCategory = isset($request->type) ? $request->type : $transaction->category;
                $isReuploadStatus = isset($transaction) && $transaction->status === 'rejected';

                $adminMsg = WhatsappMessage::paymentNotificationToAdmin($user->name, $currentCategory, $currentAmount, $isReuploadStatus);

                // Gabungkan nomor dengan koma (Aman karena FonnteService sudah kita adjust kemarin)
                $targetAdmins = implode(',', $cleanAdminPhones);
                FonnteService::send($targetAdmins, $adminMsg);
            }
        } catch (\Throwable $th) {
            Log::error('WA Pembayaran Gagal: ' . $th->getMessage());
        }

        return redirect()
            ->route('member.dashboard', ['tab' => 'history'])
            ->with('success', 'Pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.');
    }

    public function reupload(Request $request, $id)
    {
        $request->validate([
            'sender_bank' => 'required|string|max:100',
            'sender_name' => 'required|string|max:100',
            'sender_account' => 'required|string|max:50',
            'proof_attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $transaction = Transaction::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($transaction->status !== 'rejected') {
            return back()->with('error', 'Transaksi ini tidak dapat diupload ulang.');
        }

        // Hapus Bukti Lama
        if ($transaction->proof_attachment && Storage::disk('public')->exists($transaction->proof_attachment)) {
            Storage::disk('public')->delete($transaction->proof_attachment);
        }

        // Upload bukti baru
        $proofPath = $request->file('proof_attachment')->store('proofs', 'public');

        $transaction->update([
            'sender_bank' => $request->sender_bank,
            'sender_name' => $request->sender_name,
            'sender_account' => $request->sender_account,
            'proof_attachment' => $proofPath,
            'status' => 'pending',
            'rejection_reason' => null,
            'admin_id' => null,
        ]);

        $user = Auth::user();
        /*
|--------------------------------------------------------------------------
| ENGINE NOTIFIKASI WHATSAPP (SAMPEL UNTUK STORE & REUPLOAD)
|--------------------------------------------------------------------------
*/
        try {
            // 1. Kirim ke Member Sendiri
            if ($user->whatsapp) {
                $memberMsg = WhatsappMessage::paymentSubmittedToMember($user->name, $request->type, false);
                FonnteService::send($user->whatsapp, $memberMsg);
            }

            // 2. Ambil Nomor Admin & Bersihkan Formatnya memakai Helper
            // 2. Ambil Nomor Admin yang HANYA berstatus AKUN AKTIF
            $rawAdminPhones = User::where('role', 'admin')
                ->where('is_active_account', true) // ✨ FIX: Menggunakan nama kolom dari model User kamu
                ->whereNotNull('whatsapp')
                ->pluck('whatsapp')
                ->toArray();

            $cleanAdminPhones = [];
            foreach ($rawAdminPhones as $phone) {
                $cleanPhone = \App\Helpers\WhatsappFormat::formatNumber($phone);
                if ($cleanPhone) {
                    $cleanAdminPhones[] = $cleanPhone;
                }
            }

            $cleanAdminPhones = array_unique($cleanAdminPhones);

            if (!empty($cleanAdminPhones)) {
                // Tentukan data berdasarkan konteks (store / reupload)
                $currentAmount = isset($amount) ? $amount : $transaction->amount;
                $currentCategory = isset($request->type) ? $request->type : $transaction->category;
                $isReuploadStatus = isset($transaction) && $transaction->status === 'rejected';

                $adminMsg = WhatsappMessage::paymentNotificationToAdmin($user->name, $currentCategory, $currentAmount, $isReuploadStatus);

                // Gabungkan nomor dengan koma (Aman karena FonnteService sudah kita adjust kemarin)
                $targetAdmins = implode(',', $cleanAdminPhones);
                FonnteService::send($targetAdmins, $adminMsg);
            }
        } catch (\Throwable $th) {
            Log::error('WA Pembayaran Gagal: ' . $th->getMessage());
        }

        return redirect()
            ->route('member.dashboard', ['tab' => 'history'])
            ->with('success', 'Bukti pembayaran berhasil dikirim ulang.');
    }
}
