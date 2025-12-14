<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('employees.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                    &larr; Kembali
                </a>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
                    Edit Data: {{ $employee->user->name }}
                </span>
            </div>

            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white border-b pb-4 border-gray-200 dark:border-gray-700">
                        Biodata & Jabatan
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $employee->user->name) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" value="{{ old('email', $employee->user->email) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', $employee->nip) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                                <option value="contract" {{ $employee->status == 'contract' ? 'selected' : '' }}>Kontrak</option>
                                <option value="permanent" {{ $employee->status == 'permanent' ? 'selected' : '' }}>Tetap</option>
                                <option value="internship" {{ $employee->status == 'internship' ? 'selected' : '' }}>Magang</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departemen</label>
                            <select name="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                            <select name="position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}" {{ $employee->position_id == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Masuk</label>
                            <input type="date" name="join_date" value="{{ old('join_date', $employee->join_date) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white border-b pb-4 border-gray-200 dark:border-gray-700 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Setup Gaji & Tunjangan
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2 bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                            <label class="block mb-2 text-lg font-bold text-gray-900 dark:text-white">Gaji Pokok (Basic Salary)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <span class="text-gray-500 font-bold">Rp</span>
                                </div>
                                <input type="number" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}" class="bg-white border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Rekening</label>
                            <input type="text" name="account_number" value="{{ old('account_number', $employee->account_number) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Atas Nama</label>
                            <input type="text" name="account_holder" value="{{ old('account_holder', $employee->account_holder) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div class="md:col-span-2 mt-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-4 border-t pt-4 dark:border-gray-700">Komponen Tambahan (Dinamis)</h3>

                            @if($payrollComponents->isEmpty())
                                <p class="text-sm text-gray-500 italic">Belum ada komponen gaji yang dibuat. Silakan buat di menu Master Data -> Komponen Gaji.</p>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($payrollComponents as $comp)
                                        @php
                                            $existingVal = $employee->components->where('payroll_component_id', $comp->id)->first();
                                            $val = $existingVal ? $existingVal->amount : '';
                                        @endphp

                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border {{ $comp->type == 'allowance' ? 'border-green-200 dark:border-green-900' : 'border-red-200 dark:border-red-900' }}">
                                            <div>
                                                <label class="text-sm font-medium text-gray-900 dark:text-white block">{{ $comp->name }}</label>
                                                <span class="text-xs {{ $comp->type == 'allowance' ? 'text-green-600' : 'text-red-500' }}">
                                                    {{ $comp->type == 'allowance' ? '(+) Tunjangan' : '(-) Potongan' }}
                                                </span>
                                            </div>
                                            <div class="w-1/2">
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 start-0 flex items-center ps-2 pointer-events-none">
                                                        <span class="text-gray-500 text-xs">Rp</span>
                                                    </div>
                                                    <input type="number" name="components[{{ $comp->id }}]" value="{{ $val }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-8 p-1.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 shadow-lg">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
