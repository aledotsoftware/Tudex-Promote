<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = \App\Models\Creative::first();
echo "HTML Length: " . strlen($c->html_content) . "\n";
echo "First 800 chars:\n";
echo substr($c->html_content, 0, 800) . "\n\n";

// Check if valid
if (strpos($c->html_content, '<!DOCTYPE html>') === 0) echo "✓ Valid DOCTYPE\n";
if (strpos($c->html_content, '¡Fulham') !== false) echo "✓ Contains title\n";
if (strpos($c->html_content, 'tudex-ad') !== false) echo "✓ Has CSS classes\n";
if (strpos($c->html_content, '#3b82f6') !== false) echo "✓ Colors present\n";
