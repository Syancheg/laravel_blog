<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'slug' => $this->faker->text(10),
            'content' => $this->faker->sentence(300),
            'active' => $this->faker->boolean(),
            'views' => rand(0, 100),
            'category_id' => rand(1, 20)
        ];
    }

}
