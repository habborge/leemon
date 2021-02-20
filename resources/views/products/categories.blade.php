@extends('layouts.app')
@section('custom-css')
    
@endsection
@section('content')
<div id="main" role="main" class="clearfix">
    <div class="container no-padding-sm-xs">
        <div class="breadcrumbs-block" itemtype="" itemscope="">
            <div id="routeCat"class="breadcrumb hidden-xs" itemprop="breadcrumb">
                Home | {{ $gfather }} | {{ $father }} |  <a class="" href="/products/{{ str_replace(" ", "-",$gfather) }}/{{str_replace(" ", "-",$father)}}/{{str_replace(" ", "-",$son)}}_{{$subcat_id}}">{{ $son }} </a>
            </div>
        </div>
        <div id="primary" class="primary-content col-md-9 col-sm-12 col-xs-12 pull-right no-padding-md no-padding-lg no-padding-sm-xs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ $son }} </h3>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="card mb-4 shadow-global bg-leemon-pro card-rounded">
                                            <a href="/product/{{$product->proId}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product->reference }}/{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product2" alt=""></a>
                                            <div class="card-body text-center">
                                                <span class="brand-font">{{ucwords($product->brand)}} </span>
                                                <div style="height: 80px"><h6>{{ucwords($product->proName)}} </h6></div>
                                                <h6>
                                                    @if ($product->prom == 1) 
                                                        <span class="badge badge-warning">Paga 2 Lleva 3</span>
                                                    @elseif ($product->prom == 2)
                                                        <span class="badge badge-success">2nd 50% off</span>
                                                    @endif
                                                </h6> 
                                                <div class="mb-4">
                                                <h6>$ {{number_format($product->price, 0)}} COP </h6>
                                                </div>
                                                <!-- <a href="/product/{{$product->proId}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                                                {{-- <a href="{{ url('add-to-cart/'.$product->proId) }}"> <button type="button" class="btn btn-sm btn-leemon-green"><i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito</button></a> --}}
                                                
                                                {{-- <button id="" class="btn btn-sm btn-leemon-green update-cart"  data-id="{{ $product->proId }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Agregar al Carrito</button> --}}

                                                @if (isset(session('cart')[$product->proId])) 
                                                    @if (($product->webquantity - session('cart')[$product->proId]["quantity"]) > 0)
                                                        <div id="nodis-button" class="col-xl-auto">
                                                            <div class="row">
                                                            <button id="" class="btn btn-sm btn-leemon-green update-cart btn-block"  data-id="{{ $product->proId }}" data-dif="{{ $product->webquantity - session('cart')[$product->proId]["quantity"] }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
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
                                                        <button id="" class="btn btn-sm btn-leemon-green update-cart btn-block"  data-id="{{ $product->proId }}" data-dif="{{ $product->webquantity }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                                    </div>
                                                    </div>
                                                @endif 
                                                @guest
                
                                                @else
                                                    <br><a class="favorites update-wishlist" href="#"  data-id="{{ $product->proId }}">Enviar a Favoritos</a>
                                                @endguest
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if (count($products))
                <div class="d-flex justify-content-center">
                    {{ $products -> links() }}
                </div>
                @endif
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
                    @foreach ($brands as $brand) 
                        <li class="">
                            @if ($brand->brand != $brandname)
                                <a class="refinementlink add brand-size" href="/products/{{ str_replace(" ", "-",$gfather) }}/{{str_replace(" ", "-",$father)}}/{{str_replace(" ", "-",$son)}}_{{$subcat_id}}/{{ mb_strtolower(str_replace(" ", "-", $brand->brand))}}" title="Futurebiotics">
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
                </ul>   
                <hr>             
            </div>
             <div class="refinement brand" data-analyticsevent="ShopByPrice">
                <h6 class="toggle active price price-color">
                Orden de Precios
                </h6>
                <ul id="ref-price" class="refinementcontainer scrollable">
                    <div class="search-filters" style="display:none">
                        <label style="display:none" for="Search by  price">
                            Search by Price
                        </label>
                        <input type="text" id="Search by  price" placeholder="Search by  price" class="txtRefinement" data-list="price">
                    </div>
                    
                        <li class="">
                            <a class="refinementlink add brand-size" href="" title="Futurebiotics">
                                <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                <span class="text-ref ">
                                   DEL MÁS BAJO AL MÁS ALTO
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="refinementlink add brand-size" href="" title="Futurebiotics">
                                <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                <span class="text-ref ">
                                    DEL MÁS ALTO AL MÁS BAJO
                                </span>
                            </a>
                        </li>
                    
                </ul>                
            </div> 
        </div>

    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
  $(document).ready(function(){
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