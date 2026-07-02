import { notFound } from "next/navigation";
import { prisma } from "@/lib/prisma";
import TourViewer from "./tour-viewer";

interface Props {
  params: Promise<{ slug: string }>;
}

export default async function TourPage({ params }: Props) {
  const { slug } = await params;

  const venue = await prisma.venue.findUnique({
    where: { slug },
    include: {
      scenes: {
        where: { isPublished: true },
        orderBy: { order: "asc" },
        include: {
          hotspots: true,
        },
      },
    },
  });

  if (!venue || !venue.isPublished) {
    notFound();
  }

  const initialScene = venue.coverSceneId
    ? venue.scenes.find((s) => s.id === venue.coverSceneId)
    : venue.scenes[0];

  if (!initialScene) {
    return (
      <div className="bg-stone-950 text-stone-100 min-h-screen flex items-center justify-center pt-16">
        <div className="text-center">
          <h1 className="text-2xl font-bold mb-2">{venue.name}</h1>
          <p className="text-stone-400">Belum ada scene untuk tur ini.</p>
        </div>
      </div>
    );
  }

  return (
    <div className="bg-stone-950 min-h-screen">
      <TourViewer
        venueName={venue.name}
        venueLogo={venue.logoPath}
        initialScene={{
          id: initialScene.id.toString(),
          name: initialScene.name,
          imagePath: initialScene.imagePath,
          initialYaw: initialScene.initialYaw,
          initialPitch: initialScene.initialPitch,
          hotspots: initialScene.hotspots.map((h) => ({
            id: h.id.toString(),
            type: h.type,
            label: h.label,
            description: h.description,
            pitch: h.pitch,
            yaw: h.yaw,
            targetSceneId: h.targetSceneId?.toString() ?? null,
            url: h.url,
            mediaUrl: h.mediaUrl,
            mediaType: h.mediaType,
            iconColor: h.iconColor,
          })),
        }}
        scenes={venue.scenes.map((s) => ({
          id: s.id.toString(),
          name: s.name,
          imagePath: s.imagePath,
          initialYaw: s.initialYaw,
          initialPitch: s.initialPitch,
          hotspots: s.hotspots.map((h) => ({
            id: h.id.toString(),
            type: h.type,
            label: h.label,
            description: h.description,
            pitch: h.pitch,
            yaw: h.yaw,
            targetSceneId: h.targetSceneId?.toString() ?? null,
            url: h.url,
            mediaUrl: h.mediaUrl,
            mediaType: h.mediaType,
            iconColor: h.iconColor,
          })),
        }))}
      />
    </div>
  );
}
