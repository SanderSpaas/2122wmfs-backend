<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
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
        //game vastnemen
        $game = Game::findOrFail($gameId);
        //kijken of de game bezig is of niet!!!!! -> gaan kijken naar status
        if (Game::where('status', '!=', 'Started')->find($gameId)) {
            return redirect(url('games/' . $gameId))->withErrors(["Something went wrong." => "The game has not started yet or has already finished."]);
        }
        //killer vastnemen
        $killer = Player::where('target_id', $targetId)->get();

        if ($killer) {
            return redirect(url('games/' . $gameId))->withErrors(["Something went wrong." => "The player with id: " . $targetId . " does not exist."]);
        }
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
        return redirect(url('games/' . $gameId));
    }
    public function start($gameId)
    {
        $game = Game::findOrFail($gameId);
        //alle spelers van deze game gaan vastpakken
        $players = Player::where('game_id', $gameId)->get();
        if (count($players) < 3) {
            return redirect(url('games/' . $gameId))->withErrors(["Something went wrong." => "You need at least 3 players to start the game."]);
        }
        //door alle spelers gaan loopen
        $idArray = array();
        foreach ($players as $player) {
            array_push($idArray, $player->id);
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
        return redirect(url('games/' . $gameId));
    }
    //game status op closed gaan zetten
    public function close($gameId)
    {
        $game = Game::findOrFail($gameId);
        $game->status = 'Closed';
        $game->save();
        return redirect(url('games/' . $gameId));
    }
    //game status op open gaan zetten
    public function open($gameId)
    {
        $game = Game::findOrFail($gameId);
        $game->status = 'Open';
        $game->save();
        return redirect(url('games/' . $gameId));
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

        return redirect(url('games/' . $game->id));
    }
    public function edit($gameId)
    {
        $game = Game::findorFail($gameId);
        return view('editGame', compact('game'));
    }
    public function update(Request $request, $gameId)
    {
        $request->validate([
            'name' => 'required|max:125',
            'murder_method' => 'required|max:125',
        ]);

        $game = Game::findorFail($gameId);
        $game->name = $request->name;
        $game->murder_method = $request->murder_method;
        $game->save();

        return redirect(url('games/' . $game->id));
    }
    public function users()
    {
        $users = User::paginate(10);
        // dump($users);
        $roles = array('User', 'Spelbegeleider', 'Admin');
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
        return redirect(url('users'));
    }
    public function search(Request $request)
    {
        // dump($request); 
        $users = User::orderBy('name')->paginate(10);
        $roles = array('User', 'Spelbegeleider', 'Admin');
        $terms = explode(" ", strtolower($request->term));

        if (count($request->all()) > 0) {
            $users = User::query();

            //search term
            if ($terms[0] !== "") {
                if ($request->filled('term')) {
                    $termArray = explode(',', $request->term);
                    for ($i = 0; $i < count($termArray); $i++) {
                        $users->where('name', 'like', '%' . $termArray[$i] . '%');
                    }
                }
            }

            //role
            if ($request->filled('role')) {
                $users->where('role', $request->role);
            }

            //sort by
            if ($request->sort == 'name') {
                $users->orderBy('name');
            } else if ($request->sort == 'role') {
                $users->orderBy('role');
            } else if ($request->sort == 'most_recent') {
                $users->orderBy('created_at', 'desc');
            } else {
                $users->orderBy('created_at');
            }

            //zoeken
            $users = $users->paginate(10)->withQueryString();
        }
        return view('users', compact('users', 'roles'));
    }

    public function playerEdit($gameId, $id)
    {
        $player = Player::findorFail($id);
        $game = Game::findorFail($gameId);
        return view('editPlayer', compact('player', 'game'));
    }
    public function playerUpdate(Request $request, $gameId, $id)
    {
        $request->validate([
            'alias' => 'required|max:125',
            'kills' => 'required|integer|digits_between:0,1000',
        ]);

        $player = Player::findorFail($id);
        $player->alias = $request->alias;
        $player->kills = $request->kills;
        $player->save();

        return redirect(url('games/' . $gameId));
    }
}
