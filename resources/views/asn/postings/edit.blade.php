@extends('layouts.app')

@section('title', 'Edit Posting')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-900">Edit Posting</h1>

    <form action="{{ route('asn.postings.update', $posting) }}" method="POST" class="bg-white border border-gray-200 p-4 sm:p-8 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-5 sm:mb-6">
            <label class="block text-gray-900 font-semibold mb-2 text-sm">URL Posting *</label>
            <input type="url" name="url" value="{{ $posting->url }}" required
                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
            @error('url')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-5 sm:mb-6">
            <div>
                <label class="block text-gray-900 font-semibold mb-2 text-sm">Platform *</label>
                <select name="platform" required
                    class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                    <option value="Instagram" {{ $posting->platform === 'Instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="TikTok" {{ $posting->platform === 'TikTok' ? 'selected' : '' }}>TikTok</option>
                    <option value="YouTube" {{ $posting->platform === 'YouTube' ? 'selected' : '' }}>YouTube</option>
                    <option value="Facebook" {{ $posting->platform === 'Facebook' ? 'selected' : '' }}>Facebook</option>
                </select>
                @error('platform')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-gray-900 font-semibold mb-2 text-sm">Pilar *</label>
                <select name="pilar_id" required
                    class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                    @foreach($pilars as $pilar)
                        <option value="{{ $pilar->id }}" {{ $posting->pilar_id === $pilar->id ? 'selected' : '' }}>
                            {{ $pilar->hashtag }}
                        </option>
                    @endforeach
                </select>
                @error('pilar_id')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-5 sm:mb-6">
            <label class="block text-gray-900 font-semibold mb-2 text-sm">Tanggal Posting *</label>
            <input type="date" name="posted_date" value="{{ $posting->posted_date->format('Y-m-d') }}" required
                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
            @error('posted_date')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6 sm:mb-8">
            <label class="block text-gray-900 font-semibold mb-2 text-sm">Caption/Deskripsi</label>
            <textarea name="caption" rows="4" minrows="4"
                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm resize-vertical">{{ $posting->caption }}</textarea>
        </div>

        <!-- Engagement Metrics -->
        <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="font-semibold text-gray-900 mb-4 text-sm">📊 Engagement Awal</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">👍 Likes</label>
                    <input type="number" name="likes" value="{{ $posting->engagement->likes ?? 0 }}" min="0" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">💬 Comments</label>
                    <input type="number" name="comments" value="{{ $posting->engagement->comments ?? 0 }}" min="0" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">📤 Shares</label>
                    <input type="number" name="shares" value="{{ $posting->engagement->shares ?? 0 }}" min="0" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="flex-1 sm:flex-none text-white px-4 sm:px-6 py-2.5 rounded-lg font-medium text-sm transition hover:opacity-90" style="background-color: #041beb;">
                ✓ Simpan Perubahan
            </button>
            <a href="{{ route('asn.postings.show', $posting) }}" class="flex-1 sm:flex-none text-center bg-gray-200 hover:bg-gray-300 text-gray-900 px-4 sm:px-6 py-2.5 rounded-lg font-medium text-sm transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
