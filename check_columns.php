<?php

use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Schema::getColumnListing('ad_impressions');
echo "Columns in ad_impressions: " . implode(', ', $columns) . "\n";

$columnsClicks = Schema::getColumnListing('ad_clicks');
echo "Columns in ad_clicks: " . implode(', ', $columnsClicks) . "\n";
