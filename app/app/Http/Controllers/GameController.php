<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function games()
    {
        return ['data' => Game::all()];
    }
    public function game($id)
    {
        if ($game = Game::find($id)) {
            return ['data' => $game];
        } else {
            return response()->json([
                'message' => 'No game found with ID: ' . $id
            ], 404);
        }
    }
    //Todo implement function that retuns for this api call: /games/{id}/{playerId}
}
