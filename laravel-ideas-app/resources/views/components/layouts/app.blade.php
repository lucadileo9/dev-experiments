<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Laravel Ideas App' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 flex flex-col min-h-screen">
        <x-navbar />
        
        <main class="flex-grow container mx-auto px-4 py-8">
            {{ $slot }}
        </main>

        <x-footer />
    </body>
</html>