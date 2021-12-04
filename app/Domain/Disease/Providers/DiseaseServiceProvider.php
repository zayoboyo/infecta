<?php

namespace App\Domain\Disease\Providers;

use Illuminate\Support\ServiceProvider;

class DiseaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Domain\Disease\Contracts\IDiseaseRepository', 'App\Domain\Disease\Repositories\DiseaseRepository');
        $this->app->bind('App\Domain\Disease\Contracts\IDiseaseService', 'App\Domain\Disease\Services\DiseaseService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom('App\Domain\Disease\Migrations');
    }
}
