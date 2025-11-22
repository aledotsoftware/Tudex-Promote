<?php

namespace App\Http\Controllers;

use App\Models\Creative;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CreativeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For simplicity, we'll assume the advertiser has campaigns and we'll fetch creatives through them.
        // This will need to be more robust later.
        $creatives = Creative::whereIn('campaign_id', auth()->user()->campaigns->pluck('id'))->get();

        return view('creatives.index', compact('creatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campaigns = auth()->user()->campaigns;

        if ($campaigns->isEmpty()) {
            return redirect()->route('campaigns.create')->with('info', 'You need to create a campaign before adding creatives.');
        }

        return view('creatives.create', compact('campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => ['required', 'exists:campaigns,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'click_url' => ['required', 'url'],
        ]);

        // Generate HTML content from title and description
        $htmlContent = view('creatives.templates.default', [
            'title' => $request->title,
            'description' => $request->description,
            'click_url' => $request->click_url,
        ])->render();

        Creative::create([
            'campaign_id' => $request->campaign_id,
            'html_content' => $htmlContent,
            'click_url' => $request->click_url,
            'type' => 'html',
        ]);

        return redirect()->route('creatives.index')->with('success', 'Creative added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Creative $creative)
    {
        $this->authorize('view', $creative);

        return view('creatives.show', compact('creative'));
    }

    public function destroy(Creative $creative)
    {
        $this->authorize('delete', $creative);
        $creative->delete();

        return redirect()->route('creatives.index')->with('success', 'Creative deleted successfully.');
    }

    public function toggleStatus(Creative $creative)
    {
        $this->authorize('update', $creative);
        
        $creative->update([
            'is_active' => ! $creative->is_active
        ]);

        $status = $creative->is_active ? 'activated' : 'paused';
        return redirect()->route('creatives.index')->with('success', "Creative {$status} successfully.");
    }
}
