<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix' => 'api',
    ],
    function () {
        Route::post(
            '/wagers',
            [
                'as' => 'place_wager',
                'uses' => 'WagerController@place',
            ]
        );
        Route::get(
            '/wagers',
            [
                'as' => 'list_wagers',
                'uses' => 'WagerController@listing',
            ]
        );
        Route::post(
            '/buy/{wager_id}',
            [
                'as' => 'buy_wager',
                'uses' => 'WagerTransactionController@buy',
            ]
        );
    }
);
