<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $games = Game::with('players')->get();
        $user = Auth::user();
        // dump($games);
        return view('dashboard', compact('games', 'user'));
    }
    public function delete($gameId)
    {
        $game = Game::findorFail($gameId);
        $game->chats()->delete();
        $game->players()->delete();
        $game->delete();
        return redirect(url('dashboard'));
    }
    public function gameDetail($gameId)
    {
        $game = Game::findOrFail($gameId);
        $players = Player::where('game_id', $gameId)->with('user')->with('target')->with('killer')->paginate(10);
        $user = Auth::user();
        // dump($game);

        return view('gameDetail', compact('game', 'players', 'user'));
    }
    public function killPlayer($gameId, $targetId)
    {
        //kijken of de game bezig is of niet!!!!! -> gaan kijken naar status
        if (Game::where('status', '!=', 'Started')->find($gameId)) {
            return response()->json([
                'message' => 'The game has not started yet.'
            ], 405);
        }
        //game vastnemen
        $game = Game::findOrFail($gameId);
        //killer vastnemen
        $killer = Player::where('target_id', $targetId)->get();
        $killer = $killer[0];
        //huidige speler +1 kill geven
        $killer->kills = $killer->kills + 1;
        //zijn target aka de speler op dood gaan zetten
        $target = Player::findOrFail($targetId);
        $target->dead = true;

        //het target van de dode aan de hitman geven
        $killer->target_id = $target->target_id;
        //wanneer de moordenaar zichzelf als target krijgt is hij de laatste speler en dus de winnaar
        //spel op finished gaan zetten en eindtijd aanduiden -> moordenaar als winnaar gaan aanduiden
        if ($killer->id === $killer->target_id) {
            $game->status = 'Finished';
            $game->end_time = Carbon::now();
            $game->save();
            $killer->won = true;
        }

        //target gaan weghalen en moordenaar gaan zetten
        $target->target_id = null;
        $target->killer_id = $killer->id;
        $killer->save();
        $target->save();
        return redirect(url('dashboard/game/' . $gameId));
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
        if (count($idArray) < 3) {
            return response()->json([
                'error' => 'There are not enough players to start the game. min 3.'
            ], 400);
        }
        //array met alle id's gaan doorheen schudden
        shuffle($idArray);

        //alle spelers gaan vastpakken
        foreach ($players as $key => $player) {
            if ($key === 0) {
                //er is nog geen vorige speler de eerste keer dat we door de loop gaan de speler zelf pakken zal niet voor problemen zorgen
                $previousPlayer = $player;
            } else {
                $previousPlayer = $players[$key - 1];
            }
            //gaan nakijken dat een speler zichzelf niet krijgt en dat hij niet de vorige speler als target krijgt
            if ($player->id !== $idArray[0] && $previousPlayer->id !== $idArray[0]) {
                $player->target_id = $idArray[0];
                unset($idArray[0]);
            } else {
                $player->target_id = $idArray[1];
                unset($idArray[1]);
            }
            //array gaan herindexeren anders werkt het niet
            $idArray = array_values($idArray);
            $player->save();

            //game status op started gaan zetten
            $game = Game::findOrFail($gameId);
            $game->status = 'Started';
            $game->save();
        }
        return redirect(url('dashboard/game/' . $gameId));
        return response()->json([
            'message' => 'de doelwitten zijn uitgedeeld'
        ], 200);
    }
    public function close($gameId)
    {
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //game status op started gaan zetten
        $game = Game::findOrFail($gameId);
        $game->status = 'Closed';
        $game->save();
        return redirect(url('dashboard/game/' . $gameId));
    }
    public function open($gameId)
    {
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //game status op started gaan zetten
        $game = Game::findOrFail($gameId);
        $game->status = 'Open';
        $game->save();
        return redirect(url('dashboard/game/' . $gameId));
    }

    public function add()
    {
        return view('addGame');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:games|max:125',
            'murder_method' => 'required|max:125',
            'start_time' => 'required|date_format:Y-m-d',
            'end_time' => 'required|date_format:Y-m-d|after:start_time',
        ]);

        $game = new Game;
        $game->name = $request->name;
        $game->murder_method = $request->murder_method;
        $game->start_time = $request->start_time;
        $game->end_time = $request->end_time;
        $game->save();

        return redirect(url('dashboard/game/' . $game->id));
    }
    public function users()
    {
        $users = User::paginate(10);
        dump($users);
        $roles = array('User',  'Spelbegeleider', 'Admin');
        return view('users', compact('users', 'roles'));
    }
    /**
     * Update the specified user his role.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function userStore(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:User,Spelbegeleider,Admin',
        ]);
        //player role gaan updaten
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return redirect(url('dashboard/users'));
    }
}
