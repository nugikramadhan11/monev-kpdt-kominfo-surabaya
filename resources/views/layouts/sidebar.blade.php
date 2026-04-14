<aside class="w-64 bg-gray-900 text-white h-full">
    <div class="p-4 border-b border-gray-700">
        <h2 class="text-2xl font-bold">KPDT</h2>
    </div>
    <nav class="p-4">
        @if(auth()->user()->hasRole('ASN'))
            <a href="{{ route('asn.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('asn.dashboard') ? 'bg-blue-600' : '' }}">Dashboard</a>
            <a href="{{ route('asn.postings.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('asn.postings.*') ? 'bg-blue-600' : '' }}">Postings</a>
        @elseif(auth()->user()->hasRole('PIMPINAN'))
            <a href="{{ route('pimpinan.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('pimpinan.dashboard') ? 'bg-blue-600' : '' }}">Dashboard</a>
            <a href="{{ route('pimpinan.evaluations.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('pimpinan.evaluations.*') ? 'bg-blue-600' : '' }}">Evaluasi</a>
        @elseif(auth()->user()->hasRole('ADMIN'))
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">Master Data</a>
        @endif
    </nav>
</aside>
