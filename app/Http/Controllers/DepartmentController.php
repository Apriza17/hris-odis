<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        // Kita ambil dua-duanya buat ditampilkan di satu halaman
        $departments = Department::where('company_id', $companyId)->latest()->get();
        $positions = Position::where('company_id', $companyId)->latest()->get();

        return view('departments.index', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Department::create([
            'company_id' => Auth::user()->company_id,
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Department::where('id', $id)->where('company_id', Auth::user()->company_id)->delete();
        return redirect()->back()->with('success', 'Departemen dihapus.');
    }
}
