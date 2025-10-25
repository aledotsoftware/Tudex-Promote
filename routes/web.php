<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CreativeController;
use App\Http\Controllers\AdZoneController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/ad-tag.js', function () {
    return response(File::get(public_path('js/ad-tag.js')))
        ->header('Content-Type', 'application/javascript');
})->name('ad-tag.js');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'publisher') {
        return redirect()->route('sites.index');
    }

    if (auth()->user()->role === 'advertiser') {
        return redirect()->route('campaigns.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('sites', SiteController::class)->middleware('role:publisher');
    Route::get('sites/{site}/verify', [SiteController::class, 'verify'])->name('sites.verify')->middleware('role:publisher');
    Route::get('sites/{adZone}/tag', [SiteController::class, 'tag'])->name('sites.tag')->middleware('role:publisher');

    Route::resource('creatives', CreativeController::class)->middleware('role:advertiser');
    Route::resource('campaigns', CampaignController::class)->middleware('role:advertiser');
    Route::resource('ad-zones', AdZoneController::class)->middleware('role:publisher');
});

require __DIR__.'/auth.php';
