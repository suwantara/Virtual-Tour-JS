<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Virtual Tour 360° Pura Desa Adat Tambawu, Denpasar — Jelajahi warisan budaya Tri Kahyangan secara digital melalui platform Nandika.">
    <title>Virtual Tour — Pura Desa Adat Tambawu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy:  #202940;
            --brown: #4B4038;
            --taupe: #9A8678;
            --sand:  #CAAA98;
        }
        body        { font-family: 'Inter', sans-serif; background-color: var(--navy); color: #fff; }
        .serif      { font-family: 'Playfair Display', serif; }
        .bg-navy    { background-color: var(--navy); }
        .bg-brown   { background-color: var(--brown); }
        .bg-sand    { background-color: var(--sand); }
        .text-taupe { color: var(--taupe); }
        .text-sand  { color: var(--sand); }
        .text-navy  { color: var(--navy); }
        .text-brown { color: var(--brown); }
        .border-taupe { border-color: var(--taupe); }
        .border-sand  { border-color: var(--sand); }

        /* Ornamental divider */
        .ornament {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--taupe);
        }
        .ornament::before, .ornament::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--taupe);
            opacity: 0.4;
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Hero gradient overlay */
        .hero-gradient {
            background: linear-gradient(
                to bottom,
                rgba(32,41,64,0.3) 0%,
                rgba(32,41,64,0.7) 60%,
                rgba(32,41,64,1) 100%
            );
        }

        /* Card hover lift */
        .card-lift { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .card-lift:hover { transform: translateY(-4px); }

        /* Nav link underline animation */
        .nav-link {
            position: relative;
            padding-bottom: 2px;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 1px;
            background: var(--sand);
            transition: width 0.25s ease;
        }
        .nav-link:hover::after { width: 100%; }

        /* Pelinggih card pattern */
        .pelinggih-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(154,134,120,0.2);
            transition: background 0.25s, border-color 0.25s;
        }
        .pelinggih-card:hover {
            background: rgba(202,170,152,0.1);
            border-color: rgba(202,170,152,0.5);
        }
    </style>
</head>
<body>

