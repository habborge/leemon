@extends('layouts.app')

@section('content')
  <div id="main" role="main" class="clearfix">    
    <div class="container  no-padding-sm-xs">
      <div class="breadcrumbs-block" itemtype="" itemscope="">
        <div id="routeCat"class="breadcrumb hidden-xs" itemprop="breadcrumb">
            Home
        </div>
    </div>
      <div id="primary" class="primary-content col-md-9 col-sm-12 col-xs-12 pull-right no-padding-md no-padding-lg no-padding-sm-xs">
        <div class="container">
          <div class="row">
                <div class="col-md-12">
                    <h3>Resultado de la busqueda</h3>
                </div>
                <div class="col-md-12">
                  <div class="row">
                    @foreach ($pro as $product)
                      <div class="col-md-3">
                        <div class="row">
                          <div class="card mb-4  shadow-global bg-leemon-pro card-rounded">
                            <a href="/product/{{$product->id}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product->reference }}/{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product2" alt=""></a>
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
                              <div class="mb-4"><h6>$ {{number_format($product->price, 0)}} COP</h6></div>
                                                  <!-- <a href="/product/{{$product->id}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                              {{-- <a href="{{ url('add-to-cart/'.$product->id) }}">
                                <button type="button" class="btn btn-sm btn-leemon-pink">
                                  <i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito
                                </button>
                              </a> --}}
                              @if (isset(session('cart')[$product->id])) 
                                @if (($product->quantity - session('cart')[$product->id]["quantity"]) > 0)
                                  <div id="nodis-button" class="col-xl-auto">
                                    <div class="row">
                                      <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block"  data-id="{{ $product->id }}" data-dif="{{ $product->quantity - session('cart')[$product->id]["quantity"] }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                    </div>
                                  </div>
                                @else
                                  <div class="col-md-12">
                                      No Disponible
                                  </div>
                                @endif
                              @else
                                  @if ($product->quantity >0)
                                    <div id="nodis-button" class="col-xl-auto">
                                      <div class="row">
                                        <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block"  data-id="{{ $product->id }}" data-dif="{{ $product->quantity }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                      </div>
                                    </div>
                                  @else
                                    <div class="col-md-12">
                                      No Disponible
                                    </div>
                                  @endif
                              @endif 
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
      <div id="secondary" class="refinements col-md-3 pull-left no-padding-md no-padding-lg hidden-xs hidden-sm">
        <hr> Filtrar
        <hr>
        <div class="refinement brand" data-analyticsevent="ShopByBrand">
            <h6 class="toggle active brand price-color">
            Compra por Marca
            </h6>
            <ul id="ref-price" class="refinementcontainer scrollable">
                <div class="search-filters" style="display:none">
                    <label style="display:none" for="Search by  price">
                        Search by price
                    </label>
                    <input type="text" id="Search by  price" placeholder="Search by  price" class="txtRefinement" data-list="price">
                </div>
                @if (count($brands) > 0)
                  @foreach ($brands as $brand) 
                    <li class="">
                      @if ($brand->brand != $brandname)
                          <a class="refinementlink add brand-size" href="/result/brand/{{ mb_strtolower(str_replace(" ", "-", $brand->brand))}}/{{ mb_strtolower(str_replace(" ", "-", $search))}}" title="Futurebiotics">
                      @else
                          <span class="brand-size"><b>         
                      @endif
                          <span class="square-check">
                              @if ($brand->brand == $brandname)
                                  <i class="fa fa-check-square-o" aria-hidden="true"></i>

                              @else
                                  <i class="fa fa-square-o fa-lg"></i>
                              @endif
                          </span>
                          <span class="text-ref ">
                              {{ $brand->brand}}
                              <span class="hits" style="color:#333333">({{$brand->total_brand}})</span>
                          </span>
                      @if ($brand->brand != $brandname)
                          </a>
                      @else
                      </b></span>
                      @endif
                    </li>
                  @endforeach
                @else 
                  <li class="">
                    <span class="brand-size"><b> 
                      <span class="square-check"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
                      <span class="text-ref ">
                        {{ strtoupper($search) }}
                      </span>
                      </b>
                    </span>
                  </li>
                @endif
            </ul>   
            <hr>             
        </div>
      </div>
            
    </div>
  </div>
        @if (count($pro))
                <div class="d-flex justify-content-center">
                    {{ $pro->appends(Request::all())->links() }}
                </div>
            @endif

    
@endsection
@section('custom-js')
  <script type="text/javascript">
    $(document).ready(function(){
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
  </script>
@endsection