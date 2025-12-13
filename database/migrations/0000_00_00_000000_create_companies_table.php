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
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama PT/CV
        $table->string('email')->unique(); // Email perusahaan
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('logo')->nullable(); // URL logo
        $table->string('code')->unique(); // Kode unik (misal: ORCA, UNILEVER)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
