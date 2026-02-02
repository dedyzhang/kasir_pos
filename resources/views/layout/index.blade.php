<!DOCTYPE html>
<html>
    <head>
        <title>Betive POS - @yield('title',config('app.name','Laravel'))</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ Vite::asset('resources/img/headers-icon.png') }}">
    </head>
    <body class="bg-gray-100">
        <nav class="px-7 py-5 flex items-center justify-start gap-4">
            <button class="bg-white rounded-full px-2 py-3 cursor-pointer open-sidebar"><i class="fa-solid fa-bars text-2xl text-gray-500"></i></button>
        </nav>
        <div class="w-[300px] hidden bg-white shadow-md fixed top-0 left-0 h-full sidebar z-99">
            <div class="sidebar-container flex flex-wrap items-stretch align-content-between h-full">
                <div class="profile-place w-full">
                    <div class="profile-place shadow-[5px_0_10px_#E8E9EB] p-4 flex gap-3 items-center">
                        <div class="profile w-full p-2 bg-gray-100 rounded-full flex items-center gap-5">
                            <img src="{{ Vite::asset('resources/img/avatar/boy_1.png') }}" class="rounded-full w-10 h-10" />
                            <div class="profile-info">
                                <h3 class="font-bold text-base">John Doe</h3>
                                <p class="text-sm text-gray-500">Cashier</p>
                            </div>
                        </div>
                        <div class="close-sidebar">
                            <button class="bg-red-100 hover:bg-red-400 group rounded-full p-5 cursor-pointer"><i class="fa-solid fa-xmark text-xl text-gray-500 group-hover:text-white"></i></button>
                        </div>
                    </div>
                </div>
                <ul class="d-block list-none p-0 m-0 h-auto w-full">
                    <li class="p-3 group hover:bg-blue-100 w-full inline-flex items-center gap-6 cursor-pointer">
                        <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-blue-500"><i class="fas fa-home text-lg group-hover:text-white"></i></div> <a href="#" class="group-hover:text-blue-500 text-lg/loose">Point Of Sales</a></li>
                    <li class="p-3 group hover:bg-blue-100 w-full inline-flex items-center gap-6 cursor-pointer">
                        <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-blue-500"><i class="fas fa-arrow-trend-up text-lg group-hover:text-white"></i></div> <a href="#" class="group-hover:text-blue-500 text-lg/loose">Activity</a></li>
                </ul>
                <div class="logout-button w-full relative">
                    <div class="button-place absolute bottom-0 left-0 px-2 py-4 w-full shadow-[-5px_0_10px_#E8E9EB] bg-white">
                       <button class="w-full group hover:bg-red-200 bg-gray-100 flex justify-between items-center align-content-center rounded-full ps-7 pe-2 py-2 cursor-pointer">
                            <b>Logout</b> <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-red-400 group-hover:bg-white group-hover:text-red-400 text-white group-hover:bg-blue-500"><i class="fas fa-sign-out text-lg"></i></div>
                       </button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>