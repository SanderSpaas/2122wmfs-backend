<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->middleware(['guest']);



Route::middleware(['auth', 'rolechecker'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home']);
    //detail page of a game 
    Route::get('/games/{id}', [DashboardController::class, 'gameDetail'])->where(['id' => '[0-9]+']);
    Route::post('/games/{id}/{playerID}', [DashboardController::class, 'killPlayer'])->where(['id' => '[0-9]+'])->where(['playerID' => '[0-9]+'])->name('killPlayer');
    //start a game
    Route::post('/games/{id}/start', [DashboardController::class, 'start'])->where(['id' => '[0-9]+'])->name('start');
    //close a game aka players can't join
    Route::post('/games/{id}/close', [DashboardController::class, 'close'])->where(['id' => '[0-9]+'])->name('close');
    //open a game aka players can join
    Route::post('/games/{id}/open', [DashboardController::class, 'open'])->where(['id' => '[0-9]+'])->name('open');
    //routes for creating a game
    Route::get('/games/create', [DashboardController::class, 'add'])->name('add');
    Route::post('/games/create', [DashboardController::class, 'store'])->name('store');
    //routes for editing a game
    Route::get('/games/{id}/edit', [DashboardController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::post('/games/{id}/edit', [DashboardController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    //routes for editing a player
    Route::get('/games/{gameId}/players/{id}/edit', [DashboardController::class, 'playerEdit'])->where(['gameId' => '[0-9]+'])->where(['id' => '[0-9]+']);
    Route::post('/games/{gameId}/players/{id}/edit', [DashboardController::class, 'playerUpdate'])->where(['gameId' => '[0-9]+'])->where(['id' => '[0-9]+']);
    
    //routes for deleting a game aka players can
    Route::post('/games/{id}/delete', [DashboardController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');

    //routes for seeing all the users players
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::post('/users/{id}', [DashboardController::class, 'userStore'])->where(['id' => '[0-9]+'])->name('userStore');
    //searching in the users
    Route::get('/users/search', [DashboardController::class, "search"]);
});

//login for the spa
Route::post('/api/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return response(['message' => 'The user has been authenticated successfully'], 200);
    }
    return response(['message' => 'The provided credentials do not match our records.'], 401);
});

Route::post('/api/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    return response(['message' => 'The user has been logged out successfully'], 200);
});

//gaat user gaan toevoegen in de database
Route::post('/api/user/add', 'App\Http\Controllers\GameController@addUser');

require __DIR__ . '/auth.php';
