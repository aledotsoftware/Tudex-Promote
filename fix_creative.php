<?php

use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = Creative::find(12);
if ($c) {
    $c->is_active = true;
    $c->type = 'banner'; // Changing to banner to match user's test URL
    $c->save();
    echo "Creative 12 has been ACTIVATED and type set to 'banner'.\n";
}
