<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDestinationController;
use App\Http\Controllers\AdminTimelineController;
use App\Http\Controllers\AdminCultureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/explore', [PublicController::class, 'explore'])->name('explore');
Route::get('/transum', [PublicController::class, 'transum'])->name('transum');
Route::get('/culture', [PublicController::class, 'culture'])->name('culture');
Route::get('/destination/{id}', [PublicController::class, 'showDestination'])->name('destination.show');



/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin CMS Dashboard & Operations (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/metrics', [AdminController::class, 'updateMetrics'])->name('metrics.update');
    
    Route::post('/destinations/sync', [AdminDestinationController::class, 'syncOsm'])->name('destinations.sync');
    Route::resource('destinations', AdminDestinationController::class);
    Route::resource('timelines', AdminTimelineController::class);
    Route::resource('cultures', AdminCultureController::class);
});

require __DIR__.'/auth.php';
