<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Master Data Organisasi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">
                        🏢 Departemen / Divisi
                    </h3>

                    <form action="{{ route('departments.store') }}" method="POST" class="flex gap-2 mb-6">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Dept (ex: IT, Finance)" required class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700">
                            + Tambah
                        </button>
                    </form>

                    <ul class="space-y-2">
                        @forelse($departments as $dept)
                            <li class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg group">
                                <span class="text-gray-900 dark:text-white font-medium">{{ $dept->name }}</span>
                                <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('Hapus departemen {{ $dept->name }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada data departemen.</p>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">
                        💼 Jabatan (Positions)
                    </h3>

                    <form action="{{ route('positions.store') }}" method="POST" class="flex gap-2 mb-6">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Jabatan (ex: Manager, Staff)" required class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-500 dark:hover:bg-green-600">
                            + Tambah
                        </button>
                    </form>

                    <ul class="space-y-2">
                        @forelse($positions as $pos)
                            <li class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg group">
                                <span class="text-gray-900 dark:text-white font-medium">{{ $pos->name }}</span>
                                <form action="{{ route('positions.destroy', $pos->id) }}" method="POST" onsubmit="return confirm('Hapus jabatan {{ $pos->name }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada data jabatan.</p>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
