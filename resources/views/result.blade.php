@extends('layouts.app')

@section('content')
    
        <div class="container">
            <div class="row">
                @foreach ($search as $product)
          <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
              <a href="/product/{{$product->id}}"><img src="{{$product->img1}}" class="card-img-top rounded mx-auto d-block img-pro img-product" alt=""></a>
              <div class="card-body text-center">
                
                
                <span class="brand-font">{{ucwords($product->brand)}} </span>
                <h5>{{ucwords($product->name)}} </h5>

                
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
                
                  
                
              </div>
            </div>
          </div>
        @endforeach
            </div>
            
        </div>
        @if (count($search))
                <div class="d-flex justify-content-center">
                    {{ $search -> links() }}
                </div>
            @endif
            <footer class="text-muted">
                <div class="container">
                  <p class="float-right">
                    <a href="#">Regresar Arriba</a>
                  </p>
                  <p>Leemon Team</p>
                  <p></p>
                </div>
              </footer>
    
@endsection