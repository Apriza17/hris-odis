<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b pb-4 dark:border-gray-700">
                    Registrasi Klien Baru (Perusahaan)
                </h2>

                <form action="{{ route('tenants.store') }}" method="POST">
                    @csrf

                    <h3 class="text-sm font-semibold text-blue-600 uppercase mb-3">Data Perusahaan</h3>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                            Perusahaan</label>
                        <input type="text" name="company_name" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                            placeholder="PT Mencari Cinta Sejati">
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Resmi
                            Perusahaan</label>
                        <input type="email" name="company_email" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                            placeholder="info@company.com">
                    </div>

                    <h3 class="text-sm font-semibold text-green-600 uppercase mb-3 border-t pt-4 dark:border-gray-700">
                        Akun Admin HRD Pertama</h3>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Admin
                            HR</label>
                        <input type="text" name="admin_name" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                            placeholder="Nama Admin">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Login
                            Admin</label>
                        <input type="email" name="admin_email" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                            placeholder="hrd@company.com">
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                            Login</label>
                        <input type="password" name="password" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                            placeholder="Password aman">
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                        🚀 Daftarkan Klien
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
