<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Orca HRIS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
     <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
     <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">

    @include('layouts.navigation')

    @include('layouts.sidebar')


        {{-- Alert global di pojok kanan atas --}}
        @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 2000)"
                class="fixed top-4 right-4 z-50 max-w-sm"
            >
                <div
                    x-show="show"
                    x-transition:enter="transform ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-5"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transform ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-5"
                    class="space-y-3"
                >
                    @if (session('success'))
                        <div class="rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 flex items-start gap-2 shadow-lg">
                            <svg class="w-5 h-5 mt-0.5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold">Success</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 flex items-start gap-2 shadow-lg">
                            <svg class="w-5 h-5 mt-0.5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z" />
                            </svg>
                            <div>
                                <p class="font-semibold">Error</p>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    <div class="p-4 sm:ml-64 pt-20">
        {{ $slot }}
    </div>

</body>

</html>
