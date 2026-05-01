<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            // 1. Putus dulu hubungan Foreign Key-nya
            // Nama constraint biasanya: [nama_tabel]_[nama_kolom]_foreign
            $table->dropForeign(['classification_code']); 
            
            // 2. Baru hapus kolomnya
            $table->dropColumn('classification_code');
        });
    }

    public function down()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->string('classification_code')->nullable();
            
            // Kalau mau balikkin Foreign Key-nya di sini (opsional)
            // $table->foreign('classification_code')->references('code')->on('classifications');
        });
    }
};