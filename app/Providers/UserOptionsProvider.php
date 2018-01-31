<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Services\UserOptions;

class UserOptionsProvider extends ServiceProvider
{
    /***
     * Defer Loading
     */
    protected $defer    =   true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // save Singleton for user options
        $this->app->singleton( UserOptions::class, function(){
            /**
             * Index 0 is used when user is not connected
             */
            return new UserOptions( Auth::id() != null ? Auth::id() : 0 );
        });
    }

    /**
     * Provide
     * @return array of string class
     */
    public function provides()
    {
        return [ UserOptions::class ];
    }
}
