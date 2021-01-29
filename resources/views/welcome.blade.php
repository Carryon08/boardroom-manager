<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Boardroom</title>

        <nav class="navbar navbar-expand-md navbar-light sticky-top" style="background-color: darkorange">
            <a class="navbar-brand" href="#">Boardroom</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="collapsibleNavbar">
                <ul class="navbar-nav float-right ml-auto">
                    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                        @if (Route::has('login'))
                        <div class="hidden fixed ">
                            @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ url('/home') }}" class="btn-success dropdown-item mr-2 text-gray-200">Home</a>
                                    <a class=" text-gray-200 dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @else

                                <a href="{{ route('login') }}" class="btn-outline-dark text-gray-200">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-outline-dark ml-4 text-gray-200">Register</a>
                                @endif
                            @endauth
                        </div>
                        @endif
                    </div>
                </ul>
            </div>
        </nav>

    </head>
    <body class="" >
        <div id="app">

        </div>

    </body>
</html>
