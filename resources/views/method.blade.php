@extends('layouts.app')

@section('content')

<div id="main" class="tabs clearfix">
    <div class="container no-padding-sm-xs dataPosition2">
        <div class="row ">
            <div id="primary2" class=" col-md-9 col-sm-12 col-xs-12 pull-left no-padding-md no-padding-lg no-padding-sm-xs">
                <div class="primary-content2">
                    <div class="row">
                        @if ($answer == 1)
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="accordion accord-width" id="accordionExample">
                                        
                                            <div class="card col-md-12 bg-light mb-3">
                                                <div class="card-header row" id="headingOne">
                                                  
                                                    <a class="text-left a-size-methods" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                          Dirección de Envio
                                                    </a>
                                                  
                                                </div>
                                            
                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <h6>{{ ucwords($address[0]->contact) }}</h6>
                                                        <p class="info-small">
                                                            @php
                                                                $my_address = str_replace("~", " ", $address[0]->address)
                                                            @endphp
                                                            {{ $my_address }}, {{ $address[0]->zipcode }} Código Postal<br>
                                                            {{ ucwords($address[0]->details) }}<br>
                                                            {{ ucwords($address[0]->city_d_id) }} ({{ ucwords($address[0]->department) }}), {{ ucwords($address[0]->country_master_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="card col-md-12 bg-light mb-3">
                                        <div class="card-header row">Metodo de Pago</div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <input class="form-check-input" type="radio" name="methodPay" id="TC" value="1" checked>
                                                                <label class="form-check-label" for="TC">
                                                                    Tarjeta de Credito
                                                                    @if ($cardexist == 2)
                                                                        terminada en ************{{ $card[0]->last4num }}
                                                                    @else
                                                                        <a href="/secure/methods/create" id="creditcard" class="btn btn-dark btn-sm" type='button'>Agregar una Tarjeta</a>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row float-right">
                                                                @if ($cardexist == 2)
                                                                    <button class="btn btn-dark btn-sm" data-toggle="modal" id="changeCard">Cambiar Tarjeta</button>
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
                                                PSE
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
                        @endif

                        <div class="card col-md-12 ">
                            <div class="row">
                                <div class="card-header col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            Articulos
                                        </div>
                                        <div id="purchase-details" class="col-md-4">
                                            Precio
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body">
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
                                                            <div class="col-md-12">
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
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="visible-xs">
                                                
                                                
                                                <div class="col-12 col-md-12">
                                                    <hr>
                                                </div>
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
                                                
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="card-title col-md-12">
                                                            Subtotal Compra
                                                            <hr>
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
                                                                            COP$ {{ number_format($subTotal,0) }}
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
                                                                    <div class="col-md-9">
                                                                        <div class="row">
                                                                            Antes de Impuestos:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="row float-right">
                                                                            {{ number_format($beforeFee) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <div class="row">
                                                                            Impuestos:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="row float-right">
                                                                            {{ number_format($fee) }}
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
                                                                            {{ number_format(0,0) }}
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
                                                                            COP$ {{ number_format($total,0) }}
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
                                                                <button id="proccess" class="btn btn-success btn-sm">Proceder con el Pago</button>
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
                                            <div class="col-md-9">
                                                <div class="row">
                                                    Antes de Impuestos:
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row float-right">
                                                    {{ number_format($beforeFee) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    Impuestos:
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row float-right">
                                                    {{ number_format($fee) }}
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
                                                    {{ number_format(0,0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    
                                                    Total:
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row float-right">
                                                    COP$ {{ number_format($total,0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ $total + $delivery }} --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-footer col-md-12">
                                    @guest
                                        <a class="btn btn-leemon-warning btn-block" href="{{ url('/login') }}">Iniciar Sesión</a>
                                    @else
                                        @if ($answer == 0)
                                            <a href="{{ url('purchase') }}" class="btn btn-leemon-method btn-block">Información de Facturación</a>
                                        @elseif ($answer == 1)
                                            <a href="{{ url('methods') }}" class="btn btn-success btn-block">Proceder con el Pago</a>
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
            var methodPay = $('input:radio[name=methodPay]:checked').val()   

            $.ajax({
                type:'POST',
                dataType:'json',
                data: {_token: '{{ csrf_token() }}', methodPay: methodPay},
                url:'secure/methods/paynow',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function(x){
                    $('#loading_web').show();
                },
                success:function(data){
                if(data.status==200){
                    
                    $('#loading_web').hide(); 
                    //$('#selectioncard').modal('show');
                    window.open(data.url, '_blank');
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
    });
</script>
@endsection