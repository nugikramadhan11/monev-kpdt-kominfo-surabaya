<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-surabaya.png') }}">
    <title>Login - KPDT Kota Surabaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #041beb 0%, #0312b8 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
        .input-modern { transition: all 0.3s ease; }
        .input-modern:focus { box-shadow: 0 0 0 3px rgba(4, 27, 235, 0.1); }
        .btn-modern { transition: all 0.3s ease; }
        .btn-modern:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(4, 27, 235, 0.4); }
    </style>
</head>
<body class="bg-white">
    <!-- Header Navbar -->
    <nav class="text-white shadow-xl" style="background-color: #041beb;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center gap-3">
                <div class="bg-white rounded-full p-1.5 shadow-md">
                    <img src="{{ asset('images/logo/logo-surabaya.png') }}" alt="Logo" class="h-8 w-8">
                </div>
                <div>
                    <h1 class="text-lg font-bold">KPDT</h1>
                    <p class="text-xs text-blue-100">Kota Surabaya • Monitoring</p>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Section - Welcome & Info -->
        <div class="hidden lg:flex lg:w-1/2 text-white flex-col justify-center px-20 py-12 gradient-bg">
            <div class="w-full">
                <h1 class="text-4xl font-bold mb-4">Selamat Datang</h1>
                <p class="text-blue-100 text-base mb-12 font-light">Sistem Monitoring KPDT Kota Surabaya</p>

                <!-- Role Information -->
                <div class="grid grid-cols-3 gap-5">
                    <!-- ASN Role -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-5 border border-white border-opacity-20 card-hover hover:bg-opacity-15 cursor-default">
                        <h3 class="font-semibold mb-3 text-blue-50 flex items-center gap-2">
                            <span class="text-3xl">👤</span> <span class="text-sm">Role ASN</span>
                        </h3>
                        <p class="text-xs text-blue-100 leading-relaxed">Submit URL branding, verifikasi posting, lihat progress dan skor real-time.</p>
                    </div>

                    <!-- Atasan Role -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-5 border border-white border-opacity-20 card-hover hover:bg-opacity-15 cursor-default">
                        <h3 class="font-semibold mb-3 text-blue-50 flex items-center gap-2">
                            <span class="text-3xl">📊</span> <span class="text-sm">Role Atasan</span>
                        </h3>
                        <p class="text-xs text-blue-100 leading-relaxed">Monitoring lengkap, filter wilayah, lihat target ASN dan notifikasi.</p>
                    </div>

                    <!-- Admin Role -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-5 border border-white border-opacity-20 card-hover hover:bg-opacity-15 cursor-default">
                        <h3 class="font-semibold mb-3 text-blue-50 flex items-center gap-2">
                            <span class="text-3xl">⚙️</span> <span class="text-sm">Role Admin</span>
                        </h3>
                        <p class="text-xs text-blue-100 leading-relaxed">Master data OPD, wilayah, ASN mapping dan kontrol sistem.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-4 sm:px-8 py-8 sm:py-12 lg:py-16 bg-white">
            <div class="max-w-md mx-auto w-full">
                <!-- Mobile Header -->
                <div class="lg:hidden mb-6 sm:mb-8">
                    <div class="bg-gradient-to-br gradient-bg rounded-2xl p-4 text-white mb-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-white rounded-full p-1.5">
                                <img src="{{ asset('images/logo/logo-surabaya.png') }}" alt="Logo" class="h-8 w-8">
                            </div>
                            <div>
                                <h1 class="text-sm font-bold">KPDT</h1>
                                <p class="text-xs text-blue-100">Kota Surabaya</p>
                            </div>
                        </div>
                        <h2 class="text-lg font-bold">Selamat Datang</h2>
                        <p class="text-xs text-blue-100">Sistem Monitoring KPDT</p>
                    </div>
                </div>

                <div class="mb-6 sm:mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">Masuk Akun</h2>
                    <p class="text-gray-600 text-xs sm:text-sm">Nikmati akses penuh ke sistem monitoring kami</p>
                </div>

                @if($errors->any())
                    <div class="mb-5 sm:mb-6 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs sm:text-sm">
                        <p class="font-semibold mb-1">Gagal Login</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-900 mb-2 sm:mb-3">Nomor Induk Pegawai</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" required 
                            placeholder="198xxxxxxxxxxxxx"
                            class="input-modern w-full px-4 sm:px-5 py-2.5 sm:py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs sm:text-sm bg-white hover:border-gray-400">
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-900 mb-2 sm:mb-3">Password</label>
                        <div class="relative">
                            <input type="password" id="password-input" name="password" required 
                                placeholder="••••••••"
                                class="input-modern w-full px-4 sm:px-5 py-2.5 sm:py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-xs sm:text-sm bg-white hover:border-gray-400">
                            <button type="button" id="toggle-password" class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg id="eye-icon" class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-modern w-full text-white font-semibold py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm mt-6 sm:mt-8" style="background-color: #041beb;">
                        Masuk Sistem
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePasswordBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password-input');
        const eyeIcon = document.getElementById('eye-icon');

        togglePasswordBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Change icon to eye-off
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.432m5.604-1.406a3.001 3.001 0 003.093 3.093 3.001 3.001 0 00-3.093-3.093zM15 12a3 3 0 11-6 0 3 3 0 016 0zm6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            } else {
                passwordInput.type = 'password';
                // Change icon back to eye
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        });
    </script>
</body>
</html>
