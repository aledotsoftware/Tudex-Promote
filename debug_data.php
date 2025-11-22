<?php

use App\Models\Campaign;
use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$campaign = Campaign::where('is_active', true)->first();
echo "Active Campaign ID: " . ($campaign ? $campaign->id : 'None') . "\n";
if ($campaign) {
    echo "Title Color: " . $campaign->title_color . "\n";
    echo "Desc Color: " . $campaign->description_color . "\n";
    echo "Accent Color: " . $campaign->accent_color . "\n";
}

$creative = Creative::first();
echo "\nCreative ID: " . ($creative ? $creative->id : 'None') . "\n";
if ($creative) {
    echo "Click URL: " . $creative->click_url . "\n";
    echo "HTML Content Preview:\n" . substr($creative->html_content, 0, 500) . "\n";
}
