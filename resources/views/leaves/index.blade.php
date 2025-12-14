@php
    $isAdmin = Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin';
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-4 md:space-y-0">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Daftar Cuti & Izin
                </h2>
                <a href="{{ route('leaves.create') }}"
                   class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    + Ajukan Permohonan
                </a>
            </div>

            {{-- Tabel --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 p-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tanggal Pengajuan</th>

                            @if ($isAdmin)
                                <th scope="col" class="px-6 py-3">Nama Karyawan</th>
                            @endif

                            <th scope="col" class="px-6 py-3">Jenis</th>
                            <th scope="col" class="px-6 py-3">Tanggal Cuti</th>
                            <th scope="col" class="px-6 py-3">Lama</th>
                            <th scope="col" class="px-6 py-3">Alasan</th>
                            <th scope="col" class="px-6 py-3">Status</th>

                            @if ($isAdmin)
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                {{-- Tanggal pengajuan --}}
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y') }}
                                </td>

                                {{-- Nama karyawan (admin only) --}}
                                @if ($isAdmin)
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $leave->employee->user->name ?? 'Unknown' }}
                                    </td>
                                @endif

                                {{-- Jenis --}}
                                <td class="px-6 py-4">
                                    @if ($leave->type == 'annual')
                                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            Cuti Tahunan
                                        </span>
                                    @elseif($leave->type == 'sick')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            Sakit
                                        </span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            Izin
                                        </span>
                                    @endif
                                </td>

                                {{-- Tanggal cuti --}}
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                                </td>

                                {{-- Lama --}}
                                <td class="px-6 py-4 font-bold">
                                    {{ $leave->total_days }} Hari
                                </td>

                                {{-- Alasan --}}
                                <td class="px-6 py-4 truncate max-w-xs">
                                    {{ Str::limit($leave->reason, 30) }}
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if ($leave->status == 'approved')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">
                                            Disetujui
                                        </span>
                                    @elseif($leave->status == 'rejected')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi (hanya admin/super_admin) --}}
                                @if ($isAdmin)
                                    <td class="px-6 py-4">
                                        @if ($leave->status == 'pending')
                                            <div class="flex flex-wrap gap-2 justify-end">
                                                <form action="{{ route('leaves.approval', $leave->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit"
                                                        class="text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-xs px-3 py-2">
                                                        Setuju
                                                    </button>
                                                </form>

                                                <form action="{{ route('leaves.approval', $leave->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit"
                                                        class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-3 py-2">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="text-right text-gray-400 text-xs">
                                                Selesai
                                            </div>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 8 : 6 }}" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada riwayat pengajuan cuti.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $leaves->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
