<?php

use Illuminate\Support\Facades\Route;

Route::name('api.')->group(static function () {

    Route::post('report/manage/test', 'Report\ManageReportController@test')->name('report.manage.test');
    Route::get('report/manage/settings', 'Report\ManageReportController@settings')->name('report.manage.settings');

    Route::name('report')->resource('report/manage', 'Report\ManageReportController', [
        'only' => ['show', 'store', 'update', 'destroy'],
        'parameters' => ['manage' => 'report']
    ]);

    Route::get('report/connection', 'Report\ReportController@connections')->name('report.connection');
    Route::get('report/middleware', 'Report\ReportController@middleware')->name('report.middleware');
    Route::get('report/data/type', 'Report\ReportController@dataType')->name('report.data.type');
    Route::get('report/model', 'Report\ReportController@models')->name('report.model');

    Route::get('report', 'Report\ReportController@index')->name('report.index');
    Route::get('report/{report}', 'Report\ReportController@show')->name('report.show');
    Route::post('report/{report}', 'Report\ReportController@render')->name('report.render');


});