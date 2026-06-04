<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-surabaya.png') }}">
    <title>@yield('title', 'KPDT - Monitoring Kinerja Dinas Teknis')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Poppins', sans-serif; }
        
        body {
            background: linear-gradient(135deg, #f8fafb 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        @if(auth()->check())
            @include('layouts.navbar')
        @endif

        <!-- Main Content -->
        <main class="flex-1 overflow-auto {{ auth()->check() ? 'pt-16 sm:pt-20' : 'pt-0' }} pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <!-- Card Container -->
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10">
                @if($errors->any())
                    <div class="mb-6 p-5 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg text-sm shadow-sm">
                        <h3 class="font-bold mb-3">⚠️ Oops, ada kesalahan:</h3>
                        <ul class="list-disc list-inside space-y-2">
                            @foreach($errors->all() as $error)
                                <li class="font-medium">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 p-5 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2">
                        <span class="text-lg">✓</span> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
