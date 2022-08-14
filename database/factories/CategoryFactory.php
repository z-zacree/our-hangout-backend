<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{

    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cat_arr = ["Restaurant", "Outdoor", "Museum", "Beach", "Shopping", "Activity", "Other", "Singapore", "Travelling", "Sightseeing", "Why not"];

        return [
            'name' => $cat_arr[random_int(0, count($cat_arr) - 1)],
            'description' => $this->faker->paragraph(),
            'color' => $this->faker->hexColor(),
        ];
    }
}
