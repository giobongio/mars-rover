<?php

namespace Database\Seeders;

use App\Models\ObstacleModel;
use Illuminate\Database\Seeder;

class ObstacleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ObstacleModel::factory()
            ->count(config('app.total_obstacles'))
            ->create();

    }
}
