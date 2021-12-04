<?php

namespace App\Domain\Vaccine\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Vaccine\Models\Vaccine;
use App\Domain\Vaccine\Observers\VaccineObserver;

class VaccineServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Domain\Vaccine\Contracts\IVaccineRepository', 'App\Domain\Vaccine\Repositories\VaccineRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(app_path('Domain\Vaccine\Migrations'));

        Vaccine::observe(VaccineObserver::class);
    }
}
