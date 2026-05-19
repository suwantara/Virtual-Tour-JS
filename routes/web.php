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
    $disk = Storage::disk('r2');

    abort_unless($disk->exists($path), 404);

    $mimeType = $disk->mimeType($path) ?: 'application/octet-stream';
    $size     = $disk->size($path);

    return response()->stream(function () use ($disk, $path) {
        $stream = $disk->readStream($path);
        while (! feof($stream)) {
            echo fread($stream, 8192);
            ob_flush();
            flush();
        }
        fclose($stream);
    }, 200, [
        'Content-Type'   => $mimeType,
        'Content-Length' => $size,
        'Cache-Control'  => 'public, max-age=86400',
        'Accept-Ranges'  => 'bytes',
    ]);
})->where('path', '.*')->name('r2.proxy');

require __DIR__.'/settings.php';
