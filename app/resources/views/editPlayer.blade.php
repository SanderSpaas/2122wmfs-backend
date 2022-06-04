@extends('layout')
@section('title', 'Gotcha | Edit a player')
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8 mx-auto">
                <div class="p-4 mb-3 bg-light rounded ">
                    <h4 class="my-3">Edit a player</h4>
                    @include('common.errors')

                    <form class="needs-validation" novalidate="" method="post"
                        action="{{ url('games/' . $game->id . '/players/' . $player->id . '/edit') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="alias" class="form-label">Alias</label>
                                <input type="text" class="form-control @error('alias') is-invalid @enderror" id="alias"
                                    placeholder="" name="alias"
                                    value="{{ old('alias') ? old('alias') : $player->alias }}">
                            </div>
                            <div class="col-12">
                                <label for="kills" class="form-label">Kills</label>
                                <input type="number" class="form-control @error('kills') is-invalid @enderror" id="kills"
                                    name="kills" min="0" value="{{ old('kills') ? old('kills') : $player->kills }}">
                            </div>
                        </div>
                        <hr class="my-4">
                        <button class="btn btn-primary btn-lg" type="submit">Update player</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
