<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Food::factory(10)->create();

        $defaultFoods = [
            [
                'name' => 'Nasi Lemak',
                'price' => 1.50,
                'session' => 1,
                'days' => 'SUN',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 1,
            ],
            [
                'name' => 'Egg Fried Rice',
                'price' => 4.00,
                'session' => 2,
                'days' => 'SUN',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 1,
            ],
            [
                'name' => 'ABC Ice Kacang',
                'price' => 2.00,
                'session' => 1,
                'days' => 'MON',
                // 'dessert' => 1,
                'date_range_id' => 1,
                'stall_id' => 3,
            ],
            [
                'name' => 'Maggi Goreng',
                'price' => 5.00,
                'session' => 2,
                'days' => 'MON',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 1,
            ],
            [
                'name' => 'Sandwich',
                'price' => 3.50,
                'session' => 1,
                'days' => 'TUE',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 2,
            ],
            [
                'name' => 'Ice Lemon Tea',
                'price' => 2.00,
                'session' => 2,
                'days' => 'TUE',
                // 'dessert' => 1,
                'date_range_id' => 1,
                'stall_id' => 3,
            ],
            [
                'name' => 'Chicken Chop Rice',
                'price' => 3.00,
                'session' => 1,
                'days' => 'WED',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 1,
            ],
            [
                'name' => 'Salted Fish Fried Rice',
                'price' => 3.00,
                'session' => 2,
                'days' => 'WED',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 1,
            ],
            [
                'name' => 'Fried Mee + Fried Egg',
                'price' => 3.00,
                'session' => 1,
                'days' => 'THU',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 1,
            ],
            [
                'name' => 'Tom Yum Bee Hun + Fried Egg',
                'price' => 3.00,
                'session' => 2,
                'days' => 'THU',
                // 'dessert' => 0,
                'date_range_id' => 1,
                'stall_id' => 1,
            ],

        ];

        collect($defaultFoods)->each(function ($food) {
            Food::create($food);
        });
    }
}
