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
    Route::get('/dashboard/game/{id}', [DashboardController::class, 'gameDetail'])->where(['id' => '[0-9]+']);
    Route::post('/dashboard/game/{id}/{playerID}', [DashboardController::class, 'killPlayer'])->where(['id' => '[0-9]+'])->where(['playerID' => '[0-9]+'])->name('killPlayer');
    //start a game
    Route::post('/dashboard/game/{id}/start', [DashboardController::class, 'start'])->where(['id' => '[0-9]+'])->name('start');
    //close a game aka players can't join
    Route::post('/dashboard/game/{id}/close', [DashboardController::class, 'close'])->where(['id' => '[0-9]+'])->name('close');
    //open a game aka players can join
    Route::post('/dashboard/game/{id}/open', [DashboardController::class, 'open'])->where(['id' => '[0-9]+'])->name('open');
    //routes for creating a game
    Route::get('/dashboard/game/create', [DashboardController::class, 'add'])->name('add');
    Route::post('/dashboard/game/create', [DashboardController::class, 'store'])->name('store');
    //routes for deleting a game aka players can
    Route::post('/dashboard/game/{id}/delete', [DashboardController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');

    //routes for seeing all the users players
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('users');
    Route::post('/dashboard/users', [DashboardController::class, 'usersStore'])->name('usersStore');
});
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
