<?php

use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ClearCacheController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;

Debugbar::enable();

Route::view('/', 'index')->name('index');
Route::get('/hotels/', [HotelsController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelsController::class, 'show'])->name('hotels.show');

Route::middleware('auth')->group(function () {
    Route::get('/bookings/', [BookingsController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/store/', [BookingsController::class, 'store'])->name('bookings.store');
    Route::get('/booking/{booking}', [BookingsController::class, 'show'])->name('bookings.show');
    Route::delete('/booking/{booking}/deleted/', [BookingsController::class, 'deleted'])->name('bookings.deleted');
    Route::patch('/booking/{booking}/updated/', [BookingsController::class, 'updated'])->name('bookings.updated');
    Route::post('/review/store/', [ReviewController::class, 'store'])->name('review.store');
});

Route::get('/clear', ClearCacheController::class);

//Route::middleware('admin')->group(function () {});
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

require __DIR__.'/auth.php';
