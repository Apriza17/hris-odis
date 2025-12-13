<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    // Halaman List Cuti (Buat Karyawan & HR)
    public function index()
    {
        $user = Auth::user();

        // Kalau HR/Admin, lihat semua pengajuan (buat diapprove)
        // Kalau Karyawan biasa, cuma lihat punya sendiri
        $query = Leave::with('employee.user')->where('company_id', $user->company_id);

        if ($user->role === 'employee') {
            $query->where('employee_id', $user->employee->id);
        }

        $leaves = $query->latest()->paginate(10);

        return view('leaves.index', compact('leaves'));
    }

    // Halaman Form Pengajuan
    public function create()
    {
        return view('leaves.create');
    }

    // Proses Simpan Pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Hitung selisih hari
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $totalDays = $start->diffInDays($end) + 1; // +1 karena tanggal mulai dihitung

        Leave::create([
            'company_id' => $user->company_id,
            'employee_id' => $user->employee->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Pengajuan cuti berhasil dikirim! Menunggu persetujuan.');
    }

    // ... method store dan lainnya ...

    public function approval(Request $request, $id)
    {
        // 1. Cek User adalah Admin/HR (Security)
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak punya akses menyetujui cuti.');
        }

        // 2. Cari Data Cuti
        $leave = Leave::findOrFail($id);

        // 3. Validasi Input (Hanya boleh 'approved' atau 'rejected')
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        // 4. Update Status
        $leave->update([
            'status' => $request->status,
            // Kalau ditolak, kita bisa simpan alasannya (optional, ambil dari input form kalau ada)
            'rejection_note' => $request->rejection_note ?? null,
        ]);

        // 5. Kurangi Jatah Cuti (Logic Tambahan - Nanti dikembangkan)
        // Kalau 'approved' dan tipe 'annual', harusnya kurangi saldo cuti user.
        // Untuk sekarang kita update status aja dulu.

        return redirect()->back()->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }
}
