<?php

namespace App\Providers;

use App\Services\Power;
use Illuminate\Support\ServiceProvider;

class PowerServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('Power', function() {
            return new Power();
        });
    }
}
