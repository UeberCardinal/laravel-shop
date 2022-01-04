<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::pluck('id')->random(),
            'name' => $this->faker->word,
            'slug' => $this->faker->unique->word,
            'description' => $this->faker->text($min=150),
            'price' => $this->faker->numberBetween(1000, 40000),
            'count' => $this->faker->numberBetween(0, 10),
        ];
    }
}
