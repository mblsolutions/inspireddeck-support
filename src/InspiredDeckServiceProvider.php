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
        $this->loadAssets();
    }

    /**
     * Publish Inspired Deck CSS and JS Assets
     *
     * @return void
     */
    public function loadAssets()
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path('inspireddeck'),
        ], 'inspireddeck-support');
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
    }

}