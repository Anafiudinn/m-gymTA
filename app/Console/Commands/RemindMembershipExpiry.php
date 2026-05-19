<?php

namespace App\Console\Commands;

use App\Helpers\WhatsappMessage;
use App\Models\Membership;
use App\Services\FonnteService;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class RemindMembershipExpiry extends Command
{
    // Nama command yang akan dipanggil oleh kernel / cron job
    protected $signature = 'membership:remind';

    // Deskripsi singkat command
    protected $description = 'Kirim notifikasi WhatsApp pengingat untuk member yang paket bulanannya mau habis (H-3 dan H-1)';

    public function handle()
    {
        $this->info('Memulai pengecekan paket member...');

        // Tentukan target tanggal H-3 dan H-1 dari hari ini
        $targetH3 = Carbon::tomorrow()->addDays(2)->toDateString(); // Hari ini + 3 hari
        $targetH1 = Carbon::tomorrow()->toDateString();            // Hari ini + 1 hari

        // Ambil data membership yang statusnya 'active' dan berakhir di tanggal target
        $expiringMemberships = Membership::with('user')
            ->where('status', 'active')
            ->whereIn(DB::raw('DATE(end_date)'), [$targetH3, $targetH1])
            ->get();

        if ($expiringMemberships->isEmpty()) {
            $this->info('Tidak ada member yang mendekati masa kedaluwarsa hari ini.');
            return Command::SUCCESS;
        }

        foreach ($expiringMemberships as $membership) {
            $user = $membership->user;

            // Pastikan user punya nomor WhatsApp
            if ($user && $user->whatsapp) {
                $cleanPhone = \App\Helpers\WhatsappFormat::formatNumber($user->whatsapp);
                
                if ($cleanPhone) {
                    // Hitung sisa hari secara real-time
                    $daysLeft = Carbon::parse($membership->end_date)->diffInDays(Carbon::today());

                    // Buat template pesan (nanti kita tambahkan metodenya di WhatsappMessage)
                    $msg = WhatsappMessage::membershipExpiryReminder($user, $membership, $daysLeft);

                    // Tembak ke Fonnte
                    FonnteService::send($cleanPhone, $msg);
                    
                    $this->info("Notifikasi pengingat berhasil dikirim ke: {$user->name} (Sisa {$daysLeft} hari)");
                }
            }
        }

        $this->info('Proses pengiriman notifikasi pengingat selesai.');
        return Command::SUCCESS;
    }
}