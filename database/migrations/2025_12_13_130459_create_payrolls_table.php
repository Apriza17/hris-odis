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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

            // Periode Gaji
            $table->string('month'); // "December"
            $table->year('year');    // 2025
            $table->date('pay_date'); // Tanggal digenerate (misal: 2025-12-25)

            // Rincian (Snapshot)
            // Kita simpan angkanya di sini, biar kalau master gaji berubah, history ini gak ikut berubah
            $table->decimal('basic_salary', 15, 2);
            $table->decimal('allowances', 15, 2)->default(0); // Total Tunjangan
            $table->decimal('deductions', 15, 2)->default(0); // Total Potongan (Telat/Alpha)
            $table->decimal('net_salary', 15, 2); // Gaji Bersih (Basic + Allow - Deduct)

            // Status
            $table->enum('status', ['draft', 'paid'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
