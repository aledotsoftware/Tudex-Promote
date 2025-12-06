<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Site;
use App\Models\Campaign;
use App\Models\Creative;
use Illuminate\Support\Facades\Hash;

class TestAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get a test user (advertiser)
        $user = User::firstOrCreate(
            ['email' => 'advertiser@test.com'],
            [
                'name' => 'Test Advertiser',
                'password' => Hash::make('password123'),
                'role' => 'advertiser',
            ]
        );

        // Create a site with ID 2 (for New Empires game)
        $site = Site::updateOrCreate(
            ['id' => 2],
            [
                'user_id' => $user->id,
                'domain' => 'new-empires.local',
                'verified' => true,
                'verification_token' => null,
            ]
        );

        // Create an active campaign
        $campaign = Campaign::firstOrCreate(
            ['name' => 'Test Campaign'],
            [
                'advertiser_id' => $user->id,
                'budget' => 1000.00,
                'start_at' => now(),
                'end_at' => now()->addYear(),
                'model' => 'cpm',
                'is_active' => true,
            ]
        );

        // Create a test HTML creative (wide banner)
        Creative::firstOrCreate(
            ['campaign_id' => $campaign->id, 'click_url' => 'https://example.com'],
            [
                'file_url' => '',
                'type' => 'html',
                'is_active' => true,
                'html_content' => '
<div style="
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 12px;
    font-family: Arial, sans-serif;
    text-align: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
" onclick="window.open(\'%%CLICK_URL%%\', \'_blank\')">
    <h3 style="margin: 0 0 10px 0; font-size: 1.5em;">🎮 New Empires - Test Ad</h3>
    <p style="margin: 0; opacity: 0.9;">This is a test advertisement from Tudex Promote</p>
    <button style="
        margin-top: 15px;
        background: white;
        color: #764ba2;
        border: none;
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: bold;
        cursor: pointer;
    ">Click Here!</button>
</div>',
            ]
        );

        $this->command->info('✅ Test ad data seeded successfully!');
        $this->command->info("   Site ID: {$site->id}");
        $this->command->info("   Campaign: {$campaign->name}");
    }
}
