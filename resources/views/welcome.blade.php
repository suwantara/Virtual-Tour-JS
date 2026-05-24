<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Virtual Tour — Pura Desa Adat Tambawu' }}</title>

    <meta name="description" content="{{ $siteDescription }}">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $siteDescription }}">
    <meta property="og:url" content="{{ $siteUrl }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $siteDescription }}">

    <link rel="canonical" href="{{ $siteUrl }}">
    <link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml">
    <link rel="icon" href="/favicon.ico?v=2" sizes="any">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


</head>
<body class="bg-stone-950 text-stone-100">

{{-- ═══════════════════════════════ NAVBAR ═══════════════════════════════ --}}
<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40; })"
    :class="scrolled ? 'bg-stone-950/95 backdrop-blur-md shadow-lg shadow-black/30' : 'bg-transparent'"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
>
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="#hero" class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full border border-stone-600 flex items-center justify-center">
                <svg class="w-4 h-4 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582" />
                </svg>
            </div>
            <div class="leading-tight">
                <div class="text-xs text-stone-500 font-light tracking-widest uppercase">{{ $navbarSiteNameTop }}</div>
                <div class="text-sm font-semibold text-stone-200 serif tracking-wide">{{ $navbarSiteNameBottom }}</div>
            </div>
        </a>

        {{-- Desktop links --}}
        <div class="hidden md:flex items-center gap-8">
            @foreach([
                ['#hero',         'Beranda'],
                ['#tentang-pura', 'Tentang Pura'],
                ['#virtual-tour', 'Virtual Tour'],
                ['#pelinggih',    'Pelinggih'],
                ['#tim',          'Tim'],
                ['#kontak',       'Kontak'],
            ] as [$href, $label])
                <a href="{{ $href }}" class="nav-link text-sm text-stone-400 hover:text-stone-200 transition-colors">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Desktop CTA --}}
        @if($venues->isNotEmpty())
            <a href="{{ route('tour', $venues->first()) }}"
               class="hidden md:inline-flex items-center gap-2 bg-rose-900 hover:bg-rose-800 text-white text-sm font-medium px-4 py-2 rounded-full transition-all duration-200">
                <i class="fa-solid fa-play text-xs"></i>
                Mulai Tour
            </a>
        @else
            <div class="hidden md:block"></div>
        @endif

        {{-- Mobile hamburger --}}
        <button
            type="button"
            @click="open = true"
            aria-label="Open menu"
            class="md:hidden -m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-stone-300"
        >
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
    </nav>

    {{-- ── Mobile drawer ── --}}
    <div x-show="open" class="md:hidden" role="dialog" aria-modal="true" style="display: none;">

        {{-- Backdrop --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="open = false"
            class="fixed inset-0 z-50 bg-stone-950/60 backdrop-blur-sm"
        ></div>

        {{-- Slide-in panel --}}
        <div
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-stone-950 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-stone-700/30"
        >
            {{-- Panel header --}}
            <div class="flex items-center justify-between">
                <a href="#hero" @click="open = false" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full border border-stone-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582" />
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-xs text-stone-500 font-light tracking-widest uppercase">Pura Desa</div>
                        <div class="text-sm font-semibold text-stone-200 serif tracking-wide">Tambawu</div>
                    </div>
                </a>
                <button
                    type="button"
                    @click="open = false"
                    aria-label="Close menu"
                    class="-m-2.5 rounded-md p-2.5 text-stone-300"
                >
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Panel links --}}
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-stone-800">
                    <div class="space-y-1 py-6">
                        @foreach([
                            ['#hero',         'Beranda'],
                            ['#tentang-pura', 'Tentang Pura'],
                            ['#virtual-tour', 'Virtual Tour'],
                            ['#pelinggih',    'Pelinggih'],
                            ['#tim',          'Tim'],
                            ['#kontak',       'Kontak'],
                        ] as [$href, $label])
                            <a
                                href="{{ $href }}"
                                @click="open = false"
                                class="-mx-3 block rounded-lg px-3 py-3 text-base font-semibold text-stone-300 hover:bg-stone-800 hover:text-stone-100 transition-colors"
                            >
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                    @if($venues->isNotEmpty())
                        <div class="py-6">
                            <a
                                href="{{ route('tour', $venues->first()) }}"
                                @click="open = false"
                                class="-mx-3 flex items-center justify-center gap-2 rounded-lg px-3 py-3 text-base font-semibold text-white bg-rose-900 hover:bg-rose-800 transition-colors"
                            >
                                <i class="fa-solid fa-play text-sm"></i>
                                Mulai Virtual Tour
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

