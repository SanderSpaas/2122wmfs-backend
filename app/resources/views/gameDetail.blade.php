@extends('layout')

@section('title', 'Gotcha | Dashboard')


@section('content')
    <h3 class="text-center">Welkom {{ $user->name }}.</h3>
    <h2 class="text-center">Dit is de detailpagina van: {{ $game->name }}</h2>
    <ul class="list-group mx-auto align-items-start row" style="width: 70vw;">
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Name</p>
            <p class="col">Target</p>
            <p class="col">Killer</p>
            <p class="col col-lg-1">Kills</p>
            <p class="col col-lg-1">Status</p>
        </li>
        {{-- {{$game}} --}}
        @foreach ($game->players as $player)
            <li class="list-group-item d-flex justify-content-between row align-items-center">
                <p class="col text-truncate">{{ $player->alias }}</p>
                @if (is_null($player->target))
                    <p class="col text-truncate">/</p>
                    <p class="col text-truncate">{{ $player->killer->alias }}</p>
                @else
                    <p class="col text-truncate"> {{ $player->target->alias }}</p>
                    <p class="col text-truncate">/</p>
                @endif

                <p class="col col-lg-1"> {{ $player->kills }}</p>
                @if ($player->dead)
                    <span class="col col-lg-1 badge bg-danger text-light">Dead</span>
                @else
                    <span class="col col-lg-1 badge bg-success text-light">Alive</span>
                    <form method="POST" action="{{ action('App\Http\Controllers\GameController@killPlayer', [$game->id, $player->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-icon">Kill
                        </button>
                    </form>
                @endif

                {{-- {{ print_r($player->toArray(), true) }} --}}
                {{-- <p class="col">{{ \Carbon\Carbon::parse($game->end_time)->format('d/m/Y') }}</p>
                
                @if ($game->status === 'Closed' || $game->status === 'Finished')
                    <span class="badge bg-danger rounded-pill col col-lg-1">{{ $game->status }}</span>
                @elseif ($game->status === 'Open')
                    <span class="badge bg-success rounded-pill col col-lg-1">{{ $game->status }}</span>
                @else
                    <span class="badge bg-warning rounded-pill col col-lg-1">{{ $game->status }}</span>
                @endif --}}

            </li>
        @endforeach
    </ul>


@endsection
