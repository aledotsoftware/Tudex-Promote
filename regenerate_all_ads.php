<?php

use Illuminate\Support\Facades\View;
use App\Models\Creative;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Regenerating all creatives with unique scoped styles...\n\n";

$creatives = Creative::all();
$updatedCount = 0;
$skippedCount = 0;

foreach ($creatives as $creative) {
    $html = $creative->html_content;
    
    // Extract title - try multiple patterns
    $title = null;
    if (preg_match('/<h1[^>]*class="[^"]*ad-title[^"]*"[^>]*>(.*?)<\/h1>/s', $html, $matches)) {
        $title = $matches[1];
    } elseif (preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $matches)) {
        $title = $matches[1];
    }

    // Extract description
    $description = null;
    if (preg_match('/<p[^>]*class="[^"]*ad-description[^"]*"[^>]*>(.*?)<\/p>/s', $html, $matches)) {
        $description = $matches[1];
    } elseif (preg_match('/<p[^>]*>(.*?)<\/p>/s', $html, $matches)) {
        $description = $matches[1];
    }

    if ($title && $description) {
        $title = trim(strip_tags($title));
        $description = trim(strip_tags($description));
        
        echo "Updating creative ID {$creative->id}:\n";
        echo "  Title: $title\n";
        echo "  Colors: bg={$creative->bg_color}, btn={$creative->button_color}\n";
        
        try {
            $newHtml = view('creatives.templates.default', [
                'title' => $title,
                'description' => $description,
                'click_url' => $creative->click_url,
                'bg_color' => $creative->bg_color ?? '#ffffff',
                'title_color' => $creative->title_color ?? '#0f172a',
                'text_color' => $creative->text_color ?? '#64748b',
                'button_color' => $creative->button_color ?? '#3b82f6',
                'border_color' => $creative->border_color ?? '#e2e8f0',
            ])->render();

            $creative->html_content = $newHtml;
            $creative->save();
            $updatedCount++;
            echo "  ✓ Success\n\n";
        } catch (\Exception $e) {
            echo "  ✗ Error: " . $e->getMessage() . "\n\n";
            $skippedCount++;
        }
    } else {
        echo "Could not extract data for creative {$creative->id}.\n";
        echo "  Title found: " . ($title ? 'Yes' : 'No') . "\n";
        echo "  Description found: " . ($description ? 'Yes' : 'No') . "\n\n";
        $skippedCount++;
    }
}

echo "=====================================\n";
echo "Done! Updated: $updatedCount, Skipped: $skippedCount\n";
