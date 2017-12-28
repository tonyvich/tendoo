<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Modules;
class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot( Modules $modules )
    {
        $modules->load();
        $modules->init();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // register module singleton
        $this->app->singleton( 'App\Services\Modules', function( $app ) {
            return new Modules;
        });
    }
}
