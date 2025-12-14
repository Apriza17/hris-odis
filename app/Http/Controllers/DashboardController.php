<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $today = Carbon::today()->format('Y-m-d');
        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->year;

        // === KHUSUS SUPER ADMIN (CEO ORCA) ===
        // Kalau super admin, kembalikan view khusus (nanti bisa dikembangkan).
        // Untuk user selain super_admin, lanjutkan dan tampilkan data perusahaan.
        if ($user->role === 'employee') {
            $employeeId = $user->employee->id;

            // 1. Status Absen Hari Ini
            $todayAttendance = Attendance::where('employee_id', $employeeId)
                                ->where('date', $today)
                                ->first();

            // 2. Hitung Sisa Cuti (Asumsi Jatah 12 Hari - Cuti Terpakai)
            $totalLeaveEntitlement = 12;
            $usedLeave = Leave::where('employee_id', $employeeId)
                            ->where('status', 'approved')
                            ->whereYear('start_date', $currentYear)
                            ->sum('total_days');
            $leaveBalance = $totalLeaveEntitlement - $usedLeave;

            // 3. Riwayat Absen 5 Terakhir
            $recentHistory = Attendance::where('employee_id', $employeeId)
                            ->orderBy('date', 'desc')
                            ->limit(5)
                            ->get();

            // 4. Slip Gaji Terakhir
            $lastPayslip = Payroll::where('employee_id', $employeeId)
                            ->latest()
                            ->first();

            return view('dashboard', compact('todayAttendance', 'leaveBalance', 'recentHistory', 'lastPayslip'));
        }

        // === KHUSUS HRD & KARYAWAN ===

        // 1. Total Karyawan
        $totalEmployees = Employee::where('company_id', $companyId)->count();

        // 2. Yang Hadir Hari Ini
        $presentCount = Attendance::where('company_id', $companyId)
            ->where('date', $today)
            ->whereIn('status', ['present', 'late']) // Hadir & Telat dihitung masuk
            ->count();

        // 3. Izin Menunggu Persetujuan
        $pendingLeaves = Leave::where('company_id', $companyId)
            ->where('status', 'pending')
            ->count();

        // 4. Estimasi Gaji Bulan Ini (Berdasarkan Gaji Pokok Active Employees)
        // (Ini hitungan kasar buat forecast pengeluaran)
        $totalBasicSalary = Employee::where('company_id', $companyId)
            ->sum('basic_salary');

        // 5. Daftar Karyawan Terlambat Hari Ini (Buat dimarahin HRD hehe)
        $lateEmployees = Attendance::with('employee.user')
            ->where('company_id', $companyId)
            ->where('date', $today)
            ->where('status', 'late')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'presentCount',
            'pendingLeaves',
            'totalBasicSalary',
            'lateEmployees'
        ));
    }
}
