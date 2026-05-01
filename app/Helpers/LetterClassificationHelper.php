<?php

namespace App\Helpers;

use App\Models\Classification;
use Carbon\Carbon;

class LetterClassificationHelper
{
    /**
     * Tentukan klasifikasi otomatis berdasarkan
     * - hari
     * - tipe surat (incoming / outgoing)
     */
    public static function byToday(string $type): ?int
    {
        $day = Carbon::now()->dayOfWeekIso; // 1=Senin .. 7=Minggu

        // Default sekolah
        $code = 'UMUM';

        // Weekend → arsip
        if ($day >= 6) {
            $code = 'ARSIP';
        } else {
            // Hari sekolah
            if ($type === 'outgoing') {
                $code = 'DINAS';
            }
        }

        return Classification::where('code', $code)->value('id');
    }
}
