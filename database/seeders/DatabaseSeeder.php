<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
        $colors = [
            ['name' => 'Obsidian Mist', 'variables' => 'slate'],
            ['name' => 'Urban Fog', 'variables' => 'gray'],
            ['name' => 'Steel Essence', 'variables' => 'zinc'],
            ['name' => 'Timeless Ash', 'variables' => 'neutral'],
            ['name' => 'Ancient Pebble', 'variables' => 'stone'],
            ['name' => 'Ember Pulse', 'variables' => 'red'],
            ['name' => 'Solar Flame', 'variables' => 'orange'],
            ['name' => 'Golden Nectar', 'variables' => 'amber'],
            ['name' => 'Sunlit Bloom', 'variables' => 'yellow'],
            ['name' => 'Meadow Zest', 'variables' => 'lime'],
            ['name' => 'Forest Whisper', 'variables' => 'green'],
            ['name' => 'Verdant Glow', 'variables' => 'emerald'],
            ['name' => 'Ocean Serenity', 'variables' => 'teal'],
            ['name' => 'Arctic Breeze', 'variables' => 'cyan'],
            ['name' => 'Horizon Drift', 'variables' => 'sky'],
            ['name' => 'Azure Depth', 'variables' => 'blue'],
            ['name' => 'Twilight Verge', 'variables' => 'indigo'],
            ['name' => 'Cosmic Bloom', 'variables' => 'violet'],
            ['name' => 'Mystic Orchid', 'variables' => 'purple'],
            ['name' => 'Neon Dream', 'variables' => 'fuchsia'],
            ['name' => 'Blush Harmony', 'variables' => 'pink'],
            ['name' => 'Scarlet Whisper', 'variables' => 'rose'],
        ];

        DB::table('link_themes')->insert($colors);
    }
}
