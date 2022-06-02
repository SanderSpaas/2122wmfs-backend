<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    //	id	name	start_time	end_time	murder_method
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'murder_method' => $this->faker->words($nb = 3, $asText = true),
            'status' => $this->faker->randomElement(['Closed', 'Open']),
            //if you want all the status options randomElement(['Closed', 'Open', 'Started', 'Finished']),
            'end_time' => $this->faker->dateTime(),
        ];
    }
}