{{-- ═══════════════════════════════ HERO ═══════════════════════════════ --}}
<section id="hero" class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0 bg-stone-950">
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full"
             style="background: radial-gradient(circle, rgba(68,64,60,0.35) 0%, transparent 70%);"></div>
        <div class="absolute top-20 left-8 w-16 h-16 border-t border-l border-stone-700/30"></div>
        <div class="absolute top-20 right-8 w-16 h-16 border-t border-r border-stone-700/30"></div>
        <div class="absolute bottom-20 left-8 w-16 h-16 border-b border-l border-stone-700/30"></div>
        <div class="absolute bottom-20 right-8 w-16 h-16 border-b border-r border-stone-700/30"></div>
    </div>

    <div class="relative z-10 text-center px-4 sm:px-6 max-w-4xl mx-auto w-full">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-stone-800/60 border border-amber-700/30 text-amber-300 font-medium px-3 sm:px-4 py-1.5 rounded-full mb-8 uppercase" style="font-size: clamp(9px, 2vw, 12px); letter-spacing: 0.08em;">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse flex-shrink-0"></span>
            <span>{{ $heroBadge }}</span>
        </div>

        {{-- Kaligrafi --}}
        <div class="text-stone-600 text-sm tracking-[0.5em] uppercase mb-3 font-light" aria-hidden="true">
            {{ $heroKaligrafi }}
        </div>

        {{-- Title --}}
        <h1 class="serif text-4xl sm:text-5xl md:text-7xl font-bold text-stone-50 mb-2 leading-tight">
            {{ $heroTitleMain }}
        </h1>
        <h2 class="serif text-2xl sm:text-3xl md:text-5xl font-light text-amber-400 mb-6 italic">
            {{ $heroTitleSub }}
        </h2>

        {{-- Garis ornamen --}}
        <div class="flex items-center justify-center gap-3 mb-6">
            <div class="w-16 h-px bg-stone-600/50"></div>
            <svg class="w-4 h-4 text-stone-600" viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 0l1.5 6.5L16 8l-6.5 1.5L8 16l-1.5-6.5L0 8l6.5-1.5z"/>
            </svg>
            <div class="w-16 h-px bg-stone-600/50"></div>
        </div>

        {{-- Subtitle --}}
        <p class="text-stone-400 text-base sm:text-lg md:text-xl leading-relaxed max-w-2xl mx-auto mb-10 font-light">
            {!! $heroSubtitle !!}
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($venues->isNotEmpty())
                <a href="{{ route('tour', $venues->first()) }}"
                   class="inline-flex items-center justify-center gap-3 bg-rose-900 hover:bg-rose-800 text-white font-semibold px-8 py-3.5 rounded-full transition-all duration-200 group">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 010 1.972l-11.54 6.347a1.125 1.125 0 01-1.667-.986V5.653z"/>
                    </svg>
                    Mulai Virtual Tour
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @endif
            <a href="#tentang-pura"
               class="inline-flex items-center justify-center gap-2 border border-stone-600/60 text-stone-300 hover:bg-stone-800 font-medium px-8 py-3.5 rounded-full transition-all duration-200">
                Pelajari Lebih Lanjut
            </a>
        </div>

        {{-- Scroll hint --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-stone-600 text-xs animate-bounce" aria-hidden="true">
            <span class="tracking-widest uppercase text-[10px]">Gulir</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
            </svg>
        </div>
    </div>
</section>

{{-- ════════════════════════════ TENTANG PURA ════════════════════════════ --}}
<section id="tentang-pura" class="bg-stone-100 text-stone-900 py-16 md:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- Section header --}}
        <div class="text-center mb-16">
            <p class="text-stone-600 text-xs tracking-widest uppercase font-medium mb-3">{{ $tentangSectionLabel }}</p>
            <h2 class="serif text-3xl sm:text-4xl md:text-5xl font-bold text-stone-900 mb-4">{{ $tentangSectionTitle }}</h2>
            <div class="ornament text-stone-600 max-w-xs mx-auto">
                <span class="text-sm font-light">{{ $tentangSectionOrnament }}</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start">

            {{-- Sejarah --}}
            <div>
                <h3 class="serif text-2xl font-semibold text-stone-900 mb-4">{{ $tentangSejarahTitle }}</h3>
                <div class="w-10 h-0.5 bg-stone-700 mb-6"></div>

                <div class="space-y-4 text-stone-700 leading-relaxed">
                    @foreach($tentangParagraphs as $para)
                        <p>{!! $para['text'] ?? $para !!}</p>
                    @endforeach
                </div>
            </div>

            {{-- Stats --}}
            <div class="space-y-4">
                @foreach($tentangStats as $stat)
                    <div class="flex items-start gap-4 bg-white/60 border border-stone-200 rounded-2xl p-5 card-lift">
                        <div class="w-10 h-10 rounded-xl bg-rose-900 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-2">
                                <span class="serif text-xl font-bold text-stone-900">{{ $stat['value'] ?? '' }}</span>
                                <span class="text-sm font-semibold text-stone-700">{{ $stat['label'] ?? '' }}</span>
                            </div>
                            <p class="text-xs text-stone-600 mt-0.5">{{ $stat['desc'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════ VIRTUAL TOUR CTA ════════════════════════ --}}
<section id="virtual-tour" class="bg-stone-900 py-16 md:py-28 relative overflow-hidden">

    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-80 h-80 rounded-full border border-stone-700/20 opacity-30 hidden sm:block"></div>
    <div class="absolute right-16 top-1/2 -translate-y-1/2 w-52 h-52 rounded-full border border-stone-700/20 opacity-30 hidden sm:block"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            {{-- Teks --}}
            <div>
                <p class="text-amber-400 text-xs tracking-widest uppercase font-medium mb-4">{{ $tourCtaSectionLabel }}</p>
                <h2 class="serif text-3xl sm:text-4xl md:text-5xl font-bold text-stone-50 mb-6 leading-tight">
                    {{ $tourCtaTitle }}<br>
                    <span class="text-amber-400 italic">{{ $tourCtaAccent }}</span>
                </h2>
                <p class="text-stone-400 leading-relaxed mb-8">
                    {{ $tourCtaDescription }}
                </p>

                <div class="flex flex-wrap gap-3 mb-8">
                    @foreach($tourCtaFeatures as $feat)
                    @php $featLabel = $feat['label'] ?? $feat; @endphp
                        <span class="flex items-center gap-1.5 bg-stone-950/40 border border-stone-700/30 text-stone-300 text-xs px-3 py-1.5 rounded-full">
                            <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 0l1.5 6.5L16 8l-6.5 1.5L8 16l-1.5-6.5L0 8l6.5-1.5z"/>
                            </svg>
                            {{ $featLabel }}
                        </span>
                    @endforeach
                </div>

                @if($venues->isNotEmpty())
                    <a href="{{ route('tour', $venues->first()) }}"
                       class="inline-flex items-center gap-3 bg-rose-900 hover:bg-rose-800 text-white font-semibold px-8 py-3.5 rounded-full transition-all duration-200 group">
                        Buka Virtual Tour
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center gap-2 bg-stone-700/30 text-stone-500 text-sm px-8 py-3.5 rounded-full cursor-not-allowed">
                        Segera Hadir
                    </span>
                @endif
            </div>

            {{-- Visual 360° --}}
            <div class="flex justify-center md:justify-end">
                <div class="relative w-48 h-48 sm:w-64 sm:h-64">
                    <div class="absolute inset-0 rounded-full border-2 border-dashed border-stone-600/40 animate-spin" style="animation-duration: 20s;"></div>
                    <div class="absolute inset-6 rounded-full border border-stone-700/30"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="serif text-5xl font-bold text-amber-400">360</div>
                            <div class="text-stone-500 text-xs tracking-widest mt-1">DERAJAT</div>
                        </div>
                    </div>
                    @foreach([0, 60, 120, 180, 240, 300] as $deg)
                        <div class="absolute w-2 h-2 rounded-full bg-stone-600/60"
                             style="
                                top: calc(50% - 4px + {{ round(sin(deg2rad($deg)) * 120, 2) }}px);
                                left: calc(50% - 4px + {{ round(cos(deg2rad($deg)) * 120, 2) }}px);
                             "></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════ PELINGGIH HIGHLIGHT ════════════════════ --}}
<section id="pelinggih" class="bg-stone-950 py-16 md:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-16">
            <p class="text-stone-500 text-xs tracking-widest uppercase font-medium mb-3">{{ $pelinggihSectionLabel }}</p>
            <h2 class="serif text-3xl sm:text-4xl md:text-5xl font-bold text-stone-100 mb-4">{{ $pelinggihSectionTitle }}</h2>
            <p class="text-stone-400 max-w-xl mx-auto text-sm leading-relaxed">
                {{ $pelinggihSectionDescription }}
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($pelinggihItems as $p)
                <div class="pelinggih-card rounded-2xl p-6 card-lift">
                    <div class="w-10 h-10 rounded-xl bg-stone-800 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18"/>
                        </svg>
                    </div>
                    <h3 class="serif text-lg font-semibold text-stone-100 mb-2">{{ $p['nama'] ?? '' }}</h3>
                    <p class="text-stone-400 text-sm leading-relaxed">{{ $p['fungsi'] ?? '' }}</p>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="#virtual-tour"
               class="inline-flex items-center gap-2 border border-stone-700/40 text-stone-500 hover:text-stone-300 hover:border-stone-600/60 text-sm px-6 py-2.5 rounded-full transition-all duration-200">
                Lihat semua dalam Virtual Tour
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════ WIKI CTA ════════════════════════════════ --}}
<section class="bg-stone-950 py-16 md:py-24 border-t border-stone-800/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            {{-- Teks --}}
            <div>
                <p class="text-stone-500 text-xs tracking-widest uppercase font-medium mb-4">{{ $wikiCtaLabel }}</p>
                <h2 class="serif text-3xl sm:text-4xl md:text-5xl font-bold text-stone-50 mb-6 leading-tight">
                    {{ $wikiCtaTitle }}<br>
                    <span class="text-amber-400 italic">{{ $wikiCtaAccent }}</span>
                </h2>
                <p class="text-stone-400 leading-relaxed mb-8">
                    {{ $wikiCtaDescription }}
                </p>

                <div class="flex flex-wrap gap-2 mb-8">
                    @foreach($wikiCtaCategories as $cat)
                        <span class="flex items-center gap-1.5 bg-stone-800/50 border border-stone-700/30 text-stone-400 text-xs px-3 py-1.5 rounded-full">
                            <svg class="w-3 h-3 text-amber-500/80" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cat['icon'] }}"/>
                            </svg>
                            {{ $cat['label'] }}
                        </span>
                    @endforeach
                </div>

                <a href="{{ route('wiki.index') }}"
                   class="inline-flex items-center gap-3 bg-amber-700 hover:bg-amber-600 text-white font-semibold px-8 py-3.5 rounded-full transition-all duration-200 group">
                    Buka Wiki
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            {{-- Visual --}}
            <div class="flex justify-center md:justify-end">
                <div class="relative w-56 h-56 sm:w-72 sm:h-72 flex items-center justify-center overflow-hidden rounded-full">
                    {{-- Outer ring --}}
                    <div class="absolute inset-0 rounded-full border border-dashed border-stone-700/40 animate-spin" style="animation-duration: 30s;"></div>
                    {{-- Inner ring --}}
                    <div class="absolute inset-8 rounded-full border border-stone-800/60"></div>
                    {{-- Center block --}}
                    <div class="relative z-10 text-center space-y-3">
                        <div class="w-14 h-14 rounded-2xl bg-amber-900/40 border border-amber-700/30 flex items-center justify-center mx-auto">
                            <svg class="w-7 h-7 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                        </div>
                        <div class="serif text-amber-400 font-bold text-lg leading-none">Wiki</div>
                        <div class="text-stone-600 text-xs tracking-widest">ENSIKLOPEDIA</div>
                    </div>
                    {{-- Orbit dots --}}
                    @foreach([0, 72, 144, 216, 288] as $deg)
                        <div class="absolute w-1.5 h-1.5 rounded-full bg-amber-700/50"
                             style="top:calc(50% - 3px + {{ round(sin(deg2rad($deg))*108, 2) }}px);left:calc(50% - 3px + {{ round(cos(deg2rad($deg))*108, 2) }}px);"></div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ════════════════════════════ PROFIL MANGKU ══════════════════════════ --}}
