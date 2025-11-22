<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/ad-request/{adZone}', [ApiController::class, 'adRequest']);
Route::post('/impression/{placement}', [ApiController::class, 'impression']);
Route::get('/impression/{placement}', function () {
    return response()->json(['message' => 'This endpoint is for POST requests only (automated ad impressions).'], 405);
});
Route::get('/click/{placement}', [ApiController::class, 'click'])->name('api.click');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
