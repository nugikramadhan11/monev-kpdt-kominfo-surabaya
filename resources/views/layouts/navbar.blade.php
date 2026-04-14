<nav class="text-white shadow-xl sticky top-0 z-50" style="background-color: #041beb;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex items-center gap-3">
                <div class="bg-white rounded-full p-1.5 shadow-md">
                    <img src="{{ asset('images/logo/logo-surabaya.png') }}" alt="Logo" class="h-8 w-8">
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-sm font-bold leading-tight">KPDT</h1>
                    <p class="text-xs text-blue-100">Kota Surabaya</p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                @if(auth()->user()->hasRole('ASN'))
                    <a href="{{ route('asn.dashboard') }}" class="hover:text-blue-50 font-medium text-sm transition {{ request()->routeIs('asn.dashboard') ? 'text-white border-b-2 border-white pb-1' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('asn.postings.index') }}" class="hover:text-blue-50 font-medium text-sm transition {{ request()->routeIs('asn.postings.*') ? 'text-white border-b-2 border-white pb-1' : '' }}">
                        Postings
                    </a>
                @elseif(auth()->user()->hasRole('PIMPINAN'))
                    <a href="{{ route('pimpinan.dashboard') }}" class="hover:text-blue-50 font-medium text-sm transition {{ request()->routeIs('pimpinan.dashboard') ? 'text-white border-b-2 border-white pb-1' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pimpinan.evaluations.index') }}" class="hover:text-blue-50 font-medium text-sm transition {{ request()->routeIs('pimpinan.evaluations.*') ? 'text-white border-b-2 border-white pb-1' : '' }}">
                        Evaluasi
                    </a>
                @elseif(auth()->user()->hasRole('ADMIN'))
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-50 font-medium text-sm transition {{ request()->routeIs('admin.dashboard') ? 'text-white border-b-2 border-white pb-1' : '' }}">
                        Master Data
                    </a>
                @endif
            </div>

            <!-- User Section -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Notification Bell (for ASN only) -->
                @if(auth()->user()->hasRole('ASN'))
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-white hover:bg-blue-700 rounded-lg transition">
                        <img src="{{ asset('images/icons/mail.svg') }}" alt="Notifikasi" class="h-6 w-6">
                        <!-- Unread Badge -->
                        @php
                            $unreadCount = auth()->user()->unreadNotificationsCount();
                        @endphp
                        @if($unreadCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1 -translate-y-1 bg-red-600 rounded-full">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-2xl z-50 overflow-hidden">
                        <!-- Header -->
                        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-sm font-semibold text-gray-900">Notifikasi</h3>
                            @if($unreadCount > 0)
                            <button @click.prevent="open = false" class="text-xs text-blue-600 hover:text-blue-700 font-medium" onclick="fetch('{{ route('asn.notifications.mark-all-read') }}', {method: 'PUT', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}}).then(() => location.reload())">
                                Tandai Semua Dibaca
                            </button>
                            @endif
                        </div>

                        <!-- Notifications List -->
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->notifications()->take(5)->get() as $notif)
                                <a href="{{ $notif->action_url }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 transition cursor-pointer {{ !$notif->is_read ? 'bg-blue-50' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <span class="text-2xl flex-shrink-0">{{ $notif->icon }}</span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $notif->title }}</p>
                                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $notif->message }}</p>
                                            <p class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if(!$notif->is_read)
                                        <div class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-8 text-center text-gray-500 text-sm">
                                    Tidak ada notifikasi
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-3 border-t border-gray-200">
                            <a href="{{ route('asn.notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                Lihat Semua Notifikasi →
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div class="hidden sm:text-right">
                    <p class="text-xs text-blue-100">{{ auth()->user()->name }}</p>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs sm:text-sm font-medium transition">
                        Logout
                    </button>
                </form>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t" style="background-color: #0312b8;">
        <div class="px-4 py-3 space-y-2">
            @if(auth()->user()->hasRole('ASN'))
                <a href="{{ route('asn.dashboard') }}" class="block px-4 py-2 hover:opacity-80 rounded text-sm text-white">Dashboard</a>
                <a href="{{ route('asn.postings.index') }}" class="block px-4 py-2 hover:opacity-80 rounded text-sm text-white">Postings</a>
            @elseif(auth()->user()->hasRole('PIMPINAN'))
                <a href="{{ route('pimpinan.dashboard') }}" class="block px-4 py-2 hover:opacity-80 rounded text-sm text-white">Dashboard</a>
                <a href="{{ route('pimpinan.evaluations.index') }}" class="block px-4 py-2 hover:opacity-80 rounded text-sm text-white">Evaluasi</a>
            @elseif(auth()->user()->hasRole('ADMIN'))
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:opacity-80 rounded text-sm text-white">Master Data</a>
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
