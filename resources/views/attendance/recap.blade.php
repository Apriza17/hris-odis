<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Rekapitulasi Harian
                </h2>

                <form action="{{ route('attendance.recap') }}" method="GET" class="flex items-center gap-2">
                    <input type="date" name="date" value="{{ $date }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none transition">
                        Filter
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div
                    class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-green-500 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Tepat Waktu</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['present'] }}</h3>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Orang</span>
                </div>
                <div
                    class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-yellow-400 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Terlambat</p>
                        <h3 class="text-2xl font-bold text-yellow-600">{{ $stats['late'] }}</h3>
                    </div>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Orang</span>
                </div>
                <div
                    class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-red-500 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Tidak Hadir (Alpha)</p>
                        <h3 class="text-2xl font-bold text-red-600">{{ $stats['alpha'] }}</h3>
                    </div>
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Orang</span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Karyawan</th>
                                <th scope="col" class="px-6 py-3">Jam Masuk</th>
                                <th scope="col" class="px-6 py-3">Jam Pulang</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $emp)
                                @php
                                    $log = $attendances[$emp->id] ?? null;
                                @endphp
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-medium text-gray-900 dark:text-white">{{ $emp->user->name }}</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $emp->department->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($log)
                                            <span
                                                class="{{ $log->status == 'late' ? 'text-red-600 font-bold' : 'text-gray-900 dark:text-white' }}">
                                                {{ $log->time_in }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $log->time_out ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if ($log)
                                            @if ($log->status == 'present')
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">HADIR</span>
                                            @elseif($log->status == 'late')
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400">TERLAMBAT</span>
                                            @endif
                                        @else
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-400 animate-pulse">
                                                ❌ ALPHA
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-xs text-gray-500 italic">
                                        {{ $log->note ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $employees->withQueryString()->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
