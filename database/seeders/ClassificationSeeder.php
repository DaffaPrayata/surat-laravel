<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classification;

class ClassificationSeeder extends Seeder
{
    public function run(): void
    {
        Classification::insert([
            [
                'code' => 'UMUM',
                'name' => 'Surat Umum',
                'type' => 'incoming',
                'description' => 'Surat masuk umum (hari kerja)',
            ],
            [
                'code' => 'DINAS',
                'name' => 'Surat Dinas',
                'type' => 'outgoing',
                'description' => 'Surat keluar resmi sekolah',
            ],
            [
                'code' => 'ARSIP',
                'name' => 'Arsip',
                'type' => 'all',
                'description' => 'Surat otomatis saat hari libur / weekend',
            ],
        ]);
    }
}
