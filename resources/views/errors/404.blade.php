<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Halaman Tidak Ditemukan</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/favicon.ico" sizes="any">
    @fonts
    @vite(['resources/css/app.css'])
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen flex items-center justify-center">
    <div class="text-center px-6">
        <div class="text-8xl font-bold text-stone-800 select-none mb-2">404</div>
        <h1 class="text-xl font-semibold text-stone-200 mb-2">Halaman tidak ditemukan</h1>
        <p class="text-sm text-stone-500 mb-8 max-w-sm mx-auto">
            Halaman yang kamu cari tidak ada atau sudah dipindahkan.
        </p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-stone-700 text-stone-300 text-sm hover:border-stone-500 hover:text-stone-100 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
