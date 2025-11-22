<?php

use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$types = ['banner', 'vertical', 'square'];

foreach ($types as $type) {
    echo "Checking type: {$type} ... ";
    $c = Creative::where('type', $type)
        ->whereHas('campaign', function ($q) {
            $q->where('is_active', true);
        })
        ->where('is_active', true)
        ->first();
        
    if ($c) {
        echo "OK (Found ID {$c->id})\n";
    } else {
        echo "FAIL (Not found)\n";
    }
}
