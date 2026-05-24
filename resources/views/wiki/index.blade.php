<x-layouts::public
    title="Wiki — Pura Desa Adat Tambawu"
    metaDescription="Ensiklopedia lengkap tentang Pura Desa Adat Tambawu: sejarah, pelinggih, ritual, tokoh, dan glosarium istilah adat Bali."
>

<div
    x-data="{
        dark: localStorage.getItem('wiki-theme') === 'dark',
        toggleDark() {
            this.dark = !this.dark;
            localStorage.setItem('wiki-theme', this.dark ? 'dark' : 'light');
        }
    }"
    :class="{ 'dark': dark }"
    class="wiki-root bg-white min-h-screen text-stone-900"
>

{{-- ══════════════════ NAVBAR ══════════════════ --}}
<header
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
    :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md shadow-stone-200/80' : 'bg-stone-50/90 backdrop-blur-sm'"
    class="sticky top-0 z-50 transition-all duration-300"
>
    <nav class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="back-link flex items-center gap-2 text-stone-500 hover:text-stone-800 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Beranda
        </a>

        <span class="nav-title text-stone-800 font-semibold tracking-wide text-sm">Wiki Pura Desa Tambawu</span>

        <div class="flex items-center gap-2">
            {{-- Dark mode toggle --}}
            <button
                @click="toggleDark()"
                :title="dark ? 'Beralih ke mode terang' : 'Beralih ke mode gelap'"
                class="dark-toggle w-8 h-8 flex items-center justify-center rounded-full transition-colors text-stone-500"
            >
                {{-- Sun: shown when dark --}}
                <svg x-show="dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                </svg>
                {{-- Moon: shown when light --}}
                <svg x-show="!dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>
                </svg>
            </button>

            <a href="{{ $tourUrl }}"
               class="hidden sm:inline-flex items-center gap-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium px-3 py-1.5 rounded-full transition-colors">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                Mulai Tour
            </a>
        </div>
    </nav>
</header>

{{-- ══════════════════ HERO ══════════════════ --}}
<section class="hero-section bg-stone-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
        <div class="flex items-center gap-2 text-stone-400 text-xs uppercase tracking-widest mb-4">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            Ensiklopedia Digital
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold text-stone-900 mb-3">
            Wiki <span class="text-rose-600">Pura Desa Adat Tambawu</span>
        </h1>
        <p class="text-stone-500 max-w-2xl leading-relaxed">
            Dokumentasi lengkap mengenai sejarah, pelinggih, ritual, tokoh, dan istilah adat yang berkaitan dengan Pura Desa Adat Tambawu, Denpasar.
        </p>

        {{-- Category tabs --}}
        <div class="flex flex-wrap gap-2 mt-8">
            <a href="#semua" class="cat-tab px-3 py-1.5 rounded-full text-xs font-medium bg-stone-200 text-stone-600 hover:bg-stone-300 transition-colors">
                Semua
            </a>
            @foreach ($sections as $section)
                <a href="#{{ $section['category']->slug }}" class="cat-tab px-3 py-1.5 rounded-full text-xs font-medium bg-stone-200 text-stone-600 hover:bg-stone-300 transition-colors">
                    {{ $section['category']->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════ ARTIKEL ══════════════════ --}}
<main class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-16" id="semua">
    @foreach ($sections as $section)
        <section id="{{ $section['category']->slug }}">
            {{-- Category heading --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="cat-icon-wrap w-8 h-8 rounded-lg bg-rose-100 border border-rose-200 flex items-center justify-center flex-shrink-0">
                    @if ($section['category']->icon)
                        <x-dynamic-component :component="$section['category']->icon" class="w-4 h-4 text-rose-600"/>
                    @else
                        <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <h2 class="cat-title text-lg font-semibold text-stone-900">{{ $section['category']->name }}</h2>
                    <p class="text-xs text-stone-400">{{ $section['articles']->count() }} artikel</p>
                </div>
            </div>

            {{-- Article cards --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($section['articles'] as $article)
                <a href="{{ route('wiki.show', $article->slug) }}"
                   class="article-card group block bg-white border border-stone-200 rounded-xl p-5 hover:border-stone-300 hover:bg-stone-50 transition-all duration-200 shadow-sm hover:shadow-md">
                    <h3 class="text-sm font-semibold text-stone-800 group-hover:text-stone-900 mb-2 leading-snug">
                        {{ $article->title }}
                    </h3>
                    @if ($article->excerpt)
                        <p class="text-xs text-stone-500 leading-relaxed line-clamp-3">{{ $article->excerpt }}</p>
                    @endif
                    <div class="mt-4 flex items-center gap-1 text-xs text-rose-600 group-hover:text-rose-700">
                        Baca selengkapnya
                        <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
    @endforeach
</main>

{{-- ══════════════════ FOOTER ══════════════════ --}}
<footer class="bg-stone-50 mt-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-400">
        <span>Nandika PBL 2025 · Kelompok 2</span>
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="hover:text-stone-600 transition-colors">Beranda</a>
            <a href="{{ route('wiki.index') }}" class="hover:text-stone-600 transition-colors">Wiki</a>
        </div>
    </div>
</footer>

</div>
</x-layouts::public>
