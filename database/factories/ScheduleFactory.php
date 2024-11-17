<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'start' => $this->faker->dateTime(),
            'end' => $this->faker->dateTime(),
            'category' => $this->faker->word(),
            'status' => $this->faker->word(),
            'user_id' => \App\Models\User::factory(),  
        ];
    }
}
