<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sites.index', [
            'sites' => auth()->user()->sites,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function show(Site $site)
    {
        $this->authorize('view', $site);

        return view('sites.show', compact('site'));
    }

    public function tag(\App\Models\AdZone $adZone)
    {
        $this->authorize('view', $adZone->site);

        return view('sites.tag', compact('adZone'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'domain' => ['required', 'string', 'unique:sites,domain', 'max:255'],
        ]);

        $request->user()->sites()->create([
            'domain' => $request->domain,
            'verification_token' => \Illuminate\Support\Str::random(32),
        ]);

        return redirect()->route('sites.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        //
    }

    public function verify(Site $site)
    {
        $this->authorize('update', $site);

        // Method 1: DNS TXT Record Verification
        try {
            $records = dns_get_record('adverify.' . $site->domain, DNS_TXT);
            foreach ($records as $record) {
                if (isset($record['txt']) && $record['txt'] === $site->verification_token) {
                    $site->update([
                        'verified' => true,
                        'verification_expires_at' => now()->addYear(),
                    ]);
                    return redirect()->route('sites.index')->with('success', 'Site verified successfully using DNS.');
                }
            }
        } catch (\Exception $e) {
            // DNS query failed, proceed to next method
        }

        // Method 2: ads.txt File Verification
        try {
            $adsTxtContent = file_get_contents('https://' . $site->domain . '/ads.txt');
            if (str_contains($adsTxtContent, $site->verification_token)) {
                $site->update([
                    'verified' => true,
                    'verification_expires_at' => now()->addYear(),
                ]);
                return redirect()->route('sites.index')->with('success', 'Site verified successfully using ads.txt.');
            }
        } catch (\Exception $e) {
            // File could not be fetched
        }

        return redirect()->route('sites.index')->with('error', 'Could not verify site. Please check the instructions and try again.');
    }
}
