<?php

use App\Models\Creative;
use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting creative regeneration...\n";

try {
    $creatives = Creative::all();
    echo "Found " . $creatives->count() . " creatives.\n";

    $templatePath = resource_path('views/creatives/templates/default.php');
    if (!file_exists($templatePath)) {
        die("Error: Template file not found at $templatePath\n");
    }
    $template = file_get_contents($templatePath);
    $template = str_replace("\r\n", "\n", $template);

    $updatedCount = 0;
    $failedCount = 0;

    foreach ($creatives as $creative) {
        echo "Processing Creative ID: {$creative->id}...\n";
        
        $html = $creative->html_content;
        
        // Patterns for old template
        $titlePattern = '/<h1 class="tudex-ad-title.*?">(.*?)<\/h1>/s';
        $descPattern = '/<p class="tudex-ad-description.*?">(.*?)<\/p>/s';

        $title = '';
        $description = '';

        if (preg_match($titlePattern, $html, $matches)) {
            $title = $matches[1];
        } elseif (preg_match('/class="ad-title-[^"]+">(.*?)<\/h1>/s', $html, $matches)) {
             $title = $matches[1];
        } else {
            // Try to look for any h1 if specific classes fail, or just use a placeholder
             if (preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $matches)) {
                $title = $matches[1];
             } else {
                echo "  [WARN] Could not extract title. Skipping.\n";
                $failedCount++;
                continue;
             }
        }

        if (preg_match($descPattern, $html, $matches)) {
            $description = $matches[1];
        } elseif (preg_match('/class="ad-description-[^"]+">(.*?)<\/p>/s', $html, $matches)) {
            $description = $matches[1];
        } else {
            // Try generic p
            if (preg_match('/<p[^>]*>(.*?)<\/p>/s', $html, $matches)) {
                $description = $matches[1];
            } else {
                echo "  [WARN] Could not extract description. Using empty string.\n";
                $description = '';
            }
        }

        // Decode HTML entities because they will be re-encoded
        $title = htmlspecialchars_decode(strip_tags($title));
        $description = htmlspecialchars_decode(strip_tags($description));

        echo "  Title: " . substr($title, 0, 30) . "...\n";

        // Prepare variables for replacement
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

        $newHtml = str_replace(array_keys($variables), array_values($variables), $template);

        $creative->html_content = $newHtml;
        $creative->save();
        $updatedCount++;
        echo "  Updated successfully.\n";
    }

    echo "\nSummary:\n";
    echo "Total processed: " . $creatives->count() . "\n";
    echo "Updated: $updatedCount\n";
    echo "Failed/Skipped: $failedCount\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