{{-- ═══════════════════════════════ NAVBAR ═══════════════════════════════ --}}
<nav
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 40)"
    :class="scrolled ? 'bg-[#202940]/95 backdrop-blur-md shadow-lg shadow-black/30' : 'bg-transparent'"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="#hero" class="flex items-center gap-3 group">
            <div class="w-8 h-8 rounded-full border border-[#9A8678] flex items-center justify-center">
                <svg class="w-4 h-4 text-[#CAAA98]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582" />
                </svg>
            </div>
            <div class="leading-tight">
                <div class="text-xs text-[#CAAA98]/80 font-light tracking-widest uppercase">Pura Desa</div>
                <div class="text-sm font-semibold text-[#CAAA98] serif tracking-wide">Tambawu</div>
            </div>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden md:flex items-center gap-8">
            @foreach([
                ['#hero',         'Beranda'],
                ['#tentang-pura', 'Tentang Pura'],
                ['#virtual-tour', 'Virtual Tour'],
                ['#pelinggih',    'Pelinggih'],
                ['#kontak',       'Kontak'],
            ] as [$href, $label])
                <a href="{{ $href }}" class="nav-link text-sm text-[#CAAA98]/80 hover:text-[#CAAA98] transition-colors">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- CTA + Hamburger --}}
        <div class="flex items-center gap-4">
            @if($venues->isNotEmpty())
                <a href="{{ route('tour', $venues->first()) }}"
                   class="hidden md:inline-flex items-center gap-2 bg-[#4B4038] hover:bg-[#9A8678] text-[#CAAA98] hover:text-white text-sm font-medium px-4 py-2 rounded-full transition-all duration-200 border border-[#9A8678]/40">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 010 1.972l-11.54 6.347a1.125 1.125 0 01-1.667-.986V5.653z"/>
                    </svg>
                    Mulai Tour
                </a>
            @endif

            <button @click="open = !open" class="md:hidden text-[#CAAA98] p-1">
                <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
                <svg x-show="open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="md:hidden bg-[#202940]/98 backdrop-blur-md border-t border-[#4B4038] px-6 py-4 space-y-3">
        @foreach([
            ['#hero',         'Beranda'],
            ['#tentang-pura', 'Tentang Pura'],
            ['#virtual-tour', 'Virtual Tour'],
            ['#pelinggih',    'Pelinggih'],
            ['#kontak',       'Kontak'],
        ] as [$href, $label])
            <a href="{{ $href }}" @click="open = false" class="block text-[#CAAA98]/80 hover:text-[#CAAA98] py-1.5 text-sm">
                {{ $label }}
            </a>
        @endforeach
        @if($venues->isNotEmpty())
            <a href="{{ route('tour', $venues->first()) }}"
               class="block mt-3 text-center bg-[#4B4038] text-[#CAAA98] text-sm font-medium px-4 py-2.5 rounded-full border border-[#9A8678]/40">
                Mulai Virtual Tour
            </a>
        @endif
    </div>
</nav>

{{-- ═══════════════════════════════ HERO ═══════════════════════════════ --}}
<section id="hero" class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">

    {{-- Background: solid navy with subtle noise texture --}}
    <div class="absolute inset-0 bg-[#202940]">
        {{-- Decorative radial glow --}}
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full"
             style="background: radial-gradient(circle, rgba(75,64,56,0.4) 0%, transparent 70%);"></div>
        {{-- Corner ornament lines --}}
        <div class="absolute top-20 left-8 w-16 h-16 border-t border-l border-[#9A8678]/30"></div>
        <div class="absolute top-20 right-8 w-16 h-16 border-t border-r border-[#9A8678]/30"></div>
        <div class="absolute bottom-20 left-8 w-16 h-16 border-b border-l border-[#9A8678]/30"></div>
        <div class="absolute bottom-20 right-8 w-16 h-16 border-b border-r border-[#9A8678]/30"></div>
    </div>

    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">

        {{-- Badge Nandika --}}
        <div class="inline-flex items-center gap-2 bg-[#4B4038]/60 border border-[#9A8678]/40 text-[#CAAA98] text-xs font-medium px-4 py-1.5 rounded-full mb-8 tracking-widest uppercase">
            <span class="w-1.5 h-1.5 rounded-full bg-[#CAAA98] animate-pulse"></span>
            Nandika · Nusantara Digital Archive · PBL 2025
        </div>

        {{-- Kaligrafi ornamen --}}
        <div class="text-white/25 text-sm tracking-[0.5em] uppercase mb-3 font-light" aria-hidden="true">
            Tri Kahyangan · Desa Adat Tambawu
        </div>

        {{-- Title --}}
        <h1 class="serif text-5xl md:text-7xl font-bold text-white mb-2 leading-tight">
            Pura Desa
        </h1>
        <h2 class="serif text-3xl md:text-5xl font-light text-[#CAAA98] mb-6 italic">
            Adat Tambawu
        </h2>

        {{-- Garis ornamen --}}
        <div class="flex items-center justify-center gap-3 mb-6">
            <div class="w-16 h-px bg-[#9A8678]/50"></div>
            <svg class="w-4 h-4 text-[#9A8678]" viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 0l1.5 6.5L16 8l-6.5 1.5L8 16l-1.5-6.5L0 8l6.5-1.5z"/>
            </svg>
            <div class="w-16 h-px bg-[#9A8678]/50"></div>
        </div>

        {{-- Subtitle --}}
        <p class="text-[#CAAA98]/80 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto mb-10 font-light">
            Jelajahi warisan budaya Desa Adat Tambawu, Denpasar melalui
            <span class="text-[#CAAA98] font-medium">Virtual Tour 360°</span>
            interaktif. Setiap sudut pura tersimpan dalam arsip digital yang awet dan berkelanjutan.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($venues->isNotEmpty())
                <a href="{{ route('tour', $venues->first()) }}"
                   class="inline-flex items-center justify-center gap-3 bg-[#CAAA98] hover:bg-[#9A8678] text-[#202940] hover:text-white font-semibold px-8 py-3.5 rounded-full transition-all duration-200 group">
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
               class="inline-flex items-center justify-center gap-2 border border-[#9A8678]/60 text-[#CAAA98] hover:bg-[#4B4038] font-medium px-8 py-3.5 rounded-full transition-all duration-200">
                Pelajari Lebih Lanjut
            </a>
        </div>

        {{-- Scroll hint --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/30 text-xs animate-bounce" aria-hidden="true">
            <span class="tracking-widest uppercase text-[10px]">Gulir</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
            </svg>
        </div>
    </div>
</section>

{{-- ════════════════════════════ TENTANG PURA ════════════════════════════ --}}
<section id="tentang-pura" class="bg-[#CAAA98] text-[#202940] py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Section header --}}
        <div class="text-center mb-16">
            <p class="text-[#4B4038] text-xs tracking-widest uppercase font-medium mb-3">Warisan Budaya</p>
            <h2 class="serif text-4xl md:text-5xl font-bold text-[#202940] mb-4">Tentang Pura</h2>
            <div class="ornament text-[#4B4038] max-w-xs mx-auto">
                <span class="text-sm font-light">Tri Kahyangan · Dewa Brahma</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start">

            {{-- Sejarah --}}
            <div>
                <h3 class="serif text-2xl font-semibold text-[#202940] mb-4">Sejarah & Latar Belakang</h3>
                <div class="w-10 h-0.5 bg-[#4B4038] mb-6"></div>

                <div class="space-y-4 text-[#4B4038] leading-relaxed">
                    <p>
                        Pura Desa Adat Tambawu merupakan salah satu elemen penting dalam sistem
                        <strong class="text-[#202940]">Tri Kahyangan</strong> yang menjadi landasan kehidupan spiritual
                        masyarakat Desa Adat Tambawu, Kota Denpasar. Sebagai tempat pemujaan
                        <strong class="text-[#202940]">Dewa Brahma</strong>, pura ini berperan sebagai pusat
                        pelaksanaan ritual bersama dan perekat identitas budaya komunitas adat setempat.
                    </p>
                    <p>
                        Berdasarkan penuturan Jro Mangku Desa, berdirinya Pura Desa Adat Tambawu tidak diketahui
                        secara pasti. Desa Adat Tambawu termasuk dalam <strong class="text-[#202940]">desa tua</strong>
                        yang merupakan gabungan antardesa di kawasan Penatih, sehingga disebut Penatih Kidul (Selatan).
                    </p>
                    <p>
                        Catatan kecil yang tersimpan menyebutkan adanya penataan pelinggih pada
                        <strong class="text-[#202940]">dekade 1940-an</strong> atas perintah raja, ketika struktur
                        pura mulai berkembang dari satu pelinggih menjadi tatanan yang lebih lengkap seperti saat ini.
                    </p>
                    <p>
                        Piodalan utama atau <strong class="text-[#202940]">Pujawali</strong> dilaksanakan pada
                        <strong class="text-[#202940]">Saniscara Kliwon Kuningan</strong> (Hari Raya Kuningan).
                    </p>
                </div>
            </div>

            {{-- Stats --}}
            <div class="space-y-4">
                @php
                    $stats = [
                        [
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>',
                            'value' => '13',
                            'label' => 'Pelinggih',
                            'desc'  => 'Bangunan suci dalam kompleks pura',
                        ],
                        [
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>',
                            'value' => 'Kuningan',
                            'label' => 'Hari Pujawali',
                            'desc'  => 'Saniscara Kliwon Kuningan',
                        ],
                        [
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>',
                            'value' => '1993',
                            'label' => 'Mangku Desa Bertugas',
                            'desc'  => 'Jro Made Rena Atmaja · hingga saat ini',
                        ],
                        [
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>',
                            'value' => 'Desa Tua',
                            'label' => 'Status Desa Adat',
                            'desc'  => 'Salah satu desa adat tertua di Penatih',
                        ],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="flex items-start gap-4 bg-white/30 backdrop-blur-sm border border-[#9A8678]/30 rounded-2xl p-5 card-lift">
                        <div class="w-10 h-10 rounded-xl bg-[#4B4038] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#CAAA98]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                {!! $stat['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-2">
                                <span class="serif text-xl font-bold text-[#202940]">{{ $stat['value'] }}</span>
                                <span class="text-sm font-semibold text-[#4B4038]">{{ $stat['label'] }}</span>
                            </div>
                            <p class="text-xs text-[#4B4038] mt-0.5">{{ $stat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════ VIRTUAL TOUR CTA ════════════════════════ --}}
<section id="virtual-tour" class="bg-[#4B4038] py-20 md:py-28 relative overflow-hidden">

    {{-- Background decoration --}}
    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-80 h-80 rounded-full border border-[#9A8678]/20 opacity-30"></div>
    <div class="absolute right-16 top-1/2 -translate-y-1/2 w-52 h-52 rounded-full border border-[#9A8678]/20 opacity-30"></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            {{-- Teks --}}
            <div>
                <p class="text-[#CAAA98] text-xs tracking-widest uppercase font-medium mb-4">Eksplorasi Digital</p>
                <h2 class="serif text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Jelajahi Pura<br>
                    <span class="text-[#CAAA98] italic">dalam 360°</span>
                </h2>
                <p class="text-[#CAAA98] leading-relaxed mb-8">
                    Memanfaatkan teknologi fotografi panorama sferis, setiap sudut Pura Desa Adat Tambawu
                    kini dapat dijelajahi secara interaktif. Pindah antar bangunan, klik hotspot untuk
                    membaca keterangan, dan rasakan keagungan pura dari mana saja.
                </p>

                <div class="flex flex-wrap gap-3 mb-8">
                    @foreach(['Foto 360° Spherical', '13 Titik Hotspot', 'Legenda Pelinggih', 'Akses Publik'] as $feat)
                        <span class="flex items-center gap-1.5 bg-[#202940]/40 border border-[#9A8678]/30 text-[#CAAA98] text-xs px-3 py-1.5 rounded-full">
                            <svg class="w-3 h-3 text-[#CAAA98]" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 0l1.5 6.5L16 8l-6.5 1.5L8 16l-1.5-6.5L0 8l6.5-1.5z"/>
                            </svg>
                            {{ $feat }}
                        </span>
                    @endforeach
                </div>

                @if($venues->isNotEmpty())
                    <a href="{{ route('tour', $venues->first()) }}"
                       class="inline-flex items-center gap-3 bg-[#CAAA98] hover:bg-white text-[#202940] font-semibold px-8 py-3.5 rounded-full transition-all duration-200 group">
                        Buka Virtual Tour
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center gap-2 bg-[#9A8678]/30 text-[#CAAA98]/60 text-sm px-8 py-3.5 rounded-full cursor-not-allowed">
                        Segera Hadir
                    </span>
                @endif
            </div>

            {{-- Visual dekoratif 360° --}}
            <div class="flex justify-center md:justify-end">
                <div class="relative w-64 h-64">
                    {{-- Lingkaran luar --}}
                    <div class="absolute inset-0 rounded-full border-2 border-dashed border-[#9A8678]/40 animate-spin" style="animation-duration: 20s;"></div>
                    {{-- Lingkaran tengah --}}
                    <div class="absolute inset-6 rounded-full border border-[#9A8678]/30"></div>
                    {{-- Pusat --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="serif text-5xl font-bold text-[#CAAA98]">360</div>
                            <div class="text-[#9A8678] text-xs tracking-widest mt-1">DERAJAT</div>
                        </div>
                    </div>
                    {{-- Titik di lingkaran --}}
                    @foreach([0, 60, 120, 180, 240, 300] as $deg)
                        <div class="absolute w-2 h-2 rounded-full bg-[#9A8678]/60"
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
<section id="pelinggih" class="bg-[#202940] py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Section header --}}
        <div class="text-center mb-16">
            <p class="text-[#CAAA98] text-xs tracking-widest uppercase font-medium mb-3">Katalog Digital</p>
            <h2 class="serif text-4xl md:text-5xl font-bold text-white mb-4">Pelinggih Pura</h2>
            <p class="text-[#CAAA98]/80 max-w-xl mx-auto text-sm leading-relaxed">
                Setiap bangunan suci memiliki fungsi dan makna spiritual tersendiri. Berikut pelinggih-pelinggih
                utama yang dapat dijelajahi dalam virtual tour.
            </p>
        </div>

        @php
            $pelinggih = [
                [
                    'nama'  => 'Gedong Agung',
                    'fungsi'=> 'Tempat linggih Ida Bhatara Pura Desa dengan berbagai pratimanya. Diumpamakan sebagai rumah yang besar, suci, dan merupakan pusat pelinggih.',
                    'icon'  => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18',
                ],
                [
                    'nama'  => 'Bale Agung',
                    'fungsi'=> 'Tempat berstananya Ida Bhatara. Setiap ada upacara, di sinilah para Sesuhunan berada. Pusat dari segala proses upacara.',
                    'icon'  => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
                ],
                [
                    'nama'  => 'Ratu Anglurah Agung',
                    'fungsi'=> 'Tempat Ida dalam menjaga pura. Semua yang masuk ke pura harus melewati beliau — bagaikan ajudan pribadi yang menyambut dan melindungi.',
                    'icon'  => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                ],
                [
                    'nama'  => 'Pelinggih Dewi Sedana',
                    'fungsi'=> 'Tempat pemujaan kepada Dewi Kesuburan dalam menunjang dan melimpahkan berkah kehidupan bagi masyarakat adat.',
                    'icon'  => 'M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z',
                ],
                [
                    'nama'  => 'Bale Paruman',
                    'fungsi'=> 'Tempat para pendamping (pengabih) yang dikenal dengan premas berkumpul ketika proses upacara berlangsung.',
                    'icon'  => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
                ],
                [
                    'nama'  => 'Begawan Penyarikan',
                    'fungsi'=> 'Tempat berstananya Ida dalam mengatur dan mencatat kehidupan bermasyarakat. Dipohon restu untuk kelancaran setiap kegiatan.',
                    'icon'  => 'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10',
                ],
            ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($pelinggih as $p)
                <div class="pelinggih-card rounded-2xl p-6 card-lift">
                    <div class="w-10 h-10 rounded-xl bg-[#4B4038] flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-[#CAAA98]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $p['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="serif text-lg font-semibold text-white mb-2">{{ $p['nama'] }}</h3>
                    <p class="text-[#CAAA98]/80 text-sm leading-relaxed">{{ $p['fungsi'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="#virtual-tour"
               class="inline-flex items-center gap-2 border border-[#9A8678]/40 text-[#CAAA98]/80 hover:text-[#CAAA98] hover:border-[#CAAA98]/60 text-sm px-6 py-2.5 rounded-full transition-all duration-200">
                Lihat semua dalam Virtual Tour
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════ PROFIL MANGKU ══════════════════════════ --}}
<section class="bg-[#CAAA98] py-20 md:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            {{-- Avatar placeholder --}}
            <div class="flex justify-center">
                <div class="relative">
                    <div class="w-56 h-56 rounded-full bg-[#4B4038] border-4 border-[#9A8678]/50 flex items-center justify-center">
                        <svg class="w-20 h-20 text-[#9A8678]" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-[#202940] text-[#CAAA98] text-xs font-medium px-4 py-1 rounded-full whitespace-nowrap">
                        Jro Mangku Desa
                    </div>
                </div>
            </div>

            {{-- Bio --}}
            <div>
                <p class="text-[#4B4038] text-xs tracking-widest uppercase font-medium mb-3">Pengempon Pura</p>
                <h2 class="serif text-3xl md:text-4xl font-bold text-[#202940] mb-1">Jro Made Rena Atmaja</h2>
                <p class="text-[#4B4038] text-sm mb-6">Lahir 1951 · Mangku Desa sejak 1993</p>

                <div class="w-10 h-0.5 bg-[#4B4038] mb-6"></div>

                <blockquote class="text-[#4B4038] italic leading-relaxed mb-6 text-lg font-light serif">
                    "Menjadi Mangku itu tidak mengenal istilah pensiun. Jika seseorang sudah terpilih menjadi
                    Mangku di Khayangan Tiga, ia melakukan kewajibannya dengan tulus ikhlas hingga akhir hayat."
                </blockquote>

                <p class="text-[#4B4038] text-sm leading-relaxed">
                    Beliau telah mengabdi sebagai Jro Mangku Desa selama lebih dari tiga dekade, bahkan
                    sejak masih aktif berdinas di pemerintahan. Peran Mangku Desa bersifat permanen
                    dan hanya dapat diwakilkan oleh Mangku pembantu (<em>pengayah</em>) dalam kondisi tertentu.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════ TENTANG NANDIKA ════════════════════════ --}}
<section class="bg-[#202940] py-20 md:py-24 border-t border-[#4B4038]/60">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <p class="text-[#CAAA98] text-xs tracking-widest uppercase font-medium mb-4">Project Akademik</p>
        <h2 class="serif text-3xl md:text-4xl font-bold text-white mb-4">
            Nandika —
            <span class="text-[#CAAA98] italic">Nusantara Digital Archive</span>
        </h2>
        <div class="flex items-center justify-center gap-3 mb-8">
            <div class="w-12 h-px bg-[#9A8678]/40"></div>
            <svg class="w-3 h-3 text-[#9A8678]/60" viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 0l1.5 6.5L16 8l-6.5 1.5L8 16l-1.5-6.5L0 8l6.5-1.5z"/>
            </svg>
            <div class="w-12 h-px bg-[#9A8678]/40"></div>
        </div>
        <p class="text-[#CAAA98]/80 leading-relaxed max-w-2xl mx-auto mb-8">
            Website ini merupakan luaran dari mata kuliah
            <strong class="text-[#CAAA98]">Project Based Learning (PBL)</strong> program studi
            Rekam Medis & Informasi Kesehatan — Kelompok 2. Proyek Nandika berfokus pada
            pengalih-mediaan warisan budaya lokal ke dalam arsip digital yang awet dan berkelanjutan,
            dengan menyerahkan seluruh aset digital kepada pihak Desa Adat Tambawu.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach(['Virtual Tour 360°', 'Metadata Dublin Core', 'Arsip Digital', 'Kontribusi Sosial'] as $tag)
                <span class="bg-[#4B4038]/60 border border-[#9A8678]/30 text-[#CAAA98]/80 text-xs px-4 py-1.5 rounded-full">
                    {{ $tag }}
                </span>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════ KONTAK ═══════════════════════════════ --}}
<section id="kontak" class="bg-[#4B4038] py-20 md:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="text-[#CAAA98] text-xs tracking-widest uppercase font-medium mb-3">Hubungi Kami</p>
            <h2 class="serif text-4xl font-bold text-white">Kontak</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6 max-w-3xl mx-auto">
            @php $contacts = [
                ['label' => 'Lokasi',   'value' => 'Desa Adat Tambawu, Penatih, Denpasar Timur, Bali',
                 'icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z'],
                ['label' => 'Piodalan', 'value' => 'Saniscara Kliwon Kuningan (Hari Raya Kuningan)',
                 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                ['label' => 'Proyek',   'value' => 'PBL Nandika · Kelompok 2 · 2025',
                 'icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5'],
            ]; @endphp

            @foreach($contacts as $c)
                <div class="text-center p-6 rounded-2xl bg-[#202940]/40 border border-[#9A8678]/20">
                    <div class="w-10 h-10 rounded-full bg-[#9A8678]/20 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-[#CAAA98]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="text-[#CAAA98] text-xs uppercase tracking-widest mb-2">{{ $c['label'] }}</div>
                    <p class="text-[#CAAA98] text-sm leading-relaxed">{{ $c['value'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════ FOOTER ════════════════════════════════ --}}
<footer class="bg-[#202940] border-t border-[#4B4038] py-8">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-[#CAAA98]/80">
        <div class="flex items-center gap-2">
            <div class="w-5 h-5 rounded-full border border-[#9A8678]/40 flex items-center justify-center">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/>
                </svg>
            </div>
            <span>Pura Desa Adat Tambawu · Denpasar, Bali</span>
        </div>
        <div>Nandika PBL 2025 · Kelompok 2 · Hak Cipta Dilindungi</div>
        @auth
            <a href="{{ route('dashboard') }}" class="hover:text-[#CAAA98] transition-colors">Admin ↗</a>
        @else
            <a href="{{ route('login') }}" class="hover:text-[#CAAA98] transition-colors">Admin ↗</a>
        @endauth
    </div>
</footer>

</body>
</html>
