<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Game;
use Carbon\Carbon;
use App\Models\Player;
use App\Models\User;
use App\Models\Chat;

/**
 * @group Gotcha
 *
 * API endpoints for managing a Gotcha game 
 */
class GameController extends Controller
{
    /**
     * Retuns a list of all games with their players.
     *
     * @response {"data":[{"id":1,"name":"inventore","murder_method":"eum ut et","status":"Open","players":[{"id":1,"alias":"Fritz Jenkins","kills":0,"game_id":1,"user_id":1,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":2,"alias":"Felipe Beahan","kills":0,"game_id":1,"user_id":2,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":3,"alias":"Afton Flatley","kills":0,"game_id":1,"user_id":3,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":4,"alias":"Danika Kessler","kills":0,"game_id":1,"user_id":4,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":5,"alias":"Idella Bogan PhD","kills":0,"game_id":1,"user_id":5,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":6,"alias":"Sonia Denesik","kills":0,"game_id":1,"user_id":6,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":7,"alias":"Ibrahim Dare","kills":0,"game_id":1,"user_id":7,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":8,"alias":"Miss Bianka Lemke IV","kills":0,"game_id":1,"user_id":8,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":9,"alias":"Blanca Haag","kills":0,"game_id":1,"user_id":9,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":10,"alias":"Prof. Judah McClure DVM","kills":0,"game_id":1,"user_id":10,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":11,"alias":"Catherine Swift II","kills":0,"game_id":1,"user_id":11,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":12,"alias":"Tristian Jast DDS","kills":0,"game_id":1,"user_id":12,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":13,"alias":"Jace Mitchell","kills":0,"game_id":1,"user_id":13,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":14,"alias":"Dr. Nora Feest Jr.","kills":0,"game_id":1,"user_id":14,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":15,"alias":"Tyler Braun","kills":0,"game_id":1,"user_id":15,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":16,"alias":"Prof. Concepcion Veum","kills":0,"game_id":1,"user_id":16,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":17,"alias":"Darrick Lueilwitz","kills":0,"game_id":1,"user_id":17,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":18,"alias":"Agustin Fadel","kills":0,"game_id":1,"user_id":18,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":19,"alias":"Jeramy Romaguera","kills":0,"game_id":1,"user_id":19,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":20,"alias":"Mrs. Bettye Barton I","kills":0,"game_id":1,"user_id":20,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":21,"alias":"Rosario Kozey DVM","kills":0,"game_id":1,"user_id":21,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":22,"alias":"Alexandrea Rohan","kills":0,"game_id":1,"user_id":22,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":28,"alias":"zel","kills":0,"game_id":1,"user_id":27,"killer_id":null,"target_id":null,"dead":0,"won":0}]},{"id":2,"name":"Big Boy Game","murder_method":"Give a kiss \ud83d\ude0a","status":"Open","players":[{"id":23,"alias":"XenoxBS","kills":0,"game_id":2,"user_id":24,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":24,"alias":"LuckyLukas","kills":0,"game_id":2,"user_id":23,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":25,"alias":"BigCheese","kills":0,"game_id":2,"user_id":21,"killer_id":null,"target_id":null,"dead":0,"won":0},{"id":26,"alias":"Amelia","kills":0,"game_id":2,"user_id":26,"killer_id":null,"target_id":null,"dead":0,"won":0}]},{"id":3,"name":"dolorum","murder_method":"itaque autem consequatur","status":"Closed","players":[]},{"id":4,"name":"dolore","murder_method":"voluptate error cupiditate","status":"Open","players":[]},{"id":5,"name":"qui","murder_method":"deleniti cupiditate quo","status":"Open","players":[{"id":27,"alias":"Rincewind","kills":0,"game_id":5,"user_id":21,"killer_id":null,"target_id":null,"dead":0,"won":0}]}]}
     * */
    public function games()
    {
        return ['data' => Game::with('players')->get()];
    }

