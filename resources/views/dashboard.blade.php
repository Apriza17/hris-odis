<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Halo, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-gray-500 dark:text-gray-400">Berikut ringkasan aktivitas perusahaan hari ini.</p>
            </div>
            @if(Auth::user()->role === 'employee')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-t-4 {{ $todayAttendance ? 'border-green-500' : 'border-gray-400' }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Status Hari Ini</p>
                                @if($todayAttendance)
                                    <h3 class="text-2xl font-bold text-green-600">SUDAH HADIR</h3>
                                    <p class="text-xs text-gray-500 mt-1">Masuk: {{ $todayAttendance->time_in }}</p>
                                    @if($todayAttendance->time_out)
                                        <p class="text-xs text-gray-500">Pulang: {{ $todayAttendance->time_out }}</p>
                                    @else
                                        <p class="text-xs text-blue-500 font-semibold animate-pulse">Sedang Bekerja...</p>
                                    @endif
                                @else
                                    <h3 class="text-2xl font-bold text-gray-400">BELUM ABSEN</h3>
                                    <p class="text-xs text-gray-500 mt-1">Jangan lupa clock-in ya!</p>
                                @endif
                            </div>
                            <div class="p-3 {{ $todayAttendance ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }} rounded-full">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        @if(!$todayAttendance || !$todayAttendance->time_out)
                        <div class="mt-4">
                            <a href="{{ route('attendance.index') }}" class="block w-full text-center py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                                {{ !$todayAttendance ? 'Absen Masuk Sekarang' : 'Absen Pulang' }}
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-t-4 border-blue-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Sisa Cuti Tahunan</p>
                                <h3 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $leaveBalance }} <span class="text-sm font-normal text-gray-500">Hari</span></h3>
                                <p class="text-xs text-gray-400 mt-1">Dari total 12 hari/tahun</p>
                            </div>
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('leaves.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ajukan Cuti &rarr;</a>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-t-4 border-purple-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Gaji Terakhir ({{ $lastPayslip ? $lastPayslip->month : '-' }})</p>
                                @if($lastPayslip)
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($lastPayslip->net_salary, 0, ',', '.') }}</h3>
                                    <p class="text-xs text-green-500 mt-1 font-semibold">Sudah Cair</p>
                                @else
                                    <h3 class="text-xl font-bold text-gray-400">Belum Ada</h3>
                                @endif
                            </div>
                            <div class="p-3 bg-purple-100 text-purple-600 rounded-full">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                        @if($lastPayslip)
                            <div class="mt-4">
                                <a href="{{ route('payrolls.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Lihat Slip Gaji &rarr;</a>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Aktivitas Terakhir Saya</h3>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Masuk</th>
                                    <th scope="col" class="px-6 py-3">Pulang</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentHistory as $log)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">{{ $log->time_in }}</td>
                                    <td class="px-6 py-4">{{ $log->time_out ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($log->status == 'late')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Telat</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Hadir</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Belum ada aktivitas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


            @else

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Karyawan</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalEmployees ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Hadir Hari Ini</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $presentCount ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Permohonan Izin</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $pendingLeaves ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Estimasi Gaji Pokok</p>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Rp {{ number_format(($totalBasicSalary ?? 0) / 1000000, 1, ',', '.') }} Jt</h3>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Terlambat Hari Ini
                    </h3>

                    @if(isset($lateEmployees) && count($lateEmployees) > 0)
                        <ul class="space-y-3">
                            @foreach($lateEmployees as $attendance)
                                <li class="flex items-center justify-between border-b pb-2 dark:border-gray-700 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($attendance->employee->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $attendance->employee->user->name }}</p>
                                            <p class="text-xs text-gray-500">Masuk: {{ $attendance->time_in }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-red-500 font-semibold bg-red-50 px-2 py-1 rounded">
                                        Telat
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <svg class="w-12 h-12 text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-gray-500">Mantap! Tidak ada yang terlambat hari ini.</p>
                        </div>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Akses Cepat</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('employees.create') }}" class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-600 transition group border border-gray-200 dark:border-gray-600">
                            <div class="text-blue-600 dark:text-blue-400 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600">Tambah Karyawan</h4>
                        </a>

                        <a href="{{ route('attendance.index') }}" class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 transition group border border-gray-200 dark:border-gray-600">
                            <div class="text-green-600 dark:text-green-400 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-green-600">Absen Sekarang</h4>
                        </a>

                        <a href="{{ route('payrolls.index') }}" class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-purple-50 dark:hover:bg-gray-600 transition group border border-gray-200 dark:border-gray-600">
                            <div class="text-purple-600 dark:text-purple-400 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-600">Payroll</h4>
                        </a>

                        <a href="{{ route('leaves.index') }}" class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-yellow-50 dark:hover:bg-gray-600 transition group border border-gray-200 dark:border-gray-600">
                            <div class="text-yellow-600 dark:text-yellow-400 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600">Cek Cuti</h4>
                        </a>
                    </div>
                </div>

            </div>
            @endif

        </div>
    </div>
</x-app-layout>
