<x-layouts::public
    :title="$article->title . ' — Wiki Pura Desa Tambawu'"
    :metaDescription="$article->excerpt"
>
<div class="bg-white min-h-screen text-stone-900">

{{-- ══════════════════ NAVBAR ══════════════════ --}}
<header
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
    :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md shadow-stone-200/80' : 'bg-white/80 backdrop-blur-sm'"
    class="sticky top-0 z-50 transition-all duration-300 border-b border-stone-200"
>
    <nav class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between gap-4">
        <a href="{{ route('wiki.index') }}" class="flex items-center gap-2 text-stone-500 hover:text-stone-800 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Wiki
        </a>

        <span class="text-stone-400 text-xs hidden sm:block truncate max-w-xs">{{ $article->title }}</span>

        <a href="{{ route('home') }}" class="text-stone-400 hover:text-stone-700 transition-colors text-xs">
            Beranda
        </a>
    </nav>
</header>

{{-- ══════════════════ LAYOUT: sidebar + konten ══════════════════ --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 lg:grid lg:grid-cols-[220px_1fr] lg:gap-10">

    {{-- ── Sidebar navigasi ── --}}
    <aside class="hidden lg:block">
        <div class="sticky top-20 space-y-6">
            @foreach ($categories as $cat)
                @php $catArticles = $grouped->get($cat->value, collect()) @endphp
                @if ($catArticles->isNotEmpty())
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-stone-400 mb-2 px-2">{{ $cat->label() }}</p>
                    <ul class="space-y-0.5">
                        @foreach ($catArticles as $item)
                        <li>
                            <a href="{{ route('wiki.show', $item->slug) }}"
                               class="block px-2 py-1.5 rounded-lg text-xs transition-colors {{ $item->slug === $article->slug ? 'bg-rose-50 text-rose-700 font-medium border border-rose-200' : 'text-stone-500 hover:text-stone-900 hover:bg-stone-100' }}">
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
            <a href="{{ route('wiki.index') }}" class="hover:text-stone-600 transition-colors">Wiki</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="text-stone-500">{{ $article->category->label() }}</span>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="text-stone-700 truncate">{{ $article->title }}</span>
        </nav>

        {{-- Category badge --}}
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700 border border-rose-200">
                <x-dynamic-component :component="$article->category->icon()" class="w-3 h-3"/>
                {{ $article->category->label() }}
            </span>
        </div>

        {{-- Title --}}
        <h1 class="text-2xl sm:text-3xl font-bold text-stone-900 mb-4 leading-snug">
            {{ $article->title }}
        </h1>

        @if ($article->excerpt)
            <p class="text-stone-600 text-base leading-relaxed border-l-2 border-rose-300 pl-4 mb-8 italic">
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
        @php
            $flat = $grouped->flatten();
            $idx  = $flat->search(fn ($a) => $a->slug === $article->slug);
            $prev = $idx > 0 ? $flat->get($idx - 1) : null;
            $next = $flat->get($idx + 1);
        @endphp
        <div class="mt-12 pt-6 border-t border-stone-200 flex justify-between gap-4 text-sm">
            @if ($prev)
                <a href="{{ route('wiki.show', $prev->slug) }}"
                   class="flex items-center gap-2 text-stone-500 hover:text-stone-800 transition-colors max-w-[45%]">
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
                   class="flex items-center gap-2 text-stone-500 hover:text-stone-800 transition-colors max-w-[45%] text-right">
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
<footer class="border-t border-stone-200 mt-8">
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
