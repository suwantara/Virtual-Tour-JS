export default function TeamSection() {
  const members = [
    {
      name: "Anggota 1",
      role: "Project Manager",
      avatar: null,
    },
    {
      name: "Anggota 2",
      role: "Developer",
      avatar: null,
    },
    {
      name: "Anggota 3",
      role: "Content Writer",
      avatar: null,
    },
    {
      name: "Anggota 4",
      role: "3D Designer",
      avatar: null,
    },
  ];

  return (
    <section id="tim" className="bg-stone-950 py-16 md:py-24 border-t border-stone-800/60">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-bold tracking-tight sm:text-4xl">Tim Kami</h2>
          <div className="mt-4 mx-auto w-24 h-1 bg-rose-800 rounded-full" />
          <p className="mt-6 text-lg text-stone-400 max-w-2xl mx-auto">
            Proyek ini dikembangkan oleh mahasiswa sebagai bagian dari PBL 2025
            di bawah inisiatif Nandika — Nusantara Digital Archive.
          </p>
        </div>
        <div className="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8">
          {members.map((member) => (
            <div key={member.name} className="text-center">
              <div className="mx-auto w-24 h-24 rounded-full bg-stone-800 border border-stone-700 flex items-center justify-center">
                <svg className="w-10 h-10 text-stone-500" fill="none" viewBox="0 0 24 24" strokeWidth={1} stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
              </div>
              <h3 className="mt-4 font-semibold text-white">{member.name}</h3>
              <p className="text-sm text-stone-400">{member.role}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
