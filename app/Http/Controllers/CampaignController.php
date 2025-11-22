<?php

namespace App\Http\Controllers;

use App\Models\AdClick;
use App\Models\AdImpression;
use App\Models\Campaign;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = auth()->user()->campaigns;
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'numeric', 'min:0'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'model' => ['required', 'string', 'in:cpc,cpm'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'description_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'accent_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'font_family' => ['nullable', 'string', 'max:255'],
        ]);

        auth()->user()->campaigns()->create($request->all());

        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        return view('campaigns.show', compact('campaign'));
    }

    public function stats(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $impressions = AdImpression::whereHas('placement.creative', function ($query) use ($campaign) {
            $query->where('campaign_id', $campaign->id);
        })->count();

        $clicks = AdClick::whereHas('placement.creative', function ($query) use ($campaign) {
            $query->where('campaign_id', $campaign->id);
        })->count();

        $ctr = $impressions > 0 ? ($clicks / $impressions) * 100 : 0;

        $stats = [
            'impressions' => $impressions,
            'clicks' => $clicks,
            'ctr' => number_format($ctr, 2) . '%',
        ];

        return view('campaigns.stats', compact('campaign', 'stats'));
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        $campaign->delete();

        return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully.');
    }

    public function toggleStatus(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        
        $campaign->update([
            'is_active' => ! $campaign->is_active
        ]);

        $status = $campaign->is_active ? 'activated' : 'paused';
        return redirect()->route('campaigns.index')->with('success', "Campaign {$status} successfully.");
    }
}
