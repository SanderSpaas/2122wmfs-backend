<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $number = 1;
        return [
            'alias' => $this->faker->name(),
            'game_id' => 1,
            'user_id' => $number++,
            'dead' => 0,
            'won' => 0,
            'kills' => 0,
        ];
    }
}
