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
            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-100 border border-gray-100">
                <!-- Header Gradient Modern -->
                <div class="bg-gradient-to-r from-brand to-indigo-600 px-6 py-8 text-white relative">
                    <button type="button" class="absolute top-4 right-4 text-white/80 hover:text-white hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition-all cursor-pointer close-attendance-modal outline-none border-0 bg-transparent">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                    <div class="text-center">
                        <p class="text-xs uppercase tracking-widest text-blue-100 font-semibold opacity-90 mb-1">Absensi Staf Kasir</p>
                        <!-- Real-time Clock -->
                        <h2 id="attendance-clock" class="text-4xl font-extrabold tracking-tight drop-shadow-md my-2 font-mono">00:00:00</h2>
                        <!-- Date Display -->
                        <p id="attendance-date" class="text-sm font-medium opacity-90"></p>
                    </div>
                </div>

                <!-- Body Modal -->
                <div class="p-6 max-h-[80vh] overflow-y-auto">
                    <!-- Profil Karyawan Card -->
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl mb-6 border border-gray-100">
                        <img id="attendance-user-avatar" src="" class="rounded-full w-14 h-14 object-cover border-2 border-brand/20 shadow-md animate-pulse" alt="Avatar" />
                        <div>
                            <h3 id="attendance-user-name" class="font-bold text-gray-800 text-lg leading-tight">Nama Karyawan</h3>
                            <span id="attendance-user-role" class="inline-block mt-1 px-2.5 py-0.5 bg-brand-soft text-fg-brand-strong text-xs font-semibold rounded-full uppercase tracking-wider">ROLE</span>
                        </div>
                    </div>

                    <!-- Panel Kamera Absensi Premium -->
                    <div id="attendance-photo-panel" class="mb-6 hidden transition-all duration-300">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2" id="attendance-photo-title">Ambil Foto Bukti Kehadiran</h4>
                        
                        <div class="relative w-full h-56 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 flex items-center justify-center shadow-inner group">
                            <!-- Live Video Feed -->
                            <video id="attendance-video" class="w-full h-full object-cover hidden" autoplay playsinline></video>
                            
                            <!-- Static Preview Image (after capture/upload) -->
                            <img id="attendance-photo-preview" class="w-full h-full object-cover hidden" alt="Pratinjau Foto" />
                            
                            <!-- Placeholder and Fallback Button -->
                            <div id="attendance-photo-placeholder" class="text-center p-4">
                                <div class="w-12 h-12 rounded-full bg-brand-soft text-brand flex items-center justify-center text-xl mx-auto mb-2 animate-bounce">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <p class="text-xs font-semibold text-gray-500">Kamera tidak aktif atau terblokir</p>
                                <button type="button" id="btn-file-fallback" class="mt-3 px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded-xl transition-all cursor-pointer inline-flex items-center gap-1 border-none outline-none">
                                    <i class="fa-solid fa-file-image"></i> Pilih Foto Manual
                                </button>
                            </div>
                            
                            <!-- Hidden File Input for Fallback -->
                            <input type="file" id="attendance-file-input" class="hidden" accept="image/*" capture="user" />

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
                    <div class="space-y-4 mb-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status Kehadiran Hari Ini</h4>
                        
                        <!-- Clock In Card -->
                        <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 bg-white transition-all hover:shadow-sm" id="card-clock-in">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase">Clock In (Masuk)</p>
                                    <p id="txt-clock-in-time" class="text-sm font-bold text-gray-700 mt-0.5">Belum Tercatat</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="thumb-clock-in" class="hidden">
                                    <img src="" class="w-10 h-10 object-cover rounded-lg border border-gray-200 cursor-pointer hover:scale-105 transition-all view-attendance-photo shadow-sm" alt="Bukti Foto Masuk" />
                                </div>
                                <span id="badge-clock-in" class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-500">Belum Absen</span>
                            </div>
                        </div>

                        <!-- Clock Out Card -->
                        <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 bg-white transition-all hover:shadow-sm" id="card-clock-out">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase">Clock Out (Pulang)</p>
                                    <p id="txt-clock-out-time" class="text-sm font-bold text-gray-700 mt-0.5">Belum Tercatat</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="thumb-clock-out" class="hidden">
                                    <img src="" class="w-10 h-10 object-cover rounded-lg border border-gray-200 cursor-pointer hover:scale-105 transition-all view-attendance-photo shadow-sm" alt="Bukti Foto Pulang" />
                                </div>
                                <span id="badge-clock-out" class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-500">Belum Absen</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div id="attendance-action-container">
                        <!-- Dinamis diisi lewat JS -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Fullscreen Attendance Image Viewer Overlay -->
        <div id="attendance-image-viewer" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/85 backdrop-blur-md transition-opacity duration-300 opacity-0">
            <div class="relative max-w-md w-full p-4 flex flex-col items-center">
                <button type="button" class="absolute top-4 right-4 bg-white/20 hover:bg-white/40 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer border-none outline-none close-image-viewer animate-pulse">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
                <img id="viewer-photo" class="max-w-full max-h-[70vh] rounded-2xl object-contain shadow-2xl border border-white/10" src="" alt="Bukti Kehadiran Full" />
                <p id="viewer-caption" class="text-white text-sm font-semibold mt-4 text-center px-4 py-2 bg-black/40 rounded-full backdrop-blur-sm"></p>
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

                // Handle Modal Close Click
                $(document).on('click', '.close-attendance-modal', function() {
                    if (attendanceModal) attendanceModal.hide();
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
                    $('#attendance-file-input').val('');

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

                        // Action Button (Disabled initially until photo captured)
                        $('#attendance-action-container').html(`
                            <button id="btn-clock-in" disabled class="w-full py-4 bg-gray-200 text-gray-400 rounded-2xl font-bold text-base cursor-not-allowed flex items-center justify-center gap-2 border-none outline-none">
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

                        // Action Button (Disabled initially until photo captured)
                        $('#attendance-action-container').html(`
                            <button id="btn-clock-out" disabled class="w-full py-4 bg-gray-200 text-gray-400 rounded-2xl font-bold text-base cursor-not-allowed flex items-center justify-center gap-2 border-none outline-none">
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
                            .addClass('bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white shadow-emerald-500/20 transform transition-all duration-150 hover:scale-[1.02] cursor-pointer border-none outline-none');
                    }
                    const $btnOut = $('#btn-clock-out');
                    if ($btnOut.length) {
                        $btnOut.prop('disabled', false)
                            .removeClass('bg-gray-200 text-gray-400 cursor-not-allowed')
                            .addClass('bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white shadow-orange-500/20 transform transition-all duration-150 hover:scale-[1.02] cursor-pointer border-none outline-none');
                    }
                }

                function disableAttendanceActionButton() {
                    const $btnIn = $('#btn-clock-in');
                    if ($btnIn.length) {
                        $btnIn.prop('disabled', true)
                            .addClass('bg-gray-200 text-gray-400 cursor-not-allowed')
                            .removeClass('bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white shadow-emerald-500/20 transform hover:scale-[1.02] cursor-pointer border-none outline-none');
                    }
                    const $btnOut = $('#btn-clock-out');
                    if ($btnOut.length) {
                        $btnOut.prop('disabled', true)
                            .addClass('bg-gray-200 text-gray-400 cursor-not-allowed')
                            .removeClass('bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white shadow-orange-500/20 transform hover:scale-[1.02] cursor-pointer border-none outline-none');
                    }
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

                // Handle file fallback triggers
                $(document).on('click', '#btn-file-fallback', function(e) {
                    e.preventDefault();
                    $('#attendance-file-input').click();
                });

                $(document).on('change', '#attendance-file-input', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    
                    loading();
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = new Image();
                        img.onload = function() {
                            const canvas = document.getElementById('attendance-canvas');
                            const ctx = canvas.getContext('2d');
                            
                            let width = img.width;
                            let height = img.height;
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
                            ctx.drawImage(img, 0, 0, width, height);
                            
                            // Compress client side (JPEG quality: 0.6)
                            capturedPhotoBase64 = canvas.toDataURL('image/jpeg', 0.6);
                            
                            removeLoading();
                            stopCamera();
                            
                            $('#attendance-video').addClass('hidden');
                            $('#attendance-photo-placeholder').addClass('hidden');
                            $('#attendance-video-overlay').addClass('hidden');
                            
                            $('#attendance-photo-preview').attr('src', capturedPhotoBase64).removeClass('hidden');
                            $('#attendance-preview-overlay').removeClass('hidden');
                            
                            enableAttendanceActionButton();
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
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
                        oAlert("orange", "Foto Dibutuhkan", "Mohon ambil foto bukti kehadiran terlebih dahulu.");
                        return;
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
                        oAlert("orange", "Foto Dibutuhkan", "Mohon ambil foto bukti pulang terlebih dahulu.");
                        return;
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