    /**
     * Retuns a game with all the players and their users.
     *
     * @response {"data":{"id":1,"name":"inventore","murder_method":"eum ut et","status":"Open","players":[{"id":1,"alias":"Fritz Jenkins","kills":0,"game_id":1,"user_id":1,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":1,"name":"Rosalia Swift III","email":"herman.bogan@example.com","role":"user"}},{"id":2,"alias":"Felipe Beahan","kills":0,"game_id":1,"user_id":2,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":2,"name":"Branson Beer","email":"simeon01@example.com","role":"user"}},{"id":3,"alias":"Afton Flatley","kills":0,"game_id":1,"user_id":3,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":3,"name":"Floyd Mertz","email":"senger.elijah@example.net","role":"user"}},{"id":4,"alias":"Danika Kessler","kills":0,"game_id":1,"user_id":4,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":4,"name":"Mr. Trevion Altenwerth","email":"marcellus76@example.com","role":"user"}},{"id":5,"alias":"Idella Bogan PhD","kills":0,"game_id":1,"user_id":5,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":5,"name":"Edna Walsh","email":"golden61@example.org","role":"user"}},{"id":6,"alias":"Sonia Denesik","kills":0,"game_id":1,"user_id":6,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":6,"name":"Breanna Waters","email":"judy.purdy@example.com","role":"user"}},{"id":7,"alias":"Ibrahim Dare","kills":0,"game_id":1,"user_id":7,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":7,"name":"Percy Kulas","email":"ntillman@example.org","role":"user"}},{"id":8,"alias":"Miss Bianka Lemke IV","kills":0,"game_id":1,"user_id":8,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":8,"name":"Dr. Zita McGlynn PhD","email":"salvatore53@example.org","role":"user"}},{"id":9,"alias":"Blanca Haag","kills":0,"game_id":1,"user_id":9,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":9,"name":"Prof. Eulah Kreiger","email":"little.shirley@example.com","role":"user"}},{"id":10,"alias":"Prof. Judah McClure DVM","kills":0,"game_id":1,"user_id":10,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":10,"name":"Brendan Hane","email":"rubie56@example.com","role":"user"}},{"id":11,"alias":"Catherine Swift II","kills":0,"game_id":1,"user_id":11,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":11,"name":"Amira White DDS","email":"marley20@example.com","role":"user"}},{"id":12,"alias":"Tristian Jast DDS","kills":0,"game_id":1,"user_id":12,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":12,"name":"Mrs. Paige Fisher II","email":"kirk04@example.org","role":"user"}},{"id":13,"alias":"Jace Mitchell","kills":0,"game_id":1,"user_id":13,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":13,"name":"Christophe Sipes MD","email":"henry65@example.com","role":"user"}},{"id":14,"alias":"Dr. Nora Feest Jr.","kills":0,"game_id":1,"user_id":14,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":14,"name":"Chad Morissette IV","email":"vhackett@example.org","role":"user"}},{"id":15,"alias":"Tyler Braun","kills":0,"game_id":1,"user_id":15,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":15,"name":"Dr. Blaise Leannon IV","email":"arvid.mitchell@example.net","role":"user"}},{"id":16,"alias":"Prof. Concepcion Veum","kills":0,"game_id":1,"user_id":16,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":16,"name":"Sabina Bergstrom","email":"yhettinger@example.net","role":"user"}},{"id":17,"alias":"Darrick Lueilwitz","kills":0,"game_id":1,"user_id":17,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":17,"name":"Breanna Miller DDS","email":"sally75@example.org","role":"user"}},{"id":18,"alias":"Agustin Fadel","kills":0,"game_id":1,"user_id":18,"killer_id":null,"target_id":null,"dead":0,"won":0,"user":{"id":18,"name":"Mr. Robb Goldner DDS","email":"johan03@example.com","role":"user"}}]}}
     * @response 404 {"message": "That game does not exist: $gameId."}
     * @response 403 {"message": "Player is not playing in this game: $gameId"}
     * */
    public function game($gameId)
    {
        //kijken of de game bestaat
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //gaan nakijken of speler meetdoet aan game
        $player = Player::where('game_id', $gameId)->where('user_id', auth()->user()->id)->get();
        if ($player->isEmpty()) {
            return response()->json([
                'message' => 'Player is not playing in this game: ' . $gameId
            ], 403);
        }

        if ($game = Game::with('Players.user')->find($gameId)) {
            return ['data' => $game];
        }
    }

