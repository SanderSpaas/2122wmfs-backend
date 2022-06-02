@extends('layout')

@section('title', 'Gotcha | Dashboard')


@section('content')
    <ul class="list-group align-items-start row" style="width: 40vw; margin-left:15vw;">
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Game name</p>
            <p class="col col-lg-3">{{ $game->name }}</p>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Total players</p>
            @if ($game->players !== null)
                <p class="col col-lg-3">{{ count($game->players) }}👤</p>
            @else
                <p class="col col-lg-3">0👤</p>
            @endif
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Murder method</p>
            <p class="col col-lg-3">{{ $game->murder_method }}</p>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Endtime</p>
            <p class="col col-lg-3">{{ \Carbon\Carbon::parse($game->end_time)->format('d/m/Y') }}</p>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Status</p>
            @if ($game->status === 'Closed')
                <span class="badge bg-danger rounded-pill col col-lg-3">{{ $game->status }}</span>
            @elseif ($game->status === 'Open')
                <span class="badge bg-success rounded-pill col col-lg-3">{{ $game->status }}</span>
            @elseif ($game->status === 'Finished')
                <span class="badge bg-primary rounded-pill col col-lg-3">{{ $game->status }}</span>
            @else
                <span class="badge bg-warning rounded-pill col col-lg-3">{{ $game->status }}</span>
            @endif
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Action</p>
            @if ($game->status === 'Closed')
                <form class="col col-lg-3" method="post"
                    action="{{ action('App\Http\Controllers\DashboardController@start', $game->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-icon">Start Game
                    </button>
                </form>
                <form class="col col-lg-3" method="post"
                    action="{{ action('App\Http\Controllers\DashboardController@open', $game->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-icon">Open Game
                    </button>
                </form>
            @elseif ($game->status === 'Open')
                <form class="col col-lg-3" method="post"
                    action="{{ action('App\Http\Controllers\DashboardController@start', $game->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-icon">Start Game
                    </button>
                </form>
                <form class="col col-lg-3" method="post"
                    action="{{ action('App\Http\Controllers\DashboardController@close', $game->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-icon">Close Game
                    </button>
                </form>
            @else
                <p class="col col-lg-3">None available. Maybe get a drink? 🍹</p>
            @endif

        </li>

    </ul>
    <ul class="list-group mx-auto align-items-start row" style="width: 70vw;">
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Name</p>
            <p class="col">Target</p>
            <p class="col">Killer</p>
            <p class="col col-lg-1">Kills</p>
            <p class="col col-lg-1">Status</p>
            @if ($game->status === 'Started')
                <p class="col col-lg-1">Action</p>
            @endif
        </li>
        @if (count($game->players))
            @foreach ($game->players as $player)
                <li class="list-group-item d-flex justify-content-between row align-items-center">
                    @if ($player->won)
                        <p class="col text-truncate">{{ $player->alias }}👑</p>
                    @else
                        <p class="col text-truncate">{{ $player->alias }}</p>
                    @endif

                    @if ($game->status === 'Started' || $game->status === 'Finished')
                        @if (is_null($player->target))
                            <p class="col text-truncate">/</p>
                            <p class="col text-truncate">{{ $player->killer->alias }}</p>
                        @else
                            <p class="col text-truncate"> {{ $player->target->alias }}</p>
                            <p class="col text-truncate">/</p>
                        @endif
                    @endif
                    <p class="col col-lg-1"> {{ $player->kills }}</p>
                    @if ($player->dead)
                        <span class="col col-lg-1 badge bg-danger text-light">Dead</span>
                    @else
                        <span class="col col-lg-1 badge bg-success text-light">Alive</span>
                    @endif
                    @if ($game->status === 'Started' && !$player->dead)
                        <form method="post" class="col col-lg-1"
                            action="{{ action('App\Http\Controllers\DashboardController@killPlayer', [$game->id, $player->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-icon ">Kill
                            </button>
                        </form>
                    @else
                        <p class="col col-lg-1 text-truncate">/</p>
                    @endif
                </li>
            @endforeach
        @else
            <li class="list-group-item d-flex justify-content-between row align-items-center">
                <p>No players in game. Sooooo.... sit back and relax? 😎</p>
            </li>
        @endif
    </ul>
@endsection
