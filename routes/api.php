<?php

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
        'prefix' => 'v1',
    ],
    static function () {
        Route::group(
            [
                'prefix'    => '{token}',
                'namespace' => 'Api',
            ],
            static function () {
                Route::get('documents/list', 'AuthController@index');
                Route::get('documents/{document}/show', 'AuthController@show');
                Route::post('documents/{document}/store', 'AuthController@store');
                Route::put('documents/{document}/update', 'AuthController@update');
                Route::delete('documents/{document}', 'AuthController@destroy');
            }
        );
    }
);
