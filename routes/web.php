<?php

use App\Livewire\TourViewer;
use App\Services\VenueService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', function (VenueService $venueService) {
        $venues = $venueService->getPublished();

        return view('welcome', compact('venues'));
    })->name('home');

    Route::get('/tour/{venue:slug}', TourViewer::class)->name('tour');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', '/admin')->name('dashboard');
});

Route::get('/r2/{path}', function (string $path) {
    abort_unless(Storage::disk('r2')->exists($path), 404);

    $stream = Storage::disk('r2')->readStream($path);
    $mimeType = Storage::disk('r2')->mimeType($path) ?: 'application/octet-stream';

    return response()->stream(
        fn () => fpassthru($stream),
        200,
        [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]
    );
})->where('path', '.*')->name('r2.proxy');

require __DIR__.'/settings.php';
