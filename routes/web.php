<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CreativeController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'publisher') {
        return redirect()->route('sites.index');
    }

    if (auth()->user()->role === 'advertiser') {
        return redirect()->route('creatives.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('sites', SiteController::class)->middleware('role:publisher');
    Route::get('sites/{site}/verify', [SiteController::class, 'verify'])->name('sites.verify')->middleware('role:publisher');

    Route::resource('creatives', CreativeController::class)->middleware('role:advertiser');
});

require __DIR__.'/auth.php';
