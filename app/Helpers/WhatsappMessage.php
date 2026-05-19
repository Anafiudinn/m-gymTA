<?php

namespace App\Helpers;

use App\Models\Setting;

class WhatsappMessage
{
    /**
     * Helper internal untuk mengambil nama gym secara dinamis dari database settings
     */
    private static function getGymName()
    {
        $gymName = Setting::where('key', 'gym_name')->value('value');
        return !empty($gymName) ? $gymName : 'UB GYM';
    }

    /**
     * =========================================================
     * NEW MEMBER ACCOUNT
     * =========================================================
     */
    public static function newMemberAccount($user)
    {
        $gym = self::getGymName();
        $message = "🎉 Selamat Datang di *{$gym}*\n\n";
        $message .= "Halo *{$user->name}* 👋\n\n";
        $message .= "Akun member Anda berhasil dibuat.\n\n";

        $message .= "📌 *Informasi Member*\n";
        $message .= "• Kode Member: {$user->member_code}\n";
        $message .= "• WhatsApp: {$user->whatsapp}\n\n";

        $message .= "🔐 *Informasi Login*\n";
        $message .= "• Username: Nomor WhatsApp Anda\n";
        $message .= "• Password: _12345678_\n\n";

        $message .= "⚠️ _Demi keamanan, segera ubah password setelah login melalui area member._\n\n";
        $message .= "Selamat berlatih 💪";

        return $message;
    }

    public static function newMemberWithPackage($user, $membership, $packageName)
    {
        $gym = self::getGymName();
        $message = "🎉 Selamat Datang di *{$gym}*\n\n";
        $message .= "Halo *{$user->name}* 👋\n\n";
        $message .= "Akun member Anda berhasil dibuat dan paket bulanan Anda telah aktif!\n\n";

        $message .= "📌 *Informasi Member*\n";
        $message .= "• Kode Member: {$user->member_code}\n";
        $message .= "• WhatsApp: {$user->whatsapp}\n\n";

        $message .= "🔐 *Informasi Login*\n";
        $message .= "• Username: Nomor WhatsApp Anda\n";
        $message .= "• Password: _12345678_\n\n";

        $message .= "⚠️ _Demi keamanan, segera ubah password setelah login._\n\n";

        $message .= "📦 *Detail Paket Bulanan*\n";
        $message .= "• Jenis Paket: {$packageName}\n";
        $message .= "• Masa Aktif: " . $membership->start_date->format('d M Y') . " s/d " . $membership->end_date->format('d M Y') . "\n\n";

        $message .= "Selamat berlatih 💪";

        return $message;
    }

    /**
     * =========================================================
     * MEMBER ACTIVATION
     * =========================================================
     */
    public static function activation($user)
    {
        $message = "✅ *Aktivasi Member Berhasil*\n\n";
        $message .= "Halo *{$user->name}* 👋\n\n";
        $message .= "Status member Anda berhasil diaktivasi.\n\n";

        $message .= "📌 *Kode Member*\n";
        $message .= "👉 *{$user->member_code}*\n\n";

        $message .= "Selamat berlatih 💪";

        return $message;
    }

    /**
     * =========================================================
     * MONTHLY PACKAGE
     * =========================================================
     */
    public static function monthly($user, $membership, $packageName)
    {
        $message = "✅ *Paket Bulanan Aktif*\n\n";
        $message .= "Halo *{$user->name}* 👋\n\n";
        $message .= "Paket bulanan Anda berhasil diaktifkan.\n\n";

        $message .= "📦 *Jenis Paket*\n";
        $message .= "• {$packageName}\n\n";

        $message .= "📅 *Masa Aktif*\n";
        $message .= "• " . $membership->start_date->format('d M Y') . " s/d " . $membership->end_date->format('d M Y') . "\n\n";

        $message .= "Selamat berlatih 💪";

        return $message;
    }

