@extends('layout')

@section('title', 'Blogotopia | Sign in')


@section('content')
            <div class="p-4 mb-3 bg-light rounded">
                <h4 class="mb-3">Sign in</h4>
                <form class="needs-validation" novalidate="" method="post" action="{{ url('login') }}">
                    @csrf
                    <div class="row g-3">

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="" name="email" value="{{ old('email', '') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" placeholder="" name="password" value="">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                    <hr class="my-4">


                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember"
                            @if (old('remember')) checked="checked" @endif>
                        <label class="form-check-label" for="featured">Remember me</label>
                    </div>


                    <hr class="my-4">

                    <button class="btn btn-primary btn-lg" type="submit">Sign in</button>
                </form>

            </div>
        
@endsection
