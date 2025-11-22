<?php

use App\Models\Campaign;
use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ACTIVE CAMPAIGNS ===\n";
$activeCampaigns = Campaign::where('is_active', true)->pluck('id');
echo "IDs: " . $activeCampaigns->implode(', ') . "\n";

echo "\n=== ACTIVE CREATIVES (In Active Campaigns) ===\n";
$creatives = Creative::whereIn('campaign_id', $activeCampaigns)
    ->where('is_active', true)
    ->get();

if ($creatives->isEmpty()) {
    echo "No active creatives found in active campaigns.\n";
} else {
    foreach ($creatives as $c) {
        echo "ID: {$c->id} | Type: [{$c->type}] | Campaign ID: {$c->campaign_id}\n";
    }
}

echo "\n=== REQUEST SIMULATION ===\n";
$type = 'banner';
echo "Requesting type: '{$type}'\n";
$match = $creatives->where('type', $type)->first();
if ($match) {
    echo "MATCH FOUND: Creative ID {$match->id}\n";
} else {
    echo "NO MATCH FOUND for type '{$type}'.\n";
    echo "Available types: " . $creatives->pluck('type')->unique()->implode(', ') . "\n";
}
