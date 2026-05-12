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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="border-t border-gray-200 bg-white">
                <div class="max-w-7xl mx-auto px-4 py-6 text-sm text-gray-500 sm:px-6 lg:px-8">
                    Created by
                    <a href="https://github.com/hanfx11" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 font-semibold text-gray-800 underline decoration-gray-300 underline-offset-4 hover:text-indigo-700 hover:decoration-indigo-500">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.021c0 4.428 2.865 8.184 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.867-.014-1.702-2.782.605-3.369-1.343-3.369-1.343-.455-1.158-1.11-1.466-1.11-1.466-.908-.621.069-.608.069-.608 1.004.071 1.532 1.033 1.532 1.033.892 1.531 2.341 1.089 2.91.833.091-.647.349-1.089.635-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.094.39-1.988 1.03-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.56 9.56 0 0 1 12 6.871a9.56 9.56 0 0 1 2.504.337c1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.641.7 1.029 1.594 1.029 2.688 0 3.848-2.338 4.695-4.566 4.944.359.31.678.92.678 1.855 0 1.339-.012 2.419-.012 2.748 0 .267.18.578.688.48C19.138 20.202 22 16.448 22 12.021 22 6.484 17.523 2 12 2Z" clip-rule="evenodd" />
                        </svg>
                        Hanif
                    </a>
                </div>
            </footer>
        </div>
    </body>
</html>
