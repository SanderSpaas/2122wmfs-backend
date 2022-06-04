@section('header')
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.84.0">
        <title>@yield('title')</title>

        <meta name="color-scheme" content="light dark">

        <!-- Load the alternate CSS first ...in this case the Bootstrap-Dark Variant CSS -->
        <link href="{{ asset('css/bootstrap.min.dark.css') }}" rel="stylesheet" media="(prefers-color-scheme: dark)">
        <!-- and then the primary CSS last ...in this case the (original) Bootstrap Variant CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" media="(prefers-color-scheme: light)">

    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a href="{{ url('dashboard') }}" class="navbar-brand">
                    <h1>Gotcha</h1>
                </a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="{{ url('dashboard') }}" class="nav-item nav-link active">Home</a>
                        @auth
                            <a href="{{ url('games/create') }}" class="nav-item nav-link">Create game</a>
                        @endauth
                        @auth
                            <a href="{{ url('users') }}" class="nav-item nav-link">Users</a>
                        @endauth
                    </div>
                    @auth
                        <div class="navbar-nav ms-auto">
                            <a class="nav-item nav-link" href="{{ url('logout') }}">Logout</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    @show
    @section('content')

    @show
    @section('footer')
        <footer class="bg-light text-center">
            <!-- Grid container -->
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                <p>&copy; Project Gotcha By: Sander Spaas for Web &amp; Mobile Full-stack @ <a
                        href="https://www.odisee.be">odisee</a></p>
            </div>
            <!-- Copyright -->
        </footer>
    </body>

    </html>
@show
