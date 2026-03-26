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
    {{-- <link rel="stylesheet" href="./style.css"> --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body class="bg-gray-900 text-white">
    <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <nav class="mb-8">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/contact">Contact</a></li>
            <li><a href="/ideas">Ideas</a></li>
            <li><a href="/register">Register</a></li>
            <li><a href="/login">Login</a></li>
            @if(auth()->check())
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white hover:text-gray-300">Logout</button>
            </form>
            @endif
        </ul>
    </nav>

     {{ $slot }}
    </main>
    <script src="index.js"></script>
  </body>
</html>
