<?php

use Illuminate\Support\Facades\Route;

Route::name('inspireddeck.')->group(static function () {

    Route::get('/', 'Auth\LoginController@show')->name('login');
    Route::post('/', 'Auth\LoginController@authenticate')->name('login.authenticate');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/privacy', 'Legal\PrivacyController@index')->name('privacy');
    Route::get('/terms', 'Legal\TermsController@index')->name('terms');

});