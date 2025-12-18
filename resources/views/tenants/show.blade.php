<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-2">
                    &larr; Kembali ke Dashboard CEO
                </a>
                <span
                    class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded border border-indigo-400">
                    Client ID: {{ $company->id }}
                </span>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $company->name }}</h2>
                        <p class="text-gray-500">{{ $company->email }}</p>
                        <p class="text-sm text-gray-400 mt-1">Bergabung sejak:
                            {{ $company->created_at->format('d F Y') }}</p>
                    </div>

                    <div class="mt-4 md:mt-0 flex gap-3">
                        <button
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-medium transition">
                            Edit Data
                        </button>

                        @if ($adminUser)
                            <form action="{{ route('tenants.impersonate', $company->id) }}" method="POST"
                                onsubmit="return confirm('Anda akan login sebagai {{ $adminUser->name }}. Lanjutkan?');">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-bold shadow-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Login Sebagai Admin
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed text-sm">
                                Akun Admin Tidak Ditemukan
                            </button>
                        @endif
                    </div>
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <span class="text-gray-500 text-sm">Kode Perusahaan</span>
                        <p class="font-mono text-lg font-semibold text-gray-800 dark:text-white">
                            {{ $company->code ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Total User</span>
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $company->users->count() }}
                            Orang</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Jam Kerja</span>
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $company->time_in }} -
                            {{ $company->time_out }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Radius Absen</span>
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $company->radius_km }} Meter
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Daftar Pengguna
                    ({{ $company->users->count() }})</h3>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Nama User</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($company->users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
