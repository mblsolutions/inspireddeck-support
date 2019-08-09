<?php

namespace MBLSolutions\InspiredDeckSupport;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;

class InspiredDeckServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadSupportRoutes();

        // Publish Inspired Deck Support js files
        $this->publishes([
            __DIR__.'/../resources/js' => base_path('resources/js/inspireddeck'),
        ], 'inspireddeck-js');

        // Publish Inspired Deck Support sass files
        $this->publishes([
            __DIR__.'/../resources/sass' => base_path('resources/sass/inspireddeck'),
        ], 'inspireddeck-sass');
    }

    /**
     * Load Inspired Deck Support Routes
     *
     * @return void
     */
    public function loadSupportRoutes()
    {
        Route::group([
            'prefix' => 'async',
            'namespace' => 'MBLSolutions\InspiredDeckSupport\Http\Controllers\Async',
            'middleware' => ['web', 'inspireddeck_auth'],
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/async.php');
        });

        Route::group([
            'prefix' => 'api',
            'namespace' => 'MBLSolutions\InspiredDeckSupport\Http\Controllers\Api',
            'middleware' => ['web', 'inspireddeck_auth'],
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

}