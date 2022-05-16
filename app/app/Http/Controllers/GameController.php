<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Player;
use App\Models\User;

class GameController extends Controller
{
    public function games()
    {
        return ['data' => Game::with('players')->get()];
    }
    public function game($gameId)
    {
        if ($game = Game::find($gameId)->with('Player')) {
            return ['data' => $game];
        } else {
            return response()->json([
                'message' => 'No game found with ID: ' . $gameId
            ], 404);
        }
    }
    public function player($gameId)
    {
        if ($data = Player::find($gameId)->with('Game')->with('User')->where('players.id', auth()->user()->id)->with('target')->get()) {
            return ['data' => $data];
        } else {
            return response()->json([
                'message' => 'No player or game found with the IDs: ' . $gameId . auth()->user()->id
            ], 404);
        }
    }
    public function target($gameId)
    {
        if ($data = Player::find($gameId)->with('Game')->with('target')->get()) {
            return ['data' => $data];
        } else {
            return response()->json([
                'message' => 'No player or game found with the IDs: ' . $gameId . auth()->user()->id
            ], 404);
        }
    }
    //TODO GAAN NAKIJKEN OF HET SPEL AL GESTART IS 
    public function killPlayer()
    {
        $killer = Player::where('target_id', auth()->user()->id)->get();
        $killer = $killer[0];
        //huidige speler +1 kill geven
        $killer->kills = $killer->kills + 1;
        //zijn target op dood gaan zetten
        $target = Player::where('id', auth()->user()->id)->get();
        $target = $target[0];
        $target->dead = true;

        //het target van de dode aan de hitman geven
        $killer->target_id = $target->target_id;
        $target->target_id = null;
        $killer->save();
        $target->save();
    }
    public function start($gameId)
    {
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //alle spelers van deze game gaan vastpakken
        $players = Player::where('game_id', $gameId)->get();
        //door alle spelers gaan loopen
        $idArray = array();
        foreach ($players as $player) {
            array_push($idArray, $player->id);
        }
        //array met alle id's gaan doorheen schudden
        shuffle($idArray);

        //alle spelers gaan vastpakken
        foreach ($players as $player) {
            if ($player->id !== $idArray[0]) {
                $player->target_id = $idArray[0];
                unset($idArray[0]);
            } else {
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

    public function addPlayer(Request $request, $gameId)
    {
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        if (Player::where('id', '=', auth()->user()->id)->where('game_id', $gameId)->exists()) {
            return response()->json([
                'message' => 'You are not allowed to have multiple players in the game from the same user game id: ' . $gameId . 'user id: ' .  auth()->user()->id
            ], 401);
        }
        //TODO DIT NOG GAAN FIXEN
        // if (Game::find($gameId)->where('end_time', '>=', Carbon::now())->exist()) {
        //     return response()->json([
        //         'message' => 'That game has already ended: ' . $gameId
        //     ], 405);
        // } 
        else {
            $request->validate([
                'alias' => 'required|unique:players|max:125',
            ]);
            $player = new Player();
            $player->alias = $request->alias;
            $player->game_id = $gameId;
            $player->user_id = auth()->user()->id;
            $player->save();

            return response()->json(['message' => 'The player: ' . $request->alias . ' has been created'], 201);
        }
    }
    //todo een post route waarmee een user kan gaan meedoen bij een game

    //user vastpakken

    //gaan kijken of die user al een player heeft in de game if ja -> zeggen ge moogt er ni meer dan ene hebben

    //zoniet word hun alias die ze hebben opgegeven toegevoegd en word hun player in de db gezet

}
