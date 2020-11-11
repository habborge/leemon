@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        
            <div class="card col-md-12">
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
                                    
                                        $total += ($details['price'] * $nq) - $half - $discount;
                                        $delivery += $details['delivery_cost'] * $nq;
                                    ?>
        
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-9" data-th="Product">
                                                <div class="row">
                                                    <div class="col-3 col-sm-3 hidden-xs">
                                                        <div class="row text-center">
                                                            <img src="{{ $details['photo'] }}"  class="img-purchase img-responsive mx-auto d-block"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 col-sm-9">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <h4 class="nomargin">
                                                                    {{ $details['name'] }}
                                                                    @if ($details['prom'] == 1) 
                                                                        <br><span class="badge badge-warning">Paga 2 Lleva 3</span>
                                                                    @elseif ($details['prom'] == 2)
                                                                        <br><span class="badge badge-danger">2nd 50% off</span>
                                                                    @endif
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-12" data-th="Price">
                                                                    ${{ number_format($details['price'],0) }}
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4 input-group" data-pr="Quantity">
                                                                            <div class="row">
                                                                                <div class="input-group input-group-sm mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                      <span class="input-group-text" id="inputGroup-sizing-sm">Cantidad</span>
                                                                                    </div>
                                                                                    <input class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"  id="Quantity_{{$id}}" type="number" value="{{ $details['quantity'] }}">
                                                                                  </div>
                                                                                
                                                                                
                                                                                @if ($discount > 0)
                                                                                    <span class="info-small">Free: {{ $whole }}</span> 
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 actions" data-th="">
                                                                            <div class="row">
                                                                                <button id="" class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i> Eliminar</button>
                                                                    </div>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div data-th="Subtotal" class="col-3 col-md-3 text-right">
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
                                    <div>
                                        @if ($answer == 1)
                                            <h6><b>Información de Envio</b></h6>
                                            <span class="info-small"><b>Dirección de Envio:</b> {{ $member_info[0]->delivery_address }}<br>
                                            <b>Cliente:</b> {{ $member_info[0]->firstname }} {{ $member_info[0]->lastname }}<br>
                                            <b>Email:</b> {{ $member_info[0]->email }}<br>
                                            <b>No de ID:</b> {{ $member_info[0]->n_doc }}<br></span>
                                            
                                        @endif
                                    </div>
                                    <div colspan="2" class="hidden-xs">
                                        @if ($answer == 1)
                                            <h6><b>Información de Pago</b></h6>
                                            <span class="info-small"><b>Cliente:</b>  {{ $member_info[0]->fullname }}<br>
                                            <b>Metodo de Pago:</b> Credit Card<br>
                                            @php
                                                $number = substr($member_info[0]->cardnumber, -4, 4);
                                            @endphp
                                            <b>No de Tarjeta:</b> **********{{$number}}<br>
                                            <b>vence:</b> {{ $member_info[0]->expiration }}<br></span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        SubTotal $ {{ $total }}<br>
                                        @if ($answer == 1)
                                            Costo de Entrega $ {{ $delivery }}<br>
                                    <b>Total a Pagar $ {{ $total + $delivery }}</b>
                                        @endif    
                                    
                                    </div>
                                </div>
                                
                            
                                <div class="visible-xs">
                                    <div class="row">
                                        <div class="col-6 col-md-6">
                                            <a href="{{ url('/') }}" class="btn btn-leemon-back">
                                                Continua de Compras
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
                                                    <a href="{{ url('confirm') }}" class="btn btn-primary">Confirmar Pago</a>
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
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".update-cart").click(function (e) {
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