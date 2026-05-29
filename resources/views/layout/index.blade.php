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
        {{-- Sidebar Modal --}}
        @include('layout.sidebar')

        {{-- Modal Absensi Staf Premium --}}
        <div id="modal-attendance" tabindex="-1" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-100 border border-gray-100 flex flex-col max-h-[90vh]">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 rounded-t shrink-0 border-b border-gray-100 bg-white">
                    <h3 class="text-lg font-bold text-gray-800">
                        Absensi Harian
                    </h3>
                    <div class="button-place flex gap-1">
                        <button type="button" class="text-sm w-9 h-9 ms-auto bg-danger-subtle text-danger rounded-full hover:bg-red-300 cursor-pointer outline-0 inline-flex justify-center items-center close-attendance-modal border-none">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>

                <!-- Body Modal (Scrollable) -->
                <div class="p-5 overflow-y-auto flex-grow max-h-[50vh] md:max-h-[55vh]">
                    <!-- Real-time Clock and Date Card -->
                    <div class="bg-gradient-to-r from-brand to-indigo-600 p-4 rounded-2xl text-white text-center shadow-md mb-4 flex-shrink-0">
                        <p class="text-[10px] uppercase tracking-widest text-blue-100 font-semibold opacity-90 mb-0.5">Waktu Sekarang</p>
                        <h2 id="attendance-clock" class="text-2xl font-extrabold tracking-tight drop-shadow-sm my-0.5 font-mono">00:00:00</h2>
                        <p id="attendance-date" class="text-[10px] font-medium opacity-90"></p>
                    </div>

                    <!-- Profil Karyawan Card -->
                    <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-2xl mb-4 border border-gray-100">
                        <img id="attendance-user-avatar" src="" class="rounded-full w-12 h-12 object-cover border-2 border-brand/20 shadow-md animate-pulse" alt="Avatar" />
                        <div>
                            <h3 id="attendance-user-name" class="font-bold text-gray-800 text-base leading-tight">Nama Karyawan</h3>
                            <span id="attendance-user-role" class="inline-block mt-0.5 px-2.5 py-0.5 bg-brand-soft text-fg-brand-strong text-[10px] font-semibold rounded-full uppercase tracking-wider">ROLE</span>
                        </div>
                    </div>

                    <!-- Panel Kamera Absensi Premium -->
                    <div id="attendance-photo-panel" class="mb-4 hidden transition-all duration-300">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2" id="attendance-photo-title">Ambil Foto Bukti Kehadiran</h4>
                        
                        <div class="relative w-full h-60 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 flex items-center justify-center shadow-inner group">
                            <!-- Live Video Feed -->
                            <video id="attendance-video" class="w-full h-full object-cover hidden" autoplay playsinline></video>
                            
                            <!-- Static Preview Image (after capture) -->
                            <img id="attendance-photo-preview" class="w-full h-full object-cover hidden" alt="Pratinjau Foto" />
                            
                            <!-- Placeholder -->
                            <div id="attendance-photo-placeholder" class="text-center p-4">
                                <div class="w-10 h-10 rounded-full bg-brand-soft text-brand flex items-center justify-center text-lg mx-auto mb-2 animate-bounce">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <p class="text-xs font-semibold text-gray-500">Menginisialisasi kamera...</p>
                                <p class="text-[10px] text-gray-400 mt-1">Harap berikan izin akses kamera jika diminta</p>
                            </div>

                            <!-- Overlay control when video streaming is active -->
                            <div id="attendance-video-overlay" class="absolute bottom-3 left-0 right-0 flex justify-center gap-2 hidden">
                                <button type="button" id="btn-snap-photo" class="px-4 py-2 bg-brand hover:bg-brand-strong text-white text-xs font-bold rounded-xl shadow-lg transition-all cursor-pointer flex items-center gap-1 border-none outline-none">
                                    <i class="fa-solid fa-camera"></i> Jepret Foto
                                </button>
                            </div>

                            <!-- Overlay control when preview is active -->
                            <div id="attendance-preview-overlay" class="absolute top-3 right-3 hidden">
                                <button type="button" id="btn-retake-photo" class="w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-lg transition-all cursor-pointer border-none outline-none" title="Ulangi Foto">
                                    <i class="fa-solid fa-rotate-left text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Canvas for resizing and compression (always hidden) -->
                        <canvas id="attendance-canvas" class="hidden"></canvas>
                    </div>

                    <!-- Status Absensi Timeline Card -->
                    <div class="space-y-3 mb-2">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Status Kehadiran Hari Ini</h4>
                        
                        <!-- Clock In Card -->
                        <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 bg-white transition-all hover:shadow-sm" id="card-clock-in">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-base">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-semibold uppercase">Clock In (Masuk)</p>
                                    <p id="txt-clock-in-time" class="text-xs font-bold text-gray-700 mt-0.5">Belum Tercatat</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="thumb-clock-in" class="hidden">
                                    <img src="" class="w-8 h-8 object-cover rounded-lg border border-gray-200 cursor-pointer hover:scale-105 transition-all view-attendance-photo shadow-sm" alt="Bukti Foto Masuk" />
                                </div>
                                <span id="badge-clock-in" class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-500">Belum Absen</span>
                            </div>
                        </div>

                        <!-- Clock Out Card -->
                        <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 bg-white transition-all hover:shadow-sm" id="card-clock-out">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-base">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-semibold uppercase">Clock Out (Pulang)</p>
                                    <p id="txt-clock-out-time" class="text-xs font-bold text-gray-700 mt-0.5">Belum Tercatat</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="thumb-clock-out" class="hidden">
                                    <img src="" class="w-8 h-8 object-cover rounded-lg border border-gray-200 cursor-pointer hover:scale-105 transition-all view-attendance-photo shadow-sm" alt="Bukti Foto Pulang" />
                                </div>
                                <span id="badge-clock-out" class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-500">Belum Absen</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer (Fixed Action Buttons) -->
                <div class="p-4 border-t border-gray-100 bg-gray-50 flex-shrink-0 rounded-b-3xl">
                    <div id="attendance-action-container">
                        <!-- Dinamis diisi lewat JS -->
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Fullscreen Attendance Image Viewer Overlay -->
        <div id="attendance-image-viewer" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/85 backdrop-blur-md transition-opacity duration-300 opacity-0">
            <div class="relative max-w-md w-full p-4 flex flex-col items-center">
                <button type="button" class="absolute top-4 right-4 bg-white/20 hover:bg-white/40 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer border-none outline-none close-image-viewer animate-pulse">
                    <i class="fas fa-times text-base"></i>
                </button>
                <img id="viewer-photo" class="max-w-full max-h-[70vh] rounded-2xl object-contain shadow-2xl border border-white/10" src="" alt="Bukti Kehadiran Full" />
                <p id="viewer-caption" class="text-white text-sm font-semibold mt-4 text-center px-4 py-2 bg-black/40 rounded-full backdrop-blur-sm"></p>
            </div>
        </div>

        {{-- Modal Ganti Password Premium --}}
        <div id="modal-change-password" tabindex="-1" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-100 border border-gray-100 flex flex-col max-h-[90vh]">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 rounded-t shrink-0 border-b border-gray-100 bg-white">
                    <h3 class="text-lg font-bold text-gray-800">
                        Ganti Password
                    </h3>
                    <div class="button-place flex gap-1">
                        <button type="button" class="text-sm w-9 h-9 ms-auto bg-danger-subtle text-danger rounded-full hover:bg-red-300 cursor-pointer outline-0 inline-flex justify-center items-center close-change-password-modal border-none">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>

                <!-- Body Modal -->
                <form id="form-change-password" class="m-0">
                    <div class="p-5 space-y-4 overflow-y-auto max-h-[60vh]">
                        <!-- Password Saat Ini -->
                        <div>
                            <label for="current_password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-all pr-10" placeholder="Masukkan password saat ini" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand btn-toggle-password" data-target="current_password">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label for="new_password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Baru (Minimal 6 karakter)</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-all pr-10" placeholder="Masukkan password baru" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand btn-toggle-password" data-target="new_password">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-all pr-10" placeholder="Ulangi password baru" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand btn-toggle-password" data-target="new_password_confirmation">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Modal -->
                    <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-2 shrink-0">
                        <button type="button" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-2xl transition-all cursor-pointer close-change-password-modal border-none outline-none">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-brand hover:bg-brand-strong text-white text-sm font-semibold rounded-2xl shadow-md transition-all cursor-pointer border-none outline-none">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script type="module">
            $(document).ready(function() {
                let attendanceStream = null;
                let capturedPhotoBase64 = null;

                // Initialize digital clock & date immediately
                function updateClock() {
                    if (window.moment) {
                        $('#attendance-clock').text(moment().format('HH:mm:ss'));
                        $('#attendance-date').text(moment().format('dddd, DD MMMM YYYY'));
                    } else {
                        const now = new Date();
                        $('#attendance-clock').text(now.toTimeString().split(' ')[0]);
                        $('#attendance-date').text(now.toDateString());
                    }
                }
                updateClock();
                setInterval(updateClock, 1000);

                // Setup Flowbite Modal
                let attendanceModal = null;
                const attendanceModalEl = document.getElementById('modal-attendance');
                if (attendanceModalEl && window.Modal) {
                    attendanceModal = new window.Modal(attendanceModalEl, {
                        placement: 'center',
                        backdrop: 'dynamic',
                        backdropClasses: 'bg-gray-900/60 backdrop-blur-sm fixed inset-0 z-40',
                        closable: true,
                        onHide: function() {
                            stopCamera();
                        }
                    });
                }

                let changePasswordModal = null;
                const changePasswordModalEl = document.getElementById('modal-change-password');
                if (changePasswordModalEl && window.Modal) {
                    changePasswordModal = new window.Modal(changePasswordModalEl, {
                        placement: 'center',
                        backdrop: 'dynamic',
                        backdropClasses: 'bg-gray-900/60 backdrop-blur-sm fixed inset-0 z-40',
                        closable: true,
                        onHide: function() {
                            // Reset form on hide
                            $('#form-change-password')[0].reset();
                            // Reset password visibility icon and type
                            $('#form-change-password input').attr('type', 'password');
                            $('.btn-toggle-password i').removeClass('fa-eye-slash').addClass('fa-eye');
                        }
                    });
                }

                // Handle Sidebar "Absensi Staf" Click
                $(document).on('click', '.btn-open-attendance', function(e) {
                    e.preventDefault();
                    // Close sidebar
                    $('.sidebar').addClass('hidden');
                    
                    // Reset photo state
                    capturedPhotoBase64 = null;
                    
                    // Fetch attendance info
                    loadAttendanceStatus();
                });

                // Handle Sidebar "Ganti Password" Click
                $(document).on('click', '.btn-open-change-password', function(e) {
                    e.preventDefault();
                    // Close sidebar
                    $('.sidebar').addClass('hidden');
                    
                    // Open change password modal
                    if (changePasswordModal) changePasswordModal.show();
                });

                // Handle Modal Close Click
                $(document).on('click', '.close-attendance-modal', function() {
                    if (attendanceModal) attendanceModal.hide();
                });

                $(document).on('click', '.close-change-password-modal', function() {
                    if (changePasswordModal) changePasswordModal.hide();
                });

                // Toggle Password Visibility
                $(document).on('click', '.btn-toggle-password', function() {
                    const targetId = $(this).data('target');
                    const input = $('#' + targetId);
                    const icon = $(this).find('i');
                    
                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        input.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });

                // AJAX Submit Ganti Password
                $('#form-change-password').on('submit', function(e) {
                    e.preventDefault();
                    
                    const currentPassword = $('#current_password').val();
                    const newPassword = $('#new_password').val();
                    const confirmPassword = $('#new_password_confirmation').val();

                    if (newPassword.length < 6) {
                        oAlert("red", "Gagal", "Password baru minimal 6 karakter.");
                        return;
                    }

                    if (newPassword !== confirmPassword) {
                        oAlert("red", "Gagal", "Konfirmasi password baru tidak cocok.");
                        return;
                    }

                    loading();
                    
                    $.ajax({
                        type: "POST",
                        url: "{{ route('users.change-password') }}",
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        data: {
                            current_password: currentPassword,
                            new_password: newPassword,
                            new_password_confirmation: confirmPassword
                        },
                        success: function(response) {
                            removeLoading();
                            if (response.success) {
                                if (changePasswordModal) changePasswordModal.hide();
                                oAlert("green", "Sukses", response.message);
                            } else {
                                oAlert("red", "Gagal", response.message || "Gagal mengubah password.");
                            }
                        },
                        error: function(xhr) {
                            removeLoading();
                            let msg = "Terjadi kesalahan server saat mengganti password.";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errors = xhr.responseJSON.errors;
                                const firstKey = Object.keys(errors)[0];
                                msg = errors[firstKey][0];
                            }
                            oAlert("red", "Gagal", msg);
                        }
                    });
                });

                // AJAX Load Status Absensi
                function loadAttendanceStatus() {
                    loading();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('attendance.today') }}",
                        success: function(response) {
                            removeLoading();
                            if (response.success) {
                                renderAttendanceModal(response);
                                if (attendanceModal) attendanceModal.show();
                            } else {
                                oAlert("red", "Kesalahan", "Gagal memuat data absensi.");
                            }
                        },
                        error: function(xhr) {
                            removeLoading();
                            console.error(xhr);
                            oAlert("red", "Kesalahan", "Terjadi kesalahan server saat memuat data absensi.");
                        }
                    });
                }

                // Render Modal UI dynamically
                function renderAttendanceModal(data) {
                    const user = data.user;
                    const attendance = data.attendance;
                    const status = data.status;

                    // 1. User Info
                    $('#attendance-user-name').text(user.name);
                    $('#attendance-user-role').text(user.role);
                    $('#attendance-user-avatar').attr('src', user.profile_picture).removeClass('animate-pulse');

                    // 2. Clear panels
                    $('#attendance-photo-panel').addClass('hidden');

                    // 3. Attendance Status Card
                    if (status === 'belum_absen') {
                        // Clock In
                        $('#txt-clock-in-time').text('Belum Tercatat').removeClass('text-emerald-600').addClass('text-gray-700');
                        $('#badge-clock-in').text('Belum Absen').removeClass('bg-emerald-100 text-emerald-700').addClass('bg-gray-100 text-gray-500');
                        $('#card-clock-in').removeClass('border-emerald-200 bg-emerald-50/10').addClass('border-gray-100 bg-white');
                        $('#thumb-clock-in').addClass('hidden');

                        // Clock Out
                        $('#txt-clock-out-time').text('Belum Tercatat').removeClass('text-indigo-600').addClass('text-gray-700');
                        $('#badge-clock-out').text('Belum Absen').removeClass('bg-indigo-100 text-indigo-700').addClass('bg-gray-100 text-gray-500');
                        $('#card-clock-out').removeClass('border-indigo-200 bg-indigo-50/10').addClass('border-gray-100 bg-white');
                        $('#thumb-clock-out').addClass('hidden');

                        // Action Button (Active immediately, blue brand theme)
                        $('#attendance-action-container').html(`
                            <button id="btn-clock-in" class="w-full py-4 bg-brand hover:bg-brand-strong text-white rounded-2xl font-bold text-base shadow-lg shadow-brand/20 transition-all hover:scale-[1.02] cursor-pointer flex items-center justify-center gap-2 border-none outline-none">
                                <i class="fa-solid fa-right-to-bracket text-lg"></i>
                                CLOCK IN (Absen Masuk)
                            </button>
                        `);

                        // Show photo panel & start webcam
                        $('#attendance-photo-panel').removeClass('hidden');
                        $('#attendance-photo-title').text('Ambil Foto Bukti Masuk (Clock In)');
                        startCamera();
                    } 
                    else if (status === 'sudah_clock_in') {
                        // Clock In (Tercatat)
                        const clockInFormatted = attendance.clock_in.substring(0, 5);
                        $('#txt-clock-in-time').text(clockInFormatted + ' WIB').addClass('text-emerald-600').removeClass('text-gray-700');
                        $('#badge-clock-in').text('Tercatat').addClass('bg-emerald-100 text-emerald-700').removeClass('bg-gray-100 text-gray-500');
                        $('#card-clock-in').addClass('border-emerald-200 bg-emerald-50/10').removeClass('border-gray-100 bg-white');
                        
                        if (data.foto_in_url) {
                            $('#thumb-clock-in img').attr('src', data.foto_in_url);
                            $('#thumb-clock-in').removeClass('hidden');
                        } else {
                            $('#thumb-clock-in').addClass('hidden');
                        }

                        // Clock Out
                        $('#txt-clock-out-time').text('Belum Tercatat').removeClass('text-indigo-600').addClass('text-gray-700');
                        $('#badge-clock-out').text('Belum Absen').removeClass('bg-indigo-100 text-indigo-700').addClass('bg-gray-100 text-gray-500');
                        $('#card-clock-out').removeClass('border-indigo-200 bg-indigo-50/10').addClass('border-gray-100 bg-white');
                        $('#thumb-clock-out').addClass('hidden');

                        // Action Button (Active immediately, blue brand theme)
                        $('#attendance-action-container').html(`
                            <button id="btn-clock-out" class="w-full py-4 bg-brand hover:bg-brand-strong text-white rounded-2xl font-bold text-base shadow-lg shadow-brand/20 transition-all hover:scale-[1.02] cursor-pointer flex items-center justify-center gap-2 border-none outline-none">
                                <i class="fa-solid fa-right-from-bracket text-lg"></i>
                                CLOCK OUT (Absen Pulang)
                            </button>
                        `);

                        // Show photo panel & start webcam
                        $('#attendance-photo-panel').removeClass('hidden');
                        $('#attendance-photo-title').text('Ambil Foto Bukti Pulang (Clock Out)');
                        startCamera();
                    } 
                    else if (status === 'sudah_clock_out') {
                        // Clock In (Tercatat)
                        const clockInFormatted = attendance.clock_in.substring(0, 5);
                        $('#txt-clock-in-time').text(clockInFormatted + ' WIB').addClass('text-emerald-600').removeClass('text-gray-700');
                        $('#badge-clock-in').text('Tercatat').addClass('bg-emerald-100 text-emerald-700').removeClass('bg-gray-100 text-gray-500');
                        $('#card-clock-in').addClass('border-emerald-200 bg-emerald-50/10').removeClass('border-gray-100 bg-white');
                        
                        if (data.foto_in_url) {
                            $('#thumb-clock-in img').attr('src', data.foto_in_url);
                            $('#thumb-clock-in').removeClass('hidden');
                        } else {
                            $('#thumb-clock-in').addClass('hidden');
                        }

                        // Clock Out (Tercatat)
                        const clockOutFormatted = attendance.clock_out.substring(0, 5);
                        $('#txt-clock-out-time').text(clockOutFormatted + ' WIB').addClass('text-indigo-600').removeClass('text-gray-700');
                        $('#badge-clock-out').text('Tercatat').addClass('bg-indigo-100 text-indigo-700').removeClass('bg-gray-100 text-gray-500');
                        $('#card-clock-out').addClass('border-indigo-200 bg-indigo-50/10').removeClass('border-gray-100 bg-white');
                        
                        if (data.foto_out_url) {
                            $('#thumb-clock-out img').attr('src', data.foto_out_url);
                            $('#thumb-clock-out').removeClass('hidden');
                        } else {
                            $('#thumb-clock-out').addClass('hidden');
                        }

                        // Action Button Disabled
                        $('#attendance-action-container').html(`
                            <button disabled class="w-full py-4 bg-gray-100 text-gray-400 rounded-2xl font-bold text-base cursor-not-allowed flex items-center justify-center gap-2 border border-gray-200 outline-none">
                                <i class="fa-solid fa-circle-check text-lg text-emerald-500"></i>
                                Selesai Absen Hari Ini
                            </button>
                        `);
                    }
                }

                // webcam utilities
                function startCamera() {
                    // Reset elements
                    $('#attendance-video').addClass('hidden');
                    $('#attendance-photo-preview').addClass('hidden').attr('src', '');
                    $('#attendance-photo-placeholder').removeClass('hidden');
                    $('#attendance-video-overlay').addClass('hidden');
                    $('#attendance-preview-overlay').addClass('hidden');
                    
                    stopCamera();

                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({ 
                            video: { 
                                width: { ideal: 640 }, 
                                height: { ideal: 480 }, 
                                facingMode: "user" 
                            } 
                        })
                        .then(function(stream) {
                            attendanceStream = stream;
                            const video = document.getElementById('attendance-video');
                            video.srcObject = stream;
                            $(video).removeClass('hidden');
                            $('#attendance-photo-placeholder').addClass('hidden');
                            $('#attendance-video-overlay').removeClass('hidden');
                        })
                        .catch(function(err) {
                            console.warn("Kamera terblokir atau tidak terdeteksi:", err);
                        });
                    }
                }

                function stopCamera() {
                    if (attendanceStream) {
                        attendanceStream.getTracks().forEach(track => track.stop());
                        attendanceStream = null;
                    }
                }

                function enableAttendanceActionButton() {
                    const $btnIn = $('#btn-clock-in');
                    if ($btnIn.length) {
                        $btnIn.prop('disabled', false)
                            .removeClass('bg-gray-200 text-gray-400 cursor-not-allowed')
                            .addClass('bg-brand hover:bg-brand-strong text-white shadow-brand/20 cursor-pointer border-none outline-none');
                    }
                    const $btnOut = $('#btn-clock-out');
                    if ($btnOut.length) {
                        $btnOut.prop('disabled', false)
                            .removeClass('bg-gray-200 text-gray-400 cursor-not-allowed')
                            .addClass('bg-brand hover:bg-brand-strong text-white shadow-brand/20 cursor-pointer border-none outline-none');
                    }
                }

                function disableAttendanceActionButton() {
                    enableAttendanceActionButton();
                }

                // Handle snap click
                $(document).on('click', '#btn-snap-photo', function(e) {
                    e.preventDefault();
                    const video = document.getElementById('attendance-video');
                    const canvas = document.getElementById('attendance-canvas');
                    const ctx = canvas.getContext('2d');
                    
                    if (video.paused || video.ended) return;

                    let width = video.videoWidth || 640;
                    let height = video.videoHeight || 480;
                    const max_size = 800;
                    
                    if (width > max_size || height > max_size) {
                        if (width > height) {
                            height = Math.round((height * max_size) / width);
                            width = max_size;
                        } else {
                            width = Math.round((width * max_size) / height);
                            height = max_size;
                        }
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(video, 0, 0, width, height);
                    
                    // Compress client side (JPEG quality: 0.6)
                    capturedPhotoBase64 = canvas.toDataURL('image/jpeg', 0.6);
                    
                    stopCamera();
                    
                    $('#attendance-video').addClass('hidden');
                    $('#attendance-video-overlay').addClass('hidden');
                    
                    $('#attendance-photo-preview').attr('src', capturedPhotoBase64).removeClass('hidden');
                    $('#attendance-preview-overlay').removeClass('hidden');
                    
                    enableAttendanceActionButton();
                });



                // Retake button click
                $(document).on('click', '#btn-retake-photo', function(e) {
                    e.preventDefault();
                    capturedPhotoBase64 = null;
                    disableAttendanceActionButton();
                    startCamera();
                });

                // Image Viewer Click Handlers
                $(document).on('click', '.view-attendance-photo', function(e) {
                    e.preventDefault();
                    const src = $(this).attr('src');
                    const caption = $(this).attr('alt');
                    $('#viewer-photo').attr('src', src);
                    $('#viewer-caption').text(caption);
                    
                    const $viewer = $('#attendance-image-viewer');
                    $viewer.removeClass('hidden');
                    setTimeout(() => {
                        $viewer.removeClass('opacity-0');
                    }, 50);
                });

                $(document).on('click', '.close-image-viewer, #attendance-image-viewer', function(e) {
                    if (e.target.id === 'viewer-photo' || e.target.id === 'viewer-caption') {
                        return;
                    }
                    const $viewer = $('#attendance-image-viewer');
                    $viewer.addClass('opacity-0');
                    setTimeout(() => {
                        $viewer.addClass('hidden');
                    }, 300);
                });

                // Handle Clock In Action Click
                $(document).on('click', '#btn-clock-in', function(e) {
                    e.preventDefault();
                    if (!capturedPhotoBase64) {
                        const video = document.getElementById('attendance-video');
                        if (video && !video.paused && !video.ended) {
                            const canvas = document.getElementById('attendance-canvas');
                            const ctx = canvas.getContext('2d');
                            let width = video.videoWidth || 640;
                            let height = video.videoHeight || 480;
                            const max_size = 800;
                            if (width > max_size || height > max_size) {
                                if (width > height) {
                                    height = Math.round((height * max_size) / width);
                                    width = max_size;
                                } else {
                                    width = Math.round((width * max_size) / height);
                                    height = max_size;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            ctx.drawImage(video, 0, 0, width, height);
                            capturedPhotoBase64 = canvas.toDataURL('image/jpeg', 0.6);
                        } else {
                            oAlert("orange", "Kamera Menginisialisasi", "Mohon tunggu kamera aktif atau izinkan akses kamera.");
                            return;
                        }
                    }

                    loading();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('attendance.clock-in') }}",
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        data: {
                            foto: capturedPhotoBase64
                        },
                        success: function(response) {
                            removeLoading();
                            if (response.success) {
                                oAlert("green", "Berhasil Masuk", response.message);
                                loadAttendanceStatus(); // Reload data status inside modal dynamically
                            } else {
                                oAlert("red", "Gagal", response.message || "Gagal melakukan Clock In.");
                            }
                        },
                        error: function(xhr) {
                            removeLoading();
                            const msg = xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan server saat memproses Clock In.";
                            oAlert("red", "Gagal", msg);
                        }
                    });
                });

                // Handle Clock Out Action Click
                $(document).on('click', '#btn-clock-out', function(e) {
                    e.preventDefault();
                    if (!capturedPhotoBase64) {
                        const video = document.getElementById('attendance-video');
                        if (video && !video.paused && !video.ended) {
                            const canvas = document.getElementById('attendance-canvas');
                            const ctx = canvas.getContext('2d');
                            let width = video.videoWidth || 640;
                            let height = video.videoHeight || 480;
                            const max_size = 800;
                            if (width > max_size || height > max_size) {
                                if (width > height) {
                                    height = Math.round((height * max_size) / width);
                                    width = max_size;
                                } else {
                                    width = Math.round((width * max_size) / height);
                                    height = max_size;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            ctx.drawImage(video, 0, 0, width, height);
                            capturedPhotoBase64 = canvas.toDataURL('image/jpeg', 0.6);
                        } else {
                            oAlert("orange", "Kamera Menginisialisasi", "Mohon tunggu kamera aktif atau izinkan akses kamera.");
                            return;
                        }
                    }

                    loading();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('attendance.clock-out') }}",
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        data: {
                            foto: capturedPhotoBase64
                        },
                        success: function(response) {
                            removeLoading();
                            if (response.success) {
                                oAlert("green", "Berhasil Pulang", response.message);
                                loadAttendanceStatus(); // Reload data status inside modal dynamically
                            } else {
                                oAlert("red", "Gagal", response.message || "Gagal melakukan Clock Out.");
                            }
                        },
                        error: function(xhr) {
                            removeLoading();
                            const msg = xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan server saat memproses Clock Out.";
                            oAlert("red", "Gagal", msg);
                        }
                    });
                });
            });
        </script>
    </body>
</html>