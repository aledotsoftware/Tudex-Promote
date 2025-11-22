<?php

use App\Models\Creative;
use App\Models\Campaign;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ACTIVE CAMPAIGNS ===\n";
$activeCampaigns = Campaign::where('is_active', true)->pluck('id');
echo "IDs: " . $activeCampaigns->implode(', ') . "\n";

echo "\n=== ACTIVE CREATIVES ===\n";
$creatives = Creative::whereIn('campaign_id', $activeCampaigns)
    ->where('is_active', true)
    ->get();

foreach ($creatives as $c) {
    echo "ID: {$c->id} | Type: {$c->type} | Campaign: {$c->campaign_id}\n";
}

echo "\n=== MISSING TYPES ===\n";
$neededTypes = ['banner', 'vertical', 'square', 'skyscraper', 'mrec'];
$existingTypes = $creatives->pluck('type')->unique()->toArray();
$missing = array_diff($neededTypes, $existingTypes);

if (!empty($missing)) {
    echo "Missing creatives for types: " . implode(', ', $missing) . "\n";
    echo "Creating placeholders for these types...\n";
    
    $campaignId = $activeCampaigns->first();
    if ($campaignId) {
        foreach ($missing as $type) {
            Creative::create([
                'campaign_id' => $campaignId,
                'file_url' => 'placeholder.jpg', // Dummy
                'html_content' => "<div style='width:100%;height:100%;background:#eee;color:#333;display:flex;align-items:center;justify-content:center;border:1px solid #ccc;'><b>{$type} Ad</b></div>",
                'click_url' => 'http://example.com',
                'width' => 100, // Dummy
                'height' => 100, // Dummy
                'type' => $type,
                'is_active' => true
            ]);
            echo "Created dummy creative for '{$type}'\n";
        }
    } else {
        echo "No active campaign found to attach dummies to.\n";
    }
} else {
    echo "All types covered.\n";
}
