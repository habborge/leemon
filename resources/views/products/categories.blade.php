@extends('layouts.app')

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
                                        <div class="card mb-4 shadow-sm shadow-global">
                                            <a href="/product/{{$product->id}}"><img src="{{ env('AWS_URL') }}/{{ env('BUCKET_SUBFOLDER')}}/products/{{ $product->reference }}/{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product2" alt=""></a>
                                            <div class="card-body text-center">
                                                <h6>{{ucwords($product->brand)}} </h6>
                                                <span  class="brand-font">{{ucwords($product->name)}} </span>
                                                <h6>
                                                    @if ($product->prom == 1) 
                                                        <span class="badge badge-warning">Paga 2 Lleva 3</span>
                                                    @elseif ($product->prom == 2)
                                                        <span class="badge badge-success">2nd 50% off</span>
                                                    @endif
                                                </h6> 
                                                <h6>$ {{number_format($product->price, 0)}} COP</h6>
                                                <!-- <a href="/product/{{$product->id}}"><button type="button" class="btn btn-sm btn-primary">Ver Más</button></a> -->
                                                <a href="{{ url('add-to-cart/'.$product->id) }}"> <button type="button" class="btn btn-sm btn-leemon-green"><i class="czi-cart font-size-sm mr-1"></i>Agregar al Carrito</button></a>
                                                @guest
                
                                                @else
                                                    <br><a class="favorites update-wishlist" href="#"  data-id="{{ $product->id }}">Enviar a Favoritos</a>
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
                Rango de Precios
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
                                    10.000 a 20.000
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="refinementlink add brand-size" href="" title="Futurebiotics">
                                <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                <span class="text-ref ">
                                    20.000 a 30.000
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="refinementlink add brand-size" href="" title="Futurebiotics">
                                <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                <span class="text-ref ">
                                    30.000 a 40.000
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="refinementlink add brand-size" href="" title="Futurebiotics">
                                <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                <span class="text-ref ">
                                    40.000 a 50.000
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="refinementlink add brand-size" href="" title="Futurebiotics">
                                <span class="square-check"><i class="fa fa-square-o fa-lg"></i></span>
                                <span class="text-ref ">
                                    Mas de 50.000
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
  });
</script>
@endsection