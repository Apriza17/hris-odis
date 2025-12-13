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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

            $table->date('date'); // Tanggal absen (2025-12-13)
            $table->time('time_in'); // Jam Masuk (08:00:00)
            $table->time('time_out')->nullable(); // Jam Pulang (Bisa null kalau belum pulang)

            // Data Lokasi (Koordinat Google Maps)
            $table->string('lat_in')->nullable();
            $table->string('long_in')->nullable();
            $table->string('lat_out')->nullable();
            $table->string('long_out')->nullable();

            // Status: present (Hadir), late (Telat), sick (Sakit), permit (Izin)
            $table->string('status')->default('present');

            $table->text('note')->nullable(); // Kalau telat, alasannya apa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
