<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Super Admin (Kamu - Owner Orca)
        // Dia gak punya company_id (NULL) karena dia yang punya sistem
        User::create([
            'name' => 'CEO Orca',
            'email' => 'rey@orcadigitalsolution.com',
            'password' => Hash::make('87654321'),
            'role' => 'super_admin',
        ]);

        // 2. Buat Company Klien Pertama (Simulasi)
        $company = Company::create([
            'name' => 'PT Maju Mundur Kena',
            'email' => 'info@majumundur.com',
            'code' => 'MMK01',
        ]);

        // 3. Buat Master Data Jabatan & Departemen buat PT itu
        $deptIT = Department::create(['company_id' => $company->id, 'name' => 'Information Technology']);
        $deptHR = Department::create(['company_id' => $company->id, 'name' => 'Human Resource']);

        $posMgr = Position::create(['company_id' => $company->id, 'name' => 'Manager']);
        $posStaff = Position::create(['company_id' => $company->id, 'name' => 'Staff']);

        // 4. Buat Akun HRD Klien (Admin PT tersebut)
        $hrUser = User::create([
            'company_id' => $company->id,
            'name' => 'Ibu HRD Galak',
            'email' => 'hr@klien.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Link User HRD ke tabel Employee juga (opsional, biasanya HR juga karyawan)
        Employee::create([
            'company_id' => $company->id,
            'user_id' => $hrUser->id,
            'department_id' => $deptHR->id,
            'position_id' => $posMgr->id,
            'nip' => 'K001',
            'join_date' => now(),
        ]);

        // 5. Buat 1 Akun Karyawan Biasa (Korban Uji Coba)
        $empUser = User::create([
            'company_id' => $company->id,
            'name' => 'Budi Santoso',
            'email' => 'budi@klien.com',
            'password' => Hash::make('12345678'),
            'role' => 'employee',
        ]);

        Employee::create([
            'company_id' => $company->id,
            'user_id' => $empUser->id,
            'department_id' => $deptIT->id,
            'position_id' => $posStaff->id,
            'nip' => 'K002',
            'join_date' => now(),
        ]);
    }
}
