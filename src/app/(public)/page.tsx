import { prisma } from "@/lib/prisma";
import HeroSection from "@/components/landing/hero-section";
import AboutSection from "@/components/landing/about-section";
import TourSection from "@/components/landing/tour-section";
import ShrinesSection from "@/components/landing/shrines-section";
import TeamSection from "@/components/landing/team-section";
import ContactSection from "@/components/landing/contact-section";

export default async function HomePage() {
  const venues = await prisma.venue.findMany({
    where: { isPublished: true },
    include: { category: true },
    orderBy: { createdAt: "asc" },
  });

  const publishedVenue = venues[0] ?? null;

  return (
    <div className="bg-stone-950 text-stone-100">
      <HeroSection venue={publishedVenue} />
      <AboutSection />
      <TourSection venue={publishedVenue} />
      <ShrinesSection />
      <TeamSection />
      <ContactSection />
    </div>
  );
}