    /**
     * =========================================================
     * PT PACKAGE
     * =========================================================
     */
    public static function pt($user, $package)
    {
        $message = "✅ *Paket Personal Trainer Aktif*\n\n";
        $message .= "Halo *{$user->name}* 👋\n\n";
        $message .= "Paket PT berhasil ditambahkan.\n\n";

        $message .= "🏋️ *Paket PT*\n";
        $message .= "• {$package->nama_paket}\n\n";

        $message .= "🎯 *Jumlah Sesi*\n";
        $message .= "• {$package->jumlah_sesi}x sesi pertemuan\n\n";

        if ($package->coach_name) {
            $message .= "👨‍🏫 *Coach / Trainer*\n";
            $message .= "• {$package->coach_name}\n\n";
        }

        $message .= "Semangat latihan 🔥";

        return $message;
    }

    /**
     * =========================================================
     * TRANSACTION CANCELLED NOTIFICATION
     * =========================================================
     */
    public static function transactionCancelled($user, $transaction)
    {
        $gym = self::getGymName();
        $message = "⚠️ *Pemberitahuan Pembatalan Transaksi*\n\n";
        $message .= "Halo *{$user->name}* 👋\n\n";
        $message .= "Kami menginformasikan bahwa transaksi Anda telah *DIBATALKAN* oleh pihak admin *{$gym}*.\n\n";

        $message .= "📌 *Detail Transaksi yang Dibatalkan:*\n";
        $message .= "• Kode Invoice: {$transaction->invoice_code}\n";
        
        $kategori = 'Lain-lain';
        if ($transaction->category === 'activation') $kategori = 'Biaya Aktivasi Member';
        if ($transaction->category === 'monthly') $kategori = 'Paket Bulanan';
        if ($transaction->category === 'pt') $kategori = 'Paket Personal Trainer';
        
        $message .= "• Kategori: {$kategori}\n";
        $message .= "• Nominal: Rp " . number_format($transaction->amount, 0, ',', '.') . "\n\n";

        $message .= "Jika Anda merasa ini adalah kesalahan, silakan hubungi meja kasir/admin gym. Terima kasih 🙌";

        return $message;
    }

    /**
     * =========================================================
     * ONLINE TRANSACTION APPROVED NOTIFICATION
     * =========================================================
     */
    public static function verificationApproved($user, $transaction, $latestMembership = null)
    {
        $gym = self::getGymName();
        $message = "✅ *Pembayaran Berhasil Diverifikasi*\n\n";
        $message .= "Halo *{$user->name}*, terima kasih! Pembayaran online Anda telah diverifikasi oleh admin *{$gym}*.\n\n";

        if ($transaction->category === 'activation') {
            $message .= "📦 *Detail Benefit:*\n";
            $message .= "• Aktivasi Akun Member: BERHASIL\n";
            $message .= "• Kode Member Resmi: {$user->member_code}\n\n";
            $message .= "Silakan gunakan kode member atau nomor WA Anda untuk check-in di kasir.";
        } elseif ($transaction->category === 'monthly') {
            $message .= "📦 *Detail Paket:*\n";
            $message .= "• Jenis: Paket Bulanan GYM\n";
            if ($latestMembership) {
                $message .= "• Masa Aktif: " . $latestMembership->start_date->format('d M Y') . " s/d " . $latestMembership->end_date->format('d M Y') . "\n";
            }
        } elseif ($transaction->category === 'pt') {
            $message .= "📦 *Detail Paket PT:*\n";
            if ($transaction->ptPackage) {
                $message .= "• Nama Paket: {$transaction->ptPackage->nama_paket}\n";
                $message .= "• Total Sesi: {$transaction->ptPackage->jumlah_sesi}x Pertemuan\n";
            }
        }

        $message .= "\n\nSelamat berlatih dan jaga kesehatan selalu 💪";
        return $message;
    }

