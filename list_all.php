<?php

use App\Models\Creative;
use App\Models\Campaign;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CAMPAIGNS ===\n";
$campaigns = Campaign::all();
foreach ($campaigns as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Active: " . ($c->is_active ? 'YES' : 'NO') . "\n";
}

echo "\n=== CREATIVES ===\n";
$creatives = Creative::all();
foreach ($creatives as $c) {
    echo "ID: {$c->id} | Type: {$c->type} | Active: " . ($c->is_active ? 'YES' : 'NO') . " | Campaign ID: {$c->campaign_id}\n";
}
