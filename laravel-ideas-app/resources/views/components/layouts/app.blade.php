@props([
    'title' => 'My Website'
])

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    
    <!-- Imposta il tema prima del render per evitare sfarfallii -->
    <script>
        const savedTheme = localStorage.getItem('theme') || 'dim';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body class="bg-base-100 text-base-content flex flex-col min-h-screen">
    
    <x-layouts.navbar />
    <x-ui.flash />

    <main class="flex-grow mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 w-full">
        {{ $slot }}
    </main>

    <x-layouts.footer />

    <!-- Script per gestire il salvataggio dei temi -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeControllers = document.querySelectorAll('.theme-controller');
            const currentTheme = localStorage.getItem('theme') || 'dim';
            
            themeControllers.forEach(controller => {
                if (controller.value === currentTheme) {
                    controller.checked = true;
                }
                
                controller.addEventListener('change', (e) => {
                    const newTheme = e.target.value;
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            });
        });
    </script>
  </body>
</html>
