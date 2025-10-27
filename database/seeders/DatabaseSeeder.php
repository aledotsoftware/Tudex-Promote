<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Publisher User',
            'email' => 'publisher@example.com',
            'role' => 'publisher',
        ]);

        User::factory()->create([
            'name' => 'Advertiser User',
            'email' => 'advertiser@example.com',
            'role' => 'advertiser',
        ]);
    }
}
