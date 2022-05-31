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

        //geeft alle info van de game + spelers weer
        Route::get('/games/{id}', 'App\Http\Controllers\GameController@game')->where('id', '[0-9]+');

        //gaat een player gaan toevoegen aan een game
        Route::post('/games/{id}/add', 'App\Http\Controllers\GameController@addPlayer')->where('id', '[0-9]+');

        //geeft de user + player
        Route::get('/games/{id}/player', 'App\Http\Controllers\GameController@player')->where('id', '[0-9]+');

        //geeft info over de huigide user zijn target weer: player + user info van die game
        Route::get('/games/{id}/target', 'App\Http\Controllers\GameController@target')->where('id', '[0-9]+');

        //geeft info over de huigide user zijn killer weer: player + user info van die game
        Route::get('/games/{id}/killer', 'App\Http\Controllers\GameController@killer')->where('id', '[0-9]+');

        //gaat een speler gaan uitschakelen en zijn target aan de moordenaar gaan geven
        Route::post('/player/{id}/{targetID}', 'App\Http\Controllers\GameController@killPlayer')->where('id', '[0-9]+')->where('targetID', '[0-9]+');

        //geeft alle games in de database weer samen met de spelers in die game
        Route::get('/games', 'App\Http\Controllers\GameController@games');

        //gaat alle spelers in die game een target gaan geven, Aleen een ADMIN heeft toegang tot deze route
        Route::get('/games/{id}/start', 'App\Http\Controllers\GameController@start')->where('id', '[0-9]+')->middleware('can:isAdmin');

        //gaat alle messages van die game gaan weergeven + de speler die het heeft verstuurd
        Route::get('/games/{id}/chat', 'App\Http\Controllers\GameController@chat')->where('id', '[0-9]+');

        //bericht gaan toevoegen in de chat colomend
        Route::post('/games/{id}/chat', 'App\Http\Controllers\GameController@addChat')->where('id', '[0-9]+');
    }
);
