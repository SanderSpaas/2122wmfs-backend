<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use App\Models\Chat;

class GameController extends Controller
{
    public function games()
    {
        return ['data' => Game::with('players')->get()];
    }

    public function game($gameId)
    {
        if ($game = Game::with('Players.user')->findOrFail($gameId)) {
            return ['data' => $game];
        }
    }
    //geeft info over de player en de user weer
    public function player($gameId)
    {
        if ($data = Player::where('game_id', $gameId)->where('user_id', auth()->user()->id)->with('User', 'Game')->firstOrFail()) {
            return ['data' => $data];
        }
    }
    //geeft info over de huigide user zijn target weer: player + user info van die game
    public function target($gameId)
    {
        $targetID = Player::where('user_id', '=', auth()->user()->id)->where('game_id', $gameId)->pluck('target_id')[0];
        if ($data = Player::with('User')->findOrFail($targetID)) {
            return ['data' => $data];
        } else {
            return response()->json([
                'message' => 'No target or game found with the IDs: ' . $gameId . $targetID
            ], 404);
        }
    }
    //geeft info over de huigide user zijn killer weer: player + user info van die game
    public function killer($gameId)
    {
        $killerId = Player::where('user_id', '=', auth()->user()->id)->where('game_id', $gameId)->pluck('killer_id')[0];
        if ($data = Player::with('User')->findOrFail($killerId)) {
            return ['data' => $data];
        }
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

    public function addUser(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users|max:125',
            'password' => ['required', Password::defaults()],
            'email' => 'required|email|unique:users'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'The user: ' . $request->name . ' has been created'], 201);
    }

    public function addPlayer(Request $request, $gameId)
    {
        //kijken of de game bestaat
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //gaan kijken of die user al een player heeft in de game if ja -> zeggen ge moogt er ni meer dan ene hebben
        if (Player::where('user_id', '=', auth()->user()->id)->where('game_id', $gameId)->exists()) {
            return response()->json([
                'message' => 'You are not allowed to have multiple players in the game from the same user.'
            ], 401);
        }
        //kijken of de game bezig is of niet!!!!! -> gaan kijken naar status
        if (Game::where('status', '!=', 'Open')->find($gameId)) {
            return response()->json([
                'message' => 'That game is not accepting players right now.'
            ], 405);
        }

        //zoniet word hun alias die ze hebben opgegeven toegevoegd en word hun player in de db gezet
        else {
            $request->validate([
                'alias' => 'required|max:125',
            ]);
            $player = new Player();
            $player->alias = $request->alias;
            $player->game_id = $gameId;
            $player->user_id = auth()->user()->id;
            $player->save();

            return response()->json(['message' => 'The player: ' . $request->alias . ' has been created'], 201);
        }
    }

    //chat gaan tonen van die game + spelers die ze verstuurd hebben
    public function chat($gameId)
    {
        if ($data = Chat::where('game_id', $gameId)->with('Player')->orderBy("send_at")->get()) {
            return ['data' => $data];
        } else {
            return response()->json([
                'message' => 'No game found with the ID: ' . $gameId
            ], 404);
        }
    }
    public function addChat(Request $request, $gameId)
    {
        //kijken of de game bestaat
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //todo kijken of spel nog bezig is?

        //kijken of speler in game zit
        if (Player::where('user_id', '=', auth()->user()->id)->where('game_id', $gameId)->exists()) {
            $request->validate([
                'message' => 'required|max:250',
            ]);
            $chat = new Chat();
            $chat->message = $request->message;
            $chat->send_at = date('Y-m-d H:i:s');
            $chat->game_id = $gameId;
            $chat->player_id = Player::where('user_id', '=', auth()->user()->id)->where('game_id', $gameId)->pluck('id')[0];
            $chat->save();

            return response()->json(['message' => 'The chat message: ' . $request->message . ' has been created'], 201);
        }
    }
}
