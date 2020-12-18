@extends('layouts.app')
@section('custom-css')
<link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    @if (env('APP_ENV') == "production")    
        <link href="{{ secure_asset('css/xzoom.css') }}" rel="stylesheet">
    @else 
        <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet">
    @endif
@endsection
@section('content')
<div class="tabs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="breadcrumbs-block" itemtype="" itemscope="">
                        <div id="routeCat"class="breadcrumb hidden-xs" itemprop="breadcrumb">
                            <span>Categorias: </span>  
                            @foreach ($categories as $category)
                                <a class="" href="/products/{{ str_replace(" ", "-",$category->gfName) }}/{{str_replace(" ", "-",$category->fName)}}/{{str_replace(" ", "-",$category->catName)}}_{{$category->catId}}"> {{ $category->catName }} |
                            @endforeach
                            {{-- Home | {{ $gfather }} | {{ $father }} |  <a class="" href="/products/{{ str_replace(" ", "-",$gfather) }}/{{str_replace(" ", "-",$father)}}/{{str_replace(" ", "-",$son)}}_{{$subcat_id}}">{{ $son }} </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xl-1 xzoom-thumbs">
                        <ul class="nav nav-pills nav-stacked flex-column">
                        <li class="active">
                            <a href="#tab_a" data-toggle="pill">
                                <img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" class="img-tam xzoom-gallery" alt="" xpreview="../{{ $prod_info->img1 }}">
                            </a>
                        </li>
                        @for ($i = 0; $i <= count($images); $i++)
                            @if (!empty($images[$i]))
                                <li><a href="#tab_{{$i}}" data-toggle="pill"><img src="{{ env('AWS_URL') }}/{{ $images[$i] }}" class="img-tam xzoom-gallery_{{$i}}" alt="" xpreview="../{{ $images[$i] }}"></a></li>
                            @endif
                            
                        @endfor

                            {{-- <li><a href="#tab_b"  data-toggle="pill"><img src="../{{ $prod_info->img2 }}" class="img-tam" alt=""></a></li> --}}
                        </ul>
                    </div>
                    <div class="col-xl-5">
                        <div class="tab-content" id="father">
                            <div class="tab-pane active" id="tab_a">
                                <img id="xzoom-default" src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" class="img-tam2 xzoom" xoriginal="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" alt="">
                            </div>
                            @for ($i = 0; $i <= count($images); $i++)
                                @if (!empty($images[$i]))
                                    <div class="tab-pane" id="tab_{{$i}}">
                                        <img id="thumb_{{$i}}" src="{{ env('AWS_URL') }}/{{ $images[$i] }}" class="img-tam2 xzoom_{{$i}}" xoriginal="{{ env('AWS_URL') }}/{{ $images[$i] }}" alt="">
                                    </div>
                                @endif
                            @endfor
                            
                            <div class="comentario" id="comentario"></div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6">
                        <div>
                            <form action="{{ route('generateimg') }}" method="POST" name="formaut" id="formRegisterwithdrawal">
                                @csrf
                                <div class="form-group">
                                    
                                  <h2><small class="info-small">{{ $prod_info->brand }}</small><br>{{ $prod_info->name }}</h2>
                                  <hr class="mb-4">
                                </div>
                                <div class="form-group">
                                    <p>
                                        @if ($prod_info->prom == 1) 
                                        <h2><span class="badge badge-warning">Paga 2 Lleva 3</span></h2><br>
                                        @elseif ($prod_info->prom == 2)
                                        <h2> <span class="badge badge-success">2nd 50% off</span></h2><br>
                                        @endif
                                    </p>
                                    
                                    <p>
                                        <span class="price-color">Referencia:</span> <br>{{ $prod_info->reference }}
                                    </p>
                                    
                                   
                                    <p>
                                        <span class="price-color">Precio: </span><br>
                                        <span class="price text-danger">Ahora $ {{ number_format($prod_info->price, 0) }} COP</span>
                                    </p>
                                    <hr class="mb-4">
                                    {{-- <span class="price-color">Costo de Envio:</span><br> $ {{ number_format($prod_info->delivery_cost, 0) }} COP<br>
                                    <hr class="mb-4"> --}}
                                </div>
                                <div class="form-group">
                                    <div class="col-xl-2" data-th="Quantity">
                                        <div class="row">
                                            Cantidad:
                                            <select class="form-control quantity" name="" id="">
                                                @for ($i = 1; $i <= $prod_info->stockquantity; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        {{-- <input type="number" value="" class="form-control quantity" /> --}}
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <button id="" class="btn btn-purchase btn-block update-cart"  data-id="{{ $prod_id }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Agregar al Carrito</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                <div class="row">
                                                    @guest
                                                    @else
                                                    <button id="" class="btn btn-wishlist btn-block update-wishlist"  data-id="{{ $prod_id }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Agregar a Lista Deseada</button>
                                                    @endguest
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    @guest
                                    @else
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="alert alert-email" role="alert" style="width: 100%">
                                                    <h6 class="alert-heading">Enviaselo a un Amigo!</h6>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">@</span>
                                                        </div>
                                                        <input id="email" name="email" type="email" class="form-control" placeholder="email de tu amigo" aria-label="email" aria-describedby="basic-addon1" required>
                                                        <div class="input-group-append">
                                                            <button id="sendEmail" class="btn btn-dark" type="button">Enviar articulo</button>
                                                        </div>
                                                    </div>
                                                    <div id="mm"></div>

                                                </div>
                                            </div>
                                        </div>
                                    @endguest
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr class="mb-4">
                <p>
                    <span class="price-color">Sobre este Articulo</span> <br> <span class="text-justify">{{ $prod_info->description }}</span> 
                </p>
            </div>
            
        </div>
    </div>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <hr class="mb-4">
            <h3>Te podria Interesar</h3>
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
                        <div class="card mb-4 shadow-sm">
                          <a href="/product/{{$similar->proId}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $similar->reference }}/{{$similar->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt=""></a>
                          <div class="card-body text-center">
                            <span class="brand-font">{{ucwords($similar->brand)}} </span>
                            <h6>{{ucwords($similar->proName)}} </h6>
                            <h6>
                              @if ($similar->prom == 1) 
                              <span class="badge badge-warning">Paga 2 Lleva 3</span>
                            @elseif ($similar->prom == 2)
                              <span class="badge badge-success">2nd 50% off</span>
                            @endif
                          </h6> 
                          <span class="brand-font2"><b>$ {{number_format($similar->price, 0)}} COP</b></span><br><br>
                                                 <!-- <a href="/product/{{$similar->proId}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                               <a href="{{ url('add-to-cart/'.$similar->proId) }}"> <button type="button" class="btn btn-sm btn-leemon-green"><i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito</button></a>
                            
                              
                            
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
        $(".xzoom, #xzoom-default").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
        $(".xzoom_0, #xzoom-default_0").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
        $(".xzoom_1, #xzoom-default_1").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
        $(".xzoom_2, #xzoom-default_2").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
        $(".xzoom_3, #xzoom-default_3").xzoom({tint: '#333', Xoffset: 15, position: 'right' });
        
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

            $.ajax({
                url: "{{ url('add-to-cart-quantity')}}",
                method: "post",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("div").find(".quantity").val()},
                success: function (response) {
                    window.location.reload();
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
                    window.location.reload();
                }
            });
        });

        $('.owl-carousel').owlCarousel({
      
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:true,
                    loop:false
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
                success: function (response) {
                    // window.location.reload();
                }
            });
            
        });
    });
</script>
@endsection