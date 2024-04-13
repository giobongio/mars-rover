<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ObstacleModel>
 */
class ObstacleModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'x' => rand(0, config('app.planisphere.total_meridians') - 1),
            'y' => rand(0, config('app.planisphere.total_parallels') - 1),
        ];
    }
}
