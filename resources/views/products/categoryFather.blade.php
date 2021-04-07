@extends('layouts.app')
@section('custom-css')
    
@endsection
@section('content')
<div id="main" role="main" class="clearfix">
    {{-- <div itemtype="" itemscope="">
        <img id="slideSection" src="/img/ca_{{$gfather_id}}.jpg" alt="" class="img-fluid d-block w-100" style="max-height: 300px">
    </div> --}}
    <div class="container no-padding-sm-xs">
        <div class="row">
            <div id="primary" class="primary-content col-md-9 col-sm-12 col-xs-12 pull-right2 no-padding-md no-padding-lg no-padding-sm-xs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mt-4 mb-4">
                            <h3>{{ $gfather }} </h3>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-6 col-md-3">
                                        <div class="row">
                                            <div class="card mb-4 shadow-global bg-leemon-pro">
                                                <a href="/product/{{$product->proId}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product->reference }}/{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product2 img-fluid" alt=""></a>
                                                <div class="card-body col-12 col-md-12">
                                                    <div class="row justify-content-center text-center">
                                                        <span class="brand-font font-black text-leemon-color">{{ucwords($product->brand)}} </span>
                                                        <div class="col-12 height-p">
                                                            <h6>{{ucwords($product->proName)}} </h6>
                                                        </div>
                                                    
                                                            @if ($product->prom == 1) 
                                                                <h6><span class="badge badge-warning">Paga 2 Lleva 3</span></h6> 
                                                            @elseif ($product->prom == 2)
                                                                <h6><span class="badge badge-success">2nd 50% off</span></h6> 
                                                            @endif
                                                    
                                                        <div class="mt-2 mb-1">
                                                            <h6>$ {{number_format($product->price, 0)}} COP </h6>
                                                        </div>
                                                        <!-- <a href="/product/{{$product->proId}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                                                        {{-- <a href="{{ url('add-to-cart/'.$product->proId) }}"> <button type="button" class="btn btn-sm btn-leemon-pink"><i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito</button></a> --}}
                                                        
                                                        {{-- <button id="" class="btn btn-sm btn-leemon-pink update-cart"  data-id="{{ $product->proId }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Agregar al Carrito</button> --}}

                                                        @if (isset(session('cart')[$product->proId])) 
                                                            @if (($product->webquantity - session('cart')[$product->proId]["quantity"]) > 0)
                                                                <div id="nodis-button" class="col-xl-auto" style="width: 95%;">
                                                                    <div class="row">
                                                                    <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block"  data-id="{{ $product->proId }}" data-dif="{{ $product->webquantity - session('cart')[$product->proId]["quantity"] }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12">
                                                                    No Disponible
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div id="nodis-button" class="col-xl-auto" style="width: 95%;">
                                                                <div class="row">
                                                                    <button id="" class="btn btn-sm btn-leemon-pink update-cart btn-block"  data-id="{{ $product->proId }}" data-dif="{{ $product->webquantity }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar</button>
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
            <div id="secondary" class="refinements col-md-3 pull-left2 no-padding-md no-padding-lg hidden-xs hidden-sm">
            <hr> Filtrar
                <hr>
                <div class="refinement brand" data-analyticsevent="ShopBySub">
                    <h6 class="toggle active brand price-color">
                        Compra por Subcategoria
                    </h6>
                    <ul id="ref-price" class="refinementcontainer scrollable">
                        <div class="search-filters" style="display:none">
                            <label style="display:none" for="Search by  price">
                                Search by price
                            </label>
                            <input type="text" id="Search by  price" placeholder="Search by  price" class="txtRefinement" data-list="price">
                        </div>
                        @foreach ($subcategories as $subcategory) 
                            <li class="">
                                <a class="refinementlink add brand-size" href="/category/{{ str_replace(" ", "-",$gfather) }}/{{ $gfather_id }}/{{ str_replace(" ", "-",$subcategory->name) }}/{{ $subcategory->id }}" title="Futurebiotics">
                                    <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                    <span class="text-ref ">
                                        {{ $subcategory->name}}
                                        {{-- <span class="hits" style="color:#333333">({{$brand->total_brand}})</span> --}}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>   
                    <hr>             
                </div>
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
                                <a class="refinementlink add brand-size" href="/products/{{ str_replace(" ", "-",$gfather) }}/{{str_replace(" ", "-",$father)}}/{{str_replace(" ", "-",$son)}}_{{$subcat_id}}/{{ mb_strtolower(str_replace(" ", "-", $brand->brand))}}" title="Futurebiotics">
                                    <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                    <span class="text-ref ">
                                        {{ $brand->brand}}
                                        <span class="hits" style="color:#333333">({{$brand->total_brand}})</span>
                                    </span>
                                </a>
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
                        <li class="">
                                <a class="refinementlink add brand-size" href="/categories/filter/lowtohigh/{{ str_replace(" ", "-",$gfather) }}/{{$gfather_id}}" title="Futurebiotics">
                                    <span class="square-check">
                                        @if ($orderPrice == "lowtohigh")
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i><b>
                                        @else
                                            <i class="fa fa-square-o fa-lg"></i>
                                        @endif
                                    </span>
                                    <span class="text-ref ">
                                    DEL MÁS BAJO AL MÁS ALTO
                                    </span>
                                    @if ($orderPrice == "lowtohigh")
                                        </b>
                                    @endif 
                                </a>
                            </li>
                            <li class="">
                                <a class="refinementlink add brand-size" href="/categories/filter/hightolow/{{ str_replace(" ", "-",$gfather) }}/{{$gfather_id}}" title="Futurebiotics">
                                    <span class="square-check">
                                        @if ($orderPrice == "hightolow")
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i><b>
                                        @else
                                            <i class="fa fa-square-o fa-lg"></i>
                                        @endif
                                    </span>
                                    <span class="text-ref ">
                                        DEL MÁS ALTO AL MÁS BAJO
                                    </span>
                                    @if ($orderPrice == "lowtohigh")
                                        </b>
                                    @endif
                                </a>
                            </li>
                        
                    </ul>    
                    <hr>             
                </div> 
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