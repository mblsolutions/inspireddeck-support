<?php

use Illuminate\Support\Facades\Route;
use MBLSolutions\InspiredDeckSupport\Middleware\Authentication\InspiredDeckAuthentication;

Route::name('inspireddeck.')->group(static function () {

    Route::get('/', 'Auth\LoginController@show')->name('login');
    Route::post('/', 'Auth\LoginController@authenticate')->name('login.authenticate');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

});

Route::name('inspireddeck.')->middleware(InspiredDeckAuthentication::class)->group(static function () {

    Route::get('code/search/result', 'Search\SearchController@results')->name('code.search.result');
    Route::get('code/search/select/{serial}', 'Search\SearchController@select')->name('code.search.select');

});