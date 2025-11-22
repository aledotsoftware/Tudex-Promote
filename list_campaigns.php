<?php

use App\Models\Campaign;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- All Campaigns ---\n";
$campaigns = Campaign::all();
foreach ($campaigns as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Active: {$c->is_active}\n";
}
