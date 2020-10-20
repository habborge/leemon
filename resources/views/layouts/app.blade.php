<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Leemon') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>
    <script src="{{ secure_asset('js/scripts.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    @font-face {
        font-family: "AcuminVariableConcept2";
        src: url("{{ env('APP_URL')}}/css/AcuminVariableConceptCondens.otf") format('opentype');
    }
    @font-face {
        font-family: "AcuminVariableConcept";
        src: url("{{ env('APP_URL') }}/css/AcuminVariableConcept.otf") format('opentype');
    }

</style>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="col-md-2">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/img/logo_leemon_small_black.png" alt="" class="leemonlogo">
                    </a>
                </div>
                
                <div class="col-md-6">
                    <form name="form" id="form" action="/result" class="" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <input name="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="search" aria-describedby="button-addon2">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="row">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="col-md-3">
                    <div class="row">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            
                            <ul class="navbar-nav mr-auto">
                                
                            </ul>
        
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Log in') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrate') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
        
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                        <div class="main-section">
                            <div class="dropdown">
                                <button type="button" class="btn btn-info" data-toggle="dropdown">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>Carrito<span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                                </button>
                                <div class="dropdown-menu">
                                    <div class="row total-header-section">
                                        <div class="col-lg-6 col-sm-6 col-6">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                                        </div>
                                        <?php $total = 0 ?>
                                        @foreach((array) session('cart') as $id => $details)
                                            <?php $total += $details['price'] * $details['quantity'] ?>
                                        @endforeach
         
                                        <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                            <p>Total: <span class="text-info">$ {{ number_format($total,0) }}</span></p>
                                        </div>
                                    </div>
         
                                    @if(session('cart'))
                                        @foreach(session('cart') as $id => $details)
                                            <div class="row cart-detail">
                                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                                    <img src="{{ env('APP_URL') }}/{{ $details['photo'] }}" />
                                                </div>
                                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                                    <p>{{ $details['name'] }}</p>
                                                    <span class="price text-info"> $ {{ number_format($details['price'],0) }}</span> <span class="count"> Cantidad:{{ $details['quantity'] }}</span>
                                                </div>
                                                
                                            </div>
                                            
                                        @endforeach
                                    @endif
        
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 text-center">
                                            <hr class="mb-4">
                                            <a href="{{ url('cart') }}" class="btn btn-primary btn-block">Ver completo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </nav>
        @include('layouts.menu')
            @yield('content')
        
    </div>
    @yield('custom-js')
</body>
</html>
