<?php

use App\Models\Creative;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Regenerating creatives with new template system...\n\n";

$creatives = Creative::all();
$updatedCount = 0;

foreach ($creatives as $creative) {
    $html = $creative->html_content;
    
    $title = null;
    $description = null;
    
    // Try to extract title and description
    if (preg_match('/<h1[^>]*class="[^"]*tudex-ad-title[^"]*"[^>]*>(.*?)<\/h1>/s', $html, $matches)) {
        $title = trim(strip_tags($matches[1]));
    } elseif (preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $matches)) {
        $title = trim(strip_tags($matches[1]));
    }
    
    if (preg_match('/<p[^>]*class="[^"]*tudex-ad-description[^"]*"[^>]*>(.*?)<\/p>/s', $html, $matches)) {
        $description = trim(strip_tags($matches[1]));
    } elseif (preg_match('/<p[^>]*>(.*?)<\/p>/s', $html, $matches)) {
        $description = trim(strip_tags($matches[1]));
    }
    
    if (!$title || !$description) {
        echo "Skipping creative #{$creative->id} - couldn't extract content\n";
        continue;
    }
    
    echo "Regenerating creative #{$creative->id}: $title\n";
    
    // Load template
    $template = file_get_contents(resource_path('views/creatives/templates/default.php'));
    
    // Replace variables
    $variables = [
        '{{TITLE}}' => htmlspecialchars($title),
        '{{DESCRIPTION}}' => htmlspecialchars($description),
        '{{CLICK_URL}}' => htmlspecialchars($creative->click_url),
        '{{BG_COLOR}}' => $creative->bg_color ?? '#ffffff',
        '{{TITLE_COLOR}}' => $creative->title_color ?? '#0f172a',
        '{{TEXT_COLOR}}' => $creative->text_color ?? '#64748b',
        '{{BUTTON_COLOR}}' => $creative->button_color ?? '#3b82f6',
        '{{BORDER_COLOR}}' => $creative->border_color ?? '#e2e8f0',
        '{{DOMAIN}}' => parse_url($creative->click_url, PHP_URL_HOST) ?? 'promoted',
    ];
    
    $htmlContent = str_replace(array_keys($variables), array_values($variables), $template);
    
    $creative->html_content = $htmlContent;
    $creative->save();
    $updatedCount++;
}

echo "\n✓ Done! Regenerated $updatedCount creatives\n";
