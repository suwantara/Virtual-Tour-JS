<div
    x-data="tourViewer(@js($scenes), @js($scenes->first()['id'] ?? null))"
    x-init="init()"
    class="tour-root"
    style="--brand: {{ $primaryColor }};"
>
    {{-- Sidebar --}}
    <aside class="tour-sidebar" :class="sidebarOpen ? 'tour-sidebar--open' : ''">

        {{-- Header --}}
        <div class="tour-sidebar__header">
            <a href="{{ route('home') }}" class="tour-back-link">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $venue->name }}" class="tour-logo">
                @else
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    <span>Kembali</span>
                @endif
            </a>
            <button @click="sidebarOpen = false" class="tour-close-btn lg:hidden">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Venue info --}}
        <div class="tour-sidebar__venue">
            <h1 class="tour-venue-name">{{ $venue->name }}</h1>
            @if ($venue->description)
                <p class="tour-venue-desc">{{ $venue->description }}</p>
            @endif
        </div>

        {{-- Scene list --}}
        <nav class="tour-scene-list">
            @if ($scenes->isEmpty())
                <p class="tour-empty">Belum ada scene.</p>
            @else
                @foreach ($scenes as $scene)
                    <button
                        @click="switchScene('scene-{{ $scene['id'] }}')"
                        :class="currentSceneId === 'scene-{{ $scene['id'] }}' ? 'tour-scene-btn--active' : ''"
                        class="tour-scene-btn"
                    >
                        <div class="tour-scene-thumb">
                            @if ($scene['image_path'])
                                <img src="{{ $scene['image_path'] }}" alt="{{ $scene['name'] }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-4 h-4 tour-scene-thumb__icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159"/>
                                </svg>
                            @endif
                        </div>
                        <span class="truncate">{{ $scene['name'] }}</span>
                    </button>
                @endforeach
            @endif
        </nav>
    </aside>

    {{-- Mobile backdrop --}}
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="tour-backdrop lg:hidden"
    ></div>

    {{-- Viewer --}}
    <div class="tour-viewer">

        {{-- Top bar --}}
        <div class="tour-topbar">
            <button @click="sidebarOpen = true" class="tour-menu-btn lg:hidden">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
            <span x-text="currentSceneName" class="tour-scene-label"></span>

            {{-- Coordinate helper toggle --}}
            <button
                @click="toggleCoordHelper()"
                :class="coordHelper ? 'tour-coord-btn--active' : ''"
                class="tour-coord-btn"
                title="Tampilkan koordinat untuk penempatan hotspot"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <span class="text-xs">Koordinat</span>
            </button>
        </div>

        {{-- Coordinate overlay --}}
        <div x-show="coordHelper" class="tour-coord-overlay" x-transition>

            {{-- Crosshair --}}
            <div class="tour-crosshair" aria-hidden="true">
                <div class="tour-crosshair__h"></div>
                <div class="tour-crosshair__v"></div>
                <div class="tour-crosshair__dot"></div>
            </div>

            {{-- Coordinate card --}}
            <div class="tour-coord-card">
                <div class="tour-coord-card__label">Posisi Tengah Kamera</div>
                <div class="tour-coord-card__values">
                    <div class="tour-coord-card__row">
                        <span class="tour-coord-card__key">Pitch</span>
                        <span class="tour-coord-card__val" x-text="coordPitch + '°'"></span>
                    </div>
                    <div class="tour-coord-card__row">
                        <span class="tour-coord-card__key">Yaw</span>
                        <span class="tour-coord-card__val" x-text="coordYaw + '°'"></span>
                    </div>
                </div>
                <button @click="copyCoords()" class="tour-coord-card__copy" x-text="coordCopied ? '✓ Tersalin!' : 'Salin'"></button>
                <p class="tour-coord-card__hint">
                    Arahkan objek ke <strong>tengah layar</strong>, lalu salin koordinatnya untuk diisi di form hotspot.
                </p>
            </div>
        </div>

        {{-- Pannellum --}}
        <div id="panorama" class="w-full h-full">
            @if ($scenes->isEmpty())
                <div class="tour-no-scene">
                    <svg class="w-16 h-16 mb-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21l6.75-6.75 1.5 1.5M21 3l-9 9"/>
                    </svg>
                    <p class="text-sm">Belum ada scene untuk ditampilkan.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Hotspot Modal --}}
    <div
        x-show="modal.open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="tour-modal-overlay"
        @click.self="modal.open = false"
        @keydown.escape.window="modal.open = false"
    >
        <div class="tour-modal-backdrop"></div>

        <div class="tour-modal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <div class="tour-modal__header">
                <h3 x-text="modal.label" class="tour-modal__title"></h3>
                <button @click="modal.open = false" class="tour-modal__close">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="tour-modal__body">
                <template x-if="modal.type === 'info'">
                    <p x-text="modal.description" class="tour-modal__text"></p>
                </template>

                <template x-if="modal.type === 'url'">
                    <div class="space-y-4">
                        <p x-show="modal.description" x-text="modal.description" class="tour-modal__text"></p>
                        <a :href="safeUrl(modal.url)" target="_blank" rel="noopener noreferrer" class="tour-modal__link">
                            <span>Buka Link</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                            </svg>
                        </a>
                    </div>
                </template>

                <template x-if="modal.type === 'media'">
                    <div class="space-y-3">
                        <p x-show="modal.description" x-text="modal.description" class="tour-modal__text"></p>
                        <template x-if="modal.mediaType === 'video'">
                            <video :src="safeUrl(modal.mediaUrl)" controls class="w-full rounded-lg bg-black max-h-72"></video>
                        </template>
                        <template x-if="modal.mediaType === 'audio'">
                            <audio :src="safeUrl(modal.mediaUrl)" controls class="w-full"></audio>
                        </template>
                        <template x-if="modal.mediaType === 'image'">
                            <img :src="safeUrl(modal.mediaUrl)" :alt="modal.label" class="w-full rounded-lg object-contain max-h-80">
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<style>
    /* ── Layout ── */
    .tour-root {
        display: flex;
        height: 100vh;
        overflow: hidden;
        background: #202940;
    }

    /* ── Sidebar ── */
    .tour-sidebar {
        position: fixed;
        inset-y: 0;
        left: 0;
        z-index: 30;
        width: 18rem;
        display: flex;
        flex-direction: column;
        background: #202940;
        border-right: 1px solid #4B4038;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
    }
    @media (min-width: 1024px) {
        .tour-sidebar { position: relative; transform: translateX(0); }
    }
    .tour-sidebar--open { transform: translateX(0); }

    .tour-sidebar__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #4B4038;
    }

    .tour-back-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: rgba(202,170,152,0.8);
        text-decoration: none;
        transition: color 0.2s;
        min-height: 44px;
    }
    .tour-back-link:hover { color: #CAAA98; }

    .tour-logo { height: 1.5rem; width: auto; object-fit: contain; }

    .tour-close-btn {
        color: rgba(202,170,152,0.8); background: none; border: none;
        cursor: pointer; padding: 0.5rem; transition: color 0.2s;
    }
    .tour-close-btn:hover { color: #CAAA98; }

    .tour-sidebar__venue {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #4B4038;
    }
    .tour-venue-name {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        font-size: 0.875rem;
        color: #CAAA98;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .tour-venue-desc {
        font-size: 0.875rem;
        color: rgba(202,170,152,0.8);
        margin: 0.25rem 0 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ── Scene list ── */
    .tour-scene-list { flex: 1; overflow-y: auto; padding: 0.5rem 0; }
    .tour-empty { padding: 2rem 1rem; text-align: center; color: rgba(202,170,152,0.8); font-size: 0.875rem; }

    .tour-scene-btn {
        width: 100%;
        text-align: left;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        color: rgba(202,170,152,0.8);
        background: none;
        border: none;
        border-left: 2px solid transparent;
        cursor: pointer;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .tour-scene-btn:hover { background: rgba(75,64,56,0.5); color: #CAAA98; }
    .tour-scene-btn--active {
        background: rgba(202,170,152,0.12);
        color: #CAAA98;
        border-left-color: var(--brand, #9A8678);
    }

    .tour-scene-thumb {
        width: 3.5rem;
        height: 2.25rem;
        border-radius: 0.25rem;
        background: #4B4038;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .tour-scene-thumb__icon { color: #9A8678; }

    /* ── Backdrop ── */
    .tour-backdrop { position: fixed; inset: 0; z-index: 20; background: rgba(0,0,0,0.6); }

    /* ── Viewer ── */
    .tour-viewer { flex: 1; display: flex; flex-direction: column; min-width: 0; position: relative; }

    .tour-topbar {
        position: absolute;
        top: 0; left: 0; right: 0;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(to bottom, rgba(32,41,64,0.7), transparent);
        pointer-events: none;
    }
    .tour-menu-btn {
        pointer-events: auto;
        color: #fff;
        background: rgba(32,41,64,0.6);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem;
        cursor: pointer;
        transition: background 0.2s;
        min-width: 44px;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .tour-menu-btn:hover { background: rgba(75,64,56,0.8); }

    .tour-scene-label {
        font-family: 'Playfair Display', serif;
        font-size: 0.875rem;
        font-weight: 500;
        color: #fff;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        pointer-events: none;
        flex: 1;
    }

    /* ── Coordinate helper button ── */
    .tour-coord-btn {
        pointer-events: auto;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        color: rgba(202,170,152,0.8);
        background: rgba(32,41,64,0.6);
        border: 1px solid rgba(202,170,152,0.2);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        min-height: 44px;
        cursor: pointer;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        font-family: 'Inter', sans-serif;
    }
    .tour-coord-btn:hover { background: rgba(75,64,56,0.8); color: #CAAA98; }
    .tour-coord-btn--active {
        background: rgba(202,170,152,0.15);
        color: #CAAA98;
        border-color: rgba(202,170,152,0.5);
    }

    /* ── Coordinate overlay ── */
    .tour-coord-overlay {
        position: absolute;
        inset: 0;
        z-index: 9;
        pointer-events: none;
    }

    /* Crosshair */
    .tour-crosshair {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 60px; height: 60px;
        display: flex; align-items: center; justify-content: center;
    }
    .tour-crosshair__h {
        position: absolute;
        width: 60px; height: 1px;
        background: rgba(202,170,152,0.7);
    }
    .tour-crosshair__v {
        position: absolute;
        width: 1px; height: 60px;
        background: rgba(202,170,152,0.7);
    }
    .tour-crosshair__dot {
        position: absolute;
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #CAAA98;
        box-shadow: 0 0 0 2px rgba(32,41,64,0.8);
    }

    /* Coordinate card */
    .tour-coord-card {
        position: absolute;
        bottom: 5rem; right: 1rem;
        pointer-events: auto;
        background: rgba(20,26,48,0.95);
        border: 1px solid rgba(202,170,152,0.25);
        border-radius: 0.875rem;
        padding: 1rem 1.25rem;
        min-width: 200px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        backdrop-filter: blur(12px);
        font-family: 'Inter', sans-serif;
    }
    .tour-coord-card__label {
        font-size: 0.6875rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(202,170,152,0.6);
        margin-bottom: 0.625rem;
    }
    .tour-coord-card__values { margin-bottom: 0.75rem; }
    .tour-coord-card__row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 1rem;
        padding: 0.25rem 0;
    }
    .tour-coord-card__row + .tour-coord-card__row {
        border-top: 1px solid rgba(202,170,152,0.1);
    }
    .tour-coord-card__key {
        font-size: 0.75rem;
        color: rgba(202,170,152,0.6);
    }
    .tour-coord-card__val {
        font-size: 1rem;
        font-weight: 600;
        color: #CAAA98;
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.02em;
    }
    .tour-coord-card__copy {
        width: 100%;
        background: rgba(75,64,56,0.8);
        border: 1px solid rgba(202,170,152,0.3);
        border-radius: 0.5rem;
        color: #CAAA98;
        font-size: 0.8125rem;
        font-weight: 500;
        padding: 0.5rem;
        cursor: pointer;
        transition: background 0.2s;
        margin-bottom: 0.75rem;
        font-family: 'Inter', sans-serif;
    }
    .tour-coord-card__copy:hover { background: rgba(154,134,120,0.6); }
    .tour-coord-card__hint {
        font-size: 0.6875rem;
        color: rgba(202,170,152,0.5);
        line-height: 1.5;
        margin: 0;
    }
    .tour-coord-card__hint strong { color: rgba(202,170,152,0.75); font-weight: 500; }

    #panorama { position: relative; width: 100%; height: 100%; }
    .pnlm-container { background: #202940 !important; }

    /* Fix tooltip positioning — Pannellum miscalculates margin when scrollWidth=0 at init */
    div.pnlm-tooltip > span {
        width: max-content !important;
        margin-left: 0 !important;
        margin-top: 0 !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        top: auto !important;
        bottom: calc(100% + 10px) !important;
    }

    .tour-no-scene {
        width: 100%; height: 100%;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        color: rgba(202,170,152,0.8);
    }

    /* ── Modal ── */
    .tour-modal-overlay {
        position: fixed; inset: 0; z-index: 50;
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
    }
    .tour-modal-backdrop {
        position: absolute; inset: 0;
        background: rgba(32,41,64,0.75);
        backdrop-filter: blur(4px);
    }
    .tour-modal {
        position: relative;
        background: #202940;
        border: 1px solid #4B4038;
        border-radius: 1rem;
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        max-width: 32rem;
        width: 100%;
        overflow: hidden;
    }
    .tour-modal__header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #4B4038;
    }
    .tour-modal__title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        font-size: 1.125rem;
        color: #CAAA98;
        margin: 0;
    }
    .tour-modal__close {
        color: rgba(202,170,152,0.8); background: none; border: none; cursor: pointer;
        padding: 0.5rem; min-width: 44px; min-height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 0.375rem; transition: color 0.2s;
    }
    .tour-modal__close:hover { color: #CAAA98; }
    .tour-modal__body { padding: 1.25rem 1.5rem; }
    .tour-modal__text { color: #CAAA98; line-height: 1.65; font-size: 1rem; margin: 0; }
    .tour-modal__link {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: #4B4038; color: #CAAA98;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-size: 0.875rem; font-weight: 500;
        text-decoration: none;
        transition: background 0.2s, color 0.2s;
    }
    .tour-modal__link:hover { background: #9A8678; color: #fff; }

    /* ── Info hotspot — card tooltip ── */
    .pnlm-hotspot-base.hs-card-host {
        overflow: visible;
    }
    .pnlm-hotspot-base.hs-card-host .hs-card {
        visibility: hidden;
        opacity: 0;
        pointer-events: none;
        position: absolute;
        bottom: calc(100% + 14px);
        left: 50%;
        transform: translateX(-50%);
        min-width: 200px;
        max-width: 260px;
        background: rgba(20, 26, 48, 0.97);
        border: 1px solid rgba(202, 170, 152, 0.28);
        border-radius: 12px;
        padding: 12px 14px 10px;
        box-shadow: 0 12px 32px rgba(0,0,0,0.6), 0 0 0 1px rgba(202,170,152,0.06);
        backdrop-filter: blur(16px);
        transition: opacity 0.18s ease, visibility 0.18s ease;
        z-index: 100;
        text-align: left;
        white-space: normal;
        word-break: break-word;
    }
    .pnlm-hotspot-base.hs-card-host:hover .hs-card {
        visibility: visible;
        opacity: 1;
    }
    /* Caret pointing down toward hotspot */
    .pnlm-hotspot-base.hs-card-host .hs-card::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 8px solid rgba(20, 26, 48, 0.97);
        pointer-events: none;
    }
    .hs-card__title {
        font-family: 'Playfair Display', serif;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #CAAA98;
        line-height: 1.35;
        letter-spacing: 0.01em;
    }
    .hs-card__desc {
        font-size: 0.75rem;
        color: rgba(202, 170, 152, 0.75);
        line-height: 1.55;
        margin-top: 6px;
        padding-top: 6px;
        border-top: 1px solid rgba(202, 170, 152, 0.15);
    }
    .hs-card__hint {
        font-size: 0.6875rem;
        color: rgba(202, 170, 152, 0.4);
        margin-top: 8px;
        padding-top: 6px;
        border-top: 1px solid rgba(202, 170, 152, 0.1);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    /* ── Hotspots ── */
    .pnlm-hotspot-base.hotspot-scene-nav {
        width: 40px; height: 40px;
        background: rgba(75,64,56,0.85);
        border: 2px solid rgba(202,170,152,0.4);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.2s;
        backdrop-filter: blur(4px);
    }
    .pnlm-hotspot-base.hotspot-scene-nav:hover {
        background: rgba(154,134,120,0.9);
    }
    .pnlm-hotspot-base.hotspot-scene-nav::after {
        content: '';
        display: block;
        width: 0; height: 0;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-bottom: 11px solid rgba(202,170,152,0.9);
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script>
    function tourViewer(scenes, firstSceneId) {
        return {
            scenes,
            viewer: null,
            currentSceneId: null,
            currentSceneName: '',
            sidebarOpen: false,

            modal: {
                open: false, type: null, label: '',
                description: '', url: null, mediaUrl: null, mediaType: null,
            },

            coordHelper: false,
            coordPitch: '0.0',
            coordYaw: '0.0',
            coordCopied: false,
            _coordInterval: null,

            safeUrl(url) {
                if (!url) return '#';
                try {
                    const parsed = new URL(url);
                    return ['http:', 'https:'].includes(parsed.protocol) ? url : '#';
                } catch {
                    return '#';
                }
            },

            init() {
                if (!scenes || scenes.length === 0) return;

                const pannellumScenes = {};
                scenes.forEach(scene => {
                    const sceneKey = `scene-${scene.id}`;
                    pannellumScenes[sceneKey] = {
                        type: 'equirectangular',
                        panorama: scene.image_path || 'data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=',
                        yaw: scene.initial_yaw ?? 0,
                        pitch: scene.initial_pitch ?? 0,
                        hotSpots: this.buildHotspots(scene.hotspots || []),
                        title: scene.name,
                    };
                });

                const firstKey = `scene-${firstSceneId ?? scenes[0].id}`;

                this.viewer = pannellum.viewer('panorama', {
                    default: {
                        firstScene: firstKey,
                        autoLoad: true,
                        showZoomCtrl: true,
                        showFullscreenCtrl: true,
                        keyboardZoom: true,
                        mouseZoom: true,
                        hfov: 100,
                    },
                    scenes: pannellumScenes,
                });

                this.viewer.on('scenechange', (id) => {
                    this.currentSceneId = id;
                    const scene = scenes.find(s => `scene-${s.id}` === id);
                    this.currentSceneName = scene ? scene.name : '';
                });

                this.currentSceneId = firstKey;
                const firstScene = scenes.find(s => `scene-${s.id}` === firstKey);
                this.currentSceneName = firstScene ? firstScene.name : '';

                window.__tourOpenModal = (args) => {
                    this.modal = { open: true, ...args };
                };
            },

            toggleCoordHelper() {
                this.coordHelper = !this.coordHelper;
                if (this.coordHelper && this.viewer) {
                    this._coordInterval = setInterval(() => {
                        this.coordPitch = this.viewer.getPitch().toFixed(1);
                        this.coordYaw   = this.viewer.getYaw().toFixed(1);
                    }, 100);
                } else {
                    clearInterval(this._coordInterval);
                }
            },

            copyCoords() {
                const text = `Pitch: ${this.coordPitch}  Yaw: ${this.coordYaw}`;
                navigator.clipboard.writeText(text).then(() => {
                    this.coordCopied = true;
                    setTimeout(() => { this.coordCopied = false; }, 2000);
                });
            },

            makeCardTooltip() {
                return (hotspotDiv, args) => {
                    hotspotDiv.classList.add('hs-card-host');

                    const card = document.createElement('div');
                    card.className = 'hs-card';

                    const title = document.createElement('div');
                    title.className = 'hs-card__title';
                    title.textContent = args.label;
                    card.appendChild(title);

                    if (args.description) {
                        const desc = document.createElement('div');
                        desc.className = 'hs-card__desc';
                        desc.textContent = args.description;
                        card.appendChild(desc);
                    }

                    if (args.hint) {
                        const hint = document.createElement('div');
                        hint.className = 'hs-card__hint';
                        hint.textContent = args.hint;
                        card.appendChild(hint);
                    }

                    hotspotDiv.appendChild(card);
                };
            },

            buildHotspots(hotspots) {
                return hotspots.map(hs => {
                    const pos = { pitch: hs.pitch ?? 0, yaw: hs.yaw ?? 0 };
                    const tooltipArgs = { label: hs.label, description: hs.description };

                    if (hs.type === 'scene_link' && hs.target_scene_id) {
                        return {
                            ...pos,
                            type: 'scene',
                            sceneId: `scene-${hs.target_scene_id}`,
                            targetPitch: 0,
                            targetYaw: 0,
                            cssClass: 'hotspot-scene-nav',
                            createTooltipFunc: this.makeCardTooltip(),
                            createTooltipArgs: { ...tooltipArgs, hint: 'Klik untuk pindah scene' },
                        };
                    }

                    if (hs.type === 'url' && hs.url) {
                        return {
                            ...pos,
                            type: 'info',
                            URL: hs.url,
                            attributes: { target: '_blank', rel: 'noopener noreferrer' },
                            createTooltipFunc: this.makeCardTooltip(),
                            createTooltipArgs: { ...tooltipArgs, hint: 'Klik untuk buka link' },
                        };
                    }

                    return {
                        ...pos,
                        type: 'info',
                        createTooltipFunc: this.makeCardTooltip(),
                        createTooltipArgs: {
                            ...tooltipArgs,
                            hint: hs.type === 'media' ? 'Klik untuk lihat media' : 'Klik untuk detail',
                        },
                        clickHandlerFunc: (_evt, args) => window.__tourOpenModal(args),
                        clickHandlerArgs: {
                            type: hs.type,
                            label: hs.label,
                            description: hs.description,
                            url: hs.url,
                            mediaUrl: hs.media_url,
                            mediaType: hs.media_type,
                        },
                    };
                });
            },

            switchScene(sceneId) {
                if (this.viewer) this.viewer.loadScene(sceneId);
                this.currentSceneId = sceneId;
                this.sidebarOpen = false;
            },
        };
    }
</script>
@endpush
