<?php

use App\Models\Campaign;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$campaigns = Campaign::all();
if ($campaigns->isEmpty()) {
    echo "No campaigns found. Creating one...\n";
    $campaign = Campaign::create([
        'user_id' => 1, // Assuming user 1 exists
        'name' => 'Default Campaign',
        'budget' => 1000,
        'model' => 'cpc',
        'status' => 'active',
        'is_active' => true
    ]);
} else {
    echo "Found " . $campaigns->count() . " campaigns.\n";
    foreach ($campaigns as $c) {
        echo "ID: {$c->id} | Name: {$c->name} | Active: " . ($c->is_active ? 'YES' : 'NO') . "\n";
        if (!$c->is_active) {
            $c->update(['is_active' => true]);
            echo "  -> Activated.\n";
        }
    }
}
