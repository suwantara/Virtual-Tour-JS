export default function ShrinesSection() {
  const shrines = [
    {
      name: "Padmasana",
      description: "Tempat pemujaan Ida Sang Hyang Widhi Wasa, pelinggih utama berbentuk tahta teratai.",
    },
    {
      name: "Merajan",
      description: "Pelinggih untuk memuja roh suci leluhur yang telah disucikan.",
    },
    {
      name: "Pelinggih Sedahan",
      description: "Tempat pemujaan Dewi Sri sebagai manifestasi dewi kesuburan dan kemakmuran.",
    },
    {
      name: "Bale Agung",
      description: "Tempat upacara adat dan pertemuan krama desa, fungsi sosial dan keagamaan.",
    },
  ];

  return (
    <section id="pelinggih" className="bg-stone-950 py-16 md:py-28">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-bold tracking-tight sm:text-4xl">Pelinggih</h2>
          <div className="mt-4 mx-auto w-24 h-1 bg-rose-800 rounded-full" />
          <p className="mt-6 text-lg text-stone-400 max-w-2xl mx-auto">
            Pura ini memiliki beberapa pelinggih utama yang masing-masing memiliki fungsi dan makna sakral tersendiri.
          </p>
        </div>
        <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          {shrines.map((shrine) => (
            <div
              key={shrine.name}
              className="group relative bg-stone-900 border border-stone-800 rounded-2xl p-6 hover:border-rose-900/50 transition-all duration-300"
            >
              <div className="w-12 h-12 rounded-xl bg-rose-900/20 flex items-center justify-center mb-4">
                <svg className="w-6 h-6 text-rose-400" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
              </div>
              <h3 className="text-lg font-semibold text-white group-hover:text-rose-300 transition-colors">
                {shrine.name}
              </h3>
              <p className="mt-2 text-sm text-stone-400 leading-relaxed">
                {shrine.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
