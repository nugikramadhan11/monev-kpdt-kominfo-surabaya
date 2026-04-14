@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Notifikasi</h1>
                <p class="text-gray-600 text-base">Kelola semua notifikasi dan feedback Anda di sini</p>
            </div>
            @if($notifications->count() > 0)
            <div class="flex gap-2">
                <form action="{{ route('asn.notifications.mark-all-read') }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-medium text-sm hover:bg-blue-200 transition">
                        ✓ Tandai Semua Dibaca
                    </button>
                </form>
                <form action="{{ route('asn.notifications.delete-all') }}" method="POST" class="inline" onsubmit="return confirm('Hapus semua notifikasi?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-medium text-sm hover:bg-red-200 transition">
                        🗑️ Hapus Semua
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Notifications Grid -->
    @forelse($notifications as $notification)
        <div class="bg-white rounded-xl p-6 sm:p-7 shadow-md border border-gray-100 mb-4 hover:shadow-lg transition {{ !$notification->is_read ? 'border-l-4' : '' }}" style="{{ !$notification->is_read ? 'border-left-color: var(--tw-border-opacity); border-left-width: 4px; --tw-border-opacity: 1; border-left-color: rgb(59, 130, 246);' : '' }}">
            <div class="flex items-start gap-4">
                <!-- Icon -->
                <span class="text-4xl flex-shrink-0">{{ $notification->icon }}</span>

                <!-- Content -->
                <div class="flex-1">
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $notification->title }}</h3>
                            <p class="text-gray-600 text-sm mt-2 leading-relaxed">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-3">
                                📅 {{ $notification->created_at->format('d M Y H:i') }}
                                <span class="mx-2">•</span>
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex-shrink-0">
                            @if(!$notification->is_read)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    • Belum Dibaca
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    ✓ Dibaca
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex gap-2">
                        @if($notification->action_url)
                            <a href="{{ $notification->action_url }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg font-medium text-sm hover:bg-blue-700 transition">
                                Lihat Detail →
                            </a>
                        @endif

                        @if(!$notification->is_read)
                            <form action="{{ route('asn.notifications.read', $notification) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium text-sm hover:bg-gray-200 transition">
                                    ✓ Tandai Dibaca
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('asn.notifications.delete', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Hapus notifikasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg font-medium text-sm hover:bg-red-200 transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl p-12 sm:p-16 shadow-md border border-gray-100 text-center">
            <span class="text-6xl mb-4 inline-block">🔔</span>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Tidak Ada Notifikasi</h3>
            <p class="text-gray-600 mb-6">Anda tidak memiliki notifikasi saat ini. Notifikasi akan muncul ketika ada flagging atau feedback dari pimpinan.</p>
            <a href="{{ route('asn.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                Kembali ke Dashboard
            </a>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
