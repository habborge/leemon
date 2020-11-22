@extends('layouts.app')

@section('content')
<div id="main" class="tabs clearfix">
    <div class="container no-padding-sm-xs dataPosition2">
        <div class="row ">
            <div id="primary2" class=" col-md-9 col-sm-12 col-xs-12 pull-left no-padding-md no-padding-lg no-padding-sm-xs">
                <div class="primary-content2">
                    <div class="row">
                        <div class="card col-md-12 ">
                            <div class="row">
                                <div class="card-header col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            Product
                                        </div>
                                        <div id="purchase-details" class="col-md-4">
                                            Price
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body">
                                    <div class="row">
                                        <?php 
                                            $total = 0;
                                            $q_prod = 0;
                                            $delivery = 0;
                                        ?>
                                        @if(session('cart'))
                                            @foreach(session('cart') as $id => $details)
                                
                                                <?php 
                                                $whole = 0;
                                                $half = 0;
                                                $nq = 0;
                                                $h = 0;
                                                $discount = 0;
                                                
                                                if (($details['prom'] == 1) and ($details['quantity'] >= 2 )){
                                                    $whole = (int) ($details['quantity'] / 2);
                                                    $h = (2 * $whole) + $whole;
                                                    $nq = $details['quantity'] + ($h - $details['quantity']);
                                                    $discount = round($details['price'] * $whole);
                                                    //$details['quantity'] = $nq;
                    
                                                }else if (($details['prom'] == 2) and ($details['quantity'] >= 2)){
                                                    $whole = (int) ($details['quantity'] / 2);
                                                    $half = round(($details['price'] / 2) * $whole);
                                                    $nq = $details['quantity'];
                                                }else{
                                                    $nq = $details['quantity'];
                                                }
                                                    $q_prod += $details['quantity'];
                                                    $total += ($details['price'] * $nq) - $half - $discount;
                                                    $delivery += $details['delivery_cost'] * $nq;
                                                ?>
                    
                                                <div class="col-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-9" data-th="Product">
                                                            <div class="row">
                                                                <div class="col-3 col-sm-4 hidden-xs">
                                                                    <div class="row text-center">
                                                                        <img src="{{ $details['photo'] }}"  class="img-purchase img-responsive mx-auto d-block"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-9 col-sm-8">
                                                                    <div id="cart_1" class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <span class="nomargin">{{ $details['name'] }}</span>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <span data-th="Price">
                                                                                        ${{ number_format($details['price'],0) }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    @if ($details['prom'] == 1) 
                                                                                        <span class="badge badge-warning">Paga 2 Lleva 3</span>
                                                                                    @elseif ($details['prom'] == 2)
                                                                                        <span class="badge badge-danger">2nd 50% off</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div id="cart_2" class="col-md-12">
                                                                        <div class="row">
                                                                            
                                                                            <div class="col-8 col-md-12">
                                                                                <div class="row">
                                                                                    <div class="col-9 col-md-4 input-group" data-pr="Quantity">
                                                                                        <div class="row">
                                                                                            <div class="input-group input-group-sm mb-3">
                                                                                                <div class="input-group-prepend">
                                                                                                  <span class="input-group-text" id="inputGroup-sizing-sm">Cant:</span>
                                                                                                </div>
                                                                                                <input class="form-control update-cart" aria-label="Small" aria-describedby="inputGroup-sizing-sm"  data-id="{{ $id }}"  id="Quantity_{{$id}}" type="number" value="{{ $details['quantity'] }}">
                                                                                              </div>
                                                                                            
                                                                                            
                                                                                            @if ($discount > 0)
                                                                                                <span class="info-small">Free: {{ $whole }}</span> 
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    {{-- <div class="col-2 col-md-2" data-th="">
                                                                                        <div class="row">
                                                                                            <button id="" class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                                                                                        </div>
                                                                                    </div> --}}
                                                                                    <div class="col-3 col-md-2">
                                                                                        <div class="row">
                                                                                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i> Eliminar</button>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="subtotal" data-th="Subtotal" class="col-3 col-md-3 text-right">
                                                            <h4 class="nomargin">
                                                                $ {{ number_format($details['price'] * $nq,0)}}
                                                            </h4> 
                                                            @if ($half > 0)
                                                                <br> <span class="text-danger">Descuento $ {{ number_format($half,0) }}</span>
                                                            @elseif ($discount > 0)
                                                                <br> <span class="text-danger">Descuento $ {{ number_format($discount,0) }}</span>
                                                            @else
                                                            @endif
                                                                <br>A pagar $ {{ number_format(($details['price'] * $nq) - $half - $discount,0) }}
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <hr>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="visible-xs">
                                                
                                                <div class="col-md-12 mb-3">

                                                    @if ($answer == 1)
                                                        <div class="card bg-light mb-3 h-card">
                                                            <div class="card-header">Información de Envio</div>
                                                            <div class="card-body">
                                                                <span class="info-small"><b>Dirección de Envio:</b> {{ $address[0]->address }}<br>
                                                                    <b>Detalle:</b> {{ $address[0]->details }}<br>
                                                                    <b>Lugar:</b> {{ $address[0]->city }}({{ $address[0]->dpt }}), {{ $address[0]->country }}<br>
                                                                    <b>Código Postal:</b> {{ $address[0]->zipcode }}<br></span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div colspan="2" class="col-md-12 mb-3 hidden-xs">
                                                    @if ($answer == 1)
                                                        <div class="card bg-light mb-3 h-card">
                                                            <div class="card-header">Información de Pago</div>
                                                            <div class="card-body">
                                                                <span class="info-small"><b>Cliente:</b>  {{ $card[0]->fullname }}<br>
                                                                    <b>Metodo de Pago:</b> Credit Card<br>
                                                                    <b>No de Tarjeta:</b> **********{{$card[0]->last4num}}<br>
                                                                    <b>vence:</b> {{ $card[0]->expiration }}<br></span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    SubTotal $ {{ $total }}<br>
                                                    {{-- @if ($answer == 1)
                                                        Costo de Entrega $ {{ $delivery }}<br>
                                                        <b>Total a Pagar $ {{ $total + $delivery }}</b>
                                                    @endif     --}}
                                                
                                                </div>
                                            </div>
                                            
                                        
                                            <div class="visible-xs">
                                                <div class="row">
                                                    <div class="col-6 col-md-6">
                                                        <a href="{{ url('/') }}" class="btn btn-leemon-back">
                                                            Seguir Comprando
                                                        </a>
                                                    </div>
                                                    
                                                    <!--<div class="hidden-xs text-right"><strong>Total $ {{ $total }}</strong></div>-->
                                                    <div class="col-6 col-md-6 text-right">
                                                        @guest
                                                            <a class="btn btn-leemon-warning" href="{{ route('login') }}">Iniciar Sesión</a>
                                                        @else
                                                            @if ($answer == 0)
                                                                <a href="{{ url('purchase') }}" class="btn btn-leemon-method">Metodo de Pago</a>
                                                            @elseif ($answer == 1)
                                                                <a href="{{ url('confirm') }}" class="btn btn-success">Proceder con el Pago</a>
                                                            @endif
                                                        @endguest
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
            </div>
            <div id="secondary2" class="refinements col-md-3 pull-right no-padding-md no-padding-lg hidden-xs hidden-sm">
                <div class="primary-content2">
                    <div class="row">
                        <div class="card col-md-12">
                            <div class="row">
                                <div class="card-header col-md-12">
                                    Subtotal Compra
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body">
                                    <span>Cantidad de articulos: {{ $q_prod }}<br>
                                    <b>Subtotal a Pagar $ {{ $total }}</b></span>
                                    {{-- {{ $total + $delivery }} --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-footer col-md-12">
                                    @guest
                                        <a class="btn btn-leemon-warning" href="{{ route('login') }}">Iniciar Sesión</a>
                                    @else
                                        @if ($answer == 0)
                                            <a href="{{ url('purchase') }}" class="btn btn-leemon-method">Metodo de Pago</a>
                                        @elseif ($answer == 1)
                                            <a href="{{ url('confirm') }}" class="btn btn-success btn-block">Proceder con el Pago</a>
                                        @endif
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".update-cart").change(function (e) {
            e.preventDefault();
            
            var ele = $(this);
            var q = $("#Quantity_" + ele.attr("data-id")).val();

            
            $.ajax({
                url: "{{ env('APP_URL')}}/update-cart",
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: q},
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if(confirm("Are you sure")) {
                $.ajax({
                    url: "{{ env('APP_URL')}}/remove-from-cart",
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection