<aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-950 text-white h-full shadow-2xl border-r border-gray-800 fixed left-0 top-0 overflow-y-auto">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        .sidebar-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-link:hover {
            background: rgba(4, 27, 235, 0.2);
            transform: translateX(4px);
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(4, 27, 235, 0.3) 0%, rgba(4, 27, 235, 0.1) 100%);
            border-l-4 border-blue-500;
        }
    </style>

    <div class="p-5 border-b border-gray-700 sticky top-0 bg-gray-900/80 backdrop-blur">
        <div class="flex items-center gap-3 mb-3">
            <div class="bg-blue-600 rounded-lg p-2 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2zm0 4h18v2H3v-2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold leading-tight">KPDT</h2>
                <p class="text-xs text-gray-400 font-light">Kota Surabaya</p>
            </div>
        </div>
        <p class="text-xs text-gray-400 font-light leading-relaxed">
            Sistem Monitoring Kampung Pancasila Digital Tracking
        </p>
    </div>

    <nav class="p-4 space-y-2">
        @if(auth()->user()->hasRole('ASN'))
            <a href="{{ route('asn.dashboard') }}" class="sidebar-link block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('asn.dashboard') ? 'active' : '' }}">
                <span class="inline-flex items-center gap-3 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l4-4m0 0l4-4m-4 4v-8"></path>
                    </svg>
                    Dashboard
                </span>
            </a>
            <a href="{{ route('asn.postings.index') }}" class="sidebar-link block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('asn.postings.*') ? 'active' : '' }}">
                <span class="inline-flex items-center gap-3 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Postings
                </span>
            </a>
        @elseif(auth()->user()->hasRole('PIMPINAN'))
            <a href="{{ route('pimpinan.dashboard') }}" class="sidebar-link block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}">
                <span class="inline-flex items-center gap-3 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l4-4m0 0l4-4m-4 4v-8"></path>
                    </svg>
                    Dashboard
                </span>
            </a>
            <a href="{{ route('pimpinan.evaluations.index') }}" class="sidebar-link block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('pimpinan.evaluations.*') ? 'active' : '' }}">
                <span class="inline-flex items-center gap-3 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Evaluasi
                </span>
            </a>
        @elseif(auth()->user()->hasRole('ADMIN'))
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="inline-flex items-center gap-3 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    Master Data
                </span>
            </a>
        @endif
    </nav>
</aside>
