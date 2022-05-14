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

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return response(['message' => 'The user has been authenticated successfully'], 200);
    }
    return response(['message' => 'The provided credentials do not match our records.'], 401);
});

 Route::post('/logout', function (Request $request) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();
        });
Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {

        Route::get('api/user', function (Request $request) {
            return $request->user();
        });
        Route::get('/games/{id}', [GameController::class, "game"])->where('id', '[0-9]+');
        Route::get('/games/{id}/{playerId}', 'App\Http\Controllers\GameController@player')->where('id', '[0-9]+')->where('playerId', '[0-9]+');
        Route::get('/games', 'App\Http\Controllers\GameController@games');
        Route::get('/games/{id}/start', 'App\Http\Controllers\GameController@start')->where('id', '[0-9]+')->middleware('can:isAdmin');
    }
);
