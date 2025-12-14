<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\PayrollComponent;
use App\Models\EmployeeComponent;


class EmployeeController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Query Karyawan:
        // 1. Filter cuma karyawan di Company milik user yang login (Multi-tenancy basic)
        // 2. Load relasi (User, Department, Position) biar query ringan (Eager Loading)
        $employees = Employee::where('company_id', $user->company_id)
            ->with(['user', 'department', 'position'])
            ->latest()
            ->paginate(10); // Paging 10 baris per halaman

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $companyId = Auth::user()->company_id;

        // Ambil data master milik company tersebut saja
        $departments = Department::where('company_id', $companyId)->get();
        $positions = Position::where('company_id', $companyId)->get();

        return view('employees.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Email harus unik
            'department_id' => 'required',
            'position_id' => 'required',
            'join_date' => 'required|date',
        ]);

        // 2. Mulai Transaksi Database
        DB::transaction(function () use ($request) {
            $companyId = Auth::user()->company_id;

            // A. Create User Account
            $user = User::create([
                'company_id' => $companyId,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'), // Default password
                'role' => 'employee', // Role otomatis karyawan
            ]);

            // B. Create Employee Data
            Employee::create([
                'company_id' => $companyId,
                'user_id' => $user->id, // Sambungkan ke user di atas
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'nip' => $request->nip,
                'join_date' => $request->join_date,
                'status' => $request->status,
                'basic_salary' => $request->basic_salary,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_holder' => $request->account_holder,
            ]);

        });

        // 3. Redirect Balik
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }


    public function edit($id)
    {
        // 1. Ambil Data Karyawan & Company ID
        $employee = Employee::with(['user', 'components'])->findOrFail($id);
        $companyId = Auth::user()->company_id;

        // Security Check: Pastikan karyawan milik perusahaan user yang login
        if ($employee->company_id !== $companyId) abort(404);

        // 2. Ambil Master Data (Dept, Position, dan KOMPONEN GAJI)
        $departments = Department::where('company_id', $companyId)->get();
        $positions = Position::where('company_id', $companyId)->get();
        $payrollComponents = PayrollComponent::where('company_id', $companyId)->get();

        return view('employees.edit', compact('employee', 'departments', 'positions', 'payrollComponents'));
    }

    public function update(Request $request, $id)
    {
        // 1. Ambil Data
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        // 2. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id, // Ignore email sendiri
            'basic_salary' => 'required|numeric',
            // Validasi array komponen (opsional, tapi bagus buat security)
            'components' => 'array',
            'components.*' => 'nullable|numeric'
        ]);

        DB::transaction(function () use ($request, $employee, $user) {
            // A. Update Data User (Login)
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // B. Update Data Employee (Jabatan, Gaji Pokok, Bank)
            $employee->update([
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'nip' => $request->nip,
                'join_date' => $request->join_date,
                'status' => $request->status,
                'basic_salary' => $request->basic_salary,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_holder' => $request->account_holder,
            ]);

            // C. UPDATE KOMPONEN GAJI (Jantung Fitur Ini) ❤️
            // Kita loop semua input dari form "components"
            if ($request->has('components')) {
                foreach ($request->components as $componentId => $amount) {
                    // Jika diisi angka (tidak kosong), simpan/update ke database
                    if ($amount !== null) {
                        EmployeeComponent::updateOrCreate(
                            [
                                'employee_id' => $employee->id,
                                'payroll_component_id' => $componentId
                            ],
                            [
                                'amount' => $amount
                            ]
                        );
                    } else {
                        // Kalau dikosongin, hapus datanya (misal tunjangannya dicabut)
                        EmployeeComponent::where('employee_id', $employee->id)
                            ->where('payroll_component_id', $componentId)
                            ->delete();
                    }
                }
            }
        });

        return redirect()->route('employees.index')->with('success', 'Data karyawan & gaji berhasil diperbarui!');
    }
}
