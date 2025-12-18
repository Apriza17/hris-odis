<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">

                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </h3>

                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-8 tracking-widest"
                            id="realtime-clock">
                            --:--:--
                        </div>

                        <form action="{{ route('attendance.store') }}" id="attendance-form" method="POST">
                            @csrf

                            <input type="hidden" name="latitude" id="lat">
                            <input type="hidden" name="longitude" id="long">

                            @if (!$attendance)
                                <button type="button" onclick="getLocation()"
                                    class="w-48 h-48 mx-auto rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex flex-col items-center justify-center gap-2 border-4 border-blue-200 dark:border-blue-900">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    CLOCK IN
                                    <span class="text-xs font-normal opacity-80">Absen Masuk</span>
                                </button>
                            @elseif(!$attendance->time_out)
                                <div class="mb-4">
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        Masuk: {{ $attendance->time_in }}
                                    </span>
                                </div>
                                <button type="button" onclick="getLocation()"
                                    class="w-48 h-48 mx-auto rounded-full bg-red-600 hover:bg-red-700 text-white font-bold text-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex flex-col items-center justify-center gap-2 border-4 border-red-200 dark:border-red-900">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    CLOCK OUT
                                    <span class="text-xs font-normal opacity-80">Absen Pulang</span>
                                </button>
                            @else
                                <div
                                    class="flex flex-col items-center justify-center h-48 bg-gray-50 dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    <svg class="w-12 h-12 text-green-500 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h4 class="text-lg font-bold text-gray-800 dark:text-white">Good Job!</h4>
                                    <p class="text-sm text-gray-500">Kamu sudah absen pulang hari ini.</p>
                                    <div class="mt-2 text-xs text-gray-400">
                                        Masuk: {{ $attendance->time_in }} <br>
                                        Pulang: {{ $attendance->time_out }}
                                    </div>
                                </div>
                            @endif

                        </form>
                        @if (session('error'))
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <span class="font-medium">Gagal Absen!</span> {{ session('error') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                                role="alert">
                                <span class="font-bold">Perhatian:</span> {{ session('warning') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Riwayat Kehadiran Bulan Ini
                        </h3>

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Tanggal</th>
                                        <th scope="col" class="px-6 py-3">Jam Masuk</th>
                                        <th scope="col" class="px-6 py-3">Jam Pulang</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($history as $item)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-green-600 font-semibold">
                                                {{ $item->time_in }}
                                            </td>
                                            <td class="px-6 py-4 text-red-600 font-semibold">
                                                {{ $item->time_out ?? '--:--' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($item->status == 'present')
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Hadir</span>
                                                @elseif($item->status == 'late')
                                                    <span
                                                        class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Telat</span>
                                                @else
                                                    <span
                                                        class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center">Belum ada data absensi
                                                bulan ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour12: false
            });
            document.getElementById('realtime-clock').textContent = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock(); // Run immediately

        function getLocation() {
            if (navigator.geolocation) {
                // Tampilkan loading (Optional: bisa ubah text tombol jadi "Locating...")

                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            // Debugging: Munculkan koordinat yang didapat browser
            alert("Posisi Terdeteksi:\nLat: " + position.coords.latitude + "\nLong: " + position.coords.longitude);

            // 1. Isi input hidden dengan koordinat
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('long').value = position.coords.longitude;

            // 2. Submit form secara otomatis
            document.getElementById('attendance-form').submit();
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("Wajib izinkan akses Lokasi (GPS) untuk absen!");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Info lokasi tidak tersedia.");
                    break;
                case error.TIMEOUT:
                    alert("Gagal mengambil lokasi (Timeout). Coba lagi.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("Terjadi kesalahan sistem GPS.");
                    break;
            }
        }
    </script>
</x-app-layout>
