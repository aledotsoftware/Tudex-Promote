<?php

use App\Models\Creative;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Final regeneration with line ending fix...\n\n";

$creatives = Creative::all();

foreach ($creatives as $creative) {
    // Extract content
    $html = $creative->html_content;
    $title = $description = null;
    
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $m)) $title = trim(strip_tags($m[1]));
    if (preg_match('/<p[^>]*>(.*?)<\/p>/s', $html, $m)) $description = trim(strip_tags($m[1]));
    
    if (!$title || !$description) continue;
    
    // Load and normalize template
    $template = file_get_contents(resource_path('views/creatives/templates/default.php'));
    $template = str_replace("\r\n", "\n", $template);
    
    // Replace variables
    $html = str_replace([
        '{{TITLE}}', '{{DESCRIPTION}}', '{{CLICK_URL}}',
        '{{BG_COLOR}}', '{{TITLE_COLOR}}', '{{TEXT_COLOR}}',
        '{{BUTTON_COLOR}}', '{{BORDER_COLOR}}', '{{DOMAIN}}'
    ], [
        htmlspecialchars($title),
        htmlspecialchars($description),
        htmlspecialchars($creative->click_url),
        $creative->bg_color ?? '#ffffff',
        $creative->title_color ?? '#0f172a',
        $creative->text_color ?? '#64748b',
        $creative->button_color ?? '#3b82f6',
        $creative->border_color ?? '#e2e8f0',
        parse_url($creative->click_url, PHP_URL_HOST) ?? 'promoted'
    ], $template);
    
    $creative->html_content = $html;
    $creative->save();
    echo "✓ Regenerated #{$creative->id}: $title\n";
}

echo "\nDone!\n";
