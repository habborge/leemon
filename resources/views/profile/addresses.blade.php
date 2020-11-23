@extends('layouts.app')

@section('content')
<div id="main" class=" clearfix">
    <div class="container no-padding-sm-xs dataPosition2 py-5">
        <div class="row">
            <div class="col-md-12">
              <h3>Mis Direcciones de Entrega</h3>
            </div>
          </div>
        <div class="row ">
            <div id="primary2" class=" col-md-9 col-sm-12 col-xs-12 pull-left no-padding-md no-padding-lg no-padding-sm-xs">
                <div class="primary-content2">
                    <div class="row">
                        
                                        @foreach($addresses as $address)
                                        <div class="col-md-4 mb-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row p-right">
                                                        <div class="card bg-light col-md-12 h-card-address">
                                                            <div class="row">
                                                                @if ($address->default == 1)
                                                                    <div class="card-header  col-md-12"><span class="info-small"><b>Dirección Predeterminada</b></span></div>
                                                                @endif
                                                                    <div class="card-body  col-md-12">
                                                                        <span class="info-small"><b>{{ ucwords($address->contact) }}</b> <br>
                                                                            {{ str_replace("~", " ", $address->address) }}<br>
                                                                            {{ $address->details }}<br>
                                                                            {{ ucwords($address->city) }}, {{ ucwords($address->dpt) }} {{ $address->zipcode }}<br>
                                                                            {{ ucwords($address->country) }}<br>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-12 p-bottom">
                                                                        <span class="info-small">
                                                                            <a href="/addresses/{{$address->id }}/edit">Editar</a> | <a href="/addresses/{{$address->id }}/">Eliminar</a>
                                                                            @if ($address->default == 0)
                                                                                | <a href="/addresses/{{$address->id }}/">Predeterminar</a>
                                                                            @endif
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
                                    <a class="btn btn-success btn-block" href="/addresses/create">Adicionar Dirección</a>
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
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>
@endsection