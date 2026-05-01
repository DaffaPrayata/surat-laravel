<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
 * Run the migrations.
 *
 * @return void
 */
public function up()
{
    Schema::table('letters', function (Blueprint $table) {
        // Karena index-nya sudah tidak ada di database, baris ini kita matikan
        // agar tidak menyebabkan error saat menjalankan php artisan migrate.
        // $table->dropUnique(['reference_number']);
    });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::table('letters', function (Blueprint $table) {
        // Jika ingin mengembalikan sifat unique di masa depan:
        // $table->unique('reference_number');
    });
}
};