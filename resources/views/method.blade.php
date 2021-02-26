@extends('layouts.app')

@section('content')

<div id="main" class=" clearfix">
    <div class="container litlemargin">
        <div class="row justify-content-center">
            <div class="md-stepper-horizontal orange">
                {{-- <div class="md-step active done"> --}}
                {{-- <div class="md-step active editable"> --}}
                <div class="md-step active done">
                  <div class="md-step-circle"><span>1</span></div>
                  <div class="md-step-title">Registro</div>
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step active done">
                  <div class="md-step-circle"><span>2</span></div>
                  <div class="md-step-title">Verificación</div>
                  {{-- <div class="md-step-optional">Optional</div> --}}
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step active done">
                  <div class="md-step-circle"><span>3</span></div>
                  <div class="md-step-title">Envío</div>
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step active">
                  <div class="md-step-circle"><span>4</span></div>
                  <div class="md-step-title">Pago</div>
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
              </div>
        </div>
        <div class="row ">
            <div id="primary2" class=" col-md-9 col-sm-12 col-xs-12 pull-left no-padding-md no-padding-lg no-padding-sm-xs">
                <div class="primary-content2">
                    <div class="row">
                        @if ($answer == 1)
                            <div class="col-md-12">
                                <div class="row">
                                    
                                        
                                            <div class="card col-md-12 card-rounded mb-3">
                                                <div class="card-header row card-round-header" id="headingOne"> Dirección de Envio</div>
                                                <div class="row">
                                                    
                                                        
                                                            <div class="card-body card-body-yellow card-round-footer">
                                                                <h6>{{ ucwords($address->contact) }}</h6>
                                                                <p class="info-small">
                                                                    @php
                                                                        $my_address = str_replace("~", " ", $address->address)
                                                                    @endphp
                                                                    {{ $my_address }}, {{ $address->zipcode }} Código Postal<br>
                                                                    {{ ucwords($address->details) }}<br>
                                                                    {{ ucwords($address->city_d_id) }} ({{ ucwords($address->department) }}), {{ ucwords($address->country_master_name) }}
                                                                </p>
                                                            </div>
                                                        
                                                    
                                                </div>
                                                    
                                                
                                            </div>
                                        
                                    
                                </div>
                            </div>
                            {{--<div class="col-md-12">
                                <div class="row">
                                    <div class="card col-md-12 card-rounded mb-3">
                                        <div class="row">
                                            <div class="card-header col-md-12 card-round-header">Metodo de Pago</div>
                                        </div>
                                         
                                        <div class="row">
                                            <div class="card-body card-body-yellow card-round-footer">
                                                 <div class="form-check">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <input class="form-check-input" type="radio" name="methodPay" id="TC" value="1">
                                                                    <label class="form-check-label" for="TC">
                                                                        Tarjeta de Credito
                                                                        @if ($cardexist == 2)
                                                                            terminada en ************{{ $card[0]->last4num }}
                                                                        @else
                                                                            <a href="/secure/methods/create" id="creditcard" class="btn btn-leemon-green btn-sm" type='button'>Agregar una Tarjeta</a>
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="row float-right">
                                                                    @if ($cardexist == 2)
                                                                        <button class="btn btn-leemon-back btn-sm" data-toggle="modal" id="changeCard">Cambiar Tarjeta</button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div> 
                                                <hr>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="methodPay" id="PSE" value="2">
                                                    <label class="form-check-label" for="PSE">
                                                    PSE y tarjeta de Credito
                                                    </label>
                                                </div>
                                                <hr>
                                                 <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="methodPay" id="OTH" value="3">
                                                    <label class="form-check-label" for="OTH">
                                                    Otros metodos
                                                    </label>
                                                </div> 
    
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                             </div>--}}
                        @endif

                        <div class="card col-md-12 card-rounded">
                            <div class="row">
                                <div class="card-header col-md-12 card-round-header">
                                    <div class="row">
                                        <div class="col-md-8">
                                            Articulos
                                        </div>
                                        <div id="purchase-details" class="col-md-4 text-center">
                                            Precio
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body card-body-yellow card-round-footer">
                                    <div class="row">
                                        <?php 
                                            $subTotal = 0;
                                            $total = 0;
                                            $q_prod = 0;
                                            $delivery = 0;
                                            $total_d = 0;
                                            $beforeFee = 0;
                                            $fee = 0;
                                        ?>
                                        @if(session('cart'))
                                            @foreach(session('cart') as $id => $details)
                                
                                                <?php 
                                                $whole = 0;
                                                $half = 0;
                                                $nq = 0;
                                                $h = 0;
                                                $discount = 0;

                                                $hash = md5(env('SECRETPASS')."~".$details['name']."~".$details['price']."~".$details['prom']."~".$details['fee']."~".$details['width']."~".$details['height']."~".$details['length']."~".$details['weight']);

                                                if ($hash == $details['hash']){
                                                
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
                                                    // $delivery += $details['delivery_cost'] * $nq;
                                                    $total_d += $half + $discount;
                                                    $subTotal += ($details['price'] * $nq);
                                                    
                                                    if ($details['fee'] == 1){
                                                        $beforeFee += (($details['price'] * $nq) - $half - $discount) / 1.19;
                                                        $fee += ((($details['price'] * $nq) - $half - $discount) / 1.19) * 0.19;
                                                    }else{
                                                        $beforeFee += (($details['price'] * $nq) - $half - $discount);
                                                    }
                                                }
                                                ?>
                    
                                                <div class="col-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-8 col-md-8 line-right-cart py-3" data-th="Product">
                                                            <div class="row">
                                                                <div class="col-3 col-sm-4 hidden-xs">
                                                                    <div class="row text-center">
                                                                        <img src="{{ $details['photo'] }}"  class="img-purchase2 img-responsive mx-auto d-block"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-9 col-sm-8">
                                                                    <div id="cart_1" class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <small><span class="nomargin">{{ $details['name'] }}</span></small>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <span data-th="Price">
                                                                                        <small>$ {{ number_format($details['price'],0) }} COP</small>
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
                                                                    {{--<br>
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
                                                                                     <div class="col-2 col-md-2" data-th="">
                                                                                        <div class="row">
                                                                                            <button id="" class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                                                                                        </div>
                                                                                    </div> 
                                                                                    <div class="col-3 col-md-2">
                                                                                        <div class="row">
                                                                                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i> Eliminar</button>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                                        </div>
                                                                    </div>--}}
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="subtotal" data-th="Subtotal" class="col-4 col-md-4 text-right py-3">
                                                            <div class="col-md-12">
                                                                {{-- <span class="nomargin">
                                                                    <b>$ {{ number_format($details['price'] * $nq,0)}}</b><br>
                                                                </span> 
                                                                @if ($half > 0)
                                                                    <span class="text-danger">Descuento $ {{ number_format($half,0) }}</span><br> 
                                                                @elseif ($discount > 0)
                                                                     <span class="text-danger">Descuento $ {{ number_format($discount,0) }}</span><br>
                                                                @else
                                                                @endif --}}
                                                                <small><b>A pagar</b> $ {{ number_format(($details['price'] * $nq) - $half - $discount,0) }}</small>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                
                                            @endforeach
                                        @else
                                            <?php
                                            header('Location: /home');
                                            exit;
                                            ?>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="visible-xs">
                                               
                                                {{-- <div colspan="2" class="col-md-12 mb-3 hidden-xs">
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
                                                </div> --}}
                                                
                                                <div class="col-md-12 mt-4">
                                                    <div class="row">
                                                        <div class="card-title col-md-12 text-center">
                                                            <div class="row justify-content-md-center">
                                                                <div class="col-4 col-md-4 bg-title-cart">
                                                                    <div class="mt-2 mb-2"><b>Subtotal Compra</b></div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card-body info-small">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <div class="row">
                                                                            Cantidad de articulos:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="row float-right">
                                                                            {{ $q_prod }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            Subtotal:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="row float-right">
                                                                            COP $ {{ number_format($subTotal,0) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <div class="row">
                                                                            Descuento:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="row float-right">
                                                                            <span class="text-danger">-{{ number_format($total_d, 0) }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            Envío:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="row float-right">
                                                                            @if (session('tcc'))
                                                                                {{ number_format(session('tcc')->consultarliquidacionResult->total->totaldespacho,0) }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            Total
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="row float-right">
                                                                            @if (session('tcc'))
                                                                                COP$ {{ number_format($total + session('tcc')->consultarliquidacionResult->total->totaldespacho,0) }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- {{ $total + $delivery }} --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                            <div class="col-md-12">
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
                                                                <a href="{{ url('purchase') }}" class="btn btn-leemon-method">Información de Facturación</a>
                                                            @elseif ($answer == 1)
                                                                {{-- <button id="proccess" class="btn btn-purchase btn-sm">Proceder con el Pago</button> --}}
                                                                <a href="{{ route('paymentnow') }}" class="btn btn-purchase">Proceder con el Pago</a>
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
                        <div class="card col-md-12 card-rounded">
                            <div class="row">
                                <div class="card-header col-md-12 card-round-header">
                                    Subtotal Compra
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body info-small card-body-yellow card-round-footer">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    Cantidad de articulos:
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row float-right">
                                                    {{ $q_prod }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    Subtotal:
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row float-right">
                                                    COP$ {{ number_format($subTotal, 0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    Descuento:
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row float-right">
                                                    <span class="text-danger">-{{ number_format($total_d, 0) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    Envío:
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row float-right">
                                                    @if (session('tcc'))
                                                        {{ number_format(session('tcc')->consultarliquidacionResult->total->totaldespacho,0) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    
                                                    Total:
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row float-right">
                                                    @if (session('tcc'))
                                                    COP$ {{ number_format($total + session('tcc')->consultarliquidacionResult->total->totaldespacho,0) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ $total + $delivery }} --}}
                                    <div class="col-md-12">
                                        <div class="row">
                                    
                                            <div class="text-center col-md-12">
                                                @guest
                                                    <a class="btn btn-leemon-green btn-block" href="{{ url('/login') }}">Iniciar Sesión</a>
                                                    <span class="title-tam3">¿Eres nuevo en Leemon? </span><a class="title-tam2" href="{{ route('register') }}">{{ __('Unete aquí.') }}</a>
                                                @else
                                                    @if ($answer == 0)
                                                        <a href="{{ url('purchase') }}" class="btn btn-leemon-info btn-block">Información de Usuario</a>
                                                    @elseif ($answer == 1)
                                                    {{-- <button id="proccess2" class="btn btn-purchase btn-sm btn-block">Proceder con el Pago</button> --}}
                                                    <a href="{{ route('paymentnow') }}" class="btn btn-purchase btn-block">Proceder con el Pago</a>
                                                    
                                                    @endif
                                                @endguest
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="card-footer col-md-12">
                                    @guest
                                        <a class="btn btn-leemon-warning btn-block" href="{{ url('/login') }}">Iniciar Sesión</a>
                                    @else
                                        @if ($answer == 0)
                                            <a href="{{ url('purchase') }}" class="btn btn-leemon-method btn-block">Información de Facturación</a>
                                        @elseif ($answer == 1)
                                            <button id="proccess2" class="btn btn-success btn-sm btn-block">Proceder con el Pago</button>
                                        @endif
                                    @endguest
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.my_methods')
@endsection
@section('custom-js')
<script type="text/javascript">
    // function submitForm(){
    //     var fullname = $("#cc_name").val();
    //     var number = $("#cc_number").val();
    //     var month = $("#cc_expiration_m").val();
    //     var year = $("#cc_expiration_y").val();
    //     var cvv = $("#cc_cvv").val();

    //     $.ajax({
    //         type:'POST',
    //         dataType:'json',
    //         url:'secure/methods/',
    //         data:  $("#form_edit_info_card").serialize(),
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         beforeSend: function(x){
    //             $('#loading_web').show();
    //         },
    //         success:function(data){
    //             if(data.status==200){
    //                 // swal({
    //                 //     title: data.message,
    //                 //     text: data.message,
    //                 //     icon: "success",
    //                 // }); 
                    
    //                 $('#loading_web').hide();
    //                 window.location.reload(true);
                    
    //             }else if(data.status==403){
    //                 $.each(data.errors, function( index, value ) {
    //                 toastr.error(value, 'Error!', {  timeOut: 5e3});
    //                 });
    //                 $('#loading_web').hide();
    //                 return  false;
    //             }else{              
    //                 $('#loading_web').hide();
    //                 // toastr.error(data.message, "Error!");
    //                 alert("error");
    //                 return  false;
    //             }
    //         }
    //     });
    // }
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

        $('#creditcard').click(function () {
            
            $.ajax({
            type:'GET',   
            dataType:'json',      
            url:'secure/methods/create',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function(x){
                $('#loading_web').show();
            },
            success:function(data){
                if(data.status==200){
                    $('#loading_web').hide(); 
                    $('#modalCard').modal('show');        
                }else if(data.status==403){
                    $('#loading_web').hide(); 
                    $.each(data.errors, function( index, value ) {         
                        toastr.error(value, 'Error!', {  timeOut: 5e3});
                    });  
                }else{ 
                    $('#loading_web').hide(); 
                    toastr.error(data.message, "Error!");      
                }  
            }
            });
        });

        $(document).on('click', '#changeCard', function () {
      
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'secure/methods/list',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function(x){
                    $('#loading_web').show();
                },
                success:function(data){
                if(data.status==200){
                    showdata(data);
                    $('#loading_web').hide(); 
                    $('#selectioncard').modal('show');
                }else if(data.status==403){
                    $('#loading_web').hide(); 
                    $.each(data.errors, function( index, value ){
                    toastr.error(value, 'Error!', {  timeOut: 5e3});
                    });  
                }else{ 
                    $('#loading_web').hide(); 
                    toastr.error(data.message, "Error!");
                }  
                }
            });

        });

        $("#proccess").click(function () {
            connectZonPagos();
        });
        $("#proccess2").click(function () {
            connectZonPagos();
        });
    });

    // function connectZonPagos(){
    //     var methodPay = $('input:radio[name=methodPay]:checked').val()   

    //         if ((methodPay ==2) || (methodPay == 1)){
    //             $.ajax({
    //                 type:'POST',
    //                 dataType:'json',
    //                 data: {_token: '{{ csrf_token() }}', methodPay: methodPay},
    //                 url:'secure/methods/paynow',
    //                 // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //                 beforeSend: function(x){
    //                     $('#loading_web').show();
    //                 },
    //                 success:function(data){
    //                 if(data.status==200){
    //                     //alert(data.url);
    //                     //$('#loading_web').hide(); 
    //                     //$('#selectioncard').modal('show');
    //                     //window.open(data.url, '_blank');
    //                     $(location).attr('href',data.url);
    //                 }else if(data.status==403){
    //                     $('#loading_web').hide(); 
    //                     $.each(data.errors, function( index, value ){
    //                     toastr.error(value, 'Error!', {  timeOut: 5e3});
    //                     });  
    //                 }else if(data.status==506){
    //                     $('#loading_web').hide(); 
    //                     // $.each(data.errors, function( index, value ){
    //                     // toastr.error(value, 'Error!', {  timeOut: 5e3});
    //                     // });  
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Oops...',
    //                         text: data.message + data.order_exists,
    //                     });
    //                 }else{ 
    //                     $('#loading_web').hide(); 
    //                     toastr.error(data.message, "Error!");
    //                 }  
    //                 }
    //             });
    //         }else{
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Debe escojer un Metodo de Pago Valido',
    //             });
    //         }
            
    // }
</script>
@endsection