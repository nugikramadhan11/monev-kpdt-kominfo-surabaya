@props(['platform' => 'Instagram', 'size' => 'w-5 h-5'])

@php
// Normalize platform name to match our icon files
$platformLower = strtolower($platform);
$platformMap = [
    'instagram' => 'instagram',
    'tiktok' => 'tiktok',
    'youtube' => 'youtube',
    'facebook' => 'facebook',
];

// Handle various formats: Instagram, instagram, TikTok, tiktok, etc
$normalized = match($platformLower) {
    'tiktok', 'tik tok', 'tik-tok' => 'tiktok',
    'youtube', 'you tube', 'you-tube' => 'youtube',
    'instagram', 'ig' => 'instagram',
    'facebook', 'fb' => 'facebook',
    default => $platformMap[$platformLower] ?? 'instagram'
};

$icon = asset("images/icons/{$normalized}.svg");
@endphp

<img src="{{ $icon }}" alt="{{ $platform }}" class="{{ $size }}" title="{{ $platform }}">
