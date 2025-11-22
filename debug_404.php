<?php

use App\Models\Creative;
use App\Models\Campaign;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$siteId = 3;
$type = 'banner';

echo "Checking for creatives matching:\n";
echo "Site ID: {$siteId} (Not used for filtering, just context)\n";
echo "Type: {$type}\n";

$query = Creative::where('type', $type)
    ->whereHas('campaign', function ($q) {
        $q->where('is_active', true);
    })
    ->where('is_active', true);

$count = $query->count();
echo "Found {$count} matching creatives.\n";

if ($count === 0) {
    echo "\n--- Debugging Why ---\n";
    
    echo "1. Checking for ANY creatives of type '{$type}':\n";
    $anyType = Creative::where('type', $type)->count();
    echo "   Found: {$anyType}\n";
    
    echo "2. Checking for Active Campaigns:\n";
    $activeCampaigns = Campaign::where('is_active', true)->pluck('id');
    echo "   Active Campaign IDs: " . $activeCampaigns->implode(', ') . "\n";
    
    if ($anyType > 0) {
        echo "3. Checking status of '{$type}' creatives:\n";
        $creatives = Creative::where('type', $type)->get();
        foreach ($creatives as $c) {
            $campActive = $activeCampaigns->contains($c->campaign_id) ? 'Yes' : 'No';
            echo "   Creative ID {$c->id}: Active={$c->is_active}, Campaign ID={$c->campaign_id} (Active: {$campActive})\n";
        }
    }
}
