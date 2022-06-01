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
        <nav class="navbar bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/dashboard">
                    <img src="{{ asset('storage/img/GotchaLogo.gif') }}" alt="logo gotcha" width="50" height="50"
                        class="d-inline-block align-text-top">
                </a>
                <h1>Gotcha</h1>

                @auth
                    <a class="btn btn-sm btn-outline-secondary" href="{{ url('logout') }}">Logout</a>
                @endauth
            </div>
        </nav>
        </div>
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
