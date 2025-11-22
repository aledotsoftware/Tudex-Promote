<?php

use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = Creative::find(12);
if ($c) {
    echo "Creative 12:\n";
    echo "  Campaign ID: {$c->campaign_id}\n";
    echo "  Type: {$c->type}\n";
    echo "  Is Active: " . ($c->is_active ? 'YES' : 'NO') . " (Value: " . var_export($c->is_active, true) . ")\n";
} else {
    echo "Creative 12 not found.\n";
}
