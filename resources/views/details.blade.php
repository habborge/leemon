@extends('layouts.app')
@section('custom-css')

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@leemon_market">
    <meta name="twitter:title" content="Leemon">
    <meta property="twitter:description" content="{{ $prod_info->name }}">
    <meta name="twitter:creator" content="@leemon_market">
    
    <!-- Twitter Summary card images. Igual o superar los 200x200px -->
    <meta name="twitter:image" content="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}">
    <link href="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" rel="image_src">
    <!-- Open Graph data -->
    <meta property="og:title" content="Leemon" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:image" content="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" />
    <meta property="og:image:url" content="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" />
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="og:image:type" content="image/png">
    <meta property="og:description" content="{{ $prod_info->name }}" />
    <meta property="og:site_name" content="Leemon.com.co" />
    <title>Leemon - {{ $prod_info->name }}</title>
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../css/buttonquantity.css">
    @if (env('APP_ENV') == "production")    
        <link href="{{ secure_asset('css/xzoom.css') }}" rel="stylesheet">
    @else 
        <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet">
    @endif
@endsection
@section('content')

<div class="tabs2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="breadcrumbs-block" itemtype="" itemscope="">
                        <div id="routeCat"class="breadcrumb hidden-xs" itemprop="breadcrumb">
                            <span class="pr-1">Categorias:  </span>  
                            @foreach ($categories as $category)
                                <a class="" href="/products/{{ str_replace(" ", "-",$category->gfName) }}/{{str_replace(" ", "-",$category->fName)}}/{{str_replace(" ", "-",$category->catName)}}_{{$category->catId}}"> {{ $category->catName }} |
                            @endforeach
                            {{-- Home | {{ $gfather }} | {{ $father }} |  <a class="" href="/products/{{ str_replace(" ", "-",$gfather) }}/{{str_replace(" ", "-",$father)}}/{{str_replace(" ", "-",$son)}}_{{$subcat_id}}">{{ $son }} </a> --}}
                        </div>
                    </div>
                </div>
            </div> 
            <div class="tabs col-md-12">
                <div class="row">
                    {{-- small images --}}
                    <div id="one_details" class="col-12 col-xl-1 xzoom-thumbs">
                        <ul class="nav nav-pills nav-stacked column-flex">
                        <li class="active card-rounded">
                            <a href="#tab_a" data-toggle="pill">
                                <img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" class="img-tam xzoom-gallery_" alt="" xpreview="../{{ $prod_info->img1 }}">
                            </a>
                        </li>
                        @for ($i = 0; $i <= count($images); $i++)
                            @if (!empty($images[$i]))
                                <li class="card-rounded"><a href="#tab_{{$i}}" data-toggle="pill"><img src="{{ env('AWS_URL') }}/{{ $images[$i] }}" class="img-tam xzoom-gallery_{{$i}}" alt="" xpreview="../{{ $images[$i] }}"></a></li>
                            @endif
                            
                        @endfor

                            {{-- <li><a href="#tab_b"  data-toggle="pill"><img src="../{{ $prod_info->img2 }}" class="img-tam" alt=""></a></li> --}}
                        </ul>
                    </div>

                    {{-- big images --}}
                    <div id="two_details" class="col-12 col-xl-5 text-center">
                        <div class="row tab-content" id="father">
                            <div class="tab-pane active bg-white" id="tab_a">
                                <img id="xzoom-default" src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" class="img-tam2 xzoom card-rounded" xoriginal="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" alt="">
                            </div>
                            @for ($i = 0; $i <= count($images); $i++)
                                @if (!empty($images[$i]))
                                    <div class="tab-pane" id="tab_{{$i}}">
                                        <img id="thumb_{{$i}}" src="{{ env('AWS_URL') }}/{{ $images[$i] }}" class="img-tam2 xzoom_{{$i}} detail-xzoom card-rounded" xoriginal="{{ env('AWS_URL') }}/{{ $images[$i] }}" alt="">
                                    </div>
                                @endif
                            @endfor
                            
                            <div class="comentario" id="comentario"></div>
                        </div>
                    </div>
                    
                    <div id="three_details" class="col-12 col-xl-6">
                        <div>
                            {{-- <form action="{{ route('generateimg') }}" method="POST" name="formaut" id="formRegisterwithdrawal">
                                @csrf --}}
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="">
                                                <div class="info-small font-black">{{ $prod_info->brand }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="">
                                                <h2 class="text-leemon-color">{{ $prod_info->name }}</h2>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr class="mb-4">
                                </div>
                                <div class="col-md-12">
                                    {{-- <p>
                                        @if ($prod_info->prom == 1) 
                                        <h2><span class="badge badge-warning">Paga 2 Lleva 3</span></h2><br>
                                        @elseif ($prod_info->prom == 2)
                                        <h2> <span class="badge badge-success">2nd 50% off</span></h2><br>
                                        @endif
                                    </p> --}}
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div>
                                                <div class="price-color">Referencia:</div> 
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div>
                                                {{ $prod_info->reference }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div>
                                                <div class="price-color">Precio:</div> 
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div>
                                                Ahora $ {{ number_format($prod_info->price, 0) }} COP
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mb-4">
                                    {{-- <span class="price-color">Costo de Envio:</span><br> $ {{ number_format($prod_info->delivery_cost, 0) }} COP<br>
                                    <hr class="mb-4"> --}}
                                </div>
                                
                                <div class="col-md-12" data-th="Quantity">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-1">
                                            <div>
                                                <div class="price-color">Cantidad: </div>
                                            </div>
                                        </div>
                                        
                                        @if (isset(session('cart')[$prod_info->id])) 
                                            @if (($prod_info->webquantity - session('cart')[$prod_info->id]["quantity"]) > 0)
                                                <div class="qua col-md-3 mb-3">
                                                    <span id="cant">
                                                        <input class="quantity" type="number" min="1" max="{{$prod_info->webquantity - session('cart')[$prod_info->id]["quantity"] }}" step="1" value="1" readonly>
                                                    </span>
                                                </div>
                                            @else
                                                <div class="col-md-12 mb-3">
                                                    No Disponible, pero no te preocupes LEEMON te notificará cuando el producto se encuentre disponible.
                                                </div> 
                                            @endif

                                        @else
                                            @if ($prod_info->webquantity > 0)
                                                <div class="qua col-xl-3 mb-3">
                                                    <span id="cant">
                                                        <input class="quantity" type="number" min="1" max="{{ $prod_info->webquantity }}" step="1" value="1" readonly>
                                                    </span>
                                                </div>
                                            @else

                                            @endif
                                        @endif
                                            
                                        <div id="nodis"  class="col-md-12">
                                            No Disponible, pero no te preocupes LEEMON te notificará cuando el producto se encuentre disponible
                                        </div>
                                            
                                            
                                        
                                            {{-- <select class="form-control quantity" name="" id="">
                                                @for ($i = 1; $i <= $prod_info->webquantity; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select> --}}
                                            {{-- <input type="number" value="" class="form-control quantity" /> --}}
                                    </div>
                                    
                                </div>
                                
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        @if (isset(session('cart')[$prod_info->id])) 
                                            @if (($prod_info->webquantity - session('cart')[$prod_info->id]["quantity"]) > 0)
                                            
                                                <div id="nodis-button" class="col-xl-auto">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button id="" class="btn btn-leemon-pink update-cart btn-width" data-cart="1" data-id="{{ $prod_id }}" data-dif="{{ $prod_info->webquantity - session('cart')[$prod_info->id]["quantity"] }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            @endif
                                        @else
                                            @if ($prod_info->webquantity > 0)
                                                <div id="nodis-button" class="col-xl-auto">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button id="" class="btn btn-leemon-pink update-cart mr-1 btn-width" data-cart="1"  data-id="{{ $prod_id }}" data-dif="{{ $prod_info->webquantity }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Agregar al Carrito</button>
                                                        </div>  
                                                    </div>
                                                
                                                </div>
                                            
                                            @else
                                            <div class="col-md-12 mb-3">
                                                No Disponible, pero no te preocupes LEEMON te notificará cuando el producto se encuentre disponible.
                                            </div> 
                                            @endif
                                        @endif  

                                        @guest
                                                
                                        @else
                                            <div class="col-xl-auto">
                                                <div class="row">
                                                    <button id="" class="btn btn-wishlist update-wishlist btn-leemon-radius mr-1"  data-id="{{ $prod_id }}" data-dif="{{ $prod_info->webquantity }}"><i class="fa fa-heart" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-xl-auto">
                                                <div class="row">
                                                    
                                                    <div class="btn-group dropdown">
                                                        <button id="" class="btn btn-upload share-with btn-leemon-radius mr-1"  data-id="{{ $prod_id }}" data-dif="{{ $prod_info->webquantity }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="/img/upload_1.png" alt="" style="width: 14px"></button>
                                                        <div class="dropdown-menu dropdown-menu-position-upload dropdown-upload">
                                                            <div class="">
                                                                <div class="input-group mt-2 mb-1">
                                                                    <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-link" aria-hidden="true"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control form-control-sm mr-1" value="{{Request::url()}}" aria-label="Username" aria-describedby="basic-addon1" readonly>
                                                                    <button id="copylink" class="btn btn-dark btn-sm"><i class="fa fa-files-o" aria-hidden="true"></i> Copiar </button>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown-divider"></div>
                                                            <div class="">
                                                                <div class="input-group mb-2">
                                                                    <a id="linkWeb" data-id="{{ $prod_id }}" href="https://web.whatsapp.com/send?text=Visita%20el%20blog%20de%20Parzibyte%20en%20{{Request::url()}}" target="_blank" class="mr-1">
                                                                        <img src="/img/whatsappIcon.png" width="35px" alt="">
                                                                    </a>
                                                                    <a id="linkApp" data-id="{{ $prod_id }}" href="https://api.whatsapp.com/send?text=Visita%20el%20blog%20de%20Parzibyte%20en%20{{Request::url()}}" target="_blank"  class="mr-1">
                                                                        <img src="/img/whatsappIcon.png" width="35px" alt="">
                                                                    </a>
                                                                    <button id="openbox" class="btn btn-dark"  data-id="{{ $prod_id }}"><i class="fa fa-envelope" aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                            
                                                            <div id="sendemailbox" style="display: none">
                                                                <div class="input-group mb-2">
                                                                    {{-- <div id="loading_sendtofriend">
                                                                        <img src="/img/preloader.gif" id="img_loading" alt="">
                                                                    </div> --}}
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-at" aria-hidden="true"></i></span>
                                                                    </div>
                                                                    
                                                                    <input id="email" name="email" type="email" class="form-control form-control-sm" placeholder="email de tu amigo" aria-label="email" aria-describedby="basic-addon1" required>
                                                                    <div class="input-group-append">
                                                                        <button id="sendEmail" class="btn btn-dark btn-sm" type="button">Enviar</button>
                                                                    </div>
                                                                </div>
                                                            
                                                    
                                                            </div>
                                                            
                                                        </div>
                                                        </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-auto">
                                                <div class="row">
                                                    
                                                </div>
                                            </div>
                                        @endguest
                                    </div>
                                </div>
                                
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                
            </div>
            {{-- pc resolution --}}
            <div id="tabs3" class="tabs3 col-md-12">
                <hr class="mb-4">
                <h3 class="h3color">Sobre este Articulo<br> <small>(Información suministrada por el Proveedor)</small></h3> <br>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="desc-tab" data-toggle="tab" href="#desc" role="tab" aria-controls="desc" aria-selected="true">Descripción</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="cara-tab" data-toggle="tab" href="#cara" role="tab" aria-controls="cara" aria-selected="false">Características</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="ingr-tab" data-toggle="tab" href="#ingr" role="tab" aria-controls="ingr" aria-selected="false">Ingredientes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="indi-tab" data-toggle="tab" href="#indi" role="tab" aria-controls="indi" aria-selected="false">Indicaciones de uso</a>
                      </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                        <p class="text-justify">
                            {{ $prod_info->description }}
                        </p>
                    </div>
                    <div class="tab-pane fade" id="cara" role="tabpanel" aria-labelledby="cara-tab">
                        <p class="text-justify">
                            {{ $prod_info->characteristics }}
                        </p>
                    </div>
                    <div class="tab-pane fade" id="ingr" role="tabpanel" aria-labelledby="ingr-tab">
                        <p class="text-justify">
                            {{ $prod_info->ingredients }}
                        </p>
                    </div>
                    <div class="tab-pane fade" id="indi" role="tabpanel" aria-labelledby="indi-tab">
                        <p class="text-justify">
                            {{ $prod_info->use }}
                        </p>
                    </div>
                </div>
            </div>
            {{-- mobil resolution --}}
            
            <div id="mobilinfo" class="col-md-12">
                <div class="col-12 col-md-12">
                    <div class="row">
                        <hr class="mb-4">
                        <h3 class="h3color">Sobre este Articulo<br> <small>(Información suministrada por el Proveedor)</small></h3>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="row" style="width: 100%">
                        <div class="accordion accord-width" id="accordionExample">
                            <div class="card col-md-12 col-12">
                                <a class="text-left a-size-methods" type="" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="width: 100%">
                                    <div class="card-header row" id="headingOne"><div class="col-6 col-md-6 font-black text-leemon-color"><div class="row">Descripción</div></div><div class="col-6 col-md-6"><div class="row float-right">Ver Más</div></div></div>
                                </a>
                                <div class="row">
                                    <div id="collapseOne" class="col-md-12 collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="row">
                                            <div class="card-body card-body-yellow card-round-footer">
                                                
                                                <p class="info-small">
                                                    {{ $prod_info->description }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-12">
                                <a class="text-left a-size-methods" type="" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="width: 100%">
                                    <div class="card-header row" id="headingTwo"> <div class="col-6 col-md-6 font-black text-leemon-color"><div class="row">Características</div></div><div class="col-6 col-md-6"><div class="row float-right">Ver Más</div></div> </div>
                                </a>
                                <div class="row">
                                    <div id="collapseTwo" class="col-md-12 collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                        <div class="row">
                                            <div class="card-body card-body-yellow card-round-footer">
                                                
                                                <p class="info-small">
                                                    {{ $prod_info->characteristics }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-12">
                                <a class="text-left a-size-methods" type="" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" style="width: 100%">
                                    <div class="card-header row" id="headingThree"><div class="col-6 col-md-6 font-black text-leemon-color"><div class="row">Ingredientes</div></div><div class="col-6 col-md-6"><div class="row float-right">Ver Más</div></div></div>
                                </a>
                                <div class="row">
                                    <div id="collapseThree" class="col-md-12 collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                        <div class="row">
                                            <div class="card-body card-body-yellow card-round-footer">
                                                
                                                <p class="info-small">
                                                    {{ $prod_info->ingredients }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-12">
                                <a class="text-left a-size-methods" type="" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour" style="width: 100%">
                                    <div class="card-header row" id="headingFour"><div class="col-6 col-md-6 font-black text-leemon-color"><div class="row">Indicaciones de uso</div></div><div class="col-6 col-md-6"><div class="row float-right">Ver Más</div></div></div>
                                </a>
                                <div class="row">
                                    <div id="collapseFour" class="col-md-12 collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                        <div class="row">
                                            <div class="card-body card-body-yellow card-round-footer">
                                                <p class="info-small">
                                                    {{ $prod_info->use }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  --}}
        </div>
    </div><br>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <hr class="mb-4">
            <h3 class="h3color">Te podria Interesar</h3><br>
          </div>
        </div>
        <div class="owl-carousel owl-theme owl-loaded owl-drag">
          <div class="owl-stage-outer">
            <div class="owl-stage" style="transform: translate3d(-1386px, 0px, 0px); transition: all 0.25s ease 0s; width: 2376px;">
              @foreach ($similars as $similar)
              <div class="owl-item" style="width: 200px; margin-right: 10px;">
                <div class="item">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="rom">
                        <div class="card mb-4  bg-leemon-pro card-rounded">
                            <a href="/product/{{$similar->proId}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $similar->reference }}/{{$similar->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt=""></a>
                            <div class="card-body text-center">
                                <span class="brand-font">{{ucwords($similar->brand)}} </span>
                                <div style="height: 60px"><h6>{{ucwords($similar->proName)}} </h6></div>
                                <h6>
                                    @if ($similar->prom == 1) 
                                        <span class="badge badge-warning">Paga 2 Lleva 3</span>
                                    @elseif ($similar->prom == 2)
                                        <span class="badge badge-success">2nd 50% off</span>
                                    @endif
                                </h6> 
                                <span class="brand-font2"><b>$ {{number_format($similar->price, 0)}} COP </b></span><br><br>
                                                 
                                    {{-- <button id="" class="btn btn-sm btn-leemon-pink update-cart" data-cart="2"  data-id="{{ $similar->proId }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Agregar al Carrito</button> --}}

                                @if (isset(session('cart')[$similar->proId])) 
                                    @if (($similar->webquantity - session('cart')[$similar->proId]["quantity"]) > 0)
                                        <div id="nodis-button" class="col-xl-auto">
                                        <div class="row">
                                            <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block" data-cart="2" data-id="{{ $similar->proId }}" data-dif="{{ $similar->webquantity - session('cart')[$similar->proId]["quantity"] }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                        </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <div class="row">
                                            @guest
                                                <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $similar->proId }}" data-t="0">Notificar Disponibilidad</button>
                                            @else
                                                <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $similar->proId }}" data-t="1">Notificar Disponibilidad</button>
                                            @endguest
                                            
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($similar->webquantity > 0)
                                        <div id="nodis-button" class="col-xl-auto">
                                        <div class="row">
                                            <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block" data-cart="2" data-id="{{ $similar->proId }}" data-dif="{{ $similar->webquantity }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                        </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <div class="row">
                                                @guest
                                                    <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $similar->proId }}" data-t="0">Notificar Disponibilidad</button>
                                                @else
                                                <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $similar->proId }}" data-t="1">Notificar Disponibilidad</button>
                                                @endguest
                                            </div>
                                        </div>
                                    @endif
                                @endif
                              
                            
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          
        </div>
    </div>
</div>
@endsection
@section('custom-js')

    @if (env('APP_ENV') == "production")
        <script src="{{ secure_asset('js/xzoom.min.js') }}" defer></script>
    @else
        <script src="{{ asset('js/xzoom.min.js') }}" defer></script>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script defer src="../js/owl.carousel.min.js"></script>

<script type="text/javascript">
    

    $(document).ready(function(){
        var max = 0;

        if ($(window).width() > 600){
            $(".xzoom, #xzoom-default").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
            $(".xzoom_0, #xzoom-default_0").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
            $(".xzoom_1, #xzoom-default_1").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
            $(".xzoom_2, #xzoom-default_2").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
            $(".xzoom_3, #xzoom-default_3").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
        }

        
        
        
         $(function() {
            var $a = $(".tabs li");
            $a.click(function() {
                $a.removeClass("active");
                $(this).addClass("active");
                //alert($(this).attr('id'));
            });
            
        });

        $(".update-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);
            var option = ele.attr("data-cart");
            var diff = ele.attr("data-dif");
        
            if (option == 1){
                var dataQuant = ele.parents("div").find(".quantity").val();
            }else{
                var dataQuant = 1;
            }
            
            
            $.ajax({
                url: "{{ url('add-to-cart-quantity')}}",
                method: "post",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: dataQuant},
                beforeSend: function(x){
                    ele.before("<div id='loadPro' class='col-12 text-center'><i class='fa fa-refresh fa-spin'></i> Agregando</div>");
                    ele.hide();
                },
                success: function (response) {
                    // window.location.reload();
                    if (response.status ==200){
                        $('#litlecart').load(location.href + " #litlecart");
                        toastr.success("Ha agregado un nuevo articulo al carrito!!", "Articulo Agregado");
                        ele.show();
                        $("#loadPro").remove();
                        //alert(diff - dataQuant);
                        if (diff - dataQuant < 1){
                            if (option == 1){
                                $("#cant").hide();
                                $("#nodis-button").hide();
                                $("#nodis").show();
                            }else{
                                ele.hide();
                                ele.before("<div class='col-md-12'>No Disponible</div>");
                            }
                        }else{
                            
                            ele.attr("data-dif", diff - dataQuant);
                            if (option == 1){
                                ele.parents("div").find(".quantity").attr('max', diff - dataQuant);
                                ele.parents("div").find(".quantity").val(1);
                            }
                        }
                    }else{
                        ele.show();
                        $("#loadPro").remove();
                        toastr.error(response.info);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                     
                }
            });
        });

        $(".update-wishlist").click(function (e) {
            
            e.preventDefault();
            var ele = $(this);

            $.ajax({
                url: "{{ url('add-to-wishlist')}}",
                method: "post",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                success: function (response) {
                    //window.location.reload();
                    toastr.success("Ha agregado un nuevo articulo a su lista deseada!!", "Articulo Agregado");
                }
            });
        });

        $('.owl-carousel').owlCarousel({
      
            loop:false,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:2,
                    nav:true,
                    navText : ['<div class="carousel-control-prev-icon"></div>','<div class="carousel-control-next-icon"></div>']
                },
                600:{
                    items:3,
                    nav:true,
                    navText : ['<div class="carousel-control-prev-icon"></div>','<div class="carousel-control-next-icon"></div>']
                },
                1000:{
                    items:5,
                    nav:true,
                    loop:false,
                    navText : ['<div class="carousel-control-prev-icon"></div>','<div class="carousel-control-next-icon"></div>']
                }
            }
        });

        $("#sendEmail").click(function(){
            if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1) {
                $("#mm").text("Ingrese un email valido!!");
                return false;
            }

            $.ajax({
                url: "{{ url('send-email-friend')}}",
                method: "post",
                data: {_token: '{{ csrf_token() }}', id: '{{ $prod_id }}', proName: '{{$prod_info->name}}', img: "{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}", email: $("#email").val()},
                beforeSend: function(x){
                    $('#loading_sendtofriend').show();
                },
                success: function (response) {
                    $('#loading_sendtofriend').hide();
                    $("#email").val('');
                    //toast('Success Toast','success');
                    Swal.fire({
                        icon: 'success',
                        title: 'Correo Enviado',
                        text: 'El email ha sido enviado al amigo deseado',
                    })
                    //swal("Buen trabajo!", data.mensaje, "success");
                    // window.location.reload();
                }
            });
            
        });

        $('<div class="qua-nav"><div class="qua-button qua-up">+</div><div class="qua-button qua-down">-</div></div>').insertAfter('.qua input');
        $('.qua').each(function() {
            var spinner = $(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.qua-up'),
            btnDown = spinner.find('.qua-down'),
            min = input.attr('min'),
            max = input.attr('max');
            
            btnUp.click(function() {
                
                var oldValue = parseFloat(input.val());
                if (oldValue >= input.attr('max')) {
                var newVal = oldValue;
                } else {
                var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

            btnDown.click(function() {
                var oldValue = parseFloat(input.val());
                if (oldValue <= input.attr('min')) {
                var newVal = oldValue;
                } else {
                var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
        });

        $("#openbox").click(function(){
            $("#sendemailbox").toggle();
        });

        $('.dropdown-menu').on('click', function (e) {
            e.stopPropagation();
        });


    });
    
</script>
@endsection