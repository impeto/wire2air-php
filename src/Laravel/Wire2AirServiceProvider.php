<?php

namespace Impeto\Wire2Air\Laravel;

use Illuminate\Support\ServiceProvider;
use Impeto\Wire2Air\Wire2AirAPI;

class Wire2AirServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app->make( 'config');
        if ( $config->has('wire2air'))
        {
            $client = new Wire2AirAPI( $config->get( 'wire2air'));
        } else {
            $client = new Wire2AirAPI();
        }

        $this->app->singleton( ['w2a', 'Impeto\Wire2Air'], function( $app) use ($client){
            return $client;
        });
    }

    public function provides()
    {
        return ['w2a', 'Impeto\Wire2Air'];
    }
}