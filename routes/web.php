<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PayrollComponentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TenantController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // === AREA PUBLIK (Semua Karyawan Bisa Akses) ===
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('leaves', LeaveController::class); // Karyawan butuh ini buat request

    // Absensi
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

    // Payroll (Index boleh diakses karyawan buat lihat slip sendiri)
    Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
    Route::get('/payrolls/{id}/slip', [PayrollController::class, 'downloadSlip'])->name('payrolls.download');


    // === AREA TERLARANG (Khusus Admin / Super Admin) ===
    Route::middleware(['role:admin'])->group(function () {

        // Master Data Departemen & Jabatan
        // Departemen (Utama)
        Route::resource('departments', DepartmentController::class)->only(['index', 'store', 'destroy']);
        // Jabatan (Numpang Store & Destroy)
        Route::resource('positions', PositionController::class)->only(['store', 'destroy']);

        // Master Data Karyawan
        Route::resource('employees', EmployeeController::class);

        // Master Komponen Gaji
        Route::resource('payroll-components', PayrollComponentController::class);

        // Fitur Generate Payroll & Approval Cuti
        Route::post('/payrolls/generate', [PayrollController::class, 'generate'])->name('payrolls.generate');
        Route::patch('/leaves/{id}/approval', [LeaveController::class, 'approval'])->name('leaves.approval');

        // Pengaturan Kantor
        Route::get('/settings', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('/settings', [CompanyController::class, 'update'])->name('company.update');

        // Rekap Absensi Karyawan
        Route::get('/attendance/recap', [AttendanceController::class, 'recap'])->name('attendance.recap');

    });


});
Route::middleware(['role:super_admin'])->group(function () {
    // ... route lain ...

    // Manajemen Tenant (Client)
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{id}', [TenantController::class, 'show'])->name('tenants.show');

    // Login As (Pakai POST demi keamanan, jangan GET)
    Route::post('/tenants/{id}/impersonate', [TenantController::class, 'impersonate'])->name('tenants.impersonate');
});

require __DIR__.'/auth.php';