<section class="bg-stone-100 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            {{-- Avatar --}}
            <div class="flex justify-center">
                <div class="relative">
                    <div class="w-44 h-44 sm:w-56 sm:h-56 rounded-full bg-stone-700 border-4 border-stone-400/50 overflow-hidden flex items-center justify-center">
                        @if($mangkuAvatarUrl)
                            <img src="{{ $mangkuAvatarUrl }}" alt="{{ $mangkuName }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-20 h-20 text-stone-500" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-stone-900 text-stone-200 text-xs font-medium px-4 py-1 rounded-full whitespace-nowrap">
                        {{ $mangkuAvatarBadge }}
                    </div>
                </div>
            </div>

            {{-- Bio --}}
            <div>
                <p class="text-stone-600 text-xs tracking-widest uppercase font-medium mb-3">{{ $mangkuSectionLabel }}</p>
                <h2 class="serif text-2xl sm:text-3xl md:text-4xl font-bold text-stone-900 mb-1">{{ $mangkuName }}</h2>
                <p class="text-stone-600 text-sm mb-6">{{ $mangkuMeta }}</p>

                <div class="w-10 h-0.5 bg-stone-600 mb-6"></div>

                @if($mangkuQuote)
                    <blockquote class="text-stone-700 italic leading-relaxed mb-6 text-lg font-light serif">
                        "{{ $mangkuQuote }}"
                    </blockquote>
                @endif

                @if($mangkuBio)
                    <p class="text-stone-700 text-sm leading-relaxed">{!! $mangkuBio !!}</p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════ TENTANG NANDIKA ════════════════════════ --}}
