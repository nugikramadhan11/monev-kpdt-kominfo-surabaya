@extends('layouts.app')

@section('title', 'Detail Posting')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('asn.postings.index') }}" class="text-blue-600 hover:text-blue-800 font-medium mb-6 inline-flex items-center gap-1">
        ← Kembali
    </a>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500">{{ $posting->posted_date->format('d M Y') }}</p>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <x-platform-icon :platform="$posting->platform" size="w-6 h-6" />
                        {{ $posting->platform }}
                    </h1>
                </div>
                @if($posting->status === 'VERIFIED')
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ Terverifikasi</span>
                @elseif($posting->status === 'REJECTED')
                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">✗ Ditolak</span>
                @else
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">⏳ Menunggu</span>
                @endif
            </div>
        </div>

        <div class="p-4 sm:p-6 space-y-6">
            <div>
                <h3 class="font-semibold text-gray-900 mb-2 text-sm">Pilar</h3>
                <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ $posting->pilar->hashtag }}</span>
            </div>

            <div>
                <h3 class="font-semibold text-gray-900 mb-2 text-sm">URL</h3>
                <a href="{{ $posting->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all text-sm">{{ $posting->url }}</a>
            </div>

            @if($posting->caption)
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2 text-sm">Caption</h3>
                    <p class="text-gray-700 text-sm bg-gray-50 p-4 rounded-lg border border-gray-200">{{ $posting->caption }}</p>
                </div>
            @endif

            @if($posting->rejection_reason)
                <div class="p-4 sm:p-6 bg-red-50 border border-red-200 rounded-lg">
                    <h3 class="font-semibold text-red-900 mb-2 text-sm">Alasan Penolakan</h3>
                    <p class="text-red-700 text-sm">{{ $posting->rejection_reason }}</p>
                </div>
            @endif

            <!-- Engagement Display -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="font-semibold text-lg text-gray-900 mb-4">📊 Engagement</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 p-4 sm:p-6 rounded-lg">
                        <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $posting->engagement->likes ?? 0 }}</p>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1">👍 Likes</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-white border border-green-200 p-4 sm:p-6 rounded-lg">
                        <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $posting->engagement->comments ?? 0 }}</p>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1">💬 Comments</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-white border border-purple-200 p-4 sm:p-6 rounded-lg">
                        <p class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $posting->engagement->shares ?? 0 }}</p>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1">📤 Shares</p>
                    </div>
                </div>
            </div>

            <!-- Edit/Delete Actions -->
            @if($posting->status === 'DRAFT' || $posting->status === 'REJECTED')
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('asn.postings.edit', $posting) }}" class="flex-1 sm:flex-none text-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 rounded-lg font-medium text-sm transition">
                        ✎ Edit
                    </a>
                    <form action="{{ route('asn.postings.destroy', $posting) }}" method="POST" class="flex-1 sm:flex-none">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg font-medium text-sm transition" onclick="return confirm('Yakin?')">
                            🗑 Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
