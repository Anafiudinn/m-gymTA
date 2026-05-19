<?php


namespace App\Helpers;

class WhatsappFormat
{
   public static function formatNumber($number)
    {
        if (empty($number)) {
            return null;
        }

        // 1. Hilangkan semua karakter non-angka (seperti spasi, strip, tanda plus, dll)
        $cleaned = preg_replace('/[^0-9]/', '', $number);

        // 2. Jika nomor diawali dengan '08', ubah menjadi '628'
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        }

        // 3. Jika nomor internasional ditulis tanpa '+', tapi langsung '62' atau sudah benar, biarkan saja
        return $cleaned;
    }
}