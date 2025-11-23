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
            'type' => ['required', 'string', 'in:wide,tall,square,popup,interstitial'],
            'bg_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'title_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'text_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'button_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'border_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        // Load template and normalize line endings
        $templatePath = resource_path('views/creatives/templates/default.php');
        $template = file_get_contents($templatePath);
        $template = str_replace("\r\n", "\n", $template); // Normalize Windows line endings
        
        // Prepare variables for replacement
        $variables = [
            '{{TITLE}}' => htmlspecialchars($request->title),
            '{{DESCRIPTION}}' => htmlspecialchars($request->description),
            '{{CLICK_URL}}' => htmlspecialchars($request->click_url),
            '{{BG_COLOR}}' => $request->bg_color ?? '#ffffff',
            '{{TITLE_COLOR}}' => $request->title_color ?? '#0f172a',
            '{{TEXT_COLOR}}' => $request->text_color ?? '#64748b',
            '{{BUTTON_COLOR}}' => $request->button_color ?? '#3b82f6',
            '{{BORDER_COLOR}}' => $request->border_color ?? '#e2e8f0',
            '{{DOMAIN}}' => parse_url($request->click_url, PHP_URL_HOST) ?? 'promoted',
        ];
        
        $htmlContent = str_replace(array_keys($variables), array_values($variables), $template);

        Creative::create([
            'campaign_id' => $request->campaign_id,
            'html_content' => $htmlContent,
            'click_url' => $request->click_url,
            'type' => $request->type,
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
        $newCreative->impressions = 0;
        $newCreative->clicks = 0;
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
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:255'],
            'click_url' => ['sometimes', 'url'],
            'type' => ['sometimes', 'string', 'in:wide,tall,square,popup,interstitial'],
        ]);

        // If we're updating content fields, regenerate HTML
        if ($request->has(['title', 'description', 'click_url'])) {
            $templatePath = resource_path('views/creatives/templates/default.php');
            $template = file_get_contents($templatePath);
            $template = str_replace("\r\n", "\n", $template);
            
            $variables = [
                '{{TITLE}}' => htmlspecialchars($request->title ?? $creative->title),
                '{{DESCRIPTION}}' => htmlspecialchars($request->description ?? $creative->description),
                '{{CLICK_URL}}' => htmlspecialchars($request->click_url ?? $creative->click_url),
                '{{BG_COLOR}}' => $creative->bg_color ?? '#ffffff',
                '{{TITLE_COLOR}}' => $creative->title_color ?? '#0f172a',
                '{{TEXT_COLOR}}' => $creative->text_color ?? '#64748b',
                '{{BUTTON_COLOR}}' => $creative->button_color ?? '#3b82f6',
                '{{BORDER_COLOR}}' => $creative->border_color ?? '#e2e8f0',
                '{{DOMAIN}}' => parse_url($request->click_url ?? $creative->click_url, PHP_URL_HOST) ?? 'promoted',
            ];
            
            $htmlContent = str_replace(array_keys($variables), array_values($variables), $template);
            $creative->html_content = $htmlContent;
        }

        $creative->fill($request->only(['click_url', 'type']));
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
                'Type',
                'Status',
                'Click URL',
                'Impressions',
                'Clicks',
                'CTR (%)',
                'Created At',
                'Last Updated'
            ]);

            // Data
            foreach ($creatives as $creative) {
                $ctr = $creative->impressions > 0 
                    ? number_format(($creative->clicks / $creative->impressions) * 100, 2) 
                    : '0.00';

                fputcsv($file, [
                    $creative->id,
                    $creative->campaign->name ?? 'N/A',
                    ucfirst($creative->type),
                    $creative->is_active ? 'Active' : 'Paused',
                    $creative->click_url,
                    $creative->impressions,
                    $creative->clicks,
                    $ctr,
                    $creative->created_at->format('Y-m-d H:i:s'),
                    $creative->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

