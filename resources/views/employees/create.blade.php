<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('employees.index') }}"
                    class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                    &larr; Kembali ke Data Karyawan
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2
                    class="text-xl font-bold mb-6 text-gray-800 dark:text-white border-b pb-4 border-gray-200 dark:border-gray-700">
                    Form Input Karyawan Baru
                </h2>

                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Akun Login
                            </h3>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Lengkap</label>
                            <input type="text" name="name" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                                Login</label>
                            <input type="email" name="email" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                                Default</label>
                            <input type="text" name="password" value="password123" readonly
                                class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-400 cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-500">Password default adalah <b>password123</b>. User bisa
                                menggantinya nanti.</p>
                        </div>

                        <div class="md:col-span-2 mt-4 border-t pt-4 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Data
                                Kepegawaian</h3>
                        </div>

                        <div class="md:col-span-2 mt-4 border-t pt-4 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Informasi Gaji & Rekening</h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gaji Pokok (Basic Salary)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                </div>
                                <input type="number" name="basic_salary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: 5000000">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Bank</label>
                            <select name="bank_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Pilih Bank</option>
                                <option value="BCA">BCA</option>
                                <option value="MANDIRI">Mandiri</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Rekening</label>
                            <input type="text" name="account_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pemilik Rekening (Atas Nama)</label>
                            <input type="text" name="account_holder" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Sesuai buku tabungan">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP (Nomor
                                Induk)</label>
                            <input type="text" name="nip"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Masuk
                                (Join Date)</label>
                            <input type="date" name="join_date" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departemen</label>
                            <select name="department_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Pilih Departemen</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <select name="position_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($positions as $pos)
                                    <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                                Karyawan</label>
                            <select name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="contract">Kontrak (PKWT)</option>
                                <option value="permanent">Tetap (PKWTT)</option>
                                <option value="internship">Magang</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan Data Karyawan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
