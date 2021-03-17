@extends('layouts.app')

@section('content')
<div id="main" class="clearfix">
    <div class="container no-padding-sm-xs dataPosition2 py-5">
        <div class="col-12 col-md-12">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="row">
                        <div class="col-12 no-padding">
                            <h3>Mis Ordenes</h3>
                            <hr>
                        </div>
                        
                    </div>
                </div>
                <div id="primary2" class="col-12 col-md-9 col-sm-12 col-xs-12 pull-left no-padding-md no-padding-lg no-padding-sm-xs">
                    <div class="primary-content2">
                        <div class="row">
                            
                            @foreach($orders as $order)
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row p-right">
                                                <div class="card bg-light col-md-12">
                                                    <div class="row">
                                                        
                                                            <div class="col-12 card-body  col-md-12">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-8">
                                                                        
                                                                            <span class="info-small">
                                                                                Orden No: {{ $order->id }} - {{ $order->code_hash }} <br>
                                                                                
                                                                            </span>
                                                                        
                                                                    </div>
                                                                    <div class="col-12 col-md-4 text-right">
                                                                        
                                                                            <span class="info-small">
                                                                                Estado de la Orden: {{ $order->status }}<br>
                                                                                Estado de Entrega: En {{ $order->status_after_approved }}</span>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-8">
                                                                        
                                                                            <span class="info-small">
                                                                                Fecha de Compra: {{ $order->created_at }}<br>
                                                                                Metodo: {{ $order->payment }}<br>
                                                                                @php
                                                                                    $address = explode(",", $order->delivery_address);
                                                                                @endphp 
                                                                                {{ $address[0] }}, {{ $order->city }} ({{ $order->dpt}})<br>
                                                                                {{ $address[1]}}<br>
                                                                                {{ $address[2]}}<br>
                                                                                
                                                                            </span>
                                                                        
                                                                    </div>
                                                                    <div class="col-12 col-md-4 text-right">
                                                                        
                                                                            <span class="info-small">
                                                                                Valor Comprado: {{ number_format($order->amount, 0) }}<br>
                                                                                Costo del Envío: {{ $order->delivery_cost }}<br>
                                                                            </span>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>   
                                                                    
                                                                    
                                                                </span>
                                                            </div>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                        
                        </div>
                    </div>
                </div>
                <div id="secondary2" class="refinements col-md-3 pull-right no-padding-md no-padding-lg hidden-xs hidden-sm">
                    <div class="primary-content2">
                        <div class="row">
                            <div class="card col-md-12">
                                <div class="row">
                                    <div class="card-header col-md-12">
                                        Opciones
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card-body">
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card-footer col-md-12">
                                        
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
        
    });
</script>
@endsection