@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        <div class="row">
            <div class="col-xl-2">
                <ul class="nav nav-pills nav-stacked flex-column">
                <li class="active"><a href="#tab_a" data-toggle="pill"><img src="../{{ $prod_info->img1 }}" class="img-tam" alt=""></a></li>
                    <li><a href="#tab_b"  data-toggle="pill"><img src="../{{ $prod_info->img2 }}" class="img-tam" alt=""></a></li>
                </ul>
            </div>
            <div class="col-xl-4">
                <div class="tab-content" id="father">
                    <div class="tab-pane active" id="tab_a">
                        
                        <img src="../{{ $prod_info->img1 }}" class="img-tam2 img-thumbnail" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_b">
                        
                        <img src="../{{ $prod_info->img2 }}" class="img-tam2 img-thumbnail" alt="">
                        
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
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
       
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
    });
</script>
@endsection