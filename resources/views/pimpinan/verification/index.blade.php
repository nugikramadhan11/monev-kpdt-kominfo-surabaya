@extends('layouts.app')

@section('title', 'Verifikasi Posting')

@section('content')
<div class="max-w-6xl">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-900">Pending Verification</h1>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-50 to-blue-25 border-b border-blue-200">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">ASN</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Wilayah</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Platform</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Pilar</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Tanggal</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pendingPostings as $posting)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-4 font-medium text-sm text-gray-900">{{ $posting->user->name }}</td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $posting->wilayah->name ?? 'N/A' }}</td>
                        <td class="px-4 sm:px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-platform-icon :platform="$posting->platform" size="w-4 h-4" />
                                <span class="text-sm text-gray-700">{{ $posting->platform }}</span>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $posting->pilar->hashtag }}</span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $posting->created_at->format('d M Y') }}</td>
                        <td class="px-4 sm:px-6 py-4 text-sm">
                            <a href="{{ route('pimpinan.verification.show', $posting) }}" class="text-blue-600 hover:text-blue-800 font-medium">Review →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">Tidak ada posting pending</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
        @forelse($pendingPostings as $posting)
            <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-medium text-gray-900 text-sm">{{ $posting->user->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">📅 {{ $posting->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                
                <div class="flex gap-2 flex-wrap mb-3">
                    <span class="px-2 py-1 bg-blue-600 text-white rounded-full text-xs font-medium inline-flex items-center gap-1">
                        <x-platform-icon :platform="$posting->platform" size="w-3 h-3" />
                        {{ $posting->platform }}
                    </span>
                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-medium">{{ $posting->pilar->hashtag }}</span>
                </div>
                
                <a href="{{ route('pimpinan.verification.show', $posting) }}" class="inline-block w-full text-center py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition">
                    Review →
                </a>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-lg p-6 text-center">
                <p class="text-gray-500 text-sm">Tidak ada posting pending</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $pendingPostings->links() }}
    </div>
</div>
@endsection
