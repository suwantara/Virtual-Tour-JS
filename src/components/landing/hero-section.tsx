import Link from "next/link";
import type { Venue, Category } from "@prisma/client";

interface Props {
  venue: (Venue & { category: Category | null }) | null;
}

export default function HeroSection({ venue }: Props) {
  return (
    <section
      id="hero"
      className="relative min-h-screen flex flex-col items-center justify-center overflow-hidden"
    >
      <div className="absolute inset-0 bg-gradient-to-b from-stone-950/60 via-stone-950/30 to-stone-950" />
      <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-rose-900/20 via-transparent to-transparent" />

      <div className="relative z-10 mx-auto max-w-4xl px-4 text-center">
        <h1 className="font-display text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl">
          Pura Desa
          <br />
          <span className="text-rose-300">Adat Tambawu</span>
        </h1>
        <p className="mt-6 mx-auto max-w-2xl text-lg leading-relaxed text-stone-300">
          Jelajahi warisan budaya dan spiritual Pura Desa Adat Tambawu melalui
          tur virtual interaktif 360°. Temukan keindahan arsitektur, sejarah,
          dan nilai-nilai sakral yang telah dijaga selama berabad-abad.
        </p>
        <div className="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
          {venue ? (
            <Link
              href={`/tour/${venue.slug}`}
              className="inline-flex items-center gap-2 bg-rose-900 hover:bg-rose-800 text-white font-medium px-8 py-3 rounded-full transition-all duration-200"
            >
              <svg
                className="w-4 h-4"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M8 5v14l11-7z" />
              </svg>
              Mulai Tur Virtual
            </Link>
          ) : null}
          <Link
            href="/wiki"
            className="inline-flex items-center gap-2 border border-stone-600 hover:border-stone-400 text-stone-300 hover:text-white font-medium px-8 py-3 rounded-full transition-all duration-200"
          >
            <svg
              className="w-4 h-4"
              fill="none"
              viewBox="0 0 24 24"
              strokeWidth={1.5}
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"
              />
            </svg>
            Jelajahi Wiki
          </Link>
        </div>
      </div>

      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg
          className="w-6 h-6 text-stone-500"
          fill="none"
          viewBox="0 0 24 24"
          strokeWidth={1.5}
          stroke="currentColor"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
          />
        </svg>
      </div>
    </section>
  );
}
