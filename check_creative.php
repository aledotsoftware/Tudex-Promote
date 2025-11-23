<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$creative = \App\Models\Creative::first();
if ($creative) {
    echo "Creative ID: " . $creative->id . PHP_EOL;
    echo "HTML Length: " . strlen($creative->html_content) . " chars" . PHP_EOL;
    echo "Has title_color: " . ($creative->title_color ? $creative->title_color : 'NULL') . PHP_EOL;
    echo "Has button_color: " . ($creative->button_color ? $creative->button_color : 'NULL') . PHP_EOL;
    echo PHP_EOL . "First 800 characters of HTML:" . PHP_EOL;
    echo substr($creative->html_content, 0, 800) . PHP_EOL;
} else {
    echo "No creatives found";
}
