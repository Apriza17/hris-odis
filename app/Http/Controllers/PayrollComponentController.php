<?php

namespace App\Http\Controllers;

use App\Models\PayrollComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollComponentController extends Controller
{
    // List Komponen
    public function index()
    {
        $components = PayrollComponent::where('company_id', Auth::user()->company_id)
            ->latest()
            ->get();

        return view('payroll-components.index', compact('components'));
    }

    // Simpan Komponen Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction', // Harus Tunjangan atau Potongan
        ]);

        PayrollComponent::create([
            'company_id' => Auth::user()->company_id,
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Komponen gaji berhasil ditambahkan!');
    }

    // Hapus Komponen
    public function destroy($id)
    {
        $component = PayrollComponent::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $component->delete();

        return redirect()->back()->with('success', 'Komponen berhasil dihapus.');
    }
}
