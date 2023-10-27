<?php

namespace App\Providers;

use App\Services\RoomsAvailabilityService;
use App\Services\RoomsAvailabilityServiceInterfece;
use App\Services\ProjectEnumsService;
use App\Services\ProjectEnumsServiceInterfece;
use Illuminate\Support\ServiceProvider;

class ProjectProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProjectEnumsServiceInterfece::class, function () {
            return new ProjectEnumsService();
        });
        $this->app->bind(RoomsAvailabilityServiceInterfece::class, function () {
            return new RoomsAvailabilityService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