    /**
     * Kills a player and gives their target to the killer.
     *
     * @response {"message":"Player killed"}
     * @response 404 {"message": "That game does not exist: $gameId."}
     * @response 403 {"message": "The game has not started yet or has already finished."}
     * @response 403 {"message": "You are not allowed to kill this player."}
     * @response 404 {"message": "The player with id: $targetId does not exist."}
     * */
    public function killPlayer($gameId, $targetId)
    {
        //kijken of de game bestaat
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //kijken of de game bezig is of niet -> gaan kijken naar status
        if ($game = Game::where('status', '!=', 'Started')->find($gameId)) {
            return response()->json([
                'message' => 'The game has not started yet or has already finished.'
            ], 403);
        }
        //killer vastnemen
        $killer = Player::where('target_id', $targetId)->first();
        if (!$killer) {
            return response()->json([
                'message' => 'The player with id: ' . $targetId . ' does not exist.'
            ], 404);
        }

        //gaan nakijken of het target id wel van de speler zelf is 
        $target = Player::findOrFail($targetId);
        if (auth()->user()->id !== $target->user_id && auth()->user()->role !== 'spelbegeleider') {
            return response()->json([
                'message' => 'You are not allowed to kill this player.'
            ], 403);
        }
        //zijn target aka de speler op dood gaan zetten
        $target->dead = true;
        //huidige speler +1 kill geven
        $killer->kills = $killer->kills + 1;
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
        return response()->json([
            'message' => 'Player killed'
        ], 200);
    }

    /**
     * Creates a new user with the given name and password and email.
     *
     * @response 201 {"message": "The user: name has been created."}
     * */
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

