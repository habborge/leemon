<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Leemon') }}</title>

    <!-- Scripts -->
    
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        
    

    <!-- Fonts -->
   

    <!-- Styles -->
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    @yield('custom-css')
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
                        <div id="one" class="col-6 col-md-2">
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
                                                    <a class="nav-link brand-font" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                                                    
                                                {{-- <div class="dropdown-menu dropdown-menu-position-center dropdown-menu-center text-center" aria-labelledby="navbarDropdown">
                                                    <a class="btn btn-leemon-green btn-block mt-2" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                                                    @if (Route::has('register'))
                                                        <div class="mb-2"><span class="title-tam3">¿Eres nuevo en Leemon? </span><a class="title-tam2" href="{{ route('register') }}">{{ __('Unete aquí.') }}</a></div>
                                                    @endif
                                                </div> --}}
                                                {{--  --}}
                                            </li>
                                            <li class="nav-item dropdown li-width">
                                            <a class="nav-link brand-font" href="{{ route('register')  }}">{{ __('Registrate') }}</a>
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
                                                                    
                                                                    <a href="" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> Mis Pedidos
                                                                    </a>
                                                                    <a href="" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> Mis Listas
                                                                    </a>
                                                                    <a href="/addresses" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-address-book" aria-hidden="true"></i> Mis Direcciones
                                                                    </a>
                                                                    <a href="/secure/methods" class="dropdown-item dropdown-item-text-size">
                                                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Metodo de Pago
                                                                    </a>
                                                                   
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
                        <div id="four" class="col-6 col-md-1">
                            <div class="row float-right">
                                <div id="litlecart" class="main-section">
                                    <div class="dropdown justify-content-end d-flex">
                                        <a type="button" class="btn btn-info cart " data-toggle="dropdown">
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
                                                                <div class="mt-3 mb-3">
                                                                    <p class="brand-font">{{ $details['name'] }}<br>
                                                                        <span class="price cart-text-green"> $ {{ number_format($details['price'],0) }}</span> <span class="count"> Cantidad:{{ $details['quantity'] }}</span></p>
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
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            <div class="">
                <ul id="menu-responsive" class="menu-responsive">
                    @guest
                    <li class="sidepanel-li">
                        <a href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                    </li>
                    <li class="sidepanel-li">
                        <a href="{{ route('register')  }}">{{ __('Registrate') }}</a>
                    </li>
                    @endguest
                    <li class="sidepanel-li">
                        <a href="#"><i class="fa fa-id-card" aria-hidden="true"></i> Nosotros</a>
                    </li>
                    <li id="products" class="sidepanel-li">
                        <a href="#products"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Productos</a>
                        <ul class="sub-menu-responsive">
                            @foreach ($menus as $key => $item)
                                @if ($item['father_id'] == 0)
                                    <li class="sidepanel-li"><a href="/categories/{{ str_replace(" ", "-",$item['name']) }}/{{$item['id']}}">{{ $item['name'] }} </a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @guest

                    @else
                        <li id="profile" class="sidepanel-li">
                            <a href="#profile"><i class="fa fa-user-circle" aria-hidden="true"></i> Perfil</a>
                            <ul class="sub-menu-responsive">
                                <li class="sidepanel-li"><a href="">Ordenes</a></li>
                                <li class="sidepanel-li"><a href="">Lista de Deseos</a></li>
                                <li class="sidepanel-li"><a href="/addresses">Direcciones</a></li>
                                <li class="sidepanel-li"><a href="/secure/methods">Metodos de Pago</a></li>
                            </ul>
                        </li>
                        <li class="sidepanel-li">
                            <a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesión</a>
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
            var list = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // url points to a json file that contains an array of country names, see
            // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
            prefetch: '../js/list.json'
            });

            // passing in `null` for the `options` arguments will result in the default
            // options being used
            $('#prefetch .typeahead').typeahead(null, {
            name: 'list',
            source: list
            });
                    });

    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5EXGMB85XT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-5EXGMB85XT');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1886361894716538');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1886361894716538&ev=PageView&noscript=1" />
    </noscript>
  <!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/603920d2385de407571a73b1/1evfigdno';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
