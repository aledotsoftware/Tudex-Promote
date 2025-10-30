<?php

namespace App\Http\Controllers;

use App\Models\AdZone;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AdZoneController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_id' => ['required', 'exists:sites,id'],
            'name' => ['required', 'string', 'max:255'],
            'width' => ['required', 'integer', 'min:1'],
            'height' => ['required', 'integer', 'min:1'],
        ]);

        $site = \App\Models\Site::findOrFail($request->site_id);
        $this->authorize('update', $site);

        $site->adZones()->create($request->all());

        return redirect()->route('sites.show', $site);
    }

    /**
     * Display the specified resource.
     */
    public function show(AdZone $adZone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdZone $adZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdZone $adZone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdZone $adZone)
    {
        //
    }

    public function tag(AdZone $adZone)
    {
        $this->authorize('view', $adZone);

        return view('adzones.tag', compact('adZone'));
    }
}
