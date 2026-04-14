@extends('layouts.app')

@section('title', 'Daftar Posting')

@section('content')
<div class="max-w-6xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Posting Saya</h1>
        <a href="{{ route('asn.postings.create') }}" class="w-full sm:w-auto text-white px-4 py-2 rounded-lg font-medium text-sm transition text-center hover:opacity-90" style="background-color: #041beb;">
            ➕ Posting Baru
        </a>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-50 to-blue-25 border-b border-blue-200">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Tanggal</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Platform</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Pilar</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($postings as $posting)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $posting->created_at->format('d M Y') }}</td>
                        <td class="px-4 sm:px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-platform-icon :platform="$posting->platform" size="w-5 h-5" />
                                <span class="text-sm text-gray-700">{{ $posting->platform }}</span>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $posting->pilar->hashtag }}</span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm">
                            @if($posting->status === 'VERIFIED')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ Terverifikasi</span>
                            @elseif($posting->status === 'REJECTED')
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">✗ Ditolak</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">⏳ Menunggu</span>
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm">
                            <a href="{{ route('asn.postings.show', $posting) }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <p class="text-sm">Belum ada posting</p>
                            <p class="text-xs text-gray-400 mt-1">Mulai dengan menambahkan posting pertama Anda</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
        @forelse($postings as $posting)
            <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">📅 {{ $posting->created_at->format('d M Y') }}</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2">
                            <x-platform-icon :platform="$posting->platform" size="w-4 h-4" />
                            {{ $posting->platform }}
                        </p>
                    </div>
                    @if($posting->status === 'VERIFIED')
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ Terverifikasi</span>
                    @elseif($posting->status === 'REJECTED')
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">✗ Ditolak</span>
                    @else
                        <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">⏳ Menunggu</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <span class="inline-block px-3 py-1 bg-blue-600 text-white rounded-full text-xs font-medium">{{ $posting->pilar->hashtag }}</span>
                </div>
                
                <a href="{{ route('asn.postings.show', $posting) }}" class="inline-block w-full text-center py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition">
                    Lihat Detail →
                </a>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-lg p-6 text-center">
                <p class="text-gray-500 text-sm">Belum ada posting</p>
                <p class="text-gray-400 text-xs mt-1">Mulai dengan menambahkan posting pertama Anda</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $postings->links() }}
    </div>
</div>
@endsection
