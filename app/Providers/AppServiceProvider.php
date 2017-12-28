<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Menus;
use App\Services\Dashboard\MenusConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register a singleton a menu
        $this->app->singleton( 'App\Services\Menus', function( $app ) {
            return new Menus();
        });

        // register dashboard menu singleton
        $this->app->singleton( 'App\Services\Dashboard\MenusConfig', function( $app ) {
            return new MenusConfig( $app->make( Menus::class ) );
        });

        require_once app_path() . '\Services\Helper.php';
        require_once app_path() . '\Services\HelperFunctions.php';
    }
}
