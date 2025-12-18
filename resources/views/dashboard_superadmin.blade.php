<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Dashboard CEO (SaaS Management) 🦈
                    </h2>
                    <p class="text-gray-500">Kelola pelanggan HRIS Anda di sini.</p>
                </div>
                <a href="{{ route('tenants.create') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none">
                    + Daftarkan Perusahaan Baru
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-indigo-500">
                    <p class="text-gray-500">Total Klien (Perusahaan)</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalCompanies }}</h3>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-pink-500">
                    <p class="text-gray-500">Total User (Semua Database)</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalUsers }}</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Daftar Perusahaan Aktif</h3>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Nama Perusahaan</th>
                                <th class="px-6 py-3">Email Kontak</th>
                                <th class="px-6 py-3">Total Karyawan</th>
                                <th class="px-6 py-3">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                        {{ $company->name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $company->email }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $company->employees_count }} User
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $company->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('tenants.show', $company->id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $companies->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
