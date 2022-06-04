@extends('layout')

@section('title', 'Gotcha | Dashboard')


@section('content')
    <div class="row p-4 m-5 mb-5 bg-light rounded mx-auto" style="width: 70vw;">
        <h3 class="mb-3">Search users</h3>
        <form class="needs-validation" novalidate="" method="get" action="{{ url('/dashboard/users/search') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="term" class="form-label">Search term(s)</label>
                    <input type="text" class="form-control" id="term" placeholder="" name="term"
                        value="{{ request('term') }}">
                </div>
                <div class="col-12 col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" required="" name="role">
                        <option value="">any role</option>
                        @foreach ($roles as $role)
                            @if (request('role') == $role)
                                <option value="{{ $role }}" selected>
                                    {{ $role }}</option>
                            @else
                                <option value="{{ $role }}">{{ $role }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <hr class="my-4">

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="sort" class="form-label">Sort by</label>
                    <select class="form-select" id="sort" required="" name="sort">
                        <option value="name" @if (request('sort') == 'name') selected @endif>name</option>
                        <option value="role" @if (request('sort') == 'role') selected @endif>role</option>
                        <option value="most_recent" @if (request('sort') == 'most_recent') selected @endif>most recent
                        </option>
                        <option value="less_recent" @if (request('sort') == 'less_recent') selected @endif>less recent
                        </option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-center mt-5">
                    <button class="btn btn-primary btn-lg" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>

    <ul class="list-group mx-auto row my-5" style="width: 70vw;">
        <li class="list-group-item d-flex justify-content-between align-items-start row align-items-center">
            <p class="col ">Name</p>
            <p class="col">Role</p>
            <p class="col">Actions</p>
        </li>
        @if (count($users))
            @foreach ($users as $user)
                <li class="list-group-item d-flex justify-content-between row align-items-center">
                    <p class="col"> {{ $user->name }}</p>
                    <p class="col"> {{ $user->role }}</p>

                    <form method="post" class='col'
                        action="{{ action('App\Http\Controllers\DashboardController@userStore', $user->id) }}">
                        @include('common.errors')
                        @foreach ($errors->getMessages() as $key => $message)
                            {!! $errorArray[] = $key !!}
                        @endforeach
                        {{-- <label for="role" class="form-label">Change role</label> --}}
                        <div class="d-flex"><select
                                class="form-select {{ session()->exists('_old_input.role') ? (in_array('role', $errorArray) ? 'is-invalid' : 'is-valid') : '' }}"
                                id="role" required="true" name="role">
                                <option value="">Change role...</option>
                                @foreach ($roles as $role)
                                    @if (old('role') == $role)
                                        <option value="{{ $role }}" selected>
                                            {{ $role }}</option>
                                    @else
                                        <option value="{{ $role }}">{{ $role }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @csrf
                            <button type="submit" class="btn btn-outline-success btn-icon">Update
                            </button>
                        </div>
                    </form>
                </li>
            @endforeach
            <div class='d-flex my-5'>
                <ul class='pagination mx-auto'>
                    {!! $users->links() !!}
                </ul>
            </div>
        @else
            <li class="list-group-item d-flex justify-content-between row align-items-center">
                <p>No users found with the given search criteria.</p>
            </li>
        @endif
    </ul>
@endsection