<section class="bg-stone-950 py-16 md:py-24 border-t border-stone-800/60">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <p class="text-stone-500 text-xs tracking-widest uppercase font-medium mb-4">{{ $nandikaSectionLabel }}</p>
        <h2 class="serif text-2xl sm:text-3xl md:text-4xl font-bold text-stone-100 mb-4">
            {{ $nandikaSectionTitle }}
            <span class="text-amber-400 italic">{{ $nandikaSectionAccent }}</span>
        </h2>
        <div class="flex items-center justify-center gap-3 mb-8">
            <div class="w-12 h-px bg-stone-700/40"></div>
            <svg class="w-3 h-3 text-stone-700/60" viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 0l1.5 6.5L16 8l-6.5 1.5L8 16l-1.5-6.5L0 8l6.5-1.5z"/>
            </svg>
            <div class="w-12 h-px bg-stone-700/40"></div>
        </div>
        <p class="text-stone-400 leading-relaxed max-w-2xl mx-auto mb-8">
            {!! $nandikaDescription !!}
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach($nandikaTags as $tag)
                <span class="bg-stone-800/60 border border-stone-700/30 text-stone-500 text-xs px-4 py-1.5 rounded-full">
                    {{ $tag['label'] ?? $tag }}
                </span>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════ TIM ═══════════════════════════════════ --}}
