@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="alert @if ($approval == 1) alert-success @else alert-danger @endif card-rounded" role="alert" style="width: 100%">
                    <h4 class="alert-heading">@if ($approval == 1) ¡Transacción Aprobada Con Voucher GiveAway!  @else Atención @endif</h4>
                    <p>{{ $message }}</p>
                    @if ($approval == 1)
                        <p>Leemon le ha enviado un correo electronico. Por favor revisar la bandeja de entrada o la bandeja de correo no deseado</p>
                    @endif
                    <hr>
                    <p class="mb-0">
                        <a href="{{ url('/') }}" class="btn btn-leemon-back">
                            Continuar Navegando
                        </a>
                    </p>
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