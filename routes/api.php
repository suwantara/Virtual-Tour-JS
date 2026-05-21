<?php

use App\Http\Controllers\Api\V1\TourApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/venues', [TourApiController::class, 'index'])->name('api.v1.venues.index');
    Route::get('/venues/{venue:slug}', [TourApiController::class, 'show'])->name('api.v1.venues.show');
});
