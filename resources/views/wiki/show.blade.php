<x-layouts::public
    :title="$article->title . ' — Wiki Pura Desa Tambawu'"
    :metaDescription="$article->excerpt"
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
        <a href="{{ route('wiki.index') }}" class="back-link flex items-center gap-2 text-stone-500 hover:text-stone-800 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Wiki
        </a>

        <span class="nav-title text-stone-400 text-xs hidden sm:block truncate max-w-xs">{{ $article->title }}</span>

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

            <a href="{{ route('home') }}" class="home-link text-stone-400 hover:text-stone-700 transition-colors text-xs">
                Beranda
            </a>
        </div>
    </nav>
</header>

{{-- ══════════════════ LAYOUT: sidebar + konten ══════════════════ --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 lg:grid lg:grid-cols-[220px_1fr] lg:gap-10">

    {{-- ── Sidebar navigasi ── --}}
    <aside class="hidden lg:block">
        <div class="sticky top-20 space-y-6">
            @foreach ($sections as $section)
                @if ($section['articles']->isNotEmpty())
                <div>
                    <p class="sidebar-cat-label text-[10px] uppercase tracking-widest text-stone-400 mb-2 px-2">{{ $section['category']->name }}</p>
                    <ul class="space-y-0.5">
                        @foreach ($section['articles'] as $item)
                        <li>
                            <a href="{{ route('wiki.show', $item->slug) }}"
                               class="{{ $item->slug === $article->slug ? 'sidebar-link-active block px-2 py-1.5 rounded-lg text-xs transition-colors bg-rose-50 text-rose-700 font-medium border border-rose-200' : 'sidebar-link block px-2 py-1.5 rounded-lg text-xs transition-colors text-stone-500 hover:text-stone-900 hover:bg-stone-100' }}">
                                {{ $item->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            @endforeach
        </div>
    </aside>

    {{-- ── Konten artikel ── --}}
    <article class="min-w-0">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-stone-400 mb-6">
            <a href="{{ route('wiki.index') }}" class="breadcrumb-link hover:text-stone-600 transition-colors">Wiki</a>
            <svg class="breadcrumb-sep w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="breadcrumb-cat text-stone-500">{{ $article->wikiCategory?->name }}</span>
            <svg class="breadcrumb-sep w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="breadcrumb-title text-stone-700 truncate">{{ $article->title }}</span>
        </nav>

        {{-- Category badge --}}
        @if ($article->wikiCategory)
        <div class="flex items-center gap-2 mb-4">
            <span class="cat-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700 border border-rose-200">
                @if ($article->wikiCategory->icon)
                    <x-dynamic-component :component="$article->wikiCategory->icon" class="w-3 h-3"/>
                @endif
                {{ $article->wikiCategory->name }}
            </span>
        </div>
        @endif

        {{-- Title --}}
        <h1 class="article-title text-2xl sm:text-3xl font-bold text-stone-900 mb-4 leading-snug">
            {{ $article->title }}
        </h1>

        @if ($article->excerpt)
            <p class="article-excerpt text-stone-600 text-base leading-relaxed border-l-2 border-rose-300 pl-4 mb-8 italic">
                {{ $article->excerpt }}
            </p>
        @endif

        {{-- Article body --}}
        <div class="wiki-content prose prose-stone prose-sm max-w-none
            prose-headings:text-stone-800 prose-headings:font-semibold
            prose-h2:text-xl prose-h2:mt-8 prose-h2:mb-3 prose-h2:pb-2 prose-h2:border-b prose-h2:border-stone-200
            prose-p:text-stone-700 prose-p:leading-relaxed
            prose-a:text-rose-600 prose-a:no-underline hover:prose-a:underline
            prose-strong:text-stone-800
            prose-ul:text-stone-700 prose-li:my-1
            prose-blockquote:border-rose-300 prose-blockquote:text-stone-600 prose-blockquote:bg-rose-50 prose-blockquote:rounded-r-lg prose-blockquote:py-1
            prose-dt:text-stone-800 prose-dt:font-semibold prose-dt:mt-4
            prose-dd:text-stone-600 prose-dd:ml-4 prose-dd:mb-2">
            {!! $article->content !!}
        </div>

        {{-- Navigasi bawah ── prev/next --}}
        <div class="prev-next-border mt-12 pt-6 flex justify-between gap-4 text-sm">
            @if ($prev)
                <a href="{{ route('wiki.show', $prev->slug) }}"
                   class="prev-next-link flex items-center gap-2 text-stone-500 hover:text-stone-800 transition-colors max-w-[45%]">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    <span class="truncate">{{ $prev->title }}</span>
                </a>
            @else
                <div></div>
            @endif

            @if ($next)
                <a href="{{ route('wiki.show', $next->slug) }}"
                   class="prev-next-link flex items-center gap-2 text-stone-500 hover:text-stone-800 transition-colors max-w-[45%] text-right">
                    <span class="truncate">{{ $next->title }}</span>
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @endif
        </div>

    </article>
</div>

{{-- ══════════════════ FOOTER ══════════════════ --}}
<footer class="bg-stone-50 mt-8">
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
