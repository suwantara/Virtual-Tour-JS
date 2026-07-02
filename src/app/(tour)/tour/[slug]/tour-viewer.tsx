"use client";

import { useEffect, useRef, useState, useCallback } from "react";
import Link from "next/link";

interface HotspotData {
  id: string;
  type: string;
  label: string;
  description: string | null;
  pitch: number;
  yaw: number;
  targetSceneId: string | null;
  url: string | null;
  mediaUrl: string | null;
  mediaType: string | null;
  iconColor: string | null;
}

interface SceneData {
  id: string;
  name: string;
  imagePath: string | null;
  initialYaw: number;
  initialPitch: number;
  hotspots: HotspotData[];
}

interface Props {
  venueName: string;
  venueLogo: string | null;
  initialScene: SceneData;
  scenes: SceneData[];
}

declare global {
  interface Window {
    pannellum: {
      viewer: (id: string, config: Record<string, unknown>) => { destroy: () => void; loadScene: (id: string, pitch?: number, yaw?: number) => void; isLoaded: () => boolean };
    };
  }
}

function loadPannellum(): Promise<void> {
  return new Promise((resolve, reject) => {
    if (window.pannellum) {
      resolve();
      return;
    }
    const script = document.createElement("script");
    script.src = "https://cdn.jsdelivr.net/npm/pannellum@2.5.7/build/pannellum.js";
    script.onload = () => {
      const link = document.createElement("link");
      link.rel = "stylesheet";
      link.href = "https://cdn.jsdelivr.net/npm/pannellum@2.5.7/build/pannellum.css";
      document.head.appendChild(link);
      resolve();
    };
    script.onerror = reject;
    document.head.appendChild(script);
  });
}

function buildSceneConfig(scene: SceneData, scenes: SceneData[], onSceneChange: (sceneId: string) => void, onHotspotClick: (hotspot: HotspotData) => void) {
  const hotspots = scene.hotspots.map((h) => {
    const base: Record<string, unknown> = {
      pitch: h.pitch,
      yaw: h.yaw,
      text: h.label,
      type: h.type,
    };

    if (h.type === "scene" && h.targetSceneId) {
      base.sceneId = h.targetSceneId;
      base.clickHandlerFunc = () => onSceneChange(h.targetSceneId!);
    } else if (h.type === "info") {
      base.clickHandlerFunc = () => onHotspotClick(h);
    } else if (h.type === "url" && h.url) {
      base.URL = h.url;
    }

    if (h.iconColor) {
      base.color = h.iconColor;
    }

    return base;
  });

  return {
    type: "equirectangular" as const,
    panorama: scene.imagePath || "https://pannellum.org/images/cerro-toco-0.jpg",
    crossOrigin: "anonymous",
    pitch: scene.initialPitch,
    yaw: scene.initialYaw,
    hfov: 100,
    autoLoad: true,
    showControls: true,
    compass: false,
    hotspots,
    hotSpotDebug: false,
  };
}

export default function TourViewer({ venueName, initialScene, scenes }: Props) {
  const viewerRef = useRef<HTMLDivElement>(null);
  const viewerInstanceRef = useRef<{ destroy: () => void; loadScene: (id: string, pitch?: number, yaw?: number) => void } | null>(null);
  const [loading, setLoading] = useState(true);
  const [currentScene, setCurrentScene] = useState(initialScene.id);
  const [activeHotspot, setActiveHotspot] = useState<HotspotData | null>(null);
  const [pannellumReady, setPannellumReady] = useState(false);
  const sceneMapRef = useRef<Map<string, SceneData>>(new Map());

  useEffect(() => {
    scenes.forEach((s) => sceneMapRef.current.set(s.id, s));
  }, [scenes]);

  const changeScene = useCallback((sceneId: string) => {
    setCurrentScene(sceneId);
    setActiveHotspot(null);
    const scene = sceneMapRef.current.get(sceneId);
    if (viewerInstanceRef.current && scene) {
      viewerInstanceRef.current.loadScene(sceneId, scene.initialPitch, scene.initialYaw);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  useEffect(() => {
    let cancelled = false;

    async function init() {
      try {
        await loadPannellum();
        if (cancelled) return;
        setPannellumReady(true);
      } catch {
        if (!cancelled) setLoading(false);
      }
    }

    init();
    return () => { cancelled = true; };
  }, []);

  useEffect(() => {
    if (!pannellumReady || !viewerRef.current) return;

    const allScenes: Record<string, Record<string, unknown>> = {};
    scenes.forEach((scene) => {
      allScenes[scene.id] = buildSceneConfig(scene, scenes, changeScene, setActiveHotspot);
      allScenes[scene.id].name = scene.name;
    });

    const viewer = window.pannellum.viewer("panorama-container", {
      default: {
        firstScene: initialScene.id,
        sceneFadeDuration: 1000,
      },
      scenes: allScenes,
    });

    viewerInstanceRef.current = viewer;
    setLoading(false);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [pannellumReady]);

  const scene = sceneMapRef.current.get(currentScene);

  return (
    <div className="relative h-screen w-screen overflow-hidden">
      <div id="panorama-container" ref={viewerRef} className="absolute inset-0" />

      {loading && (
        <div className="absolute inset-0 z-10 flex items-center justify-center bg-stone-950">
          <p className="text-stone-400">Memuat panorama...</p>
        </div>
      )}

      <div className="absolute top-0 left-0 right-0 z-10 bg-gradient-to-b from-black/60 to-transparent px-4 py-3">
        <div className="flex items-center justify-between max-w-7xl mx-auto">
          <Link
            href="/"
            className="text-white/90 hover:text-white text-sm font-medium transition-colors"
          >
            &larr; Kembali
          </Link>
          <div className="text-center">
            <h1 className="text-white font-semibold text-sm">{venueName}</h1>
            {scene && (
              <p className="text-white/70 text-xs">{scene.name}</p>
            )}
          </div>
          <div className="w-16" />
        </div>
      </div>

      {activeHotspot && (
        <div className="absolute bottom-8 left-4 right-4 z-10 max-w-md mx-auto">
          <div className="bg-stone-900/90 backdrop-blur rounded-xl border border-stone-700 p-4 text-stone-100">
            <div className="flex items-start justify-between">
              <h3 className="font-semibold text-sm">{activeHotspot.label}</h3>
              <button
                onClick={() => setActiveHotspot(null)}
                className="text-stone-400 hover:text-white ml-2"
              >
                ✕
              </button>
            </div>
            {activeHotspot.description && (
              <p className="mt-1 text-sm text-stone-300">{activeHotspot.description}</p>
            )}
          </div>
        </div>
      )}

      <div className="absolute bottom-4 right-4 z-10 flex gap-1">
        {scenes.map((s) => (
          <button
            key={s.id}
            onClick={() => changeScene(s.id)}
            className={`px-3 py-1.5 rounded-lg text-xs font-medium transition-colors ${
              currentScene === s.id
                ? "bg-white text-stone-900"
                : "bg-stone-800/80 text-stone-300 hover:bg-stone-700/80"
            }`}
          >
            {s.name}
          </button>
        ))}
      </div>
    </div>
  );
}
