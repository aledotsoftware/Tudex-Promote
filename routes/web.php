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

Route::get('/api/ad-request', [ApiController::class, 'adRequest'])->name('api.ad-request');
Route::get('/api/impression/{placement}', [ApiController::class, 'impression'])->name('api.impression');
Route::get('/api/click/{placement}', [ApiController::class, 'click'])->name('api.click');



Route::get('/', function () {
    return view('welcome');
});

Route::post('/locale-switch', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'es'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('locale.switch');


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
    Route::get('sites/{site}/stats', [SiteController::class, 'stats'])->name('sites.stats')->middleware('role:publisher');

    Route::resource('creatives', CreativeController::class)->middleware('role:advertiser');
    Route::post('creatives/{creative}/toggle-status', [CreativeController::class, 'toggleStatus'])->name('creatives.toggle-status')->middleware('role:advertiser');
    Route::post('creatives/{creative}/duplicate', [CreativeController::class, 'duplicate'])->name('creatives.duplicate')->middleware('role:advertiser');
    Route::get('creatives-export', [CreativeController::class, 'export'])->name('creatives.export')->middleware('role:advertiser');
    Route::resource('campaigns', CampaignController::class)->middleware('role:advertiser');
    Route::post('campaigns/{campaign}/toggle-status', [CampaignController::class, 'toggleStatus'])->name('campaigns.toggle-status')->middleware('role:advertiser');
    Route::get('campaigns/{campaign}/stats', [CampaignController::class, 'stats'])->name('campaigns.stats')->middleware('role:advertiser');
    Route::resource('adzones', AdZoneController::class)->middleware('role:publisher');
    Route::get('adzones/{adzone}/tag', [AdZoneController::class, 'tag'])->name('adzones.tag')->middleware('role:publisher');
});

require __DIR__.'/auth.php';