    /**
     * =========================================================
     * ONLINE TRANSACTION REJECTED NOTIFICATION
     * =========================================================
     */
    public static function verificationRejected($user, $reason)
    {
        $gym = self::getGymName();
        $message = "❌ *Pembayaran Gagal Diverifikasi*\n\n";
        $message .= "Halo *{$user->name}*,\n";
        $message .= "Mohon maaf, bukti pembayaran transfer yang Anda kirimkan belum dapat kami setujui.\n\n";
        
        $message .= "⚠️ *Alasan Penolakan:*\n";
        $message .= "\"_{$reason}_\"\n\n";
        
        $message .= "Silakan lakukan upload ulang bukti transfer yang valid melalui website member, atau hubungi kasir *{$gym}* jika ada kendala. Terima kasih 🙌";
        return $message;
    }

    /**
     * =========================================================
     * GYM ATTENDANCE / CHECK-IN NOTIFICATION
     * =========================================================
     */
    public static function attendanceCheckIn($name, $statusLabel, $amount, $paymentMethod = 'cash')
    {
        $gym = self::getGymName();
        $message = "✨ *Konfirmasi Check-In {$gym}*\n\n";
        $message .= "Halo *{$name}* 👋\n\n";
        $message .= "Konfirmasi kehadiran Anda hari ini berhasil dicatat oleh sistem kami.\n\n";
        
        $message .= "📋 *Detail Kunjungan:*\n";
        $message .= "• Status Anda: {$statusLabel}\n";
        $message .= "• Jam Masuk: " . now()->format('H:i') . " WIB\n";

        if ($amount > 0) {
            $message .= "• Biaya Visit: Rp " . number_format($amount, 0, ',', '.') . "\n";
            $message .= "• Metode Bayar: " . ucfirst($paymentMethod) . "\n";
            $message .= "• Status Nota: *LUNAS* ✅\n";
        } else {
            $message .= "• Biaya Visit: Rp 0 (Benefit Paket Aktif) 🎉\n";
        }

        $message .= "\nSelamat berolahraga! Tetap fokus, jaga hidrasi, dan mari bentuk tubuh idealmu hari ini 💪🔥";
        return $message;
    }

    /**
     * =========================================================
     * PT SESSION CHECK-IN / CUT SESSION NOTIFICATION
     * =========================================================
     */
    public static function ptSessionCut($user, $membership, $before, $after)
    {
        $message = "💪 *Latihan Personal Trainer Selesai*\n\n";
        $message .= "Halo *{$user->name}* 👋\n\n";
        $message .= "Satu sesi latihan Personal Trainer Anda baru saja berhasil digunakan.\n\n";

        $message .= "📋 *Detail Penggunaan Sesi:*\n";
        $message .= "• Paket PT: " . ($membership->package->nama_paket ?? 'Personal Trainer') . "\n";
        $message .= "• Sesi Sebelumnya: {$before}x\n";
        $message .= "• Sesi Digunakan: 1x\n";
        $message .= "• *Sisa Sesi Anda*: *{$after}x* Pertemuan\n\n";

        if ($after <= 3 && $after > 0) {
            $message .= "⚠️ _Catatan: Sesi latihan Anda sudah hampir habis. Jangan lupa untuk memperpanjang paket Anda ke kasir ya!_\n\n";
        } elseif ($after === 0) {
            $message .= "🎉 _Catatan: Sesi latihan Anda untuk paket ini telah habis digunakan seluruhnya. Sampai jumpa di paket latihan berikutnya!_\n\n";
        }

        $message .= "Terima kasih telah berlatih dengan giat hari ini, keep it up! 🔥";

        return $message;
    }

    public static function memberStatusToggled($memberName, $isActive)
    {
        $gym = self::getGymName();
        if ($isActive) {
            return "Halo, *{$memberName}*! 👋\n\n"
                . "Akun keanggotaan Anda di *{$gym}* telah *AKTIF KEMBALI*.\n\n"
                . "Silakan kunjungi gym untuk melakukan check-in dan menikmati fasilitas kami.\n\n"
                . "Sampai jumpa di area latihan! 💪🏋️‍♂️";
        } else {
            return "Halo, *{$memberName}*.\n\n"
                . "Informasi dari *{$gym}*, saat ini status keanggotaan Anda telah diubah menjadi *NON-AKTIF* oleh sistem/admin.\n\n"
                . "Jika ini merupakan kekeliruan, silakan hubungi admin kami di meja kasir.\n\n"
                . "Terima kasih atas perhatiannya. 🙏";
        }
    }

