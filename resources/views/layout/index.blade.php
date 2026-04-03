<!DOCTYPE html>
<html>
    <head>
        <title>Betive POS - @yield('title',config('app.name','Laravel'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ Vite::asset('resources/img/headers-icon.png') }}">
        {{-- Font --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
        
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.tailwindcss.css"/>
        
    </head>
    <body class="bg-gray-100">
        {{-- Navbar --}}
        <nav class="ps-7 py-5 flex items-center justify-start gap-4">
            <button class="bg-white rounded-full px-4 py-4 cursor-pointer open-sidebar"><i class="fa-solid fa-bars text-2xl text-gray-500"></i></button>
            @yield('navbar')
        </nav>
        <div class="container-body">
            @yield('container')
        </div>        
        {{-- Sidebar Modal --}}
        @include('layout.sidebar')

    </body>
</html>