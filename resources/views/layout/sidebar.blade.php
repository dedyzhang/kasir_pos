<div class="w-[300px] hidden bg-white shadow-md fixed top-0 left-0 h-full sidebar z-99">
    <div class="sidebar-container flex flex-wrap items-stretch align-content-between h-full">
        <div class="profile-place w-full">
            <div class="profile-place shadow-[5px_0_10px_#E8E9EB] p-4 flex gap-3 items-center relative">
                <div class="profile w-full p-2 bg-gray-100 rounded-full flex items-center gap-4 cursor-pointer hover:bg-gray-200 transition-all duration-200 btn-toggle-profile-dropdown select-none">
                    <img src="{{ $account->profile_picture != null ? Vite::asset($account->profile_picture) : Vite::asset('resources/img/avatar/boy_1.png') }}" class="rounded-full w-10 h-10 object-cover border border-white shrink-0" />
                    <div class="profile-info overflow-hidden flex-grow">
                        <h3 class="font-bold text-base leading-tight truncate">{{$account->name}}</h3>
                        <p class="text-sm text-gray-500 leading-tight">{{ $account->role }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs mr-3 transition-transform duration-300 icon-profile-chevron shrink-0"></i>
                </div>
                <div class="close-sidebar">
                    <button class="bg-red-100 hover:bg-red-400 group rounded-full p-5 cursor-pointer"><i class="fa-solid fa-xmark text-xl text-gray-500 group-hover:text-white"></i></button>
                </div>

                <!-- Profile Dropdown Menu Premium -->
                <div id="profile-dropdown" class="hidden absolute top-[90%] left-4 right-4 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 py-2 mt-1 transform origin-top transition-all duration-200 scale-95 opacity-0">
                    <a href="#" class="px-4 py-3 hover:bg-brand-soft hover:text-brand flex items-center gap-3 text-gray-700 font-semibold text-sm transition-all duration-200 btn-open-change-password group">
                        <div class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-brand-soft text-gray-500 group-hover:text-brand flex items-center justify-center transition-all duration-200"><i class="fas fa-key text-xs"></i></div>
                        Ganti Password
                    </a>
                </div>
            </div>
        </div>
        <ul class="d-block list-none p-0 m-0 h-auto w-full">
            <li class="p-3 group hover:bg-brand-soft w-full inline-flex items-center gap-6 cursor-pointer btn-open-attendance">
                <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-brand"><i class="fas fa-clock-rotate-left text-lg group-hover:text-white"></i></div>
                <span class="group-hover:text-fg-brand-strong text-lg/loose font-medium text-gray-700">Absensi Staf</span>
            </li>
            <li class="p-3 group hover:bg-brand-soft w-full inline-flex items-center gap-6 cursor-pointer">
                <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-brand"><i class="fas fa-home text-lg group-hover:text-white"></i></div> <a href="{{ route('auth.index') }}" class="group-hover:text-fg-brand-strong text-lg/loose">Point Of Sales</a></li>
            @can('admin')
                <li class="p-3 group hover:bg-brand-soft w-full inline-flex items-center gap-6 cursor-pointer">
                <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-brand"><i class="fas fa-apple-whole text-lg group-hover:text-white"></i></div> <a href="{{ route('products.index') }}" class="group-hover:text-fg-brand-strong text-lg/loose">Products</a></li>
            @endcan
            
            <li class="p-3 group hover:bg-brand-soft w-full inline-flex items-center gap-6 cursor-pointer">
                <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-brand"><i class="fas fa-arrow-trend-up text-lg group-hover:text-white"></i></div> <a href="{{ route('activity.index') }}" class="group-hover:text-fg-brand-strong text-lg/loose">Activity</a></li>
            @can('admin')
                <li class="p-3 group hover:bg-brand-soft w-full inline-flex items-center gap-6 cursor-pointer">
                <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-brand"><i class="fas fa-clipboard-user text-lg group-hover:text-white"></i></div> <a href="{{ route('attendance.recap') }}" class="group-hover:text-fg-brand-strong text-lg/loose">Rekap Absensi</a></li>
                <li class="p-3 group hover:bg-brand-soft w-full inline-flex items-center gap-6 cursor-pointer">
                <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-brand"><i class="fas fa-user text-lg group-hover:text-white"></i></div> <a href="{{ route('users.index') }}" class="group-hover:text-fg-brand-strong text-lg/loose">Users</a></li>
                <li class="p-3 group hover:bg-brand-soft w-full inline-flex items-center gap-6 cursor-pointer">
                <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 group-hover:bg-brand"><i class="fas fa-gear text-lg group-hover:text-white"></i></div> <a href="{{ route('settings.index') }}" class="group-hover:text-fg-brand-strong text-lg/loose">Settings</a></li>
            @endcan
            
        </ul>
        <div class="logout-button w-full relative">
            <div class="button-place absolute bottom-0 left-0 px-2 py-4 w-full shadow-[-5px_0_10px_#E8E9EB] bg-white">
                <button class="w-full group hover:bg-red-200 bg-gray-100 flex justify-between items-center align-content-center rounded-full ps-7 pe-2 py-2 cursor-pointer logout-button-place">
                    <b>Logout</b> <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-red-400 group-hover:bg-white group-hover:text-red-400 text-white group-hover:bg-blue-500"><i class="fas fa-sign-out text-lg"></i></div>
                </button>
            </div>
        </div>
        <script type="module">
            // Toggle Profile Dropdown
            $(document).on('click', '.btn-toggle-profile-dropdown', function(e) {
                e.stopPropagation();
                const dropdown = $('#profile-dropdown');
                const chevron = $('.icon-profile-chevron');
                
                if (dropdown.hasClass('hidden')) {
                    dropdown.removeClass('hidden');
                    setTimeout(() => {
                        dropdown.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                        chevron.addClass('rotate-180');
                    }, 10);
                } else {
                    hideProfileDropdown();
                }
            });

            // Hide Profile Dropdown Helper
            function hideProfileDropdown() {
                const dropdown = $('#profile-dropdown');
                const chevron = $('.icon-profile-chevron');
                if (!dropdown.hasClass('hidden')) {
                    dropdown.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                    chevron.removeClass('rotate-180');
                    setTimeout(() => {
                        dropdown.addClass('hidden');
                    }, 200);
                }
            }

            // Close Dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.btn-toggle-profile-dropdown, #profile-dropdown').length) {
                    hideProfileDropdown();
                }
            });

            // Close dropdown when action clicked
            $(document).on('click', '.btn-open-change-password', function() {
                hideProfileDropdown();
            });

            $('.logout-button-place').on('click', function() {
                cConfirm("Perhatian","Confirm To Logout?",function() {
                    loading();
                    $.ajax({
                        type: "post",
                        url : "{{ route('auth.logout') }}",
                        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        success: function(data) {
                            if(data.success === true) {
                                removeLoading();
                                cAlert("green","Success",data.message,true);
                                setTimeout(() => {
                                    window.location.href = "/";
                                }, 1500);
                            }
                        },
                        error: function(data) {
                            console.log(data.responseJSON.message);
                        }
                    });
                });
            });
        </script>
    </div>
</div>