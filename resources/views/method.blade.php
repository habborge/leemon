@extends('layouts.app')

@section('content')
@php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
@endphp
<div id="main" class="clearfix body-cart">
    <div class="container litlemargin">
        <div class="col-12 row justify-content-center">
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
                  <div class="md-step-title">Datos de Envío</div>
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
                            <div id="cart_1" class="col-md-12">
                                <div class="row">
                                    @if($errors->any())
                                        <div class="col-12 alert alert-danger" role="alert">
                                            {{$errors->first()}}
                                        </div>
                                    @endif
                                    <div class="card col-md-12 card-rounded mb-3">
                                        <div class="card-header row card-round-header" id="headingOne"> 
                                            Dirección de Envio
                                        </div>
                                        <div class="row">
                                            <div class="card-body card-body-yellow card-round-footer">
                                                <h6>{{ ucwords($address->contact) }}</h6>
                                                <p class="info-small">
                                                    @php
                                                        $my_address = str_replace("~", " ", $address->address)
                                                    @endphp
                                                    {{ $my_address }}, {{ $address->zipcode }} Código Postal<br>
                                                    {{ ucwords($address->details) }}<br>
                                                    {{ ucwords($address->dane_d) }} - {{ ucwords($address->city_d_id) }} ({{ ucwords($address->department) }}), {{ ucwords($address->country_master_name) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{--  --}}
                        {{-- <div id="cart_4" class="col-md-12">
                            <div class="row">
                                <div class="card col-md-12 card-rounded mb-3">
                                    <div class="card-header row card-round-header" id="headingOne"> 
                                        Voucher de Descuento
                                    </div>
                                    <div class="card-body card-body-yellow card-round-footer">
                                        @if (session('voucher'))
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-12 alert alert-success" role="alert">
                                                        Ya has Utilizado un Voucher de Descuento!!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="row">
                                                        <div id="vouchermessage" class="col-12 alert alert-danger" role="alert">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="loading_web2">
                                                    <img src="/img/preloader.gif" id="img_loading" alt="">
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <div class="row">
                                                        <label for="voucher" class="sr-only">Código de Descuento</label>
                                                        <input type="text" class="form-control form-control-sm mr-1" id="voucher" name="voucher" placeholder="Código de Descuento" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="row">
                                                        <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                                                        <button id="sendcode" type="button" class="btn btn-primary mb-2 btn-sm">Confirmar Código</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{--  --}}

                        {{--  --}}
                        <div id="cart_2" class="card col-md-12 card-rounded">
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
                                                
                                                    $q_prod += $details['quantity'];
                                                }
                                                ?>
                    
                                                <div class="col-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-12 col-md-8 line-right-cart py-3" data-th="Product">
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
                                                                                    <span data-th="Price">
                                                                                        <small>Cant: {{ $details['quantity'] }} </small>
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
                                                        
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="subtotal" data-th="Subtotal" class="col-4 col-md-4 text-right py-3">
                                                            <div class="col-md-12">
                                                                <small>$ {{ number_format(($details['price']) ,0) }}</small>
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
                                                <div class="col-md-12 mt-4">
                                                    <div class="row">
                                                        <div class="col-12 card-title col-md-12 text-center">
                                                            <div class="row justify-content-center">
                                                                <div class="col-8 col-md-4 bg-title-cart">
                                                                    <div class="mt-2 mb-2"><b>Subtotal Compra</b></div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card-body info-small">
                                                            <div class="col-12 col-md-12">
                                                                <div class="row">
                                                                    <div class="col-9 col-md-9">
                                                                        <div class="row">
                                                                            Cantidad de articulos:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 col-md-3">
                                                                        <div class="row float-right">
                                                                            {{ $q_prod }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12">
                                                                <div class="row">
                                                                    <div class="col-6 col-md-8">
                                                                        <div class="row">
                                                                            Subtotal:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 col-md-4">
                                                                        <div class="row float-right">
                                                                            @if ($delivery_cost == "free")
                                                                                COP $ {{ number_format($supertotal,0) }}
                                                                            @elseif ($delivery_cost == "freeVoucher")
                                                                                COP $ {{ number_format($supertotal,0) }}
                                                                            @else    
                                                                                @if (session('tcc'))
                                                                                    @if (!empty(session('tcc')->consultarliquidacion2Result))
                                                                                        COP $ {{ number_format($supertotal - session('tcc')->consultarliquidacion2Result->total->totaldespacho,0) }}
                                                                                    @else
                                                                                        COP $ {{ number_format($supertotal - session('tcc'),0) }}
                                                                                    @endif
                                                                                    
                                                                                @endif
                                                                            @endif
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12">
                                                                <div class="row">
                                                                    <div class="col-9 col-md-9">
                                                                        <div class="row">
                                                                            Descuento:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 col-md-3">
                                                                        <div class="row float-right">
                                                                            <span class="text-danger">-0</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-12 col-md-12">
                                                                <div class="row">
                                                                    <div class="col-8 col-md-8">
                                                                        <div class="row">
                                                                            Envío:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4 col-md-4">
                                                                        <div class="row float-right">
                                                                            @if ($delivery_cost == "free")
                                                                                COP$ (Envío Gratis)

                                                                            @elseif ($delivery_cost == "freeVoucher")
                                                                                @if (session('voucher'))
                                                                                    COP$ (Envío Gratis por Uso de Voucher No {{session('voucher')['voucher_id']}})
                                                                                @endif
                                                                            @else 
                                                                                @if (session('tcc'))
                                                                                    @if (!empty(session('tcc')->consultarliquidacion2Result))
                                                                                        COP $ {{ number_format(session('tcc')->consultarliquidacion2Result->total->totaldespacho,0) }}
                                                                                    @else
                                                                                        COP $ {{ number_format(session('tcc'),0) }}
                                                                                    @endif
                                                                                    
                                                                                @endif
                                                                            @endif       
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="col-12 col-md-12">
                                                                <div class="row">
                                                                    <div class="col-8 col-md-8">
                                                                        <div class="row">
                                                                            Total
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4 col-md-4">
                                                                        <div class="row float-right">
                                                                            @if ($delivery_cost == "free")
                                                                                COP$ {{ number_format($supertotal,0) }}
                                                                            @elseif ($delivery_cost == "freeVoucher")
                                                                                COP$ {{ number_format($supertotal,0) }}
                                                                            @else    
                                                                                @if (session('tcc'))
                                                                                
                                                                                    COP$ {{ number_format($supertotal,0) }}
                                                                                @endif
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
                                                    <div id="firstbutton" class="col-6 col-md-6">
                                                        <a href="{{ url('/') }}" class="btn btn-leemon-back">
                                                            Seguir Comprando
                                                        </a>
                                                    </div>
                                                    
                                                    <!--<div class="hidden-xs text-right"><strong>Total $ {{ $total }}</strong></div>-->
                                                    <div id="secondbutton"class="col-12 col-md-6 text-right">
                                                        @guest
                                                            <a class="btn btn-leemon-warning btn-width" href="{{ route('login') }}">Iniciar Sesión</a>
                                                        @else
                                                            @if ($answer == 0)
                                                                <a href="{{ url('purchase') }}" class="btn btn-leemon-method btn-width">Información de Facturación</a>
                                                            @elseif ($answer == 1)
                                                                {{-- <button id="proccess" class="btn btn-purchase btn-sm">Proceder con el Pago</button> --}}
                                                                
                                                                <form method="post" action="{{env('PAY_URL')}}">
                                                                    <input name="merchantId"    type="hidden"  value="{{ env('MERCHANT') }}"   >
                                                                     <input name="accountId"     type="hidden"  value="{{ env('ACCOUNT') }}" >
                                                                     <input name="description"   type="hidden"  value="Pay-U: Compra de Productos Naturales"  >
                                                                     <input name="referenceCode" type="hidden"  value="100498-{{$orderId}}" >
                                                                     <input name="amount"        type="hidden"  value="{{$supertotal}}"   >
                                                                     <input name="tax"           type="hidden"  value="0"  >
                                                                     <input name="taxReturnBase" type="hidden"  value="0" >
                                                                     <input name="currency"      type="hidden"  value="COP" >
                                                                     <input name="signature"     type="hidden"  value="{{$signature}}"  >
                                                                     <!--<input name="test"          type="hidden"  value="0" >-->
                                                                     <input name="buyerEmail"    type="hidden"  value="{{ $member_info->email }}" >
                                                                     <input name="lng" 		  type="hidden"  value="es"/>
                                                                     <input name="telephone"     type="hidden"  value="{{ $member_info->phone }}"/>
                                                                     <input name="buyerFullName" type="hidden"  value="{{ $member_info->name." ".$member_info->lastname }}"/>
                                                                     <input name="responseUrl"    type="hidden"  value="{{ env('APP_URL')}}/secure/methods/payu/back" >
                                                                     <input name="confirmationUrl"    type="hidden"  value="{{ env('APP_URL')}}/confirmation.php" >
                                                                     <input name="Submit" class="btn-leemon-back button-payment"        type="submit"  value="" style=" background-color:transparent; background-image: url({{env('APP_URL')}}/img/boton_payu2.jpg); border:none; cursor:pointer; margin-top:0px;
                                                                       margin-botton:0px; !important; clear:0px;" >
                                                               </form>
                                                               
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
                        {{--  --}}
                        <div id="cart_3"  class="card col-md-12 card-rounded mb-3" style="background-color: #d2fcd0">
                            
                            <div class="row">
                                <div class="card-body card-round-header card-round-footer text-center">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            
                                            
                                                @if ($delivery_cost == "free")
                                                    Felicidades has obtenido <br><h2><span class="font-black">Envío Gratis</span></h2> Valor de compra ${{ number_format($supertotal,0) }} pesos.
                                                @elseif ($delivery_cost == "freeVoucher")
                                                    COP $ {{ number_format(150000 -$supertotal,0) }}
                                                @else    
                                                    @if (session('tcc'))
                                                    <span class="font-black">Envíos gratis</span> a nivel nacional por compras desde $150.000 pesos (COP).
                                                    <h2 class="mt-2">Te faltan solo $<span class="font-black">
                                                       
                                                        @if (!empty(session('tcc')->consultarliquidacion2Result))
                                                            {{ number_format(150000 - ($supertotal - session('tcc')->consultarliquidacion2Result->total->totaldespacho),0) }}</span> pesos.</h2>
                                                        @else
                                                        {{ number_format(150000 - ($supertotal - session('tcc')),0) }}</span> pesos.</h2>
                                                        @endif
                                                    @endif
                                                @endif
                                            
                                             
                                            <a href="{{ url('/') }}" class="btn btn-leemon-back">
                                                Seguir Comprando
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  --}}
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
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                            <div class="col-9 col-md-9">
                                                <div class="row">
                                                    Cantidad de articulos:
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3">
                                                <div class="row float-right">
                                                    {{ $q_prod }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                            <div class="col-6 col-md-8">
                                                <div class="row">
                                                    Subtotal:
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="row float-right">
                                                    @if ($delivery_cost == "free")
                                                         $ {{ number_format($supertotal,0) }}
                                                    @elseif ($delivery_cost == "freeVoucher")
                                                         $ {{ number_format($supertotal,0) }}
                                                    @else    
                                                        @if (session('tcc'))
                                                        
                                                             
                                                             @if (!empty(session('tcc')->consultarliquidacion2Result))
                                                                $ {{ number_format($supertotal - session('tcc')->consultarliquidacion2Result->total->totaldespacho,0) }}
                                                            @else
                                                                $ {{ number_format($supertotal - session('tcc'),0) }}
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                            <div class="col-9 col-md-9">
                                                <div class="row">
                                                    Descuento:
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3">
                                                <div class="row float-right">
                                                    <span class="text-danger">-0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                            <div class="col-4 col-md-4">
                                                <div class="row">
                                                    Envío:
                                                </div>
                                            </div>
                                            <div class="col-8 col-md-8 text-right">
                                                <div class="row float-right">
                                                    @if ($delivery_cost == "free")
                                                        COP$ (Envío Gratis)
                                                    @elseif ($delivery_cost == "freeVoucher")
                                                        @if (session('voucher'))
                                                            (Envío Gratis por Uso de Voucher No {{session('voucher')['voucher_id']}})
                                                        @endif
                                                    @else 
                                                        @if (session('tcc'))
                                                            
                                                            @if (!empty(session('tcc')->consultarliquidacion2Result))
                                                            {{ number_format(session('tcc')->consultarliquidacion2Result->total->totaldespacho,0) }}
                                                            @else
                                                            {{ number_format(session('tcc'),0) }}
                                                            @endif
                                                        @endif
                                                    @endif  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-8 col-md-8">
                                                <div class="row">
                                                    
                                                    Total:
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-4">
                                                <div class="row float-right">
                                                    @if ($delivery_cost == "free")
                                                        COP$ {{ number_format($supertotal,0) }}
                                                    @elseif ($delivery_cost == "freeVoucher")
                                                        COP$ {{ number_format($supertotal,0) }}
                                                    @else    
                                                        @if (session('tcc'))
                                                            COP$ {{ number_format($supertotal,0) }}
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ $total + $delivery }} --}}
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                    
                                            <div class="text-center col-md-12">
                                                @guest
                                                    <a class="btn btn-leemon-green btn-block" href="{{ url('/login') }}">Iniciar Sesión</a>
                                                    <span class="title-tam3">¿Eres nuevo en Leemon? </span><a class="title-tam2" href="{{ route('register') }}">{{ __('Unete aquí.') }}</a>
                                                @else
                                                    @if ($answer == 0)
                                                        <a href="{{ url('purchase') }}" class="btn btn-leemon-info btn-block">Información de Usuario</a>
                                                    @elseif ($answer == 1)
                                                    {{-- <button id="proccess2" class="btn btn-purchase btn-sm btn-block">Proceder con el Pago</button> 
                                                    <a href="{{ route('paymentnow') }}" class="btn btn-purchase btn-block">Proceder con el Pago</a>--}}
                                                    <form method="post" action="{{env('PAY_URL')}}">
                                                        <input name="merchantId"    type="hidden"  value="{{ env('MERCHANT') }}"   >
                                                        <input name="accountId"     type="hidden"  value="{{ env('ACCOUNT') }}" >
                                                        <input name="description"   type="hidden"  value="Pay-U: Compra de Productos Naturales"  >
                                                        <input name="referenceCode" type="hidden"  value="100498-{{$orderId}}" >
                                                        <input name="amount"        type="hidden"  value="{{$supertotal}}"   >
                                                        <input name="tax"           type="hidden"  value="0"  >
                                                        <input name="taxReturnBase" type="hidden"  value="0" >
                                                        <input name="currency"      type="hidden"  value="COP" >
                                                        <input name="signature"     type="hidden"  value="{{$signature}}"  >
                                                        <!--<input name="test"          type="hidden"  value="0" >-->
                                                        <input name="buyerEmail"    type="hidden"  value="{{ $member_info->email }}" >
                                                        <input name="lng" 		  type="hidden"  value="es"/>
                                                        <input name="telephone"     type="hidden"  value="{{ $member_info->phone }}"/>
                                                        <input name="buyerFullName" type="hidden"  value="{{ $member_info->name." ".$member_info->lastname }}"/>
                                                        <input name="responseUrl"    type="hidden"  value="{{ env('APP_URL')}}/secure/methods/payu/back" >
                                                        <input name="confirmationUrl"    type="hidden"  value="{{ env('APP_URL')}}/confirmation.php" >
                                                        <input name="Submit" class="btn-leemon-back button-payment"        type="submit"  value="" style=" background-color:transparent; background-image: url({{env('APP_URL')}}/img/boton_payu2.jpg); border:none; cursor:pointer; margin-top:0px;
                                                        margin-botton:0px; !important; clear:0px;" >
                                                   </form>
                                                   
                                                    
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

<script src="https://www.google.com/recaptcha/api.js?render={{ env('RE_KEY') }}"></script>
<script>
    grecaptcha.ready(function() {
    grecaptcha.execute('{{ env('RE_KEY') }}')    .then(function(token) {
    document.getElementById("recaptcha_token").value = token;
    }); 
    });
</script>
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

        $("#sendcode").click(function () {

            var token = '{{ csrf_token() }}';
            var voucherF = $("#voucher").val();
            
            $.ajax({
                type:'POST',
                dataType:'json',
                data: { voucher: voucherF, recaptcha_token: $("#recaptcha_token").val()},
                url:'secure/methods/verify/voucher',
                headers: {'X-CSRF-TOKEN': token},
                beforeSend: function(x){
                    $('#loading_web2').show();
                },
                success:function(data){
                    if(data.status==200){
                        window.location.reload();
                    }else{ 
                        $('#loading_web2').hide(); 
                        $('#vouchermessage').text(data.message);
                        $('#vouchermessage').show();
                    }  
                }
            });
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