<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function home()
    {
        $games = Game::with('players')->get();
        $user = Auth::user();
        // dump($games);
        return view('dashboard', compact('games', 'user'));
    }
    public function gameDetail($gameId)
    {
        $game = Game::with('Players.user')->with('Players.target')->with('Players.killer')->findOrFail($gameId);
        $user = Auth::user();
        dump($game);
        return view('gameDetail', compact('game', 'user'));
    }
    public function killPlayer($gameId, $targetId)
    {
        //kijken of de game bezig is of niet!!!!! -> gaan kijken naar status
        if (Game::where('status', '!=', 'Started')->find($gameId)) {
            return response()->json([
                'message' => 'The game has not started yet.'
            ], 405);
        }
        $killer = Player::where('target_id', $targetId)->get();
        $killer = $killer[0];
        //huidige speler +1 kill geven
        $killer->kills = $killer->kills + 1;
        //zijn target aka de speler op dood gaan zetten
        $target = Player::findOrFail($targetId);
        $target->dead = true;

        //het target van de dode aan de hitman geven
        $killer->target_id = $target->target_id;
        $target->target_id = null;
        $target->killer_id = $killer->id;
        $killer->save();
        $target->save();
    }
}
