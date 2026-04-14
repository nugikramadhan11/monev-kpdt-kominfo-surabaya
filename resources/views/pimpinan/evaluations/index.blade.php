@extends('layouts.app')

@section('title', 'Monitoring & Evaluasi ASN')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Monitoring & Evaluasi ASN</h1>
            <p class="text-sm text-gray-500 mt-1">Target ON_TARGET: 4 postingan | Max Progress: 10 postingan</p>
        </div>
        <form action="{{ route('pimpinan.run-flagging') }}" method="POST" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-4 sm:px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                🚀 Run Auto-Flagging
            </button>
        </form>
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-50 to-blue-25 border-b border-gray-200">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">ASN</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Wilayah</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Postingan</th>
                    <th class="px-4 sm:px-6 py-3 text-center text-xs sm:text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-4 sm:px-6 py-3 text-center text-xs sm:text-sm font-semibold text-gray-900">Evaluasi</th>
                    <th class="px-4 sm:px-6 py-3 text-right text-xs sm:text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($asnUsers as $asn)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                            <div class="font-medium text-gray-900">{{ $asn->name }}</div>
                            <div class="text-xs text-gray-500">{{ $asn->nip ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-700">
                            {{ $asn->wilayah->name ?? 'N/A' }}
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-bold text-blue-600">{{ $asn->posting_count_this_month ?? 0 }}</span>
                                <span class="text-xs text-gray-500">/10</span>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                            @if($asn->status === 'ON_TARGET')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ On Target</span>
                            @elseif($asn->status === 'AT_RISK')
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">⚠ At Risk</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">✗ Below Target</span>
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                            @php $eval = $evaluations->get($asn->id); @endphp
                            @if($eval && $eval->status === 'EVALUATED')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ Done</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">⏳ Pending</span>
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 text-right">
                            <a href="{{ route('pimpinan.evaluations.show', $asn) }}" class="text-blue-600 hover:text-blue-800 font-medium text-xs sm:text-sm">
                                Review →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 sm:px-6 py-12 text-center text-gray-500">
                            Tidak ada ASN untuk dievaluasi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Card View --}}
    <div class="md:hidden space-y-3">
        @forelse($asnUsers as $asn)
            <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $asn->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $asn->nip ?? 'N/A' }}</p>
                    </div>
                    @if($asn->status === 'ON_TARGET')
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">✓ On Target</span>
                    @elseif($asn->status === 'AT_RISK')
                        <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs font-medium">⚠ At Risk</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">✗ Below Target</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="bg-white rounded p-3 border border-blue-100">
                        <p class="text-xs text-gray-500">Postingan</p>
                        <p class="text-xl font-bold text-blue-600">{{ $asn->posting_count_this_month ?? 0 }}<span class="text-xs text-gray-400">/10</span></p>
                    </div>
                    <div class="bg-white rounded p-3 border border-blue-100">
                        <p class="text-xs text-gray-500">Evaluasi</p>
                        @php $eval = $evaluations->get($asn->id); @endphp
                        @if($eval && $eval->status === 'EVALUATED')
                            <p class="text-lg text-green-600">✓ Done</p>
                        @else
                            <p class="text-lg text-amber-600">⏳ Pending</p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('pimpinan.evaluations.show', $asn) }}" class="block w-full px-3 py-2 bg-blue-600 text-white text-center rounded text-sm font-medium hover:bg-blue-700 transition">
                    Review →
                </a>
            </div>
        @empty
            <div class="bg-white rounded-lg border border-gray-200 p-6 text-center text-gray-500">
                Tidak ada ASN untuk dievaluasi
            </div>
        @endforelse
    </div>
</div>
@endsection
