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
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:300'],
            'button_text' => ['nullable', 'string', 'max:30'],
            'image_url' => ['nullable', 'url'],
            'click_url' => ['required', 'url'],
            'bg_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'title_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'text_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'button_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'border_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        Creative::create([
            'campaign_id' => $request->campaign_id,
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text ?? 'Learn More',
            'image_url' => $request->image_url,
            'click_url' => $request->click_url,
            'bg_color' => $request->bg_color ?? '#ffffff',
            'title_color' => $request->title_color ?? '#0f172a',
            'text_color' => $request->text_color ?? '#64748b',
            'button_color' => $request->button_color ?? '#3b82f6',
            'border_color' => $request->border_color ?? '#e2e8f0',
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

    /**
     * Duplicate a creative
     */
    public function duplicate(Creative $creative)
    {
        $this->authorize('view', $creative);

        $newCreative = $creative->replicate();
        $newCreative->is_active = false; // Start as paused
        $newCreative->save();

        return redirect()->route('creatives.index')->with('success', 'Creative duplicated successfully. The new creative is paused.');
    }

    /**
     * Update creative (for inline editing)
     */
    public function update(Request $request, Creative $creative)
    {
        $this->authorize('update', $creative);

        $request->validate([
            'title' => ['sometimes', 'string', 'max:100'],
            'description' => ['sometimes', 'string', 'max:300'],
            'button_text' => ['sometimes', 'string', 'max:30'],
            'image_url' => ['sometimes', 'nullable', 'url'],
            'click_url' => ['sometimes', 'url'],
            'bg_color' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'title_color' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'text_color' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'button_color' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'border_color' => ['sometimes', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $creative->fill($request->only([
            'title', 'description', 'button_text', 'image_url', 'click_url',
            'bg_color', 'title_color', 'text_color', 'button_color', 'border_color'
        ]));
        $creative->save();

        return response()->json([
            'success' => true,
            'message' => 'Creative updated successfully.',
            'creative' => $creative
        ]);
    }

    /**
     * Export creatives data to CSV
     */
    public function export()
    {
        $creatives = Creative::whereIn('campaign_id', auth()->user()->campaigns->pluck('id'))
            ->with('campaign')
            ->get();

        $filename = 'creatives_export_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($creatives) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'ID',
                'Campaign',
                'Title',
                'Description',
                'Button Text',
                'Status',
                'Click URL',
                'Created At',
                'Last Updated'
            ]);

            // Data
            foreach ($creatives as $creative) {
                fputcsv($file, [
                    $creative->id,
                    $creative->campaign->name ?? 'N/A',
                    $creative->title,
                    $creative->description,
                    $creative->button_text,
                    $creative->is_active ? 'Active' : 'Paused',
                    $creative->click_url,
                    $creative->created_at->format('Y-m-d H:i:s'),
                    $creative->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Preview creative in different formats
     */
    public function preview(Creative $creative, Request $request)
    {
        $this->authorize('view', $creative);
        
        $format = $request->get('format', 'wide');
        $html = $creative->generateHtml($format);
        
        return response()->json([
            'html' => $html,
            'format' => $format
        ]);
    }
}
