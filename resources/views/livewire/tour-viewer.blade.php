<div
    x-data="tourViewer(@js($scenes), @js($scenes->first()['id'] ?? null))"
    @keydown.space.window.prevent="toggleAudio()"
    x-init="init()"
    class="tour-root"
    style="--brand: {{ $primaryColor }};"
>
    {{-- Panorama (fills remaining height) --}}
    <div class="tour-viewer">

        {{-- Topbar overlay --}}
        <div class="tour-topbar">
            <a href="{{ route('home') }}" class="tour-back-link">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $venue->name }}" class="tour-logo">
                @else
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                @endif
            </a>

            <span class="tour-topbar__title">{{ $venue->name }}</span>

            <button
                @click="toggleCoordHelper()"
                :class="coordHelper ? 'tour-coord-btn--active' : ''"
                class="tour-coord-btn"
                title="Tampilkan koordinat untuk penempatan hotspot"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <span class="text-xs hidden sm:inline">Koordinat</span>
            </button>
        </div>

        {{-- Coordinate overlay --}}
        <div x-show="coordHelper" class="tour-coord-overlay" x-transition>
            <div class="tour-crosshair" aria-hidden="true">
                <div class="tour-crosshair__h"></div>
                <div class="tour-crosshair__v"></div>
                <div class="tour-crosshair__dot"></div>
            </div>
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

        {{-- Error overlay --}}
        <div
            x-show="hasError"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="tour-loading"
            style="flex-direction: column; gap: 1rem;"
        >
            <svg class="w-10 h-10 text-stone-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21l6.75-6.75 1.5 1.5M21 3l-9 9"/>
            </svg>
            <p class="text-sm text-stone-500">Foto panorama tidak dapat dimuat.</p>
        </div>

        {{-- Loading overlay --}}
        <div
            x-show="isLoading && !hasError"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="tour-loading"
        >
            <div class="tour-loading__ring"></div>
        </div>

        {{-- Pannellum container --}}
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

    {{-- Audio narration player --}}
    <div
        x-show="audioHasNarration"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="tour-audio-bar"
    >
        <button @click="toggleAudio()" class="tour-audio-btn" :title="audioPlaying ? 'Jeda narasi' : 'Putar narasi'">
            {{-- Play icon --}}
            <svg x-show="!audioPlaying" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
            {{-- Pause icon --}}
            <svg x-show="audioPlaying" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
            </svg>
        </button>

        <div class="tour-audio-info">
            <span class="tour-audio-label" x-text="audioPlaying ? 'Narasi diputar…' : 'Narasi tersedia'"></span>
            <div class="tour-audio-progress" x-show="audioPlaying">
                <div class="tour-audio-progress__bar" :style="`width: ${audioProgress}%`"></div>
            </div>
        </div>

        <button @click="stopAudio()" x-show="audioPlaying" class="tour-audio-stop" title="Berhenti">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 6h12v12H6z"/>
            </svg>
        </button>
    </div>

    {{-- Scene navigation strip --}}
    @if ($scenes->isNotEmpty())
        <div class="tour-scene-strip">
            <div class="tour-scene-strip__meta">
                <span class="tour-scene-strip__label">Lokasi</span>
                <span class="tour-scene-strip__current" x-text="currentSceneName"></span>
            </div>
            <div class="tour-scene-strip__track">
                @foreach ($scenes as $scene)
                    <button
                        @click="switchScene('scene-{{ $scene['id'] }}')"
                        :class="currentSceneId === 'scene-{{ $scene['id'] }}' ? 'tour-badge--active' : ''"
                        class="tour-badge"
                    >
                        @if ($scene['image_path'])
                            <img src="{{ $scene['image_path'] }}" alt="" class="tour-badge__thumb" crossorigin="anonymous">
                        @else
                            <div class="tour-badge__thumb--empty">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159"/>
                                </svg>
                            </div>
                        @endif
                        <span>{{ $scene['name'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Hotspot modal --}}
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

        <div
            class="tour-modal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
        >
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
            _preloadQueue: [],
            _preloadedUrls: new Set(),
            _preloadTimer: null,

            isLoading: true,
            hasError: false,

            modal: {
                open: false, type: null, label: '',
                description: '', url: null, mediaUrl: null, mediaType: null,
            },

            coordHelper: false,
            coordPitch: '0.0',
            coordYaw: '0.0',
            coordCopied: false,
            _coordInterval: null,

            _audio: null,
            _progressTimer: null,
            audioPlaying: false,
            audioHasNarration: false,
            audioProgress: 0,

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

                this.viewer.on('error', () => {
                    this.isLoading = false;
                    this.hasError = true;
                });

                this.viewer.on('scenechange', (id) => {
                    this.isLoading = true;
                    this.hasError = false;
                    this.currentSceneId = id;
                    const scene = scenes.find(s => `scene-${s.id}` === id);
                    this.currentSceneName = scene ? scene.name : '';
                    this._schedulePreload(id);
                    this._loadSceneAudio(scene);
                });

                this.currentSceneId = firstKey;
                const firstScene = scenes.find(s => `scene-${s.id}` === firstKey);
                this.currentSceneName = firstScene ? firstScene.name : '';

                this.viewer.on('load', () => {
                    this.isLoading = false;
                    this._schedulePreload(this.currentSceneId);
                    if (!this._audio) {
                        const firstScene = scenes.find(s => `scene-${s.id}` === firstKey);
                        this._loadSceneAudio(firstScene);
                    }
                });

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
                            cssClass: 'hotspot-url',
                            URL: hs.url,
                            attributes: { target: '_blank', rel: 'noopener noreferrer' },
                            createTooltipFunc: this.makeCardTooltip(),
                            createTooltipArgs: { ...tooltipArgs, hint: 'Klik untuk buka link' },
                        };
                    }

                    return {
                        ...pos,
                        type: 'info',
                        cssClass: hs.type === 'media' ? 'hotspot-media' : 'hotspot-info',
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

            _loadSceneAudio(scene) {
                this._destroyAudio();
                if (!scene?.audio_path) {
                    this.audioHasNarration = false;
                    return;
                }
                this.audioHasNarration = true;
                this._audio = new Audio(scene.audio_path);
                this._audio.addEventListener('ended', () => {
                    this.audioPlaying = false;
                    this.audioProgress = 0;
                    clearInterval(this._progressTimer);
                });
                this._audio.play().then(() => {
                    this.audioPlaying = true;
                    this._startProgressTimer();
                }).catch(() => {
                    this.audioPlaying = false;
                });
            },

            _startProgressTimer() {
                clearInterval(this._progressTimer);
                this._progressTimer = setInterval(() => {
                    if (!this._audio || !this._audio.duration) return;
                    this.audioProgress = (this._audio.currentTime / this._audio.duration) * 100;
                }, 250);
            },

            _destroyAudio() {
                if (this._audio) {
                    this._audio.pause();
                    this._audio.src = '';
                    this._audio = null;
                }
                clearInterval(this._progressTimer);
                this.audioPlaying = false;
                this.audioProgress = 0;
            },

            toggleAudio() {
                if (!this._audio) return;
                if (this._audio.paused) {
                    this._audio.play().then(() => {
                        this.audioPlaying = true;
                        this._startProgressTimer();
                    });
                } else {
                    this._audio.pause();
                    this.audioPlaying = false;
                    clearInterval(this._progressTimer);
                }
            },

            stopAudio() {
                if (!this._audio) return;
                this._audio.pause();
                this._audio.currentTime = 0;
                this.audioPlaying = false;
                this.audioProgress = 0;
                clearInterval(this._progressTimer);
            },

            switchScene(sceneId) {
                if (this.viewer) this.viewer.loadScene(sceneId);
                this.currentSceneId = sceneId;
            },

            _schedulePreload(activeSceneKey) {
                clearTimeout(this._preloadTimer);

                const activeScene = scenes.find(s => `scene-${s.id}` === activeSceneKey);
                const linkedIds = new Set(
                    (activeScene?.hotspots ?? [])
                        .filter(h => h.type === 'scene_link' && h.target_scene_id)
                        .map(h => `scene-${h.target_scene_id}`)
                );

                const linked = scenes.filter(s => linkedIds.has(`scene-${s.id}`) && s.image_path && !this._preloadedUrls.has(s.image_path));
                const rest   = scenes.filter(s => !linkedIds.has(`scene-${s.id}`) && `scene-${s.id}` !== activeSceneKey && s.image_path && !this._preloadedUrls.has(s.image_path));

                this._preloadQueue = [...linked.map(s => s.image_path), ...rest.map(s => s.image_path)];

                // slight delay so the current scene finishes loading first
                this._preloadTimer = setTimeout(() => this._drainPreloadQueue(), 800);
            },

            _drainPreloadQueue() {
                const CONCURRENCY = 2;
                const batch = this._preloadQueue.splice(0, CONCURRENCY);
                if (batch.length === 0) return;

                let done = 0;
                batch.forEach(url => {
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.onload = img.onerror = () => {
                        this._preloadedUrls.add(url);
                        done++;
                        if (done === batch.length && this._preloadQueue.length > 0) {
                            setTimeout(() => this._drainPreloadQueue(), 200);
                        }
                    };
                    img.src = url;
                });
            },
        };
    }
</script>
@endpush
