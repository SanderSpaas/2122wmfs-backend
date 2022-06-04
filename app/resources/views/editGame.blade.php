@extends('layout')
@section('title', 'Gotcha | Edit a game')
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8 mx-auto">
                <div class="p-4 mb-3 bg-light rounded ">
                    <h4 class="my-3">Edit a game</h4>
                    @include('common.errors')
                    <form class="needs-validation" novalidate="" method="post"
                        action="{{ url('games/' . $game->id . '/edit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="" name="name" value="{{ old('name') ? old('name') : $game->name }}">
                            </div>
                            <div class="col-12">
                                <label for="murder_method" class="form-label">Murder method</label>
                                <textarea class="form-control @error('murder_method') is-invalid @enderror" id="murder_method" rows="2"
                                    name="murder_method">{{ old('murder_method') ? old('murder_method') : $game->murder_method }}</textarea>
                            </div>
                        </div>
                        <hr class="my-4">
                        <button class="btn btn-primary btn-lg" type="submit">Update game</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
