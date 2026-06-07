<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-surabaya.png') }}">
    <title>Login - Kampung Pancasila Digital Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Poppins', sans-serif; }
        
        body {
            background: linear-gradient(135deg, #f8fafb 0%, #f1f5f9 100%);
        }
        
        .gradient-bg { background: linear-gradient(135deg, #041beb 0%, #0312b8 100%); }
        
        .card-hover { 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 20px 40px rgba(4, 27, 235, 0.15);
            background: rgba(255, 255, 255, 0.15) !important;
        }
        
        .input-modern { 
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .input-modern:focus { 
            box-shadow: 0 0 0 4px rgba(4, 27, 235, 0.1), 0 2px 8px rgba(0, 0, 0, 0.05);
            transform: translateY(-1px);
        }
        
        .btn-modern { 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(4, 27, 235, 0.3);
        }
        
        .btn-modern:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(4, 27, 235, 0.4);
        }
        
        .btn-modern:active {
            transform: translateY(-1px);
        }

        /* Navbar modern */
        nav {
            box-shadow: 0 4px 20px rgba(4, 27, 235, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideInUp 0.6s ease-out;
        }

        /* Mobile responsive role cards */
        .role-cards-mobile {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1024px) {
            .role-cards-mobile {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin-bottom: 1rem;
            }
        }

        .role-card-mobile {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 1rem;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .role-card-mobile:hover {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.1) 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .role-card-mobile h3 {
            font-size: 0.875rem;
            margin-bottom: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .role-card-mobile .emoji {
            font-size: 1.25rem;
        }

        .role-card-mobile p {
            font-size: 0.75rem;
            line-height: 1.4;
            color: rgba(255,255,255,0.85);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-gray-100 min-h-screen">
    <!-- Header Navbar -->
    <nav class="text-white shadow-2xl fixed top-0 left-0 right-0 z-50" style="background: linear-gradient(135deg, #041beb 0%, #0312b8 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-2 sm:p-2.5 shadow-lg hover:bg-opacity-30 transition-all">
                    <img src="{{ asset('images/logo/logo-surabaya.png') }}" alt="Logo" class="h-6 sm:h-8 w-6 sm:w-8">
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-bold">KPDT</h1>
                    <p class="text-xs text-blue-100 font-light">Kampung Pancasila Digital Tracking</p>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col lg:flex-row pt-16 sm:pt-20">
        <!-- Left Section - Welcome & Info -->
        <div class="hidden lg:flex lg:w-1/2 text-white flex-col justify-center px-8 lg:px-12 py-12 gradient-bg relative overflow-hidden">
            <!-- Background decorations -->
            <div class="absolute top-10 right-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
            <div class="absolute bottom-10 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
            
            <div class="relative z-10">
                <div class="mb-8 animate-slide-up">
                    <h1 class="text-4xl lg:text-5xl font-bold mb-3 leading-tight">Selamat Datang</h1>
                    <p class="text-blue-100 text-base font-light">Sistem Monitoring & Evaluasi Branding Wilayah ASN Pemkot Surabaya</p>
                </div>

                <!-- Role Information -->
                <div class="space-y-3">
                    <!-- ASN Role -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-3.5 border border-white border-opacity-20 card-hover cursor-default hover:bg-opacity-15 group transition-all duration-300">
                        <div class="flex items-start gap-3">
                            <span class="text-3xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0">👤</span>
                            <div class="flex-1">
                                <h3 class="font-bold text-base text-white">ASN</h3>
                                <p class="text-blue-100 text-xs leading-snug">Submit URL branding, verifikasi posting, tracking progress dan monitor skor evaluasi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pimpinan Role -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-3.5 border border-white border-opacity-20 card-hover cursor-default hover:bg-opacity-15 group transition-all duration-300">
                        <div class="flex items-start gap-3">
                            <span class="text-3xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0">📊</span>
                            <div class="flex-1">
                                <h3 class="font-bold text-base text-white">Pimpinan</h3>
                                <p class="text-blue-100 text-xs leading-snug">Monitoring lengkap, analisis branding per wilayah, evaluasi target ASN dan notifikasi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Role -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-3.5 border border-white border-opacity-20 card-hover cursor-default hover:bg-opacity-15 group transition-all duration-300">
                        <div class="flex items-start gap-3">
                            <span class="text-3xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0">⚙️</span>
                            <div class="flex-1">
                                <h3 class="font-bold text-base text-white">Admin</h3>
                                <p class="text-blue-100 text-xs leading-snug">Master data OPD, wilayah, mapping ASN, pilar branding dan kontrol penuh sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-4 sm:px-8 py-6 sm:py-8 lg:py-12 bg-gradient-to-br from-white via-blue-50 to-gray-50">
            <div class="max-w-md mx-auto w-full">
                <!-- Mobile Header -->
                <div class="lg:hidden mb-4 sm:mb-5 animate-slide-up">
                    <div class="bg-gradient-to-br gradient-bg rounded-2xl p-5 sm:p-6 text-white shadow-2xl border border-blue-300/20">
                        <div class="flex items-center gap-2.5 mb-3">
                            <div class="bg-white bg-opacity-30 backdrop-blur-sm rounded-lg p-2 shadow-lg">
                                <img src="{{ asset('images/logo/logo-surabaya.png') }}" alt="Logo" class="h-5 w-5">
                            </div>
                            <div>
                                <h1 class="text-xs font-bold">KPDT</h1>
                                <p class="text-xs text-blue-100 font-light">Kampung Pancasila</p>
                            </div>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold mb-1">Selamat Datang</h2>
                        <p class="text-xs text-blue-100 font-light">Kampung Pancasila Digital Tracking</p>
                    </div>
                </div>

                <!-- Mobile Role Info -->
                <div class="lg:hidden mb-4 sm:mb-5">
                    <div class="role-cards-mobile">
                        <!-- ASN Mobile -->
                        <div class="role-card-mobile group">
                            <h3>
                                <span class="emoji group-hover:scale-110 transition-transform">👤</span>
                                <span>ASN</span>
                            </h3>
                            <p>Submit URL branding, verifikasi posting, tracking progress dan monitor skor evaluasi.</p>
                        </div>

                        <!-- Pimpinan Mobile -->
                        <div class="role-card-mobile group">
                            <h3>
                                <span class="emoji group-hover:scale-110 transition-transform">📊</span>
                                <span>Pimpinan</span>
                            </h3>
                            <p>Monitoring lengkap, analisis branding per wilayah, evaluasi target ASN dan notifikasi.</p>
                        </div>

                        <!-- Admin Mobile -->
                        <div class="role-card-mobile group">
                            <h3>
                                <span class="emoji group-hover:scale-110 transition-transform">⚙️</span>
                                <span>Admin</span>
                            </h3>
                            <p>Master data OPD, wilayah, mapping ASN, pilar branding dan kontrol penuh sistem.</p>
                        </div>
                    </div>
                </div>

                <!-- Form Title -->
                <div class="mb-4 sm:mb-5 animate-slide-up" style="animation-delay: 0.1s;">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Masuk Akun</h2>
                    <p class="text-gray-600 text-xs sm:text-sm font-light">Masukkan NIP dan password untuk akses</p>
                </div>

                <!-- Error Message -->
                @if($errors->any())
                    <div class="mb-4 sm:mb-5 p-3 sm:p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg text-xs sm:text-sm shadow-sm animate-bounce">
                        <p class="font-semibold mb-1">Akses Ditolak</p>
                        <p class="text-xs sm:text-sm">{{ $errors->first() }}</p>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.store') }}" method="POST" class="space-y-3.5 sm:space-y-5 animate-slide-up" style="animation-delay: 0.2s;">
                    @csrf
                    
                    <!-- NIP Input -->
                    <div class="group">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-1.5 sm:mb-2 group-focus-within:text-blue-600 transition-colors">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                                Nomor Induk Pegawai
                            </span>
                        </label>
                        <input type="text" name="nip" value="{{ old('nip') }}" required 
                            placeholder="198xxxxxxxxxxxxxxx"
                            class="input-modern w-full px-3.5 sm:px-5 py-2 sm:py-2.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-0 text-xs sm:text-base bg-white transition-all">
                    </div>

                    <!-- Password Input -->
                    <div class="group">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-1.5 sm:mb-2 group-focus-within:text-blue-600 transition-colors">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.51l6 3v2.59c0 4.44-2.62 8.58-6 10.33-3.38-1.75-6-5.89-6-10.33V6.51l6-3z"/></svg>
                                Password
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password-input" name="password" required 
                                placeholder="••••••••••"
                                class="input-modern w-full px-3.5 sm:px-5 py-2 sm:py-2.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-0 text-xs sm:text-base bg-white pr-11 sm:pr-12 transition-all">
                            <button type="button" id="toggle-password" class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                <svg id="eye-icon" class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-modern w-full text-white font-bold py-2.5 sm:py-3 rounded-xl text-xs sm:text-base mt-5 sm:mt-6 hover:shadow-2xl active:scale-95 flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #041beb 0%, #0312b8 100%);">
                        <span>Masuk Sistem</span>
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>

                    <!-- Footer -->
                    <div class="pt-3 sm:pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-600 text-center font-light">
                            Sistem ini dilindungi dan terpantau keamanannya.<br class="sm:hidden">
                            Silakan gunakan akun resmi Anda.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility with smooth animation
        const togglePasswordBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password-input');
        const eyeIcon = document.getElementById('eye-icon');

        togglePasswordBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Add scale animation
            eyeIcon.style.transform = 'scale(1.2)';
            
            setTimeout(() => {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.432m5.604-1.406a3.001 3.001 0 003.093 3.093 3.001 3.001 0 00-3.093-3.093zM15 12a3 3 0 11-6 0 3 3 0 016 0zm6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                }
                eyeIcon.style.transform = 'scale(1)';
            }, 100);
        });

        // Add loading state on form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('button[type="submit"]');
            button.innerHTML = '<span class="inline-flex items-center gap-2"><svg class="animate-spin w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
            button.disabled = true;
        });

        // Smooth scroll for mobile inputs on focus
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                if (window.innerWidth < 1024) {
                    setTimeout(() => {
                        this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 300);
                }
            });
        });
    </script>
</body>
</html>
