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

Route::get('/dashboard', [DashboardController::class, 'home'])->middleware(['rolechecker'])->middleware(['auth']);
Route::get('/dashboard/game/{id}', [DashboardController::class, 'gameDetail'])->where(['id' => '[0-9]+'])->middleware(['rolechecker'])->middleware(['auth']);
// Route::post('/dashboard/game/{id}/{playerID}', [GameController::class, 'killPlayer'])->where(['id' => '[0-9]+'])->where(['playerID' => '[0-9]+'])->middleware(['rolechecker'])->middleware(['auth'])->name('killPlayer');

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
