@extends('layouts.app')
@section('custom-css')
  <!-- Bootstrap core CSS -->
 
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
@endsection
@section('content')

  <main role="main">
    <div>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          {{-- <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> --}}
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="img/promo.jpg" class="img-fluid d-block w-100" alt="...">
          </div>
          {{-- <div class="carousel-item">
            <img src="img/promo_1B.jpg" class="img-fluid d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="img/promo2.jpg" class="img-fluid d-block w-100" alt="...">
          </div> --}}
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      {{-- close slide --}}
    

      {{-- MAIN CATEGORIES --}}
      <div class="album py-5 ">
        <div class="container">
            <div class="row">
              <div class="aline-title col-md-12">
                <h3 class="aline-span">{{ $catTitle }}</h3>
              </div>
              <div class="col-md-12">
                <div class="row">
                    @foreach ($cat_pri as $category)
                    
                      <div class="col-6 col-md-4 category_style">
                        <a href="/categories/{{ str_replace(" ", "-",$category->name) }}/{{ $category->id }}">
                          <picture>
                            <source type="image/webp"  srcset="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/categories/cat_{{ $category->id }}.webp">
                            <img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/categories/cat_{{ $category->id }}.jpg" class="card-img-top card-rounded mx-auto d-block" alt="">
                          </picture>
                       
                        <div class = "carousel-caption" >
                          <h5 style="text-shadow: 2px 2px #202020;"> {{$category->name}}</h5>
                          </div>
                        </a>
                    </div>
                    
                      
                    @endforeach
                  </div>
                
              </div>
            </div>
        </div>
      </div>
      {{-- end product of the month --}}
      {{-- product list --}}
<div class="album py-5 ">
  <div class="container">
    <div class="row">
      <div class="aline-title col-md-12">
        <h3 class="aline-span">{{ $prom_1 }}</h3>
      </div>
    </div>
    <div class="owl-carousel owl-theme owl-loaded owl-drag">
      <div class="owl-stage-outer">
        <div class="owl-stage" style="transform: translate3d(-1386px, 0px, 0px); transition: all 0.25s ease 0s; width: 2376px;">
          @foreach ($products_1 as $product)
            <div class="owl-item" style="width: 200px; margin-right: 10px;">
              <div class="item">
                <div class="row">
                  <div class="col-md-12">
                    <div class="rom">
                      <div class="card mb-4 bg-leemon-pro card-rounded">
                        <a href="/product/{{$product->id}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product->reference }}/{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt=""></a>
                        <div class="card-body text-center">
                          <span class="brand-font">{{ucwords($product->brand)}} </span>
                          <div style="height: 60px"><h6>{{ucwords($product->name)}} </h6></div>
                          <h6>
                            @if ($product->prom == 1) 
                              <span class="badge badge-warning">Paga 2 Lleva 3</span>
                            @elseif ($product->prom == 2)
                              <span class="badge badge-success">2nd 50% off</span>
                            @endif
                          </h6> 
                          <span class="brand-font2"><b>$ {{number_format($product->price, 0)}} COP</b></span><br><br>
                          <!-- <a href="/product/{{$product->id}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                          {{-- <a href="{{ url('add-to-cart/'.$product->id) }}">
                            <button type="button" class="btn btn-sm btn-leemon-green">
                              <i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito
                            </button>
                          </a> --}}
                          @if (isset(session('cart')[$product->id])) 
                            @if (($product->webquantity - session('cart')[$product->id]["quantity"]) > 0)
                              <div id="nodis-button" class="col-xl-auto">
                                <div class="row">
                                  <button id="" class="btn btn-sm btn-leemon-green update-cart btn-block"  data-id="{{ $product->id }}" data-dif="{{ $product->webquantity - session('cart')[$product->id]["quantity"] }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                </div>
                              </div>
                            @else
                              <div class="col-md-12">
                                  No Disponible
                              </div>
                            @endif
                          @else
                            <div id="nodis-button" class="col-xl-auto">
                              <div class="row">
                                <button id="" class="btn btn-sm btn-leemon-green update-cart btn-block"  data-id="{{ $product->id }}" data-dif="{{ $product->webquantity }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
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
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @if (count($products_1))
    <div class="d-flex justify-content-center">
        {{-- {{ $products -> links() }} --}}
    </div>
  @endif
