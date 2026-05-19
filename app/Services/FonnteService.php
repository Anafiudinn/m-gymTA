<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\WhatsappLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * =========================================================
     * SEND WHATSAPP MESSAGE (MANUAL / BYPASS QUEUE)
     * =========================================================
     */
    public static function send($target, $message)
    {
        try {
            $enabled = Setting::where('key', 'wa_enabled')->value('value');

            // 🌟 JIKA WA UTAMA DIMATIKAN, JANGAN KIRIM APAPUN
            if (!$enabled || $enabled == '0') {
                return [
                    'status' => false,
                    'message' => 'WhatsApp Gateway is disabled in settings.',
                ];
            }

            $token = Setting::where('key', 'fonnte_token')->value('value');
            $target = self::formatNumber($target);

            // 1. Tembak API Fonnte
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => $token,
                ])->asForm()->post('https://api.fonnte.com/send', [
                    'target' => $target,
                    'message' => $message,
                ]);

            // Definisikan $resJson setelah response didapat
            $resJson = $response->json();

            // PILOT DEBUG: Intip data asli dari Fonnte di storage/logs/laravel.log
            Log::info('RESPON ASLI FONNTE:', $resJson);

            // Filter Akurasi Status (Sangat toleran terhadap respon string/boolean Fonnte)
            $isSuccess = false;
            if (isset($resJson['status'])) {
                if ($resJson['status'] === true || $resJson['status'] === 'true' || $resJson['status'] === 'success') {
                    $isSuccess = true;
                }
            }

            // Tentukan pesan alasan log
            $reasonMessage = $resJson['reason'] ?? ($resJson['detail'] ?? 'No detail from Fonnte');
            if ($isSuccess) {
                $reasonMessage = 'Sent / In Queue (Success)';
            }

            // ENGINE OTOMATIS LOGS KE DATABASE
            WhatsappLog::create([
                'target'         => $target,
                'recipient_name' => self::guessRecipientName($message),
                'message'        => $message,
                'status'         => $isSuccess,
                'reason'         => $reasonMessage,
            ]);

            return $resJson;

        } catch (\Exception $e) {
            Log::error('Fonnte Error: ' . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * =========================================================
     * CHECK GATEWAY STATUS (DENGAN CACHE 5 MENIT)
     * =========================================================
     */
    public static function checkGatewayStatus()
    {
        $enabled = Setting::where('key', 'wa_enabled')->value('value');
        if (!$enabled || $enabled == '0') {
            return 'disabled';
        }

        // Simpan status di cache selama 5 menit (300 detik)
        return Cache::remember('fonnte_gateway_status', 300, function () {
            $token = Setting::where('key', 'fonnte_token')->value('value');
            if (empty($token)) {
                return 'disconnected';
            }

            try {
                $response = Http::withoutVerifying()
                    ->timeout(3) // Batasi timeout maksimal 3 detik agar tidak memicu bottleneck
                    ->withHeaders(['Authorization' => $token])
                    ->post('https://api.fonnte.com/device');

                $res = $response->json();

                if (isset($res['device_status'])) {
                    $statusDevice = strtolower($res['device_status']);
                    if ($statusDevice === 'connected' || $statusDevice === 'api-ready' || ($res['status'] ?? false) === true) {
                        return 'connected';
                    }
                }
                return 'disconnected';
            } catch (\Exception $e) {
                return 'disconnected';
            }
        });
    }

    /**
     * =========================================================
     * HELPER: FORMAT PHONE NUMBER
     * =========================================================
     */
    private static function formatNumber($number)
    {
        // Bersihkan karakter aneh, pertahankan angka dan koma (jika blast banyak nomor)
        $number = preg_replace('/[^0-9,]/', '', $number);

        // Jika nomor diawali dengan '0' ubah otomatis ke format '62'
        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }

    /**
     * =========================================================
     * HELPER: GUESS RECIPIENT NAME FROM MESSAGE
     * =========================================================
     */
    private static function guessRecipientName($message)
    {
        if (preg_match('/Halo\s+\*?([A-Za-z0-9\s]+)\*?\s+👋/', $message, $matches)) {
            return trim($matches[1]);
        }
        return 'System / Admin';
    }
}