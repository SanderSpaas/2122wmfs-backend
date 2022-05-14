<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\Player;
use App\Models\User;

class GameController extends Controller
{
    public function games()
    {
        return ['data' => Game::all()];
    }
    public function game($gameId)
    {
        if ($game = Game::find($gameId)->with('Player')) {
            return ['data' => $game];
        } else {
            return response()->json([
                'message' => 'No game found with ID: ' . $id
            ], 404);
        }
    }
    public function player($gameId, $playerId)
    {
        if ($data = Player::find($gameId)->with('Game')->with('User')->where('players.id', $playerId)->get()) {
            return ['data' => $data];
        } else {
            return response()->json([
                'message' => 'No player or game found with the IDs: ' . $gameId . $playerId
            ], 404);
        }
    }
    public function start($gameId)
    {
        //alle spelers van deze game gaan vastpakken
        $players = Player::find($gameId)->get();
        //door alle spelers gaan loopen
        $idArray = array();
        foreach ($players as $player) {
            array_push($idArray, $player->id);
        }
        //array met alle id's gaan doorheen schudden
        shuffle($idArray);

        //alle spelers gaan vastpakken
        foreach ($players as $player) {
            if($player->id !== $idArray[0])
            {
                $player->target_id = $idArray[0];
                unset($idArray[0]);
            }else{
                $player->target_id = $idArray[1];
                unset($idArray[1]);
            }

            //array gaan herindexeren anders werkt het niet
            $idArray = array_values($idArray);
            $player->save();
        }

        return response()->json([
            'message' => 'de doelwitten zijn uitgedeeld'
        ], 200);
    }
}
