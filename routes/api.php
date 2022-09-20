<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
        Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    });
    Route::group([ 'middleware'=>'auth'], function () {
        Route::group(['prefix' => 'auth' ,] , function () {
            Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
            Route::post('/refresh', [App\Http\Controllers\Api\AuthController::class, 'refresh']);
            Route::get('/user-profile', [App\Http\Controllers\Api\AuthController::class, 'userProfile']);
        });
        Route::group(['prefix' => 'dashboard' ] , function () {
            Route::apiResource('campaign' , \App\Http\Controllers\Api\CampaignController::class );
            Route::delete('campaign/delete/{image}/image' , '\App\Http\Controllers\Api\CampaignController@destroyImage' );

        });

    });
