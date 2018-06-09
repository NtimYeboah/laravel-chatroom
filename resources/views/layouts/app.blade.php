<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css.1/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css.1/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css.1/landing.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
            <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
                @guest
                <li class="hidden-xs">
                    <a href="{{ route('login') }}" class="dropdown-toggle">
                        {{ __('Login') }}
                    </a>
                </li>
                <li class="hidden-xs">
                    <a href="{{ route('register') }}" class="dropdown-toggle">
                        {{ __('Register') }}
                    </a>
                </li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-left">
                        </span>
                        {{ Auth::user()->name }} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">            
                        <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>      
        </header>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
