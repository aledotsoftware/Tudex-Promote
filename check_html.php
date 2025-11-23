<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$creative = \App\Models\Creative::first();
echo "Creative #{$creative->id}\n";
echo "HTML Length: " . strlen($creative->html_content) . "\n\n";
echo "First 800 chars:\n";
echo substr($creative->html_content, 0, 800) . "\n";
