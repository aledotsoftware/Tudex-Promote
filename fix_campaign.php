<?php

use App\Models\Campaign;
use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$campaign = Campaign::find(5);
if ($campaign) {
    $campaign->update(['is_active' => true]);
    echo "Campaign '{$campaign->name}' has been ACTIVATED.\n";
} else {
    echo "Campaign 5 not found.\n";
}

$creative = Creative::find(12);
if ($creative) {
    echo "Creative 12 Type: {$creative->type}\n";
    // Optional: Change to banner if you want to force it to work with default tag
    // $creative->update(['type' => 'banner']); 
}
