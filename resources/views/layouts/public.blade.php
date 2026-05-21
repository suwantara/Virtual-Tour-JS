<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    @if ($metaDescription ?? null)
        <meta name="description" content="{{ $metaDescription }}">
    @endif

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $ogTitle ?? $title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $ogDescription ?? $metaDescription ?? '' }}">
    <meta property="og:url" content="{{ $canonicalUrl ?? url()->current() }}">
    @if ($ogImage ?? null)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ ($ogImage ?? null) ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $ogTitle ?? $title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? $metaDescription ?? '' }}">
    @if ($ogImage ?? null)
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @stack('styles')
</head>
<body class="antialiased bg-stone-950 text-stone-100" style="font-family: 'Inter', sans-serif;">
    {{ $slot }}

    @livewireScripts
    @stack('scripts')
</body>
</html>
