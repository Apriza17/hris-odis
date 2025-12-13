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
    Schema::table('employees', function (Blueprint $table) {
        // Info Gaji Dasar
        $table->decimal('basic_salary', 15, 2)->default(0)->after('status'); // Gaji Pokok (Decimal biar aman)

        // Info Rekening (Buat Transfer)
        $table->string('bank_name')->nullable()->after('basic_salary'); // BCA, Mandiri
        $table->string('account_number')->nullable()->after('bank_name');
        $table->string('account_holder')->nullable()->after('account_number');
    });
}

public function down(): void
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn(['basic_salary', 'bank_name', 'account_number', 'account_holder']);
    });
}
};
