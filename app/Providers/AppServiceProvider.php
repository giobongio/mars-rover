<?php

namespace App\Providers;

use App\ApplicationLogic\MarsRoverControlSystemInterface;
use App\ApplicationLogic\MarsRoverControlSystem;
use App\ApplicationLogic\MarsRoverInterface;
use App\ApplicationLogic\MarsRover;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MarsRoverControlSystemInterface::class, MarsRoverControlSystem::class);
        $this->app->singleton(MarsRoverInterface::class, MarsRover::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
