<?php

use App\Models\Creative;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$creative = Creative::find(1);

if ($creative) {
    $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<style>
    body {
        font-family: var(--ad-font-family, sans-serif);
        margin: 0;
        padding: 0;
        background: transparent;
    }
    .ad-card {
        border: 1px solid var(--ad-accent-color, #e0e0e0);
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        font-family: var(--ad-font-family, sans-serif);
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-decoration: none; /* Remove underline from anchor */
        color: inherit;
        transition: transform 0.2s;
    }
    .ad-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .ad-title {
        color: var(--ad-title-color, #1a0dab);
        font-size: 18px;
        font-weight: 600;
        line-height: 1.3;
    }
    .ad-desc {
        color: var(--ad-desc-color, #4d5156);
        font-size: 14px;
        line-height: 1.5;
    }
    .ad-cta {
        color: var(--ad-accent-color, #1a73e8);
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        margin-top: 4px;
    }
</style>
</head>
<body>
    <a href="%%CLICK_URL%%" class="ad-card" target="_blank">
        <div class="ad-title">Premium Ad Service</div>
        <div class="ad-desc">Boost your reach with our adaptive ad platform. Seamlessly integrates with your site's design.</div>
        <div class="ad-cta">Learn More &rarr;</div>
    </a>
</body>
</html>
HTML;

    $creative->html_content = $html;
    $creative->save();
    echo "Creative 1 updated successfully with new HTML template.\n";
} else {
    echo "Creative 1 not found.\n";
}
