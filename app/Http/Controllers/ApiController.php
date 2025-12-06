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
    public function adRequest(Request $request)
    {
        $request->validate([
            'site_id' => 'required|exists:sites,id',
            'format' => 'nullable|string|in:wide,tall,square,popup,native',
        ]);

        $siteId = $request->input('site_id');
        $format = $request->input('format', $request->input('type', 'wide')); // Support both 'format' and 'type' params

        // Choose a random active creative from active campaigns
        $creative = \App\Models\Creative::whereHas('campaign', function ($q) {
                $q->where('is_active', true);
            })
            ->where('is_active', true)
            ->inRandomOrder()
            ->first();

        if (! $creative) {
            return response()->json(['error' => 'No creatives available'], 404);
        }

        // Create a placement record
        $placement = Placement::create([
            'creative_id' => $creative->id,
            'ad_zone_id' => null,
            'site_id' => $siteId,
        ]);

        // Generate HTML dynamically based on the requested format
        $clickUrl = route('api.click', $placement);
        $htmlContent = $creative->generateHtml($format, $clickUrl);

        return response()->json([
            'html_content' => $htmlContent,
            'placement_id' => $placement->id,
            'format' => $format,
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
          ->header('Pragma', 'no-cache')
          ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    public function impression(Request $request, Placement $placement)
    {
        AdImpression::create([
            'placement_id' => $placement->id,
            'creative_id' => $placement->creative_id,
            'site_id' => $placement->site_id,
            'ad_zone_id' => null,
            'ip_hash' => hash('sha256', $request->ip()),
            'impression_time' => now(),
            'page_url' => $request->input('page_url'),
            'user_agent' => $request->userAgent(),
            'metadata' => $request->except(['page_url']),
        ]);

        return response()->json(['success' => true]);
    }

    public function click(Request $request, Placement $placement)
    {
        // Try to find the latest impression for this placement to link the click
        $impression = AdImpression::where('placement_id', $placement->id)
            ->latest()
            ->first();

        $click = AdClick::create([
            'placement_id' => $placement->id,
            'creative_id' => $placement->creative_id,
            'site_id' => $placement->site_id,
            'ad_zone_id' => null,
            'ad_impression_id' => $impression ? $impression->id : null,
            'click_time' => now(),
        ]);

        $destinationUrl = $placement->creative->click_url;
        $separator = parse_url($destinationUrl, PHP_URL_QUERY) ? '&' : '?';
        
        $trackingParams = http_build_query([
            'utm_source' => 'tudex-promote',
            'utm_medium' => 'cpc',
            'utm_campaign' => $placement->creative->campaign->name ?? 'unknown',
            'ad_campaign_id' => $placement->creative->campaign_id,
            'ad_creative_id' => $placement->creative_id,
            'ad_placement_id' => $placement->id,
            'ad_click_id' => $click->id,
        ]);

        return redirect($destinationUrl . $separator . $trackingParams);
    }
}
