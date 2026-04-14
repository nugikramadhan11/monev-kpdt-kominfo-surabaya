@extends('layouts.app')

@section('title', 'Dashboard ASN')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Selamat Datang, {{ $user->name }}</h1>
        <p class="text-gray-600 text-base">Pantau progress posting Anda dan raih target bulanan</p>
    </div>

    <!-- Stats Grid - Responsive -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 mb-10">
        <!-- Posting Bulan Ini -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 sm:p-7 shadow-md hover:shadow-lg transition border border-blue-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Posting Bulan Ini</p>
                    <p class="text-3xl sm:text-4xl font-bold text-blue-600 mt-2">{{ $verifiedCount }}<span class="text-lg sm:text-xl text-gray-400 font-normal">/10</span></p>
                </div>
                <span class="text-3xl sm:text-4xl">📝</span>
            </div>
            <div class="w-full bg-blue-100 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full transition-all" style="width: {{ ($verifiedCount / 10) * 100 }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-3">{{ max(0, 10 - $verifiedCount) }} posting lagi</p>
        </div>

        <!-- Status -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 sm:p-7 shadow-md hover:shadow-lg transition border border-blue-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Status Bulanan</p>
                    <p class="text-2xl sm:text-3xl font-bold {{ $status === 'ON_TARGET' ? 'text-green-600' : ($status === 'AT_RISK' ? 'text-amber-600' : 'text-red-600') }} mt-2">
                        {{ $status === 'ON_TARGET' ? 'ON TARGET' : ($status === 'AT_RISK' ? 'AT RISK' : 'OFF TARGET') }}
                    </p>
                </div>
                <span class="text-3xl sm:text-4xl">{{ $status === 'ON_TARGET' ? '✓' : ($status === 'AT_RISK' ? '⚠️' : '✗') }}</span>
            </div>
            <p class="text-xs text-gray-500 mt-4">
                {{ $status === 'ON_TARGET' ? '✓ Target bulanan tercapai' : ($status === 'AT_RISK' ? '⚠️ Tingkatkan posting' : '✗ Perbaiki progress') }}
            </p>
        </div>

        <!-- Pilar Digunakan -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 sm:p-7 shadow-md hover:shadow-lg transition border border-blue-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pilar Digunakan</p>
                    <p class="text-3xl sm:text-4xl font-bold text-blue-600 mt-2">{{ $pilarsUsed->count() }}</p>
                </div>
                <span class="text-3xl sm:text-4xl">🏷️</span>
            </div>
        </div>

        <!-- Skor Sementara -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 sm:p-7 shadow-md hover:shadow-lg transition border border-blue-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Skor Sementara</p>
                    <p class="text-3xl sm:text-4xl font-bold text-blue-600 mt-2">{{ $score }}<span class="text-lg sm:text-xl text-gray-400 font-normal">/100</span></p>
                </div>
                <span class="text-3xl sm:text-4xl">⭐</span>
            </div>
            <div class="w-full bg-blue-100 rounded-full h-2.5">
                <div class="bg-amber-500 h-2.5 rounded-full transition-all" style="width: {{ $score }}%"></div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-10 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('asn.postings.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-lg font-semibold text-sm transition hover:opacity-90 shadow-md" style="background-color: #041beb;">
            ➕ Input Posting
        </a>
        <a href="{{ route('asn.postings.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 rounded-lg font-semibold text-sm transition hover:bg-blue-50 shadow-sm" style="border-color: #041beb; color: #041beb;">
            📋 Lihat Semua
        </a>
    </div>

    <!-- Postings Table - Responsive -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <!-- Table Header -->
        <div class="border-b border-gray-200 p-6 sm:p-7 bg-gradient-to-r from-blue-50 to-white">
            <h2 class="text-xl font-bold text-gray-900">Riwayat Posting Bulan Ini</h2>
            <p class="text-sm text-gray-600 mt-2">Total: <strong>{{ $postings->count() }}</strong> posting</p>
        </div>

        @if($postings->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Platform</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Pilar</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Engagement</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($postings as $posting)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-platform-icon :platform="$posting->platform" size="w-4 h-4" />
                                        <span class="font-medium text-gray-900 text-sm">{{ $posting->platform }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded text-xs font-medium">{{ $posting->pilar->hashtag }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-3">
                                        <span>👍 {{ $posting->engagement->likes ?? 0 }}</span>
                                        <span>💬 {{ $posting->engagement->comments ?? 0 }}</span>
                                        <span class="hidden sm:inline">📤 {{ $posting->engagement->shares ?? 0 }}</span>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-xs sm:text-sm">
                                    @if($posting->status === 'VERIFIED')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">✓ Verifikasi</span>
                                    @elseif($posting->status === 'PENDING')
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-medium">⏳ Menunggu</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">✗ Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-4">
                                    <a href="{{ route('asn.postings.show', $posting) }}" class="text-blue-600 hover:text-blue-700 font-medium text-xs sm:text-sm">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-200">
                @forelse($postings as $posting)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-medium text-gray-900 text-sm flex items-center gap-2">
                                    <x-platform-icon :platform="$posting->platform" size="w-4 h-4" />
                                    {{ $posting->platform }}
                                </p>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium inline-block mt-1">{{ $posting->pilar->hashtag }}</span>
                            </div>
                            @if($posting->status === 'VERIFIED')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">✓</span>
                            @elseif($posting->status === 'PENDING')
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-medium">⏳</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">✗</span>
                            @endif
                        </div>
                        <div class="flex gap-3 mb-3 text-xs text-gray-600">
                            <span>👍 {{ $posting->engagement->likes ?? 0 }}</span>
                            <span>💬 {{ $posting->engagement->comments ?? 0 }}</span>
                            <span>📤 {{ $posting->engagement->shares ?? 0 }}</span>
                        </div>
                        <a href="{{ route('asn.postings.show', $posting) }}" class="text-blue-600 hover:text-blue-700 font-medium text-xs">
                            Lihat Detail →
                        </a>
                    </div>
                @empty
                @endforelse
            </div>
        @else
            <!-- Empty State -->
            <div class="p-8 sm:p-12 text-center">
                <p class="text-gray-500 text-sm font-medium">Belum ada posting</p>
                <p class="text-gray-400 text-xs sm:text-sm mt-1">Mulai submit posting untuk mencapai target</p>
                <a href="{{ route('asn.postings.create') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition">
                    ➕ Input Posting
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
