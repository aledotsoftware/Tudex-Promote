<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_site_creation_cleans_url_format()
    {
        $user = User::factory()->create(['role' => 'publisher']);

        $response = $this->actingAs($user)->post(route('sites.store'), [
            'domain' => 'https://example.com/foo',
        ]);

        $response->assertRedirect(route('sites.index'));

        $this->assertDatabaseHas('sites', [
            'domain' => 'example.com',
            'user_id' => $user->id,
        ]);
    }

    public function test_duplicate_site_with_protocol_fails_validation()
    {
        $user = User::factory()->create(['role' => 'publisher']);

        // Create existing site
        $user->sites()->create([
            'domain' => 'example.com',
            'verification_token' => 'token123',
        ]);

        // Try to create same site with protocol
        $response = $this->actingAs($user)->post(route('sites.store'), [
            'domain' => 'https://example.com/bar',
        ]);

        // Should have validation error on domain, not 500
        $response->assertSessionHasErrors('domain');
        $this->assertDatabaseCount('sites', 1);
    }

    public function test_verification_logic_works_with_cleaned_domain()
    {
        $user = User::factory()->create(['role' => 'publisher']);

        // Directly creating the site to simulate clean state
        $site = $user->sites()->create([
            'domain' => 'example.com',
            'verification_token' => 'token123',
        ]);

        try {
            $response = $this->actingAs($user)->get(route('sites.verify', $site));
            // It will likely fail verification and redirect with error, but should not crash.
            $response->assertRedirect(route('sites.index'));
            $response->assertSessionHas('error');
        } catch (\Throwable $e) {
            $this->fail('Verification crashed: ' . $e->getMessage());
        }
    }
}
