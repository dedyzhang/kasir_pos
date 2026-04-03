<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ Vite::asset('resources/img/headers-icon.png') }}">
</head>
<body>
    <div class="flex h-[700px] w-full">
        <div class="w-full hidden md:inline-block">
            <img class="h-full w-[100%] " src="{{ Vite::asset('resources/img/login/login-image.jpg') }}" alt="leftSideImage">
        </div>

        <div class="w-full flex flex-col items-center justify-center">

            <form class="md:w-96 w-80 flex flex-col items-center" method="POST" action="{{ route('auth.login') }}">
                @csrf
                <h2 class="text-4xl text-gray-900 font-medium">Sign in</h2>
                <p class="text-sm text-gray-500/90 mt-3">Welcome back! Please sign in to continue</p>

                <div class="flex items-center gap-4 w-full my-5">
                    <div class="w-full h-px bg-gray-300/90"></div>
                    <p class="w-full text-nowrap text-sm text-gray-500/90">sign in Dengan Username</p>
                    <div class="w-full h-px bg-gray-300/90"></div>
                </div>
                @if (session('error'))
                    <div class="flex items-start sm:items-center p-4 mb-4 text-sm text-fg-danger-strong rounded-base bg-danger-soft" role="alert">
                        <svg class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        <p><span class="font-medium me-1">Perhatian!</span> Username dan Password Salah.</p>
                    </div>
                @endif
                <div class="flex items-center w-full @error('username') border border-red-500 @else bg-transparent border border-gray-300/60 @enderror h-12 rounded-full overflow-hidden pl-6 gap-3">
                    <svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 .55.571 0H15.43l.57.55v9.9l-.571.55H.57L0 10.45zm1.143 1.138V9.9h13.714V1.69l-6.503 4.8h-.697zM13.749 1.1H2.25L8 5.356z" fill="@error('username') #F54927 @else #6B7280 @endif"/>
                    </svg>
                    <input type="username" name="username" placeholder="Username ID" class="bg-transparent @error('username') text-red-700 placeholder-red-300 @else text-gray-500/80 placeholder-gray-500/80 @enderror border-0 text-sm w-full h-full outline-none focus:outline-none focus:border-0" value="{{ old('username') }}">           
                </div>
                @error('username')
                    <div class="flex items-center justify-start w-full mt-1 ps-3 gap-2">
                        <p class="text-sm text-left text-red-400 p-0 m-0">Username Wajib Diisi</p>
                    </div>
                @enderror      

                <div class="flex items-center mt-6 w-full @error('password') border border-red-500 @else bg-transparent border border-gray-300/60 @enderror  h-12 rounded-full overflow-hidden pl-6 gap-3">
                    <svg width="13" height="17" viewBox="0 0 13 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 8.5c0-.938-.729-1.7-1.625-1.7h-.812V4.25C10.563 1.907 8.74 0 6.5 0S2.438 1.907 2.438 4.25V6.8h-.813C.729 6.8 0 7.562 0 8.5v6.8c0 .938.729 1.7 1.625 1.7h9.75c.896 0 1.625-.762 1.625-1.7zM4.063 4.25c0-1.406 1.093-2.55 2.437-2.55s2.438 1.144 2.438 2.55V6.8H4.061z" fill="@error('password') #F54927 @else #6B7280 @endif"/>
                    </svg>
                    <input type="password" placeholder="Password" class="bg-transparent @error('password') text-red-700 placeholder-red-300 @else text-gray-500/80 placeholder-gray-500/80 @enderror border-0 text-sm w-full h-full outline-none focus:outline-none focus:border-0" name="password">
                </div>
                @error('password')
                    <div class="flex items-center justify-start w-full mt-1 ps-3 gap-2">
                        <p class="text-sm text-left text-red-400 p-0 m-0">Password Wajib Diisi</p>
                    </div>
                @enderror   

                <div class="w-full flex items-center justify-between mt-8 text-gray-500/80">
                    <div class="flex items-center gap-2">
                        <input class="h-5" type="checkbox" id="checkbox" name="remember">
                        <label class="text-sm" for="checkbox">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="mt-8 w-full h-11 rounded-full text-white bg-indigo-500 hover:opacity-90 transition-opacity">
                    Masuk Ke Aplikasi
                </button>
            </form>
        </div>
    </div>
</body>
</html>