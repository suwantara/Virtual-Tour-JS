import { PrismaClient } from "@prisma/client";
import { PrismaBetterSqlite3 } from "@prisma/adapter-better-sqlite3";
import { hash } from "bcryptjs";
import "dotenv/config";

const adapter = new PrismaBetterSqlite3({
  url: "file:./dev.db",
});

const prisma = new PrismaClient({ adapter });

async function main() {
  const hashedPassword = await hash("password123", 12);

  const admin = await prisma.user.upsert({
    where: { email: "admin@tambawu.id" },
    update: {},
    create: {
      name: "Admin Tambawu",
      email: "admin@tambawu.id",
      password: hashedPassword,
      role: "admin",
    },
  });

  console.log("Admin user:", admin.email);

  const categoryArsitektur = await prisma.category.upsert({
    where: { slug: "arsitektur" },
    update: {},
    create: { name: "Arsitektur", slug: "arsitektur", description: "Bangunan dan struktur pura" },
  });

  const categoryRitual = await prisma.category.upsert({
    where: { slug: "ritual" },
    update: {},
    create: { name: "Ritual", slug: "ritual", description: "Upacara dan ritual adat" },
  });

  console.log("Categories created");

  const venue = await prisma.venue.upsert({
    where: { slug: "pura-desa-adat-tambawu" },
    update: {},
    create: {
      name: "Pura Desa Adat Tambawu",
      slug: "pura-desa-adat-tambawu",
      description: "Tur virtual 360° Pura Desa Adat Tambawu, Denpasar, Bali.",
      isPublished: true,
      categoryId: categoryArsitektur.id,
      primaryColor: "#6366f1",
    },
  });

  console.log("Venue created");

  const sceneCandiBentar = await prisma.scene.upsert({
    where: { id: 1 },
    update: {},
    create: {
      venueId: venue.id,
      name: "Candi Bentar",
      localName: "Gapura Candi Bentar",
      description: "Gapura masuk utama menuju area pura berbentuk candi bentar.",
      imagePath: "https://upload.wikimedia.org/wikipedia/commons/8/83/Equirectangular_projection_SW.jpg",
      order: 1,
      initialYaw: 0,
      initialPitch: 0,
      isPublished: true,
    },
  });

  const sceneMandala = await prisma.scene.upsert({
    where: { id: 2 },
    update: {},
    create: {
      venueId: venue.id,
      name: "Mandala Utama",
      localName: "Jeroan Pura",
      description: "Area paling suci di dalam pura tempat upacara utama berlangsung.",
      imagePath: "https://upload.wikimedia.org/wikipedia/commons/8/83/Equirectangular_projection_SW.jpg",
      order: 2,
      initialYaw: 180,
      initialPitch: 0,
      isPublished: true,
    },
  });

  console.log("Scenes created");

  await prisma.hotspot.upsert({
    where: { id: 1 },
    update: {},
    create: {
      sceneId: sceneCandiBentar.id,
      type: "scene",
      label: "Masuk ke Mandala Utama",
      description: "Lanjutkan ke area paling suci pura.",
      pitch: 0,
      yaw: 0,
      targetSceneId: sceneMandala.id,
    },
  });

  await prisma.hotspot.upsert({
    where: { id: 2 },
    update: {},
    create: {
      sceneId: sceneMandala.id,
      type: "info",
      label: "Padmasana",
      description: "Tempat suci untuk memuja Sang Hyang Widhi Wasa, berbentuk singgasana kosong.",
      pitch: 10,
      yaw: 270,
      iconColor: "#f59e0b",
    },
  });

  await prisma.hotspot.upsert({
    where: { id: 3 },
    update: {},
    create: {
      sceneId: sceneMandala.id,
      type: "scene",
      label: "Kembali ke Candi Bentar",
      pitch: 5,
      yaw: 180,
      targetSceneId: sceneCandiBentar.id,
    },
  });

  console.log("Hotspots created");

  const wikiCatSejarah = await prisma.wikiCategory.upsert({
    where: { slug: "sejarah" },
    update: {},
    create: { slug: "sejarah", name: "Sejarah", icon: "book-open", order: 1 },
  });

  const wikiCatArsitektur = await prisma.wikiCategory.upsert({
    where: { slug: "arsitektur-wiki" },
    update: {},
    create: { slug: "arsitektur-wiki", name: "Arsitektur", icon: "building", order: 2 },
  });

  const wikiCatRitual = await prisma.wikiCategory.upsert({
    where: { slug: "ritual-wiki" },
    update: {},
    create: { slug: "ritual-wiki", name: "Ritual & Upacara", icon: "flame", order: 3 },
  });

  console.log("Wiki categories created");

  await prisma.wikiArticle.upsert({
    where: { slug: "sejarah-pura-tambawu" },
    update: {},
    create: {
      slug: "sejarah-pura-tambawu",
      wikiCategoryId: wikiCatSejarah.id,
      title: "Sejarah Pura Desa Adat Tambawu",
      excerpt: "Menelusuri asal-usul dan perkembangan Pura Desa Adat Tambawu sejak masa kerajaan.",
      content: "<h2>Asal Usul</h2><p>Pura Desa Adat Tambawu merupakan salah satu pura kuno di Denpasar yang telah berdiri sejak abad ke-17. Pura ini menjadi pusat kegiatan adat dan keagamaan masyarakat setempat.</p><h2>Perkembangan</h2><p>Seiring waktu, pura ini mengalami beberapa kali renovasi dan perluasan namun tetap mempertahankan arsitektur aslinya.</p>",
      order: 1,
      isPublished: true,
    },
  });

  await prisma.wikiArticle.upsert({
    where: { slug: "candi-bentar" },
    update: {},
    create: {
      slug: "candi-bentar",
      wikiCategoryId: wikiCatArsitektur.id,
      title: "Candi Bentar",
      excerpt: "Gapura masuk utama pura berbentuk candi bentar, simbol pemisahan dunia luar dan dalam.",
      content: "<h2>Candi Bentar</h2><p>Candi bentar adalah gapura berbentuk dua bangunan serupa dan sebangun yang merupakan pintu masuk menuju area pura. Bentuknya yang terbelah melambangkan pemisahan antara dunia luar (nista) dan dunia dalam (utama).</p>",
      order: 1,
      isPublished: true,
    },
  });

  await prisma.wikiArticle.upsert({
    where: { slug: "padmasana" },
    update: {},
    create: {
      slug: "padmasana",
      wikiCategoryId: wikiCatArsitektur.id,
      title: "Padmasana",
      excerpt: "Tempat suci tertinggi berbentuk singgasana untuk memuja Sang Hyang Widhi Wasa.",
      content: "<h2>Padmasana</h2><p>Padmasana adalah bangunan suci berbentuk singgasana yang berada di posisi paling tinggi di pura. Digunakan sebagai tempat pemujaan Sang Hyang Widhi Wasa, Tuhan Yang Maha Esa dalam kepercayaan Hindu Bali.</p>",
      order: 2,
      isPublished: true,
    },
  });

  await prisma.wikiArticle.upsert({
    where: { slug: "odalan" },
    update: {},
    create: {
      slug: "odalan",
      wikiCategoryId: wikiCatRitual.id,
      title: "Upacara Odalan",
      excerpt: "Perayaan hari jadi pura yang dilaksanakan setiap 210 hari sekali.",
      content: "<h2>Odalan</h2><p>Odalan atau piodalan adalah upacara peringatan hari jadi pura yang dilaksanakan setiap 210 hari berdasarkan kalender Bali. Pada saat odalan, seluruh umat berkumpul untuk bersembahyang bersama.</p>",
      order: 1,
      isPublished: true,
    },
  });

  console.log("Wiki articles created");

  const settings = [
    { key: "site_name", value: "Pura Desa Adat Tambawu" },
    { key: "site_description", value: "Virtual Tour Pura Desa Adat Tambawu" },
    { key: "hero_title", value: "Pura Desa Adat Tambawu" },
    { key: "hero_subtitle", value: "Jelajahi warisan budaya Bali melalui tur virtual 360°" },
    { key: "about_title", value: "Tentang Pura" },
    { key: "about_text", value: "Pura Desa Adat Tambawu berdiri megah di Denpasar, Bali. Sebagai pusat kegiatan adat dan keagamaan, pura ini menyimpan kekayaan arsitektur tradisional Bali yang memukau." },
  ];

  for (const setting of settings) {
    await prisma.siteSetting.upsert({
      where: { key: setting.key },
      update: { value: setting.value },
      create: setting,
    });
  }

  console.log("Site settings created");
  console.log("Seed completed!");
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
