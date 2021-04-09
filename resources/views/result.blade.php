@extends('layouts.app')

@section('content')
  <div id="main" role="main" class="clearfix">    
    <div class="container  no-padding-sm-xs">
      <div class="row">
        <div class="col-12 breadcrumbs-block" itemtype="" itemscope="">
          <div id="routeCat"class="breadcrumb hidden-xs" itemprop="breadcrumb">
              Home
          </div>
        </div>
        <div id="primary" class="primary-content col-md-9 col-sm-12 col-xs-12 pull-right2 no-padding-md no-padding-lg no-padding-sm-xs">
          <div class="container">
            <div class="row">
                  <div class="col-md-12">
                      <h3>Resultado de la busqueda</h3>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      @foreach ($pro as $product)
                        <div class="col-6 col-md-3">
                          <div class="row">
                            <div class="card mb-4  shadow-global bg-leemon-pro">
                              <a href="/product/{{$product->id}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product->reference }}/{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product2 img-fluid" alt=""></a>
                              <div class="card-body col-12 col-md-12">
                                <div class="row justify-content-center text-center">        
                                  <span class="brand-font font-black text-leemon-color">{{ucwords($product->brand)}} </span>
                                  <div class="col-12 height-p">
                                      <h6>{{ucwords($product->name)}} </h6>
                                  </div>
                                  
                                      @if ($product->prom == 1) 
                                          <h6><span class="badge badge-warning">Paga 2 Lleva 3</span></h6> 
                                      @elseif ($product->prom == 2)
                                          <h6><span class="badge badge-success">2nd 50% off</span></h6> 
                                      @endif
                                      <div class="mt-2 mb-1">
                                        @if ($product->price > 0)
                                          <h6>$ {{number_format($product->price, 0)}} COP </h6>
                                        @else 
                                          No Disponible
                                        @endif
                                      </div>
                                                          <!-- <a href="/product/{{$product->id}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                                      {{-- <a href="{{ url('add-to-cart/'.$product->id) }}">
                                        <button type="button" class="btn btn-sm btn-leemon-pink">
                                          <i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito
                                        </button>
                                      </a> --}}
                                      @if (isset(session('cart')[$product->id])) 
                                        @if (($product->quantity - session('cart')[$product->id]["quantity"]) > 0)
                                          <div id="nodis-button" class="col-xl-auto" style="width: 95%;">
                                            <div class="row">
                                              <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block"  data-id="{{ $product->id }}" data-dif="{{ $product->quantity - session('cart')[$product->id]["quantity"] }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                            </div>
                                          </div>
                                        @else
                                          <div class="col-md-12">
                                            <div class="row">
                                              @guest
                                                <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $product->id }}" data-t="0">Notificar Disponibilidad</button>
                                              @else
                                                <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $product->id }}" data-t="1">Notificar Disponibilidad</button>
                                              @endguest
                                              
                                            </div>
                                          </div>
                                        @endif
                                      @else
                                          @if ($product->quantity >0)
                                            <div id="nodis-button" class="col-xl-auto"  style="width: 95%;">
                                              <div class="row">
                                                <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block"  data-id="{{ $product->id }}" data-dif="{{ $product->quantity }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                              </div>
                                            </div>
                                          @else
                                            <div class="col-md-12">
                                              <div class="row">
                                                @guest
                                                <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $product->id }}" data-t="0">Notificar Disponibilidad</button>
                                              @else
                                                <button id="" class="btn btn-sm btn-leemon-blue notify-pro btn-block"  data-id="{{ $product->id }}" data-t="1">Notificar Disponibilidad</button>
                                              @endguest
                                              {{-- <a id="tooldisp_{{ $product->id }}" data-pro="{{ $product->id }}" class="dispo" style="position: absolute;right: 20px;top: -327px; z-index: 999; cursor:pointer" data-toggle="tooltip" data-placement="top" data-trigger="click" title="En estos momentos el articulo no se encuentra disponible. Si deseas, Leemon Nutrición te podrá avisar apenas esté disponible. Si has iniciado sesión da click en el botón azul de Notificar, sino inicia sesión con tu cuenta para poder registrar tu email.">
                                                <img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/images/logos/question.png" alt="" width="30px">
                                              </a> --}}
                                              </div>
                                            </div>
                                          @endif
                                      @endif 
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
        <div id="secondary" class="refinements col-md-3 pull-left2 no-padding-md no-padding-lg hidden-xs hidden-sm">
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

      $(".notify-pro").click(async function (e) {
        var ere = $(this);
        var pd = ere.attr("data-id");
        var t = ere.attr("data-t");
        var email2 = '';
        var send = 0;

        if(t == 0){
          const { value: email } = await Swal.fire({
            title: 'Input email address',
            input: 'email',
            inputLabel: 'Your email address',
            inputPlaceholder: 'Enter your email address'
          })

          if (email) {
           email2 = email;
           send = 1;
          }
        }else{
          send = 1;
        }

        if (send == 1)
        $.ajax({
          url: "/secure/notify/info",
          method: "post",
          data: {_token: '{{ csrf_token() }}', id: pd, t: t, email:email2},
          beforeSend: function(x){
            ere.before("<div id='loadPro' class='col-12 text-center'><i class='fa fa-refresh fa-spin'></i> Agregando</div>");
            ere.hide();
          },
          success: function (response) {
            
          }
        });

      });
      
      $('[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        placement: 'top',
        trigger: 'click'
      });
      
    });
  </script>
@endsection