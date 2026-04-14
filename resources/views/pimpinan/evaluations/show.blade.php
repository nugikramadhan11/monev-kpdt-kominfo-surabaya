@extends('layouts.app')

@section('title', 'Evaluasi ' . $asn->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('pimpinan.evaluations.index') }}" class="text-blue-600 hover:text-blue-800 font-medium mb-6 inline-flex items-center gap-1">
        ← Kembali
    </a>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $asn->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">NIP: {{ $asn->nip ?? 'N/A' }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($asn->is_flagged)
                        <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold">🚩 FLAGGED</span>
                    @else
                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">✓ OK</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-4 sm:p-6">
            {{-- Statistics --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 p-4 sm:p-6 rounded-lg">
                    <p class="text-xs sm:text-sm text-gray-500 mb-2">Total Postingan</p>
                    <p class="text-3xl sm:text-4xl font-bold text-blue-600">{{ $postings->count() }}</p>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Target ON_TARGET: 4 postingan</p>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-white border border-amber-200 p-4 sm:p-6 rounded-lg">
                    <p class="text-xs sm:text-sm text-gray-500 mb-2">Bulan</p>
                    <p class="text-xl sm:text-2xl font-bold text-amber-600">{{ $evaluation->evaluation_month?->format('M Y') ?? 'N/A' }}</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-white border border-purple-200 p-4 sm:p-6 rounded-lg">
                    <p class="text-xs sm:text-sm text-gray-500 mb-2">Status Evaluasi</p>
                    @if($evaluation->status === 'EVALUATED')
                        <p class="text-lg sm:text-xl font-bold text-green-600">✓ Selesai</p>
                    @else
                        <p class="text-lg sm:text-xl font-bold text-amber-600">⏳ Pending</p>
                    @endif
                </div>
            </div>

            {{-- Pilar Breakdown --}}
            @if($pilarBreakdown->isNotEmpty())
                <div class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-200 rounded-lg p-4 sm:p-6 mb-8">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4">📊 Breakdown Pilar</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($pilarBreakdown as $item)
                            <div class="bg-white border-l-4 border-indigo-500 p-3 rounded">
                                <p class="text-xs text-gray-500 font-medium">{{ $item['pilar']->name ?? 'Unknown' }}</p>
                                <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $item['count'] }}x</p>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-600 mt-3 p-2 bg-indigo-100 border border-indigo-200 rounded">
                        💡 Petunjuk: Jika ada pilar yang dominan, berikan rekomendasi agar bulan depan diversifikasi ke pilar lain.
                    </p>
                </div>
            @endif

            {{-- Postings List --}}
            @if($postings->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4">📋 Daftar Postingan Bulan Ini</h3>
                    <div class="space-y-2">
                        @foreach($postings as $posting)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 sm:p-4 hover:bg-gray-100 transition">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $posting->pilar->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $posting->posted_date->format('d M Y') }} • {{ $posting->platform }}</p>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        @if($posting->status === 'VERIFIED')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">✓ Verified</span>
                                        @else
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">⏳ {{ $posting->status }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 sm:p-6 mb-8">
                    <p class="text-sm text-yellow-800">⚠️ Tidak ada postingan terverifikasi bulan ini.</p>
                </div>
            @endif

            {{-- Evaluation Feedback Form --}}
            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">💬 Feedback & Rekomendasi</h2>
                <p class="text-sm text-gray-600 mb-4">Berikan coaching untuk perbaikan di bulan depan</p>

                <form action="{{ route('pimpinan.evaluations.update', $asn) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-3">
                            Pesan untuk {{ $asn->name }}
                        </label>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                            <p class="text-xs text-blue-800 font-semibold">💡 Contoh feedback:</p>
                            <ul class="text-xs text-blue-700 mt-2 space-y-1 ml-2">
                                <li>• "Target tercapai! Pertahankan konsistensi di bulan depan"</li>
                                <li>• "Bagus sudah 4 postingan, tapi semua pilar sama. Coba diversifikasi."</li>
                                <li>• "Kurang 1 postingan. Tingkatkan effort dan manfaatkan berbagai platform."</li>
                            </ul>
                        </div>
                        <textarea
                            id="notes"
                            name="notes"
                            rows="5"
                            placeholder="Tulis feedback/coaching untuk ASN ini..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent resize-none">{{ old('notes', $evaluation->notes ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Maksimal 1000 karakter</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="flex-1 px-4 sm:px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            💾 Kirim Feedback
                        </button>
                        <a href="{{ route('pimpinan.evaluations.index') }}" class="flex-1 px-4 sm:px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            {{-- Feedback sent info --}}
            @if($evaluation->evaluated_by)
                <div class="mt-8 p-4 sm:p-6 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-sm font-semibold text-green-900 mb-2">✓ Feedback Terkirim</p>
                            <p class="text-sm text-green-800">{{ $evaluation->notes?: 'Tidak ada catatan' }}</p>
                            <p class="text-xs text-green-600 mt-2">Oleh: {{ $evaluation->evaluatedBy?->name ?? 'System' }} • {{ $evaluation->updated_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-green-200">
                        <form action="{{ route('pimpinan.evaluations.clear-feedback', $asn) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-semibold hover:bg-red-200 transition text-sm" onclick="return confirm('Hapus feedback ini? ASN akan melihat evaluasi reset ke status menunggu.');">
                                🗑️ Hapus Feedback
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
