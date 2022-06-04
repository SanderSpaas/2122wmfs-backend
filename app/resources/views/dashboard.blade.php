@extends('layout')

@section('title', 'Gotcha | Dashboard')


@section('content')
    <h3 class="text-center">Welkom {{ $user->name }}.</h3>
    <h2 class="text-center">Hier is de lijst van alle games.</h2>
    <ul class="list-group mx-auto align-items-start row mb-5" style="width: 70vw;">
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col col-lg-1">Info</p>
            <p class="col">Name</p>
            <p class="col col-lg-2">Endtime</p>
            <p class="col col-lg-2">Total Players</p>
            <p class="col col-lg-1">Status</p>
            <p class="col col-lg-2">Action</p>
        </li>
        @foreach ($games as $game)
            <li class="list-group-item d-flex justify-content-between row align-items-center">
                <a class="btn btn-outline-info col-lg-1" href="{{ url('games/' . $game->id) }}">Info</a>
                <p class="fw-bold col text-truncate">{{ $game->name }}</p>

                <p class="col col-lg-2">{{ \Carbon\Carbon::parse($game->end_time)->format('d/m/Y') }}</p>
                @if ($game->players !== null)
                    <p class="col col-lg-2">{{ count($game->players) }}👤</p>
                @else
                    <p class="col col-lg-2">0👤</p>
                @endif
                <span @class([
                'badge rounded-pill col col-lg-1',
                'bg-success' => $game->status === 'Open',
                'bg-primary' => $game->status === 'Finished',
                'bg-warning' => $game->status === 'Started',
                'bg-danger' => $game->status === 'Closed',
            ])>{{ $game->status }}</span>
                <form class="col col-lg-2" method="post"
                    action="{{ action('App\Http\Controllers\DashboardController@delete', $game->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-icon">Delete
                    </button>
                </form>
            </li>
        @endforeach
    </ul>


@endsection
