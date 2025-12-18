<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // <--- Tambahkan ini baris paling atas
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    // Form Tambah Klien
    public function create()
    {
        return view('tenants.create');
    }

    // Proses Simpan Klien Baru + Akun Adminnya
    public function store(Request $request)
    {
        $request->validate([
            // Validasi Perusahaan
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies,email',

            // Validasi Akun Admin HRD Perusahaan Tsb
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Perusahaan Baru
            $company = Company::create([
                'name' => $request->company_name,
                'email' => $request->company_email,
                'code' => Str::upper(Str::slug(Str::limit($request->company_name, 5, ''))) . '-' . Str::upper(Str::random(4)),
                'radius_km' => 50, // Default setting
                'time_in' => '09:00:00',
                'time_out' => '17:00:00',
            ]);

            // 2. Buat User Admin untuk Perusahaan tsb
            $user = User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->password),
                'role' => 'admin',       // Role Admin HR
                'company_id' => $company->id, // Link ke perusahaan baru
            ]);

            // 3. Buat Data Employee untuk Admin tsb (biar bisa digaji juga/masuk struktur)
            Employee::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'status' => 'permanent',
                'join_date' => now(),
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Klien baru berhasil didaftarkan! Akun Admin HRD siap digunakan.');
    }
    public function show($id)
    {
        // Ambil data perusahaan beserta user dan karyawannya
        $company = Company::with(['users', 'employees'])->findOrFail($id);

        // Cari User Admin dari perusahaan ini (buat target Login As)
        $adminUser = $company->users()->where('role', 'admin')->first();

        return view('tenants.show', compact('company', 'adminUser'));
    }
    // Method SAKTI: Login Sebagai Klien (Impersonate)
    public function impersonate($id)
    {
        // 1. Cari user Admin milik perusahaan tersebut
        // Asumsi: Kita login sebagai Admin Utamanya (bukan staff biasa)
        $targetUser = User::where('company_id', $id)
                          ->where('role', 'admin')
                          ->firstOrFail();

        // 2. Lakukan Login Paksa (Magic happens here ✨)
        Auth::login($targetUser);

        // 3. Redirect ke Dashboard seolah-olah kita adalah mereka
        return redirect()->route('dashboard')->with('success', "Berhasil masuk sebagai Admin: {$targetUser->name}. Mode Penyamaran Aktif! 🕵️‍♂️");
    }
}
