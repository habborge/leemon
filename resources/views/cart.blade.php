@extends('layouts.app')

@section('content')
<div id="main" class="tabs clearfix body-cart">
    <div class="container no-padding-sm-xs dataPosition2">
        <div class="row ">
            <div id="primary2" class=" col-md-9 col-sm-12 col-xs-12 pull-left no-padding-md no-padding-lg no-padding-sm-xs">
                <div class="primary-content2">
                    <div class="row">

                         @if ($answer == 1)
                            <div id="cart_1"  class="col-md-12">
                                <div class="row">
                                    <div class="card col-md-12 bg-light mb-3 card-rounded">
                                        <div class="card-header row card-round-header"><b>Dirección de Envio</b></div>
                                        <div class="card-body card-body-yellow row card-round-footer">
                                            <div class="col-md-12">
                                                @if($errors->any())
                                                    <div class="row">   
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="alert alert-danger col-12" role="alert">
                                                                    {{$errors->first()}}<br>
                                                                    Por favor verifique o cambie el municipio de destino<br>
                                                                    O intente mas tarde la disponibilidad del destino. 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            
                                                            <p>
                                                                <b>{{ ucwords($address[0]->contact) }}</b><br>
                                                                @php
                                                                    $my_address = str_replace("~", " ", $address[0]->address)
                                                                @endphp
                                                                <span class="info-small">
                                                                    {{ $my_address }}, {{ $address[0]->zipcode }} Código Postal<br>
                                                                    @if ($address[0]->details) {{ ucwords($address[0]->details) }}<br> @endif
                                                                    {{ ucwords($address[0]->city_d_id) }} ({{ ucwords($address[0]->department) }}), {{ ucwords($address[0]->country_master_name) }}
                                                                </span>
                                                                <br><a class="btn btn-leemon-back mt-2" data-toggle="modal" id="changeAddress">Cambiar Dirección</a>
                                                            </p>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        @endif
                        {{--  --}}
                        <div id="cart_2" class="card col-md-12 card-rounded">
                            <div class="row">
                                <div class="card-header col-md-12 card-round-header">
                                    <div class="row">
                                        <div class="col-md-8 ">
                                            <b>Articulos</b>
                                        </div>
                                        <div id="purchase-details" class="col-md-4 text-center">
                                            <b>Precio</b>
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
                                                }
                                                
                                                
                                                ?>
                    
                                                <div class="col-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-12 col-md-8 line-right-cart py-3" data-th="Product">
                                                            <div class="row">
                                                                <div class="col-4 col-sm-4 hidden-xs">
                                                                    <div class="row text-center">
                                                                        <img src="{{ $details['photo'] }}"  class="img-purchase img-responsive mx-auto d-block"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-8 col-sm-8 mt-3">
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
                                                                                       <small><b>$ {{ number_format($details['price'],0) }} COP</b></small>
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
                                                                                                <input class="form-control update-cart" aria-label="Small" aria-describedby="inputGroup-sizing-sm"  data-id="{{ $id }}"  id="Quantity_{{$id}}" type="number" value="{{ $details['quantity'] }}" max="{{ $details['maxqua'] }}">
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
                                                                                            <button class="btn btn-leemon-delete btn-sm remove-from-cart" data-id="{{ $id }}"><img src="/img/x.png" alt="" width="25px"></button>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="subtotal" data-th="Subtotal" class="col-4 col-md-4 text-right  py-3">
                                                            <div class="col-md-12 mt-3">
                                                                <span class="nomargin">
                                                                   <b> $ {{ number_format($details['price'] * $nq,0)}}</b>
                                                                </span> <br>
                                                                @if ($half > 0)
                                                                    <span class="text-danger">Descuento $ {{ number_format($half,0) }}</span><br>
                                                                @elseif ($discount > 0)
                                                                    <span class="text-danger">Descuento $ {{ number_format($discount,0) }}</span><br>
                                                                @else
                                                                    
                                                                @endif
                                                                    <small>A pagar $ {{ number_format(($details['price'] * $nq) - $half - $discount,0) }}</small>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <div class="col-md-12">
                                                        
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="visible-xs">
                                                
                                                <div class="col-12 col-md-12 mt-4">
                                                    <div class="row">
                                                        <div class="card-title col-md-12 text-center">
                                                            <div class="row justify-content-md-center">
                                                                <div class="col-12 col-md-4 bg-title-cart">
                                                                    <div class="mt-2 mb-2"><b>Subtotal Compra</b></div>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        
                                                        <div class="card-body info-small card-body-yellow">
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
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-7 col-md-7">
                                                                        <div class="row">
                                                                            Subtotal:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-5 col-md-5">
                                                                        <div class="row float-right">
                                                                            COP$ {{ number_format($subTotal,0) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-9 col-md-9">
                                                                        <div class="row">
                                                                            Descuento:
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 col-md-3">
                                                                        <div class="row float-right">
                                                                            <span class="text-danger">-{{ number_format($total_d, 0) }}</span>
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
                                                                            --
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="col-12 col-md-12">
                                                                <div class="row">
                                                                    <div class="col-8 col-md-8">
                                                                        <div class="row">
                                                                            <b>Total:</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4 col-md-4">
                                                                        <div class="row float-right">
                                                                           <b>COP$ --</b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- {{ $total + $delivery }} --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                            
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mt-4">
                                        <div class="row">
                                            <div id="firstbutton" class="col-12 col-md-6">
                                                <a href="{{ url('/') }}" class="btn btn-leemon-back">
                                                    Seguir Comprando
                                                </a>
                                            </div>
                                            
                                            <!--<div class="hidden-xs text-right"><strong>Total $ {{ $total }}</strong></div>-->
                                            <div id="secondbutton" class="col-12 col-md-6 text-right">
                                                @guest
                                                    {{-- <a class="btn btn-leemon-green" href="{{ route('login') }}">Ir a Pagar</a><br> --}}
                                                    <a id="pagar" class="btn btn-leemon-green btn-width">Ir a Pagar</a>
                                                    {{-- <span class="title-tam3">¿Eres nuevo en Leemon? </span><a class="title-tam2" href="{{ route('register') }}">{{ __('Unete aquí.') }}</a> --}}
                                                @else
                                                    @if ($answer == 0)
                                                        <a href="{{ url('purchase') }}" class="btn btn-leemon-info btn-width">Datos de Envío</a>
                                                    @elseif ($answer == 1)
                                                        <a href="{{ url('methods') }}" class="btn btn-leemon-method btn-width">Resumen de Compra</a>
                                                    @endif
                                                @endguest
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
                                            @if ($subTotal >= 150000)
                                                Felicidades has obtenido <br><h2><span class="font-black">Envío Gratis</span></h2> Valor de compra ${{ number_format($subTotal,0) }} pesos.
                                            @else
                                                <span class="font-black">Envíos gratis</span> a nivel nacional por compras desde $150.000 pesos (COP).
                                                <h2 class="mt-2">Te faltan solo $<span class="font-black">{{ number_format(150000 - $subTotal,0) }}</span> pesos.</h2>  
                                                
                                            @endif
                                            <a href="{{ url('/') }}" class="btn btn-leemon-back">Seguir Comprando</a>
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
                                            <div class="col-7 col-md-7">
                                                <div class="row">
                                                    Subtotal:
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-5">
                                                <div class="row float-right">
                                                    COP$ {{ number_format($subTotal, 0) }}
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
                                                    <span class="text-danger">-{{ number_format($total_d, 0) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-8 col-md-8">
                                                <div class="row">
                                                    Envío:
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-4">
                                                <div class="row float-right">
                                                    --
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-8 col-md-8">
                                                <div class="row">
                                                    
                                                    Total:
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-4">
                                                <div class="row float-right">
                                                    COP$ --
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ $total + $delivery }} --}}
                                    <div class="col-md-12">
                                    <div class="row">
                                
                                        <div class="text-center col-md-12">
                                            @guest
                                                {{-- <a class="btn btn-leemon-green btn-block" href="{{ url('/login') }}">Ir a Pagar</a> --}}
                                                <a id="pagar2" class="btn btn-leemon-green btn-block">Ir a Pagar</a>
                                                {{-- <span class="title-tam3">¿Eres nuevo en Leemon? </span><a class="title-tam2" href="{{ route('register') }}">{{ __('Unete aquí.') }}</a> --}}
                                            @else
                                                @if ($answer == 0)
                                                    <a href="{{ url('purchase') }}" class="btn btn-leemon-info btn-block">Datos de Envío</a>
                                                @elseif ($answer == 1)
                                                    <a href="{{ url('methods') }}" class="btn btn-leemon-method btn-block">Resumen de Compra</a>
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
</div>
@include('modal.my_address')
@endsection
@section('custom-js')
@include('layouts.analityc')
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
            Swal.fire({
                title: 'Seguro quieres eliminar el articulo del carrito?',
                text: "No podras revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6CC4F6',
                cancelButtonColor: '#403d38',
                confirmButtonText: 'Sí, Borrar del carrito',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                $.ajax({
                    url: "{{ env('APP_URL')}}/remove-from-cart",
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
            })
            // if(confirm("Are you sure")) {
                
            // }
        });

        $(document).on('click', '#changeAddress', function () {
      
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/addresses/list',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function(x){
                $('#loading_web').show();
                },
                success:function(data){
                if(data.status==200){
                    showdata(data);
                    $('#loading_web').hide(); 
                    $('#selectionaddress').modal('show');
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

        $('#pagar').click(function () {
            confirmation();
        });
        $('#pagar2').click(function () {
            confirmation();
        });
        
    });
    function confirmation(){
        Swal.fire({
            title: 'Eres Usuario Registrado?',
            showDenyButton: true,
            showCancelButton: true,
            cancelButtonText: `Cancelar`,
            confirmButtonText: `Sí, Inicia Sesión`,
            confirmButtonColor: '#4da042',
            denyButtonText: `No, Registrate`,
            denyButtonColor: '#E39281',
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $(location).attr('href', "{{ url('/login') }}")
            } else if (result.isDenied) {
                $(location).attr('href', "{{ url('/register') }}")
            }
            })
    }
</script>
@endsection
