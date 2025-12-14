<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class PayrollController extends Controller
{
    // Halaman List Gaji (History)
    public function index()
    {
        $user = Auth::user();

        // Kalau Admin: Lihat semua history gaji perushaan
        // Kalau Karyawan: Cuma lihat slip gaji punya sendiri
        $query = Payroll::with('employee.user')
            ->where('company_id', $user->company_id);

        if ($user->role === 'employee') {
            $query->where('employee_id', $user->employee->id);
        }

        $payrolls = $query->latest()->paginate(10);

        return view('payrolls.index', compact('payrolls'));
    }

    // Logic SAKTI: Generate Gaji Bulan Ini
    public function generate(Request $request)
    {
        // Hanya Admin/HR yang boleh
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        $companyId = Auth::user()->company_id;
        $currentMonth = Carbon::now()->format('F'); // "December"
        $currentYear = Carbon::now()->year;         // 2025

        DB::transaction(function () use ($companyId, $currentMonth, $currentYear) {
            // 1. Ambil semua karyawan aktif
            $employees = Employee::where('company_id', $companyId)
                                 ->where('status', '!=', 'internship') // Magang biasanya beda, kita skip dulu
                                 ->get();

            foreach ($employees as $emp) {
                // 2. Cek apakah sudah digaji bulan ini?
                $exists = Payroll::where('employee_id', $emp->id)
                                 ->where('month', $currentMonth)
                                 ->where('year', $currentYear)
                                 ->exists();

                if ($exists) continue; // Skip kalau sudah ada

               // === LOGIC BARU: HITUNG OTOMATIS ===

                // 1. Gaji Pokok
                $basic = $emp->basic_salary;

                // 2. Hitung Total Tunjangan (Allowance)
                $allowance = $emp->components
                    ->where('component.type', 'allowance')
                    ->sum('amount');

                // 3. Hitung Total Potongan (Deduction)
                $deduction = $emp->components
                    ->where('component.type', 'deduction')
                    ->sum('amount');

                // 4. Hitung Bersih
                $net = $basic + $allowance - $deduction;

                // Simpan
                Payroll::create([
                    'company_id' => $companyId,
                    'employee_id' => $emp->id,
                    'month' => $currentMonth,
                    'year' => $currentYear,
                    'pay_date' => Carbon::now(),
                    'basic_salary' => $basic,
                    'allowances' => $allowance, // Otomatis terisi 700rb (500+200)
                    'deductions' => $deduction, // Otomatis terisi 100rb
                    'net_salary' => $net,
                    'status' => 'paid'
                ]);
            }
        });

        return redirect()->back()->with('success', 'Payroll berhasil digenerate dengan kalkulasi otomatis!');
    }

    // Tambahkan use di paling atas


// ... di dalam class PayrollController ...

public function downloadSlip($id)
{
    // 1. Cari Data Payroll
    $payroll = Payroll::with(['employee.user', 'employee.position', 'employee.department', 'company'])
        ->findOrFail($id);

    // 2. Cek Otorisasi (Penting!)
    // Karyawan cuma boleh download punya sendiri
    $user = Auth::user();
    if ($user->role === 'employee' && $payroll->employee_id !== $user->employee->id) {
        abort(403, 'Bukan slip gaji Anda!');
    }

    // 3. Load View PDF (Kita buat habis ini)
    $pdf = Pdf::loadView('payrolls.pdf', compact('payroll'));

    // 4. Download file
    return $pdf->download('Slip_Gaji_'.$payroll->month.'_'.$payroll->year.'.pdf');
}
}