</div>
    {{-- <div class="album py-5 ">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>{{ $prom_2 }}</h3>
          </div>  
        </div>
        <div class="owl-carousel owl-theme owl-loaded owl-drag">
          <div class="owl-stage-outer">
            <div class="owl-stage" style="transform: translate3d(-1386px, 0px, 0px); transition: all 0.25s ease 0s; width: 2376px;">
              @foreach ($products_2 as $product2)
                <div class="owl-item" style="width: 200px; margin-right: 10px;">
                  <div class="item">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="rom">
                          <div class="card mb-4 shadow-sm">
                            <a href="/product/{{$product2->id}}">
                              <img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product2->reference }}/{{$product2->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt="">
                            </a>
                            <div class="card-body text-center">
                              <span class="brand-font">{{ucwords($product2->brand)}} </span>
                              <h6>{{ucwords($product2->name)}} </h6>
                              <h6>
                                @if ($product2->prom == 1) 
                                  <span class="badge badge-warning">Paga 2 Lleva 3</span>
                                @elseif ($product2->prom == 2)
                                  <span class="badge badge-success">2nd 50% off</span>
                                @endif
                              </h6> 
                              <span class="brand-font2"><b>$ {{number_format($product2->price, 0)}} COP</b></span><br><br>
                              <!-- <a href="/product/{{$product2->id}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                              <a href="{{ url('add-to-cart/'.$product2->id) }}"> <button type="button" class="btn btn-sm btn-leemon-green"><i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito</button></a>
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
    </div> --}}
    <div class="album py-5 ">
      <div class="container">
          <div class="row">
            <div class="col-md-12">
              
                <img src="/img/BANNER-COMBO-MOD.jpg" width="100%" class="card-rounded" alt="">
              
            </div>
          </div>
      </div>
    </div>
    <div class="album py-5 ">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
                <div class="row">
                  
                  <div class="card no-line-left line-right">
                    <div class="card-body">
                      <div class="col-md-12">
                        <h5 class="card-title text-left">PROMOCION DE PRODUCTO ESCOGIDO 1<br>
                          <small>Descripcion de promocion del producto</small>
                        </h5>
                        <br>
                      </div>
                      <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-7">
                              <div class="col-md-12">
                                <div class="row">
                                  <p class="card-text">
                                    Some quick example text to build on the card title and make up the bulk of the card's content.
                                  </p>
                                </div>
                              </div>
                              <div class="col-md-12 button-topline">
                                <div class="row">
                                  <a href="{{ url('add-to-cart/') }}">
                                    <button type="button" class="btn btn-leemon-green">
                                      <i class="czi-cart font-size-sm mr-1"></i>Comprar Ahora
                                    </button>
                                  </a>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-5 text-right">
                              <img src="/img/Garlic(1).png" class="img-responsive" width="120">
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                
                </div>
          </div>
          <div class="col-md-6">
                <div class="row">
                  <div class="card no-line-right line-left">
                    <div class="card-body">
                      <div class="col-md-12">
                        <h5 class="card-title text-left">PROMOCION DE PRODUCTO ESCOGIDO 2<br>
                          <small>Descripcion de promocion del producto</small>
                        </h5>
                        <br>
                      </div>
                      <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-7">
                              <div class="col-md-12">
                                <div class="row">
                                  <p class="card-text">
                                    Some quick example text to build on the card title and make up the bulk of the card's content.
                                  </p>
                                </div>
                              </div>
                              <div class="col-md-12 button-topline">
                                <div class="row">
                                  <a href="{{ url('add-to-cart/') }}">
                                    <button type="button" class="btn btn-leemon-green">
                                      <i class="czi-cart font-size-sm mr-1"></i>Comprar Ahora
                                    </button>
                                  </a>
                                </div>
                              </div>
                              
                              
                            </div>
                            <div class="col-md-5 text-right">
                              <img src="/img/Garlic(1).png" class="img-responsive" width="120">
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </div>
      </div>
    </div>
    
    {{-- <div class="album py-5 ">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <img class="card-img-top" src="/img/chicken-curry.jpg" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title text-center">Titulo de noticia de interes</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <img class="card-img-top" src="/img/flat-lay-vegetables-circular-frame.jpg" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title text-center">Titulo de noticia de interes</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
    
  </div>
  {{-- images in slide --}}  
  </main>


@endsection
@section('custom-js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script defer src="js/owl.carousel.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '.dropdown-menu-mega', function (e) {
      e.stopPropagation();
    });

    $('.owl-carousel').owlCarousel({
      
      loop:true,
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
              nav:false,
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
    $(".update-cart").click(function (e) {
      e.preventDefault();

      var ele = $(this);
      var diff = ele.attr("data-dif");

      $.ajax({
          url: "{{ url('add-to-cart-quantity')}}",
          method: "post",
          data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: 1},
          beforeSend: function(x){
            ele.before("<div id='loadPro' class='col-12 text-center'><i class='fa fa-refresh fa-spin'></i> Agregando</div>");
            ele.hide();
          },
          success: function (response) {
            // window.location.reload();
            
            $('#litlecart').load(location.href + " #litlecart");
            toastr.success("Ha agregado un nuevo articulo al carrito!!", "Articulo Agregado");
            ele.show();
            $("#loadPro").remove();
            if (diff - 1 < 1){
              ele.hide();
              ele.before("<div class='col-md-12'>No Disponible</div>");
            }else{
              ele.attr("data-dif", diff -1 );
            }
          }
      });
    });
    
  });
  $(window).load()
</script>
@endsection