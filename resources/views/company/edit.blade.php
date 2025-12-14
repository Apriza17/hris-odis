<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex items-center justify-between mb-6 border-b pb-4 border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                        Pengaturan Perusahaan (SaaS Tenant)
                    </h2>
                </div>

                <form action="{{ route('company.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Perusahaan</label>
                            <input type="text" name="name" value="{{ old('name', $company->name) }}" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                                Resmi</label>
                            <input type="email" name="email" value="{{ old('email', $company->email) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat
                                Kantor</label>
                            <input type="text" name="address" value="{{ old('address', $company->address) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div class="md:col-span-2 mt-4 border-t pt-4 dark:border-gray-700">
                            <h3
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Titik Koordinat Kantor
                            </h3>
                            <p class="text-xs text-gray-500 mb-4">Titik ini akan menjadi pusat radius untuk karyawan
                                melakukan Absensi. Pastikan Anda berada di kantor saat mengatur ini.</p>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Latitude</label>
                            <input type="text" id="lat" name="latitude"
                                value="{{ old('latitude', $company->latitude) }}" required readonly
                                class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-600 dark:border-gray-500">
                        </div>

                        <div>
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Longitude</label>
                            <input type="text" id="long" name="longitude"
                                value="{{ old('longitude', $company->longitude) }}" required readonly
                                class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-600 dark:border-gray-500">
                        </div>

                        <div class="md:col-span-2">
                            <button type="button" onclick="setCurrentLocation()"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18d-6 0-6-6 6-6 6 0 6 6 0 0 1 12 0z"></path>
                                </svg>
                                Set Lokasi Saya Saat Ini Sebagai Titik Kantor
                            </button>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Radius Toleransi
                                Absensi (Meter)</label>
                            <input type="number" name="radius_km" value="{{ old('radius_km', $company->radius_km) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <p class="text-xs text-gray-500 mt-1">Karyawan hanya bisa absen jika berada dalam radius ini
                                (Contoh: 50 meter).</p>
                        </div>

                        <div class="md:col-span-2 mt-4 border-t pt-4 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Jam Kerja</h3>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Masuk
                                (Default)</label>
                            <input type="time" name="time_in" value="{{ old('time_in', $company->time_in) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Pulang
                                (Default)</label>
                            <input type="time" name="time_out" value="{{ old('time_out', $company->time_out) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan Pengaturan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function setCurrentLocation() {
            if (navigator.geolocation) {
                // Ubah text tombol biar interaktif
                const btn = document.querySelector('button[onclick="setCurrentLocation()"]');
                const originalText = btn.innerHTML;
                btn.innerHTML = "Mendeteksi Lokasi...";
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById('lat').value = position.coords.latitude;
                        document.getElementById('long').value = position.coords.longitude;

                        alert("Lokasi berhasil ditemukan! Jangan lupa klik Simpan Pengaturan.");
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    },
                    function(error) {
                        alert("Gagal mengambil lokasi: " + error.message);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }, {
                        enableHighAccuracy: true
                    }
                );
            } else {
                alert("Browser tidak support GPS.");
            }
        }
    </script>
</x-app-layout>
