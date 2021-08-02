<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Food::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $days = ["SUN","MON","TUE","WED","THU"];
        return [
            'name' => $this->faker->randomElement(['Char Kuey Teow','Nasi Lemak','Roti Canai','French Fries']),
            'price' => $this->faker->randomDigit,
            'session' => $this->faker->randomElement([1,2]),
            'days' => $this->faker->randomElement($days),
            'type' =>  $this->faker->randomElement(["VEGE","NON-VEGE"]),
        ];
    }
}
