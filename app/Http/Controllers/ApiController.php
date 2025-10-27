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
        // Find an active campaign with a creative that matches the ad zone dimensions
        $campaign = Campaign::where('status', 'active')
            ->whereHas('creatives', function ($query) use ($adZone) {
                $query->where('width', $adZone->width)->where('height', $adZone->height);
            })
            ->inRandomOrder()
            ->first();

        if (!$campaign) {
            return response()->json(['error' => 'No matching ad found'], 404);
        }

        $creative = $campaign->creatives()
            ->where('width', $adZone->width)
            ->where('height', $adZone->height)
            ->inRandomOrder()
            ->first();

        // Create a placement record
        $placement = Placement::create([
            'creative_id' => $creative->id,
            'ad_zone_id' => $adZone->id,
        ]);

        $htmlContent = Storage::disk('public')->get($creative->file_url);
        $clickUrl = route('api.click', $placement);
        $htmlContent = str_replace('%%CLICK_URL%%', $clickUrl, $htmlContent);

        return response()->json([
            'html_content' => $htmlContent,
            'placement_id' => $placement->id,
        ]);
    }

    public function impression(Placement $placement)
    {
        AdImpression::create([
            'placement_id' => $placement->id,
            'impression_time' => now(),
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
