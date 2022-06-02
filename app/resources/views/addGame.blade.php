@extends('layout')
@section('title', 'Gotcha | Create a game')
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="mb-3">Create a game</h4>
                    @include('common.errors')
                    @foreach ($errors->getMessages() as $key => $message)
                        {{ $errorArray[] = $key }}
                    @endforeach

                    <form class="needs-validation" novalidate="" method="post" action="{{ url('dashboard/game/create') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text"
                                    class="form-control {{ session()->exists('_old_input.name') ? (in_array('name', $errorArray) ? 'is-invalid' : 'is-valid') : '' }}"
                                    id="name" placeholder="" name="name" value="{{ old('name', '') }}">
                            </div>
                            <div class="col-12">
                                <label for="murder_method" class="form-label">Murder method</label>
                                <textarea class="form-control {{ session()->exists('_old_input.murder_method') ? (in_array('murder_method', $errorArray) ? 'is-invalid' : 'is-valid') : '' }}"
                                    id="murder_method" rows="2"
                                    name="murder_method">{{ old('murder_method', '') }}</textarea>
                            </div>
                            <div class="col-5">
                                <label for="start_time" class="form-label">Start time</label>
                                <input type="date"
                                    class="form-control 
                                    {{ session()->exists('_old_input.start_time') ? (in_array('start_time', $errorArray) ? 'is-invalid' : 'is-valid') : '' }}"
                                    id="start_time" name="start_time" value="{{ old('start_time', '') }}">

                                <label for="end_time" class="form-label">End time</label>
                                <input type="date"
                                    class="form-control 
                                    {{ session()->exists('_old_input.end_time') ? (in_array('end_time', $errorArray) ? 'is-invalid' : 'is-valid') : '' }}"
                                    id="end_time" name="end_time" value="{{ old('end_time', '') }}">

                            </div>
                        </div>
                </div>
                <hr class="my-4">
                <button class="btn btn-primary btn-lg" type="submit">Create game</button>
                </form>
            </div>
        </div>
        </div>
    </main>
@endsection
