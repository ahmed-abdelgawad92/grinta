<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('js/jq/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/jq/jquery-ui.theme.min.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jq/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('js/table.js') }}" defer></script>
    <script src="{{ asset('js/order.js') }}" defer></script>
    <script src="{{ asset('js/checkout.js') }}" defer></script>
    <script src="{{ asset('js/ps.js') }}" defer></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('changePassword') }}">change password</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">
                @auth
                @if(Auth::user()->admin)
                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <div class="list-group mb-5">
                            @php
                                $active = $active ?? '';
                            @endphp
                            <a href="{{route('home')}}" class="list-group-item list-group-item-action @if($active == 'dashboard') active @endif">Dashboard</a>
                            <a href="{{route('allTable')}}" class="list-group-item list-group-item-action @if($active == 'table') active @endif">Tables</a>
                            <a href="{{route('createTable')}}" class="list-group-item list-group-item-action @if($active == 'createTable') active @endif">Create new table</a>
                            <a href="{{route('allMeal')}}" class="list-group-item list-group-item-action @if($active == 'meal') active @endif">Meals</a>
                            <a href="{{route('createMeal')}}" class="list-group-item list-group-item-action @if($active == 'createMeal') active @endif">Add new meal</a>
                            <a href="{{route('allDrink')}}" class="list-group-item list-group-item-action @if($active == 'drink') active @endif">Drinks</a>
                            <a href="{{route('createDrink')}}" class="list-group-item list-group-item-action @if($active == 'createDrink') active @endif">Add new drink</a>
                            <a href="{{route('dailyReport')}}" class="list-group-item list-group-item-action @if($active == 'dailyReport') active @endif">Daily Report</a>
                            <a href="#" class="list-group-item list-group-item-action @if($active == 'store') active @endif">Store</a>
                            <a href="#" class="list-group-item list-group-item-action @if($active == 'createStore') active @endif">Add materials to the store</a>
                            <a href="{{route('allUser')}}" class="list-group-item list-group-item-action @if($active == 'user') active @endif">Users</a>
                            <a href="{{route('createUser')}}" class="list-group-item list-group-item-action @if($active == 'createUser') active @endif">Add new user</a>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card">
                            @yield('content')
                        </div>
                    </div>
                </div>
                @else 
                <div class="card">
                    @yield('content')
                </div>
                @endif
                @endauth
                @guest
                @yield('content')
                @endguest
            </div>
        </main>
    </div>
</body>
</html>
