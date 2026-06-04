<nav class="text-white fixed top-0 left-0 right-0 z-50" style="background: linear-gradient(135deg, #041beb 0%, #0312b8 100%); box-shadow: 0 4px 20px rgba(4, 27, 235, 0.1); backdrop-filter: blur(10px);">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        .navbar-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .navbar-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s ease;
        }
        .navbar-link:hover::after {
            width: 100%;
        }
        .navbar-link.active::after {
            width: 100%;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
        <div class="flex justify-between items-center">
            <!-- Logo Section -->
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-2 sm:p-2.5 shadow-lg hover:bg-opacity-30 transition-all duration-300">
                    <img src="{{ asset('images/logo/logo-surabaya.png') }}" alt="Logo" class="h-6 sm:h-8 w-6 sm:w-8">
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-bold leading-tight">KPDT</h1>
                    <p class="text-xs text-blue-100 font-light">Kota Surabaya • Monitoring</p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8 lg:gap-12">
                @if(auth()->user()->hasRole('ASN'))
                    <a href="{{ route('asn.dashboard') }}" class="navbar-link hover:text-blue-100 font-medium text-sm transition {{ request()->routeIs('asn.dashboard') ? 'active text-white' : 'text-blue-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('asn.postings.index') }}" class="navbar-link hover:text-blue-100 font-medium text-sm transition {{ request()->routeIs('asn.postings.*') ? 'active text-white' : 'text-blue-50' }}">
                        Postings
                    </a>
                @elseif(auth()->user()->hasRole('PIMPINAN'))
                    <a href="{{ route('pimpinan.dashboard') }}" class="navbar-link hover:text-blue-100 font-medium text-sm transition {{ request()->routeIs('pimpinan.dashboard') ? 'active text-white' : 'text-blue-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pimpinan.evaluations.index') }}" class="navbar-link hover:text-blue-100 font-medium text-sm transition {{ request()->routeIs('pimpinan.evaluations.*') ? 'active text-white' : 'text-blue-50' }}">
                        Evaluasi
                    </a>
                @elseif(auth()->user()->hasRole('ADMIN'))
                    <a href="{{ route('admin.dashboard') }}" class="navbar-link hover:text-blue-100 font-medium text-sm transition {{ request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-blue-50' }}">
                        Master Data
                    </a>
                @endif
            </div>

            <!-- User Section -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Notification Bell (for ASN only) -->
                @if(auth()->user()->hasRole('ASN'))
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-300">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <!-- Unread Badge -->
                        @php
                            $unreadCount = auth()->user()->unreadNotificationsCount();
                        @endphp
                        @if($unreadCount > 0)
                        <span class="absolute top-1 right-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full shadow-lg animate-pulse">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden">
                        <!-- Header -->
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-blue-50 to-gray-50">
                            <h3 class="text-sm font-bold text-gray-900">Notifikasi</h3>
                            @if($unreadCount > 0)
                            <button @click.prevent="open = false" class="text-xs text-blue-600 hover:text-blue-700 font-semibold transition" onclick="fetch('{{ route('asn.notifications.mark-all-read') }}', {method: 'PUT', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}}).then(() => location.reload())">
                                Tandai Dibaca
                            </button>
                            @endif
                        </div>

                        <!-- Notifications List -->
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->notifications()->take(5)->get() as $notif)
                                <a href="{{ $notif->action_url }}" class="block px-4 sm:px-6 py-4 hover:bg-blue-50 border-b border-gray-100 transition cursor-pointer {{ !$notif->is_read ? 'bg-blue-50' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <span class="text-2xl flex-shrink-0 mt-1">{{ $notif->icon }}</span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $notif->title }}</p>
                                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $notif->message }}</p>
                                            <p class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if(!$notif->is_read)
                                        <div class="flex-shrink-0 w-2.5 h-2.5 bg-blue-600 rounded-full mt-1.5"></div>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 sm:px-6 py-8 text-center text-gray-500 text-sm">
                                    Tidak ada notifikasi
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        <div class="px-4 sm:px-6 py-3 border-t border-gray-200 bg-gray-50">
                            <a href="{{ route('asn.notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-semibold transition">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- User Profile -->
                <div class="hidden sm:block">
                    <p class="text-xs text-blue-100 font-light">{{ auth()->user()->name }}</p>
                </div>
                
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 sm:px-4 py-2 sm:py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs sm:text-sm font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg">
                        Logout
                    </button>
                </form>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden p-2 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-300" onclick="toggleMobileMenu()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t border-white border-opacity-20 bg-gradient-to-b from-blue-700 to-blue-900" style="background: linear-gradient(180deg, rgba(4, 27, 235, 0.9) 0%, rgba(3, 18, 184, 0.9) 100%);">
        <div class="px-4 py-4 space-y-2">
            @if(auth()->user()->hasRole('ASN'))
                <a href="{{ route('asn.dashboard') }}" class="block px-4 py-3 hover:bg-white hover:bg-opacity-10 rounded-lg text-sm text-blue-50 font-medium transition-all duration-300 {{ request()->routeIs('asn.dashboard') ? 'bg-white bg-opacity-10' : '' }}">Dashboard</a>
                <a href="{{ route('asn.postings.index') }}" class="block px-4 py-3 hover:bg-white hover:bg-opacity-10 rounded-lg text-sm text-blue-50 font-medium transition-all duration-300 {{ request()->routeIs('asn.postings.*') ? 'bg-white bg-opacity-10' : '' }}">Postings</a>
            @elseif(auth()->user()->hasRole('PIMPINAN'))
                <a href="{{ route('pimpinan.dashboard') }}" class="block px-4 py-3 hover:bg-white hover:bg-opacity-10 rounded-lg text-sm text-blue-50 font-medium transition-all duration-300 {{ request()->routeIs('pimpinan.dashboard') ? 'bg-white bg-opacity-10' : '' }}">Dashboard</a>
                <a href="{{ route('pimpinan.evaluations.index') }}" class="block px-4 py-3 hover:bg-white hover:bg-opacity-10 rounded-lg text-sm text-blue-50 font-medium transition-all duration-300 {{ request()->routeIs('pimpinan.evaluations.*') ? 'bg-white bg-opacity-10' : '' }}">Evaluasi</a>
            @elseif(auth()->user()->hasRole('ADMIN'))
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 hover:bg-white hover:bg-opacity-10 rounded-lg text-sm text-blue-50 font-medium transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-10' : '' }}">Master Data</a>
            @endif
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
</script>
