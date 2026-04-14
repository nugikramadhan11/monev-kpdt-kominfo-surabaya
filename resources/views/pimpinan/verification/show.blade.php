@extends('layouts.app')

@section('title', 'Review Posting')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('pimpinan.verification.index') }}" class="text-blue-600 hover:text-blue-800 font-medium mb-6 inline-flex items-center gap-1">
        ← Kembali
    </a>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500">{{ $posting->created_at->format('d M Y H:i') }}</p>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $posting->user->name }}</h1>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1 flex items-center gap-2">
                        <x-platform-icon :platform="$posting->platform" size="w-4 h-4" />
                        <span>{{ $posting->platform }} • {{ $posting->pilar->hashtag }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-6 space-y-6">
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Pilar</h3>
                <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ $posting->pilar->hashtag }}</span>
            </div>

            <div>
                <h3 class="font-semibold text-gray-900 mb-2">URL</h3>
                <a href="{{ $posting->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all text-sm">{{ $posting->url }}</a>
            </div>

            @if($posting->caption)
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Caption</h3>
                    <p class="text-gray-700 text-sm bg-gray-50 p-4 rounded-lg border border-gray-200">{{ $posting->caption }}</p>
                </div>
            @endif

            <div>
                <h3 class="font-semibold text-gray-900 mb-3">Engagement</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
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

            <div class="pt-6 border-t border-gray-200 space-y-4">
                <h3 class="font-semibold text-lg text-gray-900">Verifikasi</h3>

                <!-- Approve Button -->
                <form action="{{ route('pimpinan.verification.approve', $posting) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 sm:px-6 py-2.5 rounded-lg font-medium text-sm transition">
                        ✓ Setujui Posting
                    </button>
                </form>

                <!-- Reject Form -->
                <div class="mt-4 p-4 sm:p-6 bg-red-50 rounded-lg border border-red-200">
                    <form action="{{ route('pimpinan.verification.reject', $posting) }}" method="POST">
                        @csrf
                        <label class="block text-gray-900 font-semibold mb-3 text-sm">Tolak dengan Alasan:</label>
                        <textarea name="reason" rows="3" placeholder="Masukkan alasan penolakan..." required
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent mb-3 text-sm"></textarea>
                        <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 sm:px-6 py-2.5 rounded-lg font-medium text-sm transition">
                            ✗ Tolak Posting
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
