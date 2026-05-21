<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WikiController;
use App\Livewire\TourViewer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', WelcomeController::class)->name('home');

    Route::get('/wiki', [WikiController::class, 'index'])->name('wiki.index');
    Route::get('/wiki/{slug}', [WikiController::class, 'show'])->name('wiki.show');

    Route::get('/tour/{venue:slug}', TourViewer::class)->name('tour');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', '/admin')->name('dashboard');
});

Route::get('/r2/{path}', function (string $path) {
    $disk = Storage::disk('r2');

    abort_unless($disk->exists($path), 404);

    $mimeType = $disk->mimeType($path) ?: 'application/octet-stream';
    $size = $disk->size($path);
    $lastModified = $disk->lastModified($path);
    $etag = md5($path.'.'.$lastModified.'.'.$size);

    $request = request();

    if ($request->header('If-None-Match') === $etag) {
        return response('', 304, [
            'ETag' => $etag,
            'Cache-Control' => 'public, max-age=86400, immutable',
        ]);
    }

    return response()->stream(function () use ($disk, $path) {
        $stream = $disk->readStream($path);
        while (! feof($stream)) {
            echo fread($stream, 8192);
            ob_flush();
            flush();
        }
        fclose($stream);
    }, 200, [
        'Content-Type' => $mimeType,
        'Content-Length' => $size,
        'Cache-Control' => 'public, max-age=86400, immutable',
        'Accept-Ranges' => 'bytes',
        'ETag' => $etag,
        'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified).' GMT',
    ]);
})->where('path', '.*')->name('r2.proxy');

require __DIR__.'/settings.php';