        return response()->json(['message' => 'The user: ' . $request->name . ' has been created.'], 201);
    }

    /**
     * Adds a player to the given game.
     *
     * @response 201 {"message": "The player: alias has been created."}
     * @response 404 {"message": "That game does not exist: $gameId."}
     * @response 403 {"message": "You are not allowed to have multiple players in the game from the same user."}
     * @response 403 {"message": "That game is not accepting players right now."}
     * */
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
            ], 403);
        }
        //kijken of de game bezig is of niet!!!!! -> gaan kijken naar status
        if (Game::where('status', '!=', 'Open')->find($gameId)) {
            return response()->json([
                'message' => 'That game is not accepting players right now.'
            ], 403);
        }

        //alles in orde player word aan db toegeveogd
        $request->validate([
            'alias' => 'required|max:125',
        ]);
        $player = new Player();
        $player->alias = $request->alias;
        $player->game_id = $gameId;
        $player->user_id = auth()->user()->id;
        $player->save();

        return response()->json(['message' => 'The player: ' . $request->alias . ' has been created.'], 201);
    }

    /**
     * Shows all chat messages from the given game.
     * @response {"data":[{"id":34,"send_at":"1971-07-21 17:59:44","message":"molestiae veritatis facere eos nesciunt","game_id":1,"player_id":4,"player":{"id":4,"alias":"Danika Kessler","kills":0,"game_id":1,"user_id":4,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":48,"send_at":"1973-05-31 13:44:09","message":"numquam quibusdam dolores sit quis","game_id":1,"player_id":15,"player":{"id":15,"alias":"Tyler Braun","kills":0,"game_id":1,"user_id":15,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":47,"send_at":"1973-09-07 04:33:36","message":"ipsa similique illum dignissimos veritatis","game_id":1,"player_id":5,"player":{"id":5,"alias":"Idella Bogan PhD","kills":0,"game_id":1,"user_id":5,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":19,"send_at":"1974-01-25 02:06:50","message":"nihil numquam ratione omnis aliquam","game_id":1,"player_id":11,"player":{"id":11,"alias":"Catherine Swift II","kills":0,"game_id":1,"user_id":11,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":9,"send_at":"1974-02-05 19:39:28","message":"dolores corrupti unde voluptatum nesciunt","game_id":1,"player_id":7,"player":{"id":7,"alias":"Ibrahim Dare","kills":0,"game_id":1,"user_id":7,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":21,"send_at":"1975-03-22 01:16:18","message":"corporis corrupti harum voluptatem ipsa","game_id":1,"player_id":2,"player":{"id":2,"alias":"Felipe Beahan","kills":0,"game_id":1,"user_id":2,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":42,"send_at":"1977-03-04 23:15:52","message":"officiis voluptatibus est eveniet aliquid","game_id":1,"player_id":22,"player":{"id":22,"alias":"Alexandrea Rohan","kills":0,"game_id":1,"user_id":22,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":28,"send_at":"1977-12-21 12:24:57","message":"aliquam consequatur fuga quis ea","game_id":1,"player_id":21,"player":{"id":21,"alias":"Rosario Kozey DVM","kills":0,"game_id":1,"user_id":21,"killer_id":null,"target_id":null,"dead":0,"won":0}},{"id":36,"send_at":"1978-05-11 06:24:28","message":"dolorem architecto ad corrupti voluptatem","game_id":1,"player_id":8,"player":{"id":8,"alias":"Miss Bianka Lemke IV","kills":0,"game_id":1,"user_id":8,"killer_id":null,"target_id":null,"dead":0,"won":0}}]}
     * @response 404 {"message": "That game does not exist: $gameId."}
     * @response 403 {"message": "Player is not playing in this game: $gameId."}
     * */
    //chat gaan tonen van die game + spelers die ze verstuurd hebben
    public function chat($gameId)
    {
        //kijken of de game bestaat
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //kijken of speler in game zit
        $player = Player::where('game_id', $gameId)->where('user_id', auth()->user()->id)->get();
        if ($player->isEmpty()) {
            return response()->json([
                'message' => 'Player is not playing in this game: ' . $gameId
            ], 403);
        }
        $data = Chat::where('game_id', $gameId)->with('Player')->orderBy("send_at")->get();
        return ['data' => $data];
    }

    /**
     * Send a chat message to everyone in the game.
     * @response 404 {"message": "That game does not exist: $gameId."}
     * @response 201 {"message": "The chat message: message has been created"}
     * @response 403 {"message": "Player is not playing in this game: $gameId."}
     * */
    public function addChat(Request $request, $gameId)
    {
        //kijken of de game bestaat
        if (!Game::where('id', '=', $gameId)->exists()) {
            return response()->json([
                'message' => 'That game does not exist: ' . $gameId
            ], 404);
        }
        //kijken of speler in game zit
        $player = Player::where('game_id', $gameId)->where('user_id', auth()->user()->id)->get();
        if ($player->isEmpty()) {
            return response()->json([
                'message' => 'Player is not playing in this game: ' . $gameId
            ], 403);
        }
        //chat gaan in database gaan steken
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
    /**
     * Delete a chat message from a game, can only be used by users with the role: spelbegeleider or admin..
     * @response 200 {"message": "Chat message deleted"}
     * @response 403 {"message": "You are not allowed to remove chat."}
     * */
    public function deleteChat($gameId, $chatId)
    {
        if (auth()->user()->role !== 'spelbegeleider' && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to remove chat.'
            ], 403);
        }
        Chat::findOrFail($chatId)->delete();
        return response()->json([
            'message' => 'Chat message deleted'
        ], 200);
    }
    //geeft info over de player en de user weer
    // public function player($gameId)
    // {
    //     if ($data = Player::where('game_id', $gameId)->where('user_id', auth()->user()->id)->with('User', 'Game')->firstOrFail()) {
    //         return ['data' => $data];
    //     }
    // }
    //geeft info over de huigide user zijn target weer: player + user info van die game
    // public function target($gameId)
    // {
    //     $targetID = Player::where('user_id', '=', auth()->user()->id)->where('game_id', $gameId)->pluck('target_id')[0];
    //     if ($data = Player::with('User')->findOrFail($targetID)) {
    //         return ['data' => $data];
    //     } else {
    //         return response()->json([
    //             'message' => 'No target or game found with the IDs: ' . $gameId . $targetID
    //         ], 404);
    //     }
    // }
    //geeft info over de huigide user zijn killer weer: player + user info van die game
    // public function killer($gameId)
    // {
    //     $killerId = Player::where('user_id', '=', auth()->user()->id)->where('game_id', $gameId)->pluck('killer_id')[0];
    //     if ($data = Player::with('User')->findOrFail($killerId)) {
    //         return ['data' => $data];
    //     }
    // }
}
