<?php

namespace Database\Seeders;

use App\Models\Menu;
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
            'name' => 'Klaas Rikhotso',
            'email' => 'klaas@rikscss.co.za',
        ]);

        $this->call([MenuSeeder::class]);
        $this->call([MenuCategorySeeder::class]);
        $this->call([MenuItemSeeder::class]);
    }
}
