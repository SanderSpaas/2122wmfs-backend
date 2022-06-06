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



Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        /**
         * Returns the current authenticated user.
         * @response {"id":21,"name":"sander","email":"sander.spaas@odisee.be","role":"admin"}
         * @response 401 {"message":"Unauthenticated."}
         * */
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        //geeft alle info van de game + spelers + users weer
        Route::get('/games/{id}', 'App\Http\Controllers\GameController@game')->where('id', '[0-9]+');

        //gaat een player gaan toevoegen aan een game
        Route::post('/games/{id}/add', 'App\Http\Controllers\GameController@addPlayer')->where('id', '[0-9]+');

        //gaat een speler gaan uitschakelen en zijn target aan de moordenaar gaan geven
        Route::patch('/player/{id}/{targetID}', 'App\Http\Controllers\GameController@killPlayer')->where('id', '[0-9]+')->where('targetID', '[0-9]+');

        //geeft alle games in de database weer samen met de spelers in die game
        Route::get('/games', 'App\Http\Controllers\GameController@games');

        //gaat alle messages van die game gaan weergeven + de speler die het heeft verstuurd
        Route::get('/games/{id}/chat', 'App\Http\Controllers\GameController@chat')->where('id', '[0-9]+');

        //bericht gaan toevoegen in de chat colomend
        Route::post('/games/{id}/chat', 'App\Http\Controllers\GameController@addChat')->where('id', '[0-9]+');

        //een chatbericht gaan verwijderen
        Route::delete('/games/{id}/chat/{chatId}', 'App\Http\Controllers\GameController@deleteChat')->where('id chatId', '[0-9]+');
    }
);
