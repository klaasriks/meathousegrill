<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'name' => 'Grand Opening 2026',
            'description' => 'This is the first menu that was created when the shop was opened.',
            'version' => 1,
            'is_default' => true,
        ]);
    }
}
