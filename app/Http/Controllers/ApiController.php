<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AdZone;
use App\Models\AdClick;
use App\Models\Campaign;
use App\Models\Placement;
use App\Models\AdImpression;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function adRequest(AdZone $adZone)
    {
        // Choose creatives by type (the creatives table doesn't include width/height).
        $type = $adZone->type ?? 'banner';

        // Prefer creatives of the same type from active campaigns.
        $creative = \App\Models\Creative::where('type', $type)
            ->whereHas('campaign', function ($q) {
                $q->where('status', 'active');
            })
            ->inRandomOrder()
            ->first();

        // Fallback: any creative from an active campaign
        if (! $creative) {
            $creative = \App\Models\Creative::whereHas('campaign', function ($q) {
                $q->where('status', 'active');
            })->inRandomOrder()->first();
        }

        if (! $creative) {
            return response()->json(['error' => 'No creatives available'], 404);
        }

        // Ensure the creative has a valid file in storage
        $disk = Storage::disk('public');
        if (! $disk->exists($creative->file_url)) {
            return response()->json(['error' => 'Creative file not found'], 404);
        }

        // Create a placement record. Include site_id because the placements table
        // requires it in this schema.
        $placement = Placement::create([
            'creative_id' => $creative->id,
            'ad_zone_id' => $adZone->id,
            'site_id' => $adZone->site_id,
        ]);

        $htmlContent = $disk->get($creative->file_url);
        $clickUrl = route('api.click', $placement);
        $htmlContent = str_replace('%%CLICK_URL%%', $clickUrl, $htmlContent);

        return response()->json([
            'html_content' => $htmlContent,
            'placement_id' => $placement->id,
        ]);
    }

    public function impression(Request $request, Placement $placement)
    {
        AdImpression::create([
            'placement_id' => $placement->id,
            'impression_time' => now(),
            'page_url' => $request->input('page_url'),
            'user_agent' => $request->userAgent(),
            'metadata' => $request->except(['page_url']),
        ]);

        return response()->json(['success' => true]);
    }

    public function click(Placement $placement)
    {
        AdClick::create([
            'placement_id' => $placement->id,
            'click_time' => now(),
        ]);

        return redirect($placement->creative->click_url);
    }
}
