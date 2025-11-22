<?php

use App\Models\Campaign;
use App\Models\Creative;
use App\Models\AdZone;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ACTIVE CAMPAIGNS ===\n";
$activeCampaigns = Campaign::where('is_active', true)->get();
foreach ($activeCampaigns as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Budget: {$c->budget}\n";
}

echo "\n=== INACTIVE CAMPAIGNS ===\n";
$inactiveCampaigns = Campaign::where('is_active', false)->get();
foreach ($inactiveCampaigns as $c) {
    echo "ID: {$c->id} | Name: {$c->name}\n";
}

echo "\n=== CREATIVES (Active Campaigns Only) ===\n";
$creatives = Creative::whereHas('campaign', function ($q) {
    $q->where('is_active', true);
})->get();

foreach ($creatives as $c) {
    echo "ID: {$c->id} | Type: {$c->type} | Campaign: {$c->campaign->name} | File/Content: " . substr($c->file_url ?? $c->html_content, 0, 30) . "...\n";
}

echo "\n=== AD ZONES ===\n";
$zones = AdZone::all();
foreach ($zones as $z) {
    echo "ID: {$z->id} | Site: {$z->site->domain} | Type: {$z->type}\n";
}
