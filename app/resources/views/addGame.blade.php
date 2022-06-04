@extends('layout')
@section('title', 'Gotcha | Create a game')
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8 mx-auto">
                <div class="p-4 my-3 bg-light rounded ">
                    <h4 class="mb-3">Create a game</h4>
                    @include('common.errors')
                    <form class="needs-validation" novalidate="" method="post" action="{{ url('games/create') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="" name="name" value="{{ old('name', '') }}">
                            </div>
                            <div class="col-12">
                                <label for="murder_method" class="form-label">Murder method</label>
                                <textarea class="form-control @error('murder_method') is-invalid @enderror" id="murder_method" rows="2"
                                    name="murder_method">{{ old('murder_method', '') }}</textarea>
                            </div>
                            <div class="d-flex justify-content-start">
                                <div><label for="start_time" class="form-label">Start time</label>
                                    <input type="date" class="form-control @error('start_time') is-invalid @enderror"
                                        id="start_time" name="start_time" value="{{ old('start_time', '') }}">
                                </div>
                                <div> <label for="end_time" class="form-label">End time</label>
                                    <input type="date"
                                        class="form-control 
                                   @error('end_time') is-invalid @enderror"
                                        id="end_time" name="end_time" value="{{ old('end_time', '') }}">
                                </div>

                            </div>
                        </div>

                        <hr class="my-4">
                        <button class="btn btn-primary btn-lg" type="submit">Create game</button>
                </div>
                </form>
            </div>
        </div>
        </div>
    </main>
@endsection
