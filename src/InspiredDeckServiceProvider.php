<?php

namespace MBLSolutions\InspiredDeckSupport;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use MBLSolutions\InspiredDeckSupport\Services\MarkDownRenderService;
use ParsedownExtra;

class InspiredDeckServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(MarkDownRenderService::class, static function ($app) {
            return new MarkDownRenderService(new ParsedownExtra);
        });
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 5 login tries a minute per email
        RateLimiter::for('inspireddeck-login', static function (Request $request) {
            $email = $request->input('email');

            return Limit::perMinute(5)->by(is_string($email) ? Str::transliterate(Str::lower($email)) : '');
        });

        $this->loadSupportRoutes();

        // Publish Inspired Deck support assets
        $this->publishes([
            __DIR__.'/../public/inspireddeck' => base_path('public/inspireddeck'),
        ], 'inspireddeck-assets');

        // Publish Inspired Deck support js files
        $this->publishes([
            __DIR__.'/../resources/js' => base_path('resources/js/inspireddeck'),
        ], 'inspireddeck-js');

        // Publish Inspired Deck support sass files
        $this->publishes([
            __DIR__.'/../resources/sass' => base_path('resources/sass/inspireddeck'),
        ], 'inspireddeck-sass');

        // Publish Inspired Deck support views
        $this->publishes([
            __DIR__.'/../resources/views/inspireddeck' => base_path('resources/views/inspireddeck'),
            __DIR__.'/../resources/views/errors' => base_path('resources/views/errors'),
        ], 'inspireddeck-views');
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

        Route::group([
            'prefix' => 'inspireddeck',
            'namespace' => '\MBLSolutions\InspiredDeckSupport\Http\Controllers',
            'middleware' => ['web'],
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

}