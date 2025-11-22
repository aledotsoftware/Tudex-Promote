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
            'type' => 'nullable|string',
        ]);

        $siteId = $request->input('site_id');
        $type = $request->input('type', 'banner');

        // Verify site is active/verified (optional, but good practice)
        // $site = \App\Models\Site::find($siteId);
        // if (!$site->verified) ...

        // Choose creatives. We allow ANY type to be served, assuming the creative is responsive.
        // We prioritize active campaigns and active creatives.
        $creative = \App\Models\Creative::whereHas('campaign', function ($q) {
                $q->where('is_active', true);
            })
            ->where('is_active', true)
            ->inRandomOrder()
            ->first();

        if (! $creative) {
            return response()->json(['error' => 'No creatives available'], 404);
        }

        // Create a placement record.
        $placement = Placement::create([
            'creative_id' => $creative->id,
            'ad_zone_id' => null, // No longer using Ad Zones
            'site_id' => $siteId,
        ]);

        if ($creative->html_content) {
            $htmlContent = $creative->html_content;
        } else {
            // Ensure the creative has a valid file in storage
            $disk = Storage::disk('public');
            if (! $disk->exists($creative->file_url)) {
                return response()->json(['error' => 'Creative file not found'], 404);
            }
            $htmlContent = $disk->get($creative->file_url);
        }

        // Inject Campaign Styles
        $campaign = $creative->campaign;
        if ($campaign) {
            $styles = "<style>:root {";
            if ($campaign->title_color) $styles .= "--ad-title-color: {$campaign->title_color};";
            if ($campaign->description_color) $styles .= "--ad-desc-color: {$campaign->description_color};";
            if ($campaign->accent_color) $styles .= "--ad-accent-color: {$campaign->accent_color};";
            if ($campaign->font_family) $styles .= "--ad-font-family: {$campaign->font_family};";
            $styles .= "}</style>";
            
            // Prepend to HTML
            if (str_contains($htmlContent, '<head>')) {
                $htmlContent = str_replace('<head>', '<head>' . $styles, $htmlContent);
            } else {
                $htmlContent = $styles . $htmlContent;
            }
        }

        $clickUrl = route('api.click', $placement);
        $htmlContent = str_replace('%%CLICK_URL%%', $clickUrl, $htmlContent);

        return response()->json([
            'html_content' => $htmlContent,
            'placement_id' => $placement->id,
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
