<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(1),
            'gender' => $this->faker->boolean(),
            'text' => $this->faker->sentence(300),
            'birthday' => $this->faker->date(),
            'active' => $this->faker->boolean(),
        ];
    }
}
