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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

            // Jenis izin: Cuti Tahunan, Sakit, atau Izin Biasa
            $table->enum('type', ['annual', 'sick', 'permission']);

            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days'); // Berapa hari totalnya

            $table->text('reason'); // Alasan cuti

            // Status Approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_note')->nullable(); // Alasan kalau ditolak bos

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
