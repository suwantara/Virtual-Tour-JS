import Link from "next/link";
import type { Venue, Category } from "@prisma/client";

interface Props {
  venue: (Venue & { category: Category | null }) | null;
}

export default function TourSection({ venue }: Props) {
  if (!venue) return null;

  return (
    <section id="virtual-tour" className="bg-stone-900 py-16 md:py-28 relative overflow-hidden">
      <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-rose-900/10 via-transparent to-transparent" />
      <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 className="text-3xl font-bold tracking-tight sm:text-4xl">
              Tur Virtual 360°
            </h2>
            <div className="mt-4 w-24 h-1 bg-rose-800 rounded-full" />
            <p className="mt-8 text-lg leading-relaxed text-stone-300">
              Rasakan pengalaman menjelajahi Pura Desa Adat Tambawu secara
              virtual. Dengan teknologi panorama 360°, Anda dapat melihat
              setiap sudut pura, menjelajahi pelinggih-pelinggih sakral, dan
              mendapatkan informasi mendalam melalui hotspot interaktif.
            </p>
            <p className="mt-4 text-lg leading-relaxed text-stone-400">
              Dilengkapi dengan narasi audio, informasi sejarah, dan panduan
              visual yang membantu Anda memahami setiap elemen arsitektur
              tradisional Bali.
            </p>
            <div className="mt-8">
              <Link
                href={`/tour/${venue.slug}`}
                className="inline-flex items-center gap-2 bg-rose-900 hover:bg-rose-800 text-white font-medium px-8 py-3 rounded-full transition-all duration-200"
              >
                <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
                Mulai Tur Virtual
              </Link>
            </div>
          </div>
          <div className="relative aspect-square rounded-2xl overflow-hidden bg-stone-800 border border-stone-700">
            <div className="absolute inset-0 flex items-center justify-center">
              <svg className="w-16 h-16 text-stone-600" fill="none" viewBox="0 0 24 24" strokeWidth={1} stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3" />
              </svg>
            </div>
            <div className="absolute inset-0 flex items-center justify-center">
              <div className="w-20 h-20 rounded-full bg-rose-900/80 flex items-center justify-center">
                <svg className="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
