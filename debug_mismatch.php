<?php

use App\Models\AdZone;
use App\Models\Campaign;
use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$zoneId = 4;
$campaignId = 4; // Assuming the user meant Campaign 4 is the one they expect to show

echo "--- Ad Zone {$zoneId} ---\n";
$zone = AdZone::find($zoneId);
if ($zone) {
    echo "Type: " . ($zone->type ?? 'banner (default)') . "\n";
    echo "Site ID: {$zone->site_id}\n";
} else {
    echo "Ad Zone not found!\n";
}

echo "\n--- Campaign {$campaignId} ---\n";
$campaign = Campaign::find($campaignId);
if ($campaign) {
    echo "Name: {$campaign->name}\n";
    echo "Active: " . ($campaign->is_active ? 'Yes' : 'No') . "\n";
    
    echo "\n--- Creatives in Campaign {$campaignId} ---\n";
    $creatives = $campaign->creatives;
    if ($creatives->isEmpty()) {
        echo "No creatives found in this campaign.\n";
    } else {
        foreach ($creatives as $c) {
            echo "ID: {$c->id} | Type: {$c->type} | Active: " . ($c->is_active ? 'Yes' : 'No') . "\n";
        }
    }
} else {
    echo "Campaign not found!\n";
}

echo "\n--- Matching Logic Check ---\n";
if ($zone && $campaign) {
    $type = $zone->type ?? 'banner';
    $matchingCreatives = Creative::where('campaign_id', $campaign->id)
        ->where('type', $type)
        ->where('is_active', true)
        ->count();
    echo "Creatives matching Zone Type '{$type}' and Active: {$matchingCreatives}\n";
}
