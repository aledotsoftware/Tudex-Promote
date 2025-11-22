<?php

use App\Models\Campaign;
use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- Campaigns ---\n";
$campaigns = Campaign::all();
if ($campaigns->isEmpty()) {
    echo "No campaigns found.\n";
} else {
    foreach ($campaigns as $c) {
        echo "ID: {$c->id}, Name: {$c->name}, Active: {$c->is_active}\n";
    }
}

echo "\n--- Creatives ---\n";
$creatives = Creative::all();
if ($creatives->isEmpty()) {
    echo "No creatives found.\n";
} else {
    foreach ($creatives as $c) {
        $camp = $c->campaign;
        echo "ID: {$c->id}, Campaign ID: {$c->campaign_id}, Campaign Exists: " . ($camp ? 'Yes' : 'No') . "\n";
    }
}
