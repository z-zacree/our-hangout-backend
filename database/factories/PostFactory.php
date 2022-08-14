<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type_arr = ['Blog', 'Complaint', 'Advice', 'Request'];

        $ran_int = random_int(0, 3);

        return [
            'user_id' => User::factory(),
            'title' =>  "{$this->faker->text(48)} {$this->faker->emoji()}",
            'subtitle' => $ran_int == 0 ? null : $this->faker->text(48),
            'content' => "{$this->faker->realText(450, 2)} <em>{$this->faker->realText(450, 2)}</em> {$this->faker->realText(450, 2)}",
            'type' => $type_arr[random_int(0, 3)],
            'views' => $this->faker->numberBetween(0, 200),
        ];
    }
}
