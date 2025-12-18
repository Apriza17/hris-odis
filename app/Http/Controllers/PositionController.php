<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Position::create([
            'company_id' => Auth::user()->company_id,
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Position::where('id', $id)->where('company_id', Auth::user()->company_id)->delete();
        return redirect()->back()->with('success', 'Jabatan dihapus.');
    }
}
