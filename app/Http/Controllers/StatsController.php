<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdImpression;
use App\Models\AdClick;
use App\Models\Campaign;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        // Simple aggregate stats for now
        $totalImpressions = AdImpression::count();
        $totalClicks = AdClick::count();
        $activeCampaigns = Campaign::where('is_active', true)
                                   ->where('budget', '>', 0)
                                   ->where(function($query) {
                                       $now = now();
                                       $query->whereNull('start_at')->orWhere('start_at', '<=', $now);
                                   })
                                   ->where(function($query) {
                                       $now = now();
                                       $query->whereNull('end_at')->orWhere('end_at', '>=', $now);
                                   })
                                   ->count();

        // Optional: Weekly data for chart
        // This is a placeholder for future chart data
        $impressionsLast7Days = AdImpression::where('impression_time', '>=', now()->subDays(7))
            ->selectRaw('DATE(impression_time) as date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        return response()->json([
            'total_impressions' => $totalImpressions,
            'total_clicks' => $totalClicks,
            'active_campaigns' => $activeCampaigns,
            'recent_impressions' => $impressionsLast7Days,
        ]);
    }
}
