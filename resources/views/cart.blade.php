@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        <div class="row">
            <table id="cart" class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        <th style="width:50%">Product - {{ url('update-cart') }}</th>
                        <th style="width:10%">Price</th>
                        <th style="width:8%">Quantity</th>
                        <th style="width:22%" class="text-right">Subtotal</th>
                        <th style="width:10%"></th>
                    </tr>
                    </thead>
                    <tbody>
            
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
            
                            <tr>
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                                        <div class="col-sm-9">
                                        <h4 class="nomargin">{{ $details['name'] }}
                                            @if ($details['prom'] == 1) 
                                            <br><span class="badge badge-warning">Paga 2 Lleva 3</span>
                                        @elseif ($details['prom'] == 2)
                                            <br><span class="badge badge-danger">2nd 50% off</span>
                                        @endif
                                        </h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">${{ number_format($details['price'],0) }}</td>
                                <td data-th="Quantity">
                                    <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                                    @if ($discount > 0)
                                        <span class="info-small">Free: {{ $whole }}</span> 
                                    @endif
                                </td>
                                <td data-th="Subtotal" class="text-right">$ {{ number_format($details['price'] * $nq,0)}}
                                    @if ($half > 0)
                                        <br> <span class="text-danger">Descuento $ {{ number_format($half,0) }}</span>
                                    @elseif ($discount > 0)
                                        <br> <span class="text-danger">Descuento $ {{ number_format($discount,0) }}</span>
                                    @else
                                    @endif
                                        <br>A pagar $ {{ number_format(($details['price'] * $nq) - $half - $discount,0) }}
                                </td>
                                <td class="actions" data-th="">
                                    <button id="" class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                                    <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
            
                    </tbody>
                    <tfoot>
                        <tr class="visible-xs">
                            <td>
                                @if ($answer == 1)
                                    <h6><b>Información de Envio</b></h6>
                                    <span class="info-small"><b>Dirección de Envio:</b> {{ $member_info[0]->delivery_address }}<br>
                                    <b>Cliente:</b> {{ $member_info[0]->firstname }} {{ $member_info[0]->lastname }}<br>
                                    <b>Email:</b> {{ $member_info[0]->email }}<br>
                                    <b>No de ID:</b> {{ $member_info[0]->n_doc }}<br></span>
                                    
                                @endif
                            </td>
                            <td colspan="2" class="hidden-xs">
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
                            </td>
                            <td class="text-right">
                                SubTotal $ {{ $total }}<br>
                                @if ($answer == 1)
                                    Costo de Entrega $ {{ $delivery }}<br>
                            <b>Total a Pagar $ {{ $total + $delivery }}</b>
                                @endif    
                            
                            </td>
                        </tr>
                        
                    
                        <tr>
                            <td><a href="{{ url('/') }}" class="btn btn-primary"><i class="fa fa-angle-left"></i> Continua de Compras</a></td>
                            <td colspan="2" class="hidden-xs"></td>
                            <!--<td class="hidden-xs text-right"><strong>Total $ {{ $total }}</strong></td>-->
                            <td class="text-right">
                                @guest
                                    <a class="btn btn-warning" href="{{ route('login') }}">Iniciar Sesión</a>
                                @else
                                    @if ($answer == 0)
                                        <a href="{{ url('purchase') }}" class="btn btn-primary">Adicionar Metodo de Pago</a>
                                    @elseif ($answer == 1)
                                        <a href="{{ url('confirm') }}" class="btn btn-primary">Confirmar Pago</a>
                                    @endif
                                @endguest
                            </td>
                                
                        </tr>
                    </tfoot>
                </table>
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

            $.ajax({
                url: "{{ env('APP_URL')}}/update-cart",
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
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
                    url: "{{ url('remove-from-cart') }}",
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