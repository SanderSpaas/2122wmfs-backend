<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GamesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {

        Route::get('api/user', function (Request $request) {
            return $request->user();
        });
        // Route::get('/games/{id}', 'App\Http\Controllers\GameController@game')->where('id', '[0-9]+');
        Route::post('/games/{id}', 'App\Http\Controllers\GameController@addPlayer')->where('id', '[0-9]+');
        Route::get('/games/{id}', 'App\Http\Controllers\GameController@player')->where('id', '[0-9]+');
        Route::get('/games/{id}/target', 'App\Http\Controllers\GameController@target')->where('id', '[0-9]+');


        //gaat een speler gaan uitschakelen en zijn target aan de moordenaar gaan geven
        Route::post('/player', 'App\Http\Controllers\GameController@killPlayer');

        //geeft alle games in de database weer samen met de spelers in die game
        Route::get('/games', 'App\Http\Controllers\GameController@games');
        //gaat alle spelers in die game een target gaan geven, Aleen een ADMIN heeft toegang tot deze route
        Route::get('/games/{id}/start', 'App\Http\Controllers\GameController@start')->where('id', '[0-9]+')->middleware('can:isAdmin');
    }
);
