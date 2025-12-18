<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - OrcaHRIS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-white dark:bg-gray-900">

    <div class="min-h-screen flex">

        <div
            class="hidden lg:flex w-1/2 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 relative justify-center items-center overflow-hidden">

            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#FFFFFF"
                        d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,81.6,-46.6C91.4,-34.1,98.1,-19.2,95.8,-4.9C93.5,9.3,82.2,22.9,71.3,35.1C60.4,47.3,49.9,58.1,37.6,65.8C25.3,73.5,11.2,78.1,-1.9,81.4C-15,84.7,-28.1,86.7,-40.3,81.3C-52.5,75.9,-63.8,63.1,-72.6,49.2C-81.4,35.3,-87.7,20.3,-86.3,6.2C-84.9,-7.9,-75.8,-21.1,-65.7,-32.3C-55.6,-43.5,-44.5,-52.7,-32.5,-61.1C-20.5,-69.5,-7.6,-77.1,3.8,-83.7L15.3,-90.3"
                        transform="translate(100 100)" />
                </svg>
            </div>

            <div class="relative z-10 p-12 text-white max-w-lg">
                <div class="mb-6">
                    <span
                        class="bg-blue-500/30 border border-blue-400/50 text-blue-100 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                        Human Resource Information System
                    </span>
                </div>
                <h1 class="text-5xl font-bold mb-6 leading-tight">
                    Manage People,<br>Not Paper.
                </h1>
                <p class="text-blue-100 text-lg mb-8 leading-relaxed">
                    Sistem manajemen SDM modern untuk perusahaan yang ingin bergerak lebih cepat. Absensi, Payroll, dan
                    Cuti dalam satu genggaman.
                </p>

                <div
                    class="flex items-center gap-4 mt-12 bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/10">
                    <div
                        class="w-12 h-12 rounded-full bg-yellow-400 flex items-center justify-center text-xl font-bold text-yellow-900">
                        HR
                    </div>
                    <div>
                        <p class="text-sm italic">"Pekerjaan saya jadi 10x lebih mudah sejak pakai Orca."</p>
                        <p class="text-xs font-bold mt-1 text-blue-200">- Happy HR Manager</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-white dark:bg-gray-900">

            <div class="w-full max-w-md">

                <div class="lg:hidden mb-8 text-center">
                    <h2 class="text-3xl font-bold text-blue-700 dark:text-white">OrcaHRIS</h2>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Selamat Datang Kembali! 👋</h2>
                    <p class="text-gray-500 dark:text-gray-400">Masukkan akun Anda untuk mengakses dashboard.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                            Perusahaan</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="nama@perusahaan.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password"
                                class="block text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm text-blue-600 hover:underline dark:text-blue-500">Lupa password?</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center mb-6">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="remember_me" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ingat
                            Saya</label>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition shadow-lg shadow-blue-500/30">
                        Masuk ke Dashboard &rarr;
                    </button>

                    <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum punya akun perusahaan? <a href="#"
                            class="font-medium text-blue-600 hover:underline dark:text-blue-500">Hubungi Account Manager Orca</a>
                    </p>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} OrcaHRIS SaaS. All rights reserved.</p>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
