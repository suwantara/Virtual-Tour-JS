import Link from "next/link";

export default function PublicLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <>
      <header className="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <nav className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex h-16 items-center justify-between">
            <Link href="/" className="text-lg font-semibold text-white">
              Pura Desa Adat Tambawu
            </Link>
            <div className="hidden md:flex items-center gap-8">
              <Link
                href="/"
                className="text-sm font-medium text-white/90 hover:text-white transition-colors"
              >
                Beranda
              </Link>
              <Link
                href="/wiki"
                className="text-sm font-medium text-white/90 hover:text-white transition-colors"
              >
                Wiki
              </Link>
              <Link
                href="/#tour"
                className="text-sm font-medium text-white/90 hover:text-white transition-colors"
              >
                Tur Virtual
              </Link>
            </div>
          </div>
        </nav>
      </header>
      <main className="flex-1">{children}</main>
      <footer className="bg-zinc-900 text-zinc-400">
        <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
              <h3 className="text-white font-semibold mb-3">
                Pura Desa Adat Tambawu
              </h3>
              <p className="text-sm leading-relaxed">
                Nandika - Nusantara Digital Archive
                <br />
                PBL 2025, Kelompok 2
              </p>
            </div>
            <div>
              <h4 className="text-white font-medium mb-3">Navigasi</h4>
              <ul className="space-y-2 text-sm">
                <li>
                  <Link href="/" className="hover:text-white transition-colors">
                    Beranda
                  </Link>
                </li>
                <li>
                  <Link
                    href="/wiki"
                    className="hover:text-white transition-colors"
                  >
                    Wiki
                  </Link>
                </li>
              </ul>
            </div>
            <div>
              <h4 className="text-white font-medium mb-3">Kontak</h4>
              <p className="text-sm leading-relaxed">
                Denpasar, Bali, Indonesia
              </p>
            </div>
          </div>
          <div className="mt-8 pt-8 border-t border-zinc-800 text-center text-sm">
            &copy; {new Date().getFullYear()} Pura Desa Adat Tambawu. Seluruh
            hak cipta dilindungi.
          </div>
        </div>
      </footer>
    </>
  );
}
