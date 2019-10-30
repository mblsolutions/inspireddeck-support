<?php

use Illuminate\Support\Facades\Route;

Route::name('async.')->group(static function () {

    Route::get('metrics/dashboard', 'Metric\DashboardController@index')->name('code.balance');

    Route::post('code/balance', 'Code\BalanceController@code')->name('code.balance');

    Route::post('code/issue', 'Code\IssueController@code')->name('code.issue');
    Route::post('code/credit', 'Code\CreditController@code')->name('code.credit');
    Route::post('code/debit', 'Code\DebitController@code')->name('code.debit');
    Route::post('code/block', 'Code\BlockController@code')->name('code.block');
    Route::post('code/transfer', 'Code\TransferController@code')->name('code.transfer');

    Route::post('code/reverse', 'Transaction\ReverseController@transaction')->name('transaction.reverse');

    Route::get('code/refresh/{serial}', 'Code\RefreshController@code')->name('code.search');
    Route::post('code/search', 'Code\SearchController@search')->name('code.search');

    Route::get('code/transactions/{serial}/{page}', 'Code\TransactionController@history')->name('code.transaction');

    Route::post('asset-batch/{asset_batch}/export', 'Product\BatchController@export')->name('asset-batch.export');

});