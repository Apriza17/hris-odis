<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = $user->employee;
        $today = Carbon::today()->format('Y-m-d');

        // Cek apakah hari ini sudah absen?
        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('date', $today)
                                ->first();

        // Kirim data history absensi bulan ini juga
        $history = Attendance::where('employee_id', $employee->id)
                             ->whereMonth('date', Carbon::now()->month)
                             ->orderBy('date', 'desc')
                             ->get();

        return view('attendance.index', compact('attendance', 'history'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();

        // Logic CLOCK IN vs CLOCK OUT
        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('date', $today)
                                ->first();

        if (!$attendance) {
            // === ABSEN MASUK (CLOCK IN) ===
            Attendance::create([
                'company_id' => $user->company_id,
                'employee_id' => $employee->id,
                'date' => $today,
                'time_in' => $now->format('H:i:s'),
                'status' => 'present', // Nanti kita tambah logic "Telat" disini
                // Lokasi nanti kita ambil dari Request (sementara null dulu)
            ]);

            return redirect()->back()->with('success', 'Berhasil Absen Masuk! Semangat kerja 💪');

        } else {
            // === ABSEN PULANG (CLOCK OUT) ===
            $attendance->update([
                'time_out' => $now->format('H:i:s'),
            ]);

            return redirect()->back()->with('success', 'Berhasil Absen Pulang! Hati-hati di jalan 👋');
        }
    }
}
