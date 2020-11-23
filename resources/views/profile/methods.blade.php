@extends('layouts.app')

@section('content')
<div id="main" class=" clearfix">
    <div class="container no-padding-sm-xs dataPosition2 py-5">
        <div class="row">
            <div class="col-md-12">
              <h3>Mis Tarjetas de Credito</h3>
            </div>
          </div>
        <div class="row ">
            <div id="primary2" class=" col-md-9 col-sm-12 col-xs-12 pull-left no-padding-md no-padding-lg no-padding-sm-xs">
                <div class="primary-content2">
                    <div class="row">
                        @foreach($cards as $card)
                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row p-right">
                                            <div id="accordion" style="width: 100%">
                                                <div class="card bg-light col-md-12">
                                                    <div class="row">
                                                        
                                                            <div class="card-header  col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-8 card-father">
                                                                        <div class="float-left">
                                                                            <span class="info-small"><b>{{ ucwords($card->brand) }} No *************{{ ucwords($card->last4num) }}</b></span>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <div class="col-md-9 card-father">
                                                                                        <div class="float-right">
                                                                                            <span class="align-middle info-small"><b>Caduca en:</b> {{ ucwords($card->expiration) }}</span>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="float-right">
                                                                                        <button class="btn btn-link info-small" data-toggle="collapse" data-target="#collapse_{{ $card->id }}" aria-expanded="true" aria-controls="collapseOne"><b>Ver Más</b></button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div id="collapse_{{ $card->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                <div class="card-body h-card-credit">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <span class="info-small">
                                                                                <b>Nombre de la Tarjeta</b> <br>
                                                                                {{ ucwords($card->fullname) }}
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-12 p-bottom">
                                                                            <span class="info-small">
                                                                                <a href="/secure/methods/{{$card->id }}/edit">Editar</a> | <a href="/secure/methods/{{$card->id }}/">Eliminar</a>
                                                                                @if ($card->default == 0)
                                                                                    | <a href="/secure/methods/default/{{$card->id }}/">Predeterminar</a>
                                                                                @endif
                                                                            </span>
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