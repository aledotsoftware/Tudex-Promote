<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing new PHP template...\n\n";

try {
    $html = view('creatives.templates.default', [
        'title' => 'Test Ad Title',
        'description' => 'This is a test description for the ad',
        'click_url' => 'https://example.com/landing',
        'bg_color' => '#ffffff',
        'title_color' => '#0f172a',
        'text_color' => '#64748b',
        'button_color' => '#3b82f6',
        'border_color' => '#e2e8f0',
    ])->render();
    
    echo "✓ Render successful!\n";
    echo "HTML Length: " . strlen($html) . " bytes\n\n";
    
    // Validate HTML
    if (strpos($html, '<!DOCTYPE html>') === 0) {
        echo "✓ Valid DOCTYPE\n";
    }
    
    if (strpos($html, 'Test Ad Title') !== false) {
        echo "✓ Title present\n";
    }
    
    if (strpos($html, 'This is a test description') !== false) {
        echo "✓ Description present\n";
    }
    
    if (strpos($html, 'tudex-ad') !== false) {
        echo "✓ CSS classes present\n";
    }
    
    if (strpos($html, '#3b82f6') !== false) {
        echo "✓ Colors applied\n";
    }
    
    echo "\nFirst 500 chars:\n";
    echo substr($html, 0, 500) . "\n";
    
} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
}