<section id="tim" class="bg-stone-950 py-16 md:py-24 border-t border-stone-800/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-12">
            <p class="text-stone-500 text-xs tracking-widest uppercase font-medium mb-3">{{ $timSectionLabel }}</p>
            <h2 class="serif text-3xl sm:text-4xl md:text-5xl font-bold text-stone-100 mb-4">{{ $timSectionTitle }}</h2>
            <p class="text-stone-400 max-w-xl mx-auto text-sm leading-relaxed">
                {{ $timSectionDescription }}
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($timMembers as $anggota)
                <div class="pelinggih-card rounded-2xl p-5 card-lift flex items-start gap-4">
                    @if(!empty($anggota['photo_url']))
                        <img src="{{ $anggota['photo_url'] }}"
                             alt="{{ $anggota['nama'] ?? '' }}"
                             class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                    @else
                        <div class="w-12 h-12 rounded-xl {{ $anggota['bg'] ?? 'bg-stone-600' }} flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">{{ $anggota['inisial'] ?? '?' }}</span>
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <h3 class="serif text-sm font-semibold text-stone-100 leading-snug mb-1">{{ $anggota['nama'] ?? '' }}</h3>
                        <p class="text-stone-600 text-xs font-mono mb-2.5">{{ $anggota['nim'] ?? '' }}</p>
                        <span class="inline-flex items-center gap-1.5 bg-stone-950/50 border border-stone-700/20 text-stone-400 text-xs px-2.5 py-1 rounded-full">
                            <span class="w-1 h-1 rounded-full bg-amber-500/60 flex-shrink-0"></span>
                            {{ $anggota['peran'] ?? '' }}
                        </span>
                    </div>
                </div>
            @endforeach

            {{-- Kartu Dosen Pembimbing --}}
            <div class="rounded-2xl p-5 card-lift flex items-start gap-4"
                 style="background: rgba(120,53,15,0.06); border: 1px solid rgba(180,83,9,0.2);">
                @if($dosenPhotoUrl)
                    <img src="{{ $dosenPhotoUrl }}" alt="{{ $dosenName ?? 'Dosen Pembimbing' }}"
                         class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                @else
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background: rgba(120,53,15,0.3); border: 1px solid rgba(180,83,9,0.25);">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                        </svg>
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="text-amber-600 text-xs tracking-widest uppercase font-medium mb-1.5">{{ $timDosenLabel }}</p>
                    @if($dosenName)
                        <h3 class="serif text-sm font-semibold text-stone-200 leading-snug mb-1">{{ $dosenName }}</h3>
                        <p class="text-stone-500 text-xs">{{ $dosenNip ? 'NIP · '.$dosenNip : 'NIP · —' }}</p>
                    @else
                        <h3 class="serif text-sm font-semibold text-stone-400 leading-snug italic mb-1">Belum diisi</h3>
                        <p class="text-stone-600 text-xs">NIP · —</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ════════════════════════════════ KONTAK ═══════════════════════════════ --}}
