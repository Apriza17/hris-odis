<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OrcaHRIS - Modern HR Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-white dark:bg-gray-900">

    <nav
        class="fixed w-full z-50 top-0 start-0 border-b border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span
                    class="self-center text-2xl font-extrabold whitespace-nowrap text-blue-700 dark:text-white">Orca<span
                        class="text-gray-800 dark:text-blue-500">HRIS</span></span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/30">
                        Masuk (Login)
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="bg-white dark:bg-gray-900 pt-32 pb-20 lg:pt-40 lg:pb-28">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">

            <a href="#"
                class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700"
                role="alert">
                <span class="text-xs bg-blue-600 rounded-full text-white px-4 py-1.5 mr-3">Baru</span> <span
                    class="text-sm font-medium">Fitur "Login As Client" untuk Support Lebih Cepat!</span>
                <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>

            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                Kelola Karyawan Tanpa Drama. <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">Efisien,
                    Akurat, Real-time.</span>
            </h1>

            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                OrcaHRIS membantu perusahaan mengelola Absensi GPS, Payroll Otomatis, dan Manajemen Cuti dalam satu
                platform cloud yang aman. Fokus pada bisnis Anda, biarkan kami mengurus administrasinya.
            </p>

            <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Ke Dashboard
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 shadow-lg shadow-blue-500/50">
                        Login Karyawan / Admin
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="mailto:rey@orcadigitalsolution.com"
                        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Hubungi Sales (CEO)
                    </a>
                @endauth
            </div>

            <div
                class="relative mx-auto border-gray-800 dark:border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[300px] md:h-[450px] w-full max-w-[800px] shadow-2xl flex items-center justify-center overflow-hidden">
                <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[178px] rounded-l-lg"></div>
                <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
                <div class="rounded-[2rem] overflow-hidden w-full h-full bg-white dark:bg-gray-800">
                    <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-700 text-gray-400">
                        <span class="text-center">
                            <img src="img/dashboard.png" alt="Dashboard Preview">
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="bg-gray-50 dark:bg-gray-800 py-20">
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <div class="max-w-screen-md mb-8 lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Fitur Unggulan
                </h2>
                <p class="text-gray-500 sm:text-xl dark:text-gray-400">Semua yang Anda butuhkan untuk mengelola SDM,
                    tersedia dalam satu aplikasi terintegrasi.</p>
            </div>
            <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">

                <div>
                    <div
                        class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-blue-100 lg:h-12 lg:w-12 dark:bg-blue-900">
                        <svg class="w-5 h-5 text-blue-600 lg:w-6 lg:h-6 dark:text-blue-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold dark:text-white">Absensi GPS Geolocation</h3>
                    <p class="text-gray-500 dark:text-gray-400">Pastikan karyawan absen di lokasi yang tepat. Anti-fake
                        GPS dengan validasi radius kantor.</p>
                </div>

                <div>
                    <div
                        class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12 dark:bg-green-900">
                        <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6 dark:text-green-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold dark:text-white">Payroll Otomatis</h3>
                    <p class="text-gray-500 dark:text-gray-400">Hitung gaji pokok, tunjangan, dan potongan telat dalam
                        sekali klik. Slip gaji siap cetak.</p>
                </div>

                <div>
                    <div
                        class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-purple-100 lg:h-12 lg:w-12 dark:bg-purple-900">
                        <svg class="w-5 h-5 text-purple-600 lg:w-6 lg:h-6 dark:text-purple-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold dark:text-white">Multi-Tenant SaaS</h3>
                    <p class="text-gray-500 dark:text-gray-400">Satu aplikasi untuk banyak perusahaan. Data aman
                        terpisah antar tenant (perusahaan).</p>
                </div>

            </div>
        </div>
    </section>

    <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-900 border-t dark:border-gray-800">
        <div class="mx-auto max-w-screen-xl text-center">
            <a href="#"
                class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                Orca<span class="text-blue-600">HRIS</span>
            </a>
            <p class="my-6 text-gray-500 dark:text-gray-400">Sistem Informasi SDM karya Anak Bangsa. Dibuat dengan ❤️
                menggunakan Laravel.</p>
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="#"
                    class="hover:underline">OrcaTech™</a>. All Rights Reserved.</span>
        </div>
    </footer>

</body>

</html>
