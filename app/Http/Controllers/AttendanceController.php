<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
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
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $user = Auth::user();
        $company = $user->company; // Ambil settingan kantor

        // 1. Cek Apakah Kantor Punya Koordinat?
        if ($company->latitude && $company->longitude) {

            // Rumus Haversine (Hitung Jarak dalam Meter)
            $earthRadius = 6371000; // Radius bumi dalam meter

            $latFrom = deg2rad($company->latitude);
            $lonFrom = deg2rad($company->longitude);
            $latTo = deg2rad($request->latitude);
            $lonTo = deg2rad($request->longitude);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

            $distance = $angle * $earthRadius; // Hasil dalam Meter

            // 2. Validasi Jarak
            if ($distance > $company->radius_km) {
                return redirect()->back()->with('error', 'Posisi Anda Terlalu Jauh dari Kantor! Jarak: ' . number_format($distance) . ' meter.');
            }
        }
        $employee = $user->employee;
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();

        // Logic CLOCK IN vs CLOCK OUT
        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('date', $today)
                                ->first();

        if (!$attendance) {
        // === ABSEN MASUK (CLOCK IN) ===

        // A. Tentukan Status (Hadir / Telat)
        $scheduleTime = Carbon::createFromFormat('H:i:s', $company->time_in); // Misal 09:00:00
        $arrivalTime = Carbon::now();

        // Default status hadir
        $status = 'present';
        $note = null;

        // Ambil jam pulang kantor (misal 17:00:00)
        $limitTime = Carbon::createFromFormat('H:i:s', $company->time_out);

        // Kalau jam sekarang LEBIH DARI jam pulang kantor...
        if ($now->gt($limitTime)) {
            return redirect()->back()->with('error', 'Gagal Absen! Jam kerja sudah berakhir. Anda dianggap Tidak Hadir (Alpha).');
        }

        // Logic: Kalau jam datang LEBIH DARI jam jadwal -> TELAT
        // Kita kasih toleransi 1 menit biar gak sadis-sadis amat
        if ($arrivalTime->gt($scheduleTime->addMinute())) {
            $status = 'late';

            // Hitung telat berapa menit (Opsional, buat info)
            $lateMinutes = $arrivalTime->diffInMinutes($scheduleTime);
            $note = 'Terlambat ' . $lateMinutes . ' menit';
        }

        Attendance::create([
            'company_id' => $user->company_id,
            'employee_id' => $employee->id,
            'date' => $today,
            'time_in' => $now->format('H:i:s'),
            'status' => $status, // <--- Pakai variabel dinamis ini
            'note' => $note,     // <--- Simpan catatan telatnya
            'lat_in' => $request->latitude,
            'long_in' => $request->longitude,
        ]);

        // Ubah pesan notifikasi biar lebih informatif
        if ($status == 'late') {
            return redirect()->back()->with('warning', 'Absen Masuk Berhasil, tapi Anda Terlambat! 😅');
        } else {
            return redirect()->back()->with('success', 'Absen Masuk Berhasil! Tepat Waktu. 🔥');
        }
        } else {
            // === ABSEN KELUAR (CLOCK OUT) ===
            // Cek sudah absen keluar atau belum
            if ($attendance->time_out) {
                return redirect()->back()->with('info', 'Anda Sudah Absen Keluar Hari Ini.');
            }

            $attendance->update([
                'time_out' => $now->format('H:i:s'),
                'lat_out' => $request->latitude,
                'long_out' => $request->longitude,
            ]);

            return redirect()->back()->with('success', 'Absen Keluar Berhasil! Sampai Jumpa Besok. 👋');
        }
    }

    public function recap(Request $request)
    {
        // Hanya Admin/HR yang boleh akses
        if (Auth::user()->role === 'employee') abort(403);

        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $companyId = Auth::user()->company_id;

        // 1. Ambil Semua Karyawan Aktif
        $employees = Employee::with('user', 'department')
            ->where('company_id', $companyId)
            ->where('status', '!=', 'internship') // Opsional: exclude magang kalau mau
            ->orderBy('id') // Atau order by nama
            ->paginate(10);

        // 2. Ambil Data Absensi pada tanggal tersebut
        $attendances = Attendance::where('company_id', $companyId)
            ->where('date', $date)
            ->get()
            ->keyBy('employee_id'); // Biar gampang dicocokin nanti

        // 3. Statistik Ringkas
        $stats = [
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'alpha' => $employees->count() - $attendances->count() // Sisanya berarti bolos/cuti
        ];

        return view('attendance.recap', compact('employees', 'attendances', 'date', 'stats'));
    }
}
