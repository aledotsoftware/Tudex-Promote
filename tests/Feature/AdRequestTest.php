<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Creative;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_ad_request_ignores_non_html_creatives()
    {
        Storage::fake('public');

        // Create user and site
        $user = User::factory()->create();
        $site = Site::create([
            'user_id' => $user->id,
            'domain' => 'example.com',
            'is_verified' => true,
        ]);

        // Create campaign
        $campaign = Campaign::create([
            'advertiser_id' => $user->id,
            'name' => 'Test Campaign',
            'is_active' => true,
            'start_at' => now(),
            'end_at' => now()->addDays(30),
            'budget' => 1000,
            'model' => 'CPC',
        ]);

        // Create dummy image file
        $file = UploadedFile::fake()->image('ad.jpg');
        $path = $file->store('creatives', 'public');

        // Create creative with file_url pointing to image
        // and NO html_content
        Creative::create([
            'campaign_id' => $campaign->id,
            'file_url' => $path,
            'click_url' => 'https://example.com',
            'type' => 'wide',
            'is_active' => true,
            'html_content' => null,
        ]);

        // Request ad
        $response = $this->get(route('api.ad-request', [
            'site_id' => $site->id,
            'type' => 'wide'
        ]));

        // Assert response status is 404 because image creatives should be ignored
        $response->assertStatus(404);
    }

    public function test_ad_request_serves_html_content()
    {
        // Create user and site
        $user = User::factory()->create();
        $site = Site::create([
            'user_id' => $user->id,
            'domain' => 'example.com',
            'is_verified' => true,
        ]);

        // Create campaign
        $campaign = Campaign::create([
            'advertiser_id' => $user->id,
            'name' => 'Test Campaign',
            'is_active' => true,
            'start_at' => now(),
            'end_at' => now()->addDays(30),
            'budget' => 1000,
            'model' => 'CPC',
        ]);

        // Create creative with html_content
        $html = '<div class="ad">Buy Now!</div>';
        Creative::create([
            'campaign_id' => $campaign->id,
            'file_url' => 'dummy/path/not/used.jpg',
            'click_url' => 'https://example.com',
            'type' => 'wide',
            'is_active' => true,
            'html_content' => $html,
        ]);

        // Request ad
        $response = $this->get(route('api.ad-request', [
            'site_id' => $site->id,
            'type' => 'wide'
        ]));

        // Assert response status is 200
        $response->assertStatus(200);

        // Assert content contains our HTML
        // Note: styles are appended, so exact match on 'html_content' key via assertJsonFragment won't work if content differs
        // $response->assertJsonFragment(['html_content' => $html]);

        // More robust check for content
        $content = $response->json('html_content');
        $this->assertStringContainsString($html, $content);
    }

    public function test_ad_request_serves_html_file()
    {
        Storage::fake('public');

        // Create user and site
        $user = User::factory()->create();
        $site = Site::create([
            'user_id' => $user->id,
            'domain' => 'example.com',
            'is_verified' => true,
        ]);

        // Create campaign
        $campaign = Campaign::create([
            'advertiser_id' => $user->id,
            'name' => 'Test Campaign',
            'is_active' => true,
            'start_at' => now(),
            'end_at' => now()->addDays(30),
            'budget' => 1000,
            'model' => 'CPC',
        ]);

        // Create dummy html file
        $htmlContent = '<div>File based ad</div>';
        $file = UploadedFile::fake()->create('ad.html', 1, 'text/html');
        // Manually store content because fake create creates an empty file sometimes or we want specific content
        Storage::disk('public')->put('creatives/ad.html', $htmlContent);
        $path = 'creatives/ad.html';

        // Create creative with file_url pointing to html file
        Creative::create([
            'campaign_id' => $campaign->id,
            'file_url' => $path,
            'click_url' => 'https://example.com',
            'type' => 'wide',
            'is_active' => true,
            'html_content' => null,
        ]);

        // Request ad
        $response = $this->get(route('api.ad-request', [
            'site_id' => $site->id,
            'type' => 'wide'
        ]));

        $response->assertStatus(200);

        $content = $response->json('html_content');
        $this->assertStringContainsString($htmlContent, $content);
    }
}
