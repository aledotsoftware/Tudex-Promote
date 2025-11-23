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
}
