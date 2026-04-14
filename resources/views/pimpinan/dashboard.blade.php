@extends('layouts.app')

@section('title', 'Monitoring - Pimpinan')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Monitoring</h1>
        <p class="text-gray-600 text-base">Bulan: {{ $currentMonth->format('Y-m') }} • Target ON_TARGET: 4 posting | Progress Bar: 0-10 postingan</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl p-6 sm:p-7 shadow-md border border-gray-100 mb-8">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Filter OPD</label>
                    <select name="opd_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="">Semua</option>
                        @foreach($opds as $opd)
                            <option value="{{ $opd->id }}" {{ $selectedOPD == $opd->id ? 'selected' : '' }}>{{ $opd->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Filter Kecamatan</label>
                    <select name="wilayah_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="">Semua</option>
                        @foreach($wilayahs as $wilayah)
                            <option value="{{ $wilayah->id }}" {{ $selectedWilayah == $wilayah->id ? 'selected' : '' }}>{{ $wilayah->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    @if($selectedOPD || $selectedWilayah)
                        <a href="{{ route('pimpinan.dashboard') }}" class="w-full px-4 py-2.5 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg font-semibold text-sm transition text-center">
                            Reset Filter
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 mb-10">
        <div class="bg-gradient-to-br from-green-50 to-white border border-green-100 rounded-xl p-6 sm:p-7 shadow-md hover:shadow-lg transition">
            <div class="text-3xl sm:text-4xl font-bold text-green-600 mb-2">{{ $onTarget }}</div>
            <p class="text-sm text-gray-600 font-medium">On Target</p>
        </div>
        <div class="bg-gradient-to-br from-amber-50 to-white border border-amber-100 rounded-xl p-6 sm:p-7 shadow-md hover:shadow-lg transition">
            <div class="text-3xl sm:text-4xl font-bold text-amber-600 mb-2">{{ $atRisk }}</div>
            <p class="text-sm text-gray-600 font-medium">At Risk</p>
        </div>
        <div class="bg-gradient-to-br from-red-50 to-white border border-red-100 rounded-xl p-6 sm:p-7 shadow-md hover:shadow-lg transition">
            <div class="text-3xl sm:text-4xl font-bold text-red-600 mb-2">{{ $belowTarget }}</div>
            <p class="text-sm text-gray-600 font-medium">Below Target</p>
        </div>
        <div class="flex items-center">
            <a href="{{ route('pimpinan.evaluations.index') }}" class="w-full inline-block text-white px-6 py-3 rounded-lg font-semibold text-sm transition text-center hover:opacity-90 shadow-md" style="background-color: #041beb;">
                📊 Monitoring & Evaluasi
            </a>
        </div>
    </div>

    <!-- ASN Status Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-md overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gradient-to-r from-blue-50 to-white border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold text-gray-900">ASN</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-900">OPD</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-900">Kecamatan</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-900">Progress</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-900">Skor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($asnStats as $stat)
                    @php
                        $postings = $stat['postings'];
                        $score = ($postings * 10) + min($stat['asn']->postings()
                            ->whereYear('created_at', $currentMonth->year)
                            ->whereMonth('created_at', $currentMonth->month)
                            ->where('status', 'VERIFIED')
                            ->with('engagement')
                            ->get()
                            ->sum(fn($p) => $p->engagement?->getTotalEngagement() ?? 0), 30);
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">{{ $stat['asn']->name }}</td>
                        <td class="px-4 sm:px-6 py-4 text-gray-700">{{ $stat['asn']->opd->name ?? '-' }}</td>
                        <td class="px-4 sm:px-6 py-4 text-gray-700">{{ $stat['asn']->wilayah->name ?? '-' }}</td>
                        <td class="px-4 sm:px-6 py-4">
                            <span class="text-sm font-medium">{{ $postings }}/10</span>
                        </td>
                        <td class="px-4 sm:px-6 py-4">
                            @if($stat['status'] === 'ON_TARGET')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ On Target</span>
                            @elseif($stat['status'] === 'AT_RISK')
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">⚠ At Risk</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">✗ Below Target</span>
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-4 font-semibold text-gray-900">{{ min($score, 100) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">Tidak ada ASN</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Top Engagement Postings (Desktop) -->
    <div class="hidden md:block bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mt-6">
        <div class="p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900">Top Engagement Postings</h2>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">ASN</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Platform</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Engagement</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($topPostings as $posting)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">{{ $posting->user->name }}</td>
                        <td class="px-4 sm:px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-platform-icon :platform="$posting->platform" size="w-4 h-4" />
                                <span class="text-sm text-gray-700">{{ $posting->platform }}</span>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">
                            👍 {{ $posting->engagement->likes ?? 0 }}
                            💬 {{ $posting->engagement->comments ?? 0 }}
                            📤 {{ $posting->engagement->shares ?? 0 }}
                            = <span class="font-bold">{{ $posting->engagement?->getTotalEngagement() ?? 0 }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada posting verified</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Top Engagement Postings (Mobile) -->
    <div class="md:hidden space-y-3 mt-6">
        <h3 class="text-lg font-bold text-gray-900">Top Engagement Postings</h3>
        @forelse($topPostings as $posting)
            <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 rounded-lg p-4 shadow-sm">
                <p class="font-medium text-gray-900 text-sm mb-2">{{ $posting->user->name }}</p>
                <p class="text-sm font-medium text-gray-900 flex items-center gap-2">
                    <x-platform-icon :platform="$posting->platform" size="w-4 h-4" />
                    {{ $posting->platform }}
                </p>
                <div class="text-xs text-gray-700 bg-white p-2 rounded border border-blue-100 mt-2">
                    👍 {{ $posting->engagement->likes ?? 0 }} | 💬 {{ $posting->engagement->comments ?? 0 }} | 📤 {{ $posting->engagement->shares ?? 0 }} = <span class="font-bold">{{ $posting->engagement?->getTotalEngagement() ?? 0 }}</span>
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-lg p-4 text-center text-gray-500 text-sm">Belum ada posting verified</div>
        @endforelse
    </div>
</div>
@endsection
