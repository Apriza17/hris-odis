<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-4 md:space-y-0">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Riwayat Penggajian (Payroll)
                </h2>

                @if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                    <form action="{{ route('payrolls.generate') }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin generate gaji untuk bulan ini? Data yang sudah ada tidak akan didouble.');">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Generate Gaji {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                        </button>
                    </form>
                @endif
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 p-4">

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Periode</th>

                            @if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                                <th scope="col" class="px-6 py-3">Karyawan</th>
                            @endif

                            <th scope="col" class="px-6 py-3">Tanggal Cair</th>
                            <th scope="col" class="px-6 py-3 text-right">Gaji Pokok</th>
                            <th scope="col" class="px-6 py-3 text-right">Tunjangan</th>
                            <th scope="col" class="px-6 py-3 text-right">Potongan</th>
                            <th scope="col" class="px-6 py-3 text-right">Total (Net)</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Slip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $payroll)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                    {{ $payroll->month }} {{ $payroll->year }}
                                </td>

                                @if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-medium text-gray-900 dark:text-white">{{ $payroll->employee->user->name }}</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $payroll->employee->position->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                @endif

                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($payroll->pay_date)->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    {{ number_format($payroll->basic_salary, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right text-green-600">
                                    + {{ number_format($payroll->allowances, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right text-red-600">
                                    - {{ number_format($payroll->deductions, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-blue-600 dark:text-blue-400 text-base">
                                    Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if ($payroll->status == 'paid')
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">LUNAS</span>
                                    @else
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-400">DRAFT</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <button class="text-gray-500 hover:text-blue-600 transition">
                                        <a href="{{ route('payrolls.download', $payroll->id) }}" target="_blank"
                                            class="text-gray-500 hover:text-blue-600 transition"
                                            title="Download Slip PDF">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </a>
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <p>Belum ada data penggajian untuk periode ini.</p>
                                        @if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                                            <p class="text-xs mt-2 text-blue-500">Klik tombol Generate di atas untuk
                                                membuat gaji bulan ini.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $payrolls->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
