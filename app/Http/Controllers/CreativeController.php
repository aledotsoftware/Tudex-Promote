<?php

namespace App\Http\Controllers;

use App\Models\Creative;
use Illuminate\Http\Request;

class CreativeController extends Controller
{
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
            'html_content' => ['required', 'string'],
            'click_url' => ['required', 'url'],
            'width' => ['required', 'integer', 'min:1'],
            'height' => ['required', 'integer', 'min:1'],
        ]);

        // We'll store the HTML content in a file and save the path.
        $path = 'creatives/' . uniqid() . '.html';
        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $request->html_content);

        Creative::create([
            'campaign_id' => $request->campaign_id,
            'file_url' => $path,
            'click_url' => $request->click_url,
            'width' => $request->width,
            'height' => $request->height,
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

    // ... other methods are empty for now
}
