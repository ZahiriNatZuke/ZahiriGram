<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset('ico/logo.ico')}}" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .nav-link, .links {
            color: #636b6f;
            margin: 0;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div id="app" class="customized-scroll">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex" @guest href="{{ route('home') }}" @else href="{{ route('post.index') }}"
                @endguest>
                <div><img class="pr-3" src="{{ asset('ico/logo.ico') }}" alt="logo.svg"
                          style="height: 44px; border-right: 1px solid #333333"></div>
                <div class="pl-3 pt-1 font-weight-normal"
                     style="font-size: 32px">{{ config('app.name', 'Laravel') }}</div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    @auth
                        <search-form></search-form>
                    @endauth
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle font-weight-bold" href="#"
                               role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                               style="font-size: 16px">
                                <img src="{{Auth::user()->profile->profileImage()}}" class="w-100 rounded-circle mr-2"
                                     style="max-width: 40px; max-height: 40px" alt="">
                                {{ Auth::user()->username }} <span class="ml-2 caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item links" href="{{ route('post.create') }}">
                                    {{ __('New Post') }}
                                </a>
                                <a class="dropdown-item links"
                                   href="{{ route('profile.show', ['user'=> Auth::user()->id]) }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item links" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main id="main">
        <div id="main-container">
            @yield('content')
        </div>
        <view-search id="search-container"></view-search>
    </main>
</div>
</body>
</html>

