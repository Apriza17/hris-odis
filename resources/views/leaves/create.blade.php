<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('leaves.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                    &larr; Kembali ke Daftar Cuti
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2
                    class="text-xl font-bold mb-6 text-gray-800 dark:text-white border-b pb-4 border-gray-200 dark:border-gray-700">
                    Form Pengajuan Cuti / Izin
                </h2>

                <form action="{{ route('leaves.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                                Izin</label>
                            <select name="type" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="annual">Cuti Tahunan (Mengurangi Jatah Cuti)</option>
                                <option value="sick">Sakit (Wajib Surat Dokter)</option>
                                <option value="permission">Izin Pribadi / Urusan Keluarga</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mulai
                                Tanggal</label>
                            <input type="date" name="start_date" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sampai
                                Tanggal</label>
                            <input type="date" name="end_date" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan /
                                Keterangan</label>
                            <textarea name="reason" rows="4" required
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Contoh: Mengurus perpanjangan SIM..."></textarea>
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Kirim Pengajuan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
