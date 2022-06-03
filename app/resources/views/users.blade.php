@extends('layout')

@section('title', 'Gotcha | Dashboard')


@section('content')
    <ul class="list-group mx-auto align-items-start row mb-5" style="width: 70vw;">
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

                    <form method="post"
                        action="{{ action('App\Http\Controllers\DashboardController@usersStore', $user->id) }}">
                        <label for="role" class="form-label">Change role</label>
                        <select
                            class="form-select {{ session()->exists('_old_input.role') ? (in_array('role', $errorArray) ? 'is-invalid' : 'is-valid') : '' }}"
                            id="role" required="true" name="role">
                            <option value="">Choose...</option>
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
                <p>No players in game. Sooooo.... sit back and relax? 😎</p>
            </li>
        @endif
    </ul>
@endsection
