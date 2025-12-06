<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Site;
use App\Models\Campaign;
use App\Models\Creative;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ========================================
        // TEST USERS
        // ========================================
        
        // Publisher User
        $publisher = User::firstOrCreate(
            ['email' => 'pub@mailinator.com'],
            [
                'name' => 'Publisher Test',
                'password' => Hash::make('Pa$$w0rd!'),
                'role' => 'publisher',
            ]
        );
        $this->command->info("✅ Publisher: pub@mailinator.com");

        // Advertiser User
        $advertiser = User::firstOrCreate(
            ['email' => 'ads@mailinator.com'],
            [
                'name' => 'Advertiser Test',
                'password' => Hash::make('Pa$$w0rd!'),
                'role' => 'advertiser',
            ]
        );
        $this->command->info("✅ Advertiser: ads@mailinator.com");

        // ========================================
        // PUBLISHER SITE
        // ========================================
        
        $site = Site::firstOrCreate(
            ['domain' => 'newempires.com'],
            [
                'user_id' => $publisher->id,
                'verified' => true,
                'verification_token' => null,
            ]
        );
        $this->command->info("✅ Site: https://newempires.com/ (ID: {$site->id})");

        // ========================================
        // CAMPAIGNS & CREATIVES
        // ========================================

        // Campaign 1: Gaming
        $campaign1 = Campaign::firstOrCreate(
            ['name' => 'New Empires - Gaming Ads'],
            [
                'advertiser_id' => $advertiser->id,
                'budget' => 5000.00,
                'start_at' => now(),
                'end_at' => now()->addYear(),
                'model' => 'cpm',
                'is_active' => true,
                'title_color' => '#ffffff',
                'description_color' => '#e0e0e0',
                'accent_color' => '#ff6b35',
                'font_family' => 'Roboto, sans-serif',
            ]
        );

        // Creative 1: Gaming Ad
        Creative::firstOrCreate(
            ['campaign_id' => $campaign1->id, 'title' => 'Build Your Empire'],
            [
                'description' => 'Conquer lands, build cities, and lead your civilization to glory in this epic strategy game.',
                'button_text' => 'Play Now Free!',
                'image_url' => null,
                'click_url' => 'https://newempires.com/play',
                'is_active' => true,
                'bg_color' => '#1a1a2e',
                'title_color' => '#ffffff',
                'text_color' => '#b0b0b0',
                'button_color' => '#ff6b35',
                'border_color' => '#2d2d44',
            ]
        );

        // Campaign 2: Tech/Software
        $campaign2 = Campaign::firstOrCreate(
            ['name' => 'Tudex Networks - Tech Ads'],
            [
                'advertiser_id' => $advertiser->id,
                'budget' => 3000.00,
                'start_at' => now(),
                'end_at' => now()->addYear(),
                'model' => 'cpc',
                'is_active' => true,
                'title_color' => '#1a0dab',
                'description_color' => '#3c4043',
                'accent_color' => '#1a73e8',
                'font_family' => 'Inter, sans-serif',
            ]
        );

        // Creative 2: Tech Ad
        Creative::firstOrCreate(
            ['campaign_id' => $campaign2->id, 'title' => 'Professional Web Solutions'],
            [
                'description' => 'Custom websites, apps, and digital marketing solutions for your business. Get started today!',
                'button_text' => 'Learn More',
                'image_url' => null,
                'click_url' => 'https://tudexnetworks.com',
                'is_active' => true,
                'bg_color' => '#ffffff',
                'title_color' => '#1a0dab',
                'text_color' => '#3c4043',
                'button_color' => '#1a73e8',
                'border_color' => '#e0e0e0',
            ]
        );

        // Campaign 3: E-commerce/Promo
        $campaign3 = Campaign::firstOrCreate(
            ['name' => 'Holiday Sale Promo'],
            [
                'advertiser_id' => $advertiser->id,
                'budget' => 2000.00,
                'start_at' => now(),
                'end_at' => now()->addMonths(3),
                'model' => 'cpm',
                'is_active' => true,
                'title_color' => '#d32f2f',
                'description_color' => '#424242',
                'accent_color' => '#4caf50',
                'font_family' => 'Poppins, sans-serif',
            ]
        );

        // Creative 3: Promo Ad
        Creative::firstOrCreate(
            ['campaign_id' => $campaign3->id, 'title' => '🎉 Holiday Sale - 50% Off!'],
            [
                'description' => 'Limited time offer! Get amazing deals on all products. Don\'t miss out on these incredible savings.',
                'button_text' => 'Shop Now 🛒',
                'image_url' => null,
                'click_url' => 'https://example.com/sale',
                'is_active' => true,
                'bg_color' => '#fff5f5',
                'title_color' => '#d32f2f',
                'text_color' => '#424242',
                'button_color' => '#4caf50',
                'border_color' => '#ffcdd2',
            ]
        );

        $this->command->info("✅ Created 3 campaigns with creatives");
        $this->command->info("");
        $this->command->info("📧 Login credentials:");
        $this->command->info("   Publisher:  pub@mailinator.com / Pa\$\$w0rd!");
        $this->command->info("   Advertiser: ads@mailinator.com / Pa\$\$w0rd!");
    }
}
