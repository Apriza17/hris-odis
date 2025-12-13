<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::resource('leaves', LeaveController::class);

    // ROUTE BARU: Approval Cuti (Method PATCH)
    Route::patch('/leaves/{id}/approval', [LeaveController::class, 'approval'])->name('leaves.approval');

    Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');

    // Tombol Sakti Generate
    Route::post('/payrolls/generate', [PayrollController::class, 'generate'])->name('payrolls.generate');

    // Tambahkan di dalam group auth
    Route::get('/payrolls/{id}/slip', [PayrollController::class, 'downloadSlip'])->name('payrolls.download');

});


Route::middleware(['auth', 'verified'])->group(function () {
    // ... route dashboard yang lama biarkan saja ...

    // Route Karyawan
    Route::resource('employees', EmployeeController::class);
});

require __DIR__.'/auth.php';
