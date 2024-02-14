<?php

namespace Deesynertz\Helpers;

use Illuminate\Support\ServiceProvider;

class HelperKitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
               
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // if ($this->app->runningInConsole()) {
        //     $this->commands([CleanCommand::class,]);
        // }
    }

    // /**
    //  * Get the services provider by the provider
    //  *
    //  * @return array
    //  */
    // public function provides()
    // {
    //     return ['toastr'];
    // }
}
