@extends('layouts.app')

@section('content')
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Leemon e-commerce</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/4.5/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/4.5/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/4.5/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
    <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon.ico">
    <meta name="msapplication-config" content="/docs/4.5/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">


    <!-- Custom styles for this template 
    <link href="album.css" rel="stylesheet">-->
  </head>
  @section('custom-css')
    <style type="text/css">
      
      
    </style>
  @endsection
  <body>
  <main role="main">
    {{-- images in slide --}}
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/promo.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/promo2.jpg" class="d-block w-100" alt="...">
        </div>
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
    {{-- product list --}}
    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>{{ $prom_1 }}</h3>
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
                          <div class="card mb-4 shadow-sm">
                            <a href="/product/{{$product->id}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product->reference }}/{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt=""></a>
                            <div class="card-body text-center">
                              <span class="brand-font">{{ucwords($product->brand)}} </span>
                              <h6>{{ucwords($product->name)}} </h6>
                              <h6>
                                @if ($product->prom == 1) 
                                  <span class="badge badge-warning">Paga 2 Lleva 3</span>
                                @elseif ($product->prom == 2)
                                  <span class="badge badge-success">2nd 50% off</span>
                                @endif
                              </h6> 
                              <span class="brand-font2"><b>$ {{number_format($product->price, 0)}} COP</b></span><br><br>
                              <!-- <a href="/product/{{$product->id}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                              <a href="{{ url('add-to-cart/'.$product->id) }}">
                                <button type="button" class="btn btn-sm btn-leemon-green">
                                  <i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito
                                </button>
                              </a>
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

    {{-- product of the month --}}
    <div class="album py-5 bg-light">
      <div class="container">
          <div class="row">
            <div class="col-md-12">
              
                <img src="/img/promo3.jpg" width="100%" class="rounded" alt="">
              
            </div>
          </div>
      </div>
    </div>
    {{-- end product of the month --}}

    {{-- <div class="album py-5 bg-light">
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
    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              
              <div class="card-body">
                <div class="col-md-12">
                  <h5 class="card-title text-left">PROMOCION DE PRODUCTO ESCOGIDO 1</h5>
                </div>
                <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-7">
                        
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        
                    </div>
                    <div class="col-md-5 text-center">
                      <img src="/img/Garlic(1).png" class="img-responsive" width="120">
                    </div>
                    </div>
                </div>
                
                
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              
              <div class="card-body">
                <h5 class="card-title text-left">PROMOCION DE PRODUCTO ESCOGIDO 2</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="album py-5 bg-light">
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
    </div>
    <div class="album py-5 bg-light">
      <div class="container">
          <div class="row">
            <div class="col-md-12">
              
                <img src="/img/50off.jpg" width="100%" class="rounded" alt="">
              
            </div>
          </div>
      </div>
    </div>
    
  </main>



</body>
</html>
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
    
  });
  $(window).load()
</script>
@endsection