<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="facebook-domain-verification" content="culvwqzsmvfz76p5lcr2ta3sw4xbbw" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    

    <!-- Scripts -->
    
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        
    

    <!-- favicon 
    <link rel="apple-touch-icon" sizes="180x180" href="https://leemon.s3.amazonaws.com/development/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://leemon.s3.amazonaws.com/development/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://leemon.s3.amazonaws.com/development/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://leemon.s3.amazonaws.com/development/images/favicon/site.webmanifest">-->

    <!-- Styles -->
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://leemon.s3.amazonaws.com/development/statics/css/floating-wpp.min.css">
    @yield('custom-css')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5EXGMB85XT"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-5EXGMB85XT');
    </script>

    <!-- Hotjar Tracking Code for https://www.leemon.com.co -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:2343211,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>
<style>
    @font-face {
        font-family: "GothamBook";
        src: url("{{ URL::to('/') }}/css/GothamBook.otf") format('opentype');
    }

    @font-face {
        font-family: "Gotham-Black";
        src: url("{{ URL::to('/') }}/css/Gotham-Black.otf") format('opentype');
    }

    #loading_web{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #5a5a5aa3;
        z-index: 99999;
        display: none;
    }

    #loading_web2, #loading_web3, #loading_sendtofriend{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* background: #5a5a5aa3; */
        z-index: 99999;
        display: none;
    }
    #img_loading{
        max-width: 60px;
        z-index: 9999;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }
    .otro{
        width: 100% !important;
    }
    #nodis{
        display: none;
    }
    #cajacookies {
            box-shadow: 0px 0px 5px 5px #c1c1c185;
            background-color: #000000c7;
            color: #fff;
            padding: 15px 30px;
            margin-bottom: 0px;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 999;
            text-align: center !important;
        }
    
        #cajacookies button {
            color: #fff;
        }
        #cajacookies button:hover {
            color: #fff;
            border-color: #c49703;
            background: #c49703;
        }
        .btn-success {
            color: #fff;
            background-color: #c49703;
            border-color: #c49703;
        }
        #cajacookies a:hover {
            color: #fff !important;
            text-decoration: underline !important;
        }
        #cajacookies a {
            font-weight: bold;
            text-decoration: underline !important;
            color: #a56b03;
        }
