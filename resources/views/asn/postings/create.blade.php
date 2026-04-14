@extends('layouts.app')

@section('title', 'Input Posting Baru')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">Input Posting Baru</h1>
        <p class="text-sm sm:text-base text-gray-600">Isi form untuk menambahkan posting ke sistem</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('asn.postings.store') }}" method="POST" class="bg-white rounded-lg border border-gray-200 p-4 sm:p-6 shadow-sm">
                @csrf

                <!-- URL Posting -->
                <div class="mb-5 sm:mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">URL Posting <span class="text-red-600">*</span></label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="url" id="urlInput" name="url" value="{{ old('url') }}" required
                            placeholder="https://instagram.com/p/..."
                            class="flex-1 px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                        <button type="button" id="verifyBtn" onclick="verifyURL()" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition whitespace-nowrap">
                            🔍 Verifikasi
                        </button>
                    </div>
                    <div id="verifyMessage" class="mt-2 text-sm"></div>
                    @error('url')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Platform & Pilar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-5 sm:mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Platform <span class="text-red-600">*</span></label>
                        <select name="platform" required
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                            <option value="">-- Pilih Platform --</option>
                            <option value="Instagram">Instagram</option>
                            <option value="TikTok">TikTok</option>
                            <option value="YouTube">YouTube</option>
                            <option value="Facebook">Facebook</option>
                        </select>
                        @error('platform')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Pilar <span class="text-red-600">*</span></label>
                        <select name="pilar_id" required
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                            <option value="">-- Pilih Pilar --</option>
                            @foreach($pilars as $pilar)
                                <option value="{{ $pilar->id }}">{{ $pilar->hashtag }}</option>
                            @endforeach
                        </select>
                        @error('pilar_id')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Tanggal Posting -->
                <div class="mb-5 sm:mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Tanggal Posting <span class="text-red-600">*</span></label>
                    <input type="date" name="posted_date" value="{{ old('posted_date', now()->format('Y-m-d')) }}" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                    @error('posted_date')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Caption/Deskripsi -->
                <div class="mb-6 sm:mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Caption/Deskripsi</label>
                    <textarea name="caption" rows="4" minrows="4"
                        placeholder="Tulis deskripsi singkat tentang konten posting Anda..."
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm resize-vertical">{{ old('caption') }}</textarea>
                </div>

                <!-- Engagement Metrics -->
                <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-4 text-sm">📊 Engagement Awal</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-2">👍 Likes</label>
                            <input type="number" name="likes" value="{{ old('likes', 0) }}" min="0" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-2">💬 Comments</label>
                            <input type="number" name="comments" value="{{ old('comments', 0) }}" min="0" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-2">📤 Shares</label>
                            <input type="number" name="shares" value="{{ old('shares', 0) }}" min="0" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 px-4 sm:px-6 py-2.5 text-white rounded-lg font-medium text-sm transition hover:opacity-90" style="background-color: #041beb;">
                        ✓ Simpan Posting
                    </button>
                    <a href="{{ route('asn.postings.index') }}" class="flex-1 px-4 sm:px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-lg font-medium text-sm transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Sidebar - Format Guide -->
        <div class="lg:col-span-1 space-y-4">
            <!-- Format Tips -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 mb-3 text-sm">📌 Panduan Caption</h3>
                
                <div class="space-y-3 text-xs">
                    <div>
                        <p class="font-medium text-gray-900 mb-1">✓ Format baik:</p>
                        <p class="text-gray-700 bg-white p-2 rounded border-l-2 border-blue-600">"Berbagi kabar pemerintah #Pancasila 🇮🇩"</p>
                    </div>

                    <div>
                        <p class="font-medium text-gray-900 mb-1">✗ Hindari:</p>
                        <ul class="text-gray-700 space-y-1">
                            <li>• Caption kosong</li>
                            <li>• Hanya link</li>
                            <li>• Konten spam</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Checklist -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 mb-3 text-sm">📋 Checklist</h3>
                <ul class="text-xs text-gray-700 space-y-2">
                    <li>☑️ URL valid</li>
                    <li>☑️ Platform benar</li>
                    <li>☑️ Pilar sesuai</li>
                    <li>☑️ Caption jelas</li>
                </ul>
            </div>

            <!-- Info -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 mb-3 text-sm">ℹ️ Info</h3>
                <ul class="text-xs text-gray-700 space-y-2">
                    <li>• 🔍 Verifikasi URL sebelum simpan</li>
                    <li>• URL tidak boleh duplikat</li>
                    <li>• URL harus valid (http/https)</li>
                    <li>• Posting langsung terupload</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
async function verifyURL() {
    const urlInput = document.getElementById('urlInput').value;
    const verifyMessage = document.getElementById('verifyMessage');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    if (!urlInput) {
        verifyMessage.innerHTML = '<p class="text-red-600">⚠️ Masukkan URL terlebih dahulu</p>';
        return;
    }

    // Check URL format (must start with http:// or https://)
    if (!urlInput.match(/^https?:\/\//i)) {
        verifyMessage.innerHTML = '<p class="text-red-600">❌ URL harus dimulai dengan http:// atau https://</p>';
        submitBtn.disabled = true;
        return;
    }

    try {
        const response = await fetch('{{ route("asn.postings.verify-url") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ url: urlInput })
        });

        const data = await response.json();

        if (response.ok) {
            verifyMessage.innerHTML = '<p class="text-green-600">✅ ' + data.message + '</p>';
            submitBtn.disabled = false;
        } else {
            verifyMessage.innerHTML = '<p class="text-red-600">❌ ' + data.message + '</p>';
            submitBtn.disabled = true;
        }
    } catch (error) {
        verifyMessage.innerHTML = '<p class="text-red-600">❌ Error verifikasi URL</p>';
        submitBtn.disabled = true;
    }
}
</script>
@endsection
