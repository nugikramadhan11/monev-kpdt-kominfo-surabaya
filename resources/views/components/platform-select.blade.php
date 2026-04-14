@props(['value' => '', 'name' => 'platform', 'required' => true])

@php
$platforms = [
    'Instagram' => 'instagram',
    'TikTok' => 'tiktok',
    'YouTube' => 'youtube',
    'Facebook' => 'facebook',
];
@endphp

<div class="relative" x-data="{ open: false, selected: '{{ $value }}' }">
    <!-- Hidden Input untuk menyimpan nilai -->
    <input type="hidden" name="{{ $name }}" :value="selected" {{ $required ? 'required' : '' }}>

    <!-- Tombol Dropdown -->
    <button type="button" 
        @click="open = !open"
        @click.outside="open = false"
        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm bg-white text-left flex items-center justify-between hover:border-gray-400 transition">
        
        <span class="flex items-center gap-2">
            @if($value && array_key_exists($value, $platforms))
                <img src="{{ asset('images/icons/' . $platforms[$value] . '.svg') }}" alt="{{ $value }}" class="w-4 h-4">
                <span>{{ $value }}</span>
            @else
                <span class="text-gray-500">-- Pilih Platform --</span>
            @endif
        </span>

        <svg class="w-4 h-4 text-gray-600 transition" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
        @click.outside="open = false"
        class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-10"
        style="">
        
        <!-- Pilihan kosong -->
        <button type="button"
            @click="selected = ''; open = false"
            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-left text-sm text-gray-500 hover:bg-gray-100 transition border-b border-gray-200">
            -- Pilih Platform --
        </button>

        <!-- Platform options -->
        @foreach($platforms as $platformName => $platformIcon)
            <button type="button"
                @click="selected = '{{ $platformName }}'; open = false"
                :class="{ 'bg-blue-50 border-l-4 border-blue-600': selected === '{{ $platformName }}' }"
                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-left text-sm hover:bg-gray-100 transition flex items-center gap-3 border-b border-gray-100 last:border-b-0">
                
                <img src="{{ asset('images/icons/' . $platformIcon . '.svg') }}" alt="{{ $platformName }}" class="w-5 h-5">
                <span class="font-medium">{{ $platformName }}</span>
            </button>
        @endforeach
    </div>
</div>
