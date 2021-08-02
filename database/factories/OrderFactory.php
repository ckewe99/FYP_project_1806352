<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->pluck('id')->toArray();
        $foods = Food::all()->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($users),
            'food_id' => $this->faker->randomElement($foods),
            'quantity'=> $this->faker->randomDigit,
        ];
    }
}
