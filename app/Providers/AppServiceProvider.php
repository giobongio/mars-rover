<?php

namespace App\Providers;

use App\ApplicationLogic\MarsRoverControlSystemInterface;
use App\ApplicationLogic\MarsRoverControlSystem;
use App\ApplicationLogic\MarsRoverInterface;
use App\ApplicationLogic\MarsRover;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MarsRoverInterface::class, function () {
            return new MarsRover(
                new PositionRepository(),
                new ObstacleRepository()
            );
        });

        $this->app->singleton(MarsRoverControlSystemInterface::class, MarsRoverControlSystem::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
