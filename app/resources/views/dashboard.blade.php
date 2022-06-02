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
                <a class="btn btn-outline-info col-lg-1" href="{{ url('dashboard/game/' . $game->id) }}">Info</a>
                <p class="fw-bold col text-truncate">{{ $game->name }}</p>

                <p class="col col-lg-2">{{ \Carbon\Carbon::parse($game->end_time)->format('d/m/Y') }}</p>
                @if ($game->players !== null)
                    <p class="col col-lg-2">{{ count($game->players) }}👤</p>
                @else
                    <p class="col col-lg-2">0👤</p>
                @endif
                @if ($game->status === 'Closed')
                    <span class="badge bg-danger rounded-pill col col-lg-1">{{ $game->status }}</span>
                @elseif ($game->status === 'Open')
                    <span class="badge bg-success rounded-pill col col-lg-1">{{ $game->status }}</span>
                @elseif ($game->status === 'Finished')
                    <span class="badge bg-primary rounded-pill col col-lg-1">{{ $game->status }}</span>
                @else
                    <span class="badge bg-warning rounded-pill col col-lg-1">{{ $game->status }}</span>
                @endif
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
