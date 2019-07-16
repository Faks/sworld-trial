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
                'prefix' => '{token}',
            ],
            static function () {
                Route::get('documents/list', 'Api\AuthController@index');
                Route::post('documents/store', 'Api\AuthController@store');
                Route::delete('documents/{document}', 'Api\AuthApi@test');
            }
        );
    }
);