<section id="kontak" class="bg-stone-900 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <p class="text-stone-400 text-xs tracking-widest uppercase font-medium mb-3">{{ $kontakSectionLabel }}</p>
            <h2 class="serif text-4xl font-bold text-stone-100">{{ $kontakSectionTitle }}</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6 max-w-3xl mx-auto">
            @foreach($kontakItems as $c)
                <div class="text-center p-6 rounded-2xl bg-stone-950/40 border border-stone-700/20">
                    <div class="w-10 h-10 rounded-full bg-stone-700/20 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                    </div>
                    <div class="text-stone-500 text-xs uppercase tracking-widest mb-2">{{ $c['label'] ?? '' }}</div>
                    <p class="text-stone-300 text-sm leading-relaxed">{{ $c['value'] ?? '' }}</p>
                </div>
            @endforeach
        </div>

        {{-- Social Media --}}
        <div class="flex justify-center gap-3 mt-10">
            @foreach($socials as $s)
                <a href="{{ $s['href'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="{{ $s['label'] }}"
                   class="w-11 h-11 rounded-full bg-stone-800/60 border border-stone-700/30 flex items-center justify-center text-stone-400 hover:text-stone-100 hover:bg-stone-700/60 hover:border-stone-600/60 transition-all duration-200"
                >
                    <i class="{{ $s['icon'] }} text-base"></i>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════ FOOTER ════════════════════════════════ --}}
<footer class="bg-stone-950 border-t border-stone-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-center justify-between gap-3 text-xs text-stone-500">
        <div class="flex items-center gap-2">
            <div class="w-5 h-5 rounded-full border border-stone-700/40 flex items-center justify-center">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/>
                </svg>
            </div>
            <span>{{ $footerVenue }}</span>
        </div>
        <div>{{ $footerCopy }}</div>
        @auth
            <a href="{{ route('dashboard') }}" class="hover:text-stone-300 transition-colors">Admin ↗</a>
        @else
            <a href="{{ route('dashboard') }}" class="hover:text-stone-300 transition-colors">Admin ↗</a>
        @endauth
    </div>
</footer>

@livewireScripts
</body>
</html>
