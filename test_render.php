<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test rendering the template directly
echo "Testing template render...\n\n";

try {
    $html = view('creatives.templates.default', [
        'title' => 'Test Title',
        'description' => 'Test Description Here',
        'click_url' => 'https://example.com',
        'bg_color' => '#ffffff',
        'title_color' => '#0f172a',
        'text_color' => '#64748b',
        'button_color' => '#3b82f6',
        'border_color' => '#e2e8f0',
    ])->render();
    
    echo "HTML Length: " . strlen($html) . " bytes\n";
    echo "First 1000 chars:\n";
    echo substr($html, 0, 1000) . "\n\n";
    
    // Check if it's valid
    if (strpos($html, '<!DOCTYPE html>') === 0) {
        echo "✓ Starts with DOCTYPE\n";
    } else {
        echo "✗ Invalid HTML start\n";
    }
    
    if (strpos($html, '</html>') !== false) {
        echo "✓ Contains closing HTML tag\n";
    } else {
        echo "✗ Missing closing HTML tag\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