</style>
<body>
    <div id="app">
        
        <nav id="" class="navbar navbar-expand-md navbar-light shadow-sm">
            
            <div class="container dataPosition">
                <div class="col-12 col xl-12">
                    <div class="row ancho">
                        {{-- 1 --}}
                        <div id="one" class="col-7 col-md-2">
                            <div class="row">
                                <button  onclick="openNav()" class="navbar-toggler" type="button" data-toggle="" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="{{ __('Toggle navigation') }}">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    <img src="/img/logo_leemon_small_black.png" alt="" class="leemonlogo">
                                </a>
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div id="two" class="col-12 col-md-6 mr-auto">
                            <div class="row">
                                <form  name="form" id="form" action="/result" class="search-form" method="GET">
                                    @csrf
                                    
                                    <div class="col-md-12 col-12 input-group mb-3">
                                        <div id="prefetch" class="col-md-10 col-9">
                                            <div class="row">
                                                <input id="search" name="search" type="search" class="form-control input-search-ra typeahead form-unfocus" aria-label="search" aria-describedby="" placeholder="Hacer una busqueda..." style="" required>
                                            </div>
                                        </div>
                                        
                                        <div class="input-group-append col-md-2 col-3">
                                        <div class="row">
                                            <button class="btn btn-outline-success btn-search-ra" type="submit">Buscar</button>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- 3 --}}
                        <div id="three" class="col-2 col-md-3">
                            <div class="row text-center">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <!-- Left Side Of Navbar -->
                                    <ul class="navbar-nav mr-auto">
                                    </ul>
                
                                    <!-- Right Side Of Navbar -->
                                    <ul class="navbar-nav ul-width ml-auto">
                                        <!-- Authentication Links -->
                                        @guest
                                            <li class="nav-item dropdown li-width">
                                                {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
                                                Registrate<span class="caret"></span>
                                                </a>
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
                                                    Inicia Sesión<span class="caret"></span>
                                                    </a> --}}
                                                    <a class="nav-link brand-font-login" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                                                    
                                                {{-- <div class="dropdown-menu dropdown-menu-position-center dropdown-menu-center text-center" aria-labelledby="navbarDropdown">
                                                    <a class="btn btn-leemon-green btn-block mt-2" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                                                    @if (Route::has('register'))
                                                        <div class="mb-2"><span class="title-tam3">¿Eres nuevo en Leemon? </span><a class="title-tam2" href="{{ route('register') }}">{{ __('Unete aquí.') }}</a></div>
                                                    @endif
                                                </div> --}}
                                                {{--  --}}
                                            </li>
                                            <li class="nav-item dropdown li-width">
                                            <a class="nav-link brand-font-login " href="{{ route('register')  }}">{{ __('Registrate') }}</a>
                                            </li>
                                        @else
                                            <li class="nav-item dropdown li-width">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><img src="/img/PERFIL.png" width="30px" alt="">
                                                    {{ Auth::user()->name }} <span class="caret"></span>
                                                </a>
                                                
                                                <div class="dropdown-menu dropdown-menu-position-center dropdown-menu-center" aria-labelledby="navbarDropdown">
                                                    <div class="col-12 col-md-12 mt-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-6 col-md-6 line-right-profile">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-12 text-center mt-3 mb-3">
                                                                        <img src="/img/PERFIL.png" width="80px" alt="">
                                                                    </div>
                                                                    <div class="col-12 col-md-12">
                                                                    <a href="" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Perfil
                                                                    </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 col-md-6">
                                                                <div class="row">
                                                                    
                                                                    <a href="/secure/orders/info" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> Mis Pedidos
                                                                    </a>
                                                                    <a href="/secure/wishlist" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> Mis Listas
                                                                    </a>
                                                                    <a href="/addresses" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-address-book" aria-hidden="true"></i> Mis Direcciones
                                                                    </a>
                                                                    {{-- <a href="/secure/methods" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Metodo de Pago
                                                                    </a> --}}
                                                                   
                                                                    <a class="dropdown-item dropdown-item-text-size mt-3" href="{{ route('logout') }}"
                                                                    onclick="event.preventDefault();
                                                                                    document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                                                        {{ __('Cerrar Sesión') }}
                                                                    </a>
                                
                                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                        @csrf
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </li>
                                        @endguest
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- 4 --}}
                        <div id="four" class="col-5 col-md-1">
                            <div class="row float-right">
                                <div id="litlecart" class="main-section">
                                    <div class="dropdown justify-content-end d-flex">
                                        <a type="" class="btn btn-info cart " data-toggle="dropdown">
                                            <span class="cart-size"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span><span id="cart_menu_num" class="">{{ count((array) session('cart')) }}</span>
                                        </a>
                                        @if(session('cart'))
                                            <div class="dropdown-menu dropdown-menu-position">
                                                <div class="row total-header-section">
                                                    {{-- <div class="col-lg-6 col-sm-6 col-6">
                                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                                                    </div> --}}
                                                    <?php $total = 0 ?>
                                                    @foreach((array) session('cart') as $id => $details)
                                                        <?php $total += $details['price'] * $details['quantity'] ?>
                                                    @endforeach
                    
                                                    <div class="col-lg-12 col-sm-12 col-12 total-section mb-3">
                                                        <div class="row">
                                                            <div class="col-6 col-sm-6 text-left">
                                                                Total a Pagar:
                                                            </div>
                                                            <div class="col-6 col-sm-6 text-right ">
                                                                <span class="cart-text-green">$ {{ number_format($total,0) }}</span> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                
                                                    @foreach(session('cart') as $id => $details)
                                                        <div class="row cart-detail">
                                                            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                                                <img src="{{ $details['photo'] }}" />
                                                            </div>
                                                            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product ">
                                                                <div class="mt-2 mb-2">
                                                                    <p class="brand-font">{{ $details['name'] }}<br>
                                                                        <span class="count"> Cantidad: {{ $details['quantity'] }}</span><span class="price cart-text-green font-black"> $ {{ number_format($details['price'],0) }}</span> </p>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    @endforeach
                                                
                    
                                                <div class="row cart-footer">
                                                    <div class="col-lg-12 col-sm-12 col-12 text-center">
                                                        
                                                        <a href="{{ url('cart') }}" class="btn btn-purchase btn-block">Ver completo</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div id="mySidepanel" class="sidepanel">
            <img src="/img/logo_leemon_small_black.png" alt="" class="leemonlogo img-menu-side">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            <div class="">
                <ul id="menu-responsive" class="menu-responsive mt-2">
                    @guest
                        <li class="sidepanel-li">
                            
                            <a href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> {{ __('Iniciar Sesión') }}</a>
                        </li>
                        <li class="sidepanel-li">
                            <a href="{{ route('register')  }}"><i class="fa fa-user-plus" aria-hidden="true"></i> {{ __('Registrate') }}</a>
                        </li>
                    @else
                        <li id="profile" class="sidepanel-li">
                            <a href="#profile"><i class="fa fa-user-circle" aria-hidden="true"></i> Perfil</a>
                            <ul class="sub-menu-responsive">
                                <li class="sidepanel-li"><a href="/secure/orders/info"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Mis pedidos</a></li>
                                <li class="sidepanel-li"><a href="/secure/wishlist"><i class="fa fa-heart" aria-hidden="true"></i> Lista de Deseos</a></li>
                                <li class="sidepanel-li"><a href="/addresses"><i class="fa fa-address-book" aria-hidden="true"></i> Direcciones</a></li>
                                {{-- <li class="sidepanel-li"><a href="/secure/methods"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Metodos de Pago</a></li> --}}
                            </ul>
                        </li>
                    @endguest
                    
                        <li id="products" class="sidepanel-li">
                            <a href="#products"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Productos</a>
                            <ul class="sub-menu-responsive">
                                @foreach ($menus as $key => $item)
                                    @if ($item['father_id'] == 0)
                                        <li class="sidepanel-li"><a href="/categories/{{ str_replace(" ", "-",$item['name']) }}/{{$item['id']}}"><i class="fa fa-minus" aria-hidden="true"></i> {{ $item['name'] }} </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>

                    @guest

                    @else
                        <li class="sidepanel-li">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                {{ __('Cerrar Sesión') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
        <div id="megamenu">
            @include('layouts.menu2')
        </div>
        <div id="loading_web">
			<img src="/img/preloader.gif" id="img_loading" alt="">
		</div>
            @yield('content')
            
            
            @if (date("l") != "SUNDAY")
                @if (date("l") == "SATURDAY")
                    @if ((date("H:i:s") >= "08:00:00") and (date("H:i:s") <= "17:00:00"))
                        <div id="myDiv"></div>
                    @endif
                @else
                    @if ((date("H:i:s") >= "08:00:00") and (date("H:i:s") <= "19:00:00"))
                        <div id="myDiv"></div>
                    @endif
                @endif
            @endif
    </div>
    
    <link href="{{ asset('js/toastr/toastr.min.css') }}" rel="stylesheet">
        <script src="{{ asset('js/toastr/toastr.min.js') }}" defer></script>
        <link href="{{ asset('js/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
     
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="{{ asset('js/jquery.validate.min.js') }}" defer></script>
    @include('layouts.footer')

    @yield('custom-js')
    @yield('modal-js')
    <script src="{{ asset('js/typeahead.bundle.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript">
        function openNav() {
            document.getElementById("mySidepanel").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        $(document).ready(function(){
            // Defining the local dataset
            
            
            // Constructing the suggestion engine
            // var list = new Bloodhound({
            //     datumTokenizer: Bloodhound.tokenizers.whitespace,
            //     queryTokenizer: Bloodhound.tokenizers.whitespace,
            //     // url points to a json file that contains an array of country names, see
            //     // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
            //     prefetch: '../js/listpro.json'
            // });

            // // passing in `null` for the `options` arguments will result in the default
            // // options being used
            // $('#prefetch .typeahead').typeahead(null, {
            //     name: 'list',
            //     source: list,
            //     limit: 10
            // });

            var products = new Bloodhound({
                datumTokenizer: function(datum) {
                    return Bloodhound.tokenizers.whitespace(datum.value);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: { 
                    url: "/",
                    transform: function(response) {
                            return $.map(response, function(product) {
                                return { value: restaurant.name };
                            });
                        }
                },
                remote: {
                    wildcard: '%QUERY',
                    url: "/searching/result/%QUERY",
                        transform: function(response) {
                            return $.map(response, function(product) {
                                return { value: product.name };
                            });
                        }
                }
            });

            $('.typeahead').typeahead({
                    hint: false,
                    highlight: true,
                    minLength: 2,
                },
                {
                    name: 'products',
                    display: 'value',
                    source: products,  
                    limit: 10
                }
            );

            $('#myDiv').floatingWhatsApp({
                phone: '573022058199',
                popupMessage: 'Hola, ¿Cómo podemos ayudarte?',
                message: "",
                showPopup: true,
                showOnIE: false,
                headerTitle: 'Bienvenido a Leemon! <br>Horario de Lunes a Viernes 8:00am a 7:00pm <br>Sabados 8:00am a 5:00pm',
                position: 'right',
                zIndex: 1000
            });
        });

    </script>
    {{-- wahtasapp --}}
    <script type="text/javascript" src="https://leemon.s3.amazonaws.com/development/statics/js/floating-wpp.min.js" defer></script>
    
    
    
</body>
</html>
