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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relasi ke akun login

        // Relasi ke Master Data
        $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('position_id')->nullable()->constrained()->nullOnDelete();

        // Data Karyawan
        $table->string('nip')->nullable(); // Nomor Induk Pegawai
        $table->string('nik_ktp')->nullable(); // KTP
        $table->string('place_of_birth')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->enum('gender', ['male', 'female'])->nullable();
        $table->text('address')->nullable();
        $table->string('phone')->nullable();

        // Data Kerja
        $table->date('join_date')->nullable();
        $table->date('end_date')->nullable(); // Kalau resign/kontrak habis
        $table->enum('status', ['permanent', 'contract', 'internship'])->default('contract');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
