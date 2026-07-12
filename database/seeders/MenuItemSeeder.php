<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_items')->insert([
            // ======================================================
            // FLAME GRILL
            // ======================================================
            [
                'menu_category_id' => 1,
                'name' => 'Full Grilled Chicken',
                'description' => 'Served with medium chips or pap or samp (250g), or 3 slices dumpling or 3 rolls.',
                'image' => '/storage/menu_images/full_grilled_chicken.jpg',
                'price' => 180,
                'drink_price' => 199,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Half Grilled Chicken',
                'description' => 'Served with medium chips or pap or samp (250g), or 3 slices dumpling or 3 rolls.',
                'image' => '/storage/menu_images/half_grilled_chicken.jpg',
                'price' => 90,
                'drink_price' => 110,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Quarter Chicken',
                'description' => 'Served with chips or pap or samp (250g), or 2 slices dumpling or 2 rolls.',
                'image' => '/storage/menu_images/quarter_chicken.jpg',
                'price' => 55,
                'drink_price' => 75,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Full Grilled Hot Wings (6)',
                'description' => 'With chips.',
                'image' => '/storage/menu_images/hot_wings_6.jpg',
                'price' => 130,
                'drink_price' => 150,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Full Grilled Hot Wings (12)',
                'description' => 'With chips.',
                'image' => '/storage/menu_images/hot_wings_12.jpg',
                'price' => 198,
                'drink_price' => 218,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Beef Ribs (300g)',
                'description' => 'Served with chips.',
                'image' => '/storage/menu_images/beef_ribs_300g.jpg',
                'price' => 120,
                'drink_price' => 130,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Beef Ribs (600g)',
                'description' => 'Served with large chips.',
                'image' => '/storage/menu_images/beef_ribs_600g.jpg',
                'price' => 175,
                'drink_price' => 198,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Grilled Beef Sausage x2',
                'description' => 'Served with chips, pap, samp (250g), 2 slices dumpling or 2 rolls.',
                'image' => '/storage/menu_images/beef_sausage_x2.jpg',
                'price' => 120,
                'drink_price' => null,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 1,
                'name' => 'Grilled Beef Steak (300g)',
                'description' => 'Served with chips, pap, samp (250g), 2 slices dumpling or 2 rolls.',
                'image' => '/storage/menu_images/beef_steak_300g.jpg',
                'price' => 130,
                'drink_price' => null,
                'chips_price' => null,
            ],

            // ======================================================
            // STREET FAVOURITES
            // ======================================================
            [
                'menu_category_id' => 2,
                'name' => 'Lip Smacker Chicken Wrap',
                'description' => 'Whip, chicken cuts grilled with signature basting sauce, lettuce, tomato, dill pickles.',
                'image' => '/storage/menu_images/lip_smacker_chicken_wrap.jpg',
                'price' => 60,
                'chips_price' => 85,
                'drink_price' => 110,
            ],
            [
                'menu_category_id' => 2,
                'name' => 'Lip Smacker Beef Wrap',
                'description' => 'Black Ember signature basting sauce, grilled beef cuts, lettuce, tomato, dill pickles.',
                'image' => '/storage/menu_images/lip_smacker_beef_wrap.jpg',
                'price' => 70,
                'chips_price' => 95,
                'drink_price' => 120,
            ],
            [
                'menu_category_id' => 2,
                'name' => 'Lip Smacker Spicy Chicken Wrap',
                'description' => 'Prego mayo, grilled chicken cuts, lettuce, onion, dill pickles, jalapeño.',
                'image' => '/storage/menu_images/lip_smacker_spicy_wrap.jpg',
                'price' => 65,
                'chips_price' => 90,
                'drink_price' => 110,
            ],
            [
                'menu_category_id' => 2,
                'name' => 'Lip Smacker Dulux Wrap',
                'description' => 'Black Ember sauce, Russian, lettuce, tomato, fried onion, avocado.',
                'image' => '/storage/menu_images/lip_smacker_dulux_wrap.jpg',
                'price' => 70,
                'chips_price' => 95,
                'drink_price' => 115,
            ],
            [
                'menu_category_id' => 2,
                'name' => 'Lip Smacker Classic Beef Burger',
                'description' => 'Black Ember sauce, prego mayo, beef patty, lettuce, tomato, fried onion.',
                'image' => '/storage/menu_images/classic_beef_burger.jpg',
                'price' => 65,
                'chips_price' => 90,
                'drink_price' => 110,
            ],
            [
                'menu_category_id' => 2,
                'name' => 'Lip Smacker Cheese Burger',
                'description' => 'Black Ember sauce, prego mayo, beef patty, cheese, tomato, fried onion, lettuce, pickles.',
                'image' => '/storage/menu_images/cheese_burger.jpg',
                'price' => 75,
                'chips_price' => 100,
                'drink_price' => 120,
            ],
            [
                'menu_category_id' => 2,
                'name' => 'Lip Smacker Double Trouble Beef Burger',
                'description' => '2 beef patties, double cheese, lettuce, tomato, fried onion, pickles.',
                'image' => '/storage/menu_images/double_trouble_burger.jpg',
                'price' => 99,
                'chips_price' => 124,
                'drink_price' => 144,
            ],

            // ======================================================
            // LOCAL CLASSICS
            // ======================================================
            [
                'menu_category_id' => 3,
                'name' => 'Chicken Curry Meal',
                'description' => 'Served with pap, samp (250g), 3 slices dumpling or 3 rolls.',
                'image' => '/storage/menu_images/chicken_curry.jpg',
                'price' => 105,
                'drink_price' => 115,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 3,
                'name' => 'Beef Curry Meal',
                'description' => 'Served with pap, samp (250g), 3 slices dumpling or 3 rolls.',
                'image' => '/storage/menu_images/mutton_curry.jpg',
                'price' => 115,
                'drink_price' => 125,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 3,
                'name' => 'Mutton Curry Meal',
                'description' => 'Served with pap, samp (250g), 3 slices dumpling or 3 rolls.',
                'image' => '/storage/menu_images/mutton_curry.jpg',
                'price' => 125,
                'drink_price' => 135,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 3,
                'name' => 'Chicken Bunny Chow',
                'description' => 'Chicken curry in bread.',
                'image' => '/storage/menu_images/chicken_bunny.jpg',
                'price' => 75,
                'drink_price' => 85,
                'chips_price' => 110,
            ],
            [
                'menu_category_id' => 3,
                'name' => 'Beef Bunny Chow',
                'description' => 'Beef curry in bread.',
                'image' => '/storage/menu_images/beef_bunny.jpg',
                'price' => 85,
                'drink_price' => 95,
                'chips_price' => 110,
            ],
            [
                'menu_category_id' => 3,
                'name' => 'Mutton Bunny Chow',
                'description' => 'Mutton curry in bread.',
                'image' => '/storage/menu_images/mutton_bunny.jpg',
                'price' => 110,
                'drink_price' => 130,
                'chips_price' => null,
            ],

            // ======================================================
            // COMBOS
            // ======================================================
            [
                'menu_category_id' => 4,
                'name' => 'Meathouse Duo Combo',
                'description' => '300g ribs & quarter chicken. Served with chips, creamy spinach or zesty rainbow chilli bean salad.',
                'image' => '/storage/menu_images/meathouse_duo.jpg',
                'price' => 140,
                'drink_price' => 165,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 4,
                'name' => 'Street & Grill Combo',
                'description' => 'Lip Smacker Spicy Chicken Wrap, chips and 6 hot wings.',
                'image' => '/storage/menu_images/street_grill_combo.jpg',
                'price' => 169,
                'drink_price' => 189,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 4,
                'name' => 'Quarter Chicken & Sausage',
                'description' => 'Served with one side.',
                'image' => '/storage/menu_images/quarter_chicken_sausage.jpg',
                'price' => 106,
                'drink_price' => 116,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 4,
                'name' => 'Half Chicken & 2 Beef Sausages',
                'description' => 'Served with two sides.',
                'image' => '/storage/menu_images/half_chicken_2sausages.jpg',
                'price' => 198,
                'drink_price' => 210,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 4,
                'name' => 'Full Chicken & 4 Beef Sausages or 300g Steak',
                'description' => 'Served with large family side.',
                'image' => '/storage/menu_images/full_chicken_4sausages_or_steak.jpg',
                'price' => 390,
                'drink_price' => 425,
                'chips_price' => null,
            ],
            [
                'menu_category_id' => 4,
                'name' => 'Full Chicken & 600g Ribs',
                'description' => 'Served with large family side.',
                'image' => '/storage/menu_images/full_chicken_ribs.jpg',
                'price' => 345,
                'drink_price' => 370,
                'chips_price' => null,
            ],

            // ======================================================
            // SIDES & EXTRAS
            // ======================================================
            [
                'menu_category_id' => 5,
                'name' => 'Large Chips',
                'description' => null,
                'image' => '/storage/menu_images/chips_large.jpg',
                'price' => 35,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Medium Chips',
                'description' => null,
                'image' => '/storage/menu_images/chips_medium.jpg',
                'price' => 25,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Pap',
                'description' => null,
                'image' => '/storage/menu_images/pap.jpg',
                'price' => 15,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Samp',
                'description' => null,
                'image' => '/storage/menu_images/samp.jpg',
                'price' => 25,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Large Dumpling',
                'description' => null,
                'image' => '/storage/menu_images/large_dumpling.jpg',
                'price' => 45,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Roll',
                'description' => null,
                'image' => '/storage/menu_images/roll.jpg',
                'price' => 12,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Coastal Greek Harvest Salad',
                'description' => null,
                'image' => '/storage/menu_images/greek_salad.jpg',
                'price' => 85,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Gravy',
                'description' => null,
                'image' => '/storage/menu_images/gravy.jpg',
                'price' => 25,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Creamy Spinach',
                'description' => null,
                'image' => '/storage/menu_images/creamy_spinach.jpg',
                'price' => 25,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Zesty Rainbow Chilli Bean Salad',
                'description' => null,
                'image' => '/storage/menu_images/rainbow_bean_salad.jpg',
                'price' => 35,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Golden Roast Butternut',
                'description' => null,
                'image' => '/storage/menu_images/roast_butternut.jpg',
                'price' => 25,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Cheese Slice',
                'description' => null,
                'image' => '/storage/menu_images/cheese_slices.jpg',
                'price' => 12,
                'drink_price' =>  null,
                'chips_price' => null
            ],
            [
                'menu_category_id' => 5,
                'name' => 'Creamy Spinach & Golden Roast Butternut',
                'description' => null,
                'image' => '/storage/menu_images/creamy_spinach.jpg',
                'price' => 45,
                'drink_price' =>  null,
                'chips_price' => null
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('menu_items')->truncate();
    }
}
