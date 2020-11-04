@extends('layouts.app')

@section('content')
<div id="main" role="main" class="clearfix">
    <div class="container no-padding-sm-xs">
        <div class="breadcrumbs-block" itemtype="" itemscope="">
            <div class="breadcrumb hidden-xs" itemprop="breadcrumb">
                Home | {{ $gfather }} | {{ $son }} 
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
                                            <a href="/product/{{$product->id}}"><img src="{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt=""></a>
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
                                                    <br><a class="favorites" href="{{ url('add-to-favorites/'.$product->id) }}">Enviar a Favoritos</a>
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
            Filtrar
        </div>

    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
  $(document).ready(function(){
        
  });
</script>
@endsection