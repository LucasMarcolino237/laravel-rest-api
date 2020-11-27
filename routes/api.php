<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserLogsController;


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

Route::namespace('API')->name('api.')->group(function(){
    Route::prefix('user')->group(function() {

        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);

        Route::post('/', [UserController::class, 'store']);

        Route::put('/{id}', [UserController::class, 'update']);
        Route::put('/restore/{id}', [UserController::class, 'restore']);

        Route::delete('/{id}', [UserController::class, 'delete']);
        Route::delete('/destroy/{id}', [UserController::class, 'forceDelete']);

    });

    Route::prefix('logs')->group(function(){

        Route::get('/', [UserLogsController::class, ('index')]);
        Route::get('/{id}', [UserLogsController::class, ('show')]);
    });
    
});