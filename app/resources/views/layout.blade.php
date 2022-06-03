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



        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">


        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

        </style>


        <!-- Custom styles for this template -->
        <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <img src="{{ asset('storage/img/GotchaLogo.gif') }}" height="28" alt="Gotcha">
                </a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="{{ url('dashboard') }}" class="nav-item nav-link active">Home</a>
                        @auth
                            <a href="{{ url('dashboard/game/create') }}" class="nav-item nav-link">Create game</a>
                        @endauth
                        @auth
                            <a href="{{ url('dashboard/users') }}" class="nav-item nav-link">Users</a>
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
        <footer class="blog-footer">
            <p>&copy; Project Gotcha By: Sander Spaas for Web &amp; Mobile Full-stack @ <a
                    href="https://www.odisee.be">odisee</a></p>
        </footer>
    </body>

    </html>
@show