    public static function paymentSubmittedToMember($memberName, $category, $isReupload = false)
    {
        $gym = self::getGymName();
        $action = $isReupload ? "UNGGAH ULANG" : "KIRIM";
        $type = match ($category) {
            'activation' => 'Aktivasi Member Baru',
            'monthly'    => 'Paket Bulanan GYM',
            'pt'         => 'Paket Personal Trainer (PT)',
            default      => 'Pembelian Paket',
        };

        return "Halo, *{$memberName}*! 👋\n\n"
            . "Bukti pembayaran untuk *{$type}* telah berhasil Anda {$action}.\n\n"
            . "Saat ini pembayaran Anda sedang dalam proses antrean verifikasi oleh Admin *{$gym}*. Kami akan mengirimkan notifikasi kembali setelah statusnya diperbarui.\n\n"
            . "Terima kasih telah melakukan pembayaran secara online! 🙏✨";
    }

    /**
     * NOTIFIKASI UNTUK ADMIN
     */
    public static function paymentNotificationToAdmin($memberName, $category, $amount, $isReupload = false)
    {
        $gym = self::getGymName();
        $statusBadge = $isReupload ? "🚨 *UPLOAD ULANG BUKTI*" : "📦 *PEMBAYARAN BARU (ONLINE)*";
        $type = match ($category) {
            'activation' => 'Aktivasi Member',
            'monthly'    => 'Paket Bulanan GYM',
            'pt'         => 'Paket Personal Trainer (PT)',
            default      => 'Paket',
        };

        return "=== *{$gym} NOTIFICATION* ===\n"
            . "{$statusBadge}\n\n"
            . "Halo Admin, ada transaksi online masuk yang memerlukan verifikasi:\n\n"
            . "▪️ *Nama Member:* {$memberName}\n"
            . "▪️ *Jenis Kategori:* {$type}\n"
            . "▪️ *Nominal:* Rp " . number_format($amount, 0, ',', '.') . "\n\n"
            . "Mohon segera login ke Dashboard Admin untuk mengecek mutasi rekening dan melakukan validasi berkas bukti transfer.\n\n"
            . "⚠️ _Pesan otomatis dikirim oleh sistem gateway Owner._";
    }
    /**
     * =========================================================
     * MEMBERSHIP EXPIRY REMINDER (AUTOMATIC TASK)
     * =========================================================
     */
    public static function membershipExpiryReminder($user, $membership, $daysLeft)
    {
        $gym = self::getGymName();
        $urgency = $daysLeft <= 1 ? "🚨 *PEMBERITAHUAN DARURAT*" : "⏳ *PEMBERITAHUAN PENGINGAT*";

        $message = "=== *{$gym} INBOUND REMINDER* ===\n"
            . "{$urgency}\n\n"
            . "Halo *{$user->name}* 👋\n\n"
            . "Kami ingin menginformasikan bahwa masa aktif paket bulanan gym Anda di *{$gym}* akan segera berakhir.\n\n"
            . "📋 *Detail Paket Anda:*\n"
            . "• Paket Saat Ini: Bulanan Gym\n"
            . "• Tanggal Berakhir: " . \Carbon\Carbon::parse($membership->end_date)->format('d M Y') . "\n"
            . "• *Sisa Masa Aktif:* *{$daysLeft} Hari Lagi*\n\n"
            . "Supaya latihanmu tidak terputus dan tetap bisa langsung *check-in/scan* dengan nyaman di meja kasir, yuk segera lakukan perpanjangan paketmu!\n\n"
            . "Kamu bisa langsung bayar tunai ke meja kasir atau melakukan transfer online melalui area member di website kami.\n\n"
            . "Sampai jumpa di area latihan, teruskan konsistensimu! 💪🔥";

        return $message;
    }
}