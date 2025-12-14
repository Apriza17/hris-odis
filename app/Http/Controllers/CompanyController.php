<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyController extends Controller
{
    // Tampilkan Halaman Setting
    public function edit()
    {
        // Ambil data company milik user yang login
        $company = Auth::user()->company;
        return view('company.edit', compact('company'));
    }

    // Simpan Perubahan
    public function update(Request $request)
    {
        $company = Auth::user()->company;

        $request->validate([
            'name' => 'required|string|max:255',
            'radius_km' => 'required|numeric|min:10', // Minimal radius 10 meter
            'latitude' => 'required',
            'longitude' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $company->update([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_km' => $request->radius_km,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);

        return redirect()->back()->with('success', 'Pengaturan kantor berhasil diupdate!');
    }
}
