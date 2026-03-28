@props([
    'title' => 'My Website'
])

<!DOCTYPE html>
<html lang="en" data-theme="dim">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body class="bg-base-100 text-base-content flex flex-col min-h-screen">
    
    <x-navbar />
    <x-flash />

    <main class="flex-grow mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 w-full">
        {{ $slot }}
    </main>

    <footer class="footer footer-center p-4 bg-base-300 text-base-content mt-auto">
        <aside>
            <p>Copyright © {{ date('Y') }} - All rights reserved by DevExperiments</p>
        </aside>
    </footer>
  </body>
</html>
