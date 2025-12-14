<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Koordinat Kantor
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            // Radius Toleransi (dalam meter, default 50 meter)
            $table->integer('radius_km')->default(50);

            // Jam Masuk/Pulang Default (Opsional, buat validasi telat nanti)
            $table->time('time_in')->default('09:00:00');
            $table->time('time_out')->default('17:00:00');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'radius_km', 'time_in', 'time_out']);
        });
    }
};
