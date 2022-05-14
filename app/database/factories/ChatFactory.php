<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'send_at' => $this->faker->dateTime(),
            'message' => $this->faker->words($nb = 5, $asText = true),
            'game_id' => rand(1, 10)
        ];
    }
}
