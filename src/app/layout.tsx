import type { Metadata } from "next";
import { Inter, Public_Sans } from "next/font/google";
import "./globals.css";

const inter = Inter({
  variable: "--font-inter",
  subsets: ["latin"],
  weight: ["300", "400", "500", "600"],
});

const publicSans = Public_Sans({
  variable: "--font-public-sans",
  subsets: ["latin"],
  weight: ["400", "500", "600", "700"],
});

export const metadata: Metadata = {
  title: {
    default: "Pura Desa Adat Tambawu - Virtual Tour",
    template: "%s | Pura Desa Adat Tambawu",
  },
  description:
    "Jelajahi warisan budaya Pura Desa Adat Tambawu melalui tur virtual 360°. Temukan sejarah, arsitektur, dan ritual suci pura.",
  metadataBase: new URL(process.env.NEXT_PUBLIC_APP_URL || "http://localhost:3000"),
  openGraph: {
    type: "website",
    locale: "id_ID",
    siteName: "Pura Desa Adat Tambawu",
    title: "Pura Desa Adat Tambawu - Virtual Tour",
    description:
      "Jelajahi warisan budaya Pura Desa Adat Tambawu melalui tur virtual 360°.",
  },
  twitter: {
    card: "summary_large_image",
    title: "Pura Desa Adat Tambawu - Virtual Tour",
    description:
      "Jelajahi warisan budaya Pura Desa Adat Tambawu melalui tur virtual 360°.",
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html
      lang="id"
      className={`${inter.variable} ${publicSans.variable} h-full antialiased`}
      suppressHydrationWarning
    >
      <body className="min-h-full flex flex-col font-sans">
        {children}
      </body>
    </html>
  );
}
