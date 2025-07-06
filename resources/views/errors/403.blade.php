<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-300">
        {{-- Navbar --}}
        @livewire('components.navbar')

        <!-- Page Content -->
        <main class="container mx-auto w-full">
            <div class="min-h-screen sm:py-3 xl:py-6">
                <div class="w-full rounded">
                    <div class="h-auto w-full p-6 sm:p-3">
                        <div class="rounded-md p-6 bg-red-50">
                            <h3 class="text-orange-500 text-4xl font-semibold">Oops! You don't have permission to view
                                this page.</h3>
                            <p class="text-gray-600 mt-2">
                                It looks like you're trying to access a page that requires special permissions.
                                You might not have the necessary role to view this content.
                            </p>
                            <p class="text-gray-600 mt-2">
                                If you believe this is an error, please contact the system administrator or try logging
                                in with a user account that has the proper access rights.
                            </p>

                            <div class="mt-6">
                                <span class="mx-2">|</span>
                                <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">
                                    Go to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @livewireScripts
</body>

</html>

