<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdZone;
use App\Models\Creative;
use App\Models\AdImpression;
use Illuminate\Http\Request;

class AdServerController extends Controller
{
    public function serveAd(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|exists:ad_zones,id',
        ]);

        $adZone = AdZone::find($request->zone_id);

        // Find a random, active creative that matches the ad zone dimensions.
        // In a real-world scenario, this logic would be much more complex,
        // involving campaign budgets, pacing, targeting, etc.
        $creative = Creative::where('width', $adZone->width)
            ->where('height', $adZone->height)
            ->whereHas('campaign', function ($query) {
                $query->where('is_active', true);
            })
            ->inRandomOrder()
            ->first();

        if (!$creative) {
            return response()->json(['error' => 'No suitable ad found.'], 404);
        }

        // Record the impression
        AdImpression::create([
            'creative_id' => $creative->id,
            'ad_zone_id' => $adZone->id,
            'impression_time' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'html' => $creative->html_content,
            'width' => $creative->width,
            'height' => $creative->height,
        ]);
    }
}
