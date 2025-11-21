<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CreativeController;
use App\Http\Controllers\AdZoneController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ApiController;

Route::get('/ad-tag.js', function () {
    return response(File::get(public_path('js/ad-tag.js')))
        ->header('Content-Type', 'application/javascript');
})->name('ad-tag.js');

// Fallback: expose API endpoints under /api/* with the 'api' middleware so the
// client tag can fetch ads and report impressions even if routes/api.php isn't
// being loaded by the app's route provider. Using the 'api' middleware avoids
// CSRF checks that would block beacon POSTs.
Route::prefix('api')->middleware('api')->group(function () {
    Route::get('/ad-request/{adZone}', [ApiController::class, 'adRequest']);
    Route::post('/impression/{placement}', [ApiController::class, 'impression']);
    Route::get('/click/{placement}', [ApiController::class, 'click'])->name('api.click');
});

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

    Route::resource('creatives', CreativeController::class)->middleware('role:advertiser');
    Route::resource('campaigns', CampaignController::class)->middleware('role:advertiser');
    Route::get('campaigns/{campaign}/stats', [CampaignController::class, 'stats'])->name('campaigns.stats')->middleware('role:advertiser');
    Route::resource('adzones', AdZoneController::class)->middleware('role:publisher');
    Route::get('adzones/{adzone}/tag', [AdZoneController::class, 'tag'])->name('adzones.tag')->middleware('role:publisher');
});

require __DIR__.'/auth.php';
