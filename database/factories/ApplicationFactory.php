<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //

            'user_id' => $this->faker->numberBetween(1, 10),
            'job_id' => $this->faker->numberBetween(1, 10),
            'cv_id' => $this->faker->numberBetween(1, 10),
            'experience' => $this->faker->sentence(3),
            'expected_salary' => $this->faker->randomFloat(2, 5000000, 10000000),
        ];
    }
}
