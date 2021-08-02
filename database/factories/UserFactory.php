<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'student_physical_id' =>  $this->faker->numerify('#######'),
            'type' => $this->faker->numberBetween($min = 3, $max = 4),
            'password' => '$2y$10$skHFGw4YHA5pgrS/D0o8cOt8URWQPix0w9I911L5iUVdPgeOTPLnq', // password
            'remember_token' => Str::random(10),
        ];
    }
}
