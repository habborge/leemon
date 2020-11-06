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
            <div class="col-xl-2 xzoom-thumbs">
                <ul class="nav nav-pills nav-stacked flex-column">
                <li class="active"><a href="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" data-toggle="pill"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" class="img-tam xzoom-gallery" alt="" xpreview="../{{ $prod_info->img1 }}"></a></li>
                    <li><a href="#tab_b"  data-toggle="pill"><img src="../{{ $prod_info->img2 }}" class="img-tam" alt=""></a></li>
                </ul>
            </div>
            <div class="col-xl-4">
                <div class="tab-content" id="father">
                    <div class="tab-pane active" id="tab_a">
                        <img id="xzoom-default" src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" class="img-tam2 img-thumbnail xzoom" xoriginal="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $prod_info->reference }}/{{ $prod_info->img1 }}" alt="">
                    </div>
                    <div class="tab-pane" id="tab_b">
                        <img id="thumb2" src="../{{ $prod_info->img2 }}" class="img-tam2 img-thumbnail" alt="">
                    </div>
                    <div class="comentario" id="comentario"></div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div>
                    <form action="{{ route('generateimg') }}" method="POST" name="formaut" id="formRegisterwithdrawal">
                        @csrf
                        <div class="form-group">
                          <h2>{{ $prod_info->name }}</h2>
                          <hr class="mb-4">
                        </div>
                        <div class="form-group">
                            @if ($prod_info->prom == 1) 
                                <span class="badge badge-warning">Paga 2 Lleva 3</span><br>
                            @elseif ($prod_info->prom == 2)
                                <span class="badge badge-success">2nd 50% off</span><br>
                            @endif
                            <span class="price-color">Marca:</span> {{ $prod_info->brand }}<br>
                            <span class="price-color">Referencia:</span> {{ $prod_info->reference }}
                            <p><span class="price-color">Descripción</span> <br> <span class="text-justify">{{ $prod_info->description }}</span> </p>
                            <p>
                                <span class="price-color">Precio: </span><span class="price text-danger">$ {{ number_format($prod_info->price, 0) }} COP</span>
                            </p>
                            <span class="price-color">Costo de Envio:</span> $ {{ number_format($prod_info->delivery_cost, 0) }} COP<br>
                        </div>
                        <div class="col-xl-4" data-th="Quantity">
                            Cantidad:
                            <input type="number" value="1" class="form-control quantity" />
                        </div>

                        <button id="" class="btn btn-primary btn-block update-cart"  data-id="{{ $prod_id }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Agregar al Carrito</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Tambien Querras Comprar</h3>
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
                          <a href="/product/{{$similar->id}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $similar->reference }}/{{$similar->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt=""></a>
                          <div class="card-body text-center">
                            
                            
                            <span class="brand-font">{{ucwords($similar->brand)}} </span>
                            <h6>{{ucwords($similar->name)}} </h6>
                
                            
                            <h6>
                              @if ($similar->prom == 1) 
                              <span class="badge badge-warning">Paga 2 Lleva 3</span>
                            @elseif ($similar->prom == 2)
                              <span class="badge badge-success">2nd 50% off</span>
                            @endif
                          </h6> 
                          <span class="brand-font2"><b>$ {{number_format($similar->price, 0)}} COP</b></span><br><br>
                                                 <!-- <a href="/product/{{$similar->id}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                               <a href="{{ url('add-to-cart/'.$similar->id) }}"> <button type="button" class="btn btn-sm btn-leemon-green"><i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito</button></a>
                            
                              
                            
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
        $(".xzoom").xzoom({
            tint: '#333', 
            Xoffset: 15,
            position: 'right',
         
        });

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
    });
</script>
@endsection