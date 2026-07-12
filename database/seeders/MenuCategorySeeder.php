<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Flame Grill',
                'description' => 'Our signature flame grilled meals.',
                'slug' => 'flame-grill',
                'menu_id' => 1,
                'sort_order' => 1,
            ],
            [
                'name' => 'Street Favourites',
                'description' => 'Wraps and burgers packed with flavour.',
                'slug' => 'street-favourites',
                'menu_id' => 1,
                'sort_order' => 2,
            ],
            [
                'name' => 'Local Classics',
                'description' => 'Traditional South African favourites.',
                'slug' => 'local-classics',
                'menu_id' => 1,
                'sort_order' => 3,
            ],
            [
                'name' => 'Combos',
                'description' => 'Value meals and combo specials.',
                'slug' => 'combos',
                'menu_id' => 1,
                'sort_order' => 4,
            ],
            [
                'name' => 'Sides & Extras',
                'description' => 'Add-ons and side dishes.',
                'slug' => 'sides-and-sides',
                'menu_id' => 1,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            MenuCategory::updateOrCreate(
                $category
            );
        }
    }
}